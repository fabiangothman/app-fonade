/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  © 2019												*
****************************************************************************/

// JavaScript Document
window.MSCiudades = (function(window, document, undefined) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	listaDepartamentos = "" /*Array de objetos de tipo ciudad */,
	rol = "" /* Rol actual del usuario en sesión */,
	creandoRegistro = false;
	MSCiudades = {},
	owner = window,
	docElement = document.documentElement;
	
	MSCiudades.init = function(_path, _model, _view, _listaDepartamentos, _rol){
		path = _path;
		model = _model;
		view = path+_view;
		listaDepartamentos = _listaDepartamentos;
		rol = _rol;

		MSCiudades.cargarLiveEdit();
	}	

	MSCiudades.updateCiudad = function(arrayListSend, tr_Obj){
		var parametros = {
			"orig_c_codigo_dane": encodeURI(arrayListSend[0]),
			"c_codigo_dane": encodeURI(arrayListSend[1]),
			"ciudad": encodeURI(arrayListSend[2]),
			"d_codigo_dane": encodeURI(arrayListSend[3])
        };
        //console.log(parametros);
        $.ajax({
        	data: parametros,
        	url: path+"modules/"+rol+"/ciudades/ciudadesActions/accion/updateCiudad/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("updateCiudad: Procesando ...");
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

	MSCiudades.createCiudad = function(arrayListSend, tr_Obj){
		var parametros = {
			"c_codigo_dane": encodeURI(arrayListSend[1]),
			"ciudad": encodeURI(arrayListSend[2]),
			"d_codigo_dane": encodeURI(arrayListSend[3])
        };
        //console.log(parametros);
        $.ajax({
        	data: parametros,
        	url: path+"modules/"+rol+"/ciudades/ciudadesActions/accion/createCiudad/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("createCiudad: Procesando ...");
        	},
        	success: function(response){ //una vez que el archivo recibe el request lo procesa y lo devuelve
        		//console.log(response);
        		if(response){
        			MSHeader.mostrarMensaje("Se ha creado el nuevo registro con éxito.", "alert-success");
        			$(tr_Obj).attr("id", encodeURI(response));
        		}else{
        			$(tr_Obj).find(".edit").click();
        			MSHeader.mostrarMensaje("Error al crear: Por favor verifique los campos.", "alert-danger");
        		}
        		creandoRegistro = false;
        	}
        });
	}

	MSCiudades.deleteCiudad = function(tr_Obj){
        $.ajax({
        	data: {"codigo_dane": encodeURI($(tr_Obj).attr("id"))},
        	url: path+"modules/"+rol+"/ciudades/ciudadesActions/accion/deleteCiudad/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("deleteCiudad: Procesando ...");
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

	MSCiudades.crearCiudad = function(thisObj, actions){
		$(thisObj).attr("disabled", "disabled");
		creandoRegistro=true;
		var index = $("#tabla_ciudades tbody tr:last-child").index();
        var row = '<tr>';
        row += '<td><input type="number" class="form-control" maxlength="45"></td>';
        row += '<td><input type="text" class="form-control" maxlength="45"></td>';
        row += '<td fieldtype="desplegable" field="departamento_dane"><select class="form-control">';
        row += MSCiudades.getOptions_listaDepartamentos();
		row += '</select></td>';
        var filas_vacias = false;
		if($("#no_ciudades").length){
			filas_vacias = true;
			$("#no_ciudades").remove();
		}
		row += '<td>' + actions + '</td>';
		
        row += '</tr>';
    	$("#tabla_ciudades").append(row);
    	$('html, body').animate({ scrollTop: $("#tabla_ciudades tr:last").offset().top }, 500);
    	if(filas_vacias)
			$("#tabla_ciudades tbody tr").eq(index).find(".add, .edit").toggle();
    	else
			$("#tabla_ciudades tbody tr").eq(index+1).find(".add, .edit").toggle();
	}

	MSCiudades.adicionarCiudad = function(thisObj){
		var empty = false;
		var input = null;
		var inputCompleto = $(thisObj).parents("tr").find('input[type="password"], input[type="text"], input[type="number"], input[type="email"], select');
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
		//Se crea el array a enviar, la id original del tr
		var arrayListSend = [$(thisObj).parents("tr").attr("id")];
		if(!empty){
			inputCompleto.each(function(){
				if($(this).parent("td").attr("fieldtype")=="desplegable"){
					$(this).parent("td").attr("valor", $("option:selected").val());
					$(this).parent("td").html($("option:selected", this).text());
				}else if($(this).parent("td").attr("fieldtype")=="password"){
					$(this).parent("td").html("Dejar vacío si no quiere actualizar");
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
				MSCiudades.createCiudad(arrayListSend, $(thisObj).parents("tr"));
			else
				MSCiudades.updateCiudad(arrayListSend, $(thisObj).parents("tr"));
		}else{
			MSHeader.mostrarMensaje("Error al adicionar: Llene la información correctamente.", "alert-danger");
		}
	}

	MSCiudades.editarCiudad = function(thisObj){
		$(thisObj).parents("tr").find("td:not(:last-child)").each(function(){
    	if($(this).attr("fieldtype")=="desplegable"){
    		var option = "";
    		if($(this).attr("field")=="departamento_dane"){option=MSCiudades.getOptions_listaDepartamentos($(this).attr("valor"));}
			$(this).html('<select class="form-control">'+option+'</select>');
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
    	}else{
    		$(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
		}
	});	
	$(thisObj).parents("tr").find(".add, .edit").toggle();
	$(".add-new").attr("disabled", "disabled");
	}

	MSCiudades.getOptions_listaDepartamentos = function(valor = false){
		var acum = "";
		$.each(listaDepartamentos, function(i, item) {
			if(item.codigo_dane==valor)
		    	acum += '<option value="'+item.codigo_dane+'" selected>'+item.codigo_dane+' - '+item.departamento+'</option>';
		    else
		    	acum += '<option value="'+item.codigo_dane+'">'+item.codigo_dane+' - '+item.departamento+'</option>';
		});
		return acum;
	}

	MSCiudades.cargarLiveEdit = function(){
		$('[data-toggle="tooltip"]').tooltip();
		if($("#no_ciudades").length){
			var actions = '<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>'+
	        '<a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>'+
			'<a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
		}else{
			var actions = $("#tabla_ciudades td:last-child").html();
		}
		// Append table with add row form on add new button click
	    $(".add-new").click(function(){
	    	MSCiudades.crearCiudad($(this), actions);
	    });
		// Add row on add button click
		$(document).on("click", ".add", function(){
			MSCiudades.adicionarCiudad($(this));
	    });
		// Edit row on edit button click
		$(document).on("click", ".edit", function(){
			MSCiudades.editarCiudad($(this));
	    });
		// Delete row on delete button click
		$(document).on("click", ".delete", function(){
			if($(this).parents("tr").attr("id")){
				MSCiudades.deleteCiudad($(this).parents("tr"));
			}else if($("#tabla_ciudades tbody tr").length==1){
				$(this).parents("tr").remove();
				$(".add-new").removeAttr("disabled");
				$("#tabla_ciudades tbody").html('<tr id="no_ciudades"><td colspan="9">No existen registros de ciudades en la base de datos.</td></tr>');
			}else{
				$(this).parents("tr").remove();
				$(".add-new").removeAttr("disabled");
			}
	    });
	}

	return MSCiudades;
	
})(this, this.document);