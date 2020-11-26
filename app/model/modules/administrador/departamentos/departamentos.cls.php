<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAODepartamentos{
  	static public $conexion;

  	static public function getDepartamentos(){
  		$query = 'SELECT * FROM '._DBPFX_.'departamento depr
  		LEFT JOIN '._DBPFX_.'region regn ON regn.id=depr.region_id';
  		$result = self::$conexion->query_db($query);
  		//return $query;
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getRegiones(){
  		$query = 'SELECT * FROM '._DBPFX_.'region regn';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."departamento", "codigo_dane");
	}

  	static public function getDepartamento($codigo_dane){
  		$query = 'SELECT * FROM '._DBPFX_.'departamento WHERE codigo_dane='.self::$conexion->safeText($codigo_dane).' LIMIT 1';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result[0];
		else
			return false;
  	}

	static public function createDepartamento($codigo_dane, $departamento, $region_id){
		$query = 'INSERT INTO '._DBPFX_.'departamento(';
		$query .='codigo_dane, departamento, region_id';
		$query .=') VALUES (';
		$query .= '"'.self::$conexion->safeText($codigo_dane).'", ';
		$query .= '"'.self::$conexion->safeText($departamento).'", ';
		$query .= '"'.self::$conexion->safeText($region_id).'"';
		$query .= ')';
		if(self::$conexion->exec_query_db($query))
			return $codigo_dane;
		else
			return false;
	}

	static public function updateDepartamento($orig_codigo_dane, $codigo_dane, $departamento, $region_id){
		$query = 'UPDATE '._DBPFX_.'departamento SET ';
		$query .= 'codigo_dane='.self::$conexion->safeText($codigo_dane).', ';
		$query .= 'departamento="'.self::$conexion->safeText($departamento).'", ';
		$query .= 'region_id='.self::$conexion->safeText($region_id).' ';
		$query .= 'WHERE codigo_dane='.self::$conexion->safeText($orig_codigo_dane);
		//var_dump($query);
		return self::$conexion->exec_query_db($query);
	}

	//No se podrá eliminar el propio usuario ni tampoco el de id=1 que será el principal
	static public function deleteDepartamento($codigo_dane){
		$query = 'DELETE FROM '._DBPFX_.'departamento WHERE codigo_dane='.self::$conexion->safeText($codigo_dane);
		//var_dump($query);
		return self::$conexion->exec_query_db($query);
	}

}

class departamentosCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAODepartamentos::$conexion = $this->main->db_data;
	}

	public function getDepartamentos(){
		return DAODepartamentos::getDepartamentos();
	}
	public function getRegiones(){
		return DAODepartamentos::getRegiones();
	}
	public function getDepartamento($codigo_dane){
		return DAODepartamentos::getDepartamento($codigo_dane);
	}

	public function deleteDepartamento($codigo_dane){
		return DAODepartamentos::deleteDepartamento($codigo_dane);
	}

	public function updateDepartamento($orig_codigo_dane, $codigo_dane, $departamento, $region_id){
		return DAODepartamentos::updateDepartamento($orig_codigo_dane, $codigo_dane, $departamento, $region_id);
	}

	public function createDepartamento($codigo_dane, $departamento, $region_id){
		return DAODepartamentos::createDepartamento($codigo_dane, $departamento, $region_id);
	}

}