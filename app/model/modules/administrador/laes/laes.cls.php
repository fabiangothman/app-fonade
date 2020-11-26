<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOLaes{
  	static public $conexion;

  	static public function getLaes(){
  		$query = 'SELECT lae.*, ciu.codigo_dane, ciu.ciudad, rol.nombre_unico FROM '._DBPFX_.'usuario lae
  		LEFT JOIN '._DBPFX_.'ciudad ciu ON ciu.codigo_dane=lae.ciudad_dane
  		INNER JOIN '._DBPFX_.'rol rol ON rol.id=lae.rol_id
  		WHERE LOWER(rol.nombre_unico)="lae"';
  		$result = self::$conexion->query_db($query);
  		//return $query;
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getCiudades_Laes(){
  		$query = 'SELECT * FROM '._DBPFX_.'ciudad ciu
  		INNER JOIN '._DBPFX_.'usuario lae ON lae.ciudad_dane=ciu.codigo_dane
  		INNER JOIN '._DBPFX_.'rol rol ON rol.id=lae.rol_id
  		WHERE LOWER(rol.nombre_unico)="lae"';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getCiudades(){
  		$query = 'SELECT * FROM '._DBPFX_.'ciudad ciu';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getRoles(){
  		$query = 'SELECT * FROM '._DBPFX_.'rol rol
  		WHERE LOWER(rol.nombre_unico)="lae"';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getLae($id){
  		$query = 'SELECT * FROM '._DBPFX_.'usuario lae
  		LEFT JOIN '._DBPFX_.'ciudad ciu ON ciu.codigo_dane=lae.ciudad_dane
  		INNER JOIN '._DBPFX_.'rol rol ON rol.id=lae.rol_id
  		WHERE LOWER(rol.nombre_unico)="lae" AND id='.self::$conexion->safeText($id);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."usuario", "id");
	}

	static public function updateLae($orig_id, $id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id=null){
		$lae_id = is_null($lae_id) ? 'null' : "'".$lae_id."'";

		$query = 'UPDATE '._DBPFX_.'usuario SET'.
		' id='.self::$conexion->safeText($id).','.
		' nombres="'.self::$conexion->safeText($nombres).'",'.
		' apellidos="'.self::$conexion->safeText($apellidos).'",'.
		' correo="'.self::$conexion->safeText($correo).'",'.
		' telefono="'.self::$conexion->safeText($telefono).'",'.
		' contacto="'.self::$conexion->safeText($contacto).'",'.
		' ciudad_dane='.self::$conexion->safeText($ciudad_dane).','.
		' rol_id='.self::$conexion->safeText($rol_id).','.
		' lae_id='.$lae_id.
		' WHERE id='.self::$conexion->safeText($orig_id);
		//var_dump($query);
		return self::$conexion->exec_query_db($query);
	}

	static public function createLae($id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $clave=null, $imagen=null, $lae_id=null){
		$clave = is_null($clave) ? 'null' : "'".md5($clave)."'";
		$imagen = is_null($imagen) ? 'null' : "'".$imagen."'";
		$lae_id = is_null($lae_id) ? 'null' : "'".$lae_id."'";

		$query = 'INSERT INTO '._DBPFX_.'usuario(';
		$query .='id, nombres, apellidos, correo, clave, imagen, telefono, contacto, ciudad_dane, rol_id, lae_id';
		$query .=') VALUES (';
		$query .= self::$conexion->safeText($id).', ';
		$query .= '"'.self::$conexion->safeText($nombres).'", ';
		$query .= '"'.self::$conexion->safeText($apellidos).'", ';
		$query .= '"'.self::$conexion->safeText($correo).'", ';
		$query .= $clave.', ';
		$query .= $imagen.', ';
		$query .= '"'.self::$conexion->safeText($telefono).'", ';
		$query .= '"'.self::$conexion->safeText($contacto).'", ';
		$query .= ''.self::$conexion->safeText($ciudad_dane).', ';
		$query .= ''.self::$conexion->safeText($rol_id).', ';
		$query .= $lae_id;
		$query .= ')';
		//var_dump($query);
		return self::$conexion->exec_query_db($query);
	}

	/*No podrá eliminar el usuario lae de ID=1*/
	static public function deleteLae($id){
		$query = 'DELETE lae FROM '._DBPFX_.'usuario lae
		INNER JOIN '._DBPFX_.'rol rol ON rol.id=lae.rol_id
  		WHERE LOWER(rol.nombre_unico)="lae" AND lae.id='.self::$conexion->safeText($id);
  		//var_dump($query);
		return self::$conexion->exec_query_db($query);
	}

}

class laesCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOLaes::$conexion = $this->main->db_data;
	}

	public function getLaes(){
		return DAOLaes::getLaes();
	}
	public function getCiudades_Laes(){
		return DAOLaes::getCiudades_Laes();
	}
	public function getCiudades(){
		return DAOLaes::getCiudades();
	}
	public function getRoles(){
		return DAOLaes::getRoles();
	}
	public function getLae($id){
		return DAOLaes::getLae($id);
	}

	public function deleteLae($id){
		return DAOLaes::deleteLae($id);
	}

	public function updateLae($orig_id, $id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id=null){
		return DAOLaes::updateLae($orig_id, $id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id);
	}

	public function createLae($id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $clave=null, $imagen=null, $lae_id=null){
		return DAOLaes::createLae($id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $clave, $imagen, $lae_id);
	}

}