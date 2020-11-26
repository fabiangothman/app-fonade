<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *          		© 2019    						                  *
  *********************************************************************/

abstract class DAOCargaCSV{
  	static public $conexion;

    static private function fieldExists($table, $field, $value){
      $query = "SELECT count(*) AS 'conteo' FROM $table WHERE $field='".self::$conexion->safeText($value)."'";
      $resul = self::$conexion->query_db($query);
      if(isset($resul[0]['conteo']) && ($resul[0]['conteo']>0))
        return true;
      else
        return false;
    }

    static public function getDocumIdIfExists($documento_id){
      $query = 'SELECT id FROM '._DBPFX_.'documento WHERE ';
      $query .= 'id='.self::$conexion->safeText($documento_id).' ';
      $query .= 'LIMIT 1';
      $resul = self::$conexion->query_db($query);
      if(isset($resul[0]['id']) && ($resul[0]['id']>0))
        return $resul[0]['id'];
      else
        return false;
    }

    static private function getVisitaIdExists($proyecto_id, $fecha, $descripcion, $nombre, $documento_id){
      $documento_id = (is_null($documento_id)) ? "null" : $documento_id;
      $query = 'SELECT id FROM '._DBPFX_.'visita WHERE ';
      $query .= 'proyecto_id='.self::$conexion->safeText($proyecto_id).' AND ';
      $query .= 'fecha="'.self::$conexion->safeText($fecha).'" AND ';
      $query .= 'descripcion="'.self::$conexion->safeText($descripcion).'" AND ';
      $query .= 'nombre="'.self::$conexion->safeText($nombre).'" AND ';
      $query .= 'documento_id='.self::$conexion->safeText($documento_id).' ';
      $query .= 'LIMIT 1';
      $resul = self::$conexion->query_db($query);
      if(isset($resul[0]['id']) && ($resul[0]['id']>0))
        return $resul[0]['id'];
      else
        return false;
    }

    static private function isValidTimeStamp($timestamp){
      try{
        new DateTime('@' . $timestamp);
      }catch(Exception $e) {
          return false;
      }
      return true;
    }

    static public function validateRowEmprendedor($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id){
      $errores = 0;
      if(!is_int((int)$id))
        $errores++;
      if(!self::fieldExists(_DBPFX_."ciudad", "codigo_dane", $ciudad_dane))
        $errores++;
      if(!self::fieldExists(_DBPFX_."rol", "id", $rol_id))
        $errores++;
      if(empty($nombres)||empty($apellidos)||empty($correo)||empty($clave)||empty($telefono)||empty($contacto))
        $errores++;

      return $errores;
    }

    static public function validateRowInterventor($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id){
      $errores = 0;
      if(!is_int((int)$id))
        $errores++;
      if(!self::fieldExists(_DBPFX_."ciudad", "codigo_dane", $ciudad_dane))
        $errores++;
      if(!self::fieldExists(_DBPFX_."rol", "id", $rol_id))
        $errores++;
      if(empty($nombres)||empty($apellidos)||empty($correo)||empty($clave)||empty($telefono)||empty($contacto))
        $errores++;

      return $errores;
    }

    static public function validateRowLae($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id){
      $errores = 0;
      if(!is_int((int)$id))
        $errores++;
      if(!self::fieldExists(_DBPFX_."ciudad", "codigo_dane", $ciudad_dane))
        $errores++;
      if(!self::fieldExists(_DBPFX_."rol", "id", $rol_id))
        $errores++;
      if(empty($nombres)||empty($apellidos)||empty($correo)||empty($clave)||empty($telefono)||empty($contacto))
        $errores++;

      return $errores;
    }

    static public function validateRowProyecto($id, $nombre, $objetivo, $fecha_asignacion, $numero_contrato){
      $errores = 0;
      if(!is_int((int)$id))
        $errores++;
      if(!self::isValidTimeStamp(strtotime($fecha_asignacion)))
        $errores++;
      if(empty($nombre)||empty($objetivo)||empty($numero_contrato))
        $errores++;

      return $errores;
    }

    static public function validateRowCentroNegocios($id, $nombre, $descripcion, $ciudad_dane){
      $errores = 0;
      if(!is_int((int)$id))
        $errores++;
      if(!self::fieldExists(_DBPFX_."ciudad", "codigo_dane", $ciudad_dane))
        $errores++;
      if(empty($nombre)||empty($descripcion))
        $errores++;

      return $errores;
    }

