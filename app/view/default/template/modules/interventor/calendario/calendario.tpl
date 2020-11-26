<div id="calendario_container">
	<div class="page_content">

		<div class="modulo_page">
			<div class="conth-wrapper">
				<div class="conth-header">
	                <div class="row">
	                    <div class="col-sm-8"><h2>Información de <b>Calendario</b> de mis visitas</h2></div>
	                </div>
	                <div class="row">
	                    <div class="col-sm-8 alinea_horiz">
	                    	<div class="col-sm-2 alinea_horiz">
	                    		<div class="col-sm-6 selector" action="anterior"><h2><i class="fa fa-angle-left"></i></h2></div>
	                    		<div class="col-sm-6 selector" action="siguiente"><h2><i class="fa fa-angle-right"></i></h2></div>
	                    	</div>
	                    	<div class="col-sm-10" id="fechaStr"><h2><?php echo $fechaStr;?></h2></div>
	                    </div>
	                </div>
	            </div>
	            <div id="table_calendario">
	            	<table>
	            		<tr>
	            			<th>Dom</th>
	            			<th>Lun</th>
	            			<th>Mar</th>
	            			<th>Mié</th>
	            			<th>Jue</th>
	            			<th>Vie</th>
	            			<th>Sáb</th>
	            		</tr>
	            		<!--Contenido generado por el js-->
	            	</table>
	            </div>
	        </div>
	    </div>
	</div>
</div>

<!--	VENTANA MODAL DE AMPLIACION	-->
<div id="myModal" class="modal">
	<!-- Modal content -->
	<div class="modal-content">
		<span class="cerrar">&times;</span>
		<div class="cont_contenido">
			<div class="title">
				<p class="text"><!--	Generados por JQuery	--></p>
			</div>
			<div id="contenido">
				<!--	Generados por JQuery	-->
			</div>
		</div>
	</div>
</div>