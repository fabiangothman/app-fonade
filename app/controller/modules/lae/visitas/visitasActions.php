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
					$this->getFormData("proyecto_id", false);
					$this->getFormData("nombre", false);
					$this->getFormData("fecha", false);
					$this->getFormData("descripcion", false);
					$this->getFormData("documento_id", false);

					echo $visitas->updateVisita(urldecode($this->id), urldecode($this->proyecto_id), urldecode($this->nombre), urldecode($this->fecha), urldecode($this->descripcion), urldecode($this->documento_id));
					exit();
				break;
				case 'createVisitas':
					$this->loadModel("modules/".$this->rol."/visitas/visitas.cls",false);
					$visitas = new visitasCRUD($this->main);

					$this->getFormData("proyecto_id", false);
					$this->getFormData("fecha", false);
					$this->getFormData("descripcion", false);
					$this->getFormData("nombre", false);
					$this->getFormData("documento_id", false);
					$this->getFormData("primer_visita", false);

					if($this->primer_visita==true || $this->primer_visita==1 || $this->primer_visita=="1"){
						echo $visitas->createPrimeraVisitas(urldecode($this->proyecto_id), urldecode($this->fecha), urldecode($this->descripcion), urldecode($this->nombre), urldecode($this->documento_id), _VISTS_DAYS_, urldecode($this->fecha), 1);
					}else{
						$resp = $visitas->createVisita(urldecode($this->proyecto_id), urldecode($this->fecha), urldecode($this->descripcion), urldecode($this->nombre), urldecode($this->documento_id));
						if($resp)
							echo json_encode($resp);
						else
							echo $resp;
					}
					exit();
			    break;
			    case 'deleteVisitas':
					$this->loadModel("modules/".$this->rol."/visitas/visitas.cls",false);
					$visitas = new visitasCRUD($this->main);

					$this->getFormData("id", false);

					$resp = $visitas->deleteVisita(urldecode($this->id));
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
