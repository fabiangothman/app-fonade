<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class usuarios extends controller
	{
		private $rol;

		protected function index()
		{
			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Todos los Usuarios";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/usuarios/usuarios");
			$this->addStyle("modules/".$this->rol."/usuarios/usuarios", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/usuarios/usuarios.cls",false);
			$usuarios = new usuariosCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaUsuarios = $usuarios->getusuarios();
			$this->listaCiudades = $usuarios->getCiudades();
			$this->listaRoles = $usuarios->getRoles();
			$this->listaLaes = $usuarios->getLaes();

			$this->addInReadyCode("
				MSUsuarios.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', ".json_encode($this->listaCiudades).", ".json_encode($this->listaRoles).", ".json_encode($this->listaLaes).", '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/usuarios/usuarios");
		}
	}
?>
