<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class centro_negociosActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateCentro_negocios':
					$this->loadModel("modules/".$this->rol."/centro_negocios/centro_negocios.cls",false);
					$centro_negocios = new centro_negociosCRUD($this->main);

					$this->getFormData("orig_id", false);
					$this->getFormData("id", false);
					$this->getFormData("ciudad_dane", false);
					$this->getFormData("nombre", false);
					$this->getFormData("descripcion", false);

					$resp = $centro_negocios->updateCentro_negocios(urldecode($this->orig_id), urldecode($this->id), urldecode($this->ciudad_dane), urldecode($this->nombre), urldecode($this->descripcion));
					echo $resp;
					exit();
				break;
				case 'createCentro_negocios':
					$this->loadModel("modules/".$this->rol."/centro_negocios/centro_negocios.cls",false);
					$centro_negocios = new centro_negociosCRUD($this->main);

					$this->getFormData("id", false);
					$this->getFormData("ciudad_dane", false);
					$this->getFormData("nombre", false);
					$this->getFormData("descripcion", false);

					$resp = $centro_negocios->createCentro_negocios(urldecode($this->id), urldecode($this->ciudad_dane), urldecode($this->nombre), urldecode($this->descripcion));
					echo $resp;
					exit();
			    break;
			    case 'deleteCentro_negocios':
					$this->loadModel("modules/".$this->rol."/centro_negocios/centro_negocios.cls",false);
					$centro_negocios = new centro_negociosCRUD($this->main);

					$this->getFormData("id", false);

					$resp = $centro_negocios->deleteCentro_negocios(urldecode($this->id));
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
