/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  © 2019												*
****************************************************************************/

// JavaScript Document
window.MSLaes = (function(window, document, undefined) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	listaCiudades = "" /*Array de objetos de tipo ciudad */,
	listaRoles = "" /*Array de objetos de tipo CentroNegocios */,
	rol = "" /* Rol actual del usuario en sesión */,
	MSLaes = {},
	owner = window,
	docElement = document.documentElement;
	
	MSLaes.init = function(_path, _model, _view, _listaCiudades, _listaRoles, _rol){
		path = _path;
		model = _model;
		view = path+_view;
		listaCiudades = _listaCiudades;
		listaRoles = _listaRoles;
		rol = _rol;

		MSLaes.cargarLiveEdit();
	}	

	MSLaes.updateLae = function(arrayListSend, tr_Obj){
		var parametros = {
			"orig_id": encodeURI(arrayListSend[0]),
			"id": encodeURI(arrayListSend[1]),
			"nombres": encodeURI(arrayListSend[2]),
			"apellidos": encodeURI(arrayListSend[3]),
			"correo": encodeURI(arrayListSend[4]),
			"telefono": encodeURI(arrayListSend[5]),
			"contacto": encodeURI(arrayListSend[6]),
			"ciudad_dane": encodeURI(arrayListSend[7]),
			"rol_id": encodeURI(arrayListSend[8])
        };
        //console.log(parametros);
        $.ajax({
        	data: parametros,
        	url: path+"modules/"+rol+"/laes/laesActions/accion/updateLae/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("updateLae: Procesando ...");
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

	MSLaes.createLae = function(arrayListSend, tr_Obj){
		var parametros = {
			"id": encodeURI(arrayListSend[1]),
			"nombres": encodeURI(arrayListSend[2]),
			"apellidos": encodeURI(arrayListSend[3]),
			"correo": encodeURI(arrayListSend[4]),
			"telefono": encodeURI(arrayListSend[5]),
			"contacto": encodeURI(arrayListSend[6]),
			"ciudad_dane": encodeURI(arrayListSend[7]),
			"rol_id": encodeURI(arrayListSend[8])
        };
        //console.log(parametros);
        $.ajax({
        	data: parametros,
        	url: path+"modules/"+rol+"/laes/laesActions/accion/createLae/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("createLae: Procesando ...");
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

	MSLaes.deleteLae = function(tr_Obj){
        $.ajax({
        	data: {"id": encodeURI($(tr_Obj).attr("id"))},
        	url: path+"modules/"+rol+"/laes/laesActions/accion/deleteLae/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("deleteLae: Procesando ...");
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

	MSLaes.crearLae = function(thisObj, actions){
		$(thisObj).attr("disabled", "disabled");
		var index = $("#tabla_laes tbody tr:last-child").index();
        var row = '<tr>' +
            '<td fieldtype="numero"><input type="number" class="form-control" id=""></td>';
        row += '<td><input type="text" class="form-control" id="" maxlength="59"></td>';
        row += '<td><input type="text" class="form-control" id="" maxlength="59"></td>';
        row += '<td fieldtype="email"><input type="email" class="form-control" id="" maxlength="59"></td>';
        row += '<td><input type="text" class="form-control" id="" maxlength="59"></td>';
        row += '<td><input type="text" class="form-control" id="" maxlength="59"></td>';
        row += '<td fieldtype="desplegable" field="ciudad_dane"><select class="form-control">';
        row += MSLaes.getOptions_listaCiudades();
		row += '</select></td>';
        row += '<td fieldtype="desplegable" field="rol_id"><select class="form-control">';
        row += MSLaes.getOptions_listaRoles();
		row += '</select></td>';
		var filas_vacias = false;
		if($("#no_laes").length){
			filas_vacias = true;
			$("#no_laes").remove();
		}
		row += '<td>' + actions + '</td>';
		
        row += '</tr>';
    	$("#tabla_laes").append(row);
    	if(filas_vacias)
			$("#tabla_laes tbody tr").eq(index).find(".add, .edit").toggle();
    	else
			$("#tabla_laes tbody tr").eq(index+1).find(".add, .edit").toggle();
	}

	MSLaes.adicionarLae = function(thisObj){
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
				MSLaes.createLae(arrayListSend, $(thisObj).parents("tr"));
			else
				MSLaes.updateLae(arrayListSend, $(thisObj).parents("tr"));
		}else{
			MSHeader.mostrarMensaje("Error al adicionar: Llene la información correctamente.", "alert-danger");
		}
	}

	MSLaes.editarLae = function(thisObj){
		$(thisObj).parents("tr").find("td:not(:last-child)").each(function(){
    	if($(this).attr("fieldtype")=="desplegable"){
    		var option = "";
    		if($(this).attr("field")=="rol_id"){option=MSLaes.getOptions_listaRoles($(this).attr("valor"));}
    		$(this).html('<select class="form-control">'+option+'</select>');
    		if($(this).attr("field")=="ciudad_dane"){option=MSLaes.getOptions_listaCiudades($(this).attr("valor"));}
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

	MSLaes.getOptions_listaRoles = function(valor = false){
		var acum = "";
		$.each(listaRoles, function(i, item) {
			if(item.id==valor)
		    	acum += '<option value="'+item.id+'" selected>'+item.id+' - '+item.nombre_unico+'</option>';
		    else
		    	acum += '<option value="'+item.id+'">'+item.id+' - '+item.nombre_unico+'</option>';
		});
		return acum;
	}
	MSLaes.getOptions_listaCiudades = function(valor = false){
		var acum = "";
		$.each(listaCiudades, function(i, item) {
			if(item.codigo_dane==valor)
		    	acum += '<option value="'+item.codigo_dane+'" selected>'+item.codigo_dane+' - '+item.ciudad+'</option>';
		    else
		    	acum += '<option value="'+item.codigo_dane+'">'+item.codigo_dane+' - '+item.ciudad+'</option>';
		});
		return acum;
	}

	MSLaes.cargarLiveEdit = function(){
		$('[data-toggle="tooltip"]').tooltip();
		if($("#no_laes").length){
			var actions = '<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>'+
	        '<a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>'+
			'<a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
		}else{
			var actions = $("#tabla_laes td:last-child").html();
		}
		// Append table with add row form on add new button click
	    $(".add-new").click(function(){
	    	MSLaes.crearLae($(this), actions);
	    });
		// Add row on add button click
		$(document).on("click", ".add", function(){
			MSLaes.adicionarLae($(this));
	    });
		// Edit row on edit button click
		$(document).on("click", ".edit", function(){
			MSLaes.editarLae($(this));
	    });
		// Delete row on delete button click
		$(document).on("click", ".delete", function(){
			if($(this).parents("tr").attr("id")){
				MSLaes.deleteLae($(this).parents("tr"));
			}else if($("#tabla_laes tbody tr").length==1){
				$(this).parents("tr").remove();
				$(".add-new").removeAttr("disabled");
				$("#tabla_laes tbody").html('<tr id="no_laes"><td colspan="9">No existen registros de LAEs en la base de datos.</td></tr>');
			}else{
				$(this).parents("tr").remove();
				$(".add-new").removeAttr("disabled");
			}
	    });
	}

	return MSLaes;
	
})(this, this.document);