<?php
/************************************** CARGA DE VARIABLES GENERALES *************************************************/
$mt = explode(' ', microtime());
$t1 = $mt[1] +$mt[0];

/**
 * @name $EXECS
 * @global global $EXECS Tiene los querys ejecutados
 */
$EXECS = 0;

/**
 * @name $CACHED
 * @global global $CACHED Tiene los querys cacheados
 */
$CACHED = 0;

/**
 * Configuracion de variables de PHP
 **/
if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
//    echo 'I am at least PHP version 5.3.0, my version: ' . PHP_VERSION . "\n";
}else
{
	// This function has been DEPRECATED as of PHP 5.3.0. Relying on this feature is highly discouraged.
set_magic_quotes_runtime (0);
}
//error_reporting(E_ALL);

/**
 * Limpieza de lo que viene por POST y GET
 */

require_once(_DIRCORE."Autenticacion.class.php");
require_once(_DIRCORE."FriendlyURL.class.php");	// CARGA LAS FUNCIONES IMPORTANTES DEL PORTAL
FriendlyURL::$enable = TRUE;

foreach($_POST as $key => $value)
{
    $_POST[$key] = Autenticacion::secureSQL($value,$key);
}

foreach($_GET as $key => $valueGet)
{
    $_GET[$key] = Autenticacion::secureSQL($valueGet,$key);
}

foreach($_REQUEST as $key => $value)
{
    $_REQUEST[$key] = Autenticacion::secureSQL($value,$key);
}

/**
 * Verificacion de que el idcategoria sea numerico y que venga por POST o por GET
 * y si viene algo que no es numerico, se envia al buscador
 **/

/**
 * @name $idcategoria
 * @global global $idcategoria Carga el id del $idcategoria actual
 */
$idcategoria = getVariable('idcategoria', 1);
if (!is_numeric($idcategoria)) {
	$idcategoria = 1;
}



/*
   Capturamos el campo de entradilla de todos las categorias dela pagina.
*/
$entradilla_form = getVariable('entradilla_form');




/**
 * Inicializacion del Objeto de Abstracción de DB
 **/
require_once(_RUTABASE.'_db/adodb.inc.php');	/** CARGA DEL OBJETO */
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$db = NewADOConnection(_DBCONNECT);
$db->Connect(_DBHOST, _DBUSER, _DBPASSWORD, _DBNAME) /*or die("Error al conectarse a la base de datos")*/;
$db->fnExecute = 'CountExecs'; /** Funcion que cuenta los querys ejecutados */
$db->fnCacheExecute = 'CountCachedExecs'; /** Funcion que cuenta los querys cacheados */



/**
 * Generacion de la categoria a partir del url amigable 
 */
if( isset($_GET['__friendly_name']) )
{
	if( strpos($_GET['__friendly_name'], "/") === 0 )
		$_GET['__friendly_name'] = substr($_GET['__friendly_name'], 1);
	if( strrpos($_GET['__friendly_name'], "/") === (strlen($_GET['__friendly_name'])-1) )
		$_GET['__friendly_name'] = substr($_GET['__friendly_name'], 0, -1);
	if( strrpos($_GET['__friendly_name'], ".do") == (strlen($_GET['__friendly_name'])-3) )
	{
		$_GET['__friendly_name'] = substr($_GET['__friendly_name'], 0, strlen($_GET['__friendly_name'])-3);
	}
//echo "<pre>";
//echo "\$_SERVER['REQUEST_URI']: ".$_SERVER['REQUEST_URI']."<br>";
//echo "\$_GET: "; print_r($_GET);
////echo "\$_POST: "; print_r($_POST);
//echo "</pre>";
	if( $_GET['__friendly_name'] == "" )
		$__idcategoria__ = 1;
	else
	{
		$__idcategoria__ = FriendlyURL::friendlyId2IdCategoria($db, $_GET['__friendly_name']);
	}
	
	// Si no se encuentra ninguna categoria con ese nombre y tampoco se dio un friendly name valido se abre home
	if( $__idcategoria__ == "" )
	{
		// Si el friendly url buscado tiene el formato de un archivo entonces realmente es un error 404.
		$ext_fu = $_GET['__friendly_name'];
		$ext_fu = substr($ext_fu, strrpos($_GET['__friendly_name'], ".") );
//		echo "Substring: $ext_fu<br>";
		$arreglo_404 = array( '.js', '.jpg', '.jpeg', '.bmp', '.txt', 'png', '.gif', '.html' );
		if( in_array(strtolower($ext_fu), $arreglo_404) )
		{
			header("HTTP/1.0 404 Not Found");
			/*die();*/
		}
		$__idcategoria__ = 1;
	}

	$_GET['idcategoria'] = $__idcategoria__;
	$_POST['idcategoria'] = $__idcategoria__;
	$_REQUEST['idcategoria'] = $__idcategoria__;
	unset($_GET['__friendly_name']);
//	echo "Categoria por nombre traducida: {$_GET['__friendly_name']} => $__idcategoria__<br>";
//	echo "<pre>";
//	echo "\$_GET: "; print_r($_GET);
////	echo "\$_POST: "; print_r($_POST);
//	echo "</pre>";
}else if(isset ($_GET['idcategoria']))
{
	// Para mantener la compatibilidad con el cambio de urls amigables se reestaura la idcategoria quitandole los slash.
	if( strpos($_GET['idcategoria'], "/") !== false )
	{
		$_GET['idcategoria'] = str_replace("/", "", $_GET['idcategoria']);
	}
}

