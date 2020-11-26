<?php
	/******************************************************/
	/*	Desarrollado por: Fabián Murillo © 2017	*/
	/******************************************************/
	
	class header_iframe extends controller
	{
		protected function index()
		{
			$this->data = $this->header_data;

		}
		public function render()
		{
			return "";
		}
	}
?>