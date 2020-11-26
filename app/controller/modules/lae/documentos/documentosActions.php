<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class documentosActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateDocumento':
					$this->loadModel("modules/".$this->rol."/documentos/documentos.cls",false);
					$documentos = new documentosCRUD($this->main);

					$this->getFormData("id", false);
					$this->getFormData("nombre_unico", false);
					$this->getFormData("usuario_id", false);

					//Si el archivo lo lee $_FILES quiere decir que se adjunto, de lo contrario no adjuntaron nada
					if(isset($_FILES['file'])){
						$file = $_FILES['file'];
						$allFileName = "user_".$this->usuario_id."_file_".time().".".pathinfo($file["name"], PATHINFO_EXTENSION);
						$this->createSaveFolderIfNotExists($this->usuario_id);
				        if(move_uploaded_file($file["tmp_name"], "documentos/".$this->usuario_id."/".$allFileName))
				        	if($documentos->updateDocumento(urldecode($this->id), urldecode($this->nombre_unico), $this->usuario_id."/".$allFileName, urldecode($this->usuario_id)))
				        		$resp = $this->usuario_id."/".$allFileName;
				        	else
				        		$resp = false;
				        else
				        	$resp = false;
				    }else if(isset($_POST["file"])){
				    	$resp = $documentos->updateDocumentoSinEnlace(urldecode($this->id), urldecode($this->nombre_unico), urldecode($this->usuario_id));
				    }else{
				    	$resp = false;
				    }
					echo $resp;
					exit();
				break;
				case 'createDocumento':
					$this->loadModel("modules/".$this->rol."/documentos/documentos.cls",false);
					$documentos = new documentosCRUD($this->main);

					$this->getFormData("nombre_unico", false);
					$this->getFormData("usuario_id", false);

					//Si el archivo lo lee $_FILES quiere decir que se adjunto, de lo contrario no adjuntaron nada
					if(isset($_FILES['file'])){
						$file = $_FILES['file'];
						$allFileName = "user_".$this->usuario_id."_file_".time().".".pathinfo($file["name"], PATHINFO_EXTENSION);
						$this->createSaveFolderIfNotExists($this->usuario_id);
				        if(move_uploaded_file($file["tmp_name"], "documentos/".$this->usuario_id."/".$allFileName)){
				        	$id_documento = $documentos->createDocumento(urldecode($this->nombre_unico), $this->usuario_id."/".$allFileName, urldecode($this->usuario_id));
				        	if($id_documento)
				        		$resp = json_encode(array("link"=>$this->usuario_id."/".$allFileName, "id"=>$id_documento));
				        	else
				        		$resp = false;
				        }else{
				        	$resp = false;
				        }
				    }else{
				    	$resp = false;
				    }
					echo $resp;
					exit();
			    break;
			    case 'deleteDocumento':
					$this->loadModel("modules/".$this->rol."/documentos/documentos.cls",false);
					$documentos = new documentosCRUD($this->main);

					$this->getFormData("id", false);

					$resp = $documentos->deleteDocumento(urldecode($this->id));
					echo $resp;
					exit();
			    break;
			  default:
			  	echo false;
			    return false;
			    exit();
			}

		}

		private function createSaveFolderIfNotExists($dirname){
			$filename = "documentos/" . $dirname . "/";
			if (!file_exists($filename)) {
			    mkdir("documentos/" . $dirname, 0777);
			}
		}

		public function render()
		{
			return "";
		}
	}
?>
