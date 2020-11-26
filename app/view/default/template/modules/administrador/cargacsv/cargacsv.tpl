<div id="cargacsv_container">
	<div class="page_content">

		<div class="modulo_page">
			<div class="cont-wrapper">
				<div class="row">
                    <div class="titulo_mod col-sm-8"><h2>Carga de <b>CSV</b></h2></div>
                    <div class="titulo_mod col-sm-12">Por favor seleccione un archivo CSV válido para cargar, puede guiarse haciendo descarga del formato base <a href="<?php echo $formatobase; ?>">aquí</a>.</div>
                </div>
                <div class="row">
                    <div class="titulo_mod col-sm-12">Recuerde que en caso de cargar aquí nuevamente un proyecto ya existente, la columna de visitas creará nuevos registros.</div>
                </div>
                <form action="<?php echo $ir_cargacsvActions; ?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
                    <div class="row">
                        <div class="titulo_mod col-sm-12">
                            <p>Cargar nuevo archivo CSV...</p>
                            <input id="file" class="form-control" type="file" accept=".csv" name="file" required="true" /> 
                        </div>
                    </div>
                    <div class="row">
                    	<div class="cont_btn_cargar">
    	                	<input type="submit" id="btn_cargar" name="submit" value="Cargar información" />
                    	</div>
                    </div>
                </form>
                <div class="row">
                    <div class="titulo_mod col-sm-12">
                    	<div id="result_carga">
    	                	Resultados
                    	</div>
                    </div>
                </div>
			</div>
	    </div>
	</div>
</div>