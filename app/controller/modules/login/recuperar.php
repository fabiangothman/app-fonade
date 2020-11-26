<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/
	
	class recuperar extends controller
	{
		protected function index()
		{
			//Se verifica el estado de la sesión
			$this->logged = ($this->main->session->check_session()=="open")?true:false;
			if($this->logged)
			{
				// Se debe dirigir al path por defecto
				$this->redirect(_MSFW_PATH_);
				exit();
			}

			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Recuperar contraseña";
			//Carga los mensajes entrantes
			
			//Carga el email si hay error al tratar de iniciar sesión
			$this->email = $this->convertNullToEmpty($this->getArg("email"));
			//URL para volver al inicio de sesión
			$this->ir_volver = _MSFW_PATH_."modules/login/login";

			$this->addScript(true, "recuperar/recuperar");
			$this->addStyle("modules/login/recuperar", "stylesheet", "screen");
			$this->addInReadyCode("
				MSRecuperar.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."');
				//
			");
		}
		
		public function render()
		{
			return $this->printView("modules/login/recuperar");
		}
	}
?>