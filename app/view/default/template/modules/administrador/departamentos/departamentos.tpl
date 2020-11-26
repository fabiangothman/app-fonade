<div id="departamentos_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>departamentos</b></h2></div>
	                    <div class="col-sm-4 text-right">
	                        <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar Nuevo</button>
	                    </div>
	                </div>
	            </div>
	            <div class="row cont_table">
		            <table id="tabla_departamentos" class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th>Código dane</th>
		                        <th>Departamento</th>
		                        <th>Región</th>
		                        <th>Acciones</th>
		                    </tr>
		                </thead>
		                <tbody>
		                	<?php if($listaDepartamentos){ ?>
		                	<?php foreach ($listaDepartamentos as $key => $departamento) { ?>
		                    <tr id="<?php echo $departamento['codigo_dane']; ?>">
		                    	<td fieldtype="numero"><?php echo $departamento['codigo_dane']; ?></td>
		                    	<td><?php echo $departamento['departamento']; ?></td>
		                    	<td fieldtype="desplegable" field="region_id" valor="<?php echo $departamento['region_id']; ?>"><?php echo $departamento['region']; ?></td>
		                        <td>
									<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		                            <a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		                            <a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		                        </td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_departamentos"><td colspan="10">No existen registros de departamentos en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>
	        </div>
		</div>
	</div>
</div>
