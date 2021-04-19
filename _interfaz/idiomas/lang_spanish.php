<?php
/**************************************************************************************
*             CATALOGO DE PRODUCTOS - PROYECTO CATALOGO DONETBUSINESS V1.0            *
***************************************************************************************
* Archivo: config.php                                                           *
* Descripcion: Configuración de todas la variables del sistema.                       *
***************************************************************************************
*                                                                                     *
*    AUTOR    : LEONARDO FORERO                        a8888b.                        *
*    EMAIL    : leofor@hotmail.com                    d888888b.                       *
*    WEBSITE  : www.micrositios.net                   8P"YP"Y88                       *
*    COPY     : Julio 10 - 2002                       8|o||o|88                       *
*                                                     8'    .88                       *
*      MICROSITIOS LTDA.                              8`._.' Y8.                      *
*      CLL 98 N 14-17 OF.305                         d/      `8b.                     *
*      BOGOTA, COLOMBIA                            .dP   .     Y8b.                   *
*      Tels.(571)6183770 (571)6183396             d8:'   "   `::88b.                  *
*                                                d8"           `Y88b                  *
*                                               :8P     '       :888                  *
*                                                8a.    :      _a88P                  *
*                                              ._/"Yaa_ :    .| 88P|                  *
*                                              \    YP"      `| 8P  `.                *
*                                              /     \._____.d|    .'                 *
*                                              `--..__)888888P`._.'                   *
*                                                                                     *
******************************************************************leofor@hotmail.com***/
// Modifique UNICAMENTE la informacion entre parentesis DESPUES de la coma
// NO modifique la palabra en mayúsculas

