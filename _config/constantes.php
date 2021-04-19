<?php
/**
 * ARCHIVO DONDE SE ENCUENTRA LA CONFIGURACION BASICA DEL PORTAL
 *
 *
 * Micrositios Ltda. - Copyright 2013
 **/

function cargar_datos_personales_desarrollador()
{
    // Para poder soportar q este archivo se convierta en un problema entre los usuarios del control de versiones
    // quienes lo modificara y cambiaran los valores para los demas se implementa un sistema de archivos por usuario
    // muy util para poder que cada usuario tenga sus propios settings
    try
    {
                // Para que cuando este archivo sea cargado desde la linea de comenado no genere NOICE
                if(!isset($_SERVER) || !isset($_SERVER['REQUEST_URI']))
                        return;

        $dir_config = dirname(__FILE__);
        $detected_user = $_SERVER['REQUEST_URI'];
        if(strpos($detected_user, "~") !== false )
        {
            $partes = explode("/", $detected_user);
            foreach ($partes as $parte)
            {
                if( trim($parte) != "" && strpos($parte, "~") === 0 )
                {
                    $detected_user = substr($parte, 1);
                    $path = "$dir_config/_devel/$detected_user.constantes.config.php";
                    if( @file_exists($path) )
                    {
                        // echo "FILE EXISTS $path<br>";
                        require($path);
                        break; // foreach
                    }
                }
            }
        }
    }catch (Exception $e)
    {
        //
    }
}

// PRIORIDA A LAS VARIABLES DE DESARROLLO SI ENCONTRADAS
#cargar_datos_personales_desarrollador();

/*
 * ******************* NOTA PARA LOS DESARROLLADORES **************************
 * Este archivo solo debe representar las variables para el portal de
 * produccion, si se desea modificar las variables de para desarrollos en
 * ambientes linux, es recomendable utilizar los archivos que existen en
 * _config/_devel/USUARIO_DESARROLLO.constantes.config.php, este metodo
 * es compatible con control de versiones y asi evitar que entre
 * desarrolladores nos modifiquemos las variables como por ejemplo base de
 * datos y otros.
 * ******************* NOTA PARA LOS DESARROLLADORES **************************
 */

/**
 * Define la codificacion por defecto del portal
 */
define('_MICROS_DEF_CHARSET', "ISO-8859-1");

/**
 * VARIABLES DE LA BASE DE DATOS
 **/
define("_DBCONNECT"             ,"mysql");     // Tipo de base de datos
define("_DBUSER"                ,"ejercitomil_portal");     // Usuario de la base de datos
//define("_DBHOST"               ,"64.131.74.35");       // Host donde se encuentra la base de datos
define("_DBHOST"                ,"10.100.10.4");  // 127.0.0.1 Host donde se encuentra la base de datos
//define("_DBHOST"		,"127.0.0.1");
define("_DBNAME"                ,"ejercitomil_portal");        // Nombre de la base de datos
define("_DBPASSWORD"    ,"VMM37Kr3GJPDYsL7gb2XRs8aWRXRDg");  // Password de la Base de Datos

/**
 * VARIABLES DEL PORTAL

 **/
define('_SISTEMA', "U"); // U = Unix, Linux O = Otro

#cargar_datos_personales_desarrollador();

if(_SISTEMA == "U")
{
   define('_RUTABASE'           ,dirname(dirname(__FILE__))."/");               // Carpetas con archivos raiz en Linux
   define('_SLASH'                      ,'/');
   define('_DOCUMENT_ROOT'      , _RUTABASE);                                           //Raiz f�sica del servidor
   define('_WEBPADRE'           , 'www.ejercito.mil.co/');              //Raiz f�sica del servidor

} else {
   define('_RUTABASE'           ,dirname(dirname(__FILE__))."/");               // Carpetas con archivos raiz en Windows
   define('_SLASH'                      ,'/');
   define('_DOCUMENT_ROOT'      , _RUTABASE);                           //Raiz f�sica del servidor
   define('_WEBPADRE'           , 'www.ejercito.mil.co/');              //Raiz f�sica del servidor
}

/**
 * configuracion para URLS amigables
 */
define('COLUMNA_NOMBRE_BASE'    , 'nombre_base'); // Es la columna que contiene los nombres base
define('COLUMNA_NOMBRE_UNICO'   , 'nombre_unico'); // Es la columna que contiene los nombres unicos sobre el base
define('COLUMNA_NOMBRE_NIVEL'   , 'nombre_nivel'); // Es la columna que contiene los nombres unicos sobre el base
define('COLUMNA_NOMBRE_URL'     , 'nombre_url'); // Es la columna que contiene los urls amigables
define('_DIR_URI_BASE'  , ''); // Siempre debe ser vacio para urls amigables a menos que la carpeta no este en la raiz del VHOST,
/**
 * INFORMACI�N Y VARIABLES DEL SITIO
 **/
