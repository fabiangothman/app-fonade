<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOInterventores{
  	static public $conexion;

  	static public function getInterventores($lae_id){
  		$query = 'SELECT
  		intr.*,
  		ciu.codigo_dane,
  		ciu.ciudad,
  		rol_intr.nombre_unico,
  		lae.nombres "lae_nombres",
  		lae.apellidos "lae_apellidos"
  		FROM
  		'._DBPFX_.'usuario intr
  		LEFT JOIN '._DBPFX_.'ciudad ciu ON ciu.codigo_dane=intr.ciudad_dane
  		INNER JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
  		LEFT JOIN '._DBPFX_.'usuario lae ON lae.id=intr.lae_id
  		INNER JOIN '._DBPFX_.'rol rol_lae ON rol_lae.id=lae.rol_id
  		WHERE LOWER(rol_intr.nombre_unico)="interventor" AND LOWER(rol_lae.nombre_unico)="lae" AND lae.id='.$lae_id;
  		$result = self::$conexion->query_db($query);
  		//var_dump($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."usuario", "id");
	}

}

class interventoresCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOInterventores::$conexion = $this->main->db_data;
	}

	public function getInterventores($lae_id){
		return DAOInterventores::getInterventores($lae_id);
	}
	public function getCiudades_Interventores(){
		return DAOInterventores::getCiudades_Interventores();
	}
	public function getCiudades(){
		return DAOInterventores::getCiudades();
	}
	public function getRoles(){
		return DAOInterventores::getRoles();
	}
	public function getLaes(){
		return DAOInterventores::getLaes();
	}
	public function getInterventor($id){
		return DAOInterventores::getInterventor($id);
	}

	public function deleteInterventor($id){
		return DAOInterventores::deleteInterventor($id);
	}

	public function updateInterventor($orig_id, $id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id=null){
		return DAOInterventores::updateInterventor($orig_id, $id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id);
	}

	public function createInterventor($id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $clave=null, $imagen=null, $lae_id=null){
		return DAOInterventores::createInterventor($id, $nombres, $apellidos, $correo, $telefono, $contacto, $ciudad_dane, $rol_id, $clave, $imagen, $lae_id);
	}

}