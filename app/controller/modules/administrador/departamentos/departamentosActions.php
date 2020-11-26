<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class departamentosActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));

			switch($accion){
				case 'updateDepartamento':
					$this->loadModel("modules/".$this->rol."/departamentos/departamentos.cls",false);
					$departamentos = new departamentosCRUD($this->main);

					$this->getFormData("orig_codigo_dane", false);
					$this->getFormData("codigo_dane", false);
					$this->getFormData("departamento", false);
					$this->getFormData("region_id", false);

					$resp = $departamentos->updateDepartamento(urldecode($this->orig_codigo_dane), urldecode($this->codigo_dane), urldecode($this->departamento), urldecode($this->region_id));
					echo $resp;
					exit();
				break;
				case 'createDepartamento':
					$this->loadModel("modules/".$this->rol."/departamentos/departamentos.cls",false);
					$departamentos = new departamentosCRUD($this->main);

					$this->getFormData("codigo_dane", false);
					$this->getFormData("departamento", false);
					$this->getFormData("region_id", false);

					$resp = $departamentos->createDepartamento(urldecode($this->codigo_dane), urldecode($this->departamento), urldecode($this->region_id));
					echo $resp;
					exit();
			    break;
			    case 'deleteDepartamento':
					$this->loadModel("modules/".$this->rol."/departamentos/departamentos.cls",false);
					$departamentos = new departamentosCRUD($this->main);

					$this->getFormData("codigo_dane", false);

					$resp = $departamentos->deleteDepartamento(urldecode($this->codigo_dane));
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
