<!doctype html>
<html>
	<head>
		<meta charset="<?php echo _CHARSET_; ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
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
<?php if($controlador != "login" && $controlador != "recuperar"){ ?>


<div id="header_container">
	<div class="page_content">


		<!--	REPORTE DE ERRORES	-->
		<div class="alertsContainer">
			<?php if(isset($exito)&&($exito != '')){ ?>
				<div class="alert alert-success alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<?php echo utf8_decode($exito); ?>
				</div>
			<?php } ?>
			<?php if(isset($peligro)&&($peligro != '')){ ?>
				<div class="alert alert-danger alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<?php echo utf8_decode($peligro); ?>
				</div>
			<?php } ?>
			<?php if(isset($info)&&($info != '')){ ?>
				<div class="alert alert-info alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<?php echo utf8_decode($info); ?>
				</div>
			<?php } ?>
			<?php if(isset($alerta)&&($alerta != '')){ ?>
				<div class="alert alert-warning alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<?php echo utf8_decode($alerta); ?>
				</div>
			<?php } ?>
		</div>


		<!--	INICIA LA MAQUETACIÓN DEL HEADER	-->
		<div class="contenedor_cabecera">
			<div class="areaNavegacionResponsive">
				<div class="cont_botonera">
					<!--	SE DEJA SIN ENTER EL NAV PARA QUE NO TOME ESPACIOS EN MOZILLA	-->
					<nav class="botonNaveg<?php echo ($controlador=='home')?' menuActual':'' ?>" onclick="MSHeader.navegar('<?php echo $ir_home; ?>');">
						<div class="cont_imagen">
							<img src="<?php echo _MSFW_PATH_._VIEW_PATH_; ?>default/_img/common/header/home.png" class="imagen" width="100%" height="100%" />
						</div>
					</nav><nav class="botonNaveg<?php echo ($controlador=='rankingsemanal')?' menuActual':'' ?>" onclick="MSHeader.navegar('<?php echo $ir_rankingsemanal; ?>');">
						<div class="cont_imagen">
							<img src="<?php echo _MSFW_PATH_._VIEW_PATH_; ?>default/_img/common/header/rankingsemanal.png" class="imagen" width="100%" height="100%" />
						</div>
					</nav><nav class="botonNaveg<?php echo ($controlador=='rankinggeneral')?' menuActual':'' ?>" onclick="MSHeader.navegar('<?php echo $ir_rankinggeneral; ?>');">
						<div class="cont_imagen">
							<img src="<?php echo _MSFW_PATH_._VIEW_PATH_; ?>default/_img/common/header/rankinggeneral.png" class="imagen" width="100%" height="100%" />
						</div>
					</nav><nav class="botonNaveg<?php echo ($controlador=='historial')?' menuActual':'' ?>" onclick="MSHeader.navegar('<?php echo $ir_historial; ?>');">
						<div class="cont_imagen">
							<img src="<?php echo _MSFW_PATH_._VIEW_PATH_; ?>default/_img/common/header/historial.png" class="imagen" width="100%" height="100%" />
						</div>
					</nav><nav class="botonNaveg<?php echo ($controlador=='perfil')?' menuActual':'' ?>" onclick="MSHeader.navegar('<?php echo $ir_perfil; ?>');">
						<div class="cont_imagen">
							<img src="<?php echo _MSFW_PATH_._VIEW_PATH_; ?>default/_img/common/header/perfil.png" class="imagen" width="100%" height="100%" />
						</div>
					</nav>
				</div>
			</div>
			<div class="areaNavegacionEscritorio">
				<div class="cont_botonera">
					<!--	SE DEJA SIN ENTER EL NAV PARA QUE NO TOME ESPACIOS EN MOZILLA	-->
					<nav class="botonNaveg<?php echo ($controlador=='home')?' menuActual':'' ?>" onclick="MSHeader.navegar('<?php echo $ir_home; ?>');">
						<span class="texto">Home</span>
					</nav><nav class="botonNaveg<?php echo ($controlador=='rankingsemanal')?' menuActual':'' ?>" onclick="MSHeader.navegar('<?php echo $ir_rankingsemanal; ?>');">
						<span class="texto">Ranking semanal</span>
					</nav><nav class="botonNaveg<?php echo ($controlador=='rankinggeneral')?' menuActual':'' ?>" onclick="MSHeader.navegar('<?php echo $ir_rankinggeneral; ?>');">
						<span class="texto">Ranking general</span>
					</nav><nav class="botonNaveg<?php echo ($controlador=='historial')?' menuActual':'' ?>" onclick="MSHeader.navegar('<?php echo $ir_historial; ?>');">
						<span class="texto">Historial de juegos</span>
					</nav><nav class="botonNaveg<?php echo ($controlador=='perfil')?' menuActual':'' ?>" onclick="MSHeader.navegar('<?php echo $ir_perfil; ?>');">
						<span class="texto">Perfil</span>
					</nav>
				</div>
			</div>
			<div class="areaInformativa" align="right">
				<div class="cont_info">
					<div class="info">
						<span><?php echo utf8_decode($usuario->nombres).' '.utf8_decode($usuario->apellidos); ?></span>
						<a href="<?php echo $ir_cerrar_sesion; ?>" >Cerrar sesión</a>
					</div>
				</div>
			</div>
		</div>
		<!--	FINALIZA LA MAQUETACIÓN DEL HEADER	-->
	</div>
</div>
</body>


<?php }?>