/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  © 2019												*
****************************************************************************/

// JavaScript Document
window.MSReportes = (function(window, document, undefined) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	procesando = false	/*Evalua si esta procesando una peticion de reporte*/,
	rol = "" /* Rol actual del usuario en sesión */,
	MSReportes = {},
	jfcalplugin = null;
	owner = window,
	docElement = document.documentElement;
	
	MSReportes.init = function(_path, _model, _view, _rol){
		path = _path;
		model = _model;
		view = path+_view;
		rol = _rol;

		MSReportes.initializeDataPickers();
		MSReportes.initializeEventsListener();
	}

	MSReportes.initializeEventsListener = function(){
		$("#btn_generar").on("click", function(){
			if(!procesando){
				var arrayListSend = [
					$("#reportes_container #emprendedores option:selected"),
					$("#reportes_container #ciudad_emprendedores option:selected"),
					$("#reportes_container #interventores option:selected"),
					$("#reportes_container #ciudad_interventores option:selected"),
					$("#reportes_container #proyectos option:selected"),
					$("#reportes_container #convocatorias option:selected"),
					$("#reportes_container #centros_negocios option:selected"),
					$("#reportes_container #ciudades_centro_negocios option:selected"),
					$("#reportes_container #visita_start"),
					$("#reportes_container #visita_end")]
				;
				MSReportes.getServerInfo(arrayListSend);
			}

		});
	}

	MSReportes.getServerInfo = function(arrayListSend){
		var sendParams = {
			"emprendedores": encodeURI(arrayListSend[0].val()),
			"ciudad_emprendedores": encodeURI(arrayListSend[1].val()),
			"interventores": encodeURI(arrayListSend[2].val()),
			"ciudad_interventores": encodeURI(arrayListSend[3].val()),
			"proyectos": encodeURI(arrayListSend[4].val()),
			"convocatorias": encodeURI(arrayListSend[5].val()),
			"centros_negocios": encodeURI(arrayListSend[6].val()),
			"ciudades_centro_negocios": encodeURI(arrayListSend[7].val()),
			"visitas_start": encodeURI(arrayListSend[8].val()),
			"visitas_end": encodeURI(arrayListSend[9].val())
        };
        //console.log(sendParams);
        $.ajax({
        	data: sendParams,
        	url: path+"modules/"+rol+"/reportes/reportesActions/accion/getReporte/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		procesando = true;
        		$("#btn_generar").addClass("procesando");
        	},
        	success: function(response){ //una vez que el archivo recibe el request lo procesa y lo devuelve
        		console.log(response);
        		procesando = false;
        		$("#btn_generar").removeClass("procesando");
        		$("#link_descarga").attr('href',response).html(response);
        		$("#cont_descarga").css("display","block");
        	}
        });
	}

	MSReportes.initializeDataPickers = function(){
		var currDate = new Date();
		var format = MSReportes.addCeros(currDate.getFullYear())+"-"+MSReportes.addCeros(currDate.getMonth())+"-"+MSReportes.addCeros(currDate.getDate())+" "+MSReportes.addCeros(currDate.getHours())+":"+MSReportes.addCeros(currDate.getMinutes())+":"+MSReportes.addCeros(currDate.getSeconds());

		$("#visita_start").datetimepicker({
    		dateFormat:'yy-mm-dd',
    		timeFormat: 'HH:mm:ss'
    	});
		$("#visita_end").datetimepicker({
    		dateFormat:'yy-mm-dd',
    		timeFormat: 'HH:mm:ss'
    	});
    	//$("#visita_start").val(format);
    	//$("#visita_end").val(format);
	}

	MSReportes.addCeros = function(num){
		if(num>=0 && num<=9)
			return ("0"+num);
		else
			return num;
	}

	return MSReportes;
	
})(this, this.document);