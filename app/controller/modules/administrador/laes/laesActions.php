<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class laesActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateLae':
					$this->loadModel("modules/".$this->rol."/laes/laes.cls",false);
					$laes = new laesCRUD($this->main);

					$this->getFormData("orig_id", false);
					$this->getFormData("id", false);
					$this->getFormData("nombres", false);
					$this->getFormData("apellidos", false);
					$this->getFormData("correo", false);
					$this->getFormData("telefono", false);
					$this->getFormData("contacto", false);
					$this->getFormData("ciudad_dane", false);
					$this->getFormData("rol_id", false);

					$resp = $laes->updateLae(urldecode($this->orig_id), urldecode($this->id), urldecode($this->nombres), urldecode($this->apellidos), urldecode($this->correo), urldecode($this->telefono), urldecode($this->contacto), urldecode($this->ciudad_dane), urldecode($this->rol_id));
					echo $resp;
					//echo json_encode($laes->updateLae($x));
					exit();
				break;
				case 'createLae':
					$this->loadModel("modules/".$this->rol."/laes/laes.cls",false);
					$laes = new laesCRUD($this->main);

					$this->getFormData("id", false);
					$this->getFormData("nombres", false);
					$this->getFormData("apellidos", false);
					$this->getFormData("correo", false);
					$this->getFormData("telefono", false);
					$this->getFormData("contacto", false);
					$this->getFormData("ciudad_dane", false);
					$this->getFormData("rol_id", false);

					$resp = $laes->createLae(urldecode($this->id), urldecode($this->nombres), urldecode($this->apellidos), urldecode($this->correo), urldecode($this->telefono), urldecode($this->contacto), urldecode($this->ciudad_dane), urldecode($this->rol_id), _USER_DEFAULT_PASSW_, null, null);
					echo $resp;
					//echo json_encode($laes->createLae($x));
					exit();
			    break;
			    case 'deleteLae':
					$this->loadModel("modules/".$this->rol."/laes/laes.cls",false);
					$laes = new laesCRUD($this->main);

					$this->getFormData("id", false);

					$resp = $laes->deleteLae(urldecode($this->id));
					echo $resp;
					//echo json_encode($laes->createLae($x));
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
