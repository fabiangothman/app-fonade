<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class rolesActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateRol':
					$this->loadModel("modules/".$this->rol."/roles/roles.cls",false);
					$roles = new rolesCRUD($this->main);

					$this->getFormData("id", false);
					$this->getFormData("rol", false);
					$this->getFormData("description", false);

					$resp = $roles->updateRol(urldecode($this->id), urldecode($this->rol), urldecode($this->description));
					echo $resp;
					exit();
				break;
				case 'createRol':
					$this->loadModel("modules/".$this->rol."/roles/roles.cls",false);
					$roles = new rolesCRUD($this->main);

					$this->getFormData("rol", false);
					$this->getFormData("description", false);

					$resp = $roles->createRol(urldecode($this->rol), urldecode($this->description));
					echo $resp;
					exit();
			    break;
			    case 'deleteRol':
					$this->loadModel("modules/".$this->rol."/roles/roles.cls",false);
					$roles = new rolesCRUD($this->main);

					$this->getFormData("id", false);

					$resp = $roles->deleteRol(urldecode($this->id));
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
