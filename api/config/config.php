<?php
	/****************************************************************************
	*	Desarrollado por: Fabián Murillo, fabianmurillo.01@gmail.com			*
	*					  © 2019												*
	****************************************************************************/

	define("USING_DB", true);

	$_DB_APP = array( 
		"Server"=>'localhost:33065',
		"User"=>'root',
		"Pass"=>'',
		"Db"=>'fonade_db',
		"Driver"=>'mysqli',
		"Debug"=>false,
		"Conector"=>'adodb');
		
	define("_MSFW_APP_NAME_","AppFONADE");

	/**** DEFICIÓN DE CONSTANTES ****/
	define("_MSFW_PATH_", 'http://' . substr($_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'], 0, strlen($_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) - strlen('index.php')));
	if (!defined("_BASE_PATH_")) define("_BASE_PATH_","");
	define("_API_PATH_",_BASE_PATH_."api/");
	define("_LIB_PATH_",_API_PATH_."libraries/");
	define("_ENGINE_PATH_",_API_PATH_."engine/");
	define("_DB_PATH_",_API_PATH_."db_connector/");
	define("_CONFIG_PATH_",_API_PATH_."config/");

	define("_APP_PATH_",_BASE_PATH_."app/");
	define("_CONTROLLER_PATH_",_APP_PATH_."controller/");
	define("_MODEL_PATH_",_APP_PATH_."model/");
	define("_VIEW_PATH_",_APP_PATH_."view/");

	define("_DEFAULT_CONTROLLER_",_CONTROLLER_PATH_."modules/rolHomeLoader"); //pagina principal
	define("_DEFAULT_VIEW_PATH_",_VIEW_PATH_."default/");
	define("_THEME_PATH_",_VIEW_PATH_."default/");
	define("_IMG_ROOT_","app/view/default/_img/");
	define("_UPLOAD_PROFILE_PIC_", str_replace("api/config/config.php", _IMG_ROOT_, str_replace("\\","/",__FILE__)));

	/*	Envio de correos	*/
	define("_EMAILFROM_", "no-reply@appfecode.com");

	/*	Notifications days time left	*/
	define("_NOTIFYDAYS_", 1);

	/* Dias hábiles entre visitas desde visita inicial */
	define("_VISTS_DAYS_", 120);

	/* Caracter de sepacion de CSV configurados en cada terminal para import y export*/
	define("_CSV_CHAR_", ",");

	/* Caracter de sepacion de CSV configurados en cada terminal */
	define("_USER_DEFAULT_PASSW_", "123456");

	/* Tiempo de caducidad de la sesión (en minutos) */
	define("_SESSION_TIME_", 720);


	define("_DBPFX_","app_"); //Prefijo tablas base de datos del sistema
	define("_CHARSET_","utf-8"); //Cotejamiento de las páginas

	// Definición de auto carga de clases para las librerías
	/*spl_autoload_register(function ($clase) {
    include_once (_LIB_PATH_ . "common/" . $clase . '.cls.php');
	});*/
?>
