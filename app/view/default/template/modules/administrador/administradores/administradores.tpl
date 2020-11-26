<div id="administradores_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>administradores</b></h2></div>
	                    <div class="col-sm-4 text-right">
	                        <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar Nuevo</button>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-sm-12">Recuerde que las ID y correo de administrador se comparten con todos los usuarios, téngalo en cuenta al momento de hacer creación de uno nuevo, pues NO puede haber una ID ó correo de administrador igual que otro usuario.</div>
	                </div>
	                <div class="row">
	                    <div class="col-sm-12">Recuerde que la contraseña por defecto para los nuevos administradores creados será: <strong><?php echo $default_pw; ?></strong>.</div>
	                </div>
	            </div>
	            <div class="row cont_table">
		            <table id="tabla_administradores" class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th>ID administrador</th>
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Correo</th>
								<th>Teléfono</th>
								<th>Contacto</th>
								<th>Ciudad</th>
								<th>Rol</th>
								<th>Acciones</th>
		                    </tr>
		                </thead>
		                <tbody>
		                	<?php if($listaAdministradores){ ?>
		                	<?php foreach ($listaAdministradores as $key => $administrador) { ?>
		                    <tr id="<?php echo $administrador['id']; ?>">
		                        <td fieldtype="numero"><?php echo $administrador['id']; ?></td>
		                        <td><?php echo $administrador['nombres']; ?></td>
		                        <td><?php echo $administrador['apellidos']; ?></td>
		                        <td><?php echo $administrador['correo']; ?></td>
		                        <td><?php echo $administrador['telefono']; ?></td>
		                        <td><?php echo $administrador['contacto']; ?></td>
		                        <td fieldtype="desplegable" field="ciudad_dane" valor="<?php echo $administrador['ciudad_dane']; ?>"><?php echo $administrador['codigo_dane']." - ".$administrador['ciudad']; ?></td>
		                        <td fieldtype="desplegable" field="rol_id" valor="<?php echo $administrador['rol_id']; ?>"><?php echo $administrador['rol_id']." - ".$administrador['nombre_unico']; ?></td>
		                        <td>
									<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		                            <a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		                            <a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		                        </td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_administradores"><td colspan="10">No existen registros de administradores en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>
	        </div>
		</div>
	</div>
</div>
