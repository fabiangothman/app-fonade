<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOVisitas{
  	static public $conexion;

  	static public function getIntrvVisitas($intr_id){
  		$query = 'SELECT vis.*, pry.nombre "proy_nombre", docu.nombre_unico, docu.enlace FROM '._DBPFX_.'visita vis
  		LEFT JOIN '._DBPFX_.'proyecto pry ON pry.id=vis.proyecto_id
  		LEFT JOIN '._DBPFX_.'documento docu ON docu.id=vis.documento_id
  		INNER JOIN '._DBPFX_.'usuario intr ON intr.id=pry.interventor_id
  		INNER JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
  		WHERE intr.id='.$intr_id.' AND LOWER(rol_intr.nombre_unico)="interventor"';
  		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getPropiosDocumentos($user_id){
  		$query = 'SELECT * FROM '._DBPFX_.'documento doc WHERE doc.usuario_id='.$user_id;
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getProyectos(){
  		$query = 'SELECT * FROM '._DBPFX_.'proyecto';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getVisita($id){
  		$query = 'SELECT * FROM '._DBPFX_.'visita WHERE id='.self::$conexion->safeText($id);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."visita", "id");
	}

	static public function updateVisita($id, $documento_id){
		$documento_id = (is_null($documento_id)) ? "null" : $documento_id;

		$queryDate = 'SELECT fecha FROM '._DBPFX_.'visita vis WHERE vis.id='.$id.' LIMIT 1';
		$date = self::$conexion->query_db($queryDate)[0]["fecha"];

		$query = 'UPDATE '._DBPFX_.'visita SET '.
		'fecha="'.self::$conexion->safeText($date).'", '.
		'documento_id='.self::$conexion->safeText($documento_id).' '.
		'WHERE id='.self::$conexion->safeText($id);
		//var_dump($query);
		if(self::$conexion->exec_query_db($query)){
			$queryGetEnlace = 'SELECT enlace FROM '._DBPFX_.'documento WHERE id='.self::$conexion->safeText($documento_id).' LIMIT 1';
			if(!is_null($documento_id) && strtolower($documento_id)<>"null")
				return self::$conexion->query_db($queryGetEnlace)[0]["enlace"];
			else
				return "null";
		}else{
			return false;
		}
	}

}

class visitasCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOVisitas::$conexion = $this->main->db_data;
	}

	public function getIntrvVisitas($intr_id){
		return DAOVisitas::getIntrvVisitas($intr_id);
	}

	public function getPropiosDocumentos($user_id){
		return DAOVisitas::getPropiosDocumentos($user_id);
	}

	public function getVisita($id){
		return DAOVisitas::getVisita($id);
	}

	public function updateVisita($id, $documento_id){
		return DAOVisitas::updateVisita($id, $documento_id);
	}

}