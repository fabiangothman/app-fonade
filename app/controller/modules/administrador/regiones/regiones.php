<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class regiones extends controller
	{
		private $rol;

		protected function index()
		{
			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Regiones";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/regiones/regiones");
			$this->addStyle("modules/".$this->rol."/regiones/regiones", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/regiones/regiones.cls",false);
			$regiones = new regionesCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaRegiones = $regiones->getRegiones();

			$this->addInReadyCode("
				MSRegiones.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/regiones/regiones");
		}
	}
?>
