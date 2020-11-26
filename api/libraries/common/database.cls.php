<?php
	/****************************************************
	*	Desarrollado por: Fabián Murillo S.A. © 2017	*
	*****************************************************/
	
	/************************************
	*	Definición general base de datos	*
	*************************************/
	class base_database
	{
		private $host, $user, $pass, $dbase, $gestor_bd, $debug;
		
		// Constructor
		protected function __construct(array $p_Array)
		{
			$this->host = $p_Array["Server"];
			$this->user = $p_Array["User"];
			$this->pass = $p_Array["Pass"];
			$this->dbase = $p_Array["Db"];
			$this->gestor_bd = $p_Array["Driver"];
			$this->debug = $p_Array["Debug"];
  	}
		protected function __destruct()
		{
			// Manejada según cada implementación de la clase.
		}
		public function safeText($text)
		{
			return (get_magic_quotes_gpc()) ? $text:addslashes($text);
		}
	}
	
	/************************************
	*	Definición general base de datos	*
	*************************************/
	abstract class database extends base_database
	{
		abstract protected function conectar();
		abstract protected function query_db($pQuery,$p_debug = self::debug);
		abstract protected function exec_query_db($pQuery,$p_debug = self::debug);
		abstract protected function desconectar();
	}
	
	/**************************
	*	Conector base de datos	*
	***************************/
	class connector_bd extends database
	{
		private $db, $conector;
		
		// Constructor
		public function __construct(array $p_Array)
		{
			$this->host = $p_Array["Server"];
			$this->user = $p_Array["User"];
			$this->pass = $p_Array["Pass"];
			$this->dbase = $p_Array["Db"];
			$this->gestor_bd = $p_Array["Driver"];
			$this->debug = $p_Array["Debug"];
			$this->conector = $p_Array["Conector"];
			include_once(_DB_PATH_."{$this->conector}/index_cv.php");
			$clase = "{$this->conector}_cv";
			$this->db = new $clase($p_Array);
			$this->db->conectar();
			return $this;
  	}
		public function conectar()
		{
			$this->db->conectar();
		}
		public function query_db($pQuery,$p_debug = NULL)
		{
			$this->conectar();
			$p_debug = is_null($p_debug)?$this->debug:$p_debug;
			$resp = $this->db->query_db($pQuery, $p_debug);
			$this->desconectar();
			return $resp;
		}
		public function exec_query_db($pQuery,$p_debug = NULL)
		{
			$this->conectar();
			$p_debug = is_null($p_debug)?$this->debug:$p_debug;
			$resp = $this->db->exec_query_db($pQuery, $p_debug);
			$this->desconectar();
			return $resp;
		}
		public function desconectar()
		{
			$this->db->desconectar();
		}
		public function autoID($db_table,$db_column)
		{
			$maximoID = 0;
	
			$this->conectar();
			$query = "SELECT MAX(".$db_column.") as 'maximo' FROM ".$db_table;
			$resultado = $this->query_db($query);
			if( empty($resultado[0]["maximo"]) || $resultado[0]["maximo"] == 0 )
				$maximoID = 1;
			else
				$maximoID = $resultado[0]["maximo"] + 1;
			
			$this->desconectar();
			return $maximoID;
		}
		public function autoIncrementFix($db_table,$auto_increment)
		{
			$this->conectar();
			$action = "ALTER TABLE ".$db_table." AUTO_INCREMENT =".$auto_increment;
			$this->desconectar();
			return $this->exec_query_db($action);
		}
		public function __destruct()
		{
			$this->desconectar();
			$this->db = NULL;
		}
	}
?>