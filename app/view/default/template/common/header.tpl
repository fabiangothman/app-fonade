<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="<?php echo _CHARSET_; ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />
		<title><?php echo $title; ?></title>
		<link rel="shortcut icon" href="<?php echo _MSFW_PATH_._DEFAULT_VIEW_PATH_; ?>_img/common/favicon.ico"/>
		<?php foreach ($links as $link) { ?>
		<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
		<?php } ?>
		<?php foreach ($styles as $style) { ?>
		<link rel="<?php echo $style['rel']; ?>" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
		<?php } ?>
		<?php foreach ($jQueryScripts as $jQueryScript) { ?>
		<script src="<?php echo $jQueryScript['src']; ?>"></script>
		    <?php if($jQueryScript['id'] != "$"){ ?>
		    <script type="text/javascript">
		    	var <?php echo $jQueryScript['id']; ?> = $.noConflict(true);
		    </script>
		    <?php } ?>
		<?php } ?>
		<?php foreach ($scripts as $script) { ?>
		<script src="<?php echo $script; ?>"></script>
		<?php } ?>
		<script>
		<!--
		jQuery(document).ready(function(){
			<?php foreach ($in_readyCodes as $in_readyCode) { ?>
				<?php echo $in_readyCode; ?>
			<?php } ?>
		});
		<?php foreach ($in_scripts as $in_script) { ?>
			<?php echo $in_script; ?>
			<?php } ?>
		//-->
		</script>
	</head>
<body id="body">
<!--[if lt IE 9]>
<div id="IEFix"></div>
<![endif]-->



