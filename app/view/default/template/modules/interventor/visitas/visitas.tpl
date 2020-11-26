<div id="visitas_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>mis visitas</b></h2></div>
	                </div>
	            </div>
	            <div class="row cont_table">
		            <table id="tabla_visitas" class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th>ID de proyecto</th>
		                        <th>Nombre de visita</th>
		                        <th>Fecha de visita</th>
		                        <th>Descripción de visita</th>
		                        <th>Documento de visita</th>
		                        <th>Acciones documento</th>
		                    </tr>
		                </thead>
		                <tbody>
		                	<?php if($listaVisitas){ ?>
		                	<?php foreach ($listaVisitas as $key => $visita) { ?>
		                    <tr id="<?php echo $visita['id']; ?>">
		                        <td><?php echo $visita['proyecto_id']." - ".$visita['proy_nombre']; ?></td>
		                        <td><?php echo $visita['nombre']; ?></td>
		                        <td fieldtype="fecha"><?php echo $visita['fecha']; ?></td>
		                        <td><?php echo $visita['descripcion']; ?></td>
		                        <?php if($visita['documento_id']){ ?>
		                        <td fieldtype="desplegable" field="documento_id" valor="<?php echo $visita['documento_id']; ?>"><?php echo $visita['nombre_unico']." - <a href='".$docs_folder.$visita['enlace']."' download>".$visita['enlace']."</a>"; ?></td>
		                    	<?php }else{ ?>
		                    	<td fieldtype="desplegable" field="documento_id" valor="NULL">No asignar aún</td>
		                    	<?php } ?>
		                    	<!--<td><input type="checkbox" name="primer_visita" id="primer_visita" checked/></td>-->
		                        <td>
									<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		                            <a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		                            <a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		                        </td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_visitas"><td colspan="9">No existen registros de visitas en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>
	        </div>
		</div>
	</div>
</div>