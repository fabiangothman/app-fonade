<div id="perfil_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="container">
	        	<div class="col-sm-12 titulo">
	        		<h2>Editar <b>perfil</b></h2>
	        		<hr />
	        	</div>
				<div class="row">
					<form action="<?php echo _MSFW_PATH_; ?>modules/<?php echo $rolFront; ?>/perfil/perfil_callback/[iframe]/" method="post" target="_self" enctype="multipart/form-data" class="form-horizontal" role="form">
						<!-- left column -->
						<div class="col-md-3">
							<div class="text-center profilepic">
								<?php if($profilepicurl==null){ ?>
								<img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
								<?php }else{ ?>
								<img src="<?php echo $profilepicurl; ?>" class="avatar img-circle" alt="avatar">
								<input type="hidden" name="currentimage" value="<?php echo $usuario['imagen']; ?>" />
								<?php } ?>
								<h6>Cambiar foto de perfil...</h6>
								<input type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg" name="subefoto">
							</div>
						</div>
						<!-- edit form column -->
						<div class="col-md-9 personal-info">
							<br />
							<div class="form-group">
								<label class="col-lg-3 control-label">Nombre:</label>
								<div class="col-lg-8">
									<input required class="form-control" type="text" value="<?php echo $usuario['nombres']; ?>" name="nombres" maxlength="60" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Apellido:</label>
								<div class="col-lg-8">
									<input required class="form-control" type="text" value="<?php echo $usuario['apellidos']; ?>" name="apellidos" maxlength="60" />
								</div>
							</div>
							<input required type="hidden" name="id" value="<?php echo $usuario['id']; ?>" />
							<div class="form-group">
								<label class="col-lg-3 control-label">Correo:</label>
								<div class="col-lg-8">
									<input required class="form-control" type="email" value="<?php echo $usuario['correo']; ?>" name="email" maxlength="60" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Teléfono:</label>
								<div class="col-lg-8">
									<input required class="form-control" type="text" value="<?php echo $usuario['telefono']; ?>" name="telefono" maxlength="60" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Contacto:</label>
								<div class="col-lg-8">
									<input required class="form-control" type="text" value="<?php echo $usuario['contacto']; ?>" name="contacto" maxlength="60" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Ciudad:</label>
								<div class="col-lg-8">
									<?php if(count($listaCiudades)>0){ ?>
									<select name="ciudad_dane" required class="form-control">
										<?php foreach ($listaCiudades as $key => $ciudad) { ?>
											<?php if($usuario['ciudad_dane']==$ciudad['codigo_dane']){ ?>
											<option value="<?php echo $ciudad['codigo_dane'];?>" selected><?php echo $ciudad['codigo_dane']." - ".$ciudad['ciudad'];?></option>
											<?php }else{ ?>
											<option value="<?php echo $ciudad['codigo_dane'];?>"><?php echo $ciudad['codigo_dane']." - ".$ciudad['ciudad'];?></option>
											<?php } ?>
										<?php } ?>
									</select>
									<?php }else{ ?>
									<label class="col-lg-8 control-label-left">No hay ciudades cargadas en el sistema</label>
									<?php } ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Rol:</label>
								<label class="col-lg-8 control-label-left"><?php echo (is_null($usuario['rol_id'])) ? "No tiene Rol asignado" : $usuario['rol_id']." - ".$usuario['nombre_unico']; ?></label>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">LAE:</label>
								<label class="col-lg-8 control-label-left"><?php echo (is_null($usuario['lae_id'])) ? "No tiene un usuario LAE asignado. Sólo los usuarios con rol de Interventores cuentan con LAE asignado." : $usuario['lae_nombres']." ".$usuario['lae_apellidos']; ?></label>
							</div>
							<hr class="espaciador" />
							<div class="form-group">
								<label class="col-md-3 control-label">Nueva contraseña:</label>
								<div class="col-md-8">
									<input class="form-control" type="password" value="" name="password" maxlength="32" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Confirmar contraseña:</label>
								<div class="col-md-8">
									<input class="form-control" type="password" value="" name="passwordconfirmation" maxlength="32" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8">(Dejar los campos vacíos si no quiere cambiar la contraseña)</div>
							</div>
							<hr />
							<div class="form-group">
								<label class="col-md-3 control-label"></label>
								<div class="col-md-8">
									<input type="submit" class="btn btn-primary" value="Guardar cambios">
									<span></span>
									<input type="reset" class="btn btn-default" value="Cancelar">
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>