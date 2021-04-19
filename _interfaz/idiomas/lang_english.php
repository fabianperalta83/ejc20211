<?php
/**
 * Archivo: config.php
 * Descripcion: Configuración de todas la variables del sistema.
 */

 // Modifique UNICAMENTE la informacion entre parentesis DESPUES de la coma
 // NO modifique la palabra en mayúsculas

// Archivo restriccion.php
define("_R_IDIOMA","en_US");
define("_ROT_PAGINA_INEXISTENTE" ,"Maybe the page you want to see is diasble<br>Please contact the webmaster.");
define("_ROT_MENSAJE_RESTRICCION","Page restricted level");
define("_ROT_PAGINA_RESTRINGIDA" ,sprintf(str_replace("  "," ","<ul>
		<li>To access our portal's services you must register <a href=index.php?idcategoria=%s><span class=tpl_titulo_mensaje_error><b>here</b></span></a>
		<li><b>Username</b> and <b>password</b> will automatically be sent to your e-mail.
		</ul>"),_SREGISTRO));

// Idioma principal del documento
define("_ROT_LANG", "en");

//Calendario
define("_ENERO"		,"January");
define("_FEBRERO"	,"February");
define("_MARZO"		,"March");
define("_ABRIL"		,"April");
define("_MAYO"		,"May");
define("_JUNIO"		,"June");
define("_JULIO"		,"July");
define("_AGOSTO"	,"August");
define("_SEPTIEMBRE","September");
define("_OCTUBRE"	,"October");
define("_NOVIEMBRE"	,"November");
define("_DICIEMBRE"	,"December");
define("_LUNES"		,"Monday");
define("_MARTES"	,"Tuesday");
define("_MIERCOLES"	,"Wednesday");
define("_JUEVES"	,"Thursday");
define("_VIERNES"	,"Friday");
define("_SABADO"	,"Saturday");
define("_DOMINGO"	,"Sunday");


define("_ROT_MIGAS"		,"You are here:");
define("_ROT_CERRARVENTANA"		,"Close this window");
define("_ROT_VER_MAS"	,"Read More");
define("_ROT_TOP_PAGINA"	,"Top of this Page");
define("_ROT_IMPRIMIR_PAGINA","Print this Page");
define("_ROT_BOLETIN_TXT_1","Write Your email to receive our BBS.");

define("_ROT_ENCUESTA1"   ,"Choose an Option and vote!");
define("_ROT_ENCUESTA2"   ,"Voting Results");
define("_ROT_ENCUESTA3"   ,"Total Votes");
define("_ROT_REDIRECCION","Redirected to another inner section");
define("_ROT_DOWNLOAD"   ,"Make click in the bond to open the file.<br>In order to keep it in your hard disk makes click<br>with the right click and choose<br> \"save as...\"<br>");
define("_ROT_CADUCIDAD"  ,"Although this information is not considered effective, continues in the historical file of the Web site");

// Archivo contacto.php
define("_ROT_ADVERTENCIA"		  ,"WARNING");
define("_ROT_REGISTRO_CEL_ERROR4"              ,"Cell is empty");
define("_ROT_REGISTRO_CEL_ERROR2"			  ,"Please check the syntax of the cell");
define("_ROT_REGISTRO_CEL"					 ,"Celular:");

define("_ROT_ERROR"				,"ERROR");
define("_ROT_CONFIRMACION"		 ,"CONFIRMATION");
define("_ROT_CONTACTO_LABEL","Contact");
define("_ROT_CONTACTO_NOMBRE"	  ,"Name:");
define("_ROT_CONTACTO_NOMBRE_ERROR","Name is empty");
define("_ROT_CONTACTO_EMAIL"	  ,"e-mail:");
define("_ROT_CONTACTO_EMAIL_ERROR1","You have to write the e-mail");
define("_ROT_CONTACTO_EMAIL_ERROR2","e-mail address is invalid");
define("_ROT_CONTACTO_EMAIL_ERROR3","Your e-mail is already registered in our system, Please enter another e-mail address.");
define("_ROT_CONTACTO_EMPRESA"	  ,"Activity/Office/Profession:");
define("_ROT_CONTACTO_EMPRESA_ERROR","Activity is empty");
define("_ROT_CONTACTO_CARGO"	  ,"Position:");
define("_ROT_CONTACTO_CARGO_ERROR","Position is empty");
define("_ROT_CONTACTO_DIRECCION"	  ,"Address:");
define("_ROT_CONTACTO_DIRECCION_ERROR","Address is empty");
define("_ROT_CONTACTO_TELEFONOS"	  ,"Phone Number:");
define("_ROT_CONTACTO_TELEFONOS_ERROR","Phone Number is empty");
define("_ROT_CONTACTO_COMENTA"	  ,"Commentaries:");
define("_ROT_CONTACTO_COMENTA_ERROR","Commentaries is empty");
define("_ROT_CONTACTO",			  "<ul><li>We are interested on your opinions, suggests, and questions.
									 <li>The fields <span id=\"fieldRequired\">stood out</span> are critical.</ul>");
define("_ROT_CONTACTO_ADVERTENCIA","We have an error sending the form!<br>Please check your information");
define("_ROT_CONTACTO_REQUERIDO","(Required)");
define("_ROT_CONTACTO_ENVIO_CONFIRMA"   ,"The message was sent to <b>%s</b>, thank you for your time");
define("_ROT_CONTACTO_ENVIO_ERROR","An error happened sending the message to <b>%s</b>,<br>please try later or use your normal mail client program");

// Archivo registro.php

define("_ROT_REGISTRO","<ul><li>The registry allows you to obtain but data on our events
							<li>The registry is <B>FREE!</B>
							<li>Your username and password will be send at your email
							<li>The fields <span id=\"fieldRequired\">stood out</span> are obligatory.</ul>");
define("_ROT_MICUENTA"						   ,"This is your Personal Information, dont forget to change the password periodically.<br>The fields <span id=\"fieldRequired\">stood out</span> are obligatory.");
define("_ROT_MICUENTA_ACTUALIZACION"			 ,"CONFIRMATION!");
define("_ROT_REGISTRO_USERNAME"				  ,"Username:");
define("_ROT_REGISTRO_USERNAME_ERROR"			,"Username is empty");
define("_ROT_REGISTRO_NOMBRE"					,"Name:");
define("_ROT_REGISTRO_NOMBRE_ERROR"			  ,"Name is empty");
define("_ROT_REGISTRO_PASSWORD_ACTUAL"          ,"Current Password:");
define("_ROT_REGISTRO_PASSWORD1"				 ," New Password:");
define("_ROT_REGISTRO_PASSWORD2"				 ,"Confirm password:");
define("_ROT_REGISTRO_PASSWORD_EXITO"            ,"Password modified sucessfully !!!");
define("_ROT_REGISTRO_PASSWORD_ERROR1"		   ,"Password is empty");
define("_ROT_REGISTRO_PASSWORD_ERROR2"		   ,"Confirml password is empty");
define("_ROT_REGISTRO_PASSWORD_ERROR3"		   ,"The password and the confirmed password does not match");
define("_ROT_REGISTRO_PASSWORD_ERROR4"           ,"The password could not be changed");
define("_ROT_REGISTRO_PASSWORD_ERROR5"           ,"Current password did not match !!!");
define("_ROT_REGISTRO_APELLIDO"				  ,"Last Name:");
define("_ROT_REGISTRO_APELLIDO_ERROR"			,"Last Name is empty");
define("_ROT_REGISTRO_EMAIL"					 ,"Email:");
define("_ROT_REGISTRO_EMAIL_ERROR1"			  ,"Email is empty");
define("_ROT_REGISTRO_EMAIL_ERROR2"			  ,"Wrong Email");
define("_ROT_REGISTRO_EMAIL_ERROR3"			  ,"Pay contact E-mail is not valid");
define("_ROT_REGISTRO_EMPRESA"				   ,"Company's Name :");
define("_ROT_REGISTRO_EMPRESA_ERROR"			 ,"Company's Name is empty'");
define("_ROT_REGISTRO_CIUDAD"					,"City:");
define("_ROT_REGISTRO_CIUDAD_ERROR"			  ,"City is empty");
define("_ROT_REGISTRO_PAIS"					  ,"Country:");
define("_ROT_REGISTRO_PAIS_ERROR"				,"Country is empty");
define("_ROT_REGISTRO_PROFESION"				 ,"Profession:");
define("_ROT_REGISTRO_PROFESION_ERROR"		   ,"Profession");
define("_ROT_REGISTRO_TELEFONO"				  ,"Phone:");
define("_ROT_REGISTRO_TELEFONO_EMPRESA"		  ,"Phones:<ul class=texto_mini><li>Puede escribir varios si lo desea<li>Escriba la extensión<li>No escriba indicativos</ul>");
define("_ROT_REGISTRO_FAX_EMPRESA"			   ,"Fax:");
define("_ROT_REGISTRO_TELEFONO_ERROR"			,"Phone is empty");
define("_ROT_REGISTRO_DIRECCION"				 ,"Address:");
define("_ROT_REGISTRO_DIRECCION_ERROR"		   ,"Address is empty");
define("_ROT_REGISTRO_CARGO"					 ,"Position:");
define("_ROT_REGISTRO_EVENTOS"				   ,"Subjects on which you would like to receive but informationn:");
define("_ROT_REGISTRO_EMPRESA_NIT"			   ,"Nit:");
define("_ROT_REGISTRO_EMPRESA_ACTIVIDAD"		 ,"Economic activity:");
define("_ROT_REGISTRO_EMPRESA_MEDIO"			 ,"How did you hear from us?:");
define("_ROT_REGISTRO_EMPRESA_MEDIO_OTRO"		,"If you chose other, please tell us which one:");
define("_ROT_REGISTRO_REQUERIDO"	,"(Requerido)");
define("_ROT_REGISTRO_CORREO"	   ,"Would you like to recieve further information by e-mail?");
define("_ROT_REGISTRO_RED"		  ,"I wish to Subscribe to Red de Medios para la Paz");
define("_ROT_REGISTRO_ADVERTENCIA"  ,"Please check the information");
define("_ROT_REGISTRO_ADVERTENCIA2"  ,"Your information WAS NOT updated.");
define("_ROT_REGISTRO_EXISTENTE"	,"Someone has already registered with that e-mail. Please choose another one.");
define("_ROT_REGISTRO_EXISTENTE2"	,"Someone has already registered with that user name. Please choose another one.");
define("_ROT_REGISTRO_EXITO"		,"Your information was successfully updated");

define("_ROT_REGISTRO_RECORDAR","<b>¿Already registered but forgot your username or password?</b><br>Give us the e-mail with which you registered, and we'll send your account information back to you.");

// Archivo buscar.php
define("_ROT_BUSCAR"			,"Search");
define("_ROT_BUSCAR_TXT"		,"The searching is restricted<br>to the information that this page has.");
define("_ROT_BUSCAR_PALABRA"	,"Word to Search");
define("_ROT_BUSCAR_RESULTADOS"	,"%s results were found related to <span style=\"color:green;\"><em>%s</em></span>");
define("_ROT_BUSCAR_ADVERTENCIA","An error happend in the process!<br>Please check the information");
define("_ROT_BUSCAR_ADVERTENCIA_MENSAJE"	  ,"The word must have at least 3 letters");


//Variable en MostrarCuentele
define("_ROT_CUEN_TIT","Mail to a Friend");
define("_ROT_CUEN_MEN1","Your email:");
define("_ROT_CUEN_MEN2","Friend's email:");
define("_ROT_CUEN_CUERPO","Sends you the following comment:\n\n");
define("_ROT_CUEN_CUERPO1","Dear friend:\nThank you for recommending us.\nKeep inviting your friends to make part of this project.\nSincerely,\nNavegantes Virtuales Work Team.");
define("_ROT_CUEN_CUERPO2","Check this page");
define("_ROT_CUEN_CUERPO3","Thanks for recomend us");
define("_ROT_CUEN_CUERPO4","\nEmail del destinatario:");
define("_ROT_CUEN_NOTIFICACION","Notification: Page Recomendation");
define("_ROT_CUEN_ENVIADO","Message Sent.<br>Thank you");
define("_ROT_RECOMENDAR_NOTICIA","Recomend this news");

// Variables para Login
define("_ROT_LOGIN","Please provide your user name and password");
define("_ROT_LOGIN_USUARIO"	,"User: ");
define("_ROT_LOGIN_PASSWORD"   ,"Password: ");
define("_ROT_LOGIN_CAPTCHA","Enter captcha value: ");
define("_ROTT_LOGIN_IMG_CAPTCHA","Captcha Image: ");

// Variables para Mapa
define("_ROT_MAPA_GENERAL"	 ,"General");
define("_ROT_MAPA_DETALLADO"   ,"Detailed");
define("_ROT_MAPA_COMPLETO"	,"Complete");

// Variables Edición
define("_ROT_EDICION"			,"The fields <span id=\"fieldRequired\">with this color</span> are a must");
define("_ROT_EDICION_ERROR"	  ,"The category's name is a must");
define("_ROT_EDICION_ANTETITULO" ,"Antetitle:");
define("_ROT_EDICION_NOMBRE"	 ,"Name:");
define("_ROT_EDICION_SUBTITULO"  ,"Subtitle:");
define("_ROT_EDICION_RESUMEN" ,"Resume:");
define("_ROT_EDICION_CONTENIDO"  ,"Content:");
define("_ROT_EDICION_AUTOR"	  ,"Author:");
define("_ROT_EDICION_IMAGEN"	 ,"Image:");
define("_ROT_EDICION_ACTIVA"	 ,"Active:");
define("_ROT_EDICION_ORDEN"	  ,"Order:");
define("_ROT_EDICION_FECHA1"	 ,"Date of Create/Update:");
define("_ROT_EDICION_FECHA2"	 ,"Maximum Date on Home:");
define("_ROT_EDICION_FECHA3"	 ,"Date 3:");
define("_ROT_EDICION_RESTRINGIDA","Restrict all user except:");
define("_ROT_EDICION_TIPOSECCION","Main type:");
define("_ROT_EDICION_TIPOSECCION_SUB","Subcategories type:");
define("_ROT_EDICION_TEMPLATE"   ,"Template:");
define("_ROT_EDICION_PLANTILLA"   ,"Layout:");
define("_ROT_EDICION_CRITERIO_ORDENA"   ,"Subcategories Order Criteria:");
define("_ROT_EDICION_TIPO_ORDENA"   ,"Subcategories Order Type:");
define("_ROT_EDICION_NUMERO_SUB"   ,"Maximum quantity of subcategories/page:");
define("_ROT_EDICION_NUMERO_SUB_INFO"   ,"Put 0 to inherit the value");
define("_ROT_EDICION_ESROOT"   ,"Home:");
define("_ROT_EDICION_ENBUSQUEDA"	,'Visible in a Search:');
define("_ROT_EDICION_ENMAPA"	,'Visible in the Map:');
define("_ROT_EDICION_IDIOMA"	,'Category Language:');
define("_ROT_EDICION_ESRSS"     ,"RSS Channel:");
define("_ROT_INDEXAR"     ,"Index File:");

define("_ROT_EDICION_VOLVER"   ,"Click here to go back to normal mode");
define("_ROT_SUBMENU_EDICION"   ,"Subcategories");

//Encuestas
define("_ROT_ENCUESTA"   ,"Encuesta");
define("_ROT_ENCUESTA_RESULTADO"   ,"Results");
define("_ROT_ENCUESTA_VOTAR"   ,"Vote");

//FOROS
define("_ROT_FORO_RESPUESTA"	,"You are answering to:");
define("_ROT_FORO_AUTOR"		,"Posted by");
define("_ROT_FORO_NOMBRE"	   ,"Name:");
define("_ROT_FORO_RESPONDER"	,"Respond");

/**
 * Quejas y Reclamos
 **/
define("_ROT_QUEJAS"            ,"You can report any complaints, statements and grievances here.
 		   						  They will be received by the Army’s Inspector General. <br><br>
			   					  Please enter the following information and press the Send button.
								  (Data marked with * are required)<br><br>This page is not the addressee of these messages and as an intermediary; it has no jurisdiction to act. Individuals who use this service are accountable for the veracity and accuracy of their allegations, if false or inaccurate reporting, the individual may face criminal prosecution.
								  When complaints or claims meet the requirements specified by law to exercise the right of petition, it will be treated as such under applicable Laws.<br><br>The <span id=\"fieldRequired\">highlighted</span> fields are mandatory");
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

//Template Noticia Avanzado
define("_ROT_FILTRO_FECHAS","Find by Date:");
define("_ROT_FILTRO_FECHAS_TODOS","View All");
define("_ROT_FILTRO_FECHAS_SUBMIT","go");

/**
 * Formato de datetotext
 **/
define('FORMAT_DATETOTEXT', '%B %d, %Y');

/**
 * Rotulos de los Meses de las Fechas del Filtro Avanzado
 **/
define("_ROT_FILTRO_BUSCAR", "Search");
define("_ROT_FILTRO_FECHA", "View All");
define("_ROT_FILTRO_FECHA_ENERO", "January");
define("_ROT_FILTRO_FECHA_FEBRERO", "Febrary");
define("_ROT_FILTRO_FECHA_MARZO", "March");
define("_ROT_FILTRO_FECHA_ABRIL", "April");
define("_ROT_FILTRO_FECHA_MAYO", "May");
define("_ROT_FILTRO_FECHA_JUNIO", "June");
define("_ROT_FILTRO_FECHA_JULIO", "July");
define("_ROT_FILTRO_FECHA_AGOSTO", "August");
define("_ROT_FILTRO_FECHA_SEPTIEMBRE", "September");
define("_ROT_FILTRO_FECHA_OCTUBRE", "October");
define("_ROT_FILTRO_FECHA_NOVIEMBRE", "November");
define("_ROT_FILTRO_FECHA_DICIEMBRE", "December");

//Shared Responsibility
define("_ROT_NEWSFLASH","NEWSFLASH");
define("_ROT_FEATURED","Featured Content");
define("_ROT_MOREFACTS","More Facts");
define("_ROT_LATESTNEWS","Latest News");
define("_ROT_MOREHELPS","More Ways to Help");
define("_ROT_MOREVICTIMS","More Transformations");
define("_ROT_JOINNEWS",	"Join our newsletter to receive news and updates about this site.");
define("_ROT_GRJOINNEWS","Thank you. Your request has been processed and soon you will recieve our newsletter");

// Cabezote
define("_ROT_GO_CONTENT","Go to content");
define("_ROT_INICIO","Home");
define("_ROT_DESCARGA","This website uses Macromedia Flash to display some of its content.  You can download the plugin");
define("_ROT_AQUI","here");
define("_ROT_HORA_LEGAL", "Current local time in Colombia");
define("_ROT_NOSCRIPT", "Your browser does not support JavaScript!");
define("_ROT_NAV_TOOLS", "Navigation bar tools");
define("_ROT_SKIP_TOOLS", "Skip the navigation toolbar");
define("_ROT_END_TOOLS", "End navigation bar tools");

define("_ROT_IMAGENES", "Images");
define("_ROT_VIDEO", "Video");
define("_ROT_AUDIO", "Audio");


// Laterales
define("_ROT_MENU_INST","<span>Institutional </span>Menu");
define("_ROT_MENU_INSTITUCIONAL","Main Menu");
define("_ROT_NAV_INST","Institutional Navigation");
define("_ROT_SKIP_INST","Skip the navigation Institutional");
define("_ROT_END_OF","End of");
define("_ROT_END_MENU_INST","End of Institutional Menu");
define("_ROT_GO_TO","Go to");
define("_ROT_AMPLIAR_NOTA","More");


define("_ROT_RECOMENDADOS","Recommended Sections");
define("_ROT_NAV_RECOMENDADOS","Navigation bar Recommended Sections");
define("_ROT_SKIP_RECOMENDADOS","Skip navigation bar Recommended Sections");
define("_ROT_END_RECOMENDADOS","End navigation bar Recommended Sections");
define("_ROT_ENLACES","Links");
define("_ROT_INCORPORACIONES","Incorporations");
define("_ROT_VIDEOS","Videos");
define("_ROT_PREGUNTAS","Frequent Questions");
define("_ROT_CATEGORIA_DESTACADA","Highlighted Category");

// Menu usuario
define("_ROT_MENU_USER","User Menu");
define("_ROT_NAV_USER", "User menu");
define("_ROT_SKIP_USER", "Skip user menu");
define("_ROT_END_MENU_USER", "End user menu");
define("_ROT_ADMIN", "Administraci&oacute;n");
define("_ROT_VER_PAGINA", "Ver p&aacute;gina");
define("_ROT_EDITAR_PAGINA", "Editar esta p&aacute;gina");
define("_ROT_MI_PORTAL", "Mi portal");
define("_ROT_TERMINAR_SESION", "Terminar Sesi&oacute;n");

// Nube
define("_ROT_TAG_CLOUD", "Tag cloud");
define("_ROT_RELATED_TAGS", "Most Viewed");
define("_ROT_NAV_CLOUD", "Navigation bar of the tag cloud");
define("_ROT_SKIP_CLOUD", "Skip navigation bar on the tag cloud");
define("_ROT_END_CLOUD", "End of the navigation bar tag cloud");

// Migas
define("_ROT_BREAD_CRUMBS", "Breadcrumbs");
define("_ROT_NAV_BREAD_CRUMBS", "Breadcrumbs Navigation bar");
define("_ROT_BREAD_CRUMBS_HERE", "You are here:");
define("_ROT_SKIP_BREAD_CRUMBS", "Skip Breadcrumbs navigation bar");
define("_ROT_END_BREAD_CRUMBS", "End Breadcrumbs navigation bar");

// Home y Home Generico
define("_ROT_CONTENT","Content");
define("_ROT_AUTOR","By");
define("_ROT_VERMAS_HOME","More information");
define("_ROT_VERMAS","More");
define("_ROT_AMPLIAR","More");
define("_ROT_PUBLICADO","Date");
define("_ROT_ACTUALIZACION","Last Update");
define("_ROT_END_SECTION","End of Section");

// Pie
define("_ROT_DESTACADOS","Highlights");
define("_ROT_NAV_HIGHLIGHTS","Navigation bar sections highlighted");
define("_ROT_SKIP_HIGHLIGHTS","Skip navigation bar sections highlighted");
define("_ROT_END_HIGHLIGHTS","End navigation bar sections highlighted");
define("_ROT_INSTITUCIONES","State Institutions");
define("_ROT_NAV_INSTITUCIONES","Navigation bar of the State institutions");
define("_ROT_SKIP_INSTITUCIONES","Skip the Institutions of the State");
define("_ROT_END_INSTITUCIONES", "End of State Institutions");
define("_ROT_INFO_COMPANY","Information of Entity");
define("_ROT_DEVELOPED","Portal design by");
define("_ROT_GOTO","Go to page");
define("_ROT_LOGO","Logo de la empresa Micrositios Ltda.");


// Default
define("_ROT_IMAGEN","Enlarge Image");
define("_ROT_AMPLIAR_IMAGEN","View image in original size");
define("_ROT_SUBCATEGORIAS","Related Links");
define("_ROT_UTILIDADES","Utilities");
define("_ROT_INICIO_PAGINA","Go to the top of this page");
define("_ROT_IMPRIMIR","View in printer friendly format");
define("_ROT_ENVIAR_AMIGO","Recommend this section to a friend");

// Lista en cuadros
define("_ROT_SUMMARY","Summarized categories organized by charts");

// Galeria de imagenes
define("_ROT_VERIMAGEN","Image");
define("_ROT_TITLE_IMAGEN","View Image");
define("_ROT_INFORMACION","Information");
define("_ROT_TITLE_INFORMACION","Category Information");

// Galeria de audio
define("_ROT_ESCUCHAR","Listen");

// Galeria de video
define("_ROT_VER_VIDEO","Ver Video");

// Paginacion
define("_ROT_PAGER","Pager");
define("_ROT_NAV_PAGER","Navigation Bar Pager");
define("_ROT_SKIP_PAGER", "Skip navigation bar Pager");
define("_ROT_END_PAGER", "End Navigation Bar Pager");
define("_ROT_PRIMERO","First");
define("_ROT_ANTERIOR","Previous");
define("_ROT_SIGUIENTE","Next");
define("_ROT_ULTIMO","Last");

// Descarga
define("_ROT_DESCARGAR","Descargar");

// url con marco
define("_ROT_VOLVER","Go Back");

// Calendario
define("_ROT_CALENDARIO_MESES","Select Month to see Events");
?>