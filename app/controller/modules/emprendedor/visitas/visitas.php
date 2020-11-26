<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class visitas extends controller
	{
		private $rol;

		protected function index()
		{
			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Visitas";
			$this->rol = $this->main->usuario_rol;
			$this->user_id = $this->main->usuario->id;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/visitas/visitas");
			$this->addStyle("modules/".$this->rol."/visitas/visitas", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/visitas/visitas.cls",false);
			$visitas = new visitasCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaVisitas = $visitas->getIntrvVisitas($this->main->usuario->id);

			//Cada cuantos días hábiles se crearán las nuevas visitas
			$this->visitas_days = _VISTS_DAYS_;

			//URL de carpeta de archivos del usuario
			$this->docs_folder = _MSFW_PATH_."documentos/";

			$this->addInReadyCode("
				MSVisitas.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/visitas/visitas");
		}
	}
?>
