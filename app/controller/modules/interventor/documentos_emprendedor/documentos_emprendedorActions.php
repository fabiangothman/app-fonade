<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class documentos_emprendedorActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateDocumento_emprendedor':
					$this->loadModel("modules/".$this->rol."/documentos_emprendedor/documentos_emprendedor.cls",false);
					$documentos_emprendedor = new documentos_emprendedorCRUD($this->main);

					$this->getFormData("id", false);
					$this->getFormData("proyecto_id", false);
					$this->getFormData("requerimiento", false);
					$this->getFormData("documento_id", false);

					echo $documentos_emprendedor->updateDocumento_emprendedor(urldecode($this->id), urldecode($this->proyecto_id), urldecode($this->requerimiento), urldecode($this->documento_id));
					exit();
				break;
				case 'createDocumento_emprendedor':
					$this->loadModel("modules/".$this->rol."/documentos_emprendedor/documentos_emprendedor.cls",false);
					$documentos_emprendedor = new documentos_emprendedorCRUD($this->main);

					$this->getFormData("proyecto_id", false);
					$this->getFormData("requerimiento", false);
					$this->getFormData("documento_id", false);

					$resp = $documentos_emprendedor->createDocumento_emprendedor(urldecode($this->proyecto_id), urldecode($this->requerimiento), urldecode($this->documento_id));
					if($resp)
						echo json_encode($resp);
					else
						echo $resp;
					//echo json_encode($documentos_emprendedor->createDocumento_emprendedor($x));
					exit();
			    break;
			    case 'deleteDocumento_emprendedor':
					$this->loadModel("modules/".$this->rol."/documentos_emprendedor/documentos_emprendedor.cls",false);
					$documentos_emprendedor = new documentos_emprendedorCRUD($this->main);

					$this->getFormData("id", false);

					$resp = $documentos_emprendedor->deleteDocumento_emprendedor(urldecode($this->id));
					echo $resp;
					//echo json_encode($documentos_emprendedor->deleteDocumento_emprendedor($x));
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
