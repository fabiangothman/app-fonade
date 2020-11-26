<?php
  /********************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *                     © 2019                                        *
  *********************************************************************/

abstract class DAOPerfil{
  
  static public $conexion;

  static public function getUsuario($id){
    $query = 'SELECT usr.*, rol.nombre_unico, ciu.ciudad, lae.nombres "lae_nombres", lae.apellidos "lae_apellidos" FROM '._DBPFX_.'usuario usr
    LEFT JOIN '._DBPFX_.'rol rol ON rol.id=usr.rol_id
    LEFT JOIN '._DBPFX_.'ciudad ciu ON ciu.codigo_dane=usr.ciudad_dane
    LEFT JOIN '._DBPFX_.'usuario lae ON lae.id=usr.lae_id
    WHERE usr.id='.$id.' LIMIT 1';
    $result = self::$conexion->query_db($query);
    //return $query;
    if(isset($result[0]))
      return $result[0];
    else
      return false;
  }

  static public function updateUsuario($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane){
    $query = 'UPDATE '._DBPFX_.'usuario SET ';
    $query .= 'nombres="'.self::$conexion->safeText($nombres).'", ';
    $query .= 'apellidos="'.self::$conexion->safeText($apellidos).'", ';
    $query .= 'correo="'.self::$conexion->safeText($correo).'", ';
    if($clave)
      $query .= 'clave="'.md5(self::$conexion->safeText($clave)).'", ';
    $query .= 'telefono="'.self::$conexion->safeText($telefono).'", ';
    $query .= 'contacto="'.self::$conexion->safeText($contacto).'", ';
    $query .= 'ciudad_dane='.self::$conexion->safeText($ciudad_dane).' ';
    $query .= 'WHERE id='.self::$conexion->safeText($id);
    //return $query;
    return self::$conexion->exec_query_db($query);
  }

  static public function updateProfilePic($id, $image){
    $query = 'UPDATE '._DBPFX_.'usuario SET'.
    ' imagen="'.self::$conexion->safeText($image).'"';
    $query .= ' WHERE id='.self::$conexion->safeText($id);
    //return $query;
    return self::$conexion->exec_query_db($query);
  }

  static public function getCiudades(){
    $query = 'SELECT * FROM '._DBPFX_.'ciudad ciu ORDER BY ciu.ciudad ASC';
    $result = self::$conexion->query_db($query);
    if(isset($result[0]))
      return $result;
    else
      return false;
  }

}

class perfiles{

  private $main;
  private $userData = array();

  public function __construct(&$p_main){
    $this->main = $p_main;
    DAOPerfil::$conexion = $this->main->db_data;
  }

  public function getUsuario($id){
		return DAOPerfil::getUsuario($id);
  }

  public function getCiudades(){
    return DAOPerfil::getCiudades();
  }

  public function updateUsuario($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane){
    return DAOPerfil::updateUsuario($id, $nombres, $apellidos, $correo, $clave, $telefono, $contacto, $ciudad_dane);
  }

  public function updateProfilePic($id, $image){
    return DAOPerfil::updateProfilePic($id, $image);
  }


}