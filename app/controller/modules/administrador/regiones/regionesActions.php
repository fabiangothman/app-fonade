<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class regionesActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateRegion':
					$this->loadModel("modules/".$this->rol."/regiones/regiones.cls",false);
					$regiones = new regionesCRUD($this->main);

					$this->getFormData("id", false);
					$this->getFormData("region", false);

					$resp = $regiones->updateRegion(urldecode($this->id), urldecode($this->region));
					echo $resp;
					exit();
				break;
				case 'createRegion':
					$this->loadModel("modules/".$this->rol."/regiones/regiones.cls",false);
					$regiones = new regionesCRUD($this->main);

					$this->getFormData("region", false);

					$resp = $regiones->createRegion(urldecode($this->region));
					echo $resp;
					exit();
			    break;
			    case 'deleteRegion':
					$this->loadModel("modules/".$this->rol."/regiones/regiones.cls",false);
					$regiones = new regionesCRUD($this->main);

					$this->getFormData("id", false);

					$resp = $regiones->deleteRegion(urldecode($this->id));
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