define('_EMAIL_ADMINISTRADOR'           ,'jhernandez@micrositios.net');         // Email del administrador de la pagina
define('_EMAIL_ADMINISTRADOR_FAQ'       ,'jhernandez@micrositios.net'); // Email de las FAQ
define('_PASS'                                          ,'alp');                // Password seccion de usuarios registrados
define('_DIAS_CADUCIDAD'                        ,'15');                 // Dias de vigencia de un articulo en el home page por default

/**
 * DIRECTORIOS DONDE SE UBICAN LOS ARCHIVOS DEL PORTAL (dejar sin slash al principio pero con slash al final)
 **/
define('_DIRLIB'                        , _RUTABASE."_lib/");                   // Directorio de las librerias
define('_DIRCORE'                       , _DIRLIB."core/"); // Directorio de las librerias core del portal
define('_DIRBUSCAR'                     , _DIRLIB."buscar/"); // Directorio de las librerias core del portal
define('_DIRJPGRAPH'            , _DIRLIB."jpgraph/"); // Directorio de las librerias core del portal
define('_DIRINTERFAZ'           , _RUTABASE."_interfaz/"); // Directorio de las librerias de Interfaz del sitio
define('_DIRTEMPLATES'          , _RUTABASE.'_templates/');    // Directorio de los templates
define('_DIRTEMPLATES_BOLETIN', _RUTABASE.'_templates_boletin/');    // Directorio de los templates
define('_DIRRELATIVE_BOLETIN', '_templates_boletin/');    // Directorio de los templates
define('_DIREDITOR_USER'     , 'editores/');     // Carpetas con documentos para usar en las p�ginas
define('_DIR_INCLUDE'     , _RUTABASE.'_include/');     // Carpetas con documentos para usar en las p�ginas
define('_DIRINCLUDE'     , _RUTABASE.'_include/');     // Carpetas con documentos para usar en las p�ginas
define('_AUTHOR','Micrositios Content Manager');
/**
 * DIRECTORIOS DE ADMINISTRACION
 */
define('_DIRADMIN_ABS'                  ,_RUTABASE."_administracion/"); // Path absoluto del template escogido (para smarty)
define('_DIRADMIN_REL'                  ,"_administracion/"); // Carpetas con archivos de recursos Path relativo
define('_DIRRECURSOS_ADMIN'     ,_DIRADMIN_REL."recursos/"); // Carpetas con archivos de recursos
define('_DIRLIB_ADMIN'                  ,_DIRADMIN_ABS."lib/"); // Carpetas con archivos libreria
define('_DIRCSS_ADMIN'                  ,_DIRRECURSOS_ADMIN."css/"); // Carpetas con archivos de css
define('_DIRIMAGES_ADMIN'       ,_DIRRECURSOS_ADMIN."images/"); // Carpetas con archivos de imagenes
define('_NUMREG_LST_ADMIN'              , 300);  // Numero de registros listado por pagina en la administracion

/**
 *  CARPETAS DE TEMPLATES (dejar sin slash al principio pero con slash al final)
 **/
define('_DIR_ROTULOS_IDIOMAS'   , _DIRINTERFAZ."idiomas/"); // Carpetas con los rotulos en distintos idiomas
define('_DIRRECURSOS_USER'              , 'recursos_user/');     // Carpetas con imagenes para usar en las p�ginas
define('_DIRIMAGES_USER'        , _DIRRECURSOS_USER.'imagenes');     // Carpetas con imagenes para usar en las p�ginas
define('_DIRDOCS_USER'          , _DIRRECURSOS_USER.'documentos/');     // Carpetas con documentos para usar en las p�ginas
/** Se cambio la ruta para que ya no guarde a recursos_user/pqr sino a pqr2  **/
define('_DIRRECURSOS_USER_PQR'          , _RUTABASE.'recursos_user/pqr2/');     // Carpetas para realizar la ruta de los archivos almacenados por los usuarios y  que se imprimen en el pdf
define('_DIR_TMPFILES'  , '/tmp/');
/**
 * RECURSOS DEL EDITOR DEL PORTAL
 */
define('_DIR_IMAGES_EDITOR', '_editor/images/');

/**
 * Modulo de autocompletar en busqueda
 */
define('_DIRPHPSPELLCHECK', _DIRLIB."phpspellcheck/"); //carpeta libreria ayuda modulo buscar

/**
 *  DEFINICION DE TABLAS
 **/
