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
					$this->getFormData("documento_id", false);

					echo $documentos_emprendedor->updateDocumento_emprendedor(urldecode($this->id), urldecode($this->documento_id));
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
