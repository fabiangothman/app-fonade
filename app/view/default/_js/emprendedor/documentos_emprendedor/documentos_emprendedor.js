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
	rol = "" /* Rol actual del usuario en sesión */,
	MSDocumentos_emprendedor = {},
	owner = window,
	docElement = document.documentElement;
	
	MSDocumentos_emprendedor.init = function(_path, _model, _view, _listaDocumentos, _rol){
		path = _path;
		model = _model;
		view = path+_view;
		listaDocumentos = _listaDocumentos;
		rol = _rol;

		MSDocumentos_emprendedor.cargarLiveEdit();
	}	

	MSDocumentos_emprendedor.updateDocumento_emprendedor = function(arrayListSend, tr_Obj){
		var parametros = {
			"id": encodeURI(arrayListSend[0]),
			"documento_id": encodeURI(arrayListSend[1])
        };
        console.log(parametros);
        $.ajax({
        	data: parametros,
        	url: path+"modules/"+rol+"/documentos_emprendedor/documentos_emprendedorActions/accion/updateDocumento_emprendedor/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("updateDocumento_emprendedor: Procesando ...");
        	},
        	success: function(response){ //una vez que el archivo recibe el request lo procesa y lo devuelve
        		console.log(response);
        		if(response){
        			MSHeader.mostrarMensaje("Se han actualizado los registros con éxito.", "alert-success");
        			if(response!="null")
        				$(tr_Obj).find("td[field=documento_id]").html($(tr_Obj).find("td[field=documento_id]").html()+" - <a href='"+path+"documentos/"+response+"' target='_blank' download>"+response+"</a>");
        			else
        				$(tr_Obj).find("td[field=documento_id]").html("<p class='msj_pendiente'>Pendiente</p>");
        		}else{
        			MSHeader.mostrarMensaje("Error al actualizar: Por favor verifique los campos.", "alert-danger");
        		}
        	}
        });
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

			MSDocumentos_emprendedor.updateDocumento_emprendedor(arrayListSend, $(thisObj).parents("tr"));
		}else{
			MSHeader.mostrarMensaje("Error al adicionar: Llene la información correctamente.", "alert-danger");
		}
	}

	MSDocumentos_emprendedor.editarDocumento_emprendedor = function(thisObj){
		$(thisObj).parents("tr").find("td:not(:last-child)").each(function(){
	    	if(($(this).attr("fieldtype")=="desplegable") && ($(this).attr("field")=="documento_id")){
	    		var option = "";
				$(this).html('<select class="form-control">'+MSDocumentos_emprendedor.getOptions_listaDocumentos($(this).attr("valor"))+'</select>');
	    	}
		});	
		$(thisObj).parents("tr").find(".add, .edit").toggle();
		$(".add-new").attr("disabled", "disabled");
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
				//No se va a eliminar delete ya que borrará solo el documento
				var vector = [$(this).parents("tr").attr("id")];
				vector.push(null);
				MSDocumentos_emprendedor.updateDocumento_emprendedor(vector, $(this).parents("tr"));
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