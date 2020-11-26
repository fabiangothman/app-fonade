<?php
	/******************************************************/
	/*	Desarrollado por: Multimedia Service S.A. © 2017	*/
	/*	Framework propiedad exclusiva Multimedia Service	*/
	/******************************************************/

	// Version MS-MEDIATECA
	define('VERSION', '1.0.0.0');

	// Error Reporting
	error_reporting(E_ALL & ~E_DEPRECATED );

	// Check Version
	if (version_compare(phpversion(), '5.3.0', '<') == true) {
		exit('PHP5.3+ Required');
	}

	date_default_timezone_set('America/Bogota');//Zona horaria de Bogotá

	// Magic Quotes Fix
	if (ini_get('magic_quotes_gpc')) {
		function clean($data){
			if (is_array($data)) {
				foreach ($data as $key => $value) {
					$data[clean($key)] = clean($value);
				}
			} else {
				$data = stripslashes($data);
			}
			return $data;
		}			
		
		$_GET = clean($_GET);
		$_POST = clean($_POST);
		$_REQUEST = clean($_REQUEST);
		$_COOKIE = clean($_COOKIE);
	}
	
	include_once("api/config/config.php");
	include_once(_ENGINE_PATH_."main.php");
	
	$app = new main();
?>