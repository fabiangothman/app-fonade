/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  © 2019												*
****************************************************************************/

// JavaScript Document
window.MSCalendario = (function(window, document, undefined) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	dateCheck = "" /*	Variable para determinar una fecha a calcular festivos	*/,
	rangoFestivos = null 	/*Contiene los dias festivos de la bd*/,
	arrVisitas = null 	/*Contiene las visitas de la bd*/,
	rol = "" /* Rol actual del usuario en sesión */,
	MSCalendario = {},
	jfcalplugin = null;
	owner = window,
	docElement = document.documentElement;
	
	MSCalendario.init = function(_path, _model, _view, arrFecha, _rangoFestivos, _arrVisitas, _rol){
		path = _path;
		model = _model;
		view = path+_view;
		rangoFestivos = _rangoFestivos;
		arrVisitas = _arrVisitas;
		rol = _rol;

		//Construye el calendario según los parámetros
		MSCalendario.contruirCalendarioMesActual(parseInt(arrFecha.UltimoDiaMes), parseInt(arrFecha.DiaSemanaMes), parseInt(arrFecha.Ano), parseInt(arrFecha.Mes), parseInt(arrFecha.Dia));
	}

	MSCalendario.addMonthChangeListener = function(anoActual, mesActual){
		$("#calendario_container .selector").unbind('click').on("click", function(){
			if($(this).attr("action")=="anterior"){
				var parametros = {
					"anoActual": anoActual,
					"mesActual": mesActual
		        };
		        //console.log(parametros);
		        $.ajax({
		        	data: parametros,
		        	url: path+"modules/"+rol+"/calendario/calendarioActions/accion/anterior/[iframe]/", //archivo que recibe la peticion
		        	type: 'POST',
		        	beforeSend: function(){
		        		//console.log("updateVisitas: Procesando ...");
		        	},
		        	success: function(response){ //una vez que el archivo recibe el request lo procesa y lo devuelve
		        		//console.log(response);
		        		response = JSON.parse(response);
		        		if(response.diaPrev)
		        			response.diaPrev = parseInt(response.diaPrev);

		        		MSCalendario.contruirCalendarioMesActual(parseInt(response.ultimoDiaDelMes), parseInt(response.diaDeLaSemanaInicial), parseInt(response.anoPrev), parseInt(response.mesPrev), response.diaPrev, response.fechaStr);
		        	}
		        });
			}
			if($(this).attr("action")=="siguiente"){
				var parametros = {
					"anoActual": anoActual,
					"mesActual": mesActual
		        };
		        //console.log(parametros);
		        $.ajax({
		        	data: parametros,
		        	url: path+"modules/"+rol+"/calendario/calendarioActions/accion/siguiente/[iframe]/", //archivo que recibe la peticion
		        	type: 'POST',
		        	beforeSend: function(){
		        		//console.log("updateVisitas: Procesando ...");
		        	},
		        	success: function(response){ //una vez que el archivo recibe el request lo procesa y lo devuelve
		        		//console.log(response);
		        		response = JSON.parse(response);
		        		if(response.diaNext)
		        			response.diaNext = parseInt(response.diaNext);

		        		MSCalendario.contruirCalendarioMesActual(parseInt(response.ultimoDiaDelMes), parseInt(response.diaDeLaSemanaInicial), parseInt(response.anoNext), parseInt(response.mesNext), response.diaNext, response.fechaStr);
		        	}
		        });
			}
		});
	}

	MSCalendario.contruirCalendarioMesActual = function(ultimoDiaDelMes, diaDeLaSemanaInicial, anoActual, mesActual, diaActual, fechaStr = null){
		//Inicia listener de botones de cambio de mes
		MSCalendario.addMonthChangeListener(anoActual, mesActual);

		var day=0;
		$("#table_calendario tr:eq(0)").nextAll().remove();
		if(fechaStr)
			$("#calendario_container #fechaStr h2").html(fechaStr);

		var acumHtml = "<tr>";
		for (var i = 1; i <= (ultimoDiaDelMes+diaDeLaSemanaInicial); i++) {
			//console.log(i);
			if(i==diaDeLaSemanaInicial+1){
				// determinamos en que los dias reales empiezan
				day=1;
			}
			if(day==0){
				acumHtml += "<td class='mesPasado'></td>";
			}else{
				if(MSCalendario.esFestivo(anoActual, mesActual, day)){
					if(day==diaActual)
						acumHtml += "<td ano='"+anoActual+"' mes='"+mesActual+"' dia='"+day+"' id="+anoActual+mesActual+day+" class='festivo hoy'><div class='cont_caja'><div class='cont_dia'>"+day+"</div><div class='cont_eventos'>"+MSCalendario.getEvents(anoActual, mesActual, day)+"</div></div></td>";
					else
						acumHtml += "<td ano='"+anoActual+"' mes='"+mesActual+"' dia='"+day+"' id="+anoActual+mesActual+day+" class='festivo'><div class='cont_caja'><div class='cont_dia'>"+day+"</div><div class='cont_eventos'>"+MSCalendario.getEvents(anoActual, mesActual, day)+"</div></div></td>";
				}else{
					if(day==diaActual)
						acumHtml += "<td ano='"+anoActual+"' mes='"+mesActual+"' dia='"+day+"' id="+anoActual+mesActual+day+" class='hoy'><div class='cont_caja'><div class='cont_dia'>"+day+"</div><div class='cont_eventos'>"+MSCalendario.getEvents(anoActual, mesActual, day)+"</div></div></td>";
					else
						acumHtml += "<td ano='"+anoActual+"' mes='"+mesActual+"' dia='"+day+"' id="+anoActual+mesActual+day+" class='diaNormal'><div class='cont_caja'><div class='cont_dia'>"+day+"</div><div class='cont_eventos'>"+MSCalendario.getEvents(anoActual, mesActual, day)+"</div></div></td>";
				}
				day++;
			}
			if(i % 7 == 0){
				acumHtml += "</tr><tr>";
			}
		}
		acumHtml += "</tr>";
		$("#table_calendario tr:last").after(acumHtml);

		//Busca los td con eventos y activa la ampliación de su información
		MSCalendario.listenerAmpliarInformacion();
	}

	MSCalendario.esFestivo = function(ano, mes, dia){
		dateCheck = new Date(ano, (mes-1), dia);
		dayIndex = dateCheck.getDay();

		if(dayIndex==0){
			//Es domingo
			return true;
		}else if(MSCalendario.diasFestivosColombia(ano, MSCalendario.addCeros(mes), MSCalendario.addCeros(dia))){
			//Dias festivos de Colombia 2018-2021
			return true;
		}else{
			return false;
		}
	}

	MSCalendario.diasFestivosColombia = function(ano, mes, dia){
		//console.log(rangoFestivos);
		var retorno = false;
		$.each(rangoFestivos, function(i, item){
		    if(item.fecha==(ano+"-"+mes+"-"+dia)){
		    	retorno = true;
		    }
		});
		return retorno;
	}

	MSCalendario.getEvents = function(ano, mes, dia){
		var eventos = "";
		$.each(MSCalendario.getEventsNameByDate(ano, MSCalendario.addCeros(mes), MSCalendario.addCeros(dia)), function(i, evento){
		    eventos += "<div class='evento'>"+evento+"</div>";
		});

		return eventos;
	}

	MSCalendario.listenerAmpliarInformacion = function(){
		$.each($("td .evento").closest('td'), function(i, item){
		    $(this).unbind('click').on("click", function(){
		    	$("#myModal .title .text").html("Visitas para el "+$(this).attr("ano")+"/"+$(this).attr("mes")+"/"+$(this).attr("dia"));
		    	MSCalendario.ampliarInfo(MSCalendario.getEventsByDate($(this).attr("ano"), MSCalendario.addCeros($(this).attr("mes")), MSCalendario.addCeros($(this).attr("dia"))));
			});
		});
	}

	MSCalendario.ampliarInfo = function(arrEvents){
		$("#myModal #contenido").html("");
		MSCalendario.activarModal();
		var html = "";
		$.each(arrEvents, function(i, evento){
			html += "<div class='modal_evento'>";
			html += "<div class='campo'><label>Nombre visita:</label><span> "+evento.nombre+"</span></div>";
			html += "<div class='campo'><label>Descripción:</label><span> "+evento.descripcion+"</span></div>";
			html += "<div class='campo'><label>Fecha:</label><span> "+evento.fecha_real+"</span></div>";
			html += "<div class='campo'><label>ID de proyecto:</label><span> "+evento.proyecto_id+"</span></div>";
			html += "<div class='campo'><label>Nombre de proyecto:</label><span> "+evento.proy_nombre+"</span></div>";
			html += "<div class='campo'><label>Emprendedor:</label><span> "+evento.empr_nombres+" "+evento.empr_apellidos+"</span></div>";
			html += "<div class='campo'><label>Teléfono:</label><span> "+evento.empr_telefono+"</span></div>";
			html += "<div class='campo'><label>Contacto:</label><span> "+evento.empr_contacto+"</span></div>";
			html += "<div class='campo'><label>Interventor:</label><span> "+evento.intr_nombres+" "+evento.intr_apellidos+"</span></div>";
			/*html += evento.id;
			html += evento.documento_id;*/
			html += "</div><hr>";
		});

		$("#myModal #contenido").html(html);
	}

	MSCalendario.activarModal = function(){
		$("#myModal").css("display", "block");

		$("#myModal .cerrar").on("click", function(){
			$("#myModal").css("display", "none");
		});

		$(window).on("click", function(event){
			if(event.target == $("#myModal")[0]) {
				$("#myModal").css("display", "none");
			}
		});
	}

	MSCalendario.getEventsByDate = function(ano, mes, dia){
		var retorno = new Array();
		$.each(arrVisitas, function(i, item){
		    if(item.fecha==(ano+"-"+mes+"-"+dia)){
		    	retorno.push(item);
		    }
		});
		return retorno;
	}

	MSCalendario.getEventsNameByDate = function(ano, mes, dia){
		var retorno = new Array();
		$.each(arrVisitas, function(i, item){
		    if(item.fecha==(ano+"-"+mes+"-"+dia)){
		    	retorno.push(item.nombre);
		    }
		});
		return retorno;
	}

	MSCalendario.addCeros = function(num){
		if(num>=0 && num<=9)
			return ("0"+num);
		else
			return num;
	}

	return MSCalendario;
	
})(this, this.document);