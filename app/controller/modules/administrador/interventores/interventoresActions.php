<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class interventoresActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateInterventor':
					$this->loadModel("modules/".$this->rol."/interventores/interventores.cls",false);
					$interventores = new interventoresCRUD($this->main);

					$this->getFormData("orig_id", false);
					$this->getFormData("id", false);
					$this->getFormData("nombres", false);
					$this->getFormData("apellidos", false);
					$this->getFormData("correo", false);
					$this->getFormData("telefono", false);
					$this->getFormData("contacto", false);
					$this->getFormData("ciudad_dane", false);
					$this->getFormData("rol_id", false);
					$this->getFormData("lae_id", false);

					$resp = $interventores->updateInterventor(urldecode($this->orig_id), urldecode($this->id), urldecode($this->nombres), urldecode($this->apellidos), urldecode($this->correo), urldecode($this->telefono), urldecode($this->contacto), urldecode($this->ciudad_dane), urldecode($this->rol_id), urldecode($this->lae_id));
					echo $resp;
					//echo json_encode($interventores->updateInterventor($x));
					exit();
				break;
				case 'createInterventor':
					$this->loadModel("modules/".$this->rol."/interventores/interventores.cls",false);
					$interventores = new interventoresCRUD($this->main);

					$this->getFormData("id", false);
					$this->getFormData("nombres", false);
					$this->getFormData("apellidos", false);
					$this->getFormData("correo", false);
					$this->getFormData("telefono", false);
					$this->getFormData("contacto", false);
					$this->getFormData("ciudad_dane", false);
					$this->getFormData("rol_id", false);
					$this->getFormData("lae_id", false);

					$resp = $interventores->createInterventor(urldecode($this->id), urldecode($this->nombres), urldecode($this->apellidos), urldecode($this->correo), urldecode($this->telefono), urldecode($this->contacto), urldecode($this->ciudad_dane), urldecode($this->rol_id), _USER_DEFAULT_PASSW_, null, urldecode($this->lae_id));
					echo $resp;
					//echo json_encode($interventores->createInterventor($x));
					exit();
			    break;
			    case 'deleteInterventor':
					$this->loadModel("modules/".$this->rol."/interventores/interventores.cls",false);
					$interventores = new interventoresCRUD($this->main);

					$this->getFormData("id", false);

					$resp = $interventores->deleteInterventor(urldecode($this->id));
					echo $resp;
					//echo json_encode($interventores->createInterventor($x));
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
