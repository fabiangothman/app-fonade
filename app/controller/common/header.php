<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/
	
	class header extends controller
	{
		private $rol;
		private $objAccess;
		private $usuario;

		protected function index()
		{
			$this->data = $this->header_data;
			$this->_MSFW_APP_NAME_ = _MSFW_APP_NAME_;
			$this->app_name = _MSFW_APP_NAME_;
			$this->rol = $this->main->usuario_rol;
			if($this->main->session->check_session()=="open")
				$this->usuario = $this->main->usuario->userData;

			$this->loadModel("common/accesoModulos.cls", false);
			$this->objAccess = new accesoModulosCRUD($this->main);

			$folderPath = $this->main->url_solver->getFolderPath();
			$this->controlador = $this->main->url_solver->getObjectName();

			//Se verifica que exista permisos para estar en cualquier módulo, excepto para todo dento de /login
			if(($folderPath!="app/controller/modules/login") && ($this->controlador!="rolHomeLoader")){
				//Se verifica el estado de la sesión y los permisos, para autorizar la entrada a cualquier controlador y modelo
				$rol_controllers_access = $this->objAccess->getAccessByRol($this->rol);
				$this->hasCapability($folderPath, $rol_controllers_access);
			}

			//Carga los mensajes entrantes
			$this->loadError();

			//Cargas del template
			$this->nombre_usuario = $this->usuario["nombres"]." ".$this->usuario["apellidos"];
			$this->rol_usuario = strtolower($this->rol);

			//Carga la foto de perfil
			$profileImagePath = _MSFW_PATH_._IMG_ROOT_."modules/".$this->rol."/perfil/fotosperfil/";
			if(isset($this->usuario)){
				if(($this->usuario['imagen']=="")||($this->usuario['imagen']==null))
					$this->profilepicurl = null;
				else
					$this->profilepicurl = $profileImagePath.$this->usuario['imagen'];
			}

			if($this->main->session->check_session()=="open"){
				//Cargar notificaciones
				$this->loadModel("modules/".$this->rol."/notificaciones/notificaciones.cls",false);
				$notifi = new notificacionesCRUD($this->main);
				if($this->rol=="administrador")
					$this->num_notificaciones = count($notifi->getProxUrgentInterVisitas(_NOTIFYDAYS_));
				else
					$this->num_notificaciones = count($notifi->getProxUrgentInterVisitas($this->usuario['id'], _NOTIFYDAYS_));
			}else{
				$this->num_notificaciones = 0;
			}

			//Variables del front
			$this->defaultProfileImage = _MSFW_PATH_._VIEW_PATH_."default/_img/common/100.png";
			
			

			//URL a páginas
			$this->ir_cerrar_sesion = _MSFW_PATH_."modules/login/logout";
			$this->ir_home = _MSFW_PATH_;
			$this->ir_proyectos = _MSFW_PATH_."modules/".$this->rol."/proyectos/proyectos";
			$this->ir_emprendedores = _MSFW_PATH_."modules/".$this->rol."/emprendedores/emprendedores";
			$this->ir_interventores = _MSFW_PATH_."modules/".$this->rol."/interventores/interventores";
			$this->ir_notificaciones = _MSFW_PATH_."modules/".$this->rol."/notificaciones/notificaciones";
			$this->ir_perfil = _MSFW_PATH_."modules/".$this->rol."/perfil/perfil";
			$this->ir_calendario = _MSFW_PATH_."modules/".$this->rol."/calendario/calendario";
			$this->ir_usuarios = _MSFW_PATH_."modules/".$this->rol."/usuarios/usuarios";
			$this->ir_roles = _MSFW_PATH_."modules/".$this->rol."/roles/roles";
			$this->ir_ciudades = _MSFW_PATH_."modules/".$this->rol."/ciudades/ciudades";
			$this->ir_departamentos = _MSFW_PATH_."modules/".$this->rol."/departamentos/departamentos";
			$this->ir_regiones = _MSFW_PATH_."modules/".$this->rol."/regiones/regiones";
			$this->ir_centro_negocios = _MSFW_PATH_."modules/".$this->rol."/centro_negocios/centro_negocios";
			$this->ir_convocatorias = _MSFW_PATH_."modules/".$this->rol."/convocatorias/convocatorias";
			$this->ir_visitas = _MSFW_PATH_."modules/".$this->rol."/visitas/visitas";
			$this->ir_reportes = _MSFW_PATH_."modules/".$this->rol."/reportes/reportes";
			$this->ir_cargacsv = _MSFW_PATH_."modules/".$this->rol."/cargacsv/cargacsv";
			$this->ir_documentos_emprendedor = _MSFW_PATH_."modules/".$this->rol."/documentos_emprendedor/documentos_emprendedor";
			$this->ir_documentos = _MSFW_PATH_."modules/".$this->rol."/documentos/documentos";
			$this->ir_laes = _MSFW_PATH_."modules/".$this->rol."/laes/laes";
			$this->ir_administradores = _MSFW_PATH_."modules/".$this->rol."/administradores/administradores";

			
			//$this->addLink("https://jqueryui.com/resources/demos/style.css", "stylesheet", "screen");
			//$this->addScript(false, "https://code.jquery.com/jquery-1.12.4.js");
			//$this->addScript(true, "common/jquery/jquery-1.12.4.js");
			//$this->addScript(false, "https://code.jquery.com/ui/1.12.1/jquery-ui.js");
			$this->addScript(true, "common/jquery/jquery-ui-1.12.1.js");

			$this->addScript(true, "datetimepicker/jquery-ui-timepicker-addon");
			$this->addStyle("common/datetimepicker/jquery-ui-timepicker-addon", "stylesheet", "screen");

			// Carga de archivos requeridos en el view
			$this->addStyle("common/general", "stylesheet", "screen");
			$this->addStyle("common/header", "stylesheet", "screen");

			//$this->addLink("https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans", "stylesheet", "screen");
			$this->addStyle("common/fonts/opensans", "stylesheet", "screen");
			//$this->addLink("https://fonts.googleapis.com/icon?family=Material+Icons", "stylesheet", "screen");
			$this->addStyle("common/fonts/materialicons", "stylesheet", "screen");
			//$this->addLink("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css", "stylesheet", "screen");
			$this->addStyle("common/fonts/font-awesome", "stylesheet", "screen");
			//$this->addLink("https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css", "stylesheet", "screen");
			$this->addStyle("common/jquery/jquery-ui-1.12.1", "stylesheet", "screen");
			//$this->addLink("https://jqueryui.com/resources/demos/style.css", "stylesheet", "screen");
			$this->addStyle("common/jquery/jquerydemos", "stylesheet", "screen");

			$this->addStyle("common/bootstrap/bootstrap.3.3.7.min", "stylesheet", "screen");
			$this->addScript(true, "header/header");
			$this->addScript(true, "bootstrap/bootstrap.3.3.7.min");
			$this->addjQueryScript(true, "jquery-3.3.1.min", "$");
			$this->addScript(true, "header/header");



			$this->addInReadyCode("
				MSHeader.init('"._MSFW_PATH_."', '"._MODEL_PATH_."', '"._VIEW_PATH_."');
				//
			");
		}

		private function loadError()
		{
			//Se cargan los posibles mensajes a enviar al view, según la variable
			$this->exito = "";
			$this->peligro = "";
			$this->info = "";
			$this->alerta = "";
			switch($this->convertNullToEmpty($this->getArg("mensaje")))
			{
				case "user closed":
					$this->info = "Ha cerrado sesión con éxito.";
					break;
				case "expired":
					$this->info = "La sesión expiró!";
					break;
				case "1":
					$this->info = "La sesión expiró!";
					break;
				case "2":
					$this->peligro = "ERROR: Debe ingresar los campos obligatorios de manera correcta.";
					break;
				case "3":
					$this->peligro = "ERROR: Email o contraseña incorrecta.";
					break;
				case "4":
					$this->peligro = "ERROR: La información de inicio de sesión automática no es válida.";
					break;
				case "5":
					$this->exito = "Ha cerrado sesión con éxito.";
					break;
				case "6":
					$this->exito = "Bienvenido ".$this->usuario['nombres']." ".$this->usuario['apellidos'].".";
					break;
				case "7":
					$this->exito = "Bienvenido ".$this->usuario['nombres']." ".$this->usuario['apellidos']." a la interface de Administración.";
					break;
				case "8":
					$this->peligro = "Por favor verifique la información. Existen datos incompletos.";
					break;
				case "9":
					$this->peligro = "Por favor verifique la información. Las contraseñas no coinciden.";
					break;
				case "10":
					$this->exito = "Se ha actualizado el perfil con éxito.";
					break;
				case "11":
					$this->peligro = "No se ha podido actualizar la información. Por favor vuelva a internatrlo más tarde.";
					break;
				case "12":
					$this->peligro = "No se ha podido actualizar la imágen de perfil. Por favor vuelva a internatrlo más tarde.";
					break;
				case "13":
					$this->exito = "Se ha actualizado la aplicación con el archivo CSV cargado con éxito.";
					break;
				case "14":
					$this->peligro = "Error: El archivo tiene columnas en la cabecera incorrectas. Por favor verifique el formato CSV e intente nuevamente.";
					break;
				case "15":
					$this->peligro = "Error: El archivo no tiene el número de columnas en la cabecera correcto. Por favor verifique el formato CSV e intente nuevamente.";
					break;
				case "16":
					$this->exito = "Se ha creado la nueva visita para el proyecto con éxito, además de las siguientes visitas automáticamente. Si es necesario puede modificarles a estas futuras visitas las fechas y horas.";
					break;
				case "17":
					$this->peligro = "ERROR: El correo ingresado es incorrecto o no existe en nuestra base de datos.";
					break;
				case "18":
					$this->alerta = "No se pudo enviar la nueva contraseña al correo electrónico. Por favor vuelva a intentarlo de nuevo.";
					break;
				case "19":
					$this->exito = "Se ha enviado la nueva contraseña al correo electónico.";
					break;
				case "20":
					$this->peligro = "ERROR: no se pudo guardar la nueva contraseña en la Base de datos. Intente más tarde.";
					break;
				default:
					$this->info = null;
					break;
			}
		}

		//Valida si un usuario tiene permisos de estar aquí
		private function hasCapability($currFolderPath, $array_rol_controllers_access){

			if($this->main->session->check_session()=="open"){

				if(!$this->isAbleToBeHere($currFolderPath, $this->controlador, $array_rol_controllers_access)){
					echo "No tiene autorización para estar aquí. Redirigiendo ...<br />";
					$this->refresh(_MSFW_PATH_, 2);
					exit();
				}
			}else{
				$this->redirect(_MSFW_PATH_);
				exit();
			}
		}

		//Comprueba si el usuario puede estar en este controlador, según arrayCapabilities
		private function isAbleToBeHere($currFolderPath, $curr_controller, $array_rol_controllers_access){
			$permiso = false;
			foreach ($array_rol_controllers_access as $key => $rol_controller) {

				if(($rol_controller['nombre_unico']==$curr_controller) && ($currFolderPath=="app/controller/modules/".$this->rol."/".basename($currFolderPath)))
					$permiso = true;
			}
			return $permiso;
		}

		public function render()
		{
			$output = $this->printView("common/header");	
			foreach($this->subControllers as $unSubController)
			{
				$output .= $unSubController->render();
			}
			return $output;
		}
	}
?>