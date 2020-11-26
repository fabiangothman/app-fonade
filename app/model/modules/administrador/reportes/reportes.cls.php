<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOReporte{
  	static public $conexion;

  	static public function generarReporte($emprendedores, $ciudad_emprendedores, $interventores, $ciudad_interventores, $proyectos, $convocatorias, $centros_negocios, $ciudades_centro_negocios, $visitas_start, $visitas_end){
  		$query = "SELECT
        empr.id 'emprendedor_id',
        empr.nombres 'emprendedor_nombres',
        empr.apellidos 'emprendedor_apellidos',
        empr.correo 'emprendedor_correo',
        "._USER_DEFAULT_PASSW_." 'emprendedor_clave',
        empr.telefono 'emprendedor_telefono',
        empr.contacto 'emprendedor_contacto',
        empr.ciudad_dane 'emprendedor_ciudad_dane',
        empr.rol_id 'emprendedor_rol_id',
        intr.id 'interventor_id',
        intr.nombres 'interventor_nombres',
        intr.apellidos 'interventor_apellidos',
        intr.correo 'interventor_correo',
        "._USER_DEFAULT_PASSW_." 'interventor_clave',
        intr.telefono 'interventor_telefono',
        intr.contacto 'interventor_contacto',
        intr.ciudad_dane 'interventor_ciudad_dane',
        intr.rol_id 'interventor_rol_id',
        lae.id 'lae_id',
        lae.nombres 'lae_nombres',
        lae.apellidos 'lae_apellidos',
        lae.correo 'lae_correo',
        "._USER_DEFAULT_PASSW_." 'lae_clave',
        lae.telefono 'lae_telefono',
        lae.contacto 'lae_contacto',
        lae.ciudad_dane 'lae_ciudad_dane',
        lae.rol_id 'lae_rol_id',
        proy.id 'proyecto_id',
        proy.nombre 'proyecto_nombre',
        proy.objetivo 'proyecto_objetivo',
        proy.fecha_asignacion 'proyecto_fecha_asignacion',
        proy.numero_contrato 'proyecto_numero_contrato',
        cneg.id 'centro_negocios_id',
        cneg.nombre 'centro_negocios_nombre',
        cneg.descripcion 'centro_negocios_descripcion',
        cneg.ciudad_dane 'centro_negocios_ciudad_dane',
        conv.numero 'convocatoria_numero',
        conv.fecha 'convocatoria_fecha',
        conv.descripcion 'convocatoria_descripcion',
        visi.nombre 'visita_nombre',
        visi.fecha 'visita_primeraFecha',
        visi.descripcion 'visita_descripcion',
        visi.documento_id 'visita_documento_id'
        FROM app_proyecto proy
        INNER JOIN app_usuario empr ON empr.id=proy.emprendedor_id
        INNER JOIN app_rol rol_empr ON rol_empr.id=empr.rol_id
        INNER JOIN app_usuario intr ON intr.id=proy.interventor_id
        INNER JOIN app_rol rol_intr ON rol_intr.id=intr.rol_id
        LEFT JOIN app_usuario lae ON lae.id=intr.lae_id
        INNER JOIN app_centro_negocios cneg ON cneg.id=proy.centro_negocios_id
        INNER JOIN app_convocatoria conv ON conv.numero=proy.convocatoria_numero
        INNER JOIN app_visita visi ON visi.proyecto_id=proy.id";

  		$condiciones = self::getQueryConditions($emprendedores, $ciudad_emprendedores, $interventores, $ciudad_interventores, $proyectos, $convocatorias, $centros_negocios, $ciudades_centro_negocios, $visitas_start, $visitas_end);
      $query .= $condiciones;

      //var_dump($query);
      $result = self::$conexion->query_db($query);
      return self::generateReportXLS($result);
  	}

  	static public function generateReportXLS($arrayResult){
  		$folder = "exports";
  		//self::removeFolderFiles($folder);
  		$my_file = $folder.'/generated_report_'.time().'.csv';
		$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
		$data = '"emprendedor_id","emprendedor_nombres","emprendedor_apellidos","emprendedor_correo","emprendedor_clave","emprendedor_telefono","emprendedor_contacto","emprendedor_ciudad_dane","emprendedor_rol_id","interventor_id","interventor_nombres","interventor_apellidos","interventor_correo","interventor_clave","interventor_telefono","interventor_contacto","interventor_ciudad_dane","interventor_rol_id","lae_id","lae_nombres","lae_apellidos","lae_correo","lae_clave","lae_telefono","lae_contacto","lae_ciudad_dane","lae_rol_id","proyecto_id","proyecto_nombre","proyecto_objetivo","proyecto_fecha_asignacion","proyecto_numero_contrato","centro_negocios_id","centro_negocios_nombre","centro_negocios_descripcion","centro_negocios_ciudad_dane","convocatoria_numero","convocatoria_fecha","convocatoria_descripcion","visita_nombre","visita_primeraFecha","visita_descripcion","visita_documento_id"'.PHP_EOL;
		foreach ($arrayResult as $key => $linea) {
			$contCols = 1;
			foreach($linea as $key => $columna) {
				$data .= '"'.$columna.'"';
				if($contCols<count($linea))
					$data .= _CSV_CHAR_;
				$contCols++;
			}
			$data .= PHP_EOL;
		}
		fwrite($handle, $data);
		fclose($handle);

		return _MSFW_PATH_.$my_file;

  	}

  	static public function removeFolderFiles($folder_route){
		$files = glob($folder_route . '/*');
		foreach($files as $file){
			if(is_file($file)){
				unlink($file);
		    }
		}
  	}

  	static public function getQueryConditions($emprendedores, $ciudad_emprendedores, $interventores, $ciudad_interventores, $proyectos, $convocatorias, $centros_negocios, $ciudades_centro_negocios, $visitas_start, $visitas_end){
  		$condiciones = "";
  		$contCondi=0;

  		if($emprendedores!="all" || is_int($emprendedores)){
  			$contCondi++;
  			$condiciones .=" WHERE (empr.id=$emprendedores)";
  		}
  		
  		if($ciudad_emprendedores!="all" || is_int($ciudad_emprendedores)){
  			$condiciones .= ($contCondi>0) ? " AND" : " WHERE";
  			$contCondi++;
  			$condiciones .=" (empr.ciudad_dane=$ciudad_emprendedores) AND";
  		}
  		if($proyectos!="all" || is_int($proyectos)){
  			$condiciones .= ($contCondi>0) ? " AND" : " WHERE";
  			$contCondi++;
  			$condiciones .=" (proy.id=$proyectos)";
  		}
  		if($centros_negocios!="all" || is_int($centros_negocios)){
  			$condiciones .= ($contCondi>0) ? " AND" : " WHERE";
  			$contCondi++;
  			$condiciones .=" (cneg.id=$centros_negocios)";
  		}
  		if($ciudades_centro_negocios!="all" || is_int($ciudades_centro_negocios)){
  			$condiciones .= ($contCondi>0) ? " AND" : " WHERE";
  			$contCondi++;
  			$condiciones .=" (cneg.ciudad_dane=$ciudades_centro_negocios)";
  		}
  		if($interventores!="all" || is_int($interventores)){
  			$condiciones .= ($contCondi>0) ? " AND" : " WHERE";
  			$contCondi++;
  			$condiciones .=" (intr.id=$interventores)";
  		}
  		if($ciudad_interventores!="all" || is_int($ciudad_interventores)){
  			$condiciones .= ($contCondi>0) ? " AND" : " WHERE";
  			$contCondi++;
  			$condiciones .=" (intr.ciudad_dane=$ciudad_interventores)";
  		}
  		if($convocatorias!="all" || is_int($convocatorias)){
  			$condiciones .= ($contCondi>0) ? " AND" : " WHERE";
  			$contCondi++;
  			$condiciones .=" (conv.numero=$convocatorias)";
  		}
  		if($visitas_start=="" && $visitas_end!=""){
  			$condiciones .= ($contCondi>0) ? " AND" : " WHERE";
  			$contCondi++;
  			$condiciones .=" (visi.fecha <= '$visitas_end')";
  		}else if($visitas_start!="" && $visitas_end==""){
  			$condiciones .= ($contCondi>0) ? " AND" : " WHERE";
  			$contCondi++;
  			$condiciones .=" (visi.fecha >= '$visitas_start')";
  		}else if($visitas_start!="" && $visitas_end!=""){
  			$condiciones .= ($contCondi>0) ? " AND" : " WHERE";
  			$contCondi++;
  			$condiciones .=" (visi.fecha >= '$visitas_start' AND visi.fecha <= '$visitas_end')";
  		}

      //Agrega los where necesarios para los tipos de usuarios
      $condiciones .= ($contCondi>0) ? " AND" : " WHERE";
      $condiciones .= " LOWER(rol_empr.nombre_unico)='emprendedor' AND LOWER(rol_intr.nombre_unico)='interventor'";

  		return $condiciones;
  	}

}

class reportesCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOReporte::$conexion = $this->main->db_data;
	}

	public function generarReporte($emprendedores, $ciudad_emprendedores, $interventores, $ciudad_interventores, $proyectos, $convocatorias, $centros_negocios, $ciudades_centro_negocios, $visitas_start, $visitas_end){
		return DAOReporte::generarReporte($emprendedores, $ciudad_emprendedores, $interventores, $ciudad_interventores, $proyectos, $convocatorias, $centros_negocios, $ciudades_centro_negocios, $visitas_start, $visitas_end);
	}

}