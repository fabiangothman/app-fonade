<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOCalendario{
  	static public $conexion;

  	static public function getFestivos(){
  		$query = 'SELECT * FROM '._DBPFX_.'festivos fest';
  		$result = self::$conexion->query_db($query);
  		//return $query;
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getVisitas(){
  		$query = 'SELECT vis.id,
  		DATE_FORMAT(vis.fecha, "%Y-%m-%d") "fecha",
  		vis.fecha "fecha_real",
  		vis.descripcion,
  		vis.nombre,
  		vis.documento_id,
  		vis.proyecto_id,
  		pry.nombre "proy_nombre",
  		empr.nombres "empr_nombres",
  		empr.apellidos "empr_apellidos",
  		empr.telefono "empr_telefono",
  		empr.contacto "empr_contacto",
  		intr.nombres "intr_nombres",
  		intr.apellidos "intr_apellidos"
  		FROM
  		'._DBPFX_.'visita vis
  		LEFT JOIN '._DBPFX_.'proyecto pry ON pry.id=vis.proyecto_id
  		LEFT JOIN '._DBPFX_.'usuario empr ON empr.id=pry.emprendedor_id
  		LEFT JOIN '._DBPFX_.'rol rol_empr ON rol_empr.id=empr.rol_id
  		LEFT JOIN '._DBPFX_.'usuario intr ON intr.id=pry.interventor_id
  		LEFT JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
  		LEFT JOIN '._DBPFX_.'usuario lae ON lae.id=intr.lae_id
  		LEFT JOIN '._DBPFX_.'rol rol_lae ON rol_lae.id=lae.rol_id';
  		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getFestivosDate(){
  		$query = 'SELECT fest.fecha FROM '._DBPFX_.'festivos fest';
  		$result = self::$conexion->query_db($query);
  		//return $query;
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."visita", "id");
	}

}

class calendarioCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOCalendario::$conexion = $this->main->db_data;
	}

	public function getFestivos(){
		return DAOCalendario::getFestivos();
	}
	public function getFestivosDate(){
		return DAOCalendario::getFestivosDate();
	}
	public function getCiudad($id){
		return DAOCalendario::getCiudad($id);
	}
	public function getVisitas(){
		return DAOCalendario::getVisitas();
	}

	public function deleteCiudad($id){
		return DAOCalendario::deleteCiudad($id);
	}

	public function updateCiudad($id, $codigo_dane, $ciudad, $departamento_id){
		return DAOCalendario::updateCiudad($id, $codigo_dane, $ciudad, $departamento_id);
	}

	public function createCiudad($codigo_dane, $ciudad, $departamento_id){
		return DAOCalendario::createCiudad($codigo_dane, $ciudad, $departamento_id);
	}

}