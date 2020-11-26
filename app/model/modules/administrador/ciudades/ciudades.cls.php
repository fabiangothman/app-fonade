<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOCiudades{
  	static public $conexion;

  	static public function getCiudades(){
  		$query = 'SELECT cty.codigo_dane "c_codigo_dane", cty.ciudad, depr.codigo_dane "d_codigo_dane", depr.departamento FROM '._DBPFX_.'ciudad cty
  		LEFT JOIN '._DBPFX_.'departamento depr ON depr.codigo_dane=cty.departamento_dane';
  		$result = self::$conexion->query_db($query);
  		//return $query;
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getDepartamentos(){
  		$query = 'SELECT * FROM '._DBPFX_.'departamento depr';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."ciudad", "codigo_dane");
	}

  	static public function getCiudad($codigo_dane){
  		$query = 'SELECT * FROM '._DBPFX_.'ciudad WHERE codigo_dane='.self::$conexion->safeText($codigo_dane).' LIMIT 1';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result[0];
		else
			return false;
  	}

	static public function createCiudad($codigo_dane, $ciudad, $departamento_dane){
		$query = 'INSERT INTO '._DBPFX_.'ciudad(';
		$query .='codigo_dane, ciudad, departamento_dane';
		$query .=') VALUES (';
		$query .= '"'.self::$conexion->safeText($codigo_dane).'", ';
		$query .= '"'.self::$conexion->safeText($ciudad).'", ';
		$query .= '"'.self::$conexion->safeText($departamento_dane).'"';
		$query .= ')';
		//var_dump($query);
		if(self::$conexion->exec_query_db($query))
			return $codigo_dane;
		else
			return false;
	}

	static public function updateCiudad($orig_codigo_dane, $codigo_dane, $ciudad, $d_codigo_dane){
		$query = 'UPDATE '._DBPFX_.'ciudad SET ';
		$query .= 'codigo_dane="'.self::$conexion->safeText($codigo_dane).'", ';
		$query .= 'ciudad="'.self::$conexion->safeText($ciudad).'", ';
		$query .= 'departamento_dane="'.self::$conexion->safeText($d_codigo_dane).'" ';
		$query .= 'WHERE codigo_dane='.self::$conexion->safeText($orig_codigo_dane);
		var_dump($query);
		return self::$conexion->exec_query_db($query);
	}

	static public function deleteCiudad($codigo_dane){
		$query = 'DELETE FROM '._DBPFX_.'ciudad WHERE codigo_dane='.self::$conexion->safeText($codigo_dane);
		//var_dump($query);
		return self::$conexion->exec_query_db($query);
	}

}

class ciudadesCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOCiudades::$conexion = $this->main->db_data;
	}

	public function getCiudades(){
		return DAOCiudades::getCiudades();
	}
	public function getDepartamentos(){
		return DAOCiudades::getDepartamentos();
	}
	public function getCiudad($id){
		return DAOCiudades::getCiudad($id);
	}

	public function deleteCiudad($codigo_dane){
		return DAOCiudades::deleteCiudad($codigo_dane);
	}

	public function updateCiudad($orig_codigo_dane, $codigo_dane, $ciudad, $d_codigo_dane){
		return DAOCiudades::updateCiudad($orig_codigo_dane, $codigo_dane, $ciudad, $d_codigo_dane);
	}

	public function createCiudad($codigo_dane, $ciudad, $departamento_id){
		return DAOCiudades::createCiudad($codigo_dane, $ciudad, $departamento_id);
	}

}