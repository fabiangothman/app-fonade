<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/
	
	class login extends controller
	{
		protected function index()
		{

			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Login";
			//Carga el email si hay error al tratar de iniciar sesión
			$this->email = $this->convertNullToEmpty($this->getArg("email"));
			//URL para recuperar contrasena
			$this->ir_recuperar = _MSFW_PATH_."modules/login/recuperar";
			
			$this->addScript(true, "login/login");
			$this->addStyle("modules/login/login", "stylesheet", "screen");
			$this->addInReadyCode("
				MSLogin.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."');
				//
			");
		}
			
		public function render()
		{
			return $this->printView("modules/login/login");
		}
	}
?>