<div id="header_container">
	<?php if($controlador != "login" && $controlador != "recuperar"){ ?>
	<div class="page_content">

		<nav class="navbar navbar-inverse navbar-expand-xl navbar-dark">
			<div class="navbar-header d-flex col">
				<a class="navbar-brand" href="<?php echo $ir_home; ?>"><i class="fa fa-pie-chart"></i><b><?php echo $app_name; ?></b></a>  		
				<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
					<span class="navbar-toggler-icon"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<!-- Collection of nav links, forms, and other content for toggling -->
			<div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
				<?php if($rol_usuario=="administrador"){ ?>
				<!--	Inicio Header administrador	-->
				<ul class="nav navbar-nav navbar-right ml-auto">
					<!--<li class="nav-item<?php echo ($controlador=='home')?' active':''; ?>"><a href="<?php echo $ir_home; ?>" class="nav-link"><i class="fa fa-home"></i><span>Home</span></a></li>-->
					<li class="nav-item<?php echo ($controlador=='usuarios')?' active':''; ?>">
						<a href="#" data-toggle="dropdown" class="nav-link"><i class="fa fa-user-circle"></i><span>Usuarios <b class="caret"></b></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_usuarios; ?>" class="dropdown-item"><i class="fa fa-user-circle"></i> Usuarios</a></li>
							<li><a href="<?php echo $ir_emprendedores; ?>" class="dropdown-item"><i class="fa fa-users"></i> Emprendedores</a></li>
							<li><a href="<?php echo $ir_interventores; ?>" class="dropdown-item"><i class="fa fa-pie-chart"></i> Interventores</a></li>
							<li><a href="<?php echo $ir_laes; ?>" class="dropdown-item"><i class="fa fa-user-circle"></i> LAEs</a></li>
							<li><a href="<?php echo $ir_administradores; ?>" class="dropdown-item"><i class="fa fa-user-circle"></i> Administradores</a></li>
							<li><a href="<?php echo $ir_roles; ?>" class="dropdown-item"><i class="fa fa-user-times"></i> Roles</a></li>
						</ul>
					</li>
					<li class="nav-item<?php echo ($controlador=='ciudades')?' active':''; ?>"><a href="#" data-toggle="dropdown" class="nav-link"><i class="fa fa-street-view"></i><span>Ciudades <b class="caret"></b></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_ciudades; ?>" class="dropdown-item"><i class="fa fa-street-view"></i> Ciudades</a></li>
							<li><a href="<?php echo $ir_departamentos; ?>" class="dropdown-item"><i class="fa fa-subway"></i> Departamentos</a></li>
							<li><a href="<?php echo $ir_regiones; ?>" class="dropdown-item"><i class="fa fa-tree"></i> Regiones</a></li>
						</ul>
					</li>
					<li class="nav-item<?php echo ($controlador=='proyectos')?' active':''; ?>">
						<a href="#" data-toggle="dropdown" class="nav-link"><i class="fa fa-building-o"></i><span>Proyectos <b class="caret"></b></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_proyectos; ?>" class="dropdown-item"><i class="fa fa-building-o"></i> Proyectos</a></li>
							<li><a href="<?php echo $ir_visitas; ?>" class="dropdown-item"><i class="fa fa-address-book"></i> Visitas</a></li>
							<li><a href="<?php echo $ir_centro_negocios; ?>" class="dropdown-item"><i class="fa fa-university"></i> Centro de Negocios</a></li>
							<li><a href="<?php echo $ir_convocatorias; ?>" class="dropdown-item"><i class="fa fa-flag"></i> Convocatorias</a></li>
						</ul>
					</li>
					<li class="nav-item<?php echo ($controlador=='emprendedores')?' active':''; ?>">
						<a href="#" data-toggle="dropdown" class="nav-link"><i class="fa fa-users"></i><span>Emprendedores </span><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_emprendedores; ?>" class="dropdown-item"><i class="fa fa-users"></i> Emprendedores</a></li>
							<li><a href="<?php echo $ir_documentos_emprendedor; ?>" class="dropdown-item"><i class="fa fa-book"></i> Documentos de Emprendedor</a></li>
						</ul>
					</li>
					<li class="nav-item<?php echo ($controlador=='documentos')?' active':''; ?>"><a href="<?php echo $ir_documentos; ?>" class="nav-link"><i class="fa fa-book"></i><span>Documentos</span></a></li>
					<li class="nav-item<?php echo ($controlador=='calendario')?' active':''; ?>"><a href="<?php echo $ir_calendario; ?>" class="nav-link"><i class="fa fa-calendar-o"></i><span>Calendario</span></a></li>
					<li class="nav-item<?php echo ($controlador=='notificaciones')?' active':''; ?>"><a href="<?php echo $ir_notificaciones; ?>" class="nav-link"><i class="fa fa-bell"><?php if($num_notificaciones>0){ ?><span class="notifi"><?php echo $num_notificaciones; ?></span><?php } ?></i><span>Notificaciones</span></a></li>
					<li class="nav-item dropdown">
						<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action">
							<?php if($profilepicurl==null){ ?>
								<img src="<?php echo $defaultProfileImage; ?>" class="avatar" alt="Avatar">
							<?php }else{ ?>
								<img src="<?php echo $profilepicurl; ?>" class="avatar" alt="Avatar">
							<?php } ?>
							<?php echo " ".$nombre_usuario; ?>
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_perfil; ?>" class="dropdown-item"><i class="fa fa-user-o"></i> Perfil</a></li>
							<li><a href="<?php echo $ir_calendario; ?>" class="dropdown-item"><i class="fa fa-calendar-o"></i> Calendario</a></li>
							<li><a href="<?php echo $ir_reportes; ?>" class="dropdown-item"><i class="fa fa-area-chart"></i> Reportes</a></li>
							<li><a href="<?php echo $ir_cargacsv; ?>" class="dropdown-item"><i class="fa fa-cloud-upload"></i> Carga CSV</a></li>
							<li class="divider dropdown-divider"></li>
							<li><a href="<?php echo $ir_cerrar_sesion; ?>" class="dropdown-item"><i class="material-icons">&#xE8AC;</i> Cerrar sesión</a></li>
						</ul>
					</li>
				</ul>
				<!--	Fin Header administrador	-->
				<?php } ?>
				<?php if($rol_usuario=="interventor"){ ?>
				<!--	Inicio Header interventor	-->
				<ul class="nav navbar-nav navbar-right ml-auto">
					<!--<li class="nav-item<?php echo ($controlador=='home')?' active':''; ?>"><a href="<?php echo $ir_home; ?>" class="nav-link"><i class="fa fa-home"></i><span>Home</span></a></li>-->
					<li class="nav-item<?php echo ($controlador=='usuarios')?' active':''; ?>">
						<a href="#" data-toggle="dropdown" class="nav-link"><i class="fa fa-user-circle"></i><span>Usuarios <b class="caret"></b></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_laes; ?>" class="dropdown-item"><i class="fa fa-user-circle"></i> LAEs</a></li>
							<li><a href="<?php echo $ir_roles; ?>" class="dropdown-item"><i class="fa fa-user-times"></i> Roles</a></li>
						</ul>
					</li>
					<li class="nav-item<?php echo ($controlador=='proyectos')?' active':''; ?>">
						<a href="#" data-toggle="dropdown" class="nav-link"><i class="fa fa-building-o"></i><span>Proyectos <b class="caret"></b></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_proyectos; ?>" class="dropdown-item"><i class="fa fa-building-o"></i> Proyectos</a></li>
							<li><a href="<?php echo $ir_visitas; ?>" class="dropdown-item"><i class="fa fa-address-book"></i> Visitas</a></li>
						</ul>
					</li>
					<li class="nav-item<?php echo ($controlador=='emprendedores')?' active':''; ?>">
						<a href="#" data-toggle="dropdown" class="nav-link"><i class="fa fa-users"></i><span>Emprendedores </span><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_emprendedores; ?>" class="dropdown-item"><i class="fa fa-users"></i> Emprendedores</a></li>
							<li><a href="<?php echo $ir_documentos_emprendedor; ?>" class="dropdown-item"><i class="fa fa-book"></i> Documentos de Emprendedor</a></li>
						</ul>
					</li>
					<li class="nav-item<?php echo ($controlador=='documentos')?' active':''; ?>"><a href="<?php echo $ir_documentos; ?>" class="nav-link"><i class="fa fa-book"></i><span>Documentos</span></a></li>
					<li class="nav-item<?php echo ($controlador=='calendario')?' active':''; ?>"><a href="<?php echo $ir_calendario; ?>" class="nav-link"><i class="fa fa-calendar-o"></i><span>Calendario</span></a></li>
					<li class="nav-item<?php echo ($controlador=='notificaciones')?' active':''; ?>"><a href="<?php echo $ir_notificaciones; ?>" class="nav-link"><i class="fa fa-bell"><?php if($num_notificaciones>0){ ?><span class="notifi"><?php echo $num_notificaciones; ?></span><?php } ?></i><span>Notificaciones</span></a></li>
					<li class="nav-item dropdown">
						<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action">
							<?php if($profilepicurl==null){ ?>
								<img src="<?php echo $defaultProfileImage; ?>" class="avatar" alt="Avatar">
							<?php }else{ ?>
								<img src="<?php echo $profilepicurl; ?>" class="avatar" alt="Avatar">
							<?php } ?>
							<?php echo " ".$nombre_usuario; ?>
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_perfil; ?>" class="dropdown-item"><i class="fa fa-user-o"></i> Perfil</a></li>
							<li><a href="<?php echo $ir_calendario; ?>" class="dropdown-item"><i class="fa fa-calendar-o"></i> Calendario</a></li>
							<li class="divider dropdown-divider"></li>
							<li><a href="<?php echo $ir_cerrar_sesion; ?>" class="dropdown-item"><i class="material-icons">&#xE8AC;</i> Cerrar sesión</a></li>
						</ul>
					</li>
				</ul>
				<!--	Fin Header interventor	-->
				<?php } ?>
				<?php if($rol_usuario=="lae"){ ?>
				<!--	Inicio Header lae	-->
				<ul class="nav navbar-nav navbar-right ml-auto">
					<!--<li class="nav-item<?php echo ($controlador=='home')?' active':''; ?>"><a href="<?php echo $ir_home; ?>" class="nav-link"><i class="fa fa-home"></i><span>Home</span></a></li>-->
					<li class="nav-item<?php echo ($controlador=='usuarios')?' active':''; ?>">
						<a href="#" data-toggle="dropdown" class="nav-link"><i class="fa fa-user-circle"></i><span>Usuarios <b class="caret"></b></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_interventores; ?>" class="dropdown-item"><i class="fa fa-pie-chart"></i> Interventores</a></li>
							<li><a href="<?php echo $ir_roles; ?>" class="dropdown-item"><i class="fa fa-user-times"></i> Roles</a></li>
						</ul>
					</li>
					<li class="nav-item<?php echo ($controlador=='proyectos')?' active':''; ?>">
						<a href="#" data-toggle="dropdown" class="nav-link"><i class="fa fa-building-o"></i><span>Proyectos <b class="caret"></b></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_proyectos; ?>" class="dropdown-item"><i class="fa fa-building-o"></i> Proyectos</a></li>
							<li><a href="<?php echo $ir_visitas; ?>" class="dropdown-item"><i class="fa fa-address-book"></i> Visitas</a></li>
						</ul>
					</li>
					<li class="nav-item<?php echo ($controlador=='emprendedores')?' active':''; ?>">
						<a href="#" data-toggle="dropdown" class="nav-link"><i class="fa fa-users"></i><span>Emprendedores </span><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_emprendedores; ?>" class="dropdown-item"><i class="fa fa-users"></i> Emprendedores</a></li>
							<li><a href="<?php echo $ir_documentos_emprendedor; ?>" class="dropdown-item"><i class="fa fa-book"></i> Documentos de Emprendedor</a></li>
						</ul>
					</li>
					<li class="nav-item<?php echo ($controlador=='documentos')?' active':''; ?>"><a href="<?php echo $ir_documentos; ?>" class="nav-link"><i class="fa fa-book"></i><span>Documentos</span></a></li>
					<li class="nav-item<?php echo ($controlador=='calendario')?' active':''; ?>"><a href="<?php echo $ir_calendario; ?>" class="nav-link"><i class="fa fa-calendar-o"></i><span>Calendario</span></a></li>
					<li class="nav-item<?php echo ($controlador=='notificaciones')?' active':''; ?>"><a href="<?php echo $ir_notificaciones; ?>" class="nav-link"><i class="fa fa-bell"><?php if($num_notificaciones>0){ ?><span class="notifi"><?php echo $num_notificaciones; ?></span><?php } ?></i><span>Notificaciones</span></a></li>
					<li class="nav-item dropdown">
						<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action">
							<?php if($profilepicurl==null){ ?>
								<img src="<?php echo $defaultProfileImage; ?>" class="avatar" alt="Avatar">
							<?php }else{ ?>
								<img src="<?php echo $profilepicurl; ?>" class="avatar" alt="Avatar">
							<?php } ?>
							<?php echo " ".$nombre_usuario; ?>
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_perfil; ?>" class="dropdown-item"><i class="fa fa-user-o"></i> Perfil</a></li>
							<li><a href="<?php echo $ir_calendario; ?>" class="dropdown-item"><i class="fa fa-calendar-o"></i> Calendario</a></li>
							<li class="divider dropdown-divider"></li>
							<li><a href="<?php echo $ir_cerrar_sesion; ?>" class="dropdown-item"><i class="material-icons">&#xE8AC;</i> Cerrar sesión</a></li>
						</ul>
					</li>
				</ul>
				<!--	Fin Header lae	-->
				<?php } ?>
				<?php if($rol_usuario=="emprendedor"){ ?>
				<!--	Inicio Header emprendedor	-->
				<ul class="nav navbar-nav navbar-right ml-auto">
					<!--<li class="nav-item<?php echo ($controlador=='home')?' active':''; ?>"><a href="<?php echo $ir_home; ?>" class="nav-link"><i class="fa fa-home"></i><span>Home</span></a></li>-->
					<li class="nav-item<?php echo ($controlador=='usuarios')?' active':''; ?>">
						<a href="#" data-toggle="dropdown" class="nav-link"><i class="fa fa-user-circle"></i><span>Usuarios <b class="caret"></b></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_interventores; ?>" class="dropdown-item"><i class="fa fa-pie-chart"></i> Interventores</a></li>
							<li><a href="<?php echo $ir_roles; ?>" class="dropdown-item"><i class="fa fa-user-times"></i> Roles</a></li>
						</ul>
					</li>
					<li class="nav-item<?php echo ($controlador=='proyectos')?' active':''; ?>">
						<a href="#" data-toggle="dropdown" class="nav-link"><i class="fa fa-building-o"></i><span>Proyectos <b class="caret"></b></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_proyectos; ?>" class="dropdown-item"><i class="fa fa-building-o"></i> Proyectos</a></li>
							<li><a href="<?php echo $ir_visitas; ?>" class="dropdown-item"><i class="fa fa-address-book"></i> Visitas</a></li>
						</ul>
					</li>
					<li class="nav-item<?php echo ($controlador=='documentos_emprendedor')?' active':''; ?>"><a href="<?php echo $ir_documentos_emprendedor; ?>" class="nav-link"><i class="fa fa-book"></i><span>Documentos de Emprendedor</span></a></li>
					<li class="nav-item<?php echo ($controlador=='documentos')?' active':''; ?>"><a href="<?php echo $ir_documentos; ?>" class="nav-link"><i class="fa fa-book"></i><span>Documentos</span></a></li>
					<li class="nav-item<?php echo ($controlador=='calendario')?' active':''; ?>"><a href="<?php echo $ir_calendario; ?>" class="nav-link"><i class="fa fa-calendar-o"></i><span>Calendario</span></a></li>
					<li class="nav-item<?php echo ($controlador=='notificaciones')?' active':''; ?>"><a href="<?php echo $ir_notificaciones; ?>" class="nav-link"><i class="fa fa-bell"><?php if($num_notificaciones>0){ ?><span class="notifi"><?php echo $num_notificaciones; ?></span><?php } ?></i><span>Notificaciones</span></a></li>
					<li class="nav-item dropdown">
						<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action">
							<?php if($profilepicurl==null){ ?>
								<img src="<?php echo $defaultProfileImage; ?>" class="avatar" alt="Avatar">
							<?php }else{ ?>
								<img src="<?php echo $profilepicurl; ?>" class="avatar" alt="Avatar">
							<?php } ?>
							<?php echo " ".$nombre_usuario; ?>
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo $ir_perfil; ?>" class="dropdown-item"><i class="fa fa-user-o"></i> Perfil</a></li>
							<li><a href="<?php echo $ir_calendario; ?>" class="dropdown-item"><i class="fa fa-calendar-o"></i> Calendario</a></li>
							<li class="divider dropdown-divider"></li>
							<li><a href="<?php echo $ir_cerrar_sesion; ?>" class="dropdown-item"><i class="material-icons">&#xE8AC;</i> Cerrar sesión</a></li>
						</ul>
					</li>
				</ul>
				<!--	Fin Header emprendedor	-->
				<?php } ?>
			</div>
		</nav>
	</div>
	<?php } ?>

	<!--	REPORTE DE ERRORES	-->
	<div class="alert_content">
		<?php if(isset($exito)&&($exito != '')){ ?>
			<div class="alert alert-success alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				<?php echo $exito; ?>
			</div>
		<?php } ?>
		<?php if(isset($peligro)&&($peligro != '')){ ?>
			<div class="alert alert-danger alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				<?php echo $peligro; ?>
			</div>
		<?php } ?>
		<?php if(isset($info)&&($info != '')){ ?>
			<div class="alert alert-info alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				<?php echo $info; ?>
			</div>
		<?php } ?>
		<?php if(isset($alerta)&&($alerta != '')){ ?>
			<div class="alert alert-warning alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				<?php echo $alerta; ?>
			</div>
		<?php } ?>
	</div>

	<!--	REPORTE DE ACTUALIZACIONES	-->
	<div class="notify_content">
			<div class="mensajes alert-success alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				<span class="mensajeMostrar"></span>
			</div>
			<div class="mensajes alert-danger alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				<span class="mensajeMostrar"></span>
			</div>
			<div class="mensajes alert-info alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				<span class="mensajeMostrar"></span>
			</div>
			<div class="mensajes alert-warning alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				<span class="mensajeMostrar"></span>
			</div>
	</div>
</div>
</body>