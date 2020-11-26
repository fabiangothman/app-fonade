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
	rol = "" /* Rol actual del usuario en sesión */,
	MSVisitas = {},
	owner = window,
	docElement = document.documentElement;
	
	MSVisitas.init = function(_path, _model, _view, _listaDocumentos, _rol){
		path = _path;
		model = _model;
		view = path+_view;
		listaDocumentos = _listaDocumentos;
		rol = _rol;

		MSVisitas.cargarLiveEdit();
	}	

	MSVisitas.updateVisitas = function(arrayListSend, tr_Obj){
		//console.log(arrayListSend);return false;
		var parametros = {
			"id": encodeURI(arrayListSend[0]),
			"documento_id": encodeURI(arrayListSend[1])
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
        			else
        				$(tr_Obj).find("td[field=documento_id]").html("No asignar aún");
        		}else{
        			MSHeader.mostrarMensaje("Error al actualizar: Por favor verifique los campos.", "alert-danger");
        		}


        	}
        });
	}

	MSVisitas.adicionarVisita = function(thisObj){
		var empty = false;
		var input = $(thisObj).parents("tr").find('select');
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
			$(this).html('<select class="form-control">'+option+'</select>');
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

	MSVisitas.cargarLiveEdit = function(){
		$('[data-toggle="tooltip"]').tooltip();
		if($("#no_visitas").length){
			var actions = '<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>'+
	        '<a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>'+
			'<a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
		}else{
			var actions = $("#tabla_visitas td:last-child").html();
		}
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
				//No se va a eliminar delete ya que borrará solo el documento
				var vector = [$(this).parents("tr").attr("id")];
				vector.push(null);
				MSVisitas.updateVisitas(vector, $(this).parents("tr"));
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