<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	class cargacsvActions extends controller
	{
		private $camposPermitidos = array(
			"emprendedor_id",
			"emprendedor_nombres",
			"emprendedor_apellidos",
			"emprendedor_correo",
			"emprendedor_clave",
			"emprendedor_telefono",
			"emprendedor_contacto",
			"emprendedor_ciudad_dane",
			"emprendedor_rol_id",
			"interventor_id",
			"interventor_nombres",
			"interventor_apellidos",
			"interventor_correo",
			"interventor_clave",
			"interventor_telefono",
			"interventor_contacto",
			"interventor_ciudad_dane",
			"interventor_rol_id",
			"lae_id",
			"lae_nombres",
			"lae_apellidos",
			"lae_correo",
			"lae_clave",
			"lae_telefono",
			"lae_contacto",
			"lae_ciudad_dane",
			"lae_rol_id",
			"proyecto_id",
			"proyecto_nombre",
			"proyecto_objetivo",
			"proyecto_fecha_asignacion",
			"proyecto_numero_contrato",
			"centro_negocios_id",
			"centro_negocios_nombre",
			"centro_negocios_descripcion",
			"centro_negocios_ciudad_dane",
			"convocatoria_numero",
			"convocatoria_fecha",
			"convocatoria_descripcion",
			"visita_nombre",
			"visita_primeraFecha",
			"visita_descripcion",
			"visita_documento_id"
		);
		private $rol;

		protected function index()
		{
			$this->title = _MSFW_APP_NAME_." - Insertando datos del CSV";
			$this->rol = $this->main->usuario_rol;

			$this->addCustomStyle("");

			if (isset($_POST["submit"]) ){
			   if(isset($_FILES["file"])) {
			        //if there was an error uploading the file
			        if ($_FILES["file"]["error"] > 0) {
			            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
			        }else{
			        	$storagename = "uploaded".time().".csv";
			        	move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $storagename);
			        	//Máximo dos minutos de ejecución
			        	set_time_limit(120);
			        	$this->uploadFileInfo("upload/".$storagename);
			        }
			    }else{
			    	echo "No file selected <br />";
			    }
			}

		}

		private function uploadFileInfo($fileRoute){
			$fila = 0;
			$result = 13;	/*Mensaje de retorno de exito*/
			$arrHeaderColumns=array();
			//Abrimos nuestro archivo
			$archivo = fopen($fileRoute, "r");
			echo "Cargando ...<br />";
			//Lo recorremos
			while(($datos = fgetcsv($archivo, _CSV_CHAR_)) == true){
				$numCols = count($datos);
				//Es la cabecera del archivo
				if($fila==0){
					if(!($numCols==count($this->camposPermitidos))){
						echo "El archivo no tiene el numero de columnas cabeceras necesario. Reviselo por favor. Puede que el archivo NO esté separado por comas.<br />";
						$result=15;
						break;
					}

					$colsErroneas = $this->validateHeaderColumns($datos);
					if($colsErroneas){
						echo "Hay columnas de la cabecera en el archivo que no corresponden. Reviselo por favor.<br />";
						$result=14;
						break;
					}
				}else{
					$colsVacias = count($this->camposPermitidos);
					//Recorremos las columnas de esa fila para validar que esten todas las columnas llenas
					for($columna=0;$columna<count($this->camposPermitidos);$columna++)
						if(isset($datos[$columna]) && $datos[$columna]!="")
							$colsVacias--;

					if($colsVacias){
						echo "<div class='error'>";$this->showData($datos);echo"<br />Hay columnas vacias en esta fila. Se omitirá.</div>";
						$fila++;
						continue;
					}else{
						if($this->validateRowData($datos)){
							if($this->saveRowData($datos)===false){
								echo "<div class='exito'>";$this->showData($datos);echo"<br />Se guardó la fila con éxito.</div>";
							}else{
								echo "<div class='error'>";$this->showData($datos);echo"<br />No se puedo guardar alguna información de la fila. Se omitirá.</div>";
							}
						}else{
							echo "<div class='error'>";$this->showData($datos);echo"<br />Hay columnas en esta fila que no tienen información válida. Se omitirá.</div>";
						}
					}
				}
				$fila++;
			}
			//Cerramos el archivo
			fclose($archivo);
			//$this->redirect(_MSFW_PATH_."modules/".$this->rol."/cargacsv/cargacsv/mensaje/$result");
			echo "<a href='"._MSFW_PATH_."modules/".$this->rol."/cargacsv/cargacsv/mensaje/".$result."'>Continuar</a>";
		}

		private function showData($fila){
			foreach ($fila as $key => $column) {
				echo $this->camposPermitidos[$key]." => ".$column."<br />";
			}
		}

		private function validateRowData($fila){
			$this->loadModel("modules/".$this->rol."/cargacsv/cargacsv.cls",false);
			$cargaCSV = new cargacsvCRUD($this->main);

			$errorNums=0;
			/*Tabla de usuario->emprendedor*/
			$errorNums = $errorNums + $cargaCSV->validateRowEmprendedor($fila[0], $fila[1], $fila[2], $fila[3], $fila[4], $fila[5], $fila[6], $fila[7], $fila[8]);
			/*Tabla de usuario->interventor*/
			$errorNums = $errorNums + $cargaCSV->validateRowInterventor($fila[9], $fila[10], $fila[11], $fila[12], $fila[13], $fila[14], $fila[15], $fila[16], $fila[17]);
			/*Tabla de usuario->lae*/
			$errorNums = $errorNums + $cargaCSV->validateRowLae($fila[18], $fila[19], $fila[20], $fila[21], $fila[22], $fila[23], $fila[24], $fila[25], $fila[26]);
			/*Tabla de proyecto*/
			$errorNums = $errorNums + $cargaCSV->validateRowProyecto($fila[27], $fila[28], $fila[29], $fila[30], $fila[31]);
			/*Tabla de centro de negocios*/
			$errorNums = $errorNums + $cargaCSV->validateRowCentroNegocios($fila[32], $fila[33], $fila[34], $fila[35]);
			/*Tabla de convocatoria*/
			$errorNums = $errorNums + $cargaCSV->validateRowConvocatoria($fila[36], $fila[37], $fila[38]);
			/*Tabla de visita*/
			$errorNums = $errorNums + $cargaCSV->validateRowVisita($fila[39], $fila[40], $fila[41], $fila[42]);

			if($errorNums>0)
				return false;
			else
				return true;
		}

		private function saveRowData($fila){
			$this->loadModel("modules/".$this->rol."/cargacsv/cargacsv.cls",false);
			$cargaCSV = new cargacsvCRUD($this->main);
			$this->loadModel("modules/".$this->rol."/visitas/visitas.cls",false);
			$visitas = new visitasCRUD($this->main);
			$errores=false;

			/*Tabla de convocatoria*/
			$convocatoria_numero = $cargaCSV->saveRowConvocatoria($fila[36], $fila[37], $fila[38]);
			if($convocatoria_numero===false)
				$errores=true;
			/*Tabla de centro de negocios*/
			$centro_negocios_id = $cargaCSV->saveRowCentroNegocios($fila[32], $fila[33], $fila[34], $fila[35]);
			if($centro_negocios_id===false)
				$errores=true;
			/*Tabla de ususario->Emprendedor*/
			$emprendedor_id = $cargaCSV->saveRowEmprendedor($fila[0], $fila[1], $fila[2], $fila[3], $fila[4], $fila[5], $fila[6], $fila[7], $fila[8]);
			if($emprendedor_id===false)
				$errores=true;
			/*Tabla de ususario->LAE*/
			$lae_id = $cargaCSV->saveRowLae($fila[18], $fila[19], $fila[20], $fila[21], $fila[22], $fila[23], $fila[24], $fila[25], $fila[26]);
			if($lae_id===false)
				$errores=true;
			/*Tabla de ususario->interventor*/
			$interventor_id = $cargaCSV->saveRowInterventor($fila[9], $fila[10], $fila[11], $fila[12], $fila[13], $fila[14], $fila[15], $fila[16], $fila[17], $lae_id);
			if($interventor_id===false)
				$errores=true;
			/*Tabla de plan de negocio*/
			$proyecto_id = $cargaCSV->saveRowProyecto($fila[27], $emprendedor_id, $interventor_id, $fila[28], $fila[29], $fila[30], $fila[31], $convocatoria_numero, $centro_negocios_id);
			if($proyecto_id===false)
				$errores=true;
			/*Tabla de visita*/
			$documento_id = ($fila[42]<>"NO" && !is_null($fila[42]) && $cargaCSV->getDocumIdIfExists($fila[42])) ? $fila[42] : null;
			$visita_success = $visitas->createPrimeraVisitas($proyecto_id, $fila[40], $fila[41], $fila[39], $documento_id, _VISTS_DAYS_, $fila[40], 1);
			//$visita_id = $cargaCSV->saveRowVisita($proyecto_id, $fila[39], $fila[40], $fila[41], $fila[42]);ss
			if($visita_success===false)
				$errores=true;

			return $errores;
		}

		private function validateHeaderColumns($columns){
			$camposErroneos = 0;
			foreach ($columns as $key => $column) {
				if(array_search($column, $this->camposPermitidos)===false){
					$camposErroneos++;
				};
			}
			return $camposErroneos;
		}

		private function addCustomStyle(){
			echo "<style type='text/css'>
				.error{
					background-color:red;
					margin:10px;
				}
				.exito{
					background-color:green;
					margin:10px;
				}
			</style>";
		}

		public function render()
		{
			//return "";
			exit();
		}
	}
?>
