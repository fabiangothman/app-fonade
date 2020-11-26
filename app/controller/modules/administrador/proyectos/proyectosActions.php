<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class proyectosActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateProyecto':
					$this->loadModel("modules/".$this->rol."/proyectos/proyectos.cls",false);
					$proyectos = new proyectosCRUD($this->main);

					$this->getFormData("orig_id", false);
					$this->getFormData("id", false);
					$this->getFormData("nombre", false);
					$this->getFormData("objetivo", false);
					$this->getFormData("fecha_asignacion", false);
					$this->getFormData("numero_contrato", false);
					$this->getFormData("emprendedor_id", false);
					$this->getFormData("interventor_id", false);
					$this->getFormData("convocatoria_numero", false);
					$this->getFormData("centro_negocios_id", false);

					$resp = $proyectos->updateProyecto(urldecode($this->orig_id), urldecode($this->id), urldecode($this->nombre), urldecode($this->objetivo), urldecode($this->fecha_asignacion), urldecode($this->numero_contrato), urldecode($this->emprendedor_id), urldecode($this->interventor_id), urldecode($this->convocatoria_numero), urldecode($this->centro_negocios_id));
					echo $resp;
					//echo json_encode($proyectos->updateProyecto($x));
					exit();
				break;
				case 'createProyecto':
					$this->loadModel("modules/".$this->rol."/proyectos/proyectos.cls",false);
					$proyectos = new proyectosCRUD($this->main);

					$this->getFormData("id", false);
					$this->getFormData("nombre", false);
					$this->getFormData("objetivo", false);
					$this->getFormData("fecha_asignacion", false);
					$this->getFormData("numero_contrato", false);
					$this->getFormData("emprendedor_id", false);
					$this->getFormData("interventor_id", false);
					$this->getFormData("convocatoria_numero", false);
					$this->getFormData("centro_negocios_id", false);

					$resp = $proyectos->createProyecto(urldecode($this->id), urldecode($this->nombre), urldecode($this->objetivo), urldecode($this->fecha_asignacion), urldecode($this->numero_contrato), urldecode($this->emprendedor_id), urldecode($this->interventor_id), urldecode($this->convocatoria_numero), urldecode($this->centro_negocios_id));
					echo $resp;
					//echo json_encode($proyectos->createProyecto($x));
					exit();
			    break;
			    case 'deleteProyecto':
					$this->loadModel("modules/".$this->rol."/proyectos/proyectos.cls",false);
					$proyectos = new proyectosCRUD($this->main);

					$this->getFormData("id", false);

					$resp = $proyectos->deleteProyecto(urldecode($this->id));
					echo $resp;
					//echo json_encode($proyectos->createProyecto($x));
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
