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
define("_ROT_PAGINA_INEXISTENTE" ,"Posiblemente la página que desea ver está deshabilitada<br>Por favor comuníquese con el administrador del sitio");
define("_ROT_MENSAJE_RESTRICCION","Página restringida nivel ");
define("_ROT_PAGINA_RESTRINGIDA" ,sprintf(str_replace("  "," ","<ul>
        <li>Para usar los servicios de nuestro portal debe crear su cuenta <a href=index.php?idcategoria=%s><span class=tpl_titulo_mensaje_error><b>aqui</b></span></a>
        <li>El <b>usuario</b> y el <b>password</b> serán enviados automáticamente a su email.
        </ul>"),_SREGISTRO));

// Archivo funciones.php

define("_ROT_MIGAS"      ,"Usted está aqui:");
define("_ROT_SUBMENU"    ,"");
define("_ROT_SUBMENU_LINEA","");
define("_ROT_SUBMENU_MARCA","");
define("_ROT_SUBMENU_PUBLICACIONES","<B>PORTADA</B>");
define("_ROT_VER_MAS","Leer Noticia");
define("_ROT_BOLETIN_TXT_1","Escriba su email para recibir nuestro bolet&iacute;n electr&oacute;nico.");

define("_ROT_ENCUESTA1"   ,"Escoja una opción y vote!");
define("_ROT_ENCUESTA2"   ,"Resultados de la votación");
define("_ROT_ENCUESTA3"   ,"Cantidad total de votos");
define("_ROT_REDIRECCION","Usted ha sido redirigido automáticamente a otra sección de la página web");
define("_ROT_DOWNLOAD"   ,"Haga click en el vínculo para abrir el archivo.<br>Para guardarlo en su disco duro haga click<br>con el botón derecho y escoja<br> \"Guardar detino como...\"<br>");
define("_ROT_CADUCIDAD"  ,"Aunque esta información no se considera vigente, continúa en el archivo histórico del sitio web");

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
define("_ROT_CONTACTO_EMPRESA"      ,"Actividad/Oficio/Profesión:");
define("_ROT_CONTACTO_EMPRESA_ERROR","Falta la actividad");
define("_ROT_CONTACTO_CARGO"      ,"Cargo:");
define("_ROT_CONTACTO_CARGO_ERROR","Falta el cargo");
define("_ROT_CONTACTO_DIRECCION"      ,"Ciudad / País:");
define("_ROT_CONTACTO_DIRECCION_ERROR","Falta la Dirección");
define("_ROT_REGISTRO_CEL_ERROR4"              ,"Falta el celular");
define("_ROT_REGISTRO_EXISTENTE4"    ,"Ya hay un usuario registrado con ese Celular. Por favor utilice otro.");
define("_ROT_REGISTRO_SMS"                     	 ,"Autorizo recibir mensajes de texto en mi teléfono celular:");
define("_ROT_REGISTRO_CEL_ERROR2"              ,"El numero de celular no es valido");
define("_ROT_REGISTRO_CEL"					 ,"Celular:");

define("_ROT_CONTACTO_TELEFONOS"      ,"Teléfono:");
define("_ROT_CONTACTO_TELEFONOS_ERROR","Falta el teléfono");
define("_ROT_REGISTRO_CEL_ERROR4"              ,"Falta el celular");
define("_ROT_REGISTRO_EXISTENTE4"    ,"Ya hay un usuario registrado con ese Celular. Por favor utilice otro.");
define("_ROT_REGISTRO_SMS"                     	 ,"Autorizo recibir mensajes de texto en mi teléfono celular:");
define("_ROT_REGISTRO_CEL_ERROR2"              ,"El numero de celular no es valido");
define("_ROT_CONTACTO_COMENTA"      ,"Comentarios:");
define("_ROT_CONTACTO_COMENTA_ERROR","Faltan los comentarios");
define("_ROT_CONTACTO",              "<ul><li>Nos interesan todos sus comentarios, sugerencias y preguntas.
                                     <li>Los campos <font color=#FF8000>resaltados</font> son obligatorios.</ul>");
define("_ROT_CONTACTO_ADVERTENCIA","NO SE ENVIÓ EL FORMULARIO!<br>Por favor revise la información");
define("_ROT_CONTACTO_REQUERIDO","(Requerido)");

define("_ROT_CONTACTO_ENVIO_CONFIRMA"   ,"El mensaje fué enviado a <b>%s</b>, muchas gracias por su interés");
define("_ROT_CONTACTO_ENVIO_ERROR","El mensaje NO pudo ser enviado a <b>%s</b>,<br>por favor intente mas tarde o utilice su cliente de correo habitual");

// Archivo certificado.php

define("_ROT_CERTIFICADO_NOMBRE"      ,"Nombres completos:");
define("_ROT_CERTIFICADO_NOMBRE_ERROR","Falta el nombre");
define("_ROT_CERTIFICADO_EMAIL"      ,"Email:");
define("_ROT_CERTIFICADO_EMAIL_ERROR1","Falta el email");
define("_ROT_CERTIFICADO_EMAIL_ERROR2","La sintaxis del email es incorrecta");
define("_ROT_CERTIFICADO_FECHA"      ,"Fecha Solicitud:");
define("_ROT_CERTIFICADO_FECHA_ERROR","Falta la Fecha");
define("_ROT_CERTIFICADO_CEDULA"      ,"Código o Cédula:");
define("_ROT_CERTIFICADO_CEDULA_ERROR","Falta Código o Cédula");
define("_ROT_CERTIFICADO_TIPO"      ,"Tipo de Solicitud:");
define("_ROT_CERTIFICADO_TIPO_ERROR","Falta el Tipo de Solicitud");
define("_ROT_CERTIFICADO_DESTINO"      ,"Destino Certificación:");
define("_ROT_CERTIFICADO_DESTINO_ERROR","Falta el Destino de la Certificación");
define("_ROT_CERTIFICADO_APELLIDO"      ,"Apellidos Completos:");
define("_ROT_CERTIFICADO_APELLIDO_ERROR","Falta el Apellido");
define("_ROT_CERTIFICADO_TELEFONOS"      ,"Teléfono Solicitante:");
define("_ROT_CERTIFICADO_TELEFONOS_ERROR","Falta el teléfono");
define("_ROT_CERTIFICADO_DIRECCION"      ,"Direccion Permanente:");
define("_ROT_CERTIFICADO_DIRECCION_ERROR","Faltan la Dirección");
define("_ROT_CERTIFICADOS","<br>Llene el formulario y presione Enviar");
define("_ROT_CERTIFICADO_ADVERTENCIA","Por favor revise la información");
define("_ROT_CERTIFICADO_REQUERIDO","(Requerido)");

// Archivo acreedores.php

define("_ROT_ACREEDORES"                     ,"ACREEDORES");
define("_ROT_ACREEDORES_TIPOIDENTIFICACION"  ,"Tipo Identificación:");
define("_ROT_ACREEDORES_IDENTIFICACION"      ,"Identificación:");
define("_ROT_ACREEDORES_IDENTIFICACION_ERROR","Falta la Identificación");
define("_ROT_ACREEDORES_CLAVE"               ,"Clave:");
define("_ROT_ACREEDORES_REQUERIDO"           ,"(Requerido)");


// Archivo registro_evento.php
define("_ROT_REGISTRO_FORMA_PAGO_ERROR"      ,"Debe seleccionar una forma de pago");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO1"   ,"Usted ya esta registrado para este evento");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO2"   ,"Se le envió un email a la cuenta <b>%s</b> con las instrucciones detalladas para terminar su proceso de registro");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO3"   ,"Si quiere anular o modificar su registro a este evento comuníquese telefónicamente con nosotros");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA1"   ,"Cuando oprima el botón de Aceptar solo podrá modificar o anular su registro telefónicamente");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA2"   ,"Una vez complete su registro le enviaremos un email de confirmación y descripciones detalladas del proceso de inscripción");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA3"   ,"Esta transacción queda amparada por el decreto XXXX y tiene validez como DDDD");
define("_ROT_INFO"                           ,"INFORMACION");


// Archivo registro.php

define("_ROT_REGISTRO","<ul><li>El registro le permite obtener mas información sobre nuestros eventos
                            <li>El registro es <B>GRATUITO</B>
                            <li>Su username y password seran enviados al email suministrado
                            <li>Los campos <font color=#FF8000>resaltados</font> son obligatorios.</ul>");
define("_ROT_MICUENTA"                           ,"Esta es su información personal, recuerde cambiar el password periódicamente.<br>Los campos <font color=#FF8000>resaltados</font> son obligatorios.");
define("_ROT_MICUENTA_ACTUALIZACION"             ,"CONFIRMACION!");
define("_ROT_REGISTRO_USERNAME"                  ,"Username:");
define("_ROT_REGISTRO_USERNAME_ERROR"            ,"Falta el username");
define("_ROT_REGISTRO_NOMBRE"                    ,"Nombres:");
define("_ROT_REGISTRO_NOMBRE_ERROR"              ,"Falta el nombre");
define("_ROT_REGISTRO_CEL"					 ,"Celular:");
define("_ROT_REGISTRO_PASSWORD1"                 ,"Password:");
define("_ROT_REGISTRO_PASSWORD2"                 ,"Confirme el password:");
define("_ROT_REGISTRO_PASSWORD_ERROR1"           ,"Falta el Password");
define("_ROT_REGISTRO_PASSWORD_ERROR2"           ,"Falta la confirmación del password");
define("_ROT_REGISTRO_PASSWORD_ERROR3"           ,"El password y la confirmación no coinciden");
define("_ROT_REGISTRO_APELLIDO"                  ,"Apellidos:");
define("_ROT_REGISTRO_APELLIDO_ERROR"            ,"Falta el apellido");
define("_ROT_REGISTRO_EMAIL"                     ,"Email:");
define("_ROT_REGISTRO_EMAIL_ERROR1"              ,"Falta el email");
define("_ROT_REGISTRO_EMAIL_ERROR2"              ,"La sintaxis del email es incorrecta");
define("_ROT_REGISTRO_EMAIL_ERROR3"              ,"La sintaxis del email del contacto de PAGO es incorrecta");
define("_ROT_REGISTRO_EMPRESA"                   ,"Nombre de la Empresa (Razón Social):");
define("_ROT_REGISTRO_EMPRESA_ERROR"             ,"Falta la empresa");
define("_ROT_REGISTRO_CIUDAD"                    ,"Ciudad:");
define("_ROT_REGISTRO_CIUDAD_ERROR"              ,"Falta la ciudad");
define("_ROT_REGISTRO_PAIS"                      ,"País:");
define("_ROT_REGISTRO_PAIS_ERROR"                ,"Falta el país");
define("_ROT_REGISTRO_PROFESION"                 ,"Profesión:");
define("_ROT_REGISTRO_PROFESION_ERROR"           ,"Falta la profesión");
define("_ROT_REGISTRO_TELEFONO"                  ,"Teléfono:");
define("_ROT_REGISTRO_TELEFONO_EMPRESA"          ,"Teléfonos:<ul class=texto_mini><li>Puede escribir varios si lo desea<li>Escriba la extensión<li>No escriba indicativos</ul>");
define("_ROT_REGISTRO_FAX_EMPRESA"               ,"Fax:");
define("_ROT_REGISTRO_TELEFONO_ERROR"            ,"Falta el teléfono");
define("_ROT_REGISTRO_DIRECCION"                 ,"Dirección:");
define("_ROT_REGISTRO_DIRECCION_ERROR"           ,"Falta la dirección");
define("_ROT_REGISTRO_CARGO"                     ,"Cargo:");
define("_ROT_REGISTRO_EVENTOS"                   ,"Temas sobre los que le gustaría recibir mas información:");
define("_ROT_REGISTRO_EMPRESA_NIT"               ,"Nit:");
define("_ROT_REGISTRO_EMPRESA_ACTIVIDAD"         ,"Actividad Económica:");

define("_ROT_REGISTRO_EMPRESA_MEDIO"             ,"Medio por el que se enteró de nuestros eventos:");
define("_ROT_REGISTRO_EMPRESA_MEDIO_OTRO"        ,"Si escogio otro, por favor escriba cual fué:");

define("_ROT_REGISTRO_REQUERIDO"    ,"(Requerido)");
define("_ROT_REGISTRO_CORREO"       ,"Desea recibir información nuestra vía email?");
define("_ROT_REGISTRO_RED"          ,"Deseo suscribirme a la Red de Medios para la Paz");
define("_ROT_REGISTRO_ADVERTENCIA"  ,"Por favor revise la información");
define("_ROT_REGISTRO_ADVERTENCIA2"  ,"Su información no fué actualizada");
define("_ROT_REGISTRO_EXISTENTE"    ,"Ya hay un usuario registrado con ese email. Por favor utilice otro.");
define("_ROT_REGISTRO_EXISTENTE2"    ,"Ya hay un usuario registrado con ese username. Por favor utilice otro.");
define("_ROT_REGISTRO_EXITO"        ,"Su información fué actualizada correctamente");

define("_ROT_REGISTRO_RECORDAR","<b>¿Ya está registrado pero olvidó su username o el password?</b><br>Escriba aquí el email con el que se registró.");

// Archivo buscar.php
define("_ROT_BUSCAR"            ,"Buscar");
define("_ROT_BUSCAR_TXT"            ,"La búsqueda esta restringida<br>a la información contenida en esta página.");
define("_ROT_BUSCAR_PALABRA"    ,"Palabra a buscar");
define("_ROT_BUSCAR_RESULTADOS" ,"Se encontraron %s resultados relacionados con <font color=green><i>%s</i></font>");
define("_ROT_BUSCAR_ADVERTENCIA","NO SE PUDO HACER LA BUSQUEDA!<br>Por favor revise la información");
define("_ROT_BUSCAR_ADVERTENCIA_MENSAJE"      ,"La palabra a buscar debe tener tres letras o más");


//Variable en MostrarCuentele
define("_ROT_CUEN_TIT","Cuéntele a un amigo");
define("_ROT_CUEN_MEN1","Su email:");
define("_ROT_CUEN_MEN2","Email de su amigo:");
define("_ROT_CUEN_CUERPO","Te envía el siguiente comentario:\n\n");
define("_ROT_CUEN_CUERPO1","Estimado amigo:\nGracias por recomendarnos.\nContinua invitando a tus amigos a hacer parte de este proyecto.\nAtentamente,\nEquipo de Trabajo Navegantes Virtuales.");
define("_ROT_CUEN_CUERPO2","Revisa esta página");
define("_ROT_CUEN_CUERPO3","Gracias por recomendarnos");
define("_ROT_CUEN_CUERPO4","\nEmail del destinatario:");
define("_ROT_CUEN_NOTIFICACION","Notificación: Recomendación en la página");
define("_ROT_CUEN_ENVIADO","Mensaje enviado.<br>Gracias");
define("_ROT_RECOMENDAR_NOTICIA","Recomiende esta Noticia");

// Variables para Emisoras
define("_ROT_EMISORA_NOMBRE","Nombre");
define("_ROT_EMISORA_RESUMEN","Descripción");
define("_ROT_EMISORA_IDENTIFICACION","Identificacion");
define("_ROT_EMISORA_URL","Página web");
define("_ROT_EMISORA_EMAIL","Email");

// Variables para Login
define("_ROT_LOGIN","Escriba su usuario y su password");
define("_ROT_LOGIN_USUARIO"    ,"Usuario: ");
define("_ROT_LOGIN_PASSWORD"   ,"Password: ");

// Variables para Mapa
define("_ROT_MAPA_GENERAL"     ,"General");
define("_ROT_MAPA_DETALLADO"   ,"Detallado");
define("_ROT_MAPA_COMPLETO"    ,"Completo");

// Variables Edición
define("_ROT_EDICION"            ,"Los campos <font color=#FF8000>resaltados</font> son obligatorios");
define("_ROT_EDICION_ERROR"      ,"El nombre de la categoría es obligatorio");
define("_ROT_EDICION_ANTETITULO" ,"Antetítulo:");
define("_ROT_EDICION_NOMBRE"     ,"Nombre:");
define("_ROT_EDICION_SUBTITULO"  ,"Subtítulo:");
define("_ROT_EDICION_RESUMEN" ,"Resumen:");
define("_ROT_EDICION_CONTENIDO"  ,"Contenido:");
define("_ROT_EDICION_AUTOR"      ,"Autor:");
define("_ROT_EDICION_IMAGEN"     ,"Imagen:");
define("_ROT_EDICION_ACTIVA"     ,"Activa:");
define("_ROT_EDICION_ORDEN"      ,"Orden:");
define("_ROT_EDICION_FECHA1"     ,"Fecha de creación/actualización:");
define("_ROT_EDICION_FECHA2"     ,"Fecha máxima en Home:");
define("_ROT_EDICION_FECHA3"     ,"Fecha 3:");
define("_ROT_EDICION_RESTRINGIDA","Restringir a todos los usuarios excepto a:");
define("_ROT_EDICION_TIPOSECCION","Tipo principal:");
define("_ROT_EDICION_TIPOSECCION_SUB","Tipo de las subcategorías:");
define("_ROT_EDICION_TEMPLATE"   ,"Template gráfico:");
define("_ROT_EDICION_PLANTILLA"   ,"Plantilla gráfica:");
define("_ROT_EDICION_CRITERIO_ORDENA"   ,"Criterio de ordenación de las subcategorías:");
define("_ROT_EDICION_TIPO_ORDENA"   ,"Tipo de ordenación de las subcategorías:");
define("_ROT_EDICION_NUMERO_SUB"   ,"Cantidad máxima de subcategorías por página:");
define("_ROT_EDICION_ESROOT"   ,"Es Home:");
define("_ROT_EDICION_NUMERO_SUB_INFO"   ,"Deje 0 para heredar el valor");
define("_ROT_EDICION_ENBUSQUEDA"	,'Visible en la Busqueda:');
define("_ROT_EDICION_ENMAPA"	,'Visible en el Mapa del Sitio:');
define("_ROT_EDICION_IDIOMA"	,'Idioma de la Categoria:');
define("_ROT_EDICION_ESRSS"     ,"Es RSS:");

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
define("_ROT_LICITACION_CUANTIA","Cuantía");
define("_ROT_LICITACION_FECHA_APERTURA","Fecha de Apertura");
define("_ROT_LICITACION_FECHA_CIERRE","Fecha y Hora de Cierre");
define("_ROT_LICITACION_ORDENADOR_GASTO","Ordenador del Gasto");
define("_ROT_LICITACION_UNIDADES_TACTICAS","Unidades Tácticas");
define("_ROT_LICITACION_VINCULO","Archivo Relacionado");

/**
 * Campañas
 **/
define("_ROT_CONOZCAMAS","Conozca m&aacute;s acerca de la campa&ntilde;a ");

/**
 * Quejas y Reclamos
 **/
define("_ROT_QUEJAS"            ,"En este lugar usted puede escribir sus quejas, reclamos y denuncias,
 		   						  estos serán recibidos por la Inspección General de la Fuerza Aérea. <br><br>
			   					  Por favor Ingrese los siguientes datos y oprima el botón Enviar.
								  (Los datos marcados con * son obligatorios)<br><br>Esta página no es destinataria de estos mensajes y en su condición de intermediario, no tiene competencia para pronunciarse al respecto, los particulares que utilicen este servicio son responsables frente a la veracidad y precisión de sus denuncias, en caso de presentar información falsa o imprecisa, se pueden iniciar en su contra las acciones penales a que haya lugar.
								  Cuando las quejas o reclamos cumplan los requisitos previstos en la ley, para el ejercicio del derecho de petición, serán tratadas como tales, de acuerdo con las disposiciones legales aplicables a al derecho.<br><br>Los campos <font color=#FF8000>resaltados</font> son obligatorios");
define("_ROT_QUEJAS_NOMBRE", "Nombre(s)");
define("_ROT_QUEJAS_NOMBRE_ERROR", "Nombre se encuentra vacio.");
define("_ROT_QUEJAS_APELLIDO", "Apellidos");
define("_ROT_QUEJAS_APELLIDO_ERROR", "Apellido se encuentra vacio.");
define("_ROT_QUEJAS_IDENTIFICACION", "Identificación");
define("_ROT_QUEJAS_IDENTIFICACION_ERROR", "La identificación solo puede tener caracteres numéricos.");
define("_ROT_QUEJAS_DIRECCION", "Dirección");
define("_ROT_QUEJAS_TELEFONO", "Teléfono");
define("_ROT_QUEJAS_CORREO", "Correo Electrónico");
define("_ROT_QUEJAS_CORREO_ERROR1", "Correo se encuentra vacio.");
define("_ROT_QUEJAS_CORREO_ERROR2", "Correo no válido. ");
define("_ROT_QUEJAS_PAIS", "País");
define("_ROT_QUEJAS_CIUDAD", "Ciudad");
define("_ROT_QUEJAS_LABEL", "Queja o Reclamo");
define("_ROT_QUEJAS_LABEL_ERROR", "Debe ingresar una queja o reclamo.");

define("_ROT_QUEJAS_ENVIO_CONFIRMA", "Queja enviada exitosamente.");
define("_ROT_QUEJAS_ENVIO_ERROR", "Hubo un error en el envio de la queja, por favor intente mas tarde.");

/**
 * VISITA
 **/
define("_ROT_VISITA"            ,"En este lugar usted puede solicitar los servicios de la Banda Sinfónica, esta solicitud sera recibida por la Dirección de la Escuela Militar de Aviación.
								 <br>Los campos <font color=#FF8000>resaltados</font> son obligatorios");

define("_ROT_VISITA_NOMBRE_INSTITUCION", "Nombre Institución");
define("_ROT_VISITA_NOMBRE_INSTITUCION_ERROR", "Nombre de la instituion se encuentra vacio.");

define("_ROT_VISITA_NOMBRE", "Nombre Solicitante");
define("_ROT_VISITA_NOMBRE_ERROR", "Nombre se encuentra vacio.");
define("_ROT_VISITA_APELLIDO", "Apellidos Solicitante");
define("_ROT_VISITA_APELLIDO_ERROR", "Apellido se encuentra vacio.");
define("_ROT_VISITA_IDENTIFICACION", "Identificación");
define("_ROT_VISITA_IDENTIFICACION_ERROR", "La identificación solo puede tener caracteres numéricos.");
define("_ROT_VISITA_DIRECCION", "Dirección");
define("_ROT_VISITA_TELEFONO", "Teléfono");
define("_ROT_VISITA_CORREO", "Correo Electrónico");
define("_ROT_VISITA_CORREO_ERROR1", "Correo se encuentra vacio.");
define("_ROT_VISITA_CORREO_ERROR2", "Correo no válido. ");

define("_ROT_VISITA_NOMBRE_EVENTO", "Nombre del Evento");
define("_ROT_VISITA_NOMBRE_EVENTO_ERROR", "Nombre del Evento se encuentra vacio.");

define("_ROT_VISITA_FECHA_EVENTO", "Fecha del Evento");
define("_ROT_VISITA_FECHA_EVENTO_ERROR", "Fecha del Evento se encuentra vacio.");

define("_ROT_VISITA_HORA_EVENTO", "Hora del Evento");
define("_ROT_VISITA_HORA_EVENTO_ERROR", "Hora del Evento se encuentra vacio.");

define("_ROT_VISITA_PAIS", "País");
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
define("_ROT_SUSCRIPCION_CC_ERROR", "Falta el campo C.C. o tiene caracteres no válidos");
define("_ROT_SUSCRIPCION_EMAIL_ERROR", "Falta el Correo");
define("_ROT_SUSCRIPCION_EMAIL_ERROR2", "La sintaxis del Correo no es válido");
define("_ROT_SUSCRIPCION_TELEFONO_ERROR", "Falta el Teléfono o tiene caracteres no válidos");
define("_ROT_SUSCRIPCION_DIRECCION_ERROR", "Falta la Dirección");
define("_ROT_SUSCRIPCION_CIUDAD_ERROR", "Falta la Ciudad");
define("_ROT_SUSCRIPCION_FECHA_SUSCRIPCION_ERROR", "Falta la fecha desde la cuál desea suscribirse");
define("_ROT_SUSCRIPCION_TIEMPO_SUSCRIPCION_ERROR", "Falta el tiempo de su suscripción");
define("_ROT_SUSCRIPCION_COMENTARIO_ERROR", "Falta el comentario");

define("_ROT_SUSCRIPCION_ENVIO_CONFIRMA", "Se envió el mensaje correctamente");
define("_ROT_SUSCRIPCION_ENVIO_ERROR", "No se pudo enviar el mensaje. Por favor intentelo mas tarde.");

/**
 * Servicios (Visitas)
 **/
define("_ROT_SERVICIO_NOMBRE_INSTITUCION_ERROR", "Falta el Campo 'Nombre de la Institución'");
define("_ROT_SERVICIO_NOMBRE_SOLICITANTE_ERROR", "Falta el Campo 'Nombre del Solicitante'");
define("_ROT_SERVICIO_APELLIDO_SOLICITANTE_ERROR", "Falta el Campo 'Apellido del Solicitante'");
define("_ROT_SERVICIO_DIRECCION_ERROR", "Falta el Campo 'Dirección'");
define("_ROT_SERVICIO_TELEFONO_ERROR", "Falta el Campo 'Teléfono'. Ingrese sólo números por favor.");
define("_ROT_SERVICIO_CORREO_ERROR", "Falta el Campo 'Correo'");
define("_ROT_SERVICIO_CORREO_ERROR2", "La sintaxis del Correo no es válido");
define("_ROT_SERVICIO_PAIS_ERROR", "Falta el Campo 'País'");
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
//Rotulos cabezote
define("_ROT_INICIO","Inicio");

//Rotulos laterales
define("_ROT_DESTACADOS","Destacados");
define("_ROT_ENLACES","Enlaces Institucionales");
define("_ROT_INCORPORACIONES","Incorporaciones");
define("_ROT_VIDEOS","Videos");
define("_ROT_PREGUNTAS","Preguntas Frecuentes");

//Rotulos Home
define("_ROT_AUTOR","Por");
define("_ROT_VERMAS","ver m&aacute;s");
define("_ROT_PUBLICADO","Publicado el d&iacute;a");
define("_ROT_ACTUALIZACION","&Uacute;ltima actualización");
define("_ROT_HORA_COLOMBIANA","Hora Legal Colombiana");


//Rotulos Default
define("_ROT_IMAGEN","Ampliar Imagen");

//Rotulos Galería de Imagen
define("_ROT_VERIMAGEN","Ver Imagen");
define("_ROT_TITLE_IMAGEN","Ver imagen completa");
define("_ROT_INFORMACION","Informaci&oacute;n");
define("_ROT_TITLE_INFORMACION","Informaci&oacute;n de la categor&iacute;a");

//Rotulos Paginación
define("_ROT_PRIMERO","Primero");
define("_ROT_ANTERIOR","Anterior");
define("_ROT_SIGUIENTE","Siguiente");
define("_ROT_ULTIMO","&Uacute;ltimo");


?>