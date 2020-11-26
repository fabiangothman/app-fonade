<div id="emprendedores_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>mis emprendedores</b></h2></div>
	                </div>
	            </div>
	            <div class="row cont_table">
		            <table id="tabla_emprendedores" class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th>ID emprendedor</th>
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
		                	<?php if($listaEmprendedores){ ?>
		                	<?php foreach ($listaEmprendedores as $key => $emprendedor) { ?>
		                    <tr id="<?php echo $emprendedor['id']; ?>">
		                        <td fieldtype="numero"><?php echo $emprendedor['id']; ?></td>
		                        <td><?php echo $emprendedor['nombres']; ?></td>
		                        <td><?php echo $emprendedor['apellidos']; ?></td>
		                        <td><?php echo $emprendedor['correo']; ?></td>
		                        <td><?php echo $emprendedor['telefono']; ?></td>
		                        <td><?php echo $emprendedor['contacto']; ?></td>
		                        <td fieldtype="desplegable" field="ciudad_dane" valor="<?php echo $emprendedor['ciudad_dane']; ?>"><?php echo $emprendedor['codigo_dane']." - ".$emprendedor['ciudad']; ?></td>
		                        <td fieldtype="desplegable" field="rol_id" valor="<?php echo $emprendedor['rol_id']; ?>"><?php echo $emprendedor['rol_id']." - ".$emprendedor['nombre_unico']; ?></td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_emprendedores"><td colspan="10">No existen registros de emprendedores en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>
	        </div>
		</div>
	</div>
</div>
