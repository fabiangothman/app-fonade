<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOCentro_negocios{
  	static public $conexion;

  	static public function getCentro_negocios(){
  		$query = 'SELECT * FROM '._DBPFX_.'centro_negocios cneg
  		LEFT JOIN '._DBPFX_.'ciudad ciud ON ciud.codigo_dane=cneg.ciudad_dane';
  		$result = self::$conexion->query_db($query);
  		//return $query;
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getCiudades(){
  		$query = 'SELECT * FROM '._DBPFX_.'ciudad ciud';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."centro_negocios", "id");
	}

  	static public function getCentro_negocio($id){
  		$query = 'SELECT * FROM '._DBPFX_.'centro_negocios WHERE id='.self::$conexion->safeText($id).' LIMIT 1';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result[0];
		else
			return false;
  	}

	static public function createCentro_negocios($id, $ciudad_dane, $nombre, $descripcion){
		$query = 'INSERT INTO '._DBPFX_.'centro_negocios(';
		$query .='id, ciudad_dane, nombre, descripcion';
		$query .=') VALUES (';
		$query .= ''.self::$conexion->safeText($id).', ';
		$query .= ''.self::$conexion->safeText($ciudad_dane).', ';
		$query .= '"'.self::$conexion->safeText($nombre).'", ';
		$query .= '"'.self::$conexion->safeText($descripcion).'"';
		$query .= ')';
		//return $query;
		return self::$conexion->exec_query_db($query);
	}

	static public function updateCentro_negocios($orig_id, $id, $ciudad_dane, $nombre, $descripcion){
		$query = 'UPDATE '._DBPFX_.'centro_negocios SET ';
		$query .= 'id="'.self::$conexion->safeText($id).'", ';
		$query .= 'ciudad_dane="'.self::$conexion->safeText($ciudad_dane).'", ';
		$query .= 'nombre="'.self::$conexion->safeText($nombre).'", ';
		$query .= 'descripcion="'.self::$conexion->safeText($descripcion).'" ';
		$query .= 'WHERE id='.self::$conexion->safeText($orig_id);
		//return $query;
		var_dump($query);
		return self::$conexion->exec_query_db($query);
	}

	//No se podrá eliminar el propio usuario ni tampoco el de id=1 que será el principal
	static public function deleteCentro_negocios($id){
		$query = 'DELETE FROM '._DBPFX_.'centro_negocios WHERE id='.self::$conexion->safeText($id);
		//var_dump($query);
		return self::$conexion->exec_query_db($query);
	}

}

class centro_negociosCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOCentro_negocios::$conexion = $this->main->db_data;
	}

	public function getCentro_negocios(){
		return DAOCentro_negocios::getCentro_negocios();
	}
	public function getCiudades(){
		return DAOCentro_negocios::getCiudades();
	}
	public function getCentro_negocio($id){
		return DAOCentro_negocios::getCentro_negocio($id);
	}

	public function deleteCentro_negocios($id){
		return DAOCentro_negocios::deleteCentro_negocios($id);
	}

	public function updateCentro_negocios($orig_id, $id, $ciudad_dane, $nombre, $descripcion){
		return DAOCentro_negocios::updateCentro_negocios($orig_id, $id, $ciudad_dane, $nombre, $descripcion);
	}

	public function createCentro_negocios($id, $ciudad_dane, $nombre, $descripcion){
		return DAOCentro_negocios::createCentro_negocios($id, $ciudad_dane, $nombre, $descripcion);
	}

}