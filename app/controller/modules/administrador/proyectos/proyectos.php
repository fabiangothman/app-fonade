<?php
	/****************************************************************************
	*	Desarrollado por: Fabi�n Murillo, fabianmurillo.01@gmail.com			*
	*					  � 2019												*
	****************************************************************************/

	class proyectos extends controller
	{
		private $rol;

		protected function index()
		{
			//Configuraci�n inicial
			$this->title = _MSFW_APP_NAME_." - Proyectos";
			$this->rol = $this->main->usuario_rol;
			
			//Carga todos los archivos requeridos en el view
			$this->addScript(true, $this->rol."/proyectos/proyectos");
			$this->addStyle("modules/".$this->rol."/proyectos/proyectos", "stylesheet", "screen");

			$this->loadModel("modules/".$this->rol."/proyectos/proyectos.cls",false);
			$proyectos = new proyectosCRUD($this->main);

			//Informacion a mostrar en front
			$this->listaProyectos = $proyectos->getProyectos();
			
			$this->listaEmprendedores = $proyectos->getEmprendedores();
			$this->listaInterventores = $proyectos->getInterventores();
			$this->listaConvocatorias = $proyectos->getConvocatorias();
			$this->listaCentroNegocios = $proyectos->getCentroNegocios();

			$this->addInReadyCode("
				MSProyectos.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."', ".json_encode($this->listaEmprendedores).", ".json_encode($this->listaInterventores).", ".json_encode($this->listaConvocatorias).", ".json_encode($this->listaCentroNegocios).", '".$this->rol."');
				//
			");
		}

		public function render()
		{
			return $this->printView("modules/".$this->rol."/proyectos/proyectos");
		}
	}
?>