// Archivo restriccion.php
define("_R_IDIOMA", 'spanish');
define("_ROT_PAGINA_INEXISTENTE" ,"Posiblemente la p&aacute;gina que desea ver est&aacute; deshabilitada<br>Por favor comun&iacute;quese con el administrador del sitio");
define("_ROT_MENSAJE_RESTRICCION","P&aacute;gina restringida nivel ");
define("_ROT_PAGINA_RESTRINGIDA" ,sprintf(str_replace("  "," ","<ul>
        <li>Para usar los servicios de nuestro portal debe crear su cuenta <a href=index.php?idcategoria=%s><span class=tpl_titulo_mensaje_error><strong>aqui</strong></span></a>
        <li>El <strong>usuario</strong> y el <strong>password</strong> ser&aacute;n enviados autom&aacute;ticamente a su email.
        </ul>"),_SREGISTRO));

// Idioma principal del documento
define("_ROT_LANG", "es");
define("_ROT_PERSONALIZACION","Personalizaci&oacute;n");
// Archivo funciones.php
define("_ROT_SUBMENU"    ,"");
define("_ROT_SUBMENU_LINEA","");
define("_ROT_SUBMENU_MARCA","");
define("_ROT_SUBMENU_PUBLICACIONES","<B>PORTADA</B>");
define("_ROT_VER_MAS","Leer Noticia");
define("_ROT_BOLETIN_TXT_1","Escriba su email para recibir nuestro bolet&iacute;n electr&oacute;nico.");

define("_ROT_ENCUESTA1"   ,"Escoja una opci&oacute;n y vote!");
define("_ROT_ENCUESTA2"   ,"Resultados de la votaci&oacute;n");
define("_ROT_ENCUESTA3"   ,"Cantidad total de votos");
define("_ROT_REDIRECCION","Usted ha sido redirigido autom&aacute;ticamente a otra secci&oacute;n de la p&aacute;gina web");
define("_ROT_DOWNLOAD"   ,"Haga click en el v&iacute;nculo para abrir el archivo.<br>Para guardarlo en su disco duro haga click<br>con el bot&oacute;n derecho y escoja<br> \"Guardar detino como...\"<br>");
define("_ROT_CADUCIDAD"  ,"Aunque esta informaci&oacute;n no se considera vigente, contin&uacute;a en el archivo hist&oacute;rico del sitio web");

define("_ROT_ADMIN_DOCUMENTOS"     ,"Administrador de documentos");
// Archivo contacto.php
define("_ROT_ADVERTENCIA"          ,"ADVERTENCIA");
define("_ROT_ERROR"                ,"ERROR");
define("_ROT_CONFIRMACION"         ,"CONFIRMACION");
define("_ROT_CONTACTO_NOMBRE"      ,"Nombre completo:");
define("_ROT_CONTACTO_NOMBRE_ERROR","Falta el nombre");
define("_ROT_CONTACTO_EMAIL"      ,"Email:");
define("_ROT_CONTACTO_EMAIL_ERROR1","Falta el email");
define("_ROT_CONTACTO_EMAIL_ERROR2","La sintaxis del email es incorrecta");
define("_ROT_CONTACTO_EMPRESA"      ,"Actividad/Oficio/Profesi&oacute;n:");
define("_ROT_CONTACTO_EMPRESA_ERROR","Falta la actividad");
define("_ROT_CONTACTO_CARGO"      ,"Cargo:");
define("_ROT_CONTACTO_CARGO_ERROR","Falta el cargo");
define("_ROT_CONTACTO_DIRECCION"      ,"Ciudad / Pa&iacute;s:");
define("_ROT_CONTACTO_DIRECCION_ERROR","Falta la Direcci&oacute;n");
define("_ROT_CONTACTO_TELEFONOS"      ,"Tel&eacute;fono:");
define("_ROT_CONTACTO_TELEFONOS_ERROR","Falta el tel&eacute;fono");
define("_ROT_CONTACTO_COMENTA"      ,"Comentarios:");
define("_ROT_CONTACTO_COMENTA_ERROR","Faltan los comentarios");
define("_ROT_CONTACTO",              "<ul><li>Nos interesan todos sus comentarios, sugerencias y preguntas.
                                     <li>Los campos <span id=\"fieldRequired\">resaltados</span> son obligatorios.</ul>");
define("_ROT_CONTACTO_ADVERTENCIA","NO SE ENVI&Oacute; EL FORMULARIO!<br>Por favor revise la informaci&oacute;n");
define("_ROT_CONTACTO_REQUERIDO","(Requerido)");

define("_ROT_CONTACTO_ENVIO_CONFIRMA"   ,"El mensaje fu&eacute; enviado a <b>%s</b>, muchas gracias por su inter&eacute;s");
define("_ROT_CONTACTO_ENVIO_ERROR","El mensaje NO pudo ser enviado a <strong>%s</strong>,<br>por favor intente mas tarde o utilice su cliente de correo habitual");

// Archivo certificado.php

define("_ROT_CERTIFICADO_NOMBRE"      ,"Nombres completos:");
define("_ROT_CERTIFICADO_NOMBRE_ERROR","Falta el nombre");
define("_ROT_CERTIFICADO_EMAIL"      ,"Email:");
define("_ROT_CERTIFICADO_EMAIL_ERROR1","Falta el email");
define("_ROT_CERTIFICADO_EMAIL_ERROR2","La sintaxis del email es incorrecta");
define("_ROT_CERTIFICADO_FECHA"      ,"Fecha Solicitud:");
define("_ROT_CERTIFICADO_FECHA_ERROR","Falta la Fecha");
define("_ROT_CERTIFICADO_CEDULA"      ,"C&oacute;digo o C&eacute;dula:");
define("_ROT_CERTIFICADO_CEDULA_ERROR","Falta C&oacute;digo o C&eacute;dula");
define("_ROT_CERTIFICADO_TIPO"      ,"Tipo de Solicitud:");
define("_ROT_CERTIFICADO_TIPO_ERROR","Falta el Tipo de Solicitud");
define("_ROT_CERTIFICADO_DESTINO"      ,"Destino Certificaci&oacute;n:");
define("_ROT_CERTIFICADO_DESTINO_ERROR","Falta el Destino de la Certificaci&oacute;n");
define("_ROT_CERTIFICADO_APELLIDO"      ,"Apellidos Completos:");
define("_ROT_CERTIFICADO_APELLIDO_ERROR","Falta el Apellido");
define("_ROT_CERTIFICADO_TELEFONOS"      ,"Tel&eacute;fono Solicitante:");
define("_ROT_CERTIFICADO_TELEFONOS_ERROR","Falta el tel&eacute;fono");
define("_ROT_CERTIFICADO_DIRECCION"      ,"Direccion Permanente:");
define("_ROT_CERTIFICADO_DIRECCION_ERROR","Faltan la Direcci&oacute;n");
define("_ROT_CERTIFICADOS","<br>Llene el formulario y presione Enviar");
define("_ROT_CERTIFICADO_ADVERTENCIA","Por favor revise la informaci&oacute;n");
define("_ROT_CERTIFICADO_REQUERIDO","(Requerido)");

// Archivo acreedores.php

define("_ROT_ACREEDORES"                     ,"ACREEDORES");
define("_ROT_ACREEDORES_TIPOIDENTIFICACION"  ,"Tipo Identificaci&oacute;n:");
define("_ROT_ACREEDORES_IDENTIFICACION"      ,"Identificaci&oacute;n:");
define("_ROT_ACREEDORES_IDENTIFICACION_ERROR","Falta la Identificaci&oacute;n");
define("_ROT_ACREEDORES_CLAVE"               ,"Clave:");
define("_ROT_ACREEDORES_REQUERIDO"           ,"(Requerido)");


// Archivo registro_evento.php
define("_ROT_REGISTRO_FORMA_PAGO_ERROR"      ,"Debe seleccionar una forma de pago");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO1"   ,"Usted ya esta registrado para este evento");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO2"   ,"Se le envi&oacute; un email a la cuenta <b>%s</b> con las instrucciones detalladas para terminar su proceso de registro");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO3"   ,"Si quiere anular o modificar su registro a este evento comun&iacute;quese telef&oacute;nicamente con nosotros");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA1"   ,"Cuando oprima el bot&oacute;n de Aceptar solo podr&aacute; modificar o anular su registro telef&oacute;nicamente");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA2"   ,"Una vez complete su registro le enviaremos un email de confirmaci&oacute;n y descripciones detalladas del proceso de inscripci&oacute;n");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA3"   ,"Esta transacci&oacute;n queda amparada por el decreto XXXX y tiene validez como DDDD");
define("_ROT_INFO"                           ,"INFORMACION");


// Archivo registro.php

define("_ROT_REGISTRO","<ul><li>El registro le permite obtener mas informaci&oacute;n sobre nuestros eventos
                            <li>El registro es <STRONG>GRATUITO</STRONG>
                            <li>Su username y password seran enviados al email suministrado
                            <li>Los campos <span id=\"fieldRequired\">resaltados (*)</span> son obligatorios.</ul>");
