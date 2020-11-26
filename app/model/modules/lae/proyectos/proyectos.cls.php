<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOProyectos{
  	static public $conexion;

  	static public function getLaeProyectos($lae_id){
  		$query = 'SELECT pry.*,
      intr.nombres "interv_nombres",
      intr.apellidos "interv_apellidos",
      emprend.nombres "emprend_nombres",
      emprend.apellidos "emprend_apellidos",
      centroneg.nombre "centroneg_nombre",
      conv.fecha "convoc_fecha"
      FROM
      '._DBPFX_.'proyecto pry
      LEFT JOIN '._DBPFX_.'usuario intr ON intr.id=pry.interventor_id
      LEFT JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
      LEFT JOIN '._DBPFX_.'usuario emprend ON emprend.id=pry.emprendedor_id
      LEFT JOIN '._DBPFX_.'rol rol_emprend ON rol_emprend.id=emprend.rol_id
      LEFT JOIN '._DBPFX_.'usuario lae ON lae.id=intr.lae_id
      LEFT JOIN '._DBPFX_.'rol rol_lae ON rol_lae.id=lae.rol_id
      LEFT JOIN '._DBPFX_.'centro_negocios centroneg ON centroneg.id=pry.centro_negocios_id
      LEFT JOIN '._DBPFX_.'convocatoria conv ON conv.numero=pry.convocatoria_numero
      WHERE lae.id='.$lae_id.' AND LOWER(rol_intr.nombre_unico)="interventor" AND LOWER(rol_lae.nombre_unico)="lae" AND LOWER(rol_emprend.nombre_unico)="emprendedor"';
  		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getOnlyProyectos(){
  		$query = 'SELECT * FROM '._DBPFX_.'proyecto pry';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getConvocatorias_Proyectos(){
  		$query = 'SELECT * FROM '._DBPFX_.'convocatoria cov
  		JOIN '._DBPFX_.'proyecto pry ON pry.convocatoria_numero=cov.numero';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getCentro_Negocios_Proyectos(){
  		$query = 'SELECT * FROM '._DBPFX_.'centro_negocios cneg
  		JOIN '._DBPFX_.'proyecto pry ON pry.centro_negocios_id=cneg.id';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getCiudades_Centro_Negocios_Proyectos(){
  		$query = 'SELECT * FROM '._DBPFX_.'ciudad ciu
  		JOIN '._DBPFX_.'centro_negocios cneg ON cneg.ciudad_dane=ciu.codigo_dane
  		JOIN '._DBPFX_.'proyecto pry ON pry.centro_negocios_id=cneg.id';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getVisitas_Proyectos(){
  		$query = 'SELECT * FROM '._DBPFX_.'visita vis
  		INNER JOIN '._DBPFX_.'proyecto pry ON pry.id=vis.proyecto_id';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

  	static public function getLaeEmprendedores($lae_id){
  		$query = 'SELECT empr.* FROM '._DBPFX_.'usuario empr
  		INNER JOIN '._DBPFX_.'rol rol_empr ON rol_empr.id=empr.rol_id
      INNER JOIN '._DBPFX_.'proyecto pry ON pry.emprendedor_id=empr.id
      INNER JOIN '._DBPFX_.'usuario intr ON intr.id=pry.interventor_id
      INNER JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
      INNER JOIN '._DBPFX_.'usuario lae ON lae.id=intr.lae_id
      INNER JOIN '._DBPFX_.'rol rol_lae ON rol_lae.id=lae.rol_id
  		WHERE LOWER(rol_empr.nombre_unico)="emprendedor" AND LOWER(rol_intr.nombre_unico)="interventor" AND LOWER(rol_lae.nombre_unico)="lae" AND intr.lae_id='.$lae_id;
      //var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}
  	static public function getLaeInterventores($lae_id){
  		$query = 'SELECT intr.* FROM '._DBPFX_.'usuario intr
  		INNER JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
      INNER JOIN '._DBPFX_.'usuario lae ON lae.id=intr.lae_id
      INNER JOIN '._DBPFX_.'rol rol_lae ON rol_lae.id=lae.rol_id
  		WHERE LOWER(rol_intr.nombre_unico)="interventor" AND LOWER(rol_lae.nombre_unico)="lae" AND intr.lae_id='.$lae_id;
  		//var_dump($query);
      $result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}
  	static public function getConvocatorias(){
  		$query = 'SELECT * FROM '._DBPFX_.'convocatoria';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}
  	static public function getCentroNegocios(){
  		$query = 'SELECT * FROM '._DBPFX_.'centro_negocios';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}


  	static public function getProyecto($id){
  		$query = 'SELECT * FROM '._DBPFX_.'proyecto WHERE id='.self::$conexion->safeText($id);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."proyecto", "id");
	}

	static public function updateProyecto($orig_id, $id, $nombre, $objetivo, $fecha_asignacion, $numero_contrato, $emprendedor_id, $interventor_id, $convocatoria_numero, $centro_negocios_id){
		$query = 'UPDATE '._DBPFX_.'proyecto SET ';
		$query .= 'id='.self::$conexion->safeText($id).', ';
		$query .= 'nombre="'.self::$conexion->safeText($nombre).'", ';
		$query .= 'nombre="'.self::$conexion->safeText($objetivo).'", ';
		$query .= 'nombre="'.self::$conexion->safeText($fecha_asignacion).'", ';
		$query .= 'nombre="'.self::$conexion->safeText($numero_contrato).'", ';
		$query .= 'emprendedor_id='.self::$conexion->safeText($emprendedor_id).', ';
		$query .= 'interventor_id='.self::$conexion->safeText($interventor_id).', ';
		$query .= 'convocatoria_numero='.self::$conexion->safeText($convocatoria_numero).', ';
		$query .= 'centro_negocios_id='.self::$conexion->safeText($centro_negocios_id).' ';
		$query .= 'WHERE id='.self::$conexion->safeText($orig_id);
		//var_dump($query);

		return self::$conexion->exec_query_db($query);
	}

	static public function createProyecto($id, $nombre, $objetivo, $fecha_asignacion, $numero_contrato, $emprendedor_id, $interventor_id, $convocatoria_numero, $centro_negocios_id){
		$query = 'INSERT INTO '._DBPFX_.'proyecto (';
		$query .= 'id, nombre, objetivo, fecha_asignacion, numero_contrato, emprendedor_id, interventor_id, convocatoria_numero, centro_negocios_id';
		$query .= ') VALUES (';
		$query .= ''.self::$conexion->safeText($id).', ';
		$query .= '"'.self::$conexion->safeText($nombre).'", ';
		$query .= '"'.self::$conexion->safeText($objetivo).'", ';
		$query .= '"'.self::$conexion->safeText($fecha_asignacion).'", ';
		$query .= '"'.self::$conexion->safeText($numero_contrato).'", ';
		$query .= ''.self::$conexion->safeText($emprendedor_id).', ';
		$query .= ''.self::$conexion->safeText($interventor_id).', ';
		$query .= ''.self::$conexion->safeText($convocatoria_numero).', ';
		$query .= ''.self::$conexion->safeText($centro_negocios_id).')';
		//var_dump($query);

		return self::$conexion->exec_query_db($query);
	}

	static public function deleteProyecto($id){
		$query = 'DELETE FROM '._DBPFX_.'proyecto WHERE id='.self::$conexion->safeText($id);
		return self::$conexion->exec_query_db($query);
	}

}

class proyectosCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOProyectos::$conexion = $this->main->db_data;
	}

	public function getLaeProyectos($lae_id){
		return DAOProyectos::getLaeProyectos($lae_id);
	}

	public function getOnlyProyectos(){
		return DAOProyectos::getOnlyProyectos();
	}

	public function getConvocatorias_Proyectos(){
		return DAOProyectos::getConvocatorias_Proyectos();
	}

	public function getCentro_Negocios_Proyectos(){
		return DAOProyectos::getCentro_Negocios_Proyectos();
	}

	public function getCiudades_Centro_Negocios_Proyectos(){
		return DAOProyectos::getCiudades_Centro_Negocios_Proyectos();
	}

	public function getVisitas_Proyectos(){
		return DAOProyectos::getVisitas_Proyectos();
	}

	public function getLaeEmprendedores($lae_id){
		return DAOProyectos::getLaeEmprendedores($lae_id);
	}
	public function getLaeInterventores($lae_id){
		return DAOProyectos::getLaeInterventores($lae_id);
	}
	public function getConvocatorias(){
		return DAOProyectos::getConvocatorias();
	}
	public function getCentroNegocios(){
		return DAOProyectos::getCentroNegocios();
	}

	

	public function deleteProyecto($id){
		return DAOProyectos::deleteProyecto($id);
	}

	public function updateProyecto($orig_id, $id, $nombre, $objetivo, $fecha_asignacion, $numero_contrato, $emprendedor_id, $interventor_id, $convocatoria_numero, $centro_negocios_id){
		return DAOProyectos::updateProyecto($orig_id, $id, $nombre, $objetivo, $fecha_asignacion, $numero_contrato, $emprendedor_id, $interventor_id, $convocatoria_numero, $centro_negocios_id);
	}

	public function createProyecto($id, $nombre, $objetivo, $fecha_asignacion, $numero_contrato, $emprendedor_id, $interventor_id, $convocatoria_numero, $centro_negocios_id){
		return DAOProyectos::createProyecto($id, $nombre, $objetivo, $fecha_asignacion, $numero_contrato, $emprendedor_id, $interventor_id, $convocatoria_numero, $centro_negocios_id);
	}

}