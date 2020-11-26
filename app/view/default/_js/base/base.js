/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  Juan Suárez, juancsuarezg@correo.udistrital.edu.co	*
*					  © 2017												*
****************************************************************************/

// JavaScript Document
window.MSBase = (function( window, document, undefined ) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	MSBase = {},
	owner = window,
	docElement = document.documentElement;
	
	MSBase.init = function(_path, _model, _view, tamanoVentana){
		path = _path;
		model = _model;
		view = _view;
		MSBase.cambiar_responsive(tamanoVentana);
	}

	MSBase.cambiar_responsive = function(tamanoVentana){
		if(tamanoVentana<600){
			$("#tipo_visualizacion").attr("class", "areaNavegacionResponsive");
		}else{
			$("#tipo_visualizacion").attr("class", "areaNavegacionEscritorio");
		}
	}

	MSBase.navegar = function(url){
		window.location.href = url;
	}

	return MSBase;
	
})(this, this.document);