define("_ROT_MICUENTA"                           ,"Esta es su informaci&oacute;n personal, recuerde cambiar el password peri&oacute;dicamente.<br>Los campos <span id=\"fieldRequired\">resaltados</span> son obligatorios.");
define("_ROT_MICUENTA_ACTUALIZACION"             ,"CONFIRMACION!");
define("_ROT_REGISTRO_USERNAME"                  ,"Username:");
define("_ROT_REGISTRO_USERNAME_ERROR"            ,"Falta el username");
define("_ROT_REGISTRO_NOMBRE"                    ,"Nombres:");
define("_ROT_REGISTRO_NOMBRE_ERROR"              ,"Falta el nombre");
define("_ROT_REGISTRO_PASSWORD_ACTUAL"           ,"Password Actual:");
define("_ROT_REGISTRO_PASSWORD1"                 ,"Nuevo Password:");
define("_ROT_REGISTRO_PASSWORD2"                 ,"Confirme el password:");
define("_ROT_REGISTRO_PASSWORD_EXITO"            ,"Contrase&ntilde;a modificada exitosamente !!");
define("_ROT_REGISTRO_PASSWORD_ERROR1"           ,"Falta el Password");
define("_ROT_REGISTRO_PASSWORD_ERROR2"           ,"Falta la confirmaci&oacute;n del password");
define("_ROT_REGISTRO_PASSWORD_ERROR3"           ,"El password y la confirmaci&oacute;n no coinciden");
define("_ROT_REGISTRO_PASSWORD_ERROR4"           ,"No fue posible cambiar la contrase&ntilde;a.");
define("_ROT_REGISTRO_PASSWORD_ERROR5"           ,"No coincide la contraseña Actual, verifique por favor !!!");
define("_ROT_REGISTRO_PASSWORD_ERROR6"           ,"L acontraseña no cumple con las caracteristicas de seguridad, verifique por favor. !!!");
define("_ROT_REGISTRO_PASSWORD_ERROR7"           ,"La contraseña no cumple con las caracteristicas de seguridad, verifique por favor. !!!<br />- M&iacute;nimo 10 Caracteres.<br />- Mayusculas y Minusculas.<br />- N&uacute;meros.<br />- Caracteres Especiales ((#@.&-_))<br />");
define("_ROT_REGISTRO_APELLIDO"                  ,"Apellidos:");
define("_ROT_REGISTRO_APELLIDO_ERROR"            ,"Falta el apellido");
define("_ROT_REGISTRO_EMAIL"                     ,"Email:");
define("_ROT_REGISTRO_EMAIL_ERROR1"              ,"Falta el email");
define("_ROT_REGISTRO_EMAIL_ERROR2"              ,"La sintaxis del email es incorrecta");
define("_ROT_REGISTRO_EMAIL_ERROR3"              ,"La sintaxis del email del contacto de PAGO es incorrecta");
define("_ROT_REGISTRO_EMPRESA"                   ,"Nombre de la Empresa (Raz&oacute;n Social):");
define("_ROT_REGISTRO_EMPRESA_ERROR"             ,"Falta la empresa");
define("_ROT_REGISTRO_CIUDAD"                    ,"Ciudad:");
define("_ROT_REGISTRO_CIUDAD_ERROR"              ,"Falta la ciudad");
define("_ROT_REGISTRO_PAIS"                      ,"Pa&iacute;s:");
define("_ROT_REGISTRO_PAIS_ERROR"                ,"Falta el pa&iacute;s");
define("_ROT_REGISTRO_PROFESION"                 ,"Profesi&oacute;n:");
define("_ROT_REGISTRO_PROFESION_ERROR"           ,"Falta la profesi&oacute;n");
define("_ROT_REGISTRO_TELEFONO"                  ,"Tel&eacute;fono:");
define("_ROT_REGISTRO_TELEFONO_EMPRESA"          ,"Tel&eacute;fonos:<ul class=texto_mini><li>Puede escribir varios si lo desea<li>Escriba la extensi&oacute;n<li>No escriba indicativos</ul>");
define("_ROT_REGISTRO_FAX_EMPRESA"               ,"Fax:");
define("_ROT_REGISTRO_TELEFONO_ERROR"            ,"Falta el tel&eacute;fono");
define("_ROT_REGISTRO_DIRECCION"                 ,"Direcci&oacute;n:");
define("_ROT_REGISTRO_DIRECCION_ERROR"           ,"Falta la direcci&oacute;n");
define("_ROT_REGISTRO_CARGO"                     ,"Cargo:");
define("_ROT_REGISTRO_CEL_ERROR4"              ,"Falta el celular");
define("_ROT_REGISTRO_EXISTENTE4"    ,"Ya hay un usuario registrado con ese Celular. Por favor utilice otro.");
define("_ROT_REGISTRO_SMS"                     	 ,"Autorizo recibir mensajes de texto en mi tel&eacute;fono celular:");
define("_ROT_REGISTRO_CEL_ERROR2"              ,"El numero de celular no es valido");
define("_ROT_REGISTRO_EVENTO"              		,"El valor del evento no es correcto");
define("_ROT_REGISTRO_CEL"					 ,"Celular:");
define("_ROT_REGISTRO_EVENTOS"                   ,"Temas sobre los que le gustar&iacute;a recibir mas informaci&oacute;n:");
define("_ROT_REGISTRO_EMPRESA_NIT"               ,"Nit:");
define("_ROT_REGISTRO_EMPRESA_ACTIVIDAD"         ,"Actividad Econ&oacute;mica:");

define("_ROT_REGISTRO_EMPRESA_MEDIO"             ,"Medio por el que se enter&oacute; de nuestros eventos:");
define("_ROT_REGISTRO_EMPRESA_MEDIO_OTRO"        ,"Si escogio otro, por favor escriba cual fu&eacute;:");

