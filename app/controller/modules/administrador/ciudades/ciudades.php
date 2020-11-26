<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class ciudades extends controller
	{
		private $rol;

		protected function index()
		{

			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Ciudades";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/ciudades/ciudades");
			$this->addStyle("modules/".$this->rol."/ciudades/ciudades", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/ciudades/ciudades.cls",false);
			$ciudades = new ciudadesCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaCiudades = $ciudades->getCiudades();
			$this->listaDepartamentos = $ciudades->getDepartamentos();

			$this->addInReadyCode("
				MSCiudades.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', ".json_encode($this->listaDepartamentos).", '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/ciudades/ciudades");
		}
	}
?>