    static public function validateRowConvocatoria($numero, $fecha, $descripcion){
      $errores = 0;
      if(!is_int((int)$numero))
        $errores++;
      if(!self::isValidTimeStamp(strtotime($fecha)))
        $errores++;
      if(empty($descripcion))
        $errores++;

      return $errores;
    }

    static public function validateRowVisita($nombre, $primeraFecha, $descripcion, $documento_id){
      $errores = 0;
      if(!self::isValidTimeStamp(strtotime($primeraFecha)))
        $errores++;
      if(empty($nombre)||empty($descripcion))
        $errores++;
      if(!is_int((int)$documento_id) && $documento_id<>"NO")
        $errores++;

      return $errores;
    }

    //Start saves

    static public function saveRowConvocatoria($numero, $fecha, $descripcion){
      if(self::fieldExists(_DBPFX_.'convocatoria', 'numero', $numero)){
        $query = 'UPDATE '._DBPFX_.'convocatoria SET ';
        $query .= 'fecha="'.self::$conexion->safeText($fecha).'", ';
        $query .= 'descripcion="'.self::$conexion->safeText($descripcion).'" ';
        $query .= 'WHERE numero='.self::$conexion->safeText($numero);
        $res = self::$conexion->exec_query_db($query);
        if($res===true)
          return $numero;
        else
          return false;
      }else{
        $query = 'INSERT INTO '._DBPFX_.'convocatoria(';
        $query .='numero, fecha, descripcion';
        $query .=') VALUES (';
        $query .= ''.self::$conexion->safeText($numero).', ';
        $query .= '"'.self::$conexion->safeText($fecha).'", ';
        $query .= '"'.self::$conexion->safeText($descripcion).'"';
        $query .= ')';
        $res = self::$conexion->exec_query_db($query);
        if($res===true)
          return $numero;
        else
          return false;
      }
    }

    static public function saveRowCentroNegocios($id, $nombre, $descripcion, $ciudad_dane){
      if(self::fieldExists(_DBPFX_.'centro_negocios', 'id', $id)){
        $query = 'UPDATE '._DBPFX_.'centro_negocios SET ';
        $query .= 'id='.self::$conexion->safeText($id).', ';
        $query .= 'ciudad_dane='.self::$conexion->safeText($ciudad_dane).', ';
        $query .= 'nombre="'.self::$conexion->safeText($nombre).'", ';
        $query .= 'descripcion="'.self::$conexion->safeText($descripcion).'" ';
        $query .= 'WHERE id='.self::$conexion->safeText($id);
        $res = self::$conexion->exec_query_db($query);
        if($res===true)
          return $id;
        else
          return false;
      }else{
        $query = 'INSERT INTO '._DBPFX_.'centro_negocios(';
        $query .='id, ciudad_dane, nombre, descripcion';
        $query .=') VALUES (';
        $query .= ''.self::$conexion->safeText($id).', ';
        $query .= ''.self::$conexion->safeText($ciudad_dane).', ';
        $query .= '"'.self::$conexion->safeText($nombre).'", ';
        $query .= '"'.self::$conexion->safeText($descripcion).'"';
        $query .= ')';
        $res = self::$conexion->exec_query_db($query);
        if($res===true)
          return $id;
        else
          return false;
      }
    }

