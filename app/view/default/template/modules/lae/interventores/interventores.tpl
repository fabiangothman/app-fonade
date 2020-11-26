<div id="interventores_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>interventores</b></h2></div>
	                </div>
	                <div class="row">
	                    <div class="col-sm-12">Esta es la lista de interventores que tiene a su cargo.</div>
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
