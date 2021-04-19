<?php

ini_set("display_errors", "on");
ini_set("error_reporting", E_ALL & ~E_NOTICE);
//error_reporting(E_ALL ^ E_NOTICE);

//if(!defined("_DBCONNECT"));	define("_DBCONNECT"		,"mysql");	// Tipo de base de datos
if(!defined("_DBUSER"));		define("_DBUSER"		,"aacosta");	// Usuario de la base de datos
//if(!defined("_DBHOST"));		define("_DBHOST"		,"localhost");	// Host donde se encuentra la base de datos
if(!defined("_DBNAME"));		define("_DBNAME"		,"portal_base");	// Nombre de la base de datos
if(!defined("_DBPASSWORD"));	define("_DBPASSWORD"	,"M1cr0s*12");	// Password de la Base de Datos

$strTmp = basename(__FILE__);
$userDevelTmp = substr($strTmp, 0, strpos($strTmp, "."));
$strTmp = basename(dirname(dirname(dirname(__FILE__))));
$dirDevelTmp = $strTmp;

if(defined("_SISTEMA") && _SISTEMA == "U")
{
	$web_padre = 'micrositios.us/~'.$userDevelTmp.'/'.$dirDevelTmp.'/';
	
	// Raiz fisica del servidor. URL del portal principal. Ejemplo: www.nombredeldominio/
	if(defined("_WEBPADRE") && function_exists("runkit_constant_redefine") )
		runkit_constant_redefine('_WEBPADRE', $web_padre );
	else
		define('_WEBPADRE', $web_padre ); 
	
} elseif(defined("_SISTEMA")) {
//   define('_WEBPADRE'		, 'www.crcom.gov.co/crcportal/'); 		//Raiz f�sica del servidor
}

//echo "Datos personales importados<br>";

?>