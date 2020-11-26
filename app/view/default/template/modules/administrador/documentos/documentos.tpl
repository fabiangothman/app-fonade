<div id="documentos_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>documentos</b> generales</h2></div>
	                    <div class="col-sm-4 text-right">
	                        <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar Nuevo</button>
	                    </div>
	                </div>
	            </div>
	            <div class="row cont_table">
		            <table id="tabla_documentos" class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th>Nombre único de documento</th>
		                        <th>Usuario Dueño</th>
		                        <th>Archivo</th>
		                        <th>Acciones</th>
		                    </tr>
		                </thead>
		                <tbody>
		                	<?php if($listaDocumentos){ ?>
		                	<?php foreach ($listaDocumentos as $key => $documento) { ?>
		                    <tr id="<?php echo $documento['id']; ?>">
		                    	<td><?php echo $documento['nombre_unico']; ?></td>
		                    	<td fieldtype="desplegable" field="user_id" valor="<?php echo $documento['usuario_id']; ?>"><?php echo $documento['nombres']." ".$documento['apellidos']; ?></td>
		                    	<td fieldtype="file"><a target="_blank" href="<?php echo $docs_folder.$documento['enlace']; ?>" download><?php echo $documento['enlace']; ?></a></td>
		                        <td>
									<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		                            <a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		                            <a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		                        </td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_documentos"><td colspan="10">No existen registros de documentos en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>
	        </div>
		</div>
	</div>
</div>
