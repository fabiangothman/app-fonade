<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class administradoresActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateAdministrador':
					$this->loadModel("modules/".$this->rol."/administradores/administradores.cls",false);
					$administradores = new administradoresCRUD($this->main);

					$this->getFormData("orig_id", false);
					$this->getFormData("id", false);
					$this->getFormData("nombres", false);
					$this->getFormData("apellidos", false);
					$this->getFormData("correo", false);
					$this->getFormData("telefono", false);
					$this->getFormData("contacto", false);
					$this->getFormData("ciudad_dane", false);
					$this->getFormData("rol_id", false);

					$resp = $administradores->updateAdministrador(urldecode($this->orig_id), urldecode($this->id), urldecode($this->nombres), urldecode($this->apellidos), urldecode($this->correo), urldecode($this->telefono), urldecode($this->contacto), urldecode($this->ciudad_dane), urldecode($this->rol_id));
					echo $resp;
					//echo json_encode($administradores->updateAdministrador($x));
					exit();
				break;
				case 'createAdministrador':
					$this->loadModel("modules/".$this->rol."/administradores/administradores.cls",false);
					$administradores = new administradoresCRUD($this->main);

					$this->getFormData("id", false);
					$this->getFormData("nombres", false);
					$this->getFormData("apellidos", false);
					$this->getFormData("correo", false);
					$this->getFormData("telefono", false);
					$this->getFormData("contacto", false);
					$this->getFormData("ciudad_dane", false);
					$this->getFormData("rol_id", false);

					$resp = $administradores->createAdministrador(urldecode($this->id), urldecode($this->nombres), urldecode($this->apellidos), urldecode($this->correo), urldecode($this->telefono), urldecode($this->contacto), urldecode($this->ciudad_dane), urldecode($this->rol_id), _USER_DEFAULT_PASSW_, null, null);
					echo $resp;
					//echo json_encode($administradores->createAdministrador($x));
					exit();
			    break;
			    case 'deleteAdministrador':
					$this->loadModel("modules/".$this->rol."/administradores/administradores.cls",false);
					$administradores = new administradoresCRUD($this->main);

					$this->getFormData("id", false);

					$resp = $administradores->deleteAdministrador(urldecode($this->id));
					echo $resp;
					//echo json_encode($administradores->createAdministrador($x));
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