/**
 * @name $idcategoria
 * @global global $idcategoria Carga el id del $idcategoria actual
 */
$idcategoria = getVariable('idcategoria', 1);
if (!is_numeric($idcategoria)) {
        $idcategoria = 1;
}
 
/**
 * @name $sroot
 * @global global $sroot Carga el idroot del $idcategoria actual
 */
$sroot = Funciones::BuscarRoot($idcategoria);

/**
 * @name $trazaCategoria
 * @global global $trazaCategoria Contiene la informacion de los ancestros de la categoria actual y la categoria actual.
 */
$trazaCategoria = array();
$trazaCategoria = Funciones::obtenerInfoCategoria($idcategoria);

require_once(_RUTABASE."_config/iniciar.php");	// CARGA CONSTANTES SEGUN EL MICROSITIO

/**
 * @name $display
 * @global global $display Contiene los display actuales del portal.
 */
$display = array();

// TEMPLATE DE EDICION POR CADA TIPO DE EDITOR		TIPO1	TIPO2
$display[0]	= array("TemplateDefault"		   		,1		,"Default"								,"");
$display[1]	= array("TemplateHome"			  		,1		,"Tipo Home"							,"");
$display[2]	= array("TemplateInclude"		   		,0		,"**NO EDITABLE**"						,"");
$display[3]	= array("TemplateInclude"		   		,1		,"Incluir Archivo"						,"");
$display[4]	= array("TemplateRedireccionInterna"	,1		,"Redirec. secci&oacute;n interna"		,"");
$display[5]	= array("TemplateExternaConMarco"		,1		,"URL Externa con Marco"				,"");
$display[7]	= array("TemplateNoticiaAvanzado"		,1		,"Default Con Filtro por Fecha"			,"");
$display[10] = array("TemplateDescargar"			,1		,"Descargar Archivo"					,"");
$display[11] = array("DisplayHomeGenerico"			,1		,"Home Gen&eacute;rico"					,"");
$display[12] = array("TemplateRedireccionExterna"	,1		,"Redireccion Externa"					,"");
$display[13] = array("TemplateHTML"					,1		,"C&oacute;digo HTML"					,"");
$display[16] = array("FormatoContratacion"			,1		,"Contrataci&oacute;n"					,"Contratacion");
// $display[17] = array("FormatoContratacionHV"		,1		,"Contrataci&oacute;n Hojas de vida"	,"ContratacionHV");
// $display[18] = array("TemplateProyecto"				,1		,"Proyectos"							,"");
// $display[19] = array("TemplateFichaBibliografica"	,1		,"Ficha Bibliografica"					,"");
$display[20] = array("TemplateUnidades"				,1		,"Tipo Principal Unidades"				,"");
// $display[21] = array("TemplateDirectorioTelefonico"	,1		,"Tipo Directorio Telef�nico"			,"");
$display[22] = array("TemplateNoticiasPrincipal"	,1		,"Tipo Principal de Noticias"			,"");
$display[23] = array("TemplateDefaultNoticias"		,1		,"Noticia con comentario"				,"");

/**
 * @name $display_sub
 * @global global $display_sub Contiene los sub-display actuales del portal.
 */
