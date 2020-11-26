/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  © 2019												*
****************************************************************************/

// JavaScript Document
window.MSRoles = (function(window, document, undefined) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	rol = "" /* Rol actual del usuario en sesión */,
	creandoUsuario = false;
	MSRoles = {},
	owner = window,
	docElement = document.documentElement;
	
	MSRoles.init = function(_path, _model, _view, _rol){
		model = _model;
		view = path+_view;
		rol = _rol;
		//console.log(rol);
	}

	return MSRoles;
	
})(this, this.document);