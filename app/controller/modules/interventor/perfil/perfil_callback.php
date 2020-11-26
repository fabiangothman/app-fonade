<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class perfil_callback extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$this->getFormData("id", false);
			$this->getFormData("nombres", false);
			$this->getFormData("apellidos", false);
			$this->getFormData("email", false);
			$this->getFormData("telefono", false);
			$this->getFormData("contacto", false);
			$this->getFormData("ciudad_dane", false);
			$this->getFormData("password", false);
			$this->getFormData("passwordconfirmation", false);
			$this->getFormData("currentimage", false);

			$this->currentimage = ($this->currentimage=="") ? null : $this->currentimage;
			
			$this->validateInfo($this->id, $this->nombres, $this->apellidos, $this->email, $this->password, $this->passwordconfirmation);

			//Compara las contraseñas ingresadas
			$this->password = (($this->password === $this->passwordconfirmation)&&($this->password!="")&&($this->passwordconfirmation!="")) ? $this->password : null;

			$this->loadModel("modules/".$this->rol."/perfil/perfil.cls",false);
			$perfil = new perfiles($this->main);
			if($this->updateProfilePic($this->id, $perfil, $this->currentimage)){
				$resp = $perfil->updateUsuario(urldecode($this->id), urldecode($this->nombres), urldecode($this->apellidos), urldecode($this->email), urldecode($this->password), urldecode($this->telefono), urldecode($this->contacto), urldecode($this->ciudad_dane));
				if($resp){
					$this->redirect(_MSFW_PATH_."modules/".$this->rol."/perfil/perfil/mensaje/10");
					exit();
				}else{
					$this->redirect(_MSFW_PATH_."modules/".$this->rol."/perfil/perfil/mensaje/11");
					exit();
				}
			}else{
				$this->redirect(_MSFW_PATH_."modules/".$this->rol."/perfil/perfil/mensaje/12");
				exit();
			}

		}

		private function updateProfilePic($userId, $objPerfil, $currentimage){
			//Garantiza que se ha seleccionado una foto para cargar, sino NO cambia la foto
			if(isset($_FILES['subefoto']) && (!empty($_FILES['subefoto']['name'])) && (($_FILES['subefoto']['type'] == 'image/jpeg') || ($_FILES['subefoto']['type'] == 'image/png') || ($_FILES['subefoto']['type'] == 'image/gif'))){

				$profilePicsPth = _UPLOAD_PROFILE_PIC_."modules/".$this->rol."/perfil/fotosperfil/";
				$picName = time().$userId.".png";
				$imageTemp = $_FILES['subefoto'];

				$nombre = $imageTemp['tmp_name'];
				$extension = pathinfo($imageTemp['name'], PATHINFO_EXTENSION);

				//Mueve la imagen subida temporalmente a la carpeta profilepics, con el nombre del id y etension original
				//Se forza a guardarla como .png para evitar duplicidad en la carpeta profilepics, por las extensiones
				if(move_uploaded_file($nombre, $profilePicsPth.$picName)){
					if($currentimage)
						unlink($profilePicsPth.$currentimage);
					$resp = $objPerfil->updateProfilePic($userId, $picName);
					if($resp)
						return true;
					else
						return false;
				}else{
					return false;
				}
			}else{
				return true;
			}
		}

		private function validateInfo($id, $name, $lastname, $email, $password, $passwordconfirmation)
		{
			if((($id=="")||($id==null))||(($name=="")||($name==null))||(($lastname=="")||($lastname==null))||(($email=="")||($email==null))){
				$this->redirect(_MSFW_PATH_."modules/".$this->rol."/perfil/perfil/mensaje/8");
				exit();
			}
			if($password!=$passwordconfirmation){
				$this->redirect(_MSFW_PATH_."modules/".$this->rol."/perfil/perfil/mensaje/9");
				exit();
			}
		}

		public function render()
		{
			return "";
		}
	}
?>
