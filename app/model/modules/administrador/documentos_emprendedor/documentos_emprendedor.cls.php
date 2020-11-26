<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAODocumentos_emprendedor{
  	static public $conexion;

  	static public function getDocumentos_emprendedor(){
  		//$query = 'SELECT * FROM '._DBPFX_.'documento doc
  		$query = 'SELECT empd.*, doc.nombre_unico, doc.enlace, pry.nombre FROM '._DBPFX_.'emprendedor_documento empd
  		LEFT JOIN '._DBPFX_.'documento doc ON doc.id=empd.documento_id
  		LEFT JOIN '._DBPFX_.'proyecto pry ON pry.id=empd.proyecto_id';
  		$result = self::$conexion->query_db($query);
  		//var_dump($query);exit();
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getDocumentos(){
  		$query = 'SELECT * FROM '._DBPFX_.'documento doc';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getProyectos(){
  		$query = 'SELECT * FROM '._DBPFX_.'proyecto pry';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
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

	static public function updateDocumento_emprendedor($id, $proyecto_id, $requerimiento, $documento_id){
		$query = 'UPDATE '._DBPFX_.'emprendedor_documento SET'.
		' proyecto_id='.self::$conexion->safeText($proyecto_id).','.
		' requerimiento="'.self::$conexion->safeText($requerimiento).'",'.
		' documento_id='.self::$conexion->safeText($documento_id).
		' WHERE id='.self::$conexion->safeText($id);
		//return $query;
		$queryGetEnlace = 'SELECT enlace FROM '._DBPFX_.'documento WHERE id='.self::$conexion->safeText($documento_id).' LIMIT 1';
		if(self::$conexion->exec_query_db($query)){
			$enlace = self::$conexion->query_db($queryGetEnlace);
			return isset($enlace[0]) ? $enlace[0]["enlace"] : "null";
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

	public function getDocumentos_emprendedor(){
		return DAODocumentos_emprendedor::getDocumentos_emprendedor();
	}
	public function getDocumentos(){
		return DAODocumentos_emprendedor::getDocumentos();
	}
	public function getProyectos(){
		return DAODocumentos_emprendedor::getProyectos();
	}
	public function getDocumento_emprendedor($id){
		return DAODocumentos_emprendedor::getDocumento_emprendedor($id);
	}

	public function deleteDocumento_emprendedor($id){
		return DAODocumentos_emprendedor::deleteDocumento_emprendedor($id);
	}

	public function updateDocumento_emprendedor($id, $proyecto_id, $requerimiento, $documento_id){
		return DAODocumentos_emprendedor::updateDocumento_emprendedor($id, $proyecto_id, $requerimiento, $documento_id);
	}

	public function createDocumento_emprendedor($proyecto_id, $requerimiento, $documento_id){
		return DAODocumentos_emprendedor::createDocumento_emprendedor($proyecto_id, $requerimiento, $documento_id);
	}

}