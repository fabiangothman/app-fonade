<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class usuariosActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateUsuario':
					$this->loadModel("modules/".$this->rol."/usuarios/usuarios.cls",false);
					$usuarios = new usuariosCRUD($this->main);

					$this->getFormData("orig_id", false);
					$this->getFormData("id", false);
					$this->getFormData("nombres", false);
					$this->getFormData("apellidos", false);
					$this->getFormData("correo", false);
					$this->getFormData("clave", false);
					$this->getFormData("telefono", false);
					$this->getFormData("contacto", false);
					$this->getFormData("ciudad_dane", false);
					$this->getFormData("rol_id", false);
					$this->getFormData("lae_id", false);

					$resp = $usuarios->updateUsuario(urldecode($this->orig_id), urldecode($this->id), urldecode($this->nombres), urldecode($this->apellidos), urldecode($this->correo), urldecode($this->clave), urldecode($this->telefono), urldecode($this->contacto), urldecode($this->ciudad_dane), urldecode($this->rol_id), urldecode($this->lae_id));
					echo $resp;
					exit();
				break;
				case 'createUsuario':
					$this->loadModel("modules/".$this->rol."/usuarios/usuarios.cls",false);
					$usuarios = new usuariosCRUD($this->main);

					$this->getFormData("id", false);
					$this->getFormData("nombres", false);
					$this->getFormData("apellidos", false);
					$this->getFormData("correo", false);
					$this->getFormData("clave", false);
					$this->getFormData("telefono", false);
					$this->getFormData("contacto", false);
					$this->getFormData("ciudad_dane", false);
					$this->getFormData("rol_id", false);
					$this->getFormData("lae_id", false);

					$resp = $usuarios->createUsuario(urldecode($this->id), urldecode($this->nombres), urldecode($this->apellidos), urldecode($this->correo), urldecode($this->clave), urldecode($this->telefono), urldecode($this->contacto), urldecode($this->ciudad_dane), urldecode($this->rol_id), urldecode($this->lae_id));
					echo $resp;
					exit();
			    break;
			    case 'deleteUsuario':
					$this->loadModel("modules/".$this->rol."/usuarios/usuarios.cls",false);
					$usuarios = new usuariosCRUD($this->main);

					$this->getFormData("id", false);

					$resp = $usuarios->deleteUsuario(urldecode($this->id));
					echo $resp;
					exit();
			    break;
			  default:
			  	echo false;
			    return false;
			    exit();
			}

		}

		public function render()
		{
			return "";
		}
	}
?>
