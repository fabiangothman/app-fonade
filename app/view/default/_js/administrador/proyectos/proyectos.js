/****************************************************************************
*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
*					  © 2019												*
****************************************************************************/

// JavaScript Document
window.MSProyectos = (function(window, document, undefined) {
	path = "" /* path al FrameWork */,
	model = "" /* path a los modelos */,
	view = "" /* path a las vistas */,
	listaInterventores = "" /*Array de objetos de tipo usuario->interventor */,
	listaEmprendedores = "" /*Array de objetos de tipo usuario->emprendedor */,
	listaCentroNegocios = "" /*Array de objetos de tipo CentroNegocios */,
	listaConvocatorias = "" /*Array de objetos de tipo Convocatorias */,
	rol = "" /* Rol actual del usuario en sesión */,
	MSProyectos = {},
	owner = window,
	docElement = document.documentElement;
	
	MSProyectos.init = function(_path, _model, _view, _listaEmprendedores, _listaInterventores, _listaConvocatorias, _listaCentroNegocios, _rol){
		path = _path;
		model = _model;
		view = path+_view;
		listaEmprendedores = _listaEmprendedores;
		listaInterventores = _listaInterventores;
		listaConvocatorias = _listaConvocatorias;
		listaCentroNegocios = _listaCentroNegocios;
		rol = _rol;

		MSProyectos.cargarLiveEdit();
	}	

	MSProyectos.updateProyecto = function(arrayListSend, tr_Obj){
		var parametros = {
			"orig_id": encodeURI(arrayListSend[0]),
			"id": encodeURI(arrayListSend[1]),
			"nombre": encodeURI(arrayListSend[2]),
			"objetivo": encodeURI(arrayListSend[3]),
			"fecha_asignacion": encodeURI(arrayListSend[4]),
			"numero_contrato": encodeURI(arrayListSend[5]),
			"emprendedor_id": encodeURI(arrayListSend[6]),
			"interventor_id": encodeURI(arrayListSend[7]),
			"convocatoria_numero": encodeURI(arrayListSend[8]),
			"centro_negocios_id": encodeURI(arrayListSend[9])
        };
        //console.log(parametros);
        $.ajax({
        	data: parametros,
        	url: path+"modules/"+rol+"/proyectos/proyectosActions/accion/updateProyecto/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("updateProyecto: Procesando ...");
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

	MSProyectos.createProyecto = function(arrayListSend, tr_Obj){
		var parametros = {
			"id": encodeURI(arrayListSend[1]),
			"nombre": encodeURI(arrayListSend[2]),
			"objetivo": encodeURI(arrayListSend[3]),
			"fecha_asignacion": encodeURI(arrayListSend[4]),
			"numero_contrato": encodeURI(arrayListSend[5]),
			"emprendedor_id": encodeURI(arrayListSend[6]),
			"interventor_id": encodeURI(arrayListSend[7]),
			"convocatoria_numero": encodeURI(arrayListSend[8]),
			"centro_negocios_id": encodeURI(arrayListSend[9])
        };
        //console.log(parametros);
        $.ajax({
        	data: parametros,
        	url: path+"modules/"+rol+"/proyectos/proyectosActions/accion/createProyecto/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("createProyecto: Procesando ...");
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

	MSProyectos.deleteProyecto = function(tr_Obj){
        $.ajax({
        	data: {"id": encodeURI($(tr_Obj).attr("id"))},
        	url: path+"modules/"+rol+"/proyectos/proyectosActions/accion/deleteProyecto/[iframe]/", //archivo que recibe la peticion
        	type: 'POST',
        	beforeSend: function(){
        		//console.log("deleteProyecto: Procesando ...");
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

	MSProyectos.crearProyecto = function(thisObj, actions){
		$(thisObj).attr("disabled", "disabled");
		var index = $("#tabla_proyectos tbody tr:last-child").index();
        var row = '<tr>';
        row += '<td fieldtype="numero"><input type="number" class="form-control" id=""></td>';
        row += '<td><input type="text" class="form-control" name="nombre" id="" maxlength="45"></td>';
        row += '<td><input type="text" class="form-control" name="objetivo" id="" maxlength="45"></td>';
        row += '<td fieldtype="fecha"><input type="text" class="form-control" name="fecha_asignacion" id="new_fecha_asignacion" maxlength="19"></td>';
        row += '<td><input type="text" class="form-control" name="numero_contrato" id="" maxlength="45"></td>';
        row += '<td fieldtype="desplegable" field="emprendedor_id"><select class="form-control">';
        row += MSProyectos.getOptions_listaEmprendedores();
		row += '</select></td>';
		row += '<td fieldtype="desplegable" field="interventor_id"><select class="form-control">';
        row += MSProyectos.getOptions_listaInterventores();
		row += '</select></td>';
		row += '<td fieldtype="desplegable" field="convocatoria_numero"><select class="form-control">';
        row += MSProyectos.getOptions_listaConvocatorias();
		row += '</select></td>';
		row += '<td fieldtype="desplegable" field="centro_negocios_id"><select class="form-control">';
        row += MSProyectos.getOptions_listaCentroNegocios();
		row += '</select></td>';

        var filas_vacias = false;
		if($("#no_proyectos").length){
			filas_vacias = true;
			$("#no_proyectos").remove();
		}
		row += '<td>' + actions + '</td>';
		
        row += '</tr>';
    	$("#tabla_proyectos").append(row);
    	if(filas_vacias)
			$("#tabla_proyectos tbody tr").eq(index).find(".add, .edit").toggle();
    	else
			$("#tabla_proyectos tbody tr").eq(index+1).find(".add, .edit").toggle();

		$("#new_fecha_asignacion").datetimepicker({
    		dateFormat:'yy-mm-dd',
    		timeFormat: 'HH:mm:ss'
    	});
        $('[data-toggle="tooltip"]').tooltip();
	}

	MSProyectos.adicionarProyecto = function(thisObj){
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
				MSProyectos.createProyecto(arrayListSend, $(thisObj).parents("tr"));
			else
				MSProyectos.updateProyecto(arrayListSend, $(thisObj).parents("tr"));
		}else{
			MSHeader.mostrarMensaje("Error al adicionar: Llene la información correctamente.", "alert-danger");
		}
	}

	MSProyectos.editarProyecto = function(thisObj){
		$(thisObj).parents("tr").find("td:not(:last-child)").each(function(){
    	if($(this).attr("fieldtype")=="desplegable"){
    		var option = "";
    		if($(this).attr("field")=="emprendedor_id"){option=MSProyectos.getOptions_listaEmprendedores($(this).attr("valor"));}
    		if($(this).attr("field")=="interventor_id"){option=MSProyectos.getOptions_listaInterventores($(this).attr("valor"));}
    		if($(this).attr("field")=="convocatoria_numero"){option=MSProyectos.getOptions_listaConvocatorias($(this).attr("valor"));}
    		if($(this).attr("field")=="centro_negocios_id"){option=MSProyectos.getOptions_listaCentroNegocios($(this).attr("valor"));}
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

	MSProyectos.getOptions_listaEmprendedores = function(valor = false){
		var acum = "";
		$.each(listaEmprendedores, function(i, item) {
			if(item.id==valor)
		    	acum += '<option value="'+item.id+'" selected>'+item.id+' - '+item.nombres+' '+item.apellidos+'</option>';
		    else
		    	acum += '<option value="'+item.id+'">'+item.id+' - '+item.nombres+' '+item.apellidos+'</option>';
		});
		return acum;
	}
	MSProyectos.getOptions_listaInterventores = function(valor = false){
		var acum = "";
		$.each(listaInterventores, function(i, item) {
			if(item.id==valor)
		    	acum += '<option value="'+item.id+'" selected>'+item.id+' - '+item.nombres+' '+item.apellidos+'</option>';
		    else
		    	acum += '<option value="'+item.id+'">'+item.id+' - '+item.nombres+' '+item.apellidos+'</option>';
		});
		return acum;
	}
	MSProyectos.getOptions_listaConvocatorias = function(valor = false){
		var acum = "";
		$.each(listaConvocatorias, function(i, item) {
			if(item.numero==valor)
		    	acum += '<option value="'+item.numero+'" selected>'+item.numero+' / '+item.fecha+'</option>';
		    else
		    	acum += '<option value="'+item.numero+'">'+item.numero+' / '+item.fecha+'</option>';
		});
		return acum;
	}
	MSProyectos.getOptions_listaCentroNegocios = function(valor = false){
		var acum = "";
		$.each(listaCentroNegocios, function(i, item) {
			if(item.id==valor)
		    	acum += '<option value="'+item.id+'" selected>'+item.id+' - '+item.nombre+'</option>';
		    else
		    	acum += '<option value="'+item.id+'">'+item.id+' - '+item.nombre+'</option>';
		});
		return acum;
	}

	MSProyectos.cargarLiveEdit = function(){
		$('[data-toggle="tooltip"]').tooltip();
		if($("#no_proyectos").length){
			var actions = '<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>'+
	        '<a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>'+
			'<a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>';
		}else{
			var actions = $("#tabla_proyectos td:last-child").html();
		}
		// Append table with add row form on add new button click
	    $(".add-new").click(function(){
	    	MSProyectos.crearProyecto($(this), actions);
	    });
		// Add row on add button click
		$(document).on("click", ".add", function(){
			MSProyectos.adicionarProyecto($(this));
	    });
		// Edit row on edit button click
		$(document).on("click", ".edit", function(){
			MSProyectos.editarProyecto($(this));
	    });
		// Delete row on delete button click
		$(document).on("click", ".delete", function(){
			if($(this).parents("tr").attr("id")){
				MSProyectos.deleteProyecto($(this).parents("tr"));
			}else if($("#tabla_proyectos tbody tr").length==1){
				$(this).parents("tr").remove();
				$(".add-new").removeAttr("disabled");
				$("#tabla_proyectos tbody").html('<tr id="no_proyectos"><td colspan="9">No existen registros de proyectos en la base de datos.</td></tr>');
			}else{
				$(this).parents("tr").remove();
				$(".add-new").removeAttr("disabled");
			}
	    });
	}

	return MSProyectos;
	
})(this, this.document);