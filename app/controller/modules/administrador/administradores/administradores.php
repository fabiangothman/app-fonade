<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class administradores extends controller
	{
		private $rol;

		protected function index()
		{
			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Administradores";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/administradores/administradores");
			$this->addStyle("modules/".$this->rol."/administradores/administradores", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/administradores/administradores.cls",false);
			$administradores = new administradoresCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaAdministradores = $administradores->getAdministradores();
			$this->listaCiudades = $administradores->getCiudades();
			$this->listaRoles = $administradores->getRoles();

			$this->default_pw = _USER_DEFAULT_PASSW_;

			$this->addInReadyCode("
				MSAdministradores.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', ".json_encode($this->listaCiudades).", ".json_encode($this->listaRoles).", '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/administradores/administradores");
		}
	}
?>
