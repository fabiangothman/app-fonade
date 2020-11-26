<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class url_solver
	{
		private $url;		// URL original
		private $path;	// Path al controlador correspondiente
		private $args;	// Argumentos pasados por el URL
		private $object_name;	// Nombre del objeto en caso de existir
		private $type;	// Atributo para saber si la URL se carga en modal, iframe u otro
		
		public function __construct($estado_sesion)
		{
			$this->url = str_replace("\\","/",$_SERVER['QUERY_STRING']);
			$this->url = str_replace("[]","/",$this->url);
			$internal_url = $this->url;
			
			$find_Str = "_route_=";
			$pos = strrpos($internal_url, $find_Str);
			$second_str = substr($internal_url, $pos+strlen($find_Str));
			$this->type = (strrpos($internal_url, "[modal]")>-1)?"_modal":((strrpos($internal_url, "[iframe]")>-1)?"_iframe":"");
			if($this->type!="")
			{
				$txtType = ($this->type=="_modal")?"[modal]":"[iframe]";
				$second_str = str_replace($txtType, "", $second_str);
				$second_str = str_replace(_MSFW_PATH_, "", $second_str);
				$second_str = str_replace(_CONTROLLER_PATH_, "", $second_str);
			}
			
			$resp = array("PATH"=>_DEFAULT_CONTROLLER_,"ARGS"=>"");
			
			// Verifica el estado de la sesión
			if($estado_sesion!="open")
			{
				if($this->type=="_modal")
				{
					echo "<script>parent.$.modal.close();</script>";
					exit();
				}
								
				$tmpPath = $this->proccess_path($second_str);

				if($estado_sesion=="expired")
					$this->path = _CONTROLLER_PATH_."modules/login/login";
				else
					$this->path = (strpos($tmpPath,_CONTROLLER_PATH_."modules/login/")>-1)?$tmpPath:_CONTROLLER_PATH_."modules/login/login";
				
				if ($pos !== false && trim($second_str) != "" && trim($second_str) != "index.php")
				{
					$resp["PATH"] = $this->proccess_path($second_str);
					$resp["ARGS"] = substr(_CONTROLLER_PATH_.$second_str,strlen($resp["PATH"]));
					$complemento = (strpos($resp["PATH"],".php"))?"":".php";
					$resp["PATH"] = (is_file($resp["PATH"].$complemento))?$resp["PATH"]:_DEFAULT_CONTROLLER_;
				}
				
				$this->args = $this->proccess_args($resp["ARGS"]);
				$this->object_name = $this->_getObjectName($this->path);
				return;
			}
			
			if ($pos !== false && trim($second_str) != "" && trim($second_str) != "index.php")
			{
				$resp["PATH"] = $this->proccess_path($second_str);
				$resp["ARGS"] = substr(_CONTROLLER_PATH_.$second_str,strlen($resp["PATH"]));
				$complemento = (strpos($resp["PATH"],".php"))?"":".php";
				$resp["PATH"] = (is_file($resp["PATH"].$complemento))?$resp["PATH"]:_DEFAULT_CONTROLLER_;
			}
			$this->path = $resp["PATH"];
			$this->args = $this->proccess_args($resp["ARGS"]);
			$this->object_name = $this->_getObjectName($this->path);
  	}
		
		private function proccess_path($p_path)
		{
			$p_path = $this->removeLastChar($p_path,"/");
			$arrayRoute = explode("/",$p_path);
			$tmpPath = _CONTROLLER_PATH_;
			foreach($arrayRoute as $unaRuta)
			{
				$complemento = (strpos($tmpPath.$unaRuta,".php"))?"":".php";
				if(is_dir($tmpPath.$unaRuta))
					$tmpPath.=$unaRuta."/";
				else if(is_file($tmpPath.$unaRuta.$complemento))
					$tmpPath.=$unaRuta;
				else
					break;
			}
			$tmpPath = $this->removeLastChar($tmpPath,"/");
			$tmpPath = $this->removeLastChar($tmpPath,"/");
			return $tmpPath;
		}
		
		private function removeLastChar($p_string,$p_char)
		{
			$p_string = (substr($p_string,strlen($p_string)-1,1)==$p_char)?substr($p_string,0,strlen($p_string)-1):$p_string;
			return $p_string;
		}
		
		private function checkLastChar($p_string,$p_char)
		{
			$p_string = (substr($p_string,strlen($p_string)-1,1)==$p_char)?$p_string:$p_string.$p_char;
			return $p_string;
		}
		
		private function proccess_args($p_args)
		{
			$p_args = $this->removeLastChar($p_args,"/");
			if($p_args=="")
				return NULL;
			$arrayArgs = explode("/",$p_args);
			if($arrayArgs[0]=="")
				unset($arrayArgs[0]);
			$pKeys = array();
			$pValues = array();
			$contador = true;
			foreach ($arrayArgs as $unArrArg)
			{
				if ($contador)
					array_push($pKeys,$unArrArg);
				else
					array_push($pValues,$unArrArg);
				$contador=!$contador;
			}
			if(!$contador)
				array_push($pValues,"");
			
			$this->args = array_combine($pKeys,$pValues);
			return $this->args;
		}
		
		private function _getObjectName($p_object_name)
		{
			$tmpName = basename($p_object_name);
			$arrObjName = explode(".",$tmpName);
			return $arrObjName[0];
		}
		
		public function solveObjectName($p_object_name)
		{
			return $this->_getObjectName($p_object_name);
		}
		
		public function getObjectName()
		{
			return $this->object_name;
		}
		
		public function getURL()
		{
			return $this->url;
		}
		
		public function getPath()
		{
			return $this->path;
		}

		public function getFolderPath()
		{
			$folder = substr($this->path, 0, strripos($this->path, '/'));
			return $folder;
		}
		
		public function getArgs()
		{
			return $this->args;
		}
		
		public function getType()
		{
			return $this->type;
		}
		
		public function __isset($name)
    {
      return isset($this->args[$name]);
    }
		
		public function __set($name, $value)
    {
      $this->args[$name] = $value;
    }

    public function __get($name)
    {
			if (array_key_exists($name, $this->args)) {
					return $this->args[$name];
			}

			$trace = debug_backtrace();
			trigger_error(
					'Undefined property via __get(): ' . $name .
					' in ' . $trace[0]['file'] .
					' on line ' . $trace[0]['line'],
					E_USER_NOTICE);
			return null;
    }
	}
?>