define("_ROT_REGISTRO_REQUERIDO"    ,"(Requerido)");
define("_ROT_REGISTRO_CORREO"       ,"Desea recibir informaci&oacute;n nuestra v&iacute;a email?");
define("_ROT_REGISTRO_RED"          ,"Deseo suscribirme a la Red de Medios para la Paz");
define("_ROT_REGISTRO_ADVERTENCIA"  ,"Por favor revise la informaci&oacute;n");
define("_ROT_REGISTRO_ADVERTENCIA2"  ,"Su informaci&oacute;n no fu&eacute; actualizada");
define("_ROT_REGISTRO_EXISTENTE"    ,"Ya hay un usuario registrado con ese email. Por favor utilice otro.");
define("_ROT_REGISTRO_EXISTENTE2"    ,"Ya hay un usuario registrado con ese username. Por favor utilice otro.");
define("_ROT_REGISTRO_EXITO"        ,"Su informaci&oacute;n fu&eacute; actualizada correctamente");

define("_ROT_REGISTRO_RECORDAR","<strong>¿Ya est&aacute; registrado pero olvid&oacute; su username o el password?</strong><br>Escriba aqu&iacute; el email con el que se registr&oacute;.");

// Archivo buscar.php
define("_ROT_BUSCAR"            ,"Buscar");
define("_ROT_BUSCAR_TXT"            ,"La b&uacute;squeda esta restringida<br>a la informaci&oacute;n contenida en esta p&aacute;gina.");
define("_ROT_BUSCAR_PALABRA"    ,"Palabra a buscar");
define("_ROT_BUSCAR_RESULTADOS" ,"Se encontraron %s resultados relacionados con <span style=\"color:green;\"><em>%s</em></span>");
define("_ROT_BUSCAR_ADVERTENCIA","NO SE PUDO HACER LA BUSQUEDA!<br>Por favor revise la informaci&oacute;n");
define("_ROT_BUSCAR_ADVERTENCIA_MENSAJE"      ,"La palabra a buscar debe tener tres letras o m&aacute;s");


//Variable en MostrarCuentele
define("_ROT_CUEN_TIT","Cu&eacute;ntele a un amigo");
define("_ROT_CUEN_MEN1","Su email:");
define("_ROT_CUEN_MEN2","Email de su amigo:");
define("_ROT_CUEN_CUERPO","Te env&iacute;a el siguiente comentario:\n\n");
define("_ROT_CUEN_CUERPO1","Estimado amigo:\nGracias por recomendarnos.\nContinua invitando a tus amigos a hacer parte de este proyecto.\nAtentamente,\nEquipo de Trabajo Navegantes Virtuales.");
define("_ROT_CUEN_CUERPO2","Revisa esta p&aacute;gina");
define("_ROT_CUEN_CUERPO3","Gracias por recomendarnos");
define("_ROT_CUEN_CUERPO4","\nEmail del destinatario:");
define("_ROT_CUEN_NOTIFICACION","Notificaci&oacute;n: Recomendaci&oacute;n en la p&aacute;gina");
define("_ROT_CUEN_ENVIADO","Mensaje enviado.<br>Gracias");
define("_ROT_RECOMENDAR_NOTICIA","Recomiende esta Noticia");

// Variables para Emisoras
define("_ROT_EMISORA_NOMBRE","Nombre");
define("_ROT_EMISORA_RESUMEN","Descripci&oacute;n");
define("_ROT_EMISORA_IDENTIFICACION","Identificacion");
define("_ROT_EMISORA_URL","P&aacute;gina web");
define("_ROT_EMISORA_EMAIL","Email");

// Variables para Login
define("_ROT_LOGIN","Escriba su usuario y su clave");
define("_ROT_LOGIN_USUARIO"    ,"Usuario: ");
define("_ROT_LOGIN_PASSWORD"   ,"Clave: ");
define("_ROT_LOGIN_CAPTCHA"    ,"Ingrese valor del captcha");
define("_ROTT_LOGIN_IMG_CAPTCHA","Imagen captcha");

// Variables para Mapa
define("_ROT_MAPA_GENERAL"     ,"General");
define("_ROT_MAPA_DETALLADO"   ,"Detallado");
define("_ROT_MAPA_COMPLETO"    ,"Completo");

