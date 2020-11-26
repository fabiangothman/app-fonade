<div id="laes_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>LAE</b> asignado</h2></div>
	                </div>
	                <div class="row">
	                    <div class="col-sm-12">Este es el usuario LAE que tiene asociado</strong>.</div>
	                </div>
	            </div>
	            <div class="row cont_table">
		            <table id="tabla_laes" class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th>ID de LAE</th>
								<th>Nombres</th>
								<th>Apellidos</th>
								<th>Correo</th>
								<th>Teléfono</th>
								<th>Contacto</th>
								<th>Ciudad</th>
								<th>Rol</th>
		                    </tr>
		                </thead>
		                <tbody>
		                	<?php if($listaLaes){ ?>
		                	<?php foreach ($listaLaes as $key => $lae) { ?>
		                    <tr id="<?php echo $lae['id']; ?>">
		                        <td fieldtype="numero"><?php echo $lae['id']; ?></td>
		                        <td><?php echo $lae['nombres']; ?></td>
		                        <td><?php echo $lae['apellidos']; ?></td>
		                        <td><?php echo $lae['correo']; ?></td>
		                        <td><?php echo $lae['telefono']; ?></td>
		                        <td><?php echo $lae['contacto']; ?></td>
		                        <td fieldtype="desplegable" field="ciudad_dane" valor="<?php echo $lae['ciudad_dane']; ?>"><?php echo $lae['codigo_dane']." - ".$lae['ciudad']; ?></td>
		                        <td fieldtype="desplegable" field="rol_id" valor="<?php echo $lae['rol_id']; ?>"><?php echo $lae['rol_id']." - ".$lae['nombre_unico']; ?></td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_laes"><td colspan="10">No existen registros de LAEs en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>
	        </div>
		</div>
	</div>
</div>
