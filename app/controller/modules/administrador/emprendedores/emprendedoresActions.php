<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class emprendedoresActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateEmprendedor':
					$this->loadModel("modules/".$this->rol."/emprendedores/emprendedores.cls",false);
					$emprendedores = new emprendedoresCRUD($this->main);

					$this->getFormData("orig_id", false);
					$this->getFormData("id", false);
					$this->getFormData("nombres", false);
					$this->getFormData("apellidos", false);
					$this->getFormData("correo", false);
					$this->getFormData("telefono", false);
					$this->getFormData("contacto", false);
					$this->getFormData("ciudad_dane", false);
					$this->getFormData("rol_id", false);

					$resp = $emprendedores->updateEmprendedor(urldecode($this->orig_id), urldecode($this->id), urldecode($this->nombres), urldecode($this->apellidos), urldecode($this->correo), urldecode($this->telefono), urldecode($this->contacto), urldecode($this->ciudad_dane), urldecode($this->rol_id));
					echo $resp;
					//echo json_encode($emprendedores->updateEmprendedor($x));
					exit();
				break;
				case 'createEmprendedor':
					$this->loadModel("modules/".$this->rol."/emprendedores/emprendedores.cls",false);
					$emprendedores = new emprendedoresCRUD($this->main);

					$this->getFormData("id", false);
					$this->getFormData("nombres", false);
					$this->getFormData("apellidos", false);
					$this->getFormData("correo", false);
					$this->getFormData("telefono", false);
					$this->getFormData("contacto", false);
					$this->getFormData("ciudad_dane", false);
					$this->getFormData("rol_id", false);

					$resp = $emprendedores->createEmprendedor(urldecode($this->id), urldecode($this->nombres), urldecode($this->apellidos), urldecode($this->correo), urldecode($this->telefono), urldecode($this->contacto), urldecode($this->ciudad_dane), urldecode($this->rol_id), _USER_DEFAULT_PASSW_, null, null);
					echo $resp;
					//echo json_encode($emprendedores->createEmprendedor($x));
					exit();
			    break;
			    case 'deleteEmprendedor':
					$this->loadModel("modules/".$this->rol."/emprendedores/emprendedores.cls",false);
					$emprendedores = new emprendedoresCRUD($this->main);

					$this->getFormData("id", false);

					$resp = $emprendedores->deleteEmprendedor(urldecode($this->id));
					echo $resp;
					//echo json_encode($emprendedores->createEmprendedor($x));
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