// Variables Edición
define("_ROT_EDICION"            ,"Los campos <span id=\"fieldRequired\">resaltados</span> son obligatorios");
define("_ROT_EDICION_ERROR"      ,"El nombre de la categor&iacute;a es obligatorio");
define("_ROT_EDICION_ANTETITULO" ,"Antet&iacute;tulo:");
define("_ROT_EDICION_NOMBRE"     ,"Nombre:");
define("_ROT_EDICION_SUBTITULO"  ,"Subt&iacute;tulo:");
define("_ROT_EDICION_RESUMEN" ,"Resumen:");
define("_ROT_EDICION_CONTENIDO"  ,"Contenido:");
define("_ROT_EDICION_AUTOR"      ,"Autor:");
define("_ROT_EDICION_IMAGEN"     ,"Imagen:");
define("_ROT_EDICION_ACTIVA"     ,"Activa:");
define("_ROT_EDICION_ORDEN"      ,"Orden:");
define("_ROT_EDICION_FECHA1"     ,"Fecha de creaci&oacute;n/actualizaci&oacute;n:");
define("_ROT_EDICION_FECHA2"     ,"Fecha m&aacute;xima en Home:");
define("_ROT_EDICION_FECHA3"     ,"Fecha 3:");
define("_ROT_EDICION_RESTRINGIDA","Restringir a todos los usuarios excepto a:");
define("_ROT_EDICION_TIPOSECCION","Tipo principal:");
define("_ROT_EDICION_TIPOSECCION_SUB","Tipo de las subcategor&iacute;as:");
define("_ROT_EDICION_TEMPLATE"   ,"Template gr&aacute;fico:");
define("_ROT_EDICION_PLANTILLA"   ,"Plantilla gr&aacute;fica:");
define("_ROT_EDICION_CRITERIO_ORDENA"   ,"Criterio de ordenaci&oacute;n de las subcategor&iacute;as:");
define("_ROT_EDICION_TIPO_ORDENA"   ,"Tipo de ordenaci&oacute;n de las subcategor&iacute;as:");
define("_ROT_EDICION_NUMERO_SUB"   ,"Cantidad m&aacute;xima de subcategor&iacute;as por p&aacute;gina:");
define("_ROT_EDICION_ESROOT"   ,"Es Home:");
define("_ROT_EDICION_NUMERO_SUB_INFO"   ,"Deje 0 para heredar el valor");
define("_ROT_EDICION_ENBUSQUEDA"	,'Visible en la Busqueda:');
define("_ROT_EDICION_ENMAPA"	,'Visible en el Mapa del Sitio:');
define("_ROT_EDICION_IDIOMA"	,'Idioma de la Categoria:');
define("_ROT_EDICION_ESRSS"     ,"Es RSS:");
define("_ROT_INDEXAR"     ,"Indexar Archivo:");

define("_ROT_EDICION_VOLVER"   ,"Cick aqui para regresar a modo normal");
define("_ROT_SUBMENU_EDICION"   ,"Subcategorias");

//Encuestas
define("_ROT_ENCUESTA"   ,"Encuesta");
define("_ROT_ENCUESTA_RESULTADO"   ,"Resultados");
define("_ROT_ENCUESTA_VOTAR"   ,"Votar");

/**
 * FOROS
 **/
define("_ROT_FORO_RESPUESTA"	,"Ud Esta dando respuesta a:");
define("_ROT_FORO_AUTOR"		,"Escrito por:");
define("_ROT_FORO_NOMBRE"       ,"Nombre:");
define("_ROT_FORO_RESPONDER"	,"Responder");

/**
 * Variables Licitaciones
 **/
define("_ROT_LICITACION_OBJETO","Objeto");
define("_ROT_LICITACION_ESTADOS","Estados");
define("_ROT_LICITACION_CUANTIA","Cuant&iacute;a");
define("_ROT_LICITACION_FECHA_APERTURA","Fecha de Apertura");
define("_ROT_LICITACION_FECHA_CIERRE","Fecha y Hora de Cierre");
define("_ROT_LICITACION_ORDENADOR_GASTO","Ordenador del Gasto");
define("_ROT_LICITACION_UNIDADES_TACTICAS","Unidades T&aacute;cticas");
define("_ROT_LICITACION_VINCULO","Archivo Relacionado");

/**
 * Campañas
 **/
define("_ROT_CONOZCAMAS","Conozca m&aacute;s acerca de la campa&ntilde;a ");

/**
 * Quejas y Reclamos
 **/
define("_ROT_QUEJAS"            ,"En este lugar usted puede escribir sus quejas, reclamos y denuncias,
 		   						  estos ser&aacute;n recibidos por la Inspecci&oacute;n General de la Fuerza A&eacute;rea. <br><br>
			   					  Por favor Ingrese los siguientes datos y oprima el bot&oacute;n Enviar.
								  (Los datos marcados con * son obligatorios)<br><br>Esta p&aacute;gina no es destinataria de estos mensajes y en su condici&oacute;n de intermediario, no tiene competencia para pronunciarse al respecto, los particulares que utilicen este servicio son responsables frente a la veracidad y precisi&oacute;n de sus denuncias, en caso de presentar informaci&oacute;n falsa o imprecisa, se pueden iniciar en su contra las acciones penales a que haya lugar.
								  Cuando las quejas o reclamos cumplan los requisitos previstos en la ley, para el ejercicio del derecho de petici&oacute;n, ser&aacute;n tratadas como tales, de acuerdo con las disposiciones legales aplicables a al derecho.<br><br>Los campos <span id=\"fieldRequired\">resaltados</span> son obligatorios");
define("_ROT_QUEJAS_NOMBRE", "Nombre(s)");
define("_ROT_QUEJAS_NOMBRE_ERROR", "Nombre se encuentra vacio.");
define("_ROT_QUEJAS_APELLIDO", "Apellidos");
define("_ROT_QUEJAS_APELLIDO_ERROR", "Apellido se encuentra vacio.");
define("_ROT_QUEJAS_IDENTIFICACION", "Identificaci&oacute;n");
define("_ROT_QUEJAS_IDENTIFICACION_ERROR", "La identificaci&oacute;n solo puede tener caracteres num&eacute;ricos.");
define("_ROT_QUEJAS_DIRECCION", "Direcci&oacute;n");
define("_ROT_QUEJAS_TELEFONO", "Tel&eacute;fono");
define("_ROT_QUEJAS_CORREO", "Correo Electr&oacute;nico");
define("_ROT_QUEJAS_CORREO_ERROR1", "Correo se encuentra vacio.");
define("_ROT_QUEJAS_CORREO_ERROR2", "Correo no v&aacute;lido. ");
define("_ROT_QUEJAS_PAIS", "Pa&iacute;s");
define("_ROT_QUEJAS_CIUDAD", "Ciudad");
define("_ROT_QUEJAS_LABEL", "Queja o Reclamo");
define("_ROT_QUEJAS_LABEL_ERROR", "Debe ingresar una queja o reclamo.");

