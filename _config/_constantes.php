<?php
/**
 * ARCHIVO DONDE SE ENCUENTRA LA CONFIGURACIï¿½N Bï¿½SICA DEL PORTAL
 *
 *
 * Micrositios Ltda. ï¿½ Copyright 2005
 **/

function cargar_datos_personales_desarrollador()
{
	// Para poder soportar q este archivo se convierta en un problema entre los usuarios del control de versiones
	// quienes lo modificara y cambiaran los valores para los demas se implementa un sistema de archivos por usuario
	// muy util para poder que cada usuario tenga sus propios settings
  
	try
	{
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
	//					echo "FILE EXISTS $path<br>";
						require($path);
						break; // foreach
					}
				}
			}
		}
	}catch (Exception $e)
	{
	
	}

}

// PRIORIDA A LAS VARIABLES DE DESARROLLO SI ENCONTRADAS
cargar_datos_personales_desarrollador();

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
 * VARIABLES DE LA BASE DE DATOS
 **/
define("_DBCONNECT" ,"mysql"); // Tipo de base de datos
define("_DBUSER"	,"ejercitomil_portal"); // Usuario de la base de datos
define("_DBHOST" ,"10.100.10.4"); // Host donde se encuentra la base de datos
define("_DBNAME" ,"ejercitomil_portal"); // Nombre de la base de datos
define("_DBPASSWORD" ,"VMM37Kr3GJPDYsL7gb2XRs8aWRXRDg"); // Password de la Base de Datos

/**
 * VARIABLES DE LA BASE DE DATOS KNOWLEDGETREE
 **/
define("_DBCONNECTK"             ,"mysql");                         // Tipo de base de datos
define("_DBUSERK"                ,"ktuser");                          // Usuario de la base de datos
define("_DBHOSTK"                ,"172.16.0.204");                     // Host donde se encuentra la base de datos
define("_DBNAMEK"                ,"kt");     // Nombre de la base de datos
define("_DBPASSWORDK"             ,"knowledgetree2015*");                     // Password de la Base de Datos


/**
 * Define el tipo de autenticacion "ldap" o "portal"
 */

define("_AUTH_TYPE"		,"portal");

/**
 * VARIABLES DE LA CONEXION AL LDAP
 */

$ldap_params[0]["servidor"]  	= "192.168.0.105";                         // el servidor AD al que se quiere conectar
$ldap_params[0]["puerto"]	= 30389;                                   // el puerto a traves del cual se conectara
$ldap_params[0]["user"]	        = "uid=etaadmin,ou=colombia,dc=com,dc=br"; // Username del administrador del AD creado para el portal
$ldap_params[0]["pass"]   	= "etaadmin";                              // Password del administrador del AD creado para el portal
$ldap_params[0]["dn"]		= "ou=colombia,dc=com,dc=br";              // Clasificador del dominio


/**
 * VARIABLES DEL PORTAL
 **/
define('_SISTEMA', "U"); // U = Unix, Linux O = Otro

cargar_datos_personales_desarrollador();

if(_SISTEMA == "U")
{
   define('_RUTABASE'		,'/App/html/');		// Carpetas con archivos raiz en Linux
   define('_SLASH'		,'/');
   define('_DOCUMENT_ROOT'	, _RUTABASE); 				//Raiz fï¿½sica del servidor
   define('_WEBPADRE'		, 'www.icanh.gov.co'); 	//Raiz fï¿½sica del servidor. URL del portal principal. Ejemplo: www.nombredeldominio/

} else {
   define('_RUTABASE'		,'C:/inetpub/wwwroot/Portal/crcportal/');		// Carpetas con archivos raiz en Windows
   define('_SLASH'		,'/');
   define('_DOCUMENT_ROOT'	, _RUTABASE);				//Raiz fï¿½sica del servidor
   define('_WEBPADRE'		, 'www.crcom.gov.co/crcportal/'); 		//Raiz fï¿½sica del servidor
}
/**
 * configuracion para URLS amigables 
 */