    static public function saveRowEmprendedor($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id){
      if(self::fieldExists(_DBPFX_.'usuario', 'id', $id)){
        $query = 'UPDATE '._DBPFX_.'usuario SET ';
        $query .= 'id="'.self::$conexion->safeText($id).'", ';
        $query .= 'nombres="'.self::$conexion->safeText($nombres).'", ';
        $query .= 'apellidos="'.self::$conexion->safeText($apellidos).'", ';
        $query .= 'correo="'.self::$conexion->safeText($correo).'", ';
        $query .= 'clave="'.md5(self::$conexion->safeText($clave)).'", ';
        $query .= 'telefono="'.self::$conexion->safeText($telefono).'", ';
        $query .= 'contacto="'.self::$conexion->safeText($contacto).'", ';
        $query .= 'ciudad_dane="'.self::$conexion->safeText($ciudad_dane).'", ';
        $query .= 'rol_id="'.self::$conexion->safeText($rol_id).'" ';
        $query .= 'WHERE id='.self::$conexion->safeText($id);
        $res = self::$conexion->exec_query_db($query);
        //var_dump($query);
        if($res===true)
          return $id;
        else
          return false;
      }else{
        $query = 'INSERT INTO '._DBPFX_.'usuario(';
        $query .= 'id, nombres, apellidos, correo, clave, telefono, contacto, ciudad_dane, rol_id';
        $query .= ') VALUES (';
        $query .= '"'.self::$conexion->safeText($id).'", ';
        $query .= '"'.self::$conexion->safeText($nombres).'", ';
        $query .= '"'.self::$conexion->safeText($apellidos).'", ';
        $query .= '"'.self::$conexion->safeText($correo).'", ';
        $query .= '"'.md5(self::$conexion->safeText($clave)).'", ';
        $query .= '"'.self::$conexion->safeText($telefono).'", ';
        $query .= '"'.self::$conexion->safeText($contacto).'", ';
        $query .= '"'.self::$conexion->safeText($ciudad_dane).'", ';
        $query .= '"'.self::$conexion->safeText($rol_id).'")';
        $res = self::$conexion->exec_query_db($query);
        //var_dump($query);
        if($res===true)
          return $id;
        else
          return false;
      }
    }

    static public function saveRowLae($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id){
      if(self::fieldExists(_DBPFX_.'usuario', 'id', $id)){
        $query = 'UPDATE '._DBPFX_.'usuario SET ';
        $query .= 'id='.self::$conexion->safeText($id).', ';
        $query .= 'nombres="'.self::$conexion->safeText($nombres).'", ';
        $query .= 'apellidos="'.self::$conexion->safeText($apellidos).'", ';
        $query .= 'correo="'.self::$conexion->safeText($correo).'", ';
        $query .= 'clave="'.md5(self::$conexion->safeText($clave)).'", ';
        $query .= 'telefono="'.self::$conexion->safeText($telefono).'", ';
        $query .= 'contacto="'.self::$conexion->safeText($contacto).'", ';
        $query .= 'ciudad_dane="'.self::$conexion->safeText($ciudad_dane).'", ';
        $query .= 'rol_id="'.self::$conexion->safeText($rol_id).'" ';
        $query .= 'WHERE id='.self::$conexion->safeText($id);
        $res = self::$conexion->exec_query_db($query);
        if($res===true)
          return $id;
        else
          return false;
      }else{
        $query = 'INSERT INTO '._DBPFX_.'usuario(';
        $query .= 'id, nombres, apellidos, correo, clave, telefono, contacto, ciudad_dane, rol_id';
        $query .= ') VALUES (';
        $query .= '"'.self::$conexion->safeText($id).'", ';
        $query .= '"'.self::$conexion->safeText($nombres).'", ';
        $query .= '"'.self::$conexion->safeText($apellidos).'", ';
        $query .= '"'.self::$conexion->safeText($correo).'", ';
        $query .= '"'.md5(self::$conexion->safeText($clave)).'", ';
        $query .= '"'.self::$conexion->safeText($telefono).'", ';
        $query .= '"'.self::$conexion->safeText($contacto).'", ';
        $query .= '"'.self::$conexion->safeText($ciudad_dane).'", ';
        $query .= '"'.self::$conexion->safeText($rol_id).'")';
        $res = self::$conexion->exec_query_db($query);
        if($res===true)
          return $id;
        else
          return false;
      }
    }