define("_ROT_QUEJAS_ENVIO_CONFIRMA", "Queja enviada exitosamente.");
define("_ROT_QUEJAS_ENVIO_ERROR", "Hubo un error en el envio de la queja, por favor intente mas tarde.");

/**
 * VISITA
 **/
define("_ROT_VISITA"            ,"En este lugar usted puede solicitar los servicios de la Banda Sinf&oacute;nica, esta solicitud sera recibida por la Direcci&oacute;n de la Escuela Militar de Aviaci&oacute;n.
								 <br>Los campos <span id=\"fieldRequired\">resaltados</span> son obligatorios");

define("_ROT_VISITA_NOMBRE_INSTITUCION", "Nombre Instituci&oacute;n");
define("_ROT_VISITA_NOMBRE_INSTITUCION_ERROR", "Nombre de la instituion se encuentra vacio.");

define("_ROT_VISITA_NOMBRE", "Nombre Solicitante");
define("_ROT_VISITA_NOMBRE_ERROR", "Nombre se encuentra vacio.");
define("_ROT_VISITA_APELLIDO", "Apellidos Solicitante");
define("_ROT_VISITA_APELLIDO_ERROR", "Apellido se encuentra vacio.");
define("_ROT_VISITA_IDENTIFICACION", "Identificaci&oacute;n");
define("_ROT_VISITA_IDENTIFICACION_ERROR", "La identificaci&oacute;n solo puede tener caracteres num&eacute;ricos.");
define("_ROT_VISITA_DIRECCION", "Direcci&oacute;n");
define("_ROT_VISITA_TELEFONO", "Tel&eacute;fono");
define("_ROT_VISITA_CORREO", "Correo Electr&oacute;nico");
define("_ROT_VISITA_CORREO_ERROR1", "Correo se encuentra vacio.");
define("_ROT_VISITA_CORREO_ERROR2", "Correo no v&aacute;lido. ");

define("_ROT_VISITA_NOMBRE_EVENTO", "Nombre del Evento");
define("_ROT_VISITA_NOMBRE_EVENTO_ERROR", "Nombre del Evento se encuentra vacio.");

define("_ROT_VISITA_FECHA_EVENTO", "Fecha del Evento");
define("_ROT_VISITA_FECHA_EVENTO_ERROR", "Fecha del Evento se encuentra vacio.");

define("_ROT_VISITA_HORA_EVENTO", "Hora del Evento");
define("_ROT_VISITA_HORA_EVENTO_ERROR", "Hora del Evento se encuentra vacio.");

define("_ROT_VISITA_PAIS", "Pa&iacute;s");
define("_ROT_VISITA_CIUDAD", "Ciudad");
define("_ROT_VISITA_LABEL", "Observaciones");
define("_ROT_VISITA_LABEL_ERROR", "Debe ingresar Observaciones.");

define("_ROT_VISITA_ENVIO_CONFIRMA", "Queja enviada exitosamente.");
define("_ROT_VISITA_ENVIO_ERROR", "Hubo un error en el envio de la queja, por favor intente mas tarde.");

/**
 * Suscripciones
 **/
define("_ROT_SUSCRIPCION_NOMBRE_ERROR", "Falta el Campo Nombre");
define("_ROT_SUSCRIPCION_APELLIDO_ERROR", "Falta el campo Apellido");
define("_ROT_SUSCRIPCION_CC_ERROR", "Falta el campo C.C. o tiene caracteres no v&aacute;lidos");
define("_ROT_SUSCRIPCION_EMAIL_ERROR", "Falta el Correo");
define("_ROT_SUSCRIPCION_EMAIL_ERROR2", "La sintaxis del Correo no es v&aacute;lido");
define("_ROT_SUSCRIPCION_TELEFONO_ERROR", "Falta el Tel&eacute;fono o tiene caracteres no v&aacute;lidos");
define("_ROT_SUSCRIPCION_DIRECCION_ERROR", "Falta la Direcci&oacute;n");
define("_ROT_SUSCRIPCION_CIUDAD_ERROR", "Falta la Ciudad");
define("_ROT_SUSCRIPCION_FECHA_SUSCRIPCION_ERROR", "Falta la fecha desde la cu&aacute;l desea suscribirse");
define("_ROT_SUSCRIPCION_TIEMPO_SUSCRIPCION_ERROR", "Falta el tiempo de su suscripci&oacute;n");
define("_ROT_SUSCRIPCION_COMENTARIO_ERROR", "Falta el comentario");

define("_ROT_SUSCRIPCION_ENVIO_CONFIRMA", "Se envi&oacute; el mensaje correctamente");
define("_ROT_SUSCRIPCION_ENVIO_ERROR", "No se pudo enviar el mensaje. Por favor intentelo mas tarde.");

/**
 * Servicios (Visitas)
 **/
