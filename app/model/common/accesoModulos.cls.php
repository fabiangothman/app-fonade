<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOAccesoModulos{
  	static public $conexion;

  	static public function getAccessByRol($nombre_unico){
  		$query = 'SELECT modu.nombre_unico FROM app_modulos modu
  		INNER JOIN app_acceso_modulos accm ON accm.modulos_id=modu.id
  		INNER JOIN app_rol rol ON rol.id=accm.rol_id
  		WHERE LOWER(rol.nombre_unico)="'.$nombre_unico.'"';
  		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

}

class accesoModulosCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOAccesoModulos::$conexion = $this->main->db_data;
	}

	public function getAccessByRol($nombre_unico){
		return DAOAccesoModulos::getAccessByRol($nombre_unico);
	}

}