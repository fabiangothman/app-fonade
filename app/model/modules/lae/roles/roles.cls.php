<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAORoles{
  	static public $conexion;

  	static public function getRoles(){
  		$query = 'SELECT * FROM '._DBPFX_.'rol rol';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."rol", "id");
	}

  	static public function getRol($id){
  		$query = 'SELECT * FROM '._DBPFX_.'rol rol WHERE rol.id='.self::$conexion->safeText($id).' LIMIT 1';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result[0];
		else
			return false;
  	}

	static public function createRol($rol, $description){
		$next_id = DAORoles::getSiguienteIdDisponible();
		$query = 'INSERT INTO '._DBPFX_.'rol(';
		$query .='id, nombre_unico, description';
		$query .=') VALUES (';
		$query .= '"'.$next_id.'", ';
		$query .= '"'.self::$conexion->safeText($rol).'", ';
		$query .= '"'.self::$conexion->safeText($description).'"';
		$query .= ')';
		//return $query;
		if(self::$conexion->exec_query_db($query))
			return $next_id;
		else
			return false;
	}

	static public function updateRol($id, $rol, $description){
		$query = 'UPDATE '._DBPFX_.'rol SET ';
		$query .= 'nombre_unico="'.self::$conexion->safeText($rol).'", ';
		$query .= 'description="'.self::$conexion->safeText($description).'" ';
		$query .= 'WHERE id='.self::$conexion->safeText($id);
		//return $query;
		return self::$conexion->exec_query_db($query);
	}

	//No se podrá eliminar ningún de los pre-establecidos por defecto
	static public function deleteRol($id){
		//$query = 'DELETE FROM '._DBPFX_.'rol WHERE id='.self::$conexion->safeText($id).' AND id<>1';
		//return $query;
		//return self::$conexion->exec_query_db($query);
	}

}

class rolesCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAORoles::$conexion = $this->main->db_data;
	}

	public function getRoles(){
		return DAORoles::getRoles();
	}
	public function getRol(){
		return DAORoles::getRol();
	}
	public function deleteRol($id){
		return DAORoles::deleteRol($id);
	}
	public function updateRol($id, $rol, $description){
		return DAORoles::updateRol($id, $rol, $description);
	}

	public function createRol($rol, $description){
		return DAORoles::createRol($rol, $description);
	}

}