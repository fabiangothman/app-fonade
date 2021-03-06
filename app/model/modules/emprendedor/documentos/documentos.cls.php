<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAODocumentos{
  	static public $conexion;

  	static public function getIntrAndEmprDocumentos($empr_id){
  		$queryEmprDocs = 'SELECT doc.*, empr.nombres, empr.apellidos FROM '._DBPFX_.'documento doc
  		INNER JOIN '._DBPFX_.'usuario empr ON empr.id=doc.usuario_id
  		INNER JOIN '._DBPFX_.'rol rol_emp ON rol_emp.id=empr.rol_id
  		WHERE LOWER(rol_emp.nombre_unico)="emprendedor" AND empr.id='.$empr_id;
  		//var_dump($queryEmprDocs);
  		$emprDocs = self::$conexion->query_db($queryEmprDocs);
  		if(isset($emprDocs[0]))
			return $emprDocs;
		else
			return false;
  	}

  	static public function getUsuariosIntrAndEmpr($empr_id){
  		$queryEmprUsers = 'SELECT empr.id, empr.nombres, empr.apellidos FROM '._DBPFX_.'usuario empr
  		INNER JOIN '._DBPFX_.'rol rol_emp ON rol_emp.id=empr.rol_id
  		WHERE LOWER(rol_emp.nombre_unico)="emprendedor" AND empr.id='.$empr_id;
  		//var_dump($queryEmprUsers);
  		$emprUsers = self::$conexion->query_db($queryEmprUsers);
  		if(isset($emprUsers[0]))
			return $emprUsers;
		else
			return false;
  	}

  	static public function getSiguienteIdDisponible(){
		return self::$conexion->autoID(_DBPFX_."documento", "id");
	}

  	static public function getDocumento($id){
  		$query = 'SELECT * FROM '._DBPFX_.'documento WHERE id='.self::$conexion->safeText($id).' LIMIT 1';
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result[0];
		else
			return false;
  	}

	static public function createDocumento($nombre_unico, $enlace, $usuario_id){
		$next_id = DAODocumentos::getSiguienteIdDisponible();
		$query = 'INSERT INTO '._DBPFX_.'documento(';
		$query .='id, nombre_unico, enlace, usuario_id';
		$query .=') VALUES (';
		$query .= '"'.$next_id.'", ';
		$query .= '"'.self::$conexion->safeText($nombre_unico).'", ';
		$query .= '"'.self::$conexion->safeText($enlace).'", ';
		$query .= '"'.self::$conexion->safeText($usuario_id).'"';
		$query .= ')';
		//var_dump($query);
		if(self::$conexion->exec_query_db($query))
			return $next_id;
		else
			return false;
	}

	static public function updateDocumento($id, $nombre_unico, $enlace, $usuario_id){
		$query = 'UPDATE '._DBPFX_.'documento SET ';
		$query .= 'nombre_unico="'.self::$conexion->safeText($nombre_unico).'", ';
		$query .= 'enlace="'.self::$conexion->safeText($enlace).'", ';
		$query .= 'usuario_id="'.self::$conexion->safeText($usuario_id).'" ';
		$query .= 'WHERE id='.self::$conexion->safeText($id);
		//var_dump($query);
		return self::$conexion->exec_query_db($query);
	}

	static public function updateDocumentoSinEnlace($id, $nombre_unico, $usuario_id){
		$query = 'UPDATE '._DBPFX_.'documento SET ';
		$query .= 'nombre_unico="'.self::$conexion->safeText($nombre_unico).'", ';
		$query .= 'usuario_id="'.self::$conexion->safeText($usuario_id).'" ';
		$query .= 'WHERE id='.self::$conexion->safeText($id);
		//var_dump($query);
		$queryGetLink = 'SELECT enlace FROM '._DBPFX_.'documento WHERE id='.self::$conexion->safeText($id).' LIMIT 1';
		//var_dump($queryGetLink);
		if(self::$conexion->exec_query_db($query))
			return self::$conexion->query_db($queryGetLink)[0]["enlace"];
		else
			return false;
	}

	//No se podrá eliminar el propio usuario ni tampoco el de id=1 que será el principal
	static public function deleteDocumento($id){
		$query = 'DELETE FROM '._DBPFX_.'documento WHERE id='.self::$conexion->safeText($id);
		//return $query;
		return self::$conexion->exec_query_db($query);
	}

}

class documentosCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAODocumentos::$conexion = $this->main->db_data;
	}

	public function getIntrAndEmprDocumentos($empr_id){
		return DAODocumentos::getIntrAndEmprDocumentos($empr_id);
	}
	public function getUsuariosIntrAndEmpr($empr_id){
		return DAODocumentos::getUsuariosIntrAndEmpr($empr_id);
	}
	public function getDocumento($id){
		return DAODocumentos::getDocumento($id);
	}

	public function deleteDocumento($id){
		return DAODocumentos::deleteDocumento($id);
	}

	public function updateDocumento($id, $nombre_unico, $enlace, $usuario_id){
		return DAODocumentos::updateDocumento($id, $nombre_unico, $enlace, $usuario_id);
	}

	public function updateDocumentoSinEnlace($id, $nombre_unico, $usuario_id){
		return DAODocumentos::updateDocumentoSinEnlace($id, $nombre_unico, $usuario_id);
	}

	public function createDocumento($nombre_unico, $enlace, $usuario_id){
		return DAODocumentos::createDocumento($nombre_unico, $enlace, $usuario_id);
	}

}