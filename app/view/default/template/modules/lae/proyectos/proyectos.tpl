<div id="proyectos_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>proyectos</b></h2></div>
	                    <div class="col-sm-4 text-right">
	                        <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar Nuevo</button>
	                    </div>
	                </div>
	            </div>
	            <div class="row cont_table">
		            <table id="tabla_proyectos" class="table table-bordered">
		                <thead class="tb_head">
		                    <tr>
		                        <th colspan="5">Proyecto</th>
		                        <th rowspan="2">Emprendedor</th>
		                        <th rowspan="2">Interventor</th>
		                        <th rowspan="2">Número de convocatoria</th>
		                        <th rowspan="2">Centro de negocios</th>
		                        <th rowspan="2">Acciones</th>
		                    </tr>
		                    <tr>
		                    	<th>ID</th>
		                    	<th>Nombre</th>
		                    	<th>Objetivo</th>
		                    	<th>Fecha asignación</th>
		                    	<th>Número contrato</th>
		                    </tr>
		                </thead>
		                <tbody>
		                	<?php if($listaProyectos){ ?>
		                	<?php foreach ($listaProyectos as $key => $proyecto) { ?>
		                    <tr id="<?php echo $proyecto['id']; ?>">
		                        <td fieldtype="numero"><?php echo $proyecto['id']; ?></td>
		                        <td><?php echo $proyecto['nombre']; ?></td>
		                        <td><?php echo $proyecto['objetivo']; ?></td>
		                        <td fieldtype="fecha"><?php echo $proyecto['fecha_asignacion']; ?></td>
		                        <td><?php echo $proyecto['numero_contrato']; ?></td>
		                        <td fieldtype="desplegable" field="emprendedor_id" valor="<?php echo $proyecto['emprendedor_id']; ?>"><?php echo $proyecto['emprendedor_id']." - ".$proyecto['emprend_nombres']." ".$proyecto['emprend_apellidos']; ?></td>
		                        <td fieldtype="desplegable" field="interventor_id" valor="<?php echo $proyecto['interventor_id']; ?>"><?php echo $proyecto['interventor_id']." - ".$proyecto['interv_nombres']." ".$proyecto['interv_apellidos']; ?></td>
		                        <td fieldtype="desplegable" field="convocatoria_numero" valor="<?php echo $proyecto['convocatoria_numero']; ?>"><?php echo $proyecto['convocatoria_numero']." / ".$proyecto['convoc_fecha']; ?></td>
		                        <td fieldtype="desplegable" field="centro_negocios_id" valor="<?php echo $proyecto['centro_negocios_id']; ?>"><?php echo $proyecto['centro_negocios_id']." - ".$proyecto['centroneg_nombre']; ?></td>
		                        <td>
									<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		                            <a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		                            <a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		                        </td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_proyectos"><td colspan="10">No existen registros de proyectos en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>
	        </div>
		</div>
	</div>
</div>