<div id="login_container">
	<div class="page_content">

		<div class="module_page">
			<div class="login_form">
			    <form action="<?php echo _MSFW_PATH_ ?>modules/login/login_callback" method="post" target="_self">
			        <h2 class="text-center">Iniciar Sesión</h2>       
			        <div class="form-group">
			            <input type="email" name="email" class="form-control" placeholder="Correo" value="<?php echo $email; ?>" required="required">
			        </div>
			        <div class="form-group">
			            <input type="password" name="password" class="form-control" placeholder="Password" required="required">
			        </div>
			        <div class="form-group">
			            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
			        </div>
			        <div class="clearfix">
			            <a href="<?php echo $ir_recuperar; ?>" class="pull-right">¿Olvidó su contraseña?</a>
			        </div>        
			    </form>
			</div>
		</div>

		
	</div>
</div>