define('COLUMNA_NOMBRE_BASE' 	, 'nombre_base'); // Es la columna que contiene los nombres base
define('COLUMNA_NOMBRE_UNICO' 	, 'nombre_unico'); // Es la columna que contiene los nombres unicos sobre el base
define('COLUMNA_NOMBRE_NIVEL' 	, 'nombre_nivel'); // Es la columna que contiene los nombres unicos sobre el base
define('COLUMNA_NOMBRE_URL' 	, 'nombre_url'); // Es la columna que contiene los urls amigables


/**
 * INFORMACIï¿½N Y VARIABLES DEL SITIO
 **/
define('_EMAIL_ADMINISTRADOR'		,'jchavez@micrositios.net');		// Email del administrador de la pagina
define('_EMAIL_ADMINISTRADOR_FAQ' 	,'jchavez@micrositios.net');                // Email de las FAQ
define('_PASS'			,'alp');                                    // Password seccion de usuarios registrados
define('_DIAS_CADUCIDAD'		,'15');                                     // Dias de vigencia de un articulo en el home page por default

/**
 * DIRECTORIOS DONDE SE UBICAN LOS ARCHIVOS DEL PORTAL (dejar sin slash al principio pero con slash al final)
 **/
define('_DIRLIB'		 	, _RUTABASE."_lib/"); 		// Directorio de las librerias
define('_DIRCORE'		 	, _DIRLIB."core/");                         // Directorio de las librerias core del portal
define('_DIRBUSCAR'		 	, _DIRLIB."buscar/");                       // Directorio de las librerias core del portal
define('_DIRJPGRAPH'                        , _DIRLIB."jpgraph/");                      // Directorio de las librerias core del portal
define('_DIRINTERFAZ'                       , _RUTABASE."_interfaz/");                  // Directorio de las librerias de Interfaz del sitio
define('_DIRTEMPLATES'                      , _RUTABASE.'_templates/');                 // Directorio de los templates
define('_DIRTEMPLATES_BOLETIN'              , _RUTABASE.'_templates_boletin/');         // Directorio de los templates
define('_DIRRELATIVE_BOLETIN'               , '_templates_boletin/');                   // Directorio de los templates
define('_DIREDITOR_USER'                    , 'editores/');                             // Carpetas con documentos para usar en las pï¿½ginas

/**
 * DIRECTORIOS DE ADMINISTRACION
 */
define('_DIRADMIN_ABS'    		,_RUTABASE."_administracion/");             // Path absoluto del template escogido (para smarty)
define('_DIRADMIN_REL' 		,"_administracion/");                       // Carpetas con archivos de recursos Path relativo
define('_DIRRECURSOS_ADMIN'                 ,_DIRADMIN_REL."recursos/");                // Carpetas con archivos de recursos
define('_DIRLIB_ADMIN'    		,_DIRADMIN_ABS."lib/");                     // Carpetas con archivos libreria
define('_DIRCSS_ADMIN'    		,_DIRRECURSOS_ADMIN."css/");                // Carpetas con archivos de css
define('_DIRIMAGES_ADMIN'                   ,_DIRRECURSOS_ADMIN."images/");             // Carpetas con archivos de imagenes
define('_NUMREG_LST_ADMIN'		, 10);                                      // Numero de registros listado por pagina en la administracion

/**
 *  CARPETAS DE TEMPLATES (dejar sin slash al principio pero con slash al final)
 **/
define('_DIR_ROTULOS_IDIOMAS'               , _DIRINTERFAZ."idiomas/");                 // Carpetas con los rotulos en distintos idiomas
define('_DIRRECURSOS_USER'		, 'recursos_user/');                        // Carpetas con imagenes para usar en las pï¿½ginas
define('_DIRIMAGES_USER'                    , _DIRRECURSOS_USER.'imagenes/');           // Carpetas con imagenes para usar en las pï¿½ginas
define('_URLKNOWLEDGE'                      ,'http://kt.micrositios.net/action.php?kt_path_info=ktcore.actions.document.view&fDocumentId=');
define('_URLKNOW'                           ,'http://kt.micrositios.net/');
define('_DIRDOCS_USER'                      , _DIRRECURSOS_USER.'documentos/');         // Carpetas con documentos para usar en las pï¿½ginas
define('_DIR_TMPFILES'	, '/tmp/');
define('_DIRRECURSOS_USER_PQR'	, _RUTABASE._DIRRECURSOS_USER.'pqr/');
define('_DIR_INCLUDE'                       ,_RUTABASE. '_include/');                   // Carpetas include
/**
 * RECURSOS DEL EDITOR DEL PORTAL
 */
