<?php
	include_once(_LIB_PATH_."common/database.cls.php");
	
	class main
	{
		public $db_cv;	// Objetos base de datos
		public function __construct()
		{
			$this->init();
  	}
		protected function init()
		{
			/**** GENERACIÓN DE OBJETOS BD ****/
			global $_DB_MSUSERSARCHITECT_;
			$this->db_cv = new connector_bd($_DB_MSUSERSARCHITECT_);
		}
	}
	$app = new main();
?>