define('_TBLCATEGORIA'          ,'categoria');                  // Tabla de categorias
define('_TBLUSUARIO'            ,'usuario');                            // Tabla de usuarios
define('_TBLCIUDADES'           ,'ciudades');                           // Tabla de ciudades
define('_TBLREGISTRO'           ,'registro');                           // Tabla registro busquedas
define('_TBLLISTAS'                     ,'listas');                             // Tabla de listas
define('_TBLDETALLELISTA'       ,'detallelista');                       // Tabla de listas
define('_TBLEDITORES'           ,'editores');                           // Tabla de acreedores
define('_TBLACCESO'                     ,'acceso');                             // Tabla de acceso por grupos
define('_TBLSMS'                        ,'sms_transaccion_detalle');            // Tabla de logs de sms
define('_TBLMAIL'                       ,'mail');                                       // Tabla de mail
define('_TBLFTOTAL'                     ,'ftotal');             // Tabla de frecuencia total
define('_TBLFORIGINAL'          ,'frecuencia_original');                // Tabla de frecuencia de palabras de articulos
define('_TBLKEYMATCH'           ,'keymatch');   // Tabla de keymatch
define('_TBLSTOPWORDS'          ,'stopwords');  // Tabla de usuarios registrados en comunidades
define('_TBLREGCOMUNIDAD'       ,'registro_comunidad'); // Tabla de usuarios registrados en comunidades
define('_TBLCONTRATACION_ESTADOS'       ,'contratacion_estado');        // Tabla de estados posibles para los contratos
define('_TBLCONTRATACION_ETAPAS'        ,'contratacion_etapas');        // Tabla de etapas posibles para los contratos
define('_TBLCONTRATACION_ORDGASTO'      ,'contratacion_ordenador_gasto');       // Tabla de ordenadores del gasto posibles para los contratos
define('_TBLSUBSITIO'       ,  'subsitio');  // Tabla subsitio para modulo Administración de banner.
define('_TBLTIPO_COMPONENTE',  'tipocomponente'); // Tabla tipocomponente para  modulo Administración banner.
define('_TBLSUBSITIO_GRAFICO', 'subsitio_grafico');  // Tabla subsitio_grafico para modulo Administración banner.
define('_TBLTRASPLANTES'                    ,'trasplantes');            // Tabla que maneja la informaci�n de los donantes de �rganos y tejidos
define('_TBLMODALIDADES'                        ,'contratacion_modalidad'); // Tabla de modaldidades para contratacion
define('_TBLDEPTOS'                                     ,'departamentos');                      // Tabla de categorias
define('_TBLLABORATORIO'                        ,'laboratorio');                        // Tabla de usuarios
define('_TBLLABPROG'                            ,'laboratorioprograma');        // Tabla de ciudades
define('_TBLMUNICIPIOS'                         ,'municipios');                         // Tabla registro busquedas
define('_TBLPAISES'                                     ,'paises');                                     // Tabla de listas
define('_TBLPROGRAMAS'                          ,'programas');                          // Tabla de listas
define('_TBLVREGISTRO'                          ,'v_registro');                         // Tabla de acreedores
define('_TBLFARMACO'                            ,'farmaco');                            // Tabla de farmacovigilancia
define('_TBLMEDICAMENTO'                        ,'medicamento');                        // Tabla de medicamentos
define('_TBLTARIFARIO'                          ,'tarifario');                  // Tabla tarifario

/**
 *  DEFINICI�N DE OPCIONES PREDEFINIDAS
 **/
define('_DEF_ORDEN_SUB'         ,'orden');      // Default campo por el cual se ordenan las subcategor�as
define('_DEF_PAGINAS_SUB'       ,'20');         // Default numero de p�ginas m�ximo para subcategorias
define('_DEF_ASC_SUB'           ,'2');          //  Default tipo de orden para las subcategor�as 1=Descendente 2=Ascendente
define('_DEF_ORDENACION_SUB','2');              // Tipo de ordenacion POR DEFAULT para las subcategorias 2 = Lista con resumen
define('_DEF_IDDISPLAY'         ,'0');          // Tipo de ordenacion POR DEFAULT para las subcategorias 2 = Lista con resumen
define('_DEF_TEMPLATE'          ,'Default');// El Template POR DEFAULT es Default
define('_DEF_IDDISPLAY_SUB'     ,'10');         // El iddisplay_sub POR DEFAULT es /** Ocultar Categorias **/
define('_DEF_IDIOMA'            ,'spanish');// El idioma POR DEFAULT es 'spanish'

/**
 *  VALIDACI�N
 **/
define('_ZONAADMIN'                     ,'9');                  // Nivel de seguridad del administrador
define('_TIPOVALIDACION'        ,'1');                  // 0=Default, jerarquica  1=Excluyente


/**
 * VARIABLES DE MANEJO DE IMAGENES Y FOTOS EN EL PORTAL
 **/
define ('_DIRCACHEIMG'          , '../cache/');// Cache Im�genes
define('_IMGALINEACION'         ,'left');       // Alineaci�n de las im�genes dentro de los contenidos. Aplicable solo a im�genes con tama�o inferior a _IMGANCHOMEDIO
define('_IMGANCHOMEDIO'         ,'280');        // Ancho medio con que se presentar�n las im�genes dentro de los contenidos
define('_IMGANCHOMAXIMO'        ,'470');        // Ancho m�ximo con que se presentar�n las im�genes dentro de los contenidos

