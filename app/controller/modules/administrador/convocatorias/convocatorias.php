<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class convocatorias extends controller
	{
		private $rol;

		protected function index()
		{

			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Convocatorias";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/convocatorias/convocatorias");
			$this->addStyle("modules/".$this->rol."/convocatorias/convocatorias", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/convocatorias/convocatorias.cls",false);
			$convocatorias = new convocatoriasCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaConvocatorias = $convocatorias->getConvocatorias();

			$this->addInReadyCode("
				MSConvocatorias.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/convocatorias/convocatorias");
		}
	}
?>