$display_sub = array();
$display_sub[0]  = array("DisplaySubmenuHeredar"	   	,1	,"** Heredar **");
$display_sub[1]  = array("DisplaySubCategorias"		 	,1	,"Lista sencilla");
$display_sub[2]  = array("DisplaySubCategorias"	   		,1	,"Lista con resumen");
$display_sub[3]  = array("DisplaySubCategorias"	 		,1	,"Lista con contenido");
$display_sub[4]  = array("DisplaySubCategorias"	 		,1	,"Lista de descarga");
$display_sub[5]  = array("DisplaySubMenuGaleria"	   	,1	,"Galer&iacute;a fotogr&aacute;fica");
$display_sub[6]  = array("DisplaySubMenuPrimerNivel"	,1	,"Lista en Cuadros");
$display_sub[7]  = array("DisplaySubMenuGaleriaAudio"	,1	,"Galer&iacute;a de audio");
$display_sub[8]  = array("DisplaySubMenuForos"			,1	,"Foro");
$display_sub[9]  = array("DisplaySubMenuEncuesta"		,1	,"Encuesta");
$display_sub[10] = array(""							   	,1	,"**Ocultar subcategorías**");
$display_sub[11] = array("DisplaySubMenuContratacion" 	,1	,"**Contratacion**");
$display_sub[12] = array("DisplaySubMenuGaleriaVideo" 	,1	,"Galería de Video");
$display_sub[13] = array("DisplaySubMenuContratacionHV" ,1	,"**Contrataci&oacute;n Hojas de vida**");
$display_sub[14] = array("DisplayEncuestaSatisfaccion"	,1	,"Encuesta Satisfacci&oacute;n");
$display_sub[15] = array("DisplaySubMenuGaleriaMulti"   ,1  ,"Galer&iacute;a  Multimedia");
$display_sub[16] = array("DisplaySubMenuPublicaciones"  ,1  ,"Visualizaci&oacute;n publicaciones");
$display_sub[17] = array("DisplaySubMenuResumenColumnas",1  ,"Lista con resumen cuadros");
$display_sub[18] = array("DisplaySubMenuInfografia"     ,1  ,"Visualización Infografía");
$display_sub[19] = array("DisplaySubMenuVistaGaleria"   ,1  ,"Vista galer&iacute;a fotogr&aacute;fica");
$display_sub[19] = array("DisplaySubMenuNoticiasPpal"   ,1  ,"Vista noticias principal");
$display_sub[20] = array("DisplaySubMenuResumenNoticias",1  ,"Lista con resumen noticias");

/**
 * Tipos de Usuario
 */
$__tipoUsuario = array(1 => "Visitante", 2 => "Editor", 9 => "Administrador");
$__rotActivo = array(0 => "Inactivo", 1 => "Activo");
$__tipoPermiso = array(1 => "Ver, Duplicar, Crear", 3 => "No puede Borrar", 4 => "Todos los Permisos");
$__tipoEventos = array(   0 => "Navegado"
						, 1 => "Editado"
						, 2 => "Borrado"
						, 3 => "Creado"
						, 4 => "Desactivado"
						, 5 => "Activado"
						, 6 => "Duplicado"
						, 7 => "Movido"
						, 8 => "Eliminado"
						, 9 => "Restaurada"
						, 10 => "Archivo Borrado"
						, 11 => "Archivo Renombrado"
						, 12 => "Archivo Editado"
					   );



/***************************************** FUNCIONES DE CARACTER GENERAL *******************************************/

# $db is the connection object
function CountExecs($db, $sql, $inputarray) {
	global $EXECS; /** @see variables.php */

	if (!is_array($inputarray)) $EXECS++;
	# handle 2-dimensional input arrays
	else if (is_array(reset($inputarray))) $EXECS += sizeof($inputarray);
	else $EXECS++;
}

# $db is the connection object
function CountCachedExecs($db, $secs2cache, $sql, $inputarray) {
	global $CACHED; $CACHED++; /** @see variables.php */
}

/**
 * Funcion para deplegar un aviso de error
 * @param string $cadena Mensaje
 **/
function msgError($cadena = '', $printMsg = TRUE) {
	$echo = "<div style=\"background:#FFFBE6;border:1px dotted #ccc;padding:5px;margin:5px 0;font:12px tahoma;\">".$cadena."</div>";
	if ($printMsg === TRUE) {
		echo ($echo);
	} else {
		return $echo;
	}
}

/**
 * errorQuery
 *
 * @return
 **/
function errorQuery($linea, $archivo, $dbe = '') {
	global $db;

	if (!empty($dbe) and gettype($dbe) == 'object') {
		$dbError = $dbe;
	} else {
		$dbError = $db;
	}

	$msg = "Error [<span style='color:#ff0000'>".$dbError->ErrorMsg()."</span>] en el query [<span style='color:#0000ff'>".$dbError->_sql."</span>] que está en la linea $linea del archivo ".basename($archivo);
	msgError($msg);
	/*exit(1);*/ // No continuamos la ejecución para asegurarnos de que nos funcione todo al pelo

//header('Location:'._URL.'index.php?idcategoria=1');
}
/**
 * getVariable
 * Saca la variable que viene por get o post
 * @param string nombre
 * @return
 */
