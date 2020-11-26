<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOUsuarios{
  	static public $conexion;

  	static public function getUsuarios(){
  		$query = 'SELECT usr.*, ciu.codigo_dane, ciu.ciudad, rol.nombre_unico, lae.nombres "lae_nombres", lae.apellidos "lae_apellidos" FROM '._DBPFX_.'usuario usr
  		LEFT JOIN '._DBPFX_.'ciudad ciu ON ciu.codigo_dane=usr.ciudad_dane
  		LEFT JOIN '._DBPFX_.'rol rol ON rol.id=usr.rol_id
  		LEFT JOIN '._DBPFX_.'usuario lae ON lae.id=usr.lae_id';

  		$result = self::$conexion->query_db($query);
  		//return $query;
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getRoles(){
  		$query = 'SELECT * FROM '._DBPFX_.'rol rol';
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

  	static public function getLaes(){
  		$query = 'SELECT usr.* FROM app_usuario usr
  		INNER JOIN app_rol rol ON rol.id=usr.rol_id
  		WHERE LOWER(rol.nombre_unico)="lae"';
  		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."usuario", "id");
	}

  	static public function getUsuario($id){
  		$query = 'SELECT * FROM '._DBPFX_.'usuario WHERE id='.self::$conexion->safeText($id).' LIMIT 1';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result[0];
		else
			return false;
  	}

	static public function createUsuario($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id){
		$lae_id = (is_null($lae_id) || $lae_id=="null") ? 'null' : $lae_id;

		$query = 'INSERT INTO '._DBPFX_.'usuario(';
		$query .='id, nombres, apellidos, correo, clave, telefono, contacto, ciudad_dane, rol_id, lae_id';
		$query .=') VALUES (';
		$query .= ''.self::$conexion->safeText($id).', ';
		$query .= '"'.self::$conexion->safeText($nombres).'", ';
		$query .= '"'.self::$conexion->safeText($apellidos).'", ';
		$query .= '"'.self::$conexion->safeText($correo).'", ';
		$query .= '"'.md5(self::$conexion->safeText($clave)).'", ';
		$query .= '"'.self::$conexion->safeText($telefono).'", ';
		$query .= '"'.self::$conexion->safeText($contacto).'", ';
		$query .= ''.self::$conexion->safeText($ciudad_dane).', ';
		$query .= ''.self::$conexion->safeText($rol_id).', ';
		$query .= ''.self::$conexion->safeText($lae_id).'';
		$query .= ')';
		//var_dump($query);
		if(self::$conexion->exec_query_db($query))
			return $id;
		else
			return false;
	}

	static public function updateUsuario($orig_id, $id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id){
		$lae_id = (is_null($lae_id) || $lae_id=="null") ? 'null' : $lae_id;

		$query = 'UPDATE '._DBPFX_.'usuario SET ';
		$query .= 'id='.self::$conexion->safeText($id).', ';
		$query .= 'nombres="'.self::$conexion->safeText($nombres).'", ';
		$query .= 'apellidos="'.self::$conexion->safeText($apellidos).'", ';
		$query .= 'correo="'.self::$conexion->safeText($correo).'", ';
		if($clave)
			$query .= 'clave="'.md5(self::$conexion->safeText($clave)).'", ';
		$query .= 'telefono="'.self::$conexion->safeText($telefono).'", ';
		$query .= 'contacto="'.self::$conexion->safeText($contacto).'", ';
		$query .= 'ciudad_dane='.self::$conexion->safeText($ciudad_dane).', ';
		$query .= 'lae_id='.$lae_id.', ';
		$query .= 'rol_id='.self::$conexion->safeText($rol_id).' ';
		$query .= 'WHERE id='.self::$conexion->safeText($orig_id);
		//var_dump($query);
		return self::$conexion->exec_query_db($query);
	}

	//No se podrá eliminar el propio usuario ni tampoco el de id=1 que será el principal
	static public function deleteUsuario($id, $idCurrent){
		$query = 'DELETE FROM '._DBPFX_.'usuario WHERE id<>1 AND id='.self::$conexion->safeText($id).' AND id<>'.$idCurrent;
		//return $query;
		return self::$conexion->exec_query_db($query);
	}

}

class usuariosCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOUsuarios::$conexion = $this->main->db_data;
	}

	public function getUsuarios(){
		return DAOUsuarios::getUsuarios();
	}
	public function getRoles(){
		return DAOUsuarios::getRoles();
	}
	public function getCiudades(){
		return DAOUsuarios::getCiudades();
	}
	public function getLaes(){
		return DAOUsuarios::getLaes();
	}
	public function getUsuario($id){
		return DAOUsuarios::getUsuario($id);
	}

	public function deleteUsuario($id){
		return DAOUsuarios::deleteUsuario($id, $this->main->usuario->id);
	}

	public function updateUsuario($orig_id, $id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id){
		return DAOUsuarios::updateUsuario($orig_id, $id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id);
	}

	public function createUsuario($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id){
		return DAOUsuarios::createUsuario($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id);
	}

}