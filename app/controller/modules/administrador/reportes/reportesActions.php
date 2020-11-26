<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class reportesActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;
			$accion = $this->convertNullToEmpty($this->getArg("accion"));
			$this->getFormData("emprendedores", false);
			$this->getFormData("ciudad_emprendedores", false);
			$this->getFormData("interventores", false);
			$this->getFormData("ciudad_interventores", false);
			$this->getFormData("proyectos", false);
			$this->getFormData("convocatorias", false);
			$this->getFormData("centros_negocios", false);
			$this->getFormData("ciudades_centro_negocios", false);
			$this->getFormData("visitas_start", false);
			$this->getFormData("visitas_end", false);

			switch($accion){
				case 'getReporte':
					$emprendedores = urldecode($this->emprendedores);
					$ciudad_emprendedores = urldecode($this->ciudad_emprendedores);
					$interventores = urldecode($this->interventores);
					$ciudad_interventores = urldecode($this->ciudad_interventores);
					$proyectos = urldecode($this->proyectos);
					$convocatorias = urldecode($this->convocatorias);
					$centros_negocios = urldecode($this->centros_negocios);
					$ciudades_centro_negocios = urldecode($this->ciudades_centro_negocios);
					$visitas_start = urldecode($this->visitas_start);
					$visitas_end = urldecode($this->visitas_end);

					if($this->validateCompleteInfo($emprendedores, $ciudad_emprendedores, $interventores, $ciudad_interventores, $proyectos, $convocatorias, $centros_negocios, $ciudades_centro_negocios)){
						/**/
						$this->loadModel("modules/".$this->rol."/reportes/reportes.cls",false);
						$reportes = new reportesCRUD($this->main);
						$reporteGenerado = $reportes->generarReporte($emprendedores, $ciudad_emprendedores, $interventores, $ciudad_interventores, $proyectos, $convocatorias, $centros_negocios, $ciudades_centro_negocios, $visitas_start, $visitas_end);
						echo $reporteGenerado;
						exit();
					}else{
						echo "false";
						exit();
					}					
				break;
			  	default:
			  	echo "false";
			    exit();
			}

		}

		private function validateCompleteInfo($emprendedores, $ciudad_emprendedores, $interventores, $ciudad_interventores, $proyectos, $convocatorias, $centros_negocios, $ciudades_centro_negocios){

			if($emprendedores!="" && $ciudad_emprendedores!="" && $interventores!="" && $ciudad_interventores!="" && $proyectos!="" && $convocatorias!="" && $centros_negocios!="" && $ciudades_centro_negocios!="")
				return true;
			else
				return false;

		}

		public function render()
		{
			return "";
		}
	}
?>
