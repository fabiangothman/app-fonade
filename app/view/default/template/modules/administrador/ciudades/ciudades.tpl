<div id="ciudades_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>ciudades</b></h2></div>
	                    <div class="col-sm-4 text-right">
	                        <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar Nuevo</button>
	                    </div>
	                </div>
	            </div>
	            <div class="row cont_table">
		            <table id="tabla_ciudades" class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th>Código dane</th>
		                        <th>Ciudad</th>
		                        <th>Departamento</th>
		                        <th>Acciones</th>
		                    </tr>
		                </thead>
		                <tbody>
		                	<?php if($listaCiudades){ ?>
		                	<?php foreach ($listaCiudades as $key => $ciudad) { ?>
		                    <tr id="<?php echo $ciudad['c_codigo_dane']; ?>">
		                    	<td><?php echo $ciudad['c_codigo_dane']; ?></td>
		                    	<td><?php echo $ciudad['ciudad']; ?></td>
		                    	<td fieldtype="desplegable" field="departamento_dane" valor="<?php echo $ciudad['d_codigo_dane']; ?>"><?php echo $ciudad['d_codigo_dane']." - ".$ciudad['departamento']; ?></td>
		                        <td>
									<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		                            <a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		                            <a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		                        </td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_ciudades"><td colspan="10">No existen registros de ciudades en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>
	        </div>
		</div>
	</div>
</div>
