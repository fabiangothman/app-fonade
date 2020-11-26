<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOEmprendedores{
  	static public $conexion;

  	static public function getIntrvEmprendedores($lae_id){
  		$query = 'SELECT DISTINCT emp.*,
      ciu.codigo_dane,
      ciu.ciudad,
      rol_emp.nombre_unico
      FROM
      '._DBPFX_.'usuario emp
  		LEFT JOIN '._DBPFX_.'ciudad ciu ON ciu.codigo_dane=emp.ciudad_dane
  		INNER JOIN '._DBPFX_.'rol rol_emp ON rol_emp.id=emp.rol_id
  		INNER JOIN '._DBPFX_.'proyecto pry ON pry.emprendedor_id=emp.id
  		INNER JOIN '._DBPFX_.'usuario intr ON intr.id=pry.interventor_id
  		INNER JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
      INNER JOIN '._DBPFX_.'usuario lae ON lae.id=intr.lae_id
      INNER JOIN '._DBPFX_.'rol rol_lae ON rol_lae.id=lae.rol_id
  		WHERE LOWER(rol_emp.nombre_unico)="emprendedor" AND LOWER(rol_intr.nombre_unico)="interventor" AND LOWER(rol_lae.nombre_unico)="lae" AND intr.lae_id='.$lae_id;
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

	public function getIntrvEmprendedores($lae_id){
		return DAOEmprendedores::getIntrvEmprendedores($lae_id);
	}

}