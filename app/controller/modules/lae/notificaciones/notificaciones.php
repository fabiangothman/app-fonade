<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class notificaciones extends controller
	{
		private $rol;

		protected function index()
		{
			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Notificaciones";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/notificaciones/notificaciones");
			$this->addStyle("modules/".$this->rol."/notificaciones/notificaciones", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/notificaciones/notificaciones.cls",false);
			$notificaciones = new notificacionesCRUD($this->main);

			//Informacion a mostrar en front
			$this->notifydays = _NOTIFYDAYS_;
			$this->listaNotificacionesProximas = $notificaciones->getProxInterVisitas($this->main->usuario->id, $this->notifydays);
			$this->listaNotificacionesProximas = array_merge($this->listaNotificacionesProximas, $notificaciones->getGenerEmprenFaltanDocs($this->main->usuario->id));
			$this->listaNotificacionesPasadas = $notificaciones->getDocsFaltantVisitas($this->main->usuario->id);
			$this->listaNotificacionesPasadas = array_merge($this->listaNotificacionesPasadas, $notificaciones->getPasadInterVisitas($this->main->usuario->id));

			$this->addInReadyCode("
				MSNotificaciones.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/notificaciones/notificaciones");
		}
	}
?>
