<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class roles extends controller
	{
		private $rol;

		protected function index()
		{
			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Roles";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/roles/roles");
			$this->addStyle("modules/".$this->rol."/roles/roles", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/roles/roles.cls",false);
			$roles = new rolesCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaRoles = $roles->getRoles();

			$this->addInReadyCode("
				MSRoles.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/roles/roles");
		}
	}
?>
