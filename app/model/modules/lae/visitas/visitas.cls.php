<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOVisitas{
  	static public $conexion;

  	static public function getLaeVisitas($lae_id){
  		$query = 'SELECT vis.*,
  		pry.nombre "proy_nombre",
  		docu.nombre_unico,
  		docu.enlace FROM
  		'._DBPFX_.'visita vis
  		LEFT JOIN '._DBPFX_.'documento docu ON docu.id=vis.documento_id
  		LEFT JOIN '._DBPFX_.'proyecto pry ON pry.id=vis.proyecto_id
  		LEFT JOIN '._DBPFX_.'usuario intr ON intr.id=pry.interventor_id
  		LEFT JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
  		LEFT JOIN '._DBPFX_.'usuario lae ON lae.id=intr.lae_id
  		LEFT JOIN '._DBPFX_.'rol rol_lae ON rol_lae.id=lae.rol_id
  		WHERE LOWER(rol_intr.nombre_unico)="interventor" AND LOWER(rol_lae.nombre_unico)="lae" AND intr.lae_id='.$lae_id;
  		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getLaeDocumentos($lae_id){
  		$queryIntrDocs = 'SELECT docu.* FROM '._DBPFX_.'documento docu
  		LEFT JOIN '._DBPFX_.'usuario intr ON intr.id=docu.usuario_id
  		LEFT JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
  		LEFT JOIN '._DBPFX_.'usuario lae ON lae.id=intr.lae_id
  		LEFT JOIN '._DBPFX_.'rol rol_lae ON rol_lae.id=lae.rol_id
  		WHERE LOWER(rol_intr.nombre_unico)="interventor" AND LOWER(rol_lae.nombre_unico)="lae" AND intr.lae_id='.$lae_id;
  		//var_dump($queryIntrDocs);
  		$resultIntr = self::$conexion->query_db($queryIntrDocs);

  		$queryLaeDocs = 'SELECT docu.* FROM '._DBPFX_.'documento docu
  		WHERE docu.usuario_id='.$lae_id;
  		//var_dump($queryLaeDocs);
  		$resultLae = self::$conexion->query_db($queryLaeDocs);

  		$result = array_merge($resultIntr, $resultLae);
  		//var_dump($result);

  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getLaeProyectos($lae_id){
  		$query = 'SELECT pry.* FROM '._DBPFX_.'proyecto pry
  		LEFT JOIN '._DBPFX_.'usuario intr ON intr.id=pry.interventor_id
  		LEFT JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
  		LEFT JOIN '._DBPFX_.'usuario lae ON lae.id=intr.lae_id
  		LEFT JOIN '._DBPFX_.'rol rol_lae ON rol_lae.id=lae.rol_id
  		WHERE LOWER(rol_intr.nombre_unico)="interventor" AND LOWER(rol_lae.nombre_unico)="lae" AND intr.lae_id='.$lae_id;
  		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getVisita($id){
  		$query = 'SELECT * FROM '._DBPFX_.'visita WHERE id='.self::$conexion->safeText($id);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."visita", "id");
	}

	static public function updateVisita($id, $proyecto_id, $nombre, $fecha, $descripcion, $documento_id){
		$query = 'UPDATE '._DBPFX_.'visita SET'.
		' proyecto_id='.self::$conexion->safeText($proyecto_id).','.
		' fecha="'.self::$conexion->safeText($fecha).'",'.
		' descripcion="'.self::$conexion->safeText($descripcion).'",'.
		' nombre="'.self::$conexion->safeText($nombre).'",'.
		' documento_id='.self::$conexion->safeText($documento_id).
		' WHERE id='.self::$conexion->safeText($id);
		//return $query;
		if(self::$conexion->exec_query_db($query)){
			$queryGetEnlace = 'SELECT enlace FROM '._DBPFX_.'documento WHERE id='.self::$conexion->safeText($documento_id).' LIMIT 1';
			if(!is_null($documento_id) && strtolower($documento_id)<>"null")
				return self::$conexion->query_db($queryGetEnlace)[0]["enlace"];
			else
				return "null";
		}else{
			return false;
		}
	}

	static public function createVisita($proyecto_id, $fecha, $descripcion, $nombre, $documento_id, $ciclo = false){
		$ciclo = ($ciclo===false || $ciclo===0 || $ciclo===1) ? "" : " ".$ciclo;
		$next_id = DAOVisitas::getSiguienteIdDisponible();
		$query = 'INSERT INTO '._DBPFX_.'visita(';
		$query .='id, proyecto_id, fecha, descripcion, nombre, documento_id';
		$query .=') VALUES (';
		$query .= '"'.$next_id.'", ';
		$query .= '"'.self::$conexion->safeText($proyecto_id).'", ';
		$query .= '"'.self::$conexion->safeText($fecha).'", ';
		$query .= '"'.self::$conexion->safeText($descripcion).$ciclo.'", ';
		$query .= '"'.self::$conexion->safeText($nombre).$ciclo.'", ';
		$query .= self::$conexion->safeText($documento_id);
		$query .= ')';
		//return $query;
		if(self::$conexion->exec_query_db($query)){
			$queryGetEnlace = 'SELECT enlace FROM '._DBPFX_.'documento WHERE id='.self::$conexion->safeText($documento_id).' LIMIT 1';
			if(!is_null($documento_id) && strtolower($documento_id)<>"null")
				return array("id"=>$next_id, "enlace"=>self::$conexion->query_db($queryGetEnlace)[0]["enlace"]);
			else
				return array("id"=>$next_id, "enlace"=>false);
		}else{
			return false;
		}
	}

	static public function createPrimeraVisitas($proyecto_id, $fecha_base, $descripcion, $nombre, $documento_id, $visitas_dias_limites, $fecha_actu = null, $ciclo = 0){
		$documento_id = (is_null($documento_id)) ? "null" : $documento_id;
		$fecha_actu = (is_null($fecha_actu)) ? $fecha_base : $fecha_actu;

		self::createVisita($proyecto_id, $fecha_actu, $descripcion, $nombre, $documento_id, $ciclo);

		$new_fecha = self::sigFechaDiasHabiles($fecha_actu, $visitas_dias_limites);
		if(self::isIntoYearLimit($fecha_base, $new_fecha)){
			self::createPrimeraVisitas($proyecto_id, $fecha_base, $descripcion, $nombre, null, $visitas_dias_limites, $new_fecha, $ciclo+1);
		}

		return true;
	}

	static public function deleteVisita($id){
		$query = 'DELETE FROM '._DBPFX_.'visita WHERE id='.self::$conexion->safeText($id);
		//return $query;
		return self::$conexion->exec_query_db($query);
	}

	static public function isIntoYearLimit($fecha_inicio, $fecha_fin){
		$datediff = strtotime($fecha_fin) - strtotime($fecha_inicio);
		if(round($datediff / (60 * 60 * 24))<=365)
			return true;
		else
			return false;
	}

	static public function sigFechaDiasHabiles($fecha, $visitas_dias_limites){
		for($i=1; $i<=$visitas_dias_limites; $i++){
			$fechaDt = new DateTime($fecha);
			//Si es sábado o domingo
			if($fechaDt->format("N")==6 || $fechaDt->format("N")==7 || self::isFestivo($fecha)){
				$fecha = date('Y-m-d H:i:s', strtotime($fecha. ' +1 days'));
				$i--;
				continue;
			}
			if($i<>$visitas_dias_limites)
				$fecha = date('Y-m-d H:i:s', strtotime($fecha. ' +1 days'));
		}
		return $fecha;
	}

	static public function isFestivo($date){
		$isFestivo = false;
		foreach (self::getFestivosDate() as $key => $festivo){
			$dt_date = new DateTime($date);
			if($festivo["fecha"]==$dt_date->format('Y-m-d')){
				$isFestivo = true;
				break;
			}
		}

		return $isFestivo;
	}

	static public function getFestivosDate(){
  		$query = 'SELECT fest.fecha FROM '._DBPFX_.'festivos fest';
  		$result = self::$conexion->query_db($query);
  		//return $query;
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

}

class visitasCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOVisitas::$conexion = $this->main->db_data;
	}

	public function getLaeVisitas($lae_id){
		return DAOVisitas::getLaeVisitas($lae_id);
	}

	public function getLaeDocumentos($lae_id){
		return DAOVisitas::getLaeDocumentos($lae_id);
	}

	public function getLaeProyectos($lae_id){
		return DAOVisitas::getLaeProyectos($lae_id);
	}

	public function getVisita($id){
		return DAOVisitas::getVisita($id);
	}

	public function deleteVisita($id){
		return DAOVisitas::deleteVisita($id);
	}

	public function updateVisita($id, $proyecto_id, $nombre, $fecha, $descripcion, $documento_id){
		return DAOVisitas::updateVisita($id, $proyecto_id, $nombre, $fecha, $descripcion, $documento_id);
	}

	public function createVisita($proyecto_id, $fecha, $descripcion, $nombre, $documento_id, $ciclo = false){
		return DAOVisitas::createVisita($proyecto_id, $fecha, $descripcion, $nombre, $documento_id, $ciclo);
	}

	public function createPrimeraVisitas($proyecto_id, $fecha, $descripcion, $nombre, $documento_id, $visitas_dias, $fecha_actu, $ciclo = 0){
		return DAOVisitas::createPrimeraVisitas($proyecto_id, $fecha, $descripcion, $nombre, $documento_id, $visitas_dias, $fecha_actu, $ciclo);
	}

}