    static public function saveRowInterventor($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id){
      if(self::fieldExists(_DBPFX_.'usuario', 'id', $id)){
        $query = 'UPDATE '._DBPFX_.'usuario SET ';
        $query .= 'id='.self::$conexion->safeText($id).', ';
        $query .= 'nombres="'.self::$conexion->safeText($nombres).'", ';
        $query .= 'apellidos="'.self::$conexion->safeText($apellidos).'", ';
        $query .= 'correo="'.self::$conexion->safeText($correo).'", ';
        $query .= 'clave="'.md5(self::$conexion->safeText($clave)).'", ';
        $query .= 'telefono="'.self::$conexion->safeText($telefono).'", ';
        $query .= 'contacto="'.self::$conexion->safeText($contacto).'", ';
        $query .= 'ciudad_dane="'.self::$conexion->safeText($ciudad_dane).'", ';
        $query .= 'rol_id="'.self::$conexion->safeText($rol_id).'", ';
        $query .= 'lae_id="'.self::$conexion->safeText($lae_id).'" ';
        $query .= 'WHERE id='.self::$conexion->safeText($id);
        $res = self::$conexion->exec_query_db($query);
        if($res===true)
          return $id;
        else
          return false;
      }else{
        $query = 'INSERT INTO '._DBPFX_.'usuario(';
        $query .= 'id, nombres, apellidos, correo, clave, telefono, contacto, ciudad_dane, rol_id, lae_id';
        $query .= ') VALUES (';
        $query .= '"'.self::$conexion->safeText($id).'", ';
        $query .= '"'.self::$conexion->safeText($nombres).'", ';
        $query .= '"'.self::$conexion->safeText($apellidos).'", ';
        $query .= '"'.self::$conexion->safeText($correo).'", ';
        $query .= '"'.md5(self::$conexion->safeText($clave)).'", ';
        $query .= '"'.self::$conexion->safeText($telefono).'", ';
        $query .= '"'.self::$conexion->safeText($contacto).'", ';
        $query .= '"'.self::$conexion->safeText($ciudad_dane).'", ';
        $query .= '"'.self::$conexion->safeText($rol_id).'", ';
        $query .= '"'.self::$conexion->safeText($lae_id).'")';
        $res = self::$conexion->exec_query_db($query);
        if($res===true)
          return $id;
        else
          return false;
      }
    }

    static public function saveRowProyecto($id, $emprendedor_id, $interventor_id, $nombre, $objetivo, $fecha_asignacion, $numero_contrato, $convocatoria_numero, $centro_negocios_id){
      if(self::fieldExists(_DBPFX_.'proyecto', 'id', $id)){
        $query = 'UPDATE '._DBPFX_.'proyecto SET ';
        $query .= 'id='.self::$conexion->safeText($id).', ';
        $query .= 'emprendedor_id="'.self::$conexion->safeText($emprendedor_id).'", ';
        $query .= 'interventor_id="'.self::$conexion->safeText($interventor_id).'", ';
        $query .= 'nombre="'.self::$conexion->safeText($nombre).'", ';
        $query .= 'objetivo="'.self::$conexion->safeText($objetivo).'", ';
        $query .= 'fecha_asignacion="'.self::$conexion->safeText($fecha_asignacion).'", ';
        $query .= 'numero_contrato="'.self::$conexion->safeText($numero_contrato).'", ';
        $query .= 'convocatoria_numero="'.self::$conexion->safeText($convocatoria_numero).'", ';
        $query .= 'centro_negocios_id="'.self::$conexion->safeText($centro_negocios_id).'" ';
        $query .= 'WHERE id='.self::$conexion->safeText($id);
        //var_dump($query);
        $res = self::$conexion->exec_query_db($query);
        if($res===true)
          return $id;
        else
          return false;
      }else{
        $query = 'INSERT INTO '._DBPFX_.'proyecto(';
        $query .= 'id, emprendedor_id, interventor_id, nombre, objetivo, fecha_asignacion, numero_contrato, convocatoria_numero, centro_negocios_id';
        $query .= ') VALUES (';
        $query .= '"'.self::$conexion->safeText($id).'", ';
        $query .= '"'.self::$conexion->safeText($emprendedor_id).'", ';
        $query .= '"'.self::$conexion->safeText($interventor_id).'", ';
        $query .= '"'.self::$conexion->safeText($nombre).'", ';
        $query .= '"'.self::$conexion->safeText($objetivo).'", ';
        $query .= '"'.self::$conexion->safeText($fecha_asignacion).'", ';
        $query .= '"'.self::$conexion->safeText($numero_contrato).'", ';
        $query .= '"'.self::$conexion->safeText($convocatoria_numero).'", ';
        $query .= '"'.self::$conexion->safeText($centro_negocios_id).'")';
        //var_dump($query);
        $res = self::$conexion->exec_query_db($query);
        if($res===true)
          return $id;
        else
          return false;
      }
    }

