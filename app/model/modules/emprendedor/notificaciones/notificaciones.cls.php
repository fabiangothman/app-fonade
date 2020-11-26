<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAONotificaciones{
  	static public $conexion;

  	static public function getProxInterVisitas($empr_id, $notification_days){
  		$query = 'SELECT "Próximas visitas de interventores" AS "notificacion",
			(CASE
				WHEN DATEDIFF(vis.fecha, CURRENT_TIMESTAMP)<='.$notification_days.' THEN "red"
				WHEN DATEDIFF(vis.fecha, CURRENT_TIMESTAMP)<='.($notification_days+7).' THEN "orange"
				ELSE "green"
			END) AS "color",
			vis.fecha "visita_fecha",
			vis.nombre "visita_nombre",
			intr.nombres "inter_nombre",
			intr.apellidos "inter_apellido",
			proy.nombre "proy_nombre",
			empr.nombres "empre_nombre",
			empr.apellidos "empre_apellido"
			FROM '._DBPFX_.'visita vis
			INNER JOIN '._DBPFX_.'proyecto proy ON proy.id=vis.proyecto_id
			INNER JOIN '._DBPFX_.'usuario empr ON empr.id=proy.emprendedor_id
			INNER JOIN '._DBPFX_.'rol rol_emp ON rol_emp.id=empr.rol_id
			INNER JOIN '._DBPFX_.'usuario intr ON intr.id=proy.interventor_id
			INNER JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
			WHERE LOWER(rol_emp.nombre_unico)="emprendedor" AND LOWER(rol_intr.nombre_unico)="interventor" AND vis.fecha >= CURRENT_TIMESTAMP AND empr.id='.$empr_id.'
			ORDER BY vis.fecha ASC';
		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		//var_dump($result);
  		if(isset($result[0]))
			return $result;
		else
			return array();
  	}

  	static public function getGenerEmprenFaltanDocs($empr_id){
  		$query = 'SELECT CONCAT("Documento <i>´", docu.requerimiento, "´</i> del emprendedor aún pendiente por cargar") AS "notificacion",
			"green" AS "color",
			NULL "visita_fecha",
			NULL "visita_nombre",
			NULL "inter_nombre",
			NULL "inter_apellido",
			proy.nombre "proy_nombre",
			empr.nombres "empre_nombre",
			empr.apellidos "empre_apellido"
			FROM app_emprendedor_documento docu
			INNER JOIN '._DBPFX_.'proyecto proy ON proy.id=docu.proyecto_id
			INNER JOIN '._DBPFX_.'usuario empr ON empr.id=proy.emprendedor_id
			INNER JOIN '._DBPFX_.'rol rol_empr ON rol_empr.id=empr.rol_id
			INNER JOIN '._DBPFX_.'usuario intr ON intr.id=proy.interventor_id
			INNER JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
			WHERE LOWER(rol_empr.nombre_unico)="emprendedor" AND LOWER(rol_intr.nombre_unico)="interventor" AND empr.id='.$empr_id.' AND docu.documento_id IS NULL';
		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return array();
  	}

  	static public function getPasadInterVisitas($empr_id){
  		$query = 'SELECT "Visitas de interventores pasadas" AS "notificacion",
			"transparent" AS "color",
			vis.fecha "visita_fecha",
			vis.nombre "visita_nombre",
			intr.nombres "inter_nombre",
			intr.apellidos "inter_apellido",
			proy.nombre "proy_nombre",
			empr.nombres "empre_nombre",
			empr.apellidos "empre_apellido"
			FROM app_visita vis
			INNER JOIN '._DBPFX_.'proyecto proy ON proy.id=vis.proyecto_id
			INNER JOIN '._DBPFX_.'usuario empr ON empr.id=proy.emprendedor_id
			INNER JOIN '._DBPFX_.'rol rol_emp ON rol_emp.id=empr.rol_id
			INNER JOIN '._DBPFX_.'usuario intr ON intr.id=proy.interventor_id
			INNER JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
			WHERE LOWER(rol_emp.nombre_unico)="emprendedor" AND LOWER(rol_intr.nombre_unico)="interventor" AND empr.id='.$empr_id.' AND vis.fecha < CURRENT_TIMESTAMP
			ORDER BY vis.fecha DESC';
		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return array();
  	}

  	static public function getDocsFaltantVisitas($empr_id){
  		$query = 'SELECT "Documentos faltantes de visitas pasadas de interventores" AS "notificacion",
			"blue" AS "color",
			vis.fecha "visita_fecha",
			vis.nombre "visita_nombre",
			intr.nombres "inter_nombre",
			intr.apellidos "inter_apellido",
			proy.nombre "proy_nombre",
			empr.nombres "empre_nombre",
			empr.apellidos "empre_apellido"
			FROM app_visita vis
			INNER JOIN '._DBPFX_.'proyecto proy ON proy.id=vis.proyecto_id
			INNER JOIN '._DBPFX_.'usuario empr ON empr.id=proy.emprendedor_id
			INNER JOIN '._DBPFX_.'rol rol_emp ON rol_emp.id=empr.rol_id
			INNER JOIN '._DBPFX_.'usuario intr ON intr.id=proy.interventor_id
			INNER JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
			WHERE LOWER(rol_emp.nombre_unico)="emprendedor" AND LOWER(rol_intr.nombre_unico)="interventor" AND empr.id='.$empr_id.' AND vis.documento_id IS NULL';
		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return array();
  	}

  	static public function getProxUrgentInterVisitas($empr_id, $notification_days){
  		$query = 'SELECT
  			vis.fecha "visita_fecha",
  			vis.nombre "visita_nombre"
  			FROM '._DBPFX_.'visita vis
  			INNER JOIN '._DBPFX_.'proyecto pry ON pry.id=vis.proyecto_id
  			INNER JOIN '._DBPFX_.'usuario intr ON intr.id=pry.interventor_id
  			INNER JOIN '._DBPFX_.'rol rol_intr ON rol_intr.id=intr.rol_id
  			INNER JOIN '._DBPFX_.'usuario empr ON empr.id=pry.emprendedor_id
  			INNER JOIN '._DBPFX_.'rol rol_empr ON rol_empr.id=empr.rol_id
  			WHERE LOWER(rol_intr.nombre_unico)="interventor" AND LOWER(rol_empr.nombre_unico)="emprendedor" AND empr.id='.$empr_id.' AND vis.fecha >= CURRENT_TIMESTAMP AND DATEDIFF(vis.fecha, CURRENT_TIMESTAMP)<='.$notification_days.'
  			ORDER BY vis.fecha DESC';
  		//var_dump($query);
  		$result = self::$conexion->query_db($query);
  		if(isset($result[0]))
			return $result;
		else
			return array();
  	}

}

class notificacionesCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAONotificaciones::$conexion = $this->main->db_data;
	}

	public function getProxInterVisitas($empr_id, $notification_days){
		return DAONotificaciones::getProxInterVisitas($empr_id, $notification_days);
	}

	public function getGenerEmprenFaltanDocs($empr_id){
		return DAONotificaciones::getGenerEmprenFaltanDocs($empr_id);
	}

	public function getPasadInterVisitas($empr_id){
		return DAONotificaciones::getPasadInterVisitas($empr_id);
	}

	public function getDocsFaltantVisitas($empr_id){
		return DAONotificaciones::getDocsFaltantVisitas($empr_id);
	}

	public function getProxUrgentInterVisitas($empr_id, $notification_days){
		return DAONotificaciones::getProxUrgentInterVisitas($empr_id, $notification_days);
	}

}