/**
 * Imagen Thumbnail Automatico
 **/
define ('_DISTMAX'                      , '150');
define ('_DISTMED'                      , '110');
define ('_CALIDADIMG'           , '80');

/**
 * Idioma de Administrador de Imagenes
 **/
define ('_IMAGE_ADMIN_LANGUAGE', 'spanish'); // EN EL CASO DE SER EN INGLES SE LE PONE 'english', por default es 'spanish'

/**
 * SHOPPING CART
 **/
define ('_IMPUESTO'                     ,'16');         //Valor del impuesto empleado para los c�lculos del Shopping Cart

/**
 * MODULO PQR
 */
define('_GRUPO_ADMINISTRACION_PQR'                              , 'administradoresPQR');
define('_GRUPO_GESTORES_PQR'                                    , 'gestoresPQR');
define('_GRUPO_DIGITADORES_PQR'                                 , 'administradoresPQR');

define( "TTF_DIR"                                                               , _RUTABASE."_templates/Default/recursos/fonts/");              //Define el directorio de fuentes

define('_DIRJS'                                                                 , 'js/');               // Directorio de los archivos de funciones javascript

define('_TBL_PQR_ASUNTO'                                                ,'pqr_asunto');                                 // Tabla de asuntos o tema de la solicitud
define('_TBL_PQR_DEPENDENCIA'                                   ,'pqr_dependencia');                    // Tabla de dependencias - organigrama
define('_TBL_PQR_DOCUMENTO'                                             ,'pqr_documento');                              // Tabla de documentos vinculados a la solicitud
define('_TBL_PQR_ESTADO'                                                ,'pqr_estado');                                 // Tabla de estados de la solicitud
define('_TBL_PQR_MEDIO'                                                 ,'pqr_medio');                                  // Tabla de medios de recepci�n posibles
define('_TBL_PQR_ORIGINADOR'                                    ,'pqr_originador');                             // Tabla de originadores de la solicitud
define('_TBL_PQR_REGION'                                                ,'pqr_region');                                 // Tabla de regiones
define('_TBL_PQR_RELACION'                                              ,'pqr_relacion');                               // Tabla de relaciones entre las solicitudes
define('_TBL_PQR_SOLICITANTE'                                   ,'pqr_solicitante');                    // Tabla de solicitantes
define('_TBL_PQR_SOLICITUD'                                             ,'pqr_solicitud');                              // Tabla de solicitudes
define('_TBL_PQR_TIPO'                                                  ,'pqr_tipo');                                   // Tabla de tipos de solicitud posibles
define('_TBL_PQR_TIPODOCUMENTO'                                 ,'pqr_tipo_documento');                 // Tabla de tipos de documento
define('_TBL_PQR_TIPOIDENTIFICACION'                    ,'pqr_tipo_identificacion');    // Tabla de tipos de identificaci�n
define('_TBL_PQR_TIPORELACION'                                  ,'pqr_tipo_relacion');                  // Tabla de tipos de relacion posibles entre las solicitudes
define('_TBL_PQR_TRANSACCION'                                   ,'pqr_transaccion');                    // Tabla de transacciones de una solicitud
define('_TBL_PQR_REL_DEPENDENCIA_USUARIO'               ,'pqr_rel_dependencia_usuario');
define('_TBL_PQR_ENCUESTA'                                              ,'pqr_respuestas_encuesta');                    // Tabla con las respuestas de las encuestas

/**
 *  DEFINICI▒N DE TABLAS GEL
 **/
define('_TBLPORUSUARIOBACKUP'                   ,'por_usuario_backup');         // Tabla de usuarios backup
define('_TBLPORUSUARIOGEL'                      ,'por_usuarios_gelxml');                // Tabla de usuarios GEL
define('_TBLPORDEPARTAMENTOS'                   ,'por_departamentos');          // Tabla de departamentos GEL
define('_TBLPORMUNICIPIOS'                      ,'por_municipios');                     // Tabla de municipios GEL
define('_TBLPORCONDICIONES'                     ,'por_condiciones_gelxml');             // Tabla de condiciones GEL

/**
 * RSS
 **/
define('_CANTIDAD_RSS', '15');                  // Cantidad de noticias desplegadas en el rss
define('_XML_RSS', '<a href="rss/"><img src="xml.gif" border="0" alt="RSS"></a>');

/**
 * Editor de HTML en el template de edicion
 **/
define('_MOSTRAR_EDITOR'        , TRUE);

/**
 * Version
 **/
define('_VERSION','Micrositios Content Manager &copy; V3.0');
?>
