<?php
  /****************************************************************************
  * Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com      *
  *           Juan Suárez, juancsuarezg@correo.udistrital.edu.co  *
  *           © 2017                        *
  ****************************************************************************/

abstract class DAOHome{
  
  static public $conexion;
  
  static public function xxx($x){
    return 0;
  }

}

class homes
{
  private $main;
  private $userData = array();

  public function __construct(&$p_main)
	{
    $this->main = $p_main;
    DAOPartidas::$conexion = $this->main->db_data;
  }

  public function xxx($x)
	{
		return DAOHome::xxx($x);
  }


}