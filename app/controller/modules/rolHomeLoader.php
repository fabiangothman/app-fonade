<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	//Se encargará de distribuir cualquier carga por defecto a su respectivo home de rol (cuando existe session)
	class rolHomeLoader extends controller
	{
		private $rol;
		
		protected function index()
		{
			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Cargando Home de Rol ...";
			$this->rol = $this->main->usuario_rol;

			$defaultControllerUrl = "notificaciones/notificaciones";

			if(is_null($this->getArg("mensaje"))){
				$this->redirect(_MSFW_PATH_."modules/".$this->rol."/".$defaultControllerUrl);
				exit();
			}else{
				$this->redirect(_MSFW_PATH_."modules/".$this->rol."/".$defaultControllerUrl."/mensaje/".$this->getArg("mensaje"));
				exit();
			}
		}

		public function render()
		{
			return "";
		}
	}
?>
