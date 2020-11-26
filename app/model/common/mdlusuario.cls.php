<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/
	
	abstract class DAOUsuario
	{
		static public $conexion;
		
		static public function login($p_email, $p_contrasena)
		{
			$query = "SELECT * FROM "._DBPFX_."usuario usr INNER JOIN "._DBPFX_."rol rol ON rol.id=usr.rol_id WHERE usr.correo = '".self::$conexion->safeText($p_email)."' AND usr.clave = '".md5(self::$conexion->safeText($p_contrasena))."' LIMIT 1";
			//var_dump($query);
			//return $query;
			return self::$conexion->query_db($query);
		}
		
		static public function getUserById($pUser_id)
		{
			$query = "SELECT * FROM "._DBPFX_."usuario usr INNER JOIN "._DBPFX_."rol rol ON rol.id=usr.rol_id WHERE usr.id=".self::$conexion->safeText($pUser_id);
			//return $query;
      		return self::$conexion->query_db($query);
		}

		static public function getAllUsers($id)
		{
			$query = "SELECT * FROM "._DBPFX_."usuario usr LEFT JOIN "._DBPFX_."rol rol ON rol.id=usr.rol_id ";
					if($id != null || $id_usuario != "" ){
						$query .= 	"WHERE usr.id != ".$id;
					}
			//echo $query;
			return self::$conexion->query_db($query);
		}

		static public function editUser($id, $name, $lastname, $email, $password, $rol_id)
		{
			$query = 'UPDATE '._DBPFX_.'usuario set ';

			if($name != null ){
				$query .= ' nombres = "'.self::$conexion->safeText($name).'" ';
			}

			if($lastname != null ){
				$query .= ', apellidos = "'.self::$conexion->safeText($lastname).'" ';
			}

			if($email != null || $email != ""){
				$query .= ', correo = "'.self::$conexion->safeText($email).'" ';
			}

			if($password != null || $password != ""){
				$query .= ', clave = "'.md5($password).'" ';
			}

			if($imagen != null || $imagen != ""){
				$query .= ', imagen = "'.self::$conexion->safeText($imagen).'" ';
			}

			if($telefono != null || $telefono != ""){
				$query .= ', telefono = "'.self::$conexion->safeText($telefono).'" ';
			}

			if($contacto != null || $contacto != ""){
				$query .= ', contacto = "'.self::$conexion->safeText($contacto).'" ';
			}

			if($ciudad_id != null || $ciudad_id != ""){
				$query .= ', ciudad_id = '.$ciudad_id.', ';
			}

			if($rol_id != null || $rol_id != ""){
				$query .= ', rol_id = '.$rol_id.', ';
			}

			$query .= ' WHERE id = '.$id;
			var_dump($query);

			//die('Editando usuario: <br>'.$query);

			return self::$conexion->exec_query_db($query);
		}
		
	}
	
	class usuario
	{
		private $main;
		public $userData = array();
		
		public function __construct(&$p_main, $p_method = null, $p_email = null, $p_clave = null, $p_id = null)
		{
			$this->main = $p_main;
			DAOUsuario::$conexion = $this->main->db_data;
			switch($p_method)
			{
				case "login":
					$this->userData = DAOUsuario::login($p_email, $p_clave);
					//var_dump($this->userData);
          			break;
				case "id":
					$this->userData = DAOUsuario::getUserById($p_id);
					break;
				default:
					break;
			}
			$this->userData = (!empty($this->userData))?$this->userData[0]:$this->userData;
		}
			
		
		public function login($p_email, $p_clave)
		{
			return DAOUsuario::login($p_email, $p_clave);
		}
		

		public function getUserById($pUser_id)
		{
			return DAOUsuario::getUserById($pUser_id);
		}

		public function getAllUsers($id_usuario = null)
		{
			return DAOUsuario::getAllUsers($id_usuario);
		}

		public function editUser($id, $name, $lastname, $email, $password, $rol_id)
		{
			return DAOUsuario::editUser($id, $name, $lastname, $email, $password, $rol_id);
		}

		///////////////////////FUNCIONES GLOBALES////////////////////////////////
		
		public function __isset($name)
	    {
	      return isset($this->userData[$name]);
	    }
			
		public function __set($name, $value)
	    {
				if (isset($this->userData[$name]))
	        $this->userData["old_".$name] = $this->userData[$name];
				$this->userData[$name] = $value;
	    }

	    public function __get($name)
	    {
				if (array_key_exists($name, $this->userData)) {
					return $this->userData[$name];
				}

				$trace = debug_backtrace();
				trigger_error(
					'Undefined property via __get(): ' . $name .
					' in ' . $trace[0]['file'] .
					' on line ' . $trace[0]['line'],
					E_USER_NOTICE);
				return null;
	    }
	}
?>