<div id="notificaciones_container">
	<div class="page_content">

		<div class="modulo_page">
	        <div class="mod-wrapper">
	            <div class="mod-title">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>mis notificaciones</b></h2></div>
	                    <div class="col-sm-12">
	                        <p>Aquí se muestran las notificaciones próximas y pasadas de sus interventores y sus emprendedores.</p>
	                    </div>
	                </div>
	            </div>

	            <div class="row">
		            <div class="croma col-sm-12">
		            	<div class="item">
		            		<div class="cuadro bkcolor-blue"></div>
		            		<div class="texto">Notificación con tiempo de reacción de baja prioridad.</div>
		            	</div>
		            	<div class="item">
		            		<div class="cuadro bkcolor-green"></div>
		            		<div class="texto">Notificación con tiempo de reacción prudente (más de <?php echo $notifydays+7;?> días).</div>
		            	</div>
		            	<div class="item">
		            		<div class="cuadro bkcolor-orange"></div>
		            		<div class="texto">Notificación con tiempo de reacción importante (menos de <?php echo $notifydays+7;?> días).</div>
		            	</div>
		            	<div class="item">
		            		<div class="cuadro bkcolor-red"></div>
		            		<div class="texto">Notificación con tiempo de reacción inmediato (menos de <?php echo $notifydays;?> días).</div>
		            	</div>
		            </div>
		        </div>

	            <!--	Notificaciones proximas	-->
	            <div class="row cont_table">
	            	<div class="col-sm-8"><h4>Notificaciones <b>próximas</b></h4></div>
		            <table id="tabla_proxnotifi" class="table table-bordered">
		                <thead class="tb_head">
		                    <tr>
		                    	<th rowspan="2">Notificación</th>
							    <th rowspan="2">Fecha visita</th>
							    <th rowspan="2">Nombre visita</th>
							    <th colspan="2">Interventor</th>
							    <th rowspan="2">Nombre de proyecto</th>
							    <th colspan="2">Emprendedor</th>
							</tr>
							<tr>
								<td>Nombres</td>
							    <td>Apellidos</td>
							    <td>Nombres</td>
							    <td>Apellidos</td>
							</tr>
		                </thead>
		                <tbody>
		                	<?php if($listaNotificacionesProximas){ ?>
		                	<?php foreach ($listaNotificacionesProximas as $key => $notificacion) { ?>
		                    <tr class="bkcolor-<?php echo $notificacion['color']; ?>">
		                        <td><?php echo $notificacion['notificacion']; ?></td>
		                        <td><?php echo $notificacion['visita_fecha']; ?></td>
		                        <td><?php echo $notificacion['visita_nombre']; ?></td>
		                        <td><?php echo $notificacion['inter_nombre']; ?></td>
		                        <td><?php echo $notificacion['inter_apellido']; ?></td>
		                        <td><?php echo $notificacion['proy_nombre']; ?></td>
		                        <td><?php echo $notificacion['empre_nombre']; ?></td>
		                        <td><?php echo $notificacion['empre_apellido']; ?></td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_notificaciones"><td colspan="9">No existen registros de notificaciones en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>

		        <!--	Notificaciones pasadas	-->
		        <div class="row cont_table">
	            	<div class="col-sm-8"><h4>Notificaciones <b>pasadas</b></h4></div>
		            <table id="tabla_pasadnotifi" class="table table-bordered">
		                <thead class="tb_head">
		                    <tr>
		                    	<th rowspan="2">Notificación</th>
							    <th rowspan="2">Fecha visita</th>
							    <th rowspan="2">Nombre visita</th>
							    <th colspan="2">Interventor</th>
							    <th rowspan="2">Nombre de proyecto</th>
							    <th colspan="2">Emprendedor</th>
							</tr>
							<tr>
								<td>Nombres</td>
							    <td>Apellidos</td>
							    <td>Nombres</td>
							    <td>Apellidos</td>
							</tr>
		                </thead>
		                <tbody>
		                	<?php if($listaNotificacionesPasadas){ ?>
		                	<?php foreach ($listaNotificacionesPasadas as $key => $notificacion) { ?>
		                    <tr class="bkcolor-<?php echo $notificacion['color']; ?>">
		                        <td><?php echo $notificacion['notificacion']; ?></td>
		                        <td><?php echo $notificacion['visita_fecha']; ?></td>
		                        <td><?php echo $notificacion['visita_nombre']; ?></td>
		                        <td><?php echo $notificacion['inter_nombre']; ?></td>
		                        <td><?php echo $notificacion['inter_apellido']; ?></td>
		                        <td><?php echo $notificacion['proy_nombre']; ?></td>
		                        <td><?php echo $notificacion['empre_nombre']; ?></td>
		                        <td><?php echo $notificacion['empre_apellido']; ?></td>
		                    </tr>
		                    <?php } ?>
		                	<?php }else{ ?>
		                		<tr id="no_notificaciones"><td colspan="9">No existen registros de notificaciones en la base de datos.</td></tr>
		                	<?php } ?>
		                </tbody>
		            </table>
		        </div>

	        </div>
		</div>
	</div>
</div>