    static public function saveRowVisita($proyecto_id, $nombre, $fechaPrimera, $descripcion, $documento_id){

      $documento_id = (is_null($documento_id)) ? "null" : $documento_id;

      $id = self::getVisitaIdExists($proyecto_id, $fechaPrimera, $descripcion, $nombre, $documento_id);
      if($id===false){
        $newId = self::$conexion->autoID(_DBPFX_.'visita', 'id');
        $query = 'INSERT INTO '._DBPFX_.'visita(';
        $query .= 'proyecto_id, nombre, fecha, descripcion, documento_id';
        $query .= ') VALUES (';
        $query .= '"'.self::$conexion->safeText($proyecto_id).'", ';
        $query .= '"'.self::$conexion->safeText($nombre).'", ';
        $query .= '"'.self::$conexion->safeText($fechaPrimera).'", ';
        $query .= '"'.self::$conexion->safeText($descripcion).'", ';
        $query .= ''.self::$conexion->safeText($documento_id).')';
        //var_dump($query);
        $res = self::$conexion->exec_query_db($query);
        if($res===true)
          return $newId;
        else
          return false;
      }else{
        $query = 'UPDATE '._DBPFX_.'visita SET ';
        $query .= 'proyecto_id="'.self::$conexion->safeText($proyecto_id).'", ';
        $query .= 'nombre="'.self::$conexion->safeText($nombre).'", ';
        $query .= 'fecha="'.self::$conexion->safeText($fechaPrimera).'", ';
        $query .= 'descripcion="'.self::$conexion->safeText($descripcion).'", ';
        $query .= 'documento_id='.self::$conexion->safeText($documento_id).' ';
        $query .= 'WHERE id='.self::$conexion->safeText($id);
        $res = self::$conexion->exec_query_db($query);
        if($res===true)
          return $id;
        else
          return false;
      }
    }    

}

class cargacsvCRUD{
	private $main;
	private $userData = array();

	public function __construct(&$p_main){
		$this->main = $p_main;
		DAOCargaCSV::$conexion = $this->main->db_data;
	}

  public function validateRowEmprendedor($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id){
    return DAOCargaCSV::validateRowEmprendedor($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id);
  }
  public function validateRowInterventor($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id){
    return DAOCargaCSV::validateRowInterventor($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id);
  }
  public function validateRowLae($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id){
    return DAOCargaCSV::validateRowLae($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id);
  }
  public function validateRowProyecto($id, $nombre, $objetivo, $fecha_asignacion, $numero_contrato){
    return DAOCargaCSV::validateRowProyecto($id, $nombre, $objetivo, $fecha_asignacion, $numero_contrato);
  }
  public function validateRowCentroNegocios($id, $nombre, $descripcion, $ciudad_dane){
    return DAOCargaCSV::validateRowCentroNegocios($id, $nombre, $descripcion, $ciudad_dane);
  }
  public function validateRowConvocatoria($numero, $fecha, $descripcion){
    return DAOCargaCSV::validateRowConvocatoria($numero, $fecha, $descripcion);
  }
  public function validateRowVisita($nombre, $primeraFecha, $descripcion, $documento_id){
    return DAOCargaCSV::validateRowVisita($nombre, $primeraFecha, $descripcion, $documento_id);
  }


  //Start saves
  public function saveRowEmprendedor($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id){
    return DAOCargaCSV::saveRowEmprendedor($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id);
  }
  public function saveRowLae($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id){
    return DAOCargaCSV::saveRowLae($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id);
  }
  public function saveRowInterventor($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id){
    return DAOCargaCSV::saveRowInterventor($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane, $rol_id, $lae_id);
  }
  public function saveRowProyecto($id, $emprendedor_id, $interventor_id, $nombre, $objetivo, $fecha_asignacion, $numero_contrato, $convocatoria_numero, $centro_negocios_id){
    return DAOCargaCSV::saveRowProyecto($id, $emprendedor_id, $interventor_id, $nombre, $objetivo, $fecha_asignacion, $numero_contrato, $convocatoria_numero, $centro_negocios_id);
  }
  public function saveRowCentroNegocios($id, $nombre, $descripcion, $ciudad_dane){
    return DAOCargaCSV::saveRowCentroNegocios($id, $nombre, $descripcion, $ciudad_dane);
  }
  public function saveRowConvocatoria($numero, $fecha, $descripcion){
    return DAOCargaCSV::saveRowConvocatoria($numero, $fecha, $descripcion);
  }
  public function saveRowVisita($proyecto_id, $nombre, $fechaPrimera, $descripcion, $documento_id){
    return DAOCargaCSV::saveRowVisita($proyecto_id, $nombre, $fechaPrimera, $descripcion, $documento_id);
  }
  public function getDocumIdIfExists($documento_id){
    return DAOCargaCSV::getDocumIdIfExists($documento_id);
  }

}