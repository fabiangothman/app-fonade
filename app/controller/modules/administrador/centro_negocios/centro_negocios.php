<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class centro_negocios extends controller
	{
		private $rol;

		protected function index()
		{

			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Centro de Negocios";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/centro_negocios/centro_negocios");
			$this->addStyle("modules/".$this->rol."/centro_negocios/centro_negocios", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/centro_negocios/centro_negocios.cls",false);
			$centro_negocios = new centro_negociosCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaCentro_negocios = $centro_negocios->getCentro_negocios();
			$this->listaCiudades = $centro_negocios->getCiudades();

			$this->addInReadyCode("
				MSCentro_negocios.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', ".json_encode($this->listaCiudades).", '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/centro_negocios/centro_negocios");
		}
	}
?>