define('_DIR_IMAGES_EDITOR', '_editor/images/');

/**
 *  DEFINICION DE TABLAS
 **/
define('_TBLCATEGORIA'		,'categoria');			// Tabla de categorias
define('_TBLUSUARIO'			,'usuario');			// Tabla de usuarios
define('_TBLCIUDADES'			,'ciudades');			// Tabla de ciudades
define('_TBLREGISTRO'			,'registro');			// Tabla registro busquedas
define('_TBLLISTAS'			,'listas');			// Tabla de listas
define('_TBLDETALLELISTA'		,'detallelista');			// Tabla de listas
define('_TBLEDITORES'			,'editores');			// Tabla de acreedores
define('_TBLACCESO'			,'acceso');			// Tabla de acceso por grupos
define('_TBLMAIL'			,'mail');				// Tabla de mail
define('_TBLSMS'			,'sms_transaccion_detalle');		// Tabla de logs de sms
define('_TBLFTOTAL'			,'ftotal');			// Tabla de frecuencia total
define('_TBLFORIGINAL'		,'frecuencia_original');		// Tabla de frecuencia de palabras de articulos
define('_TBLKEYMATCH'			,'keymatch');			// Tabla de keymatch
define('_TBLSTOPWORDS'		,'stopwords');			// Tabla de usuarios registrados en comunidades
define('_TBLREGCOMUNIDAD'		,'registro_comunidad');		// Tabla de usuarios registrados en comunidades
define('_TBLCONTRATACION_ESTADOS'	,'contratacion_estado');		// Tabla de estados posibles para los contratos
define('_TBLCONTRATACION_ETAPAS'            ,'contratacion_etapas');		// Tabla de etapas posibles para los contratos
define('_TBLCONTRATACION_ORDGASTO'	,'contratacion_ordenador_gasto');	// Tabla de ordenadores del gasto posibles para los contratos
define('_TBLTRASPLANTES'  		,'trasplantes');                            // Tabla que maneja la informaciï¿½n de los donantes de ï¿½rganos y tejidos
define('_TBLMODALIDADES'		,'contratacion_modalidad');                 // Tabla de modaldidades para contratacion
define('_TBLDEPTOS'			,'departamentos');			// Tabla de categorias
define('_TBLLABORATORIO'		,'laboratorio');			// Tabla de usuarios
define('_TBLLABPROG'			,'laboratorioprograma');                    // Tabla de ciudades
define('_TBLMUNICIPIOS'		,'municipios');			// Tabla registro busquedas
define('_TBLPAISES'			,'paises');			// Tabla de listas
define('_TBLPROGRAMAS'		,'programas');			// Tabla de listas
define('_TBLVREGISTRO'		,'v_registro');			// Tabla de acreedores
define('_TBLFARMACO'			,'farmaco');			// Tabla de farmacovigilancia
define('_TBLMEDICAMENTO'		,'medicamento');			// Tabla de medicamentos
define('_TBLTARIFARIO'		,'tarifario');			// Tabla tarifario


