<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class cargacsv extends controller
	{
		private $rol;

		protected function index()
		{

			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Carga CSV";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/cargacsv/cargacsv");
			$this->addStyle("modules/".$this->rol."/cargacsv/cargacsv", "stylesheet", "screen");

			$this->formatobase = _MSFW_PATH_."formats/cargacsv_format.csv";
			$this->ir_cargacsvActions = _MSFW_PATH_."modules/".$this->rol."/cargacsv/cargacsvActions/[iframe]/";


			$this->addInReadyCode("
				MSCargaCSV.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."' ,'".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/cargacsv/cargacsv");
		}
	}
?>
