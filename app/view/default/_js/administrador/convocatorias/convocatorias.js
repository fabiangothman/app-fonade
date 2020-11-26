/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  © 2019												*
****************************************************************************/

// JavaScript Document
window.MSConvocatorias = (function(window, document, undefined) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	rol = "" /* Rol actual del usuario en sesión */,
	MSConvocatorias = {},
	owner = window,
	docElement = document.documentElement;
	
	MSConvocatorias.init = function(_path, _model, _view, _rol){
		path = _path;
		model = _model;
		view = path+_view;
		rol = _rol;

		MSConvocatorias.cargarLiveEdit();
	}	

	MSConvocatorias.updateConvocatoria = function(arrayListSend, tr_Obj){
		var parametros = {
			"orig_numero": encodeURI(arrayListSend[0]),
			"numero": encodeURI(arrayListSend[1]),
			"fecha": encodeURI(arrayListSend[2]),
			"descripcion": encodeURI(arrayListSend[3])
        };
        //console.log(parametros);
        $.ajax({
        	data: parametros,
        	url: path+"modules/"+rol+"/convocatorias/convocatoriasActions/accion/updateConvocatoria/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("updateConvocatoria: Procesando ...");
        	},
        	success: function(response){ //una vez que el archivo recibe el request lo procesa y lo devuelve
        		//console.log(response);
        		if(response){
        			MSHeader.mostrarMensaje("Se han actualizado los registros con éxito.", "alert-success");
        			$(tr_Obj).attr("id", encodeURI(arrayListSend[1]));
        		}else{
        			MSHeader.mostrarMensaje("Error al actualizar: Por favor verifique los campos.", "alert-danger");
        		}
        	}
        });
	}

	MSConvocatorias.createConvocatoria = function(arrayListSend, tr_Obj){
		var parametros = {
			"numero": encodeURI(arrayListSend[1]),
			"fecha": encodeURI(arrayListSend[2]),
			"descripcion": encodeURI(arrayListSend[3])
        };
        //console.log(parametros);
        $.ajax({
        	data: parametros,
        	url: path+"modules/"+rol+"/convocatorias/convocatoriasActions/accion/createConvocatoria/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("createConvocatoria: Procesando ...");
        	},
        	success: function(response){ //una vez que el archivo recibe el request lo procesa y lo devuelve
        		//console.log(response);
        		if(response){
        			MSHeader.mostrarMensaje("Se ha creado el nuevo registro con éxito.", "alert-success");
        			$(tr_Obj).attr("id", encodeURI(arrayListSend[1]));
        		}else{
        			$(tr_Obj).find(".edit").click();
        			MSHeader.mostrarMensaje("Error al crear: Por favor verifique los campos.", "alert-danger");
        		}
        	}
        });
	}

	MSConvocatorias.deleteConvocatoria = function(tr_Obj){
        $.ajax({
        	data: {"numero": encodeURI($(tr_Obj).attr("id"))},
        	url: path+"modules/"+rol+"/convocatorias/convocatoriasActions/accion/deleteConvocatoria/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("deleteConvocatoria: Procesando ...");
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

	MSConvocatorias.crearConvocatoria = function(thisObj, actions){
		$(thisObj).attr("disabled", "disabled");
		var index = $("#tabla_convocatorias tbody tr:last-child").index();
        var row = '<tr>';
        row += '<td fieldtype="numero"><input type="number" class="form-control"></td>';
        row += '<td fieldtype="fecha"><input type="text" class="form-control" name="fecha" id="new_fecha" maxlength="19"></td>';
        row += '<td><input type="text" class="form-control" name="descripcion" maxlength="45"></td>';
        var filas_vacias = false;
		if($("#no_convocatorias").length){
			filas_vacias = true;
			$("#no_convocatorias").remove();
		}
		row += '<td>' + actions + '</td>';
		
        row += '</tr>';
    	$("#tabla_convocatorias").append(row);
    	if(filas_vacias)
			$("#tabla_convocatorias tbody tr").eq(index).find(".add, .edit").toggle();
    	else
			$("#tabla_convocatorias tbody tr").eq(index+1).find(".add, .edit").toggle();

		$("#new_fecha").datetimepicker({
    		dateFormat:'yy-mm-dd',
    		timeFormat: 'HH:mm:ss'
    	});
        $('[data-toggle="tooltip"]').tooltip();
	}

	MSConvocatorias.adicionarConvocatoria = function(thisObj){
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
				MSConvocatorias.createConvocatoria(arrayListSend, $(thisObj).parents("tr"));
			else
				MSConvocatorias.updateConvocatoria(arrayListSend, $(thisObj).parents("tr"));
		}else{
			MSHeader.mostrarMensaje("Error al adicionar: Llene la información correctamente.", "alert-danger");
		}
	}

	MSConvocatorias.editarConvocatoria = function(thisObj){
		$(thisObj).parents("tr").find("td:not(:last-child)").each(function(){
    	if($(this).attr("fieldtype")=="desplegable"){
    		//var option = "";
    		//if($(this).attr("field")=="ID_interventor"){option=MSConvocatorias.getOptions_listaInterventores($(this).attr("valor"));}
    		//if($(this).attr("field")=="ID_centro_negocios"){option=MSConvocatorias.getOptions_listaCentroNegocios($(this).attr("valor"));}
    		//if($(this).attr("field")=="convocatoria_numero"){option=MSConvocatorias.getOptions_listaConvocatorias($(this).attr("valor"));}
			//$(this).html('<select class="form-control">'+option+'</select>');
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

	MSConvocatorias.cargarLiveEdit = function(){
		$('[data-toggle="tooltip"]').tooltip();
		if($("#no_convocatorias").length){
			var actions = '<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>'+
	        '<a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>'+
			'<a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
		}else{
			var actions = $("#tabla_convocatorias td:last-child").html();
		}
		// Append table with add row form on add new button click
	    $(".add-new").click(function(){
	    	MSConvocatorias.crearConvocatoria($(this), actions);
	    });
		// Add row on add button click
		$(document).on("click", ".add", function(){
			MSConvocatorias.adicionarConvocatoria($(this));
	    });
		// Edit row on edit button click
		$(document).on("click", ".edit", function(){
			MSConvocatorias.editarConvocatoria($(this));
	    });
		// Delete row on delete button click
		$(document).on("click", ".delete", function(){
			if($(this).parents("tr").attr("id")){
				MSConvocatorias.deleteConvocatoria($(this).parents("tr"));
			}else if($("#tabla_convocatorias tbody tr").length==1){
				$(this).parents("tr").remove();
				$(".add-new").removeAttr("disabled");
				$("#tabla_convocatorias tbody").html('<tr id="no_convocatorias"><td colspan="9">No existen registros de convocatorias en la base de datos.</td></tr>');
			}else{
				$(this).parents("tr").remove();
				$(".add-new").removeAttr("disabled");
			}
	    });
	}

	return MSConvocatorias;
	
})(this, this.document);