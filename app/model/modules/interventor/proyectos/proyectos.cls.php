<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOProyectos{
  	static public $conexion;

  	static public function getIntervProyectos($intrv_id){
  		$query = 'SELECT pry.*, interv.nombres "interv_nombres", interv.apellidos "interv_apellidos", emprend.nombres "emprend_nombres", emprend.apellidos "emprend_apellidos", centroneg.nombre "centroneg_nombre", conv.fecha "convoc_fecha"
  		FROM '._DBPFX_.'proyecto pry
  		INNER JOIN '._DBPFX_.'usuario interv ON interv.id=pry.interventor_id
  		LEFT JOIN '._DBPFX_.'rol rol_interv ON rol_interv.id=interv.rol_id
  		LEFT JOIN '._DBPFX_.'usuario emprend ON emprend.id=pry.emprendedor_id
  		LEFT JOIN '._DBPFX_.'rol rol_emprend ON rol_emprend.id=emprend.rol_id
  		LEFT JOIN '._DBPFX_.'centro_negocios centroneg ON centroneg.id=pry.centro_negocios_id
  		LEFT JOIN '._DBPFX_.'convocatoria conv ON conv.numero=pry.convocatoria_numero
  		WHERE interv.id='.$intrv_id.' AND LOWER(rol_interv.nombre_unico)="interventor"';
  		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

}

class proyectosCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOProyectos::$conexion = $this->main->db_data;
	}

	public function getIntervProyectos($intrv_id){
		return DAOProyectos::getIntervProyectos($intrv_id);
	}

}