define("_ROT_SERVICIO_NOMBRE_INSTITUCION_ERROR", "Falta el Campo 'Nombre de la Instituci&oacute;n'");
define("_ROT_SERVICIO_NOMBRE_SOLICITANTE_ERROR", "Falta el Campo 'Nombre del Solicitante'");
define("_ROT_SERVICIO_APELLIDO_SOLICITANTE_ERROR", "Falta el Campo 'Apellido del Solicitante'");
define("_ROT_SERVICIO_DIRECCION_ERROR", "Falta el Campo 'Direcci&oacute;n'");
define("_ROT_SERVICIO_TELEFONO_ERROR", "Falta el Campo 'Tel&eacute;fono'. Ingrese s&oacute;lo n&uacute;meros por favor.");
define("_ROT_SERVICIO_CORREO_ERROR", "Falta el Campo 'Correo'");
define("_ROT_SERVICIO_CORREO_ERROR2", "La sintaxis del Correo no es v&aacute;lido");
define("_ROT_SERVICIO_PAIS_ERROR", "Falta el Campo 'Pa&iacute;s'");
define("_ROT_SERVICIO_CIUDAD_ERROR", "Falta el Campo 'Ciudad'");
define("_ROT_SERVICIO_NOMBRE_EVENTO_ERROR", "Falta el Campo 'Nombre del Evento'");
define("_ROT_SERVICIO_FECHA_EVENTO_ERROR", "Falta el Campo 'Fecha del Evento'");

/**
 * Formato de datetotext
 **/
define('FORMAT_DATETOTEXT', '%d de %B de %Y');

/**
 * Rotulos de los Meses de las Fechas del Filtro Avanzado
 **/
define("_ROT_FILTRO_BUSCAR", "Buscar");
define("_ROT_FILTRO_FECHA", "Todas las fechas");
define("_ROT_FILTRO_FECHA_ENERO", "Enero");
define("_ROT_FILTRO_FECHA_FEBRERO", "Febrero");
define("_ROT_FILTRO_FECHA_MARZO", "Marzo");
define("_ROT_FILTRO_FECHA_ABRIL", "Abril");
define("_ROT_FILTRO_FECHA_MAYO", "Mayo");
define("_ROT_FILTRO_FECHA_JUNIO", "Junio");
define("_ROT_FILTRO_FECHA_JULIO", "Julio");
define("_ROT_FILTRO_FECHA_AGOSTO", "Agosto");
define("_ROT_FILTRO_FECHA_SEPTIEMBRE", "Septiembre");
define("_ROT_FILTRO_FECHA_OCTUBRE", "Octubre");
define("_ROT_FILTRO_FECHA_NOVIEMBRE", "Noviembre");
define("_ROT_FILTRO_FECHA_DICIEMBRE", "Diciembre");

// Cabezote
define("_ROT_GO_CONTENT","Ir al contenido");
define("_ROT_INICIO","Inicio");
define("_ROT_SEL_IDIOMAS","Seleccione Idioma");
define("_ROT_IDIOMAS", 'Idiomas');
define("_ROT_DESCARGA","Este sitio usa Macromedia Flash para mostrar algunos de sus contenidos. Puede descargar el plugin");
define("_ROT_AQUI","aqu&iacute;");
define("_ROT_HORA_LEGAL", "Hora Legal Colombiana");
define("_ROT_NOSCRIPT", "Su navegador no soporta JavaScript!");
define("_ROT_NAV_TOOLS", "Barra de navegaci&oacute;n de herramientas");
define("_ROT_SKIP_TOOLS", "Saltar la barra de navegaci&oacute;n de herramientas");
define("_ROT_END_TOOLS", "Fin barra de navegaci&oacute;n de herramientas");
define("_ROT_LOGIN_USER", "Login");
define("_ROT_IMAGENES", "Im&aacute;genes");
define("_ROT_VIDEO", "Video");
define("_ROT_AUDIO", "Audio");


// Laterales
define("_ROT_MENU_INST","Men&uacute;<span> Institucional</span>");
define("_ROT_MENU_INSTITUCIONAL","Men&uacute Principal");
define("_ROT_NAV_INST","Men&uacute; de navegaci&oacute;n Institucional");
define("_ROT_SKIP_INST","Saltar el men&uacute; de navegaci&oacute;n Institucional");
define("_ROT_END_OF","Fin de");
define("_ROT_END_MENU_INST","Fin del Men&uacute; Institucional");
define("_ROT_GO_TO","Ir a");
define("_ROT_AMPLIAR_NOTA","Ampliar nota");


define("_ROT_RECOMENDADOS","Secciones Recomendadas");
define("_ROT_NAV_RECOMENDADOS","Barra de navegaci&oacute;n de las secciones recomendadas");
define("_ROT_SKIP_RECOMENDADOS","Saltar la barra de navegaci&oacute;n de las secciones recomendadas");
define("_ROT_END_RECOMENDADOS","Fin barra de navegaci&oacute;n de las secciones recomendadas");
define("_ROT_ENLACES","Enlaces Institucionales");
define("_ROT_INCORPORACIONES","Incorporaciones");
define("_ROT_VIDEOS","Videos");
define("_ROT_PREGUNTAS","Preguntas Frecuentes");
define("_ROT_CATEGORIA_DESTACADA","Categor&iacute;a destacada");

// Menu usuario
define("_ROT_MENU_USER","Men&uacute; del usuario");
define("_ROT_NAV_USER", "Men&uacute; de navegaci&oacute;n del usuario");
define("_ROT_SKIP_USER", "Saltar el men&uacute; de navegaci&oacute;n del usuario");
define("_ROT_END_MENU_USER", "Fin del men&uacute; del ususario");
define("_ROT_ADMIN", "Administraci&oacute;n");
define("_ROT_VER_PAGINA", "Ver p&aacute;gina");
define("_ROT_EDITAR_PAGINA", "Editar esta p&aacute;gina");
define("_ROT_MI_PORTAL", "Mi portal");
define("_ROT_TERMINAR_SESION", "Terminar Sesi&oacute;n");

