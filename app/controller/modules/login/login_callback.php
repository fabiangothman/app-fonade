<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

class login_callback extends controller
{
	private $usuario;
	private $rol;

	protected function index()
	{

		// Recuperación de datos del login
		$this->getFormData("email", false);
		$this->getFormData("password", false);

			
		// Carga de modelo de usuario
		$this->loadModel("common/mdlusuario.cls",false);
		
		// Se verifica el inicio de sesión con los datos proporcionados
		$this->usuario = new usuario($this->main, "login", $this->email, $this->password, "");
		if(isset($this->usuario->id))
		{
			// Se inicia sesión
			$this->main->session->login($this->usuario);
			$this->rol = $this->usuario->nombre_unico;

			// Redirige al Home, si es admin o de otro tipo
			if($this->rol=="administrador"){
				$this->redirect(_MSFW_PATH_."modules/rolHomeLoader/mensaje/7");
				exit();
			}else{
				$this->redirect(_MSFW_PATH_."modules/rolHomeLoader/mensaje/6");
				exit();
			}
		}else{
			// Se redirige al login y se muestra mensaje de error de autenticación
			$this->redirect(_MSFW_PATH_."modules/login/login/mensaje/2/email/$this->email");
			exit();
		}

  }
	
	

  public function render()
	{
    return "";
  }
}
?>
