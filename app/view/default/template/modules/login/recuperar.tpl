<div id="recuperar_container">
  <div class="page_content">


    <!--  REPORTE DE ERRORES  -->
    <div class="alertsContainer">
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
    <div class="module_page">
      <div class="login_form">
          <form action="<?php echo _MSFW_PATH_ ?>modules/login/recuperar_callback" method="post" target="_self">
              <h2 class="text-center">Recuperar clave</h2>       
              <div class="form-group">
                  <input type="email" name="email" class="form-control" placeholder="Correo"  maxlength="200" required="required" value="<?php echo $email; ?>">
              </div>
              <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-block">Recuperar</button>
              </div>
              <div class="clearfix">
                  <a href="<?php echo $ir_volver; ?>" class="pull-right">Inicio de sesión</a>
              </div>        
          </form>
      </div>
    </div>

  </div>
</div>