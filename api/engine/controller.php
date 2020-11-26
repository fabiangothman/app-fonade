<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/
	
	abstract class controller
	{
		protected $main;							// Referencia al objeto main
		protected $controller;				// Referencia al objeto controller
		protected $view;							// Objeto view
		protected $models = array();	// Arreglo de objetos model
		protected $subControllers = array(); // Arreglo de objetos subController
		protected $data = array();		// Arreglo disponible en el view
		protected $header_data = array("title"=>"","jQueryScripts"=>array(),"scripts"=>array(),"links"=>array(),"styles"=>array(),"in_scripts"=>array(),"in_readyCodes"=>array(),"migaPan"=>array());
				
		public function __construct(&$p_main, &$p_controller = NULL)
		{
			$this->main = $p_main;
			$this->controller = $p_controller;
			$this->index();
  	}
		
		protected abstract function index();
		protected abstract function render();
		
		protected function printView($file)
		{
			$the_file = _THEME_PATH_."template/".$file;	// Intenta con el tema actual
			$the_file2 = _DEFAULT_VIEW_PATH_."template/".$file;	// De no encontrar el template deseado, lo busca en el tema default
			$complemento = (strpos($the_file,".tpl"))?"":".tpl";
			$file = (is_file($the_file.$complemento))?$the_file:((is_file($the_file2.$complemento))?$the_file2:"");
			if($file!="")
			{
				$this->view = new view($this, $file.$complemento);
				return $this->view->getOutput();
			}
			
			$trace = debug_backtrace();
			trigger_error(
					'Se intentó cargar la vista no existente por printView: ' . $file .
					' en ' . $trace[0]['file'] .
					' en la línea ' . $trace[0]['line'],
					E_USER_NOTICE);
					
			$this->view = NULL;
			return "";
		}
	
  	/**
   	* Carga un modelo o su definición
		* @param string $file archivo del modelo y su ruta, relativa a app/model/
		* @param bool $p_autoCreate si es true, crea el modelo en 
		* $this->models['nombre_del_modelo']. Si es false, sólo carga la definición del modelo.
		* @return boolean true en caso de éxito, false si no se encontró el modelo. 
		* Por defecto es true.
		*/
		protected function loadModel($file, $p_autoCreate = true)
		{
			$the_file = _MODEL_PATH_.$file;
			$complemento = (strpos($the_file,".php"))?"":".php";
			if(is_file($the_file.$complemento))
			{
				$model_name = $this->main->url_solver->solveObjectName($the_file);
				include_once($the_file.$complemento);
				if($p_autoCreate)
					$this->models[$model_name] = new $model_name($this);
				return true;
			}
			$trace = debug_backtrace();
			trigger_error(
					'Se intentó cargar el modelo no existente por loadModel: ' . $file .
					' en ' . $trace[0]['file'] .
					' en la línea ' . $trace[0]['line'],
					E_USER_NOTICE);
			return false;
		}
		
		protected function loadLibrary($file)
		{
			$the_file = _LIB_PATH_.$file;
			$complemento = (strpos($the_file,".php"))?"":".php";
			if(is_file($the_file.$complemento))
			{
				include_once($the_file.$complemento);
				return true;
			}
			$trace = debug_backtrace();
			trigger_error(
					'Se intentó cargar la librería no existente por loadLibrary: ' . $file .
					' en ' . $trace[0]['file'] .
					' en la línea ' . $trace[0]['line'],
					E_USER_NOTICE);
			return false;
		}
		
		protected function loadSubController($file)
		{
			$the_file = _CONTROLLER_PATH_.$file;
			$complemento = (strpos($the_file,".php"))?"":".php";
			if(is_file($the_file.$complemento))
			{
				include_once ($the_file.$complemento);
				$subController_name = $this->main->url_solver->solveObjectName($file);
				$this->subControllers[$subController_name] = new $subController_name($this->main, $this);
				return true;
			}
			return false;
		}
		
		protected function addScript($p_local /*Bool*/, $p_src)
		{
			$complemento = "";
			if($p_local)
			{
				$the_file = _THEME_PATH_."_js/".$p_src;
				$the_file2 = _DEFAULT_VIEW_PATH_."_js/".$p_src;
				$complemento = (strpos($the_file,".js"))?"":".js";
				$p_src = (is_file($the_file.$complemento))?$the_file:((is_file($the_file2.$complemento))?$the_file2:"");
			}
			if($p_src!="")
			{
				$object = (get_class($this)=="header" || get_class($this)=="header_modal" || get_class($this)=="header_iframe")?$this:$this->main->controllers["HEADER"];
				array_push($object->data["scripts"],(($p_local)?_MSFW_PATH_:"").$p_src.$complemento);
			}
			else
			{
				$trace = debug_backtrace();
				trigger_error(
					'Se intentó cargar el script no existente por addScript: ' . $p_src .
					' en ' . $trace[0]['file'] .
					' en la línea ' . $trace[0]['line'],
					E_USER_NOTICE);
			}
		}
		
		protected function addjQueryScript($p_local /*Bool*/, $p_src, $identificador = "$")
		{
			$complemento = "";
			if($p_local)
			{
				$the_file = _THEME_PATH_."_js/".$p_src;
				$the_file2 = _DEFAULT_VIEW_PATH_."_js/".$p_src;
				$complemento = (strpos($the_file,".js"))?"":".js";
				$p_src = (is_file($the_file.$complemento))?$the_file:((is_file($the_file2.$complemento))?$the_file2:"");
			}
			if($p_src!="")
			{
				$object = (get_class($this)=="header" || get_class($this)=="header_modal" || get_class($this)=="header_iframe")?$this:$this->main->controllers["HEADER"];
				array_push($object->data["jQueryScripts"],array("src"=>(($p_local)?_MSFW_PATH_:"").$p_src.$complemento,"id"=>$identificador));
			}
			else
			{
				$trace = debug_backtrace();
				trigger_error(
					'Se intentó cargar el script no existente por addScript: ' . $p_src .
					' en ' . $trace[0]['file'] .
					' en la línea ' . $trace[0]['line'],
					E_USER_NOTICE);
			}
		}
		
		protected function addLink($p_href, $p_rel)
		{
			$object = (get_class($this)=="header" || get_class($this)=="header_modal" || get_class($this)=="header_iframe")?$this:$this->main->controllers["HEADER"];
			array_push($object->data["links"],array("href"=>$p_href,"rel"=>$p_rel));
		}
		
		protected function addStyle($p_href, $p_rel, $p_media)
		{
			$the_file = _THEME_PATH_."_css/".$p_href;
			$the_file2 = _DEFAULT_VIEW_PATH_."_css/".$p_href;
			$complemento = (strpos($the_file,".css"))?"":".css";
			$tmp_file = explode("?",$the_file);
			$tmp_file2 = explode("?",$the_file2);
			$p_href = (is_file($tmp_file[0].$complemento))?$the_file:((is_file($tmp_file2[0].$complemento))?$the_file2:"");
			if($p_href!="")
			{
				$object = (get_class($this)=="header" || get_class($this)=="header_modal" || get_class($this)=="header_iframe")?$this:$this->main->controllers["HEADER"];
				array_push($object->data["styles"],array("href"=>_MSFW_PATH_.$p_href.$complemento,"rel"=>$p_rel,"media"=>$p_media));
			}
			else
			{
				$trace = debug_backtrace();
				trigger_error(
					'Se intentó cargar la hoja de estilos no existente por addStyle: ' . $p_href .
					' en ' . $trace[0]['file'] .
					' en la línea ' . $trace[0]['line'],
					E_USER_NOTICE);
			}
		}
		
		protected function addInScript($p_inScript)
		{
			$object = (get_class($this)=="header" || get_class($this)=="header_modal" || get_class($this)=="header_iframe")?$this:$this->main->controllers["HEADER"];
			array_push($object->data["in_scripts"],$p_inScript."\n");
		}
		
		protected function addInReadyCode($p_code)
		{
			$object = (get_class($this)=="header" || get_class($this)=="header_modal" || get_class($this)=="header_iframe")?$this:$this->main->controllers["HEADER"];
			array_push($object->data["in_readyCodes"],$p_code."\n");
		}
		
		protected function setCapas($p_arrCapas)
		{
			foreach($p_arrCapas as $unaCapa)
			{
				if(!isset($this->$unaCapa))
					$this->data[$unaCapa] = array();
			}
		}
		
		public function addCapa($p_nombreCapa,$p_contCapa)
		{
			if(!isset($this->$p_nombreCapa))
			{
				$this->data[$p_nombreCapa] = array();
			}
			$this->data[$p_nombreCapa][] = $p_contCapa;
		}
		
		protected function loadClientFormValidator()
		{
			$this->addStyle("common/validation_engine/validationEngine.jquery", "stylesheet", "screen");
			$this->addScript(true, "validation_engine/languages/jquery.validationEngine-es");
			$this->addScript(true, "validation_engine/jquery.validationEngine");
		}
		
		protected function loadServerFormValidator()
		{
			$this->loadLibrary("common/formvalidator");
		}
		
		protected function setError($p_err)
		{
			$this->main->session->err = $p_err;
		}
		
		protected function getError()
		{
			if(!isset($this->main->session->err))
				return NULL;
				
			$tmpErr = $this->main->session->err;
			$this->main->session->err = "";
			return $tmpErr;
		}
		
		protected function getAllArgs()
		{
			return $this->main->url_solver->getArgs();
		}
		
		protected function getArg($p_arg)
		{
			$tmpValue = NULL;
			if(isset($this->main->url_solver->$p_arg))
				$tmpValue = $this->main->url_solver->$p_arg;
			
			return $tmpValue;
		}
		
		protected function setSessionArg($p_arg, $p_value)
		{
			$tmpArg = array();
			if(isset($this->main->session->arg))
				$tmpArg = $this->main->session->arg;
			$tmpArg[$p_arg] = $p_value;
			$this->main->session->arg = $tmpArg;
		}
		
		protected function getSessionArg($p_arg)
		{
			$tmpValue = NULL;
			if(isset($this->main->session->arg))
			{
				$tmpArg = $this->main->session->arg;
				if(array_key_exists($p_arg,$tmpArg))
				{
					$tmpValue = $tmpArg[$p_arg];
					$this->main->session->arg = $tmpArg;
				}
			}
			
			return $tmpValue;
		}
		
		protected function redirect($URL)
		{
			header("Location: ".$URL);
			exit();
		}

		protected function refresh($URL, $secs_time)
		{
			header("Refresh: ".$secs_time."; URL=".$URL);
			exit();
		}
		
		public function getData()
		{
			return $this->data;
		}
		
		protected function getFormData($_param, $assign_session = true)
		{
			if(isset($_POST[$_param]))
			{
				$this->$_param = $_POST[$_param];
				if($assign_session)
					$this->setSessionArg($_param, $this->$_param);
			}
			else
				$this->$_param = ""; 
		}
		
		protected function convertNullToEmpty($p_param)
		{
			return (is_null($p_param))?"":$p_param;
		}
		
		public function __isset($name)
    {
			$object = $this;
			if(array_key_exists($name,$this->header_data))
				$object = (get_class($this)=="header" || get_class($this)=="header_modal" || get_class($this)=="header_iframe")?$this:$this->main->controllers["HEADER"];
				
      return isset($object->data[$name]);
    }
		
		public function __set($name, $value)
    {
			$object = $this;
			if(array_key_exists($name,$this->header_data))
				$object = (get_class($this)=="header" || get_class($this)=="header_modal" || get_class($this)=="header_iframe")?$this:$this->main->controllers["HEADER"];
			
			$object->data[$name] = $value;
    }

    public function __get($name)
    {
			$object = $this;
			if(array_key_exists($name,$this->header_data))
				$object = (get_class($this)=="header" || get_class($this)=="header_modal" || get_class($this)=="header_iframe")?$this:$this->main->controllers["HEADER"];
				
			if (array_key_exists($name, $object->data)) {
					return $object->data[$name];
			}

			$trace = debug_backtrace();
			trigger_error(
					'Undefined property via __get(): ' . $name .
					' in ' . $trace[0]['file'] .
					' on line ' . $trace[0]['line'],
					E_USER_NOTICE);
			return NULL;
		}
	}
?>