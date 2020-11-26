<?php
	/******************************************************/
	/*	Desarrollado por: Multimedia Service S.A. © 2017	*/
	/******************************************************/
	
	class view
	{
		protected $controller;	// Referencia al objeto controller
		protected $file;				// Archivo a cargar
		protected $output;			// Contenido de la vista
				
		public function __construct(&$p_controller, $p_file)
		{
			$this->controller = $p_controller;
			$this->file = $p_file;
			$this->index();
  	}
		
		protected function index()
		{
			extract($this->controller->getData());
			ob_start();
			include($this->file);
			$this->output = ob_get_contents();
      ob_end_clean();
		}
		
		public function getOutput()
		{
			return $this->output;
		}
	}
?>