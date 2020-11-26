<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class visitasActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateVisitas':
					$this->loadModel("modules/".$this->rol."/visitas/visitas.cls",false);
					$visitas = new visitasCRUD($this->main);

					$this->getFormData("id", false);
					$this->getFormData("documento_id", false);

					echo $visitas->updateVisita(urldecode($this->id), urldecode($this->documento_id));
					exit();
				break;
			    case 'deleteVisitas':
					$this->loadModel("modules/".$this->rol."/visitas/visitas.cls",false);
					$visitas = new visitasCRUD($this->main);

					$this->getFormData("id", false);

					$resp = $visitas->updateVisita(urldecode($this->id), null);
					echo $resp;
					//echo json_encode($visitas->createVisita($x));
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
