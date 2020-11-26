/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  © 2019												*
****************************************************************************/

// JavaScript Document
window.MSDocumentos = (function(window, document, undefined) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	curr_user_id = "" /* id del usuario */,
	listaUsuarios = "" /*Array de objetos de tipo usuario */,
	rol = "" /* Rol actual del usuario en sesión */,
	creandoRegistro = false;
	MSDocumentos = {},
	owner = window,
	docElement = document.documentElement;
	
	MSDocumentos.init = function(_path, _model, _view, _curr_user_id, _listaUsuarios, _rol){
		path = _path;
		model = _model;
		view = path+_view;
		curr_user_id = _curr_user_id;
		listaUsuarios = _listaUsuarios;
		rol = _rol;

		MSDocumentos.cargarLiveEdit();
	}	

	MSDocumentos.updateDocumento = function(arrayListSend, tr_Obj, file){
		file = (file == undefined) ? false : file;
        var formData = new FormData();
        //console.log(arrayListSend);
        formData.append("id", encodeURI(arrayListSend[0]));
        formData.append("nombre_unico", encodeURI(arrayListSend[1]));
        formData.append("usuario_id", encodeURI(arrayListSend[2]));
        formData.append("file", file);
        //console.log(formData);
        $.ajax({
        	data: formData,
        	url: path+"modules/"+rol+"/documentos/documentosActions/accion/updateDocumento/[iframe]/", //archivo que recibe la peticion
        	cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("updateDocumento: Procesando ...");
        	},
        	success: function(response){ //una vez que el archivo recibe el request lo procesa y lo devuelve
        		//console.log(response);
        		if(response){
        			MSHeader.mostrarMensaje("Se han actualizado los registros con éxito.", "alert-success");
        			$(tr_Obj).attr("id", encodeURI(arrayListSend[0]));
        			$(tr_Obj).find("td[fieldtype=file]").html("<a href='"+path+"documentos/"+response+"' target='_blank' download>"+response+"</a>");
        		}else{
        			MSHeader.mostrarMensaje("Error al actualizar: Por favor verifique los campos.", "alert-danger");
        		}
        	}
        });
	}

	MSDocumentos.createDocumento = function(arrayListSend, tr_Obj, file){
		file = (file == undefined) ? false : file;
        var formData = new FormData();
        formData.append("nombre_unico", encodeURI(arrayListSend[1]));
        formData.append("usuario_id", encodeURI(arrayListSend[2]));
        formData.append("file", file);
        //console.log(formData);
        $.ajax({
        	data: formData,
        	url: path+"modules/"+rol+"/documentos/documentosActions/accion/createDocumento/[iframe]/", //archivo que recibe la peticion
        	cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("updateDocumento: Procesando ...");
        	},
        	success: function(response){ //una vez que el archivo recibe el request lo procesa y lo devuelve
        		//console.log(response);
        		if(response){
        			var objResponse = $.parseJSON(response);
        			MSHeader.mostrarMensaje("Se ha creado el nuevo registro con éxito.", "alert-success");
        			$(tr_Obj).attr("id", encodeURI(objResponse.id));
        			$(tr_Obj).find("td[fieldtype=file]").html("<a href='"+path+"documentos/"+objResponse.link+"' target='_blank' download>"+objResponse.link+"</a>");
        		}else{
        			$(tr_Obj).find(".edit").click();
        			MSHeader.mostrarMensaje("Error al crear: Por favor verifique los campos.", "alert-danger");
        		}
        		creandoRegistro = false;
        	}
        });
	}

	MSDocumentos.deleteDocumento = function(tr_Obj){
        $.ajax({
        	data: {"id": encodeURI($(tr_Obj).attr("id"))},
        	url: path+"modules/"+rol+"/documentos/documentosActions/accion/deleteDocumento/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("deleteDocumento: Procesando ...");
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

	MSDocumentos.crearDocumento = function(thisObj, actions){
		$(thisObj).attr("disabled", "disabled");
		creandoRegistro=true;
		var index = $("#tabla_documentos tbody tr:last-child").index();
        var row = '<tr>';
        row += '<td><input type="text" class="form-control" maxlength="45"></td>';
        row += '<td fieldtype="desplegable" field="user_id"><select class="form-control">';
        row += MSDocumentos.getOptions_listaUsuarios(curr_user_id);
		row += '</select></td>';
        row += '<td fieldtype="file"><input type="file" class="file form-control" maxlength="45"></td>';
        var filas_vacias = false;
		if($("#no_documentos").length){
			filas_vacias = true;
			$("#no_documentos").remove();
		}
		row += '<td>' + actions + '</td>';
		
        row += '</tr>';
    	$("#tabla_documentos").append(row);
    	$('html, body').animate({ scrollTop: $("#tabla_documentos tr:last").offset().top }, 500);
    	if(filas_vacias)
			$("#tabla_documentos tbody tr").eq(index).find(".add, .edit").toggle();
    	else
			$("#tabla_documentos tbody tr").eq(index+1).find(".add, .edit").toggle();
	}

	MSDocumentos.adicionarDocumento = function(thisObj){
		var empty = false;
		var input = null;
		var inputCompleto = $(thisObj).parents("tr").find('input[type="password"], input[type="file"], input[type="text"], input[type="number"], input[type="email"], select');
		if(creandoRegistro)
			input = inputCompleto;
		else
			input = $(thisObj).parents("tr").find('input[type="text"], input[type="number"], input[type="email"], select');
        input.each(function(){
        	//console.log($(this));
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

		var file = $(thisObj).parents("tr").find("input[type=file]")[0].files[0];
		//Se crea el array a enviar, la id original del tr
		var arrayListSend = [$(thisObj).parents("tr").attr("id")];
		if(!empty){
			inputCompleto.each(function(){
				if($(this).parent("td").attr("fieldtype")=="desplegable"){
					$(this).parent("td").attr("valor", $("option:selected").val());
					$(this).parent("td").html($("option:selected", this).text());
				}else if($(this).parent("td").attr("fieldtype")=="password"){
					$(this).parent("td").html("Dejar vacío si no quiere actualizar");
				}else if($(this).parent("td").attr("fieldtype")=="file"){
					$(this).parent("td").html("Cargando ...");
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
				MSDocumentos.createDocumento(arrayListSend, $(thisObj).parents("tr"), file);
			else
				MSDocumentos.updateDocumento(arrayListSend, $(thisObj).parents("tr"), file);
		}else{
			MSHeader.mostrarMensaje("Error al adicionar: Llene la información correctamente.", "alert-danger");
		}
	}

	MSDocumentos.editarDocumento = function(thisObj){
		$(thisObj).parents("tr").find("td:not(:last-child)").each(function(){
	    	if($(this).attr("fieldtype")=="desplegable"){
	    		//var option = "";
	    		if($(this).attr("field")=="user_id"){option=MSDocumentos.getOptions_listaUsuarios($(this).attr("valor"));}
	    		$(this).html('<select class="form-control">'+option+'</select>');
	    		//if($(this).attr("field")=="xxx_id"){option=MSDocumentos.getOptions
	    	}else if($(this).attr("fieldtype")=="numero"){
	    		$(this).html('<input type="number" class="form-control" value="' + $(this).text() + '">');
	    	}else if($(this).attr("fieldtype")=="email"){
	    		$(this).html('<input type="email" class="form-control" value="' + $(this).text() + '">');
	    	}else if($(this).attr("fieldtype")=="password"){
	    		$(this).html('<input type="password" class="form-control" value="" placeholder="Nueva contraseña">');
	    	}else if($(this).attr("fieldtype")=="fecha"){
	    		$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '" id="update_fecha_asignacion'+$(this).parents("tr").attr("id")+'">');
	    		$("#update_fecha_asignacion"+$(this).parents("tr").attr("id")).datetimepicker({
		    		dateFormat:'yy-mm-dd',
		    		timeFormat: 'HH:mm:ss'
		    	});
	    	}else if($(this).attr("fieldtype")=="file"){
	    		$(this).html('<input type="file" class="file form-control" /><p class="msj_inform">Si no desea cambiar el documento, déje este campo vacío.</p>');
	    	}else{
	    		$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
			}
		});	
		$(thisObj).parents("tr").find(".add, .edit").toggle();
		$(".add-new").attr("disabled", "disabled");
	}

	MSDocumentos.getOptions_listaUsuarios = function(valor = false){
		var acum = "";
		$.each(listaUsuarios, function(i, item) {
			if(item.id==valor)
		    	acum += '<option value="'+item.id+'" selected>'+item.nombres+' '+item.apellidos+'</option>';
		    else
		    	acum += '<option value="'+item.id+'">'+item.nombres+' '+item.apellidos+'</option>';
		});
		return acum;
	}


	MSDocumentos.cargarLiveEdit = function(){
		$('[data-toggle="tooltip"]').tooltip();
		if($("#no_documentos").length){
			var actions = '<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>'+
	        '<a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>'+
			'<a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
		}else{
			var actions = $("#tabla_documentos td:last-child").html();
		}
		// Append table with add row form on add new button click
	    $(".add-new").click(function(){
	    	MSDocumentos.crearDocumento($(this), actions);
	    });
		// Add row on add button click
		$(document).on("click", ".add", function(){
			MSDocumentos.adicionarDocumento($(this));
	    });
		// Edit row on edit button click
		$(document).on("click", ".edit", function(){
			MSDocumentos.editarDocumento($(this));
	    });
		// Delete row on delete button click
		$(document).on("click", ".delete", function(){
			if($(this).parents("tr").attr("id")){
				MSDocumentos.deleteDocumento($(this).parents("tr"));
			}else if($("#tabla_documentos tbody tr").length==1){
				$(this).parents("tr").remove();
				$(".add-new").removeAttr("disabled");
				$("#tabla_documentos tbody").html('<tr id="no_documentos"><td colspan="9">No existen registros de documentos en la base de datos.</td></tr>');
			}else{
				$(this).parents("tr").remove();
				$(".add-new").removeAttr("disabled");
			}
	    });
	}

	return MSDocumentos;
	
})(this, this.document);