/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  © 2019												*
****************************************************************************/

// JavaScript Document
window.MSCargaCSV = (function(window, document, undefined) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	rol = "" /* Rol actual del usuario en sesión */,
	procesando = false	/*Evalua si esta procesando una peticion de reporte*/,
	MSCargaCSV = {},
	jfcalplugin = null;
	owner = window,
	docElement = document.documentElement;
	
	MSCargaCSV.init = function(_path, _model, _view, _rol){
		path = _path;
		model = _model;
		view = path+_view;
		rol = _rol;
	}

	return MSCargaCSV;
	
})(this, this.document);