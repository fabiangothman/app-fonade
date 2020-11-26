<?php
	/******************************************************/
	/*	Desarrollado por: Fabián Murillo © 2017	*/
	/******************************************************/
	
	class footer extends controller
	{
		protected function index()
		{
			// Carga de archivos requeridos en el view
			$this->addStyle("common/footer", "stylesheet", "screen");
		}
		
		public function render()
		{
			$output = $this->printView("common/footer");
			foreach($this->subControllers as $unSubController)
			{
				$output .= $unSubController->render();
			}
			return $output;
		}
	}
?>