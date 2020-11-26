<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class emprendedores extends controller
	{
		private $rol;

		protected function index()
		{

			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Emprendedores";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/emprendedores/emprendedores");
			$this->addStyle("modules/".$this->rol."/emprendedores/emprendedores", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/emprendedores/emprendedores.cls",false);
			$emprendedores = new emprendedoresCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaEmprendedores = $emprendedores->getIntrvEmprendedores($this->main->usuario->id);

			$this->default_pw = _USER_DEFAULT_PASSW_;

			$this->addInReadyCode("
				MSEmprendedores.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/emprendedores/emprendedores");
		}
	}
?>
