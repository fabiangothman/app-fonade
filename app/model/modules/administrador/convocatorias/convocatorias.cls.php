<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOConvocatorias{
  	static public $conexion;

  	static public function getConvocatorias(){
  		$query = 'SELECT * FROM '._DBPFX_.'convocatoria pry';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getConvocatoria($numero){
  		$query = 'SELECT * FROM '._DBPFX_.'convocatoria WHERE numero='.self::$conexion->safeText($numero).'LIMIT 1';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result[0];
		else
			return false;
  	}	

	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."convocatoria", "numero");
	}

	static public function createConvocatoria($numero, $fecha, $descripcion){
		$query = 'INSERT INTO '._DBPFX_.'convocatoria(';
		$query .='numero, fecha, descripcion';
		$query .=') VALUES (';
		$query .= ''.self::$conexion->safeText($numero).', ';
		$query .= '"'.self::$conexion->safeText($fecha).'", ';
		$query .= '"'.self::$conexion->safeText($descripcion).'"';
		$query .= ')';
		//return $query;
		return self::$conexion->exec_query_db($query);
	}

	static public function updateConvocatoria($orig_numero, $numero, $fecha, $descripcion){
		$query = 'UPDATE '._DBPFX_.'convocatoria SET ';
		$query .= 'numero='.self::$conexion->safeText($numero).', ';
		$query .= 'fecha="'.self::$conexion->safeText($fecha).'", ';
		$query .= 'descripcion="'.self::$conexion->safeText($descripcion).'" ';
		$query .= 'WHERE numero='.self::$conexion->safeText($orig_numero);
		//return $query;
		return self::$conexion->exec_query_db($query);
	}

	static public function deleteConvocatoria($numero){
		$query = 'DELETE FROM '._DBPFX_.'convocatoria WHERE numero='.self::$conexion->safeText($numero);
		return self::$conexion->exec_query_db($query);
	}

}

class convocatoriasCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOConvocatorias::$conexion = $this->main->db_data;
	}

	public function getConvocatorias(){
		return DAOConvocatorias::getConvocatorias();
	}

	public function getConvocatoria($id){
		return DAOConvocatorias::getConvocatorias($id);
	}

	public function deleteConvocatoria($numero){
		return DAOConvocatorias::deleteConvocatoria($numero);
	}

	public function updateConvocatoria($orig_numero, $numero, $fecha, $descripcion){
		return DAOConvocatorias::updateConvocatoria($orig_numero, $numero, $fecha, $descripcion);
	}

	public function createConvocatoria($numero, $fecha, $descripcion){
		return DAOConvocatorias::createConvocatoria($numero, $fecha, $descripcion);
	}

}