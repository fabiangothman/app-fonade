<?php
	/******************************************************/
	/*	Desarrollado por: Fabi�n Murillo � 2017	*/
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