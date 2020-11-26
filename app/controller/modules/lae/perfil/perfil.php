<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class perfil extends controller
	{
		private $rol;

		protected function index()
		{
			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Perfil";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/perfil/perfil");
			$this->addStyle("modules/".$this->rol."/perfil/perfil", "stylesheet", "screen");
			$this->addInReadyCode("
				MSPerfil.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', '".$this->rol."');
				//
			");
			
			$this->loadModel("modules/".$this->rol."/perfil/perfil.cls",false);
			$perfil = new perfiles($this->main);
			$this->usuario = $perfil->getUsuario($this->main->usuario->id);

			$this->listaCiudades = $perfil->getCiudades();
			
			$profileImagePath = _MSFW_PATH_._IMG_ROOT_."modules/".$this->rol."/perfil/fotosperfil/";
			if(($this->usuario["imagen"]=="")||($this->usuario["imagen"]==null))
				$this->profilepicurl = null;
			else
				$this->profilepicurl = $profileImagePath.$this->usuario["imagen"];

			$this->rolFront = $this->rol;
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/perfil/perfil");
		}
	}
?>
