<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOEmprendedores{
  	static public $conexion;

  	static public function getEmprendedores(){
  		$query = 'SELECT emp.*, ciu.codigo_dane, ciu.ciudad, rol.nombre_unico FROM '._DBPFX_.'usuario emp
  		LEFT JOIN '._DBPFX_.'ciudad ciu ON ciu.codigo_dane=emp.ciudad_dane
  		INNER JOIN '._DBPFX_.'rol rol ON rol.id=emp.rol_id
  		WHERE LOWER(rol.nombre_unico)="emprendedor"';
  		$result = self::$conexion->query_db($query);
  		//return $query;
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getCiudades_Emprendedores(){
  		$query = 'SELECT * FROM '._DBPFX_.'ciudad ciu
  		INNER JOIN '._DBPFX_.'usuario emp ON emp.ciudad_dane=ciu.codigo_dane
  		INNER JOIN '._DBPFX_.'rol rol ON rol.id=emp.rol_id
  		WHERE LOWER(rol.nombre_unico)="emprendedor"';
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
  		WHERE LOWER(rol.nombre_unico)="emprendedor"';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getEmprendedor($id){
  		$query = 'SELECT * FROM '._DBPFX_.'usuario emp
  		LEFT JOIN '._DBPFX_.'ciudad ciu ON ciu.codigo_dane=emp.ciudad_dane
  		INNER JOIN '._DBPFX_.'rol rol ON rol.id=emp.rol_id
  		WHERE LOWER(rol.nombre_unico)="emprendedor" AND id='.self::$conexion->safeText($id);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

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

	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."usuario", "id");
	}

	static public function updateEmprendedor($orig_id, $id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id=null){
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

	static public function createEmprendedor($id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $clave=null, $imagen=null, $lae_id=null){
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

	static public function deleteEmprendedor($id){
		$query = 'DELETE emp FROM '._DBPFX_.'usuario emp
		INNER JOIN '._DBPFX_.'rol rol ON rol.id=emp.rol_id
  		WHERE LOWER(rol.nombre_unico)="emprendedor" AND emp.id='.self::$conexion->safeText($id);
  		//var_dump($query);
		return self::$conexion->exec_query_db($query);
	}

}

class emprendedoresCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOEmprendedores::$conexion = $this->main->db_data;
	}

	public function getEmprendedores(){
		return DAOEmprendedores::getEmprendedores();
	}
	public function getCiudades_Emprendedores(){
		return DAOEmprendedores::getCiudades_Emprendedores();
	}
	public function getCiudades(){
		return DAOEmprendedores::getCiudades();
	}
	public function getRoles(){
		return DAOEmprendedores::getRoles();
	}
	public function getLaes(){
		return DAOEmprendedores::getLaes();
	}
	public function getEmprendedor($id){
		return DAOEmprendedores::getEmprendedor($id);
	}

	public function deleteEmprendedor($id){
		return DAOEmprendedores::deleteEmprendedor($id);
	}

	public function updateEmprendedor($orig_id, $id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id=null){
		return DAOEmprendedores::updateEmprendedor($orig_id, $id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id);
	}

	public function createEmprendedor($id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $clave=null, $imagen=null, $lae_id=null){
		return DAOEmprendedores::createEmprendedor($id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $clave, $imagen, $lae_id);
	}

}