function getVariable($nombre, $default = '') {
	if (isset($_POST[$nombre])) {
		return $_POST[$nombre];
	} elseif(isset($_GET[$nombre])) {
		return $_GET[$nombre];
	} else {
		return $default;
	}
}
/**
 * tomarTiempo
 * @param inteher $ts Tiempo de inicio
 * @return
 **/
function tomarTiempo($ts = '') {
	global $db; /** @see variables.php */
	global $EXECS; /** @see variables.php */
	global $CACHED; /** @see variables.php */

	if (empty($ts)) {
		global $t1;
		$ts = $t1;
	}
	//Visualización del tiempo de generación de la página
	$mt = explode(' ', microtime());
	$t2 = $mt[1]+$mt[0] - $ts;
	printf('<div style="display:none;padding:10px;border:1px solid #ccc;">[P&aacute;gina generada en: %01.3f segundos]&nbsp;[Querys Ejecutados:%s]&nbsp;[Querys Cacheados:%s]</div>', $t2, $EXECS, $CACHED);
}
/**
 * headerLocation
 * Se hizo para que la redireccion sirva, ya que en IE 5.5 y anteriores
 * tienen problemas con el header('Location: ');
 * Por eso se dejo con Javascript.
 * @param
 * @return
 */
function headerLocation($location) {
	$loc2 = $location;
//echo "TEst: ".__FILE__."->".__LINE__."<br>";
	if( FriendlyURL::$enable )
	{
		$loc2 = preg_replace_callback( FriendlyURL::$urlRegex, "FriendlyURL::callback_replace", $loc2 );
		if( strlen($loc2)>0 && $loc2{0} != "/" && substr($loc2, 0, 4) != "http" )
		{
			// Si se logra un reemplazo por urls amigables es por que estamos en un virtual host
			// y entonces debmos redireccionar a la raiz del virutal host.
//echo "TEst: ".__FILE__."->".__LINE__."<br>";
			$loc2 = "/$loc2";
		}elseif($loc2=="")
		{
			// Esto es para las categorias cuyo nombre_url es vacio.
			$loc2 = "/";
		}
	}
//	if($location == $loc2)
//	{
//		print_r(debug_backtrace());
//		throw new Exception("Error, la redirección se esta realizando al mismo enlace de origen.");
//	}
//echo "<font color='red'>Enviando de $location a $loc2</font><br><pre>";
//print_r(debug_backtrace());
//flush();
//print('<script type="text/javascript" language="Javascript">alert(\'Enviando a: '.$loc2.'\');</script>');
//die();
	print('<script type="text/javascript" language="Javascript">window.location = \''.$loc2.'\';</script>');
	//header('Location: '.$location);
}
/**
 * arraytostring
 * Se creo por que hubo problemas con la funcion "serialize" al tener "magic_quotes" activo
 * y al serializar algo con comillas quedaba la cadena mal formada, por lo tanto quedaba inservible.
 * Por lo tanto se hizo una funcion para sustituirlo.(Tener cuidado con las comillas si se guarda en el bd)
 * @param array $array
 * @param boolean $compress
 * @return string
 */
function arraytostring($array){
	$text = "array(";
	$x = 0;
	$count = count($array);
	foreach ($array as $key => $value) {
		$x++;
		if (is_array($value)) {
			$text .= $key."=>".arraytostring($value);
			if ($count != $x) $text .= ",";
			continue;
		}
		$text .= "\"$key\"=>\"$value\"";
		if ($count != $x) $text .= ",";
	}
	$text .= ")";
	return $text;
}
/**
 * stringtoarray
 * Es la funcion contraria a "arraytostring"
 * @param param $string
 * @return
 */
function stringtoarray($string) {
	/**
	 * Probamos que sea un array sin comprimir
	 */
	if (is_string($string)) {
		if (strstr($string, 'array')) {
			eval("\$arrayAux = $string;");
			return $arrayAux;
		}
	} else {
		return FALSE;
	}
}

/* Creacion del arreglo que contiene la descripcion de los tipos de documentos
 * de la biblioteca (catalogo en l?nea)*/
function getTiposDocumento(){
	$tipos_documento["I"]	= "Investigaci&oacute;n";
	$tipos_documento["AV"]	= "Archivo vertical";
	$tipos_documento["AR"]	= "Art&iacute;culo de revisa";
	$tipos_documento["L"]	= "Libro";
	$tipos_documento["R"]	= "Revista";
	$tipos_documento["T"]	= "Tesis";
	$tipos_documento["D"]	= "Documento";	
	
	return $tipos_documento;
}
?>
