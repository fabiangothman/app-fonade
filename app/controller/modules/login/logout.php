<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/
	
	class logout extends controller
	{
		protected function index()
		{
			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Cerrando sesión...";
			$this->main->session->logout("user closed");
		}
		
		public function render()
		{
			return "";
		}
	}
?>