/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  © 2019												*
****************************************************************************/

// JavaScript Document
window.MSHeader = (function( window, document, undefined ) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	MSHeader = {},
	owner = window,
	docElement = document.documentElement;

	MSHeader.init = function(_path, _model, _view, tamanoVentana){
		path = _path;
		model = _model;
		view = _view;
	}

	MSHeader.navegar = function(url){
		window.location.href = url;
	}

	MSHeader.mostrarMensaje = function(mensaje, tipo){
		if($('#header_container .notify_content .'+tipo).css("display")=="none"){
			$('#header_container .notify_content .'+tipo+' .mensajeMostrar').html(mensaje);
			$('html, body').animate({ scrollTop: $("#header_container").offset().top }, 500);
			$('#header_container .notify_content .'+tipo).fadeIn(500).delay(3000).fadeOut(500);
		}
	}

	MSHeader.isEmail = function(email){
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  		return regex.test(email);
	}

	MSHeader.utf8_decode = function(s){
		return decodeURIComponent(escape(s));
	}

	MSHeader.utf8_encode = function(s){
		return unescape(encodeURIComponent(s));
	}

	return MSHeader;
	
})(this, this.document);