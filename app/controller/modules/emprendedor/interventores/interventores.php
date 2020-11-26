<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class interventores extends controller
	{
		private $rol;

		protected function index()
		{
			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Interventores";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/interventores/interventores");
			$this->addStyle("modules/".$this->rol."/interventores/interventores", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/interventores/interventores.cls",false);
			$interventores = new interventoresCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaInterventores = $interventores->getInterventores($this->main->usuario->id);

			$this->addInReadyCode("
				MSInterventores.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/interventores/interventores");
		}
	}
?>
