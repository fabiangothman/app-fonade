<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class laes extends controller
	{
		private $rol;

		protected function index()
		{
			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - LAEs";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/laes/laes");
			$this->addStyle("modules/".$this->rol."/laes/laes", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/laes/laes.cls",false);
			$laes = new laesCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaLaes = $laes->getInterventorLae($this->main->usuario->id);

			$this->default_pw = _USER_DEFAULT_PASSW_;

			$this->addInReadyCode("
				MSLaes.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/laes/laes");
		}
	}
?>
