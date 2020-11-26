/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  © 2019												*
****************************************************************************/

// JavaScript Document
window.MSVisitas = (function(window, document, undefined) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	listaDocumentos = "" /*Array de objetos de tipo documento */,
	listaProyectos = "" /*Array de objetos de tipo proyecto */,
	rol = "" /* Rol actual del usuario en sesión */,
	MSVisitas = {},
	owner = window,
	docElement = document.documentElement;
	
	MSVisitas.init = function(_path, _model, _view, _listaProyectos, _listaDocumentos, _rol){
		path = _path;
		model = _model;
		view = path+_view;
		listaDocumentos = _listaDocumentos;
		listaProyectos = _listaProyectos;
		rol = _rol;

		MSVisitas.cargarLiveEdit();
	}	

	MSVisitas.updateVisitas = function(arrayListSend, tr_Obj){
		//console.log(arrayListSend);return false;
		var parametros = {
			"id": encodeURI(arrayListSend[0]),
			"proyecto_id": encodeURI(arrayListSend[1]),
			"nombre": encodeURI(arrayListSend[2]),
			"fecha": encodeURI(arrayListSend[3]),
			"descripcion": encodeURI(arrayListSend[4]),
			"documento_id": encodeURI(arrayListSend[5])
        };
        //console.log(parametros);
        $.ajax({
        	data: parametros,
        	url: path+"modules/"+rol+"/visitas/visitasActions/accion/updateVisitas/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("updateVisitas: Procesando ...");
        	},
        	success: function(response){ //una vez que el archivo recibe el request lo procesa y lo devuelve
        		//console.log(response);return false;
        		if(response){
        			MSHeader.mostrarMensaje("Se han actualizado los registros con éxito.", "alert-success");
        			if(response!="null")
        				$(tr_Obj).find("td[field=documento_id]").html($(tr_Obj).find("td[field=documento_id]").html()+" - <a href='"+path+"documentos/"+response+"' target='_blank' download>"+response+"</a>");
        		}else{
        			MSHeader.mostrarMensaje("Error al actualizar: Por favor verifique los campos.", "alert-danger");
        		}


        	}
        });
	}

	MSVisitas.createVisitas = function(arrayListSend, tr_Obj){
		if(arrayListSend[6]==true)
			arrayListSend[6]=1;
		else
			arrayListSend[6]=0;

		var parametros = {
			"proyecto_id": encodeURI(arrayListSend[1]),
			"nombre": encodeURI(arrayListSend[2]),
			"fecha": encodeURI(arrayListSend[3]),
			"descripcion": encodeURI(arrayListSend[4]),
			"documento_id": encodeURI(arrayListSend[5]),
			"primer_visita": encodeURI(arrayListSend[6])
        };
        //console.log(parametros);
        $.ajax({
        	data: parametros,
        	url: path+"modules/"+rol+"/visitas/visitasActions/accion/createVisitas/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("createVisitas: Procesando ...");
        	},
        	success: function(response){ //una vez que el archivo recibe el request lo procesa y lo devuelve
        		//Si es la primer visita va a recargar la pagina para que se vean las visitas adicionales que se crearán
        		$(tr_Obj).find("td[fieldtype=checkbox]").remove();
        		if(parametros.primer_visita==true){
	        		$(tr_Obj).html("Cargando ...");
	        		location.href = path+"modules/"+rol+"/visitas/visitas/mensaje/16";
        		}else{
	        		if(response){
	        			var objResponse = $.parseJSON(response);
	        			MSHeader.mostrarMensaje("Se ha creado el nuevo registro con éxito.", "alert-success");
	        			$(tr_Obj).attr("id", encodeURI(objResponse.id));
	        			if(objResponse.enlace)
	        				$(tr_Obj).find("td[field=documento_id]").html($(tr_Obj).find("td[field=documento_id]").html()+" - <a href='"+path+"documentos/"+objResponse.enlace+"' target='_blank' download>"+objResponse.enlace+"</a>");
	        		}else{
	        			$(tr_Obj).find(".edit").click();
	        			MSHeader.mostrarMensaje("Error al crear: Por favor verifique los campos.", "alert-danger");
	        		}
	        	}
        	}
        });
	}

	MSVisitas.deleteVisitas = function(tr_Obj){
        $.ajax({
        	data: {"id": encodeURI($(tr_Obj).attr("id"))},
        	url: path+"modules/"+rol+"/visitas/visitasActions/accion/deleteVisitas/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("deleteVisitas: Procesando ...");
        	},
        	success: function(response){ //una vez que el archivo recibe el request lo procesa y lo devuelve
        		//console.log(response);
        		if(response){
        			MSHeader.mostrarMensaje("Se ha eliminado el registro con éxito.", "alert-success");
        			$(tr_Obj).remove();
					$(".add-new").removeAttr("disabled");
        		}else{
        			MSHeader.mostrarMensaje("Error al eliminar: Por favor vuelva a intentar después.", "alert-danger");
        		}
        	}
        });
	}

	MSVisitas.crearVisita = function(thisObj, actions){
		$(thisObj).attr("disabled", "disabled");
		var index = $("#tabla_visitas tbody tr:last-child").index();
        var row = '<tr>';
        row += '<td fieldtype="desplegable" field="proyecto_id"><select class="form-control">';
        row += MSVisitas.getOptions_listaProyectos();
		row += '</select></td>';
        row += '<td><input type="text" class="form-control" name="nombre" id="" maxlength="45"></td>';
        row += '<td fieldtype="fecha"><input type="text" class="form-control" name="fecha" id="new_fecha" maxlength="19"></td>';
        row += '<td><input type="text" class="form-control" name="descripcion" id="" maxlength="45"></td>';
        row += '<td fieldtype="desplegable" field="documento_id"><select class="form-control">';
        row += MSVisitas.getOptions_listaDocumentos();
		row += '</select></td>';

        var filas_vacias = false;
		if($("#no_visitas").length){
			filas_vacias = true;
			$("#no_visitas").remove();
			row += '<td>';
			row += '<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>';
	        row += '<a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>';
			row += '<a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
			row += '</td>';
		}else{
			row += '<td>' + actions + '</td>';
		}
		row += '<td fieldtype="checkbox"><label>¿Es la primer visita?</label><input type="checkbox" name="primer_visita" id="primer_visita" checked/></td>';
		
        row += '</tr>';
    	$("#tabla_visitas").append(row);
    	if(filas_vacias)
			$("#tabla_visitas tbody tr").eq(index).find(".add, .edit").toggle();
    	else
			$("#tabla_visitas tbody tr").eq(index+1).find(".add, .edit").toggle();

		$("#new_fecha").datetimepicker({
    		dateFormat:'yy-mm-dd',
    		timeFormat: 'HH:mm:ss'
    	});
        $('[data-toggle="tooltip"]').tooltip();
	}

	MSVisitas.adicionarVisita = function(thisObj){
		var empty = false;
		var input = $(thisObj).parents("tr").find('input[type="checkbox"], input[type="text"], input[type="number"], input[type="email"], select');
        input.each(function(){
			if(!$(this).val()){
				$(this).addClass("error");
				empty = true;
			}else{
				if($(this).attr("type")=="email" && !MSHeader.isEmail($(this).val())){
					$(this).addClass("error");
					empty = true;
				}else{
                	$(this).removeClass("error");
                }
            }
		});
		$(thisObj).parents("tr").find(".error").first().focus();
		//Se crea el array a enviar, la id original del tr
		var arrayListSend = [$(thisObj).parents("tr").attr("id")];
		if(!empty){
			input.each(function(){
				//Establece el html nuevamente
				if($(this).parent("td").attr("fieldtype")=="desplegable"){
					$(this).parent("td").attr("valor", $("option:selected").val());
					$(this).parent("td").html($("option:selected", this).text());
				}else{
					$(this).parent("td").html($(this).val());
				}

				//Añade los valores actuales del input al array
				if($(this).attr('type')=="checkbox")
						arrayListSend.push($(this).is(':checked'));
				else
					arrayListSend.push($(this).val());				
			});			
			$(thisObj).parents("tr").find(".add, .edit").toggle();
			$(".add-new").removeAttr("disabled");

			//Si no existe una id en el tr, se determina que es nuevo
			//console.log(arrayListSend);return false;
			if(arrayListSend[0] == null)
				MSVisitas.createVisitas(arrayListSend, $(thisObj).parents("tr"));
			else
				MSVisitas.updateVisitas(arrayListSend, $(thisObj).parents("tr"));
		}else{
			MSHeader.mostrarMensaje("Error al adicionar: Llene la información correctamente.", "alert-danger");
		}
	}

	MSVisitas.editarVisita = function(thisObj){
		$(thisObj).parents("tr").find("td:not(:last-child)").each(function(){
    	if($(this).attr("fieldtype")=="desplegable"){
    		var option = "";
    		if($(this).attr("field")=="documento_id"){option=MSVisitas.getOptions_listaDocumentos($(this).attr("valor"));}
    		if($(this).attr("field")=="proyecto_id"){option=MSVisitas.getOptions_listaProyectos($(this).attr("valor"));}
			$(this).html('<select class="form-control">'+option+'</select>');
    	}else if($(this).attr("fieldtype")=="numero"){
    		$(this).html('<input type="number" class="form-control" value="' + $(this).text() + '">');
    	}else if($(this).attr("fieldtype")=="email"){
    		$(this).html('<input type="email" class="form-control" value="' + $(this).text() + '">');
    	}else if($(this).attr("fieldtype")=="fecha"){
    		$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '" id="update_fecha'+$(this).parents("tr").attr("id")+'">');
    		$("#update_fecha"+$(this).parents("tr").attr("id")).datetimepicker({
	    		dateFormat:'yy-mm-dd',
	    		timeFormat: 'HH:mm:ss'
	    	});
    	}else{
    		$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
		}
	});	
	$(thisObj).parents("tr").find(".add, .edit").toggle();
	$(".add-new").attr("disabled", "disabled");
	}

	MSVisitas.getOptions_listaDocumentos = function(valor = false){
		var acum = "";
		acum += '<option value="NULL" selected>Falta por asignar</option>';
		$.each(listaDocumentos, function(i, item) {
			if(item.id==valor)
		    	acum += '<option value="'+item.id+'" selected>'+item.nombre_unico+'</option>';
		    else
		    	acum += '<option value="'+item.id+'">'+item.nombre_unico+'</option>';
		});
		return acum;
	}

	MSVisitas.getOptions_listaProyectos = function(valor = false){
		var acum = "";
		$.each(listaProyectos, function(i, item) {
			if(item.id==valor)
		    	acum += '<option value="'+item.id+'" selected>'+item.id+' - '+item.nombre+'</option>';
		    else
		    	acum += '<option value="'+item.id+'">'+item.id+' - '+item.nombre+'</option>';
		});
		return acum;
	}

	MSVisitas.cargarLiveEdit = function(){
		$('[data-toggle="tooltip"]').tooltip();
		var actions = $("#tabla_visitas td:last-child").html();
		// Append table with add row form on add new button click
	    $(".add-new").click(function(){
	    	MSVisitas.crearVisita($(this), actions);
	    });
		// Add row on add button click
		$(document).on("click", ".add", function(){
			MSVisitas.adicionarVisita($(this));
	    });
		// Edit row on edit button click
		$(document).on("click", ".edit", function(){
			MSVisitas.editarVisita($(this));
	    });
		// Delete row on delete button click
		$(document).on("click", ".delete", function(){
			if($(this).parents("tr").attr("id")){
				MSVisitas.deleteVisitas($(this).parents("tr"));
			}else if($("#tabla_visitas tbody tr").length==1){
				$(this).parents("tr").remove();
				$(".add-new").removeAttr("disabled");
				$("#tabla_visitas tbody").html('<tr id="no_visitas"><td colspan="9">No existen registros de visitas en la base de datos.</td></tr>');
			}else{
				$(this).parents("tr").remove();
				$(".add-new").removeAttr("disabled");
			}
	    });
	}

	return MSVisitas;
	
})(this, this.document);