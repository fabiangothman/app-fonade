<div id="home_container">
	<div class="page_content">

		<!--	REPORTE DE ERRORES	-->
		<div class="alertsContainer">
			<?php if(isset($exito)&&($exito != '')){ ?>
				<div class="alert alert-success alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<?php echo utf8_encode($exito); ?>
				</div>
			<?php } ?>
			<?php if(isset($peligro)&&($peligro != '')){ ?>
				<div class="alert alert-danger alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<?php echo utf8_encode($peligro); ?>
				</div>
			<?php } ?>
			<?php if(isset($info)&&($info != '')){ ?>
				<div class="alert alert-info alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<?php echo utf8_encode($info); ?>
				</div>
			<?php } ?>
			<?php if(isset($alerta)&&($alerta != '')){ ?>
				<div class="alert alert-warning alert-dismissable">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
					<?php echo utf8_encode($alerta); ?>
				</div>
			<?php } ?>
		</div>

		<div class="modulo_page">
	        <div class="table-wrapper">
	            <div class="table-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Home <b>FONADE</b></h2></div>
	                </div>
	            </div>
	        </div>
		</div>
	</div>
</div>
