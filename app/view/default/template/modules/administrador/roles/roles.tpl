<div id="roles_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>roles</b> de la plataforma</h2></div>
	                </div>
	            </div>
	            <div class="row cont_table">
		            <table id="tabla_roles" class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th width="20%">ID Rol</th>
		                        <th width="20%">Rol</th>
		                        <th width="60%">Descripción</th>
		                    </tr>
		                </thead>
		                <tbody>
		                	<?php if($listaRoles){ ?>
		                	<?php foreach ($listaRoles as $key => $rol) { ?>
		                    <tr id="<?php echo $rol['id']; ?>">
		                    	<td><?php echo $rol['id']; ?></td>
		                    	<td><?php echo $rol['nombre_unico']; ?></td>
		                    	<td><?php echo $rol['description']; ?></td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_roles"><td colspan="10">No existen registros de roles en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>
	        </div>
		</div>
	</div>
</div>
