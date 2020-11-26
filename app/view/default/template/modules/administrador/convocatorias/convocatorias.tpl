<div id="convocatorias_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>convocatorias</b></h2></div>
	                    <div class="col-sm-4 text-right">
	                        <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar Nuevo</button>
	                    </div>
	                </div>
	            </div>
	            <div class="row cont_table">
		            <table id="tabla_convocatorias" class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th>Número</th>
		                        <th>Fecha</th>
		                        <th>Descripción</th>
		                        <th>Acciones</th>
		                    </tr>
		                </thead>
		                <tbody>
		                	<?php if($listaConvocatorias){ ?>
		                	<?php foreach ($listaConvocatorias as $key => $convocatoria) { ?>
		                    <tr id="<?php echo $convocatoria['numero']; ?>">
		                        <td fieldtype="numero"><?php echo $convocatoria['numero']; ?></td>
		                        <td fieldtype="fecha"><?php echo $convocatoria['fecha']; ?></td>
		                        <td><?php echo $convocatoria['descripcion']; ?></td>
		                        <td>
									<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		                            <a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		                            <a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		                        </td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_convocatorias"><td colspan="9">No existen registros de convocatorias en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>
	        </div>
		</div>
	</div>
</div>