/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  © 2019												*
****************************************************************************/

// JavaScript Document
window.MSPerfil = (function( window, document, undefined) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	rol = "" /* Rol actual del usuario en sesión */,
	MSPerfil = {},
	owner = window,
	docElement = document.documentElement;
	
	MSPerfil.init = function(_path, _model, _view, _rol){
		path = _path;
		model = _model;
		view = path+_view;
		rol = _rol;
	}

	return MSPerfil;
	
})(this, this.document);