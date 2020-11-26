<div id="interventores_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>interventores</b></h2></div>
	                    <div class="col-sm-4 text-right">
	                        <button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Agregar Nuevo</button>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-sm-12">Recuerde que las ID y correo de interventor se comparten con todos los usuarios, téngalo en cuenta al momento de hacer creación de uno nuevo, pues NO puede haber una ID ó correo de interventor igual que otro usuario.</div>
	                </div>
	                <div class="row">
	                    <div class="col-sm-12">Recuerde que la contraseña por defecto para los nuevos interventores creados será: <strong><?php echo $default_pw; ?></strong>.</div>
	                </div>
	            </div>
	            <div class="row cont_table">
		            <table id="tabla_interventores" class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th>ID interventor</th>
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Correo</th>
								<th>Teléfono</th>
								<th>Contacto</th>
								<th>Ciudad</th>
								<th>Rol</th>
								<th>LAE Asignado</th>
								<th>Acciones</th>
		                    </tr>
		                </thead>
		                <tbody>
		                	<?php if($listaInterventores){ ?>
		                	<?php foreach ($listaInterventores as $key => $interventor) { ?>
		                    <tr id="<?php echo $interventor['id']; ?>">
		                        <td fieldtype="numero"><?php echo $interventor['id']; ?></td>
		                        <td><?php echo $interventor['nombres']; ?></td>
		                        <td><?php echo $interventor['apellidos']; ?></td>
		                        <td><?php echo $interventor['correo']; ?></td>
		                        <td><?php echo $interventor['telefono']; ?></td>
		                        <td><?php echo $interventor['contacto']; ?></td>
		                        <td fieldtype="desplegable" field="ciudad_dane" valor="<?php echo $interventor['ciudad_dane']; ?>"><?php echo $interventor['codigo_dane']." - ".$interventor['ciudad']; ?></td>
		                        <td fieldtype="desplegable" field="rol_id" valor="<?php echo $interventor['rol_id']; ?>"><?php echo $interventor['rol_id']." - ".$interventor['nombre_unico']; ?></td>
		                        <td fieldtype="desplegable" field="lae_id" valor="<?php echo $interventor['lae_id']; ?>"><?php echo $interventor['lae_id']." - ".$interventor['lae_nombres']." ".$interventor['lae_apellidos']; ?></td>
		                        <td>
									<a class="add" title="Agregar" data-toggle="tooltip"><i class="material-icons">&#xE03B;</i></a>
		                            <a class="edit" title="Editar" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
		                            <a class="delete" title="Eliminar" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
		                        </td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_interventores"><td colspan="10">No existen registros de interventores en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>
	        </div>
		</div>
	</div>
</div>
