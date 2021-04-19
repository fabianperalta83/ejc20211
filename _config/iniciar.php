<?php
/**
 * Inicializacion de constantes luego de un proceso de conocimiento de
 * lenguaje y plantilla definida
 * 
 * Micrositios Ltda. © Copyright 2005
 **/

define('_PLANTILLA', Funciones::buscarNombreTemplate($idcategoria, 'tpl_index.html'));
define('_IDIOMA', Funciones::BusquedaRecursiva($idcategoria, 'idioma'));
/**
 * CARGA DE LAS CONSTANTES FALTANTES...
 **/
define('_DIRTEMPLATE_ABS'    , _RUTABASE.sprintf("_templates/%s/", _PLANTILLA)); // Path absoluto del template escogido (para smarty)
define('_DIRTEMPLATE_REL'    , sprintf("_templates/%s/", _PLANTILLA)); // Carpetas con archivos de recursos Path relativo
define('_DIRRECURSOS'        , _DIRTEMPLATE_REL."recursos/");    // Carpetas con archivos de recursos
define('_DIRCSS'             , _DIRRECURSOS."css/");   // Carpetas con archivos de css
define('_DIRIMAGES'          , _DIRRECURSOS."images/");    // Carpetas con archivos de imagenes
define('_DIRIMAGES_AUX'		 , _DIRIMAGES."auxiliares/"); 	// Directorio de imagenes que se cambian muy pocas veces
define('_DIRIMAGES_IDIOMA'   , _DIRRECURSOS.sprintf("lang_%s", _IDIOMA."/"));           // Carpetas con archivos de recursos
define('_DIRNEWSLETTER'      , _DIRTEMPLATE_REL."templates/newsletter");       // Carpetas con archivos para los newsletter
define('_DIRSUBSITIOS'       , _DIRRECURSOS."subsitios/"); // Carpeta que contendra los recursos de los subitios es decir banner e imagenes

/**
 * CARGA DE LOS ARCHIVOS DEL MICROSITIO
 **/
global $trazaCategoria;
global $sroot;

//require_once(_DIRTEMPLATE_ABS.'config.php'); /** Constantes del micrositio @todo eliminar este archivo y poner las constantes en la BD */
if (!empty($trazaCategoria[$sroot]['varsubsitio'])) {
	$constSitio = stringtoarray($trazaCategoria[$sroot]['varsubsitio']); /** @see variables.php */
	while(list(, $v) = each($constSitio)) {
		eval("if(!defined('".$v["n"]."')) define('".$v["n"]."',	'".html_entity_decode($v["v"], ENT_QUOTES)."');");
	}
}

require_once(_DIRINTERFAZ.'idiomas/lang_'._IDIOMA.'.php');	/** Carga de los rotulos del lenguaje apropiado para el portal. */
?>