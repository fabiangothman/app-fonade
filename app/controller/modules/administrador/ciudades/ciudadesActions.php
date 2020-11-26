<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class ciudadesActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateCiudad':
					$this->loadModel("modules/".$this->rol."/ciudades/ciudades.cls",false);
					$ciudades = new ciudadesCRUD($this->main);

					$this->getFormData("orig_c_codigo_dane", false);
					$this->getFormData("c_codigo_dane", false);
					$this->getFormData("ciudad", false);
					$this->getFormData("d_codigo_dane", false);

					$resp = $ciudades->updateCiudad(urldecode($this->orig_c_codigo_dane), urldecode($this->c_codigo_dane), urldecode($this->ciudad), urldecode($this->d_codigo_dane));
					echo $resp;
					exit();
				break;
				case 'createCiudad':
					$this->loadModel("modules/".$this->rol."/ciudades/ciudades.cls",false);
					$ciudades = new ciudadesCRUD($this->main);

					$this->getFormData("c_codigo_dane", false);
					$this->getFormData("ciudad", false);
					$this->getFormData("d_codigo_dane", false);

					$resp = $ciudades->createCiudad(urldecode($this->c_codigo_dane), urldecode($this->ciudad), urldecode($this->d_codigo_dane));
					echo $resp;
					exit();
			    break;
			    case 'deleteCiudad':
					$this->loadModel("modules/".$this->rol."/ciudades/ciudades.cls",false);
					$ciudades = new ciudadesCRUD($this->main);

					$this->getFormData("codigo_dane", false);

					$resp = $ciudades->deleteCiudad(urldecode($this->codigo_dane));
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
