<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class calendario extends controller
	{
		private $rol;

		protected function index()
		{

			//Configuración inicial
			$this->title = _MSFW_APP_NAME_." - Calendario";
			$this->rol = $this->main->usuario_rol;			
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/calendario/calendario");
			$this->addStyle("modules/".$this->rol."/calendario/calendario", "stylesheet", "screen");


			$this->loadModel("modules/".$this->rol."/calendario/calendario.cls",false);
			$calendario = new calendarioCRUD($this->main);
			$rangoFestivos = $calendario->getFestivosDate();
			$arrVisitas = $calendario->getIntrVisitas($this->main->usuario->id);

			//Informacion a mostrar en front
			$fecha = array(
				"Mes" => date("n"),
				"Ano" => date("Y"),
				"UltimoDiaMes" => date("d",(mktime(0,0,0,date("n")+1,1,date("Y"))-1)),
				"Dia" => date("j"),
				"DiaSemanaMes" => date("w",mktime(0,0,0,date("n"),1,date("Y")))
			);

			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			$this->fechaStr = $meses[date('n')-1]." del ".date("Y");

			$this->addInReadyCode("
				MSCalendario.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', ".json_encode($fecha).",".json_encode($rangoFestivos).",".json_encode($arrVisitas).", '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/calendario/calendario");
		}
	}
?>
