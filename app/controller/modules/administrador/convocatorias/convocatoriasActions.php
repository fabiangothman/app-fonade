<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class convocatoriasActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateConvocatoria':
					$this->loadModel("modules/".$this->rol."/convocatorias/convocatorias.cls",false);
					$convocatorias = new convocatoriasCRUD($this->main);

					$this->getFormData("orig_numero", false);
					$this->getFormData("numero", false);
					$this->getFormData("fecha", false);
					$this->getFormData("descripcion", false);

					$resp = $convocatorias->updateConvocatoria(urldecode($this->orig_numero), urldecode($this->numero), urldecode($this->fecha), urldecode($this->descripcion));
					echo $resp;
					//echo json_encode($convocatorias->updateConvocatoria($x));
					exit();
				break;
				case 'createConvocatoria':
					$this->loadModel("modules/".$this->rol."/convocatorias/convocatorias.cls",false);
					$convocatorias = new convocatoriasCRUD($this->main);

					$this->getFormData("numero", false);
					$this->getFormData("fecha", false);
					$this->getFormData("descripcion", false);

					$resp = $convocatorias->createConvocatoria(urldecode($this->numero), urldecode($this->fecha), urldecode($this->descripcion));
					echo $resp;
					//echo json_encode($convocatorias->createConvocatoria($x));
					exit();
			    break;
			    case 'deleteConvocatoria':
					$this->loadModel("modules/".$this->rol."/convocatorias/convocatorias.cls",false);
					$convocatorias = new convocatoriasCRUD($this->main);

					$this->getFormData("numero", false);

					$resp = $convocatorias->deleteConvocatoria(urldecode($this->numero));
					echo $resp;
					//echo json_encode($convocatorias->createConvocatoria($x));
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