// Nube
define("_ROT_TAG_CLOUD", "Nube de Etiquetas");
define("_ROT_RELATED_TAGS", "Lo m&aacute;s visto");
define("_ROT_NAV_CLOUD", "Barra de navegaci&oacute;n de la nube de etiquetas");
define("_ROT_SKIP_CLOUD", "Saltar la barra de navegaci&oacute;n de la nube de etiquetas");
define("_ROT_END_CLOUD", "Fin barra de navegaci&oacute;n de la nube de etiquetas");

// Migas
define("_ROT_BREAD_CRUMBS", "Migas");
define("_ROT_NAV_BREAD_CRUMBS", "Barra de navegaci&oacute;n de las migas");
define("_ROT_BREAD_CRUMBS_HERE", "Usted est&aacute; aqu&iacute;:");
define("_ROT_SKIP_BREAD_CRUMBS", "Saltar la barra de navegaci&oacute;n de las migas");
define("_ROT_END_BREAD_CRUMBS", "Fin barra de navegaci&oacute;n de las migas");

// Home y Home Generico
define("_ROT_CONTENT","Contenido");
define("_ROT_AUTOR","Por");
define("_ROT_VERMAS_HOME","Ver m&aacute;s informaci&oacute;n");
define("_ROT_VERMAS","Ver m&aacute;s");
define("_ROT_VERLISTA","Ver Lista");
define("_ROT_AMPLIAR","ampliar");
define("_ROT_PUBLICADO","Publicado el d&iacute;a");
define("_ROT_ACTUALIZACION","&Uacute;ltima Actualizaci&oacute;n");
define("_ROT_END_SECTION","Fin de la secci&oacute;n");

// Pie
define("_ROT_DESTACADOS","Destacados");
define("_ROT_NAV_HIGHLIGHTS","Barra de navegaci&oacute;n de las secciones destacadas");
define("_ROT_SKIP_HIGHLIGHTS","Saltar la barra de navegaci&oacute;n de las secciones destacadas");
define("_ROT_END_HIGHLIGHTS","Fin barra de navegaci&oacute;n de las secciones destacadas");
define("_ROT_INSTITUCIONES","Instituciones del Estado");
define("_ROT_NAV_INSTITUCIONES","Barra de navegaci&oacute;n de las Instituciones del Estado");
define("_ROT_SKIP_INSTITUCIONES","Saltar las Instituciones del Estado");
define("_ROT_END_INSTITUCIONES", "Fin de las Instituciones del Estado");
define("_ROT_INFO_COMPANY","Informaci&oacute;n de la Entidad");
define("_ROT_DEVELOPED","Portal Desarrollado por");
define("_ROT_GOTO","Ir a la p&aacute;gina");
define("_ROT_LOGO","Logo de la empresa Micrositios Ltda.");


// Default
define("_ROT_IMAGEN","Ampliar Imagen");
define("_ROT_AMPLIAR_IMAGEN","Ver imagen en el tama&ntilde;o original");
define("_ROT_SUBCATEGORIAS","V&iacute;nculos relacionados");
define("_ROT_UTILIDADES","Utilidades");
define("_ROT_INICIO_PAGINA","Ir al inicio de esta p&aacute;gina");
define("_ROT_IMPRIMIR","Ver en formato amigable para la impresora");
define("_ROT_ENVIAR_AMIGO","Recomendar esta secci&oacute;n a un amigo");

// Lista en cuadros
define("_ROT_SUMMARY","Categor&iacute;as con res&uacute;menes organizadas en cuadros");

// Galeria de imagenes
define("_ROT_VERIMAGEN","Ver Imagen");
define("_ROT_TITLE_IMAGEN","Ver imagen completa");
define("_ROT_INFORMACION","Informaci&oacute;n");
define("_ROT_TITLE_INFORMACION","Ir a la categor&iacute;a");

// Galeria de audio
define("_ROT_ESCUCHAR","Escuchar");

// Galeria de video
define("_ROT_VER_VIDEO","Ver Video");

// Paginacion
define("_ROT_PAGER","Paginador");
define("_ROT_NAV_PAGER","Barra de navegaci&oacute;n del paginador");
define("_ROT_SKIP_PAGER", "Saltar la barra de navegaci&oacute;n del paginador");
define("_ROT_END_PAGER", "Fin barra de navegaci&oacute;n del paginador");
define("_ROT_PRIMERO","Primero");
define("_ROT_ANTERIOR","Anterior");
define("_ROT_SIGUIENTE","Siguiente");
define("_ROT_ULTIMO","&Uacute;ltimo");

// Descarga
define("_ROT_DESCARGAR","Descargar");

// url con marco
define("_ROT_VOLVER","Volver");

// Calendario
define("_ROT_CALENDARIO_MESES","Seleccione el Mes para ver Eventos");

// Archivo verificar_pin.php
define("_SMS_PARAMETROS_ERROR",'Par&aacute;metros incorrectos');
define("_SMS_PIN_ENVIADO",'Se envio un PIN de validaci&oacute;n a su n&uacute;mero de celular Nº ');
define("_SMS_PIN_NO_ENVIADO",'No se envi&oacute; el PIN de validaci&oacute;n. El usuario no ha aceptado recibir mensajes');

?>