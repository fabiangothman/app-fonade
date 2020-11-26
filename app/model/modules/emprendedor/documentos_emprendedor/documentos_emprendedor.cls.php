<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAODocumentos_emprendedor{
  	static public $conexion;

  	static public function getIntrvDocumentos_emprendedor($empr_id){
  		//$query = 'SELECT * FROM '._DBPFX_.'documento doc
  		$query = 'SELECT empd.*,
  		doc.nombre_unico,
  		doc.enlace,
  		pry.nombre
  		FROM
  		'._DBPFX_.'emprendedor_documento empd
  		LEFT JOIN '._DBPFX_.'documento doc ON doc.id=empd.documento_id
  		INNER JOIN '._DBPFX_.'proyecto pry ON pry.id=empd.proyecto_id
  		INNER JOIN '._DBPFX_.'usuario intr ON intr.id=pry.interventor_id
  		INNER JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
  		INNER JOIN '._DBPFX_.'usuario empr ON empr.id=pry.emprendedor_id
  		INNER JOIN '._DBPFX_.'rol rol_empr ON rol_empr.id=empr.rol_id
  		WHERE LOWER(rol_intr.nombre_unico)="interventor" AND LOWER(rol_empr.nombre_unico)="emprendedor" AND empr.id='.$empr_id;
  		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getIntrvAndEmprDocumentos($empr_id){
  		$queryEmprDocs = 'SELECT doc.* FROM '._DBPFX_.'documento doc
  		INNER JOIN '._DBPFX_.'usuario empr ON empr.id=doc.usuario_id
  		INNER JOIN '._DBPFX_.'rol rol_emp ON rol_emp.id=empr.rol_id
  		WHERE LOWER(rol_emp.nombre_unico)="emprendedor" AND empr.id='.$empr_id;
  		//var_dump($queryEmprDocs);
  		$emprDocs = self::$conexion->query_db($queryEmprDocs);
  		if(isset($emprDocs[0]))
			return $emprDocs;
		else
			return false;
  	}

  	static public function getDocumento_emprendedor($id){
  		$query = 'SELECT * FROM '._DBPFX_.'emprendedor_documento WHERE id='.self::$conexion->safeText($id);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."emprendedor_documento", "id");
	}

	static public function updateDocumento_emprendedor($id, $documento_id){
		$documento_id = (is_null($documento_id)) ? "null" : $documento_id;

		$query = 'UPDATE '._DBPFX_.'emprendedor_documento SET '.
		'documento_id='.self::$conexion->safeText($documento_id).' '.
		'WHERE id='.self::$conexion->safeText($id);
		//var_dump($query);
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

	static public function createDocumento_emprendedor($proyecto_id, $requerimiento, $documento_id){
		$next_id = DAODocumentos_emprendedor::getSiguienteIdDisponible();
		$query = 'INSERT INTO '._DBPFX_.'emprendedor_documento(';
		$query .='id, proyecto_id, requerimiento, documento_id';
		$query .=') VALUES (';
		$query .= $next_id.', ';
		$query .= self::$conexion->safeText($proyecto_id).', ';
		$query .= '"'.self::$conexion->safeText($requerimiento).'", ';
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

	static public function deleteDocumento_emprendedor($id){
		$query = 'DELETE FROM '._DBPFX_.'emprendedor_documento WHERE id='.self::$conexion->safeText($id);
		return self::$conexion->exec_query_db($query);
	}

}

class documentos_emprendedorCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAODocumentos_emprendedor::$conexion = $this->main->db_data;
	}

	public function getIntrvDocumentos_emprendedor($empr_id){
		return DAODocumentos_emprendedor::getIntrvDocumentos_emprendedor($empr_id);
	}
	public function getIntrvAndEmprDocumentos($empr_id){
		return DAODocumentos_emprendedor::getIntrvAndEmprDocumentos($empr_id);
	}
	public function getDocumento_emprendedor($id){
		return DAODocumentos_emprendedor::getDocumento_emprendedor($id);
	}

	public function deleteDocumento_emprendedor($id){
		return DAODocumentos_emprendedor::deleteDocumento_emprendedor($id);
	}

	public function updateDocumento_emprendedor($id, $documento_id){
		return DAODocumentos_emprendedor::updateDocumento_emprendedor($id, $documento_id);
	}

	public function createDocumento_emprendedor($proyecto_id, $requerimiento, $documento_id){
		return DAODocumentos_emprendedor::createDocumento_emprendedor($proyecto_id, $requerimiento, $documento_id);
	}

}