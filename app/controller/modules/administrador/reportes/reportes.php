<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class reportes extends controller
	{
		private $rol;

		protected function index()
		{
			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Reportes";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/reportes/reportes");
			$this->addStyle("modules/".$this->rol."/reportes/reportes", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/reportes/reportes.cls",false);
			$reportes = new reportesCRUD($this->main);

			/*Llamado a todos los controladores a usar en los reportes*/
			$this->loadModel("modules/".$this->rol."/emprendedores/emprendedores.cls",false);
			$emprendedores = new emprendedoresCRUD($this->main);
			$this->listaEmprendedores = $emprendedores->getEmprendedores();
			$this->listaCiudad_Emprendedores = $emprendedores->getCiudades_Emprendedores();

			$this->loadModel("modules/".$this->rol."/interventores/interventores.cls",false);
			$interventores = new interventoresCRUD($this->main);
			$this->listaInterventores = $interventores->getInterventores();
			$this->listaCiudad_Interventores = $interventores->getCiudades_Interventores();

			$this->loadModel("modules/".$this->rol."/proyectos/proyectos.cls",false);
			$proyectos = new proyectosCRUD($this->main);
			$this->listaProyectos = $proyectos->getOnlyProyectos();
			$this->listaConvocatoria_Proyectos = $proyectos->getConvocatorias_Proyectos();
			$this->listaCentro_Negocio_Proyectos = $proyectos->getCentro_Negocios_Proyectos();
			$this->listaCiudades_Centro_Negocio_Proyectos = $proyectos->getCiudades_Centro_Negocios_Proyectos();
			$this->listaVisitas_Proyectos = $proyectos->getVisitas_Proyectos();


			//Muestra todos los reportes de la carpeta
			$pathExports = 'exports/';
			$files = array_diff(scandir($pathExports), array('.', '..', 'readme.txt'));

			$listadoArchivos = array();
			foreach ($files as $key => $file){
				if(is_file($pathExports.$file)){
					array_push($listadoArchivos,
						array('fecha'=>date("Y-m-d H:i:s", filemtime($pathExports.$file)),
							'nombre'=>$file,
							"url"=>_MSFW_PATH_.$pathExports.$file));
				}
			}
			
			$this->listadoArchivos = $listadoArchivos;

			$this->addInReadyCode("
				MSReportes.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/reportes/reportes");
		}
	}
?>
