<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class documentos_emprendedor extends controller
	{
		private $rol;

		protected function index()
		{
			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Documentos de emprendedores";
			$this->rol = $this->main->usuario_rol;
			$this->user_id = $this->main->usuario->id;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/documentos_emprendedor/documentos_emprendedor");
			$this->addStyle("modules/".$this->rol."/documentos_emprendedor/documentos_emprendedor", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/documentos_emprendedor/documentos_emprendedor.cls",false);
			$documentos_emprendedor = new documentos_emprendedorCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaDocumentos_emprendedor = $documentos_emprendedor->getDocumentos_emprendedor($this->main->usuario->id);

			$this->listaDocumentos = $documentos_emprendedor->getLaeDocumentos($this->main->usuario->id);
			$this->listaProyectos = $documentos_emprendedor->getLaeProyectos($this->main->usuario->id);

			//URL de carpeta de archivos del usuario
			$this->docs_folder = _MSFW_PATH_."documentos/";

			$this->addInReadyCode("
				MSDocumentos_emprendedor.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', ".json_encode($this->listaDocumentos).", ".json_encode($this->listaProyectos).", ".$this->user_id.", '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/documentos_emprendedor/documentos_emprendedor");
		}
	}
?>
