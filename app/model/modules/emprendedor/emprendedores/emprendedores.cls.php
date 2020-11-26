<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOEmprendedores{
  	static public $conexion;

  	static public function getIntrvEmprendedores($intr_id){
  		$query = 'SELECT emp.*, ciu.codigo_dane, ciu.ciudad, rol_emp.nombre_unico FROM '._DBPFX_.'usuario emp
  		LEFT JOIN '._DBPFX_.'ciudad ciu ON ciu.codigo_dane=emp.ciudad_dane
  		INNER JOIN '._DBPFX_.'rol rol_emp ON rol_emp.id=emp.rol_id
  		INNER JOIN '._DBPFX_.'proyecto pry ON pry.emprendedor_id=emp.id
  		INNER JOIN '._DBPFX_.'usuario intr ON intr.id=pry.interventor_id
  		INNER JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
  		WHERE LOWER(rol_emp.nombre_unico)="emprendedor" AND LOWER(rol_intr.nombre_unico)="interventor" AND intr.id='.$intr_id;
  		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return false;
  	}

}

class emprendedoresCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOEmprendedores::$conexion = $this->main->db_data;
	}

	public function getIntrvEmprendedores($intr_id){
		return DAOEmprendedores::getIntrvEmprendedores($intr_id);
	}

}