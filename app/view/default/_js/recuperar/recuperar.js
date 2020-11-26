/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  Juan Suárez, juancsuarezg@correo.udistrital.edu.co	*
*					  © 2017												*
****************************************************************************/

// JavaScript Document
window.MSRecuperar = (function( window, document, undefined ) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	MSRecuperar = {},
	owner = window,
	docElement = document.documentElement;
	
	MSRecuperar.init = function(_path, _model, _view){
		path = _path;
		model = _model;
		view = _view;
	}

	return MSRecuperar;
	
})(this, this.document);