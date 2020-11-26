<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  Juan Suárez, juancsuarezg@correo.udistrital.edu.co	*
	*					  © 2017												*
	****************************************************************************/

class recuperar_callback extends controller
{
	private $usuario;

	protected function index()
	{
		// Recuperación de datos del login
		$this->getFormData("email", false);
		
		//Se estructura la URL para retornar el correo por si hay error
		$urlCallback = "/email/".$this->email;
		
		// Se carga el modelo de olvido de contraseña
		$this->loadModel("modules/login/forget.cls",false);
		$this->forget = new forget($this->main);
		$resp = $this->forget->checkUserbyEmail($this->email);
		
		if($resp){
			$id_usuario = $resp['id'];
			$correo_usuario = $resp['email'];
			
			//Se genera una nueva constraseña aleatoria
			$nuevaContrasena =  $this->generaPass();
			//Se almacena la nueva contraseña en la BD.
			$guardado = $this->forget->changePass($id_usuario, $nuevaContrasena);
			
			if($guardado){
				$respuestaCorreo = $this->enviarCorreoToken($correo_usuario, $nuevaContrasena);
				if(!$respuestaCorreo){
					$this->redirect(_MSFW_PATH_."modules/login/recuperar/mensaje/18".$urlCallback);
					exit();
				}
			}else{
				$this->redirect(_MSFW_PATH_."modules/login/recuperar/mensaje/20".$urlCallback);   
				exit();         
			}
		}else{
			$this->redirect(_MSFW_PATH_."modules/login/recuperar/mensaje/17".$urlCallback);
			exit();
		}

		$this->redirect(_MSFW_PATH_."modules/login/recuperar/mensaje/19".$urlCallback);
		exit();
	}

	/*
	* Función para enviar al correo 
	*/
	private function enviarCorreoToken($to, $tokenCifradoCorreo){
		$headers = 'From: no-reply'."\r\n".
		'Reply-To: no-reply@'._MSFW_APP_NAME_.'.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		$subject = 'Asistencia de contraseñas de la aplicación '._MSFW_APP_NAME_;
		$message = 'Señor(a) usuario, usted ha solicitado una reasignación de contraseña para el ingreso a la aplicación '._MSFW_APP_NAME_.".\t\n".'la nueva contraseña asiganada para el ingreso a la aplicación es:'."\t\n\n".$tokenCifradoCorreo."\t\n\n".'Con esta contraseña podrá iniciar sesión en la aplicación.'."\r\n".'Si ha recibido este mensaje por error, es probable que otro usuario haya introducido sin notarlo su dirección de correo electrónico al intentar reasignar una contraseña. Por lo tanto, su nueva contraseña <strong>es la que se especifica en este correo</strong>. Recuerde que puede cambiarla dentro del aplicativo'."\r\n".'Atentamente,'."\r\n".'El robot administrador del sistema '._MSFW_APP_NAME_."\r\n\n".'Nota: Este correo no puede recibir respuestas.';

		return @mail($to, $subject, $message, $headers);
  }

  private function generaPass()
	{
    //Se define una cadena de caracteres. Te recomiendo que uses esta.
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena=strlen($cadena);
     
    //Se define la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
    $longitudPass=15;
     
    //Creamos la contraseña
    for($i=1 ; $i<=$longitudPass ; $i++)
		{
			//Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
			$pos=rand(0,$longitudCadena-1);
	 
			//Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
			$pass .= substr($cadena,$pos,1);
    }
    return $pass;
  }

  public function render()
	{
    return "";
  }
}
?>
