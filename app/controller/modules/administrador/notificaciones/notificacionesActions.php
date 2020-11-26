<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class notificacionesActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateNotificaciones':
					$this->loadModel("modules/".$this->rol."/notificaciones/notificaciones.cls",false);
					$notificaciones = new notificacionesCRUD($this->main);

					$this->getFormData("id", false);
					$this->getFormData("ID_plan_negocio", false);
					$this->getFormData("fecha", false);
					$this->getFormData("descripcion", false);
					$this->getFormData("nombre", false);
					$this->getFormData("id_doc", false);

					$resp = $notificaciones->updateNotificacion(urldecode($this->id), urldecode($this->ID_plan_negocio), urldecode($this->fecha), urldecode($this->descripcion), urldecode($this->nombre), urldecode($this->id_doc));
					echo $resp;
					//echo json_encode($notificaciones->updateNotificacion($x));
					exit();
				break;
				case 'createNotificaciones':
					$this->loadModel("modules/".$this->rol."/notificaciones/notificaciones.cls",false);
					$notificaciones = new notificacionesCRUD($this->main);

					$this->getFormData("ID_plan_negocio", false);
					$this->getFormData("fecha", false);
					$this->getFormData("descripcion", false);
					$this->getFormData("nombre", false);
					$this->getFormData("id_doc", false);

					$resp = $notificaciones->createNotificacion(urldecode($this->ID_plan_negocio), urldecode($this->fecha), urldecode($this->descripcion), urldecode($this->nombre), urldecode($this->id_doc));
					echo $resp;
					//echo json_encode($notificaciones->createNotificacion($x));
					exit();
			    break;
			    case 'deleteNotificaciones':
					$this->loadModel("modules/".$this->rol."/notificaciones/notificaciones.cls",false);
					$notificaciones = new notificacionesCRUD($this->main);

					$this->getFormData("id", false);

					$resp = $notificaciones->deleteNotificacion(urldecode($this->id));
					echo $resp;
					//echo json_encode($notificaciones->createNotificacion($x));
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
