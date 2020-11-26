<div id="centro_negocios_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>Centro de negocios</b></h2></div>
	                    <div class="col-sm-4 text-right">
	                        <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar Nuevo</button>
	                    </div>
	                </div>
	            </div>
	            <div class="row cont_table">
		            <table id="tabla_centro_negocios" class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th>ID Centro de Negocios</th>
		                        <th>Ciudad</th>
		                        <th>Nombre</th>
		                        <th>Descripcion</th>
		                        <th>Acciones</th>
		                    </tr>
		                </thead>
		                <tbody>
		                	<?php if($listaCentro_negocios){ ?>
		                	<?php foreach ($listaCentro_negocios as $key => $centro_negocio) { ?>
		                    <tr id="<?php echo $centro_negocio['id']; ?>">
		                    	<td fieldtype="numero"><?php echo $centro_negocio['id']; ?></td>
		                    	<td fieldtype="desplegable" field="ciudad_dane" valor="<?php echo $centro_negocio['codigo_dane']; ?>"><?php echo $centro_negocio['codigo_dane']." - ".$centro_negocio['ciudad']; ?></td>
		                    	<td><?php echo $centro_negocio['nombre']; ?></td>
		                    	<td><?php echo $centro_negocio['descripcion']; ?></td>
		                        <td>
									<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		                            <a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		                            <a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		                        </td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_centro_negocios"><td colspan="10">No existen registros de centros de negocios en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>
	        </div>
		</div>
	</div>
</div>
