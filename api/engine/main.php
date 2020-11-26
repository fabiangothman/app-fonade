<?php
	/******************************************************/
	/*	Desarrollado por: Multimedia Service S.A. © 2017	*/
	/******************************************************/

	/**** CARGA DE LIBRERÍAS REQUERIDAS ****/
	include_once(_LIB_PATH_."common/session.cls.php");
	include_once(_LIB_PATH_."common/database.cls.php");
	include_once(_LIB_PATH_."common/url_solver.cls.php");	// Librería que resuleve la ruta por URL
	include_once(_ENGINE_PATH_."controller.php");			// Manejador de controladores
	include_once(_ENGINE_PATH_."view.php");					// Manejador de vistas

	class main
	{
		public $db_data;								// Objetos base de datos
    	public $url_solver;								// Objeto URL Solver
		public $session;								// Objeto sesión
		public $controllers = array ();					// Objetos controller
		public $usuario;								// Objeto Usuario
		public $usuario_rol;							// Objeto Usuario rol

		public function __construct()
		{
			$this->init();
		}
		
		protected function init()
		{
			/**** GENERACIÓN DE OBJETO SESION ****/
			$this->session = new session();

			/**** GENERACIÓN DE OBJETOS BD ****/
			if( USING_DB ){
				global $_DB_APP;
				$this->db_data = new connector_bd($_DB_APP);
			}
			
			/**** CARGA DEL OBJETO USUARIO SI SE ESTÁ AUTENTICADO ****/
			if($this->session->check_session()=="open")
			{
				include_once (_MODEL_PATH_."common/mdlusuario.cls.php");
				$this->usuario = new usuario($this,"id","","",$this->session->id);
				$this->usuario_rol = $this->usuario->userData['nombre_unico'];
			}else{
				$this->usuario_rol = null;
			}

			/**** GENERACIÓN DE OBJETO URL SOLVER ****/
			$this->url_solver = new url_solver($this->session->check_session());

			/**** CARGA DE CONTROLLERS ****/
			$ctrl_extra = $this->url_solver->getType();
			$this->controllers["HEADER"] = $this->load_controller(_CONTROLLER_PATH_."common/header".$ctrl_extra);
			$this->controllers["BODY"] = $this->load_controller($this->url_solver->getPath());
			$this->controllers["FOOTER"] = $this->load_controller(_CONTROLLER_PATH_."common/footer".$ctrl_extra);

			/**** OUTPUT DE LA PÁGINA ****/
			$output = "";
			foreach($this->controllers as $controller)
			{
				$output .= $controller->render();
			}
			print ($output=="")?"@charset '{_CHARSET_}'":$output;
		}
		
		protected function load_controller($file)
		{
			$complemento = (strpos($file,".php"))?"":".php";
			if(is_file($file.$complemento))
			{
				$controller_name = $this->url_solver->solveObjectName($file);
				include_once ($file.$complemento);
				return new $controller_name($this);
			}
			return NULL;
		}

		public function __destruct()
		{
			/**** CIERRA CONEXIONES DE OBJETOS BD ****/
			if($this->db_data)
			{
				$this->db_data->desconectar();
				$this->db_data = NULL;
			}
  	}
	}
?>
