<div id="documentos_emprendedor_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-10"><h2>Información de <b>documentos de emprendedores</b> de mis interventores</h2></div>
	                    <div class="col-sm-2 text-right">
	                        <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar Nuevo</button>
	                    </div>
	                </div>
	            </div>
	            <div class="row cont_table">
		            <table id="tabla_documentos_emprendedor" class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th>ID de proyecto</th>
		                        <th>Requerimiento</th>
		                        <th>Documento relacionado</th>
		                        <th>Acciones</th>
		                    </tr>
		                </thead>
		                <tbody>
		                	<?php if($listaDocumentos_emprendedor){ ?>
		                	<?php foreach ($listaDocumentos_emprendedor as $key => $documento_emprendedor) { ?>
		                    <tr id="<?php echo $documento_emprendedor['id']; ?>">
		                        <td fieldtype="desplegable" field="proyecto_id" valor="<?php echo $documento_emprendedor['proyecto_id']; ?>"><?php echo $documento_emprendedor['proyecto_id']." - ".$documento_emprendedor['nombre']; ?></td>
		                        <td><?php echo $documento_emprendedor['requerimiento']; ?></td>
		                        <td fieldtype="desplegable" field="documento_id" valor="<?php echo $documento_emprendedor['documento_id']; ?>"><?php echo is_null($documento_emprendedor['nombre_unico']) ? "<p class='msj_pendiente'>Pendiente</p>" : $documento_emprendedor['nombre_unico']." - <a href='".$docs_folder.$documento_emprendedor['enlace']."' download>".$documento_emprendedor['enlace']."</a>"; ?></td>
		                        <td>
									<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		                            <a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		                            <a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		                        </td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_documentos_emprendedor"><td colspan="10">No existen registros de documentos de emprendedores en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>
	        </div>
		</div>
	</div>
</div>
