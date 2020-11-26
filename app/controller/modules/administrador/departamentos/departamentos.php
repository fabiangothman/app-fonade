<?php
	/****************************************************************************
	*	Desarrollado por: Fabi�n Murillo, fabianmurillo.01@gmail.com			*
	*					  � 2019												*
	****************************************************************************/

	class departamentos extends controller
	{
		private $rol;

		protected function index()
		{
			//Configuraci�n inicial
			$this->title = _MSFW_APP_NAME_." - Departamentos";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/departamentos/departamentos");
			$this->addStyle("modules/".$this->rol."/departamentos/departamentos", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/departamentos/departamentos.cls",false);
			$departamentos = new departamentosCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaDepartamentos = $departamentos->getDepartamentos();
			$this->listaRegiones = $departamentos->getRegiones();

			$this->addInReadyCode("
				MSDepartamentos.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', ".json_encode($this->listaRegiones).", '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/departamentos/departamentos");
		}
	}
?>
