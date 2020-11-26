<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAORegiones{
  	static public $conexion;

  	static public function getRegiones(){
  		$query = 'SELECT * FROM '._DBPFX_.'region reg';
  		$result = self::$conexion->query_db($query);
  		//return $query;
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."region", "id");
	}

  	static public function getRegion($id){
  		$query = 'SELECT * FROM '._DBPFX_.'region WHERE id='.self::$conexion->safeText($id).' LIMIT 1';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result[0];
		else
			return false;
  	}

	static public function createRegion($region){
		$next_id = DAORegiones::getSiguienteIdDisponible();
		$query = 'INSERT INTO '._DBPFX_.'region(';
		$query .='id, region';
		$query .=') VALUES (';
		$query .= '"'.$next_id.'", ';
		$query .= '"'.self::$conexion->safeText($region).'"';
		$query .= ')';
		//return $query;
		if(self::$conexion->exec_query_db($query))
			return $next_id;
		else
			return false;
	}

	static public function updateRegion($id, $region){
		$query = 'UPDATE '._DBPFX_.'region SET ';
		$query .= 'region="'.self::$conexion->safeText($region).'" ';
		$query .= 'WHERE id='.self::$conexion->safeText($id);
		//return $query;
		return self::$conexion->exec_query_db($query);
	}

	//No se podrá eliminar el propio usuario ni tampoco el de id=1 que será el principal
	static public function deleteRegion($id){
		$query = 'DELETE FROM '._DBPFX_.'region WHERE id='.self::$conexion->safeText($id);
		//return $query;
		return self::$conexion->exec_query_db($query);
	}

}

class regionesCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAORegiones::$conexion = $this->main->db_data;
	}

	public function getRegiones(){
		return DAORegiones::getRegiones();
	}
	public function getRegion($id){
		return DAORegiones::getRegion($id);
	}

	public function deleteRegion($id){
		return DAORegiones::deleteRegion($id);
	}

	public function updateRegion($id, $region){
		return DAORegiones::updateRegion($id, $region);
	}

	public function createRegion($region){
		return DAORegiones::createRegion($region);
	}

}