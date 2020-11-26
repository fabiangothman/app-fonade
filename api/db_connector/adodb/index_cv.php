<?php
	include_once(_DB_PATH_."adodb/adodb.inc.php");        //Libreria para conexion MySQL

	class adodb_cv extends database
	{
		private $db;
		// Constructor
		public function __construct(array $p_Array)
		{
			$this->host = $p_Array["Server"];
			$this->user = $p_Array["User"];
			$this->pass = $p_Array["Pass"];
			$this->dbase = $p_Array["Db"];
			$this->gestor_bd = $p_Array["Driver"];
			$this->debug = $p_Array["Debug"];
			$this->db = ADONewConnection($this->gestor_bd);
  	}
		
		protected function conectar()
		{
			$this->db->Connect($this->host,$this->user,$this->pass,$this->dbase);
			$this->db->EXECUTE("set names 'utf8'");
			$this->db->SetFetchMode(ADODB_FETCH_ASSOC);
			//$this->db->SetCharSet("utf8");
			$this->db->debug = $this->debug;
		}
		protected function query_db($pQuery,$p_debug = NULL)
		{
			$p_debug = is_null($p_debug)?$this->debug:$p_debug;
			$this->db->debug = $p_debug;
			$datos = $this->db->GetAll($pQuery);
			return $datos;
		}
		protected function exec_query_db($pQuery,$p_debug = NULL)
		{
			$p_debug = is_null($p_debug)?$this->debug:$p_debug;
			$this->db->debug = $p_debug;
			$retorno  = $this->db->Execute($pQuery);
			if( !empty($retorno) )
				return true;
			else
				return false;
		}
		protected function desconectar()
		{
			$this->db->close();
		}
		public function __destruct()
		{
			$this->desconectar();
		}
	}
?>