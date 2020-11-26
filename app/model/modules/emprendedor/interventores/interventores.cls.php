<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOInterventores{
  	static public $conexion;

  	static public function getInterventores($empr_id){
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
  		INNER JOIN '._DBPFX_.'proyecto pry ON pry.interventor_id=intr.id
  		INNER JOIN '._DBPFX_.'usuario empr ON empr.id=pry.emprendedor_id
  		INNER JOIN '._DBPFX_.'rol rol_empr ON rol_empr.id=empr.rol_id
  		WHERE LOWER(rol_intr.nombre_unico)="interventor" AND LOWER(rol_lae.nombre_unico)="lae" AND LOWER(rol_empr.nombre_unico)="emprendedor" AND pry.emprendedor_id='.$empr_id;
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

	public function getInterventores($empr_id){
		return DAOInterventores::getInterventores($empr_id);
	}

}