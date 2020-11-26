<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOLaes{
  	static public $conexion;

  	static public function getInterventorLae($usuario_intr){
  		$query = 'SELECT lae.*, ciu.codigo_dane, ciu.ciudad, rol_lae.nombre_unico FROM '._DBPFX_.'usuario intr
  		INNER JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
        INNER JOIN '._DBPFX_.'usuario lae ON lae.id=intr.lae_id
  		LEFT JOIN '._DBPFX_.'ciudad ciu ON ciu.codigo_dane=lae.ciudad_dane
  		INNER JOIN '._DBPFX_.'rol rol_lae ON rol_lae.id=lae.rol_id
  		WHERE intr.id='.$usuario_intr.' AND LOWER(rol_lae.nombre_unico)="lae" AND LOWER(rol_intr.nombre_unico)="interventor"';
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

}

class laesCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOLaes::$conexion = $this->main->db_data;
	}

	public function getInterventorLae($usuario_intr){
		return DAOLaes::getInterventorLae($usuario_intr);
	}

}