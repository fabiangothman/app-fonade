<div id="usuarios_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>todos los usuarios</b></h2></div>
	                    <div class="col-sm-4 text-right">
	                        <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar Nuevo</button>
	                    </div>
	                </div>
	            </div>
	            <div class="row cont_table">
		            <table id="tabla_usuarios" class="table table-bordered">
		                <thead>
		                    <tr>
								<th>ID Usuario</th>
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Correo</th>
								<th>Contraseña</th>
								<th>Teléfono</th>
								<th>Contacto</th>
								<th>Ciudad</th>
								<th>Rol</th>
								<th>LAE Asignado</th>
								<th>Acciones</th>
		                    </tr>
		                </thead>
		                <tbody>
		                	<?php if($listaUsuarios){ ?>
		                	<?php foreach ($listaUsuarios as $key => $usuario) { ?>
		                    <tr id="<?php echo $usuario['id']; ?>">
								<td fieldtype="number"><?php echo $usuario['id']; ?></td>
								<td><?php echo $usuario['nombres']; ?></td>
								<td><?php echo $usuario['apellidos']; ?></td>
								<td fieldtype="email"><?php echo $usuario['correo']; ?></td>
								<td fieldtype="password">Dejar vacío si no quiere actualizar</td>
								<td><?php echo $usuario['telefono']; ?></td>
								<td><?php echo $usuario['contacto']; ?></td>
								<td fieldtype="desplegable" field="ciudad_dane" valor="<?php echo $usuario['ciudad_dane']; ?>"><?php echo $usuario['codigo_dane']." - ".$usuario['ciudad']; ?></td>
		                        <td fieldtype="desplegable" field="rol_id" valor="<?php echo $usuario['rol_id']; ?>"><?php echo $usuario['rol_id']." - ".$usuario['nombre_unico']; ?></td>
		                        <td fieldtype="desplegable" field="lae_id" valor="<?php echo $usuario['lae_id']; ?>"><?php echo $usuario['lae_id']." - ".$usuario['lae_nombres']." ".$usuario['lae_apellidos']; ?></td>
		                        <td>
									<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		                            <a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		                            <a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		                        </td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_usuarios"><td colspan="10">No existen registros de usuarios en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>
	        </div>
		</div>
	</div>
</div>