define('_TBL_PIEZAS_TENEDOR'			,'piezas_tenedor');			// Tabla del  tenedor para las piezas arqueologicas
define('_TBL_PIEZAS_TIPO_TENEDOR'		,'piezas_tipo_tenedor');		// Tabla del tipo tenedor para las piezas arqueologicas
define('_TBL_PIEZAS_INFORMACION'			,'piezas_informacion');		// Tabla del  para las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_NOMBRE_DESCRIPTIVO'		,'piezas_nombre_descriptivo');		// Tabla del  para las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_TIPO_MATERIAL'		,'piezas_tipo_material');		// Tabla del tipo de material  para las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_SISTEMA'			,'piezas_sistema');			// Tabla del  sistema de coordenadas para las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_ORIGEN'			,'piezas_origen');			// Tabla del  origen del sistema para las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_UNIDAD_RECUPERACION' 		,'piezas_unidad_recuperacion');		// Tabla de unidad de recuperacion para las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_CONTEXTO_ARQUEOLOGICO' 		,'piezas_contexto_arqueologico');	// Tabla del  origen del sistema para las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_TIPO_OBTENCION' 		,'piezas_tipo_obtencion');		// Tabla del tipo de obtencion para las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_ESTILO_CULTURA' 		,'piezas_estilo_cultura');		// Tabla del estilo arqueologico o cultura para las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_FORMA' 			,'piezas_forma');			// Tabla para la forma de las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_TECNICA_MANUFACTURA' 		,'piezas_tecnica_manufactura');		// Tabla para la tecnica manufatura de las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_COLOR_PREDOMINANTE' 		,'piezas_color_predominante');		// Tabla para el color predominante de las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_DECORACION_PREDOMINANTE' 	,'piezas_decoracion_predominante');	// Tabla para la decoracion predominante de las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_DECORACION_SECUNDARIA' 		,'piezas_decoracion_secundaria');	// Tabla para la decoracion secundaria de las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_ESTADO_CONSERVACION' 		,'piezas_estado_conservacion');		// Tabla para el estado de conservacion de las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_ACABADO_SUPERFICIE' 		,'piezas_acabado_superficie');		// Tabla para el acabado superficie de las informacion de las  piezas arqueologicas
define('_TBL_PIEZAS_PAIS' 			,'piezas_pais');			// Tabla para los paises
define('_TBL_PIEZAS_DEPARTAMENTO' 		,'piezas_departamento');		// Tabla para los departamentos
define('_TBL_PIEZAS_MUNICIPIO' 			,'piezas_municipio');			// Tabla para los municipios y ciudades
define('_TBL_PIEZAS_ESTADO_TRAMITE' 		,'piezas_estado_tramite');		// Tabla para el estado del tramite
define('_TBL_PIEZAS_COLECCION_FISICAS' 		,'piezas_coleccion_fisicas');		// Tabla para las colecciones fisicas
define('_TBL_PIEZAS_COLECCION' 			,'piezas_coleccion');			// Tabla para las colecciones

/**
 *  DEFINICIÓN DE TABLAS GEL
 **/
define('_TBLPORUSUARIOBACKUP'			,'por_usuario_backup');		// Tabla de usuarios backup
define('_TBLPORUSUARIOGEL'			,'por_usuarios_gelxml');		// Tabla de usuarios GEL
define('_TBLPORDEPARTAMENTOS'			,'por_departamentos');		// Tabla de departamentos GEL
define('_TBLPORMUNICIPIOS'			,'por_municipios');			// Tabla de municipios GEL
define('_TBLPORCONDICIONES'			,'por_condiciones_gelxml');		// Tabla de condiciones GEL


/**
 *  DEFINICIï¿½N DE OPCIONES PREDEFINIDAS
 **/
define('_DEF_ORDEN_SUB'		,'orden');                                  // Default campo por el cual se ordenan las subcategorï¿½as
define('_DEF_PAGINAS_SUB'                   ,'20');                                     // Default numero de pï¿½ginas mï¿½ximo para subcategorias
define('_DEF_ASC_SUB'                       ,'2');                                      //  Default tipo de orden para las subcategorï¿½as 1=Descendente 2=Ascendente
define('_DEF_ORDENACION_SUB'                ,'2');                                      // Tipo de ordenacion POR DEFAULT para las subcategorias 2 = Lista con resumen
define('_DEF_IDDISPLAY'		,'0');                                      // Tipo de ordenacion POR DEFAULT para las subcategorias 2 = Lista con resumen
define('_DEF_TEMPLATE'		,'Default');                                // El Template POR DEFAULT es Default
define('_DEF_IDDISPLAY_SUB'                 ,'10');                                     // El iddisplay_sub POR DEFAULT es /** Ocultar Categorias **/
define('_DEF_IDIOMA'                        ,'spanish');                                // El idioma POR DEFAULT es 'spanish'

/**
 *  VALIDACIï¿½N
 **/
define('_ZONAADMIN'			,'9');                                      // Nivel de seguridad del administrador
define('_TIPOVALIDACION'                    ,'1');                                      // 0=Default, jerarquica  1=Excluyente


/**
 * VARIABLES DE MANEJO DE IMAGENES Y FOTOS EN EL PORTAL
 **/
