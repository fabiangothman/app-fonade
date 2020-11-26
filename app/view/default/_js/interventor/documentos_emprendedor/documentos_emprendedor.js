/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  © 2019												*
****************************************************************************/

// JavaScript Document
window.MSDocumentos_emprendedor = (function(window, document, undefined) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	listaDocumentos = "" /*Array de objetos de tipo ciudad */,
	listaProyectos = "" /*Array de objetos de tipo CentroNegocios */,
	rol = "" /* Rol actual del usuario en sesión */,
	MSDocumentos_emprendedor = {},
	owner = window,
	docElement = document.documentElement;
	
	MSDocumentos_emprendedor.init = function(_path, _model, _view, _listaDocumentos, _listaProyectos, _rol){
		path = _path;
		model = _model;
		view = path+_view;
		listaDocumentos = _listaDocumentos;
		listaProyectos = _listaProyectos;
		rol = _rol;

		MSDocumentos_emprendedor.cargarLiveEdit();
	}	

	MSDocumentos_emprendedor.updateDocumento_emprendedor = function(arrayListSend, tr_Obj){
		var parametros = {
			"id": encodeURI(arrayListSend[0]),
			"proyecto_id": encodeURI(arrayListSend[1]),
			"requerimiento": encodeURI(arrayListSend[2]),
			"documento_id": encodeURI(arrayListSend[3])
        };
        //console.log(parametros);
        $.ajax({
        	data: parametros,
        	url: path+"modules/"+rol+"/documentos_emprendedor/documentos_emprendedorActions/accion/updateDocumento_emprendedor/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("updateDocumento_emprendedor: Procesando ...");
        	},
        	success: function(response){ //una vez que el archivo recibe el request lo procesa y lo devuelve
        		//console.log(response);
        		if(response){
        			MSHeader.mostrarMensaje("Se han actualizado los registros con éxito.", "alert-success");
        			//$(tr_Obj).attr("id", encodeURI(arrayListSend[0]));
        			if(arrayListSend[3]==null || arrayListSend[3]=="null"){
        				$(tr_Obj).find("td[field=documento_id]").html("<p class='msj_pendiente'>Pendiente</p>");
        			}else{
        				$(tr_Obj).find("td[field=documento_id]").html($(tr_Obj).find("td[field=documento_id]").html()+" - <a href='"+path+"documentos/"+response+"' target='_blank' download>"+response+"</a>");
        			}
        		}else{
        			MSHeader.mostrarMensaje("Error al actualizar: Por favor verifique los campos.", "alert-danger");
        		}
        	}
        });
	}

	MSDocumentos_emprendedor.createDocumento_emprendedor = function(arrayListSend, tr_Obj){
		var parametros = {
			"proyecto_id": encodeURI(arrayListSend[1]),
			"requerimiento": encodeURI(arrayListSend[2]),
			"documento_id": encodeURI(arrayListSend[3])
        };
        //console.log(parametros);
        $.ajax({
        	data: parametros,
        	url: path+"modules/"+rol+"/documentos_emprendedor/documentos_emprendedorActions/accion/createDocumento_emprendedor/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("createDocumento_emprendedor: Procesando ...");
        	},
        	success: function(response){ //una vez que el archivo recibe el request lo procesa y lo devuelve
        		//console.log(response);
        		if(response){
        			var objResponse = $.parseJSON(response);
        			console.log(objResponse);
        			MSHeader.mostrarMensaje("Se ha creado el nuevo registro con éxito.", "alert-success");
        			$(tr_Obj).attr("id", encodeURI(objResponse.id));
        			//console.log(arrayListSend[3]);
        			if(arrayListSend[3]==null || arrayListSend[3]=="null"){
        				$(tr_Obj).find("td[field=documento_id]").html("<p class='msj_pendiente'>Pendiente</p>");
        			}else{
        				$(tr_Obj).find("td[field=documento_id]").html($(tr_Obj).find("td[field=documento_id]").html()+" - <a href='"+path+"documentos/"+objResponse.enlace+"' target='_blank' download>"+objResponse.enlace+"</a>");
        			}
        		}else{
        			$(tr_Obj).find(".edit").click();
        			MSHeader.mostrarMensaje("Error al crear: Por favor verifique los campos.", "alert-danger");
        		}
        	}
        });
	}

	MSDocumentos_emprendedor.deleteDocumento_emprendedor = function(tr_Obj){
        //console.log($(tr_Obj).attr("id"));
        $.ajax({
        	data: {"id": encodeURI($(tr_Obj).attr("id"))},
        	url: path+"modules/"+rol+"/documentos_emprendedor/documentos_emprendedorActions/accion/deleteDocumento_emprendedor/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("deleteDocumento_emprendedor: Procesando ...");
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

	MSDocumentos_emprendedor.crearDocumento_emprendedor = function(thisObj, actions){
		$(thisObj).attr("disabled", "disabled");
		var index = $("#tabla_documentos_emprendedor tbody tr:last-child").index();
        var row = '<tr>';
        row += '<td fieldtype="desplegable" field="proyecto_id"><select class="form-control">';
        row += MSDocumentos_emprendedor.getOptions_listaProyectos();
		row += '</select></td>';
		row += '<td><input type="text" class="form-control" id="" maxlength="45"></td>';
        row += '<td fieldtype="desplegable" field="documento_id"><select class="form-control">';
        row += MSDocumentos_emprendedor.getOptions_listaDocumentos();
		row += '</select></td>';
        var filas_vacias = false;
		if($("#no_documentos_emprendedor").length){
			filas_vacias = true;
			$("#no_documentos_emprendedor").remove();
		}
		row += '<td>' + actions + '</td>';
		
        row += '</tr>';
    	$("#tabla_documentos_emprendedor").append(row);
    	if(filas_vacias)
			$("#tabla_documentos_emprendedor tbody tr").eq(index).find(".add, .edit").toggle();
    	else
			$("#tabla_documentos_emprendedor tbody tr").eq(index+1).find(".add, .edit").toggle();
	}

	MSDocumentos_emprendedor.adicionarDocumento_emprendedor = function(thisObj){
		var empty = false;
		var input = $(thisObj).parents("tr").find('input[type="text"], input[type="number"], input[type="email"], select');
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
				if($(this).parent("td").attr("fieldtype")=="desplegable"){
					$(this).parent("td").attr("valor", $("option:selected").val());
					$(this).parent("td").html($("option:selected", this).text());
				}else{
					$(this).parent("td").html($(this).val());
				}
				arrayListSend.push($(this).val());
			});			
			$(thisObj).parents("tr").find(".add, .edit").toggle();
			$(".add-new").removeAttr("disabled");

			//Si no existe una id en el tr, se determina que es nuevo
			//console.log(arrayListSend);
			if(arrayListSend[0] == null)
				MSDocumentos_emprendedor.createDocumento_emprendedor(arrayListSend, $(thisObj).parents("tr"));
			else
				MSDocumentos_emprendedor.updateDocumento_emprendedor(arrayListSend, $(thisObj).parents("tr"));
		}else{
			MSHeader.mostrarMensaje("Error al adicionar: Llene la información correctamente.", "alert-danger");
		}
	}

	MSDocumentos_emprendedor.editarDocumento_emprendedor = function(thisObj){
		$(thisObj).parents("tr").find("td:not(:last-child)").each(function(){
	    	if($(this).attr("fieldtype")=="desplegable"){
	    		var option = "";
	    		if($(this).attr("field")=="proyecto_id"){option=MSDocumentos_emprendedor.getOptions_listaProyectos($(this).attr("valor"));}
	    		if($(this).attr("field")=="documento_id"){option=MSDocumentos_emprendedor.getOptions_listaDocumentos($(this).attr("valor"));}
				$(this).html('<select class="form-control">'+option+'</select>');
	    	}else if($(this).attr("fieldtype")=="numero"){
	    		$(this).html('<input type="number" class="form-control" value="' + $(this).text() + '">');
	    	}else if($(this).attr("fieldtype")=="email"){
	    		$(this).html('<input type="email" class="form-control" value="' + $(this).text() + '">');
	    	}else if($(this).attr("fieldtype")=="fecha"){
	    		$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '" id="update_fecha_asignacion'+$(this).parents("tr").attr("id")+'">');
	    		$("#update_fecha_asignacion"+$(this).parents("tr").attr("id")).datetimepicker({
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

	MSDocumentos_emprendedor.getOptions_listaProyectos = function(valor = false){
		var acum = "";
		$.each(listaProyectos, function(i, item) {
			if(item.id==valor)
		    	acum += '<option value="'+item.id+'" selected>'+item.id+' - '+item.nombre+'</option>';
		    else
		    	acum += '<option value="'+item.id+'">'+item.id+' - '+item.nombre+'</option>';
		});
		return acum;
	}
	MSDocumentos_emprendedor.getOptions_listaDocumentos = function(valor = false){
		var acum = "<option value='null'>Pendiente</option>";
		$.each(listaDocumentos, function(i, item) {
			if(item.id==valor)
		    	acum += '<option value="'+item.id+'" selected>'+item.nombre_unico+'</option>';
		    else
		    	acum += '<option value="'+item.id+'">'+item.nombre_unico+'</option>';
		});
		return acum;
	}

	MSDocumentos_emprendedor.cargarLiveEdit = function(){
		$('[data-toggle="tooltip"]').tooltip();
		if($("#no_documentos_emprendedor").length){
			var actions = '<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>'+
	        '<a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>'+
			'<a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
		}else{
			var actions = $("#tabla_documentos_emprendedor td:last-child").html();
		}
		// Append table with add row form on add new button click
	    $(".add-new").click(function(){
	    	MSDocumentos_emprendedor.crearDocumento_emprendedor($(this), actions);
	    });
		// Add row on add button click
		$(document).on("click", ".add", function(){
			MSDocumentos_emprendedor.adicionarDocumento_emprendedor($(this));
	    });
		// Edit row on edit button click
		$(document).on("click", ".edit", function(){
			MSDocumentos_emprendedor.editarDocumento_emprendedor($(this));
	    });
		// Delete row on delete button click
		$(document).on("click", ".delete", function(){
			if($(this).parents("tr").attr("id")){
				MSDocumentos_emprendedor.deleteDocumento_emprendedor($(this).parents("tr"));
			}else if($("#tabla_documentos_emprendedor tbody tr").length==1){
				$(this).parents("tr").remove();
				$(".add-new").removeAttr("disabled");
				$("#tabla_documentos_emprendedor tbody").html('<tr id="no_documentos_emprendedor"><td colspan="9">No existen registros de documentos de emprendedores en la base de datos.</td></tr>');
			}else{
				$(this).parents("tr").remove();
				$(".add-new").removeAttr("disabled");
			}
	    });
	}

	return MSDocumentos_emprendedor;
	
})(this, this.document);