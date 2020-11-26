<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class documentos extends controller
	{
		private $rol;

		protected function index()
		{
			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Documentos generales";
			$this->rol = $this->main->usuario_rol;
			$this->user_id = $this->main->usuario->id;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/documentos/documentos");
			$this->addStyle("modules/".$this->rol."/documentos/documentos", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/documentos/documentos.cls",false);
			$documentos = new documentosCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaDocumentos = $documentos->getIntrAndEmprDocumentos($this->main->usuario->id);
			
			$this->listaUsuarios = $documentos->getUsuariosIntrAndEmpr($this->main->usuario->id);

			//URL de carpeta de archivos generales
			$this->docs_folder = _MSFW_PATH_."documentos/";

			$this->addInReadyCode("
				MSDocumentos.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', ".$this->user_id.", ".json_encode($this->listaUsuarios).", '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/documentos/documentos");
		}
	}
?>