define ('_DIRCACHEIMG'		, '../cache/');                             // Cache Imï¿½genes
define ('_DIRCACHEIMG1'		, 'cache/'); 
define('_IMGALINEACION'		,'left');                                   // Alineaciï¿½n de las imï¿½genes dentro de los contenidos. Aplicable solo a imï¿½genes con tamaï¿½o inferior a _IMGANCHOMEDIO
define('_IMGANCHOMEDIO'		,'400');                                    // Ancho medio con que se presentarï¿½n las imï¿½genes dentro de los contenidos
define('_IMGANCHOMAXIMO'                    ,'514');                                    // Ancho mï¿½ximo con que se presentarï¿½n las imï¿½genes dentro de los contenidos

/**
 * Imagen Thumbnail Automatico
 **/
define ('_DISTMAX'			, '150');
define ('_DISTMED'			, '110');
define ('_CALIDADIMG'                       , '60');

/**
 * Idioma de Administrador de Imagenes
 **/
define ('_IMAGE_ADMIN_LANGUAGE'             , 'spanish'); // EN EL CASO DE SER EN INGLES SE LE PONE 'english', por default es 'spanish'

/**
 * SHOPPING CART
 **/
define ('_IMPUESTO'			,'16');		//Valor del impuesto empleado para los cï¿½lculos del Shopping Cart

/**
 * MODULO PQR
 */
define('_GRUPO_ADMINISTRACION_PQR'				,'104 Administradores de PQR');
define('_GRUPO_DIGITADORES_PQR'					,'106 Digitadores de PQR');
define('_GRUPO_GESTORES_PQR'					,'105 Gestores de PQR');
define('_JEFE_GESTORES_PQR'                        ,'125 Administradores Jefes PQR');

define( "TTF_DIR"			, _RUTABASE."_templates/Default/recursos/fonts/"); //Define el directorio de fuentes
define('_DIRJS'			, 'js/');                                   // Directorio de los archivos de funciones javascript

define('_TBL_PQR_ASUNTO'		,'pqr_asunto');			// Tabla de asuntos o tema de la solicitud
define('_TBL_PQR_DEPENDENCIA'		,'pqr_dependencia');			// Tabla de dependencias - organigrama
define('_TBL_PQR_DOCUMENTO'		,'pqr_documento');			// Tabla de documentos vinculados a la solicitud
define('_TBL_PQR_ESTADO'		,'pqr_estado');			// Tabla de estados de la solicitud
define('_TBL_PQR_MEDIO'		,'pqr_medio');			// Tabla de medios de recepciï¿½n posibles
define('_TBL_PQR_ORIGINADOR'		,'pqr_originador');			// Tabla de originadores de la solicitud
define('_TBL_PQR_REGION'		,'pqr_region');			// Tabla de regiones
define('_TBL_PQR_RELACION'		,'pqr_relacion');			// Tabla de relaciones entre las solicitudes
define('_TBL_PQR_SOLICITANTE'		,'pqr_solicitante');			// Tabla de solicitantes
define('_TBL_PQR_SOLICITUD'		,'pqr_solicitud');			// Tabla de solicitudes
define('_TBL_PQR_TIPO'		,'pqr_tipo');			// Tabla de tipos de solicitud posibles
define('_TBL_PQR_TIPODOCUMENTO'		,'pqr_tipo_documento');		// Tabla de tipos de documento
define('_TBL_PQR_TIPOIDENTIFICACION'	,'pqr_tipo_identificacion');                // Tabla de tipos de identificaciï¿½n
define('_TBL_PQR_TIPORELACION'		,'pqr_tipo_relacion');		// Tabla de tipos de relacion posibles entre las solicitudes
define('_TBL_PQR_TRANSACCION'		,'pqr_transaccion');			// Tabla de transacciones de una solicitud
define('_TBL_PQR_REL_DEPENDENCIA_USUARIO'	,'pqr_rel_dependencia_usuario');		// Tabla que relaciona las dependencias con los usuarios
define('_TBL_PQR_ENCUESTA'		,'pqr_respuestas_encuesta');		// Tabla con las respuestas de las encuestas
define('_TBL_PQR_PRIORIDAD'		,'pqr_prioridad');		// Tabla con las respuestas de las encuestas
define('_USUARIOPQR','5');

define('_PQR_SOLICITUD'		,'35');         // Tabla con las respuestas de las encuestas

