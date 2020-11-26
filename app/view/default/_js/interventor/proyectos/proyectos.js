/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  © 2019												*
****************************************************************************/

// JavaScript Document
window.MSProyectos = (function(window, document, undefined) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	rol = "" /* Rol actual del usuario en sesión */,
	MSProyectos = {},
	owner = window,
	docElement = document.documentElement;
	
	MSProyectos.init = function(_path, _model, _view, _rol){
		path = _path;
		model = _model;
		view = path+_view;
		rol = _rol;

	}

	return MSProyectos;
	
})(this, this.document);