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
set_magic_quotes_runtime (0);
error_reporting(E_ALL);

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
$display[0]	= array("TemplateDefault"		   		,1		,"Default"						,"");
$display[1]	= array("TemplateHome"			  		,1		,"Tipo Home"					,"");
$display[2]	= array("TemplateInclude"		   		,0		,"**NO EDITABLE**"				,"");
$display[3]	= array("TemplateInclude"		   		,1		,"Incluir Archivo"				,"");
$display[4]	= array("TemplateRedireccionInterna"	,1		,"Redirec. sección interna"		,"");
$display[5]	= array("TemplateExternaConMarco"		,1		,"URL Externa con Marco"		,"");
//$display[6] = array("TemplateAuxiliar"				,1		,"Auxiliar"						,"TemplateAuxiliarEdicion");
$display[7]	= array("TemplateNoticiaAvanzado"		,1		,"Default Con Filtro por Fecha"	,"");
//$display[8]	= array("TemplateCatalogo"				,1		,"Cat&aacute;logo de Productos"	,"");
//$display[9]	= array("TemplateProducto"				,1		,"Producto del Cat&aacute;logo"	,"");
$display[10] = array("TemplateDescargar"			,1		,"Descargar Archivo"			,"");
$display[11] = array("DisplayHomeGenerico"			,1		,"Home Genérico"				,"");
$display[12] = array("TemplateRedireccionExterna"	,1		,"Redireccion Externa"			,"");
$display[13] = array("TemplateHTML"					,1		,"C&oacute;digo HTML"			,"");
$display[16] = array("FormatoContratacion"			,1		,"Contrataci&oacute;n"			,"Contratacion");

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
$display_sub[5]  = array("DisplaySubMenuGaleria"	   	,1	,"Galería fotográfica");
$display_sub[6]  = array("DisplaySubMenuPrimerNivel"	,1	,"Lista en Cuadros");
$display_sub[7]  = array("DisplaySubMenuGaleriaAudio"	,1	,"Galería de audio");
$display_sub[8]  = array("DisplaySubMenuForos"			,1	,"Foro");
$display_sub[9]  = array("DisplaySubMenuEncuesta"		,1	,"Encuesta");
$display_sub[10] = array(""							   	,1	,"**Ocultar subcategorías**");
$display_sub[11] = array("DisplaySubMenuContratacion" 	,1	,"**Contratacion**");

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
/*	global $db;

	if (!empty($dbe) and gettype($dbe) == 'object') {
		$dbError = $dbe;
	} else {
		$dbError = $db;
	}

	$msg = "Error [<span style='color:#ff0000'>".$dbError->ErrorMsg()."</span>] en el query [<span style='color:#0000ff'>".$dbError->_sql."</span>] que está en la linea $linea del archivo ".basename($archivo);
	msgError($msg);
	exit(1); // No continuamos la ejecución para asegurarnos de que nos funcione todo al pelo
*/
header('Location:'._URL.'index.php?idcategoria=1');
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
	printf('<div style="display:none;padding:10px;border:1px solid #ccc;">[Página generada en: %01.3f segundos]&nbsp;[Querys Ejecutados:%s]&nbsp;[Querys Cacheados:%s]</div>', $t2, $EXECS, $CACHED);
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
	print('<script type="text/javascript" language="Javascript">window.location = \''.$location.'\';</script>');
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
?>