/**
 * RSS
 **/
define('_CANTIDAD_RSS'                      , '15');                                    // Cantidad de noticias desplegadas en el rss
define('_XML_RSS'                           , '<a href="rss/"><img src="xml.gif" border="0" alt="RSS"></a>');

/**
 * Editor de HTML en el template de edicion
 **/
define('_MOSTRAR_EDITOR'                    , TRUE);

/**
 * Version
 **/
define('_VERSION','Micrositios Content Manager &copy; V3.0');
/**
 * Variables para la conexiï¿½n al servidor de correo electrï¿½nico
 */

/*define("_SMTP_HOST"        ,"email-smtp.us-east-1.amazonaws.com");            //Default localhost
define("_SMTP_USER"        ,"AKIAIKMFNBRNCODJ2NKA");        	  //Default ''
define("_SMTP_PASS"        ,"Ah+ZXRIlHAWcW9LT++amAbHFTxpzab3sa0xYfpD4ey88");            //Default ''
define("_SMTP_PORT"        ,587);                         //Default 25*/


define("_SMTP_AUTH"        ,true);                      //Default false

define("_SMTP_HOST"        ,"smtp.gmail.com");            //Default localhost
define("_SMTP_USER"        ,"contactenos@icanh.gov.co");        	  //Default ''
define("_SMTP_PASS"        ,"Toca1994");            //Default ''
define("_SMTP_PORT"        ,587);                         //Default 25
//define("_SMTP_WORDWRAP"    ,50);                            
define("_SMTP_ISHTML"      ,true);
define("_SMTP_TIMEOUT"     ,30);
define("_SMTP_SECURE"      ,"tls");			   //Default '' posible ssl y tls
define("_SMTP_DEBUG"       ,false);

/*define("_SMTP_AUTH"        ,true);                      //Default false
define("_SMTP_HOST"        ,"smtp.emailsrvr.com");          //Default localhost
define("_SMTP_USER"        ,"controlinterno@ifc.gov.co");        		 //Default ''
define("_SMTP_PASS"        ,"Instituto2014");            //Default ''
define("_SMTP_PORT"        ,25);                         //Default 25
define("_SMTP_WORDWRAP"    ,50);                            
define("_SMTP_ISHTML"      ,true);
define("_SMTP_TIMEOUT"     ,30);
define("_SMTP_SECURE"      ,"");						 //Default '' posible ssl y tls
define("_SMTP_DEBUG"       ,"2");						 //Default ''*/
//Default ''


/*define("_SMTP_AUTH"        ,true);
define("_SMTP_HOST"        ,"smtp.gmail.com");
define("_SMTP_USER"        ,"alogistica.ffmm@gmail.com");
define("_SMTP_PASS"        ,"40204020");
define("_SMTP_PORT"        ,465);
define("_SMTP_WORDWRAP"    ,50);
define("_SMTP_ISHTML"    ,true);
define("_SMTP_SECURE"     ,"ssl");
define("_SMTP_TIMEOUT"    ,30);*/


/*define("_SMTP_AUTH"        ,false);                      //Default false
define("_SMTP_HOST"        ,"localhost");          //Default localhost
define("_SMTP_USER"        ,"");        		 //Default ''
define("_SMTP_PASS"        ,"");            //Default ''
define("_SMTP_PORT"        ,25);                         //Default 25
define("_SMTP_WORDWRAP"    ,50);                            
define("_SMTP_ISHTML"      ,true);
define("_SMTP_TIMEOUT"     ,30);
define("_SMTP_SECURE"      ,"");						 //Default '' posible ssl y tls
define("_SMTP_DEBUG"       ,"");						 //Default ''
						 //Default ''*/

/**
 * Tablas del Modulo de Preguntas Cruzadas 
 */

define('_TBL_PGC_ACCESO'	,'pgc_acceso');	// Tabla autorizacion conrechazo
define('_TBL_PGC_AUDITORIA'	,'pgc_auditoria');
define('_TBL_CER_GENERACION'	,'cer_generacion');

/**
 * Directorio de Certificados
 */
define('_DIRCERTIFICADOS'	, _DIRRECURSOS_USER.'certificados/');     // Carpetas con imagenes para usar en las páginas

?>
