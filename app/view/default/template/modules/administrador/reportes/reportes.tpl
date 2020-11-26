<div id="reportes_container">
	<div class="page_content">

		<div class="modulo_page">
			<div class="cont-wrapper">
				<div class="row">
                    <div class="titulo_mod col-sm-8"><h2>Generador de <b>Reportes</b></h2></div>
                    <div class="titulo_mod col-sm-8">Por favor seleccione en las siguientes listas la información que desea generar.</div>
                </div>
                <div class="row">
                	<div class="col-sm-12">
                		<div class="selectores">
                			<div class="cont_select emprendedores">
                				<div class="labelselector"><div class="texlabel">Emprendedores</div></div>
                				<select id="emprendedores" name="emprendedores">
                					<option value="all" selected>Todos</option>
                					<?php foreach ($listaEmprendedores as $key => $emprendedor) { ?>
                					<option value="<?php echo $emprendedor['id']; ?>"><?php echo $emprendedor['nombres']." ".$emprendedor['apellidos']; ?></option>
                					<?php } ?>
                				</select>
                			</div>
                			<div class="cont_select ciudad_emprendedores">
                				<div class="labelselector"><div class="texlabel">Ciudad de Emprendedores</div></div>
                				<select id="ciudad_emprendedores" name="ciudad_emprendedores">
                					<option value="all" selected>Todos</option>
                					<?php foreach ($listaCiudad_Emprendedores as $key => $ciudad_emprendedor) { ?>
                					<option value="<?php echo $ciudad_emprendedor['codigo_dane']; ?>"><?php echo $ciudad_emprendedor['ciudad']; ?></option>
                					<?php } ?>
                				</select>
                			</div>
                			<div class="cont_select interventores">
                				<div class="labelselector"><div class="texlabel">Interventores</div></div>
                				<select id="interventores" name="interventores">
                					<option value="all" selected>Todos</option>
                					<?php foreach ($listaInterventores as $key => $interventor) { ?>
                					<option value="<?php echo $interventor['id']; ?>"><?php echo $interventor['nombres']." ".$interventor['apellidos']; ?></option>
                					<?php } ?>
                				</select>
                			</div>
                			<div class="cont_select ciudad_interventores">
                				<div class="labelselector"><div class="texlabel">Ciudad de Interventores</div></div>
                				<select id="ciudad_interventores" name="ciudad_interventores">
                					<option value="all" selected>Todos</option>
                					<?php foreach ($listaCiudad_Interventores as $key => $ciudad_interventor) { ?>
                					<option value="<?php echo $ciudad_interventor['codigo_dane']; ?>"><?php echo $ciudad_interventor['ciudad']; ?></option>
                					<?php } ?>
                				</select>
                			</div>
                			<div class="cont_select proyectos">
                				<div class="labelselector"><div class="texlabel">Proyectos</div></div>
                				<select id="proyectos" name="proyectos">
                					<option value="all" selected>Todos</option>
                					<?php foreach ($listaProyectos as $key => $proyecto) { ?>
                					<option value="<?php echo $proyecto['id']; ?>"><?php echo $proyecto['nombre']; ?></option>
                					<?php } ?>
                				</select>
                			</div>
                			<div class="cont_select convocatorias">
                				<div class="labelselector"><div class="texlabel">Convocatorias</div></div>
                				<select id="convocatorias" name="convocatorias">
                					<option value="all" selected>Todos</option>
                					<?php foreach ($listaConvocatoria_Proyectos as $key => $convocatoria_proyecto) { ?>
                					<option value="<?php echo $convocatoria_proyecto['numero']; ?>"><?php echo $convocatoria_proyecto['fecha']." ".$convocatoria_proyecto['descripcion']; ?></option>
                					<?php } ?>
                				</select>
                			</div>
                			<div class="cont_select centros_negocios">
                				<div class="labelselector"><div class="texlabel">Centro de Negocios</div></div>
                				<select id="centros_negocios" name="centros_negocios">
                					<option value="all" selected>Todos</option>
                					<?php foreach ($listaCentro_Negocio_Proyectos as $key => $centro_negocio_proyecto) { ?>
                					<option value="<?php echo $centro_negocio_proyecto['centro_negocios_id']; ?>"><?php echo $centro_negocio_proyecto['nombre']; ?></option>
                					<?php } ?>
                				</select>
                			</div>
                			<div class="cont_select ciudades_centro_negocios">
                				<div class="labelselector"><div class="texlabel">Ciudades de Centro de Negocios</div></div>
                				<select id="ciudades_centro_negocios" name="ciudades_centro_negocios">
                					<option value="all" selected>Todos</option>
                					<?php foreach ($listaCiudades_Centro_Negocio_Proyectos as $key => $ciudad_centro_negocio_proyecto) { ?>
                					<option value="<?php echo $ciudad_centro_negocio_proyecto['codigo_dane']; ?>"><?php echo $ciudad_centro_negocio_proyecto['ciudad']; ?></option>
                					<?php } ?>
                				</select>
                			</div>
                			<div class="cont_select visita">
                				<div class="labelselector"><div class="texlabel">Visitas entre las fechas</div></div>
                				<input id="visita_start" type="text" name="visita_start" />
                				<input id="visita_end" type="text" name="visita_end" />
                			</div>
                		</div>
                	</div>
                </div>
                <div class="row">
                	<div class="cont_btn_generar">
	                	<div id="btn_generar">Generar reporte</div>
                	</div>
                </div>
                <div class="row">
                	<div id="cont_descarga">
	                	<div class="texto_descarga">Descargar el reporte aquí</div>
	                	<div><a id="link_descarga" ></a></div>
                	</div>
                </div>

                <!--    VISUALIZACION DE REPORTES   -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row cont_table">
                            <table id="tabla_roles" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="20%">Archivo</th>
                                        <th width="20%">Fecha de modificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($listadoArchivos)>0){ ?>
                                        <?php foreach ($listadoArchivos as $key => $archivo){ ?>
                                        <tr>
                                            <td><a href="<?php echo $archivo['url']; ?>"><?php echo $archivo['nombre']; ?></a></td>
                                            <td><?php echo $archivo['fecha']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <tr><td colspan="10">No existen reportes generados.</td></tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
			</div>
	    </div>
	</div>
</div>