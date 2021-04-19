<?php
/************************************* VARIABLES DE INFORMACIÓN DEL USUARIO ****************************************/

/**
 * Inicializacion de la variable de session
 **/
 
require_once(_DIRLIB_ADMIN."Smarty.class.php");

$smarty = new Smarty_Plantilla;
 
 
session_name(preg_replace('/\s+/', '', strtolower(_DBNAME)));
session_start();


/**
 * validamos que esten en session las siguientes variables
 */
if (!isset($_SESSION['modo_edicion'])) $_SESSION['modo_edicion'] = FALSE;
if (!isset($_SESSION['modo_edicion_aprovado'])) $_SESSION['modo_edicion_aprovado'] = FALSE;

/**
 * Verificamos si viene modo edicion para guardarlo en session
 */
if (isset($_GET["e"])) {	// pasamos 'e' por GET para activar el modo de Edicion
	$_SESSION["modo_edicion"] = TRUE;
} elseif (isset($_GET["ne"])) { // pasamos 'ne' por GET para regresar al modo normal.
	$_SESSION["modo_edicion"] = FALSE;
}

$duracion = time() + 86400 * 365; // 365 dias

// Cookie para impedir votacion duplicada en las encuestas
if (isset($encuesta) && $_SERVER['REQUEST_METHOD'] == 'POST') {
     $idcategoria = ($idcategoria)?$idcategoria:1;
     $cookiename = "encuesta" . $idcategoria;
     setcookie($cookiename, 1, $duracion, "/", _URL, TRUE, TRUE);
}

// Cookie para impedir votacion muy seguida en los foros
if (isset($foro) && $_SERVER['REQUEST_METHOD'] == 'POST') {
     $duracion1 = time() + 15;
     setcookie("cookie_controlforo", 1, $duracion1, "/", _URL, TRUE, TRUE);
}

require_once(_DIRCORE."Autenticacion.class.php"); /** Cargamos la clase de Autenticacion */
$unAutenticacion = new Autenticacion();

/**
 * verificamos si viene Logout
 */
$unAutenticacion->Logout();

if (isset($_POST["usuario"]) and  isset($_POST["password"])) {
	
	$_POST["hash"] ="1";
	$unAutenticacion->validarUsuario($_POST["usuario"], $_POST["password"]);
	/* 
	  Redirecionamiento a formulario login si el valor del captcha es incorrecto
	
	$recaptcha = $_POST["g-recaptcha-response"];
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array(
		'secret' => '6LeM8uMUAAAAAPGrogAeayz2vQMA1WtC0hGm5AnP',
		'response' => $recaptcha
	);	
	$options = array(
		'http' => array (
			'method' => 'POST',
			'content' => http_build_query($data)
		)
	);

	$context  = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$captcha_success = json_decode($verify);
	
	if ($captcha_success->success) {
		// No eres un robot, continuamos con el envío del email
		// ...
		// ...
		//echo "<script>alert('Llego 1');</script>";
		$_POST["hash"] ="1";
		
		$unAutenticacion->validarUsuario($_POST["usuario"], $_POST["password"]);
		
	} else {
		// Eres un robot!
		$_POST["hash"] ="0";
		//echo "<script>alert('Llego 2');</script>";
		
		return $smarty->fetch('tpl_login.html');
	}*/
	/** Guardamos los datos del usuario en la sesion */
	
}

$unAutenticacion->validarUsuarioCategoria($idcategoria);


?>
