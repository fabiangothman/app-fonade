<?php
	/****************************************************************************
	*	Desarrollado por: Fabi�n Murillo, fabianmurillo.01@gmail.com			*
	*					  � 2019												*
	****************************************************************************/

	class laesActions extends controller
	{
		private $rol;

		protected function index()
		{
			$this->rol = $this->main->usuario_rol;

		}

		public function render()
		{
			return "";
		}
	}
?>
