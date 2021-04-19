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
define("_R_IDIOMA", 'german');
define("_ROT_PAGINA_INEXISTENTE" ,"Wahrscheinlich ist die Seite, die Sie sehen wollen, deaktiviert<br>Setzen Sie sich bitte mit dem Homepageverwalter in Verbindung");
define("_ROT_MENSAJE_RESTRICCION","Eingeschränkter Zugriff auf diese Seite");
define("_ROT_PAGINA_RESTRINGIDA" ,sprintf(str_replace("  "," ","<ul>
        <li>Um die Leitungen unserer Homepage zu nutzen, müssen Sie Ihren Account anlegen <a href=index.php?idcategoria=%s><span class=tpl_titulo_mensaje_error><strong>hier</strong></span></a>
        <li>El <strong>Nutzer</strong> und das <strong>Password</strong> werden automatisch an Ihre E-Mail gesandt.
        </ul>"),_SREGISTRO));

// Idioma principal del documento
define("_ROT_LANG", "de");

// Archivo funciones.php
define("_ROT_SUBMENU"    ,"");
define("_ROT_SUBMENU_LINEA","");
define("_ROT_SUBMENU_MARCA","");
define("_ROT_SUBMENU_PUBLICACIONES","<strong>TITELSEITE</strong>");
define("_ROT_VER_MAS","Nachtricht lesen");
define("_ROT_BOLETIN_TXT_1","Schreiben Sie Ihre E-Mail, um unsere Newsletter zu erhalten.");

define("_ROT_ENCUESTA1"   ,"Suchen Sie eine Option aus und wählen Sie!");
define("_ROT_ENCUESTA2"   ,"Ergebnisse der Wahl");
define("_ROT_ENCUESTA3"   ,"Gesamtanzahl der Stimmen");
define("_ROT_REDIRECCION","Sie wurden automatisch in einen anderen Abschnitt der Homepage umgeleitet");
define("_ROT_DOWNLOAD"   ,"Klicken Sie den Link an, um die Datei zu öffnen.<br>Um es auf Ihrer Hardplatte zu speichern, klicken Sie<br>mit der rechten Maustaste und wählen Sie<br> \"Ziel speichern als...\"<br>");
define("_ROT_CADUCIDAD"  ,"Obwohl diese Information als nicht gültig betrachtet wird, verbleit sie weiterhin auf der historischen Datei der Homepage");

define("_ROT_ADMIN_DOCUMENTOS"     ,"Dokumentenverwalter");
// Archivo contacto.php
define("_ROT_ADVERTENCIA"          ,"Achtung");
define("_ROT_ERROR"                ,"Fehler");
define("_ROT_CONFIRMACION"         ,"BESTÄTIGUNG");
define("_ROT_CONTACTO_NOMBRE"      ,"Vollständiger Name:");
define("_ROT_CONTACTO_NOMBRE_ERROR","Name fehlt");
define("_ROT_CONTACTO_EMAIL"      ,"E-Mail:");
define("_ROT_CONTACTO_EMAIL_ERROR1","E-Mail fehlt");
define("_ROT_CONTACTO_EMAIL_ERROR2","Die Syntaxe der E-Mail ist nicht korrekt");
define("_ROT_CONTACTO_EMPRESA"      ,"Aktivität / Gewerbe / Beruf:");
define("_ROT_CONTACTO_EMPRESA_ERROR","Aktivität fehlt");
define("_ROT_CONTACTO_CARGO"      ,"Stellung:");
define("_ROT_CONTACTO_CARGO_ERROR","Stellung fehlt");
define("_ROT_CONTACTO_DIRECCION"      ,"Stadt / Land:");
define("_ROT_CONTACTO_DIRECCION_ERROR","Anschrift fehlt");
define("_ROT_CONTACTO_TELEFONOS"      ,"Telefon:");
define("_ROT_CONTACTO_TELEFONOS_ERROR","Telefon fehlt");
define("_ROT_CONTACTO_COMENTA"      ,"Kommentare:");
define("_ROT_CONTACTO_COMENTA_ERROR","Kommentare fehlen");
define("_ROT_CONTACTO",              "<ul><li>Uns interessieren alle Ihre Kommentare, Vorschläge und Fragen.
                                     <li>Die <span id=\"fieldRequired\">markierten Felder</span> sind obligatorisch.</ul>");
define("_ROT_CONTACTO_ADVERTENCIA","DAS FORMULAR WURDE NICHT GESENDET!<br>Überprüfen Sie bitte die Information");
define("_ROT_CONTACTO_REQUERIDO","(Notwendig)");

define("_ROT_CONTACTO_ENVIO_CONFIRMA"   ,"Ihre Nachricht wurde gesendet an <strong>%s</strong>, Vielen Dank für Ihr Interesse");
define("_ROT_CONTACTO_ENVIO_ERROR","Die Nachricht konnte NICHT gesendet werden an <b>%s</b>,<br>Versuchen Sie es bitte später oder nutzen Sie Ihren gewöhnlichen Mailkunden");

// Archivo certificado.php

define("_ROT_CERTIFICADO_NOMBRE"      ,"Vollständiger Name:");
define("_ROT_CERTIFICADO_NOMBRE_ERROR","Name fehlt");
define("_ROT_CERTIFICADO_EMAIL"      ,"E-Mail:");
define("_ROT_CERTIFICADO_EMAIL_ERROR1","E-Mail fehlt");
define("_ROT_CERTIFICADO_EMAIL_ERROR2","Die Syntaxe der E-Mail ist nicht korrekt");
define("_ROT_CERTIFICADO_FECHA"      ,"Antragsdatum:");
define("_ROT_CERTIFICADO_FECHA_ERROR","Datum fehlt");
define("_ROT_CERTIFICADO_CEDULA"      ,"Code oder Ausweis:");
define("_ROT_CERTIFICADO_CEDULA_ERROR","Code oder Ausweis fehlt");
define("_ROT_CERTIFICADO_TIPO"      ,"Art des Antrags:");
define("_ROT_CERTIFICADO_TIPO_ERROR","Art des Antrags fehlt");
define("_ROT_CERTIFICADO_DESTINO"      ,"Bestimmung der Bescheinigung:");
define("_ROT_CERTIFICADO_DESTINO_ERROR","Bestimmung der Bescheinigung fehlt");
define("_ROT_CERTIFICADO_APELLIDO"      ,"VOllständiger Nachname:");
define("_ROT_CERTIFICADO_APELLIDO_ERROR","Nachname fehlt");
define("_ROT_CERTIFICADO_TELEFONOS"      ,"Telefon Antragsteller:");
define("_ROT_CERTIFICADO_TELEFONOS_ERROR","Telefon fehlt");
define("_ROT_CERTIFICADO_DIRECCION"      ,"ständige Anschrift:");
define("_ROT_CERTIFICADO_DIRECCION_ERROR","Anschrift fehlt");
define("_ROT_CERTIFICADOS","<br>Füllen Sie das Formular aus und drücken Sie Senden");
define("_ROT_CERTIFICADO_ADVERTENCIA","Überprüfen Sie bitte die Information");
define("_ROT_CERTIFICADO_REQUERIDO","(Notwendig)");

// Archivo acreedores.php

define("_ROT_ACREEDORES"                     ,"GLÄUBIGER");
define("_ROT_ACREEDORES_TIPOIDENTIFICACION"  ,"Art der Indentifikation:");
define("_ROT_ACREEDORES_IDENTIFICACION"      ,"Identifikation:");
define("_ROT_ACREEDORES_IDENTIFICACION_ERROR","Identifikation fehlt");
define("_ROT_ACREEDORES_CLAVE"               ,"Code:");
define("_ROT_ACREEDORES_REQUERIDO"           ,"(Notwendig)");


// Archivo registro_evento.php
define("_ROT_REGISTRO_FORMA_PAGO_ERROR"      ,"Sie müsse eine Zahlungsart aussuchen");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO1"   ,"Sie sind für dieses Ereignis schon eingetragen");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO2"   ,"Ihnen wurde eine E-Mail auf das Konto geschickt <strong>%s</strong> mit den detaillierten Anweisungen, um Ihr Eintragunsverfahren zu beenden");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO3"   ,"Wenn Sie die Eintragung in dieses Ereignis löschen oder verändern wollen, wenden Sie sich bitte telefonisch an uns.");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA1"   ,"Sobald Sie den  Knopf Senden drücken, können Sie Ihre Eintragung nur noch telefonisch löschen oder verändern");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA2"   ,"Sobald Sie Ihre Eintragung beenden, senden wir Ihnen eine E-MAil zur Bestätigung und detaillierte Beschreibung des Eintragungsverfahrens");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA3"   ,"Diese Transaktion ist durch Beschluss XXXX beschützt und hat Gültigkeit als DDDD");
define("_ROT_INFO"                           ,"Information");


// Archivo registro.php

define("_ROT_REGISTRO","<ul><li>Die Eintragung ermöglicht Ihnen mehr Information über unsere Ereignisse zu erhalten
                            <li>Die Eintragung ist <strong>KOSTENLOS</strong>
                            <li>hr Nutzername und Password werden auf die von Ihnen mitgeteilte E-Mail gesendet
                            <li>Die Felder <span id=\"fieldRequired\">die markeirt sind</span> sind obligatorisch.</ul>");
define("_ROT_MICUENTA"                           ,"Diese Information ist persönlich, bedenken Sie Ih Password periodisch u verändern.<br>Die Felder <span id=\"fieldRequired\">die markeirt sind</span> sind obligatorisch.");
define("_ROT_MICUENTA_ACTUALIZACION"             ,"BESTÄTIGUNG!");
define("_ROT_REGISTRO_USERNAME"                  ,"Nutzername:");
define("_ROT_REGISTRO_USERNAME_ERROR"            ,"Nutzername fehlt");
define("_ROT_REGISTRO_NOMBRE"                    ,"Namen:");
define("_ROT_REGISTRO_NOMBRE_ERROR"              ,"Vornamenfeld  ist leer oder  enthält  unerlaubte Zeichen");
define("_ROT_REGISTRO_PASSWORD_ACTUAL"           ,"Aktuelles Password:");
define("_ROT_REGISTRO_PASSWORD1"                 ,"Password:");
define("_ROT_REGISTRO_PASSWORD2"                 ,"Bestätigen Sie Ihr Password:");
define("_ROT_REGISTRO_PASSWORD_EXITO"            ,"Password erfolgreich verändert!");
define("_ROT_REGISTRO_PASSWORD_ERROR1"           ,"Password fehlt");
define("_ROT_REGISTRO_PASSWORD_ERROR2"           ,"Bestätigung des Password fehlt");
define("_ROT_REGISTRO_PASSWORD_ERROR3"           ,"Das Password und die Bestätigung stimmen nicht überein");
define("_ROT_REGISTRO_PASSWORD_ERROR4"           ,"Password konnte nicht verändert werden.");
define("_ROT_REGISTRO_PASSWORD_ERROR5"           ,"Das aktuelle PAssword stimmt nicht überein, überprüfen Sie bitte!");
define("_ROT_REGISTRO_APELLIDO"                  ,"Nachnamen:");
define("_ROT_REGISTRO_APELLIDO_ERROR"            ,"Der Nachname ist leer oder hat nicht erlaubte Zeichen");
define("_ROT_REGISTRO_EMAIL"                     ,"E-Mail:");
define("_ROT_REGISTRO_EMAIL_ERROR1"              ,"E-Mail fehltl");
define("_ROT_REGISTRO_EMAIL_ERROR2"              ,"Die Sytaxe der E-Mail ist nicht korrekt");
define("_ROT_REGISTRO_EMAIL_ERROR3"              ,"Die Syntaxe der E-Mail des Kontaktes für die ZAHLUNG ist nicht korrelt");
define("_ROT_REGISTRO_EMPRESA"                   ,"Firmenname (Firmenbezeichnung):");
define("_ROT_REGISTRO_EMPRESA_ERROR"             ,"Firma fehlt");
define("_ROT_REGISTRO_CIUDAD"                    ,"Satdt:");
define("_ROT_REGISTRO_CIUDAD_ERROR"              ,"Stadt fehlt");
define("_ROT_REGISTRO_PAIS"                      ,"Land:");
define("_ROT_REGISTRO_PAIS_ERROR"                ,"Land fehlt");
define("_ROT_REGISTRO_PROFESION"                 ,"Beruf:");
define("_ROT_REGISTRO_PROFESION_ERROR"           ,"Beruf fehlt");
define("_ROT_REGISTRO_TELEFONO"                  ,"Telefon:");
define("_ROT_REGISTRO_TELEFONO_EMPRESA"          ,"Telefone:<ul class=texto_mini><li>Sie können, falss gewünscht, mehrere schreiben<li>Schreiben Sie die Durchwahl auf<li>Geben Sie keine Vorwahlen an</ul>");
define("_ROT_REGISTRO_FAX_EMPRESA"               ,"Fax:");
define("_ROT_REGISTRO_TELEFONO_ERROR"            ,"Telefon fehlt");
define("_ROT_REGISTRO_DIRECCION"                 ,"Anschrift:");
define("_ROT_REGISTRO_DIRECCION_ERROR"           ,"Anschrift fehlt");
define("_ROT_REGISTRO_CARGO"                     ,"Stellung:");
define("_ROT_REGISTRO_EVENTOS"                   ,"Themen, über die Sie gern mehr Information erhalten würden:");
define("_ROT_REGISTRO_EMPRESA_NIT"               ,"Steuernummer:");
define("_ROT_REGISTRO_EMPRESA_ACTIVIDAD"         ,"Wirtschaftsaktivität:");

define("_ROT_REGISTRO_EMPRESA_MEDIO"             ,"Mittel, durch welches Sie über unsere Ereignisse erfuhren:");
define("_ROT_REGISTRO_EMPRESA_MEDIO_OTRO"        ,"Wenn Sie Andere AusgewÄhlt haben, nennen Sie bitte welches:");

define("_ROT_REGISTRO_REQUERIDO"    ,"(Notwendig)");
define("_ROT_REGISTRO_CORREO"       ,"Möchten Sie unsere Information per E-Mail erhalten?");
define("_ROT_REGISTRO_RED"          ,"Ich möchte mich in das Netz der Mittel für den Frieden eintragen");
define("_ROT_REGISTRO_ADVERTENCIA"  ,"Überprüfen Sie bitte die Information");
define("_ROT_REGISTRO_ADVERTENCIA2"  ,"Ihre Information wurde nicht aktualisiert");
define("_ROT_REGISTRO_EXISTENTE"    ,"Es ist bereits ein User mit dieser E-Mail eingetragen. Benuten Sie bitte ein anderes.");
define("_ROT_REGISTRO_EXISTENTE2"    ,"Es ist bereits ein Nutzer mit diesem Nutzername eingetragen. Benutzen Sie bitte ein anderes.");
define("_ROT_REGISTRO_EXITO"        ,"Ihre Information wurde korrekt aktualisiert");

define("_ROT_REGISTRO_RECORDAR","<strong>¿Sind sie bereits eingetragen, Sie haben jedoch Ihren Nutzername oder Password vergessen?</strong><br>Schreiben Sie hier bitte Ihre E-Mail ein , mit der Sie sich eingetragen haben.");

// Archivo buscar.php
define("_ROT_BUSCAR"            ,"Suhen");
define("_ROT_BUSCAR_TXT"            ,"Die Suche ist begrenzt<br>auf die auf dieser Seite enthaltene Information.");
define("_ROT_BUSCAR_PALABRA"    ,"Zu suchendes Wort");
define("_ROT_BUSCAR_RESULTADOS" ,"Es wurden %s Ergebnisse gefunden, in Bezug auf <span style=\"color:green;\"><em>%s</em></span>");
define("_ROT_BUSCAR_ADVERTENCIA","DIE SUCHE KONNTE NICHT ERFOLGEN!<br>Überprüfen Sie bitte die Information");
define("_ROT_BUSCAR_ADVERTENCIA_MENSAJE"      ,"Das zu suchende Wort muss drei oder mehr Buchstaben enthalten");


//Variable en MostrarCuentele
define("_ROT_CUEN_TIT","Erzählen Sie einem Freund");
define("_ROT_CUEN_MEN1","Ihre E-Mail-Adresse:");
define("_ROT_CUEN_MEN2","E-Mail Ihres Freundes:");
define("_ROT_CUEN_CUERPO","Sendet Dir folgendes Kommntar:\n\n");
define("_ROT_CUEN_CUERPO1","Lieber Freund:\nDanke dass Sie uns weiterempfehlen.\nLade weiterhin Deinen Freunde ein, Teil dieses Projektes zu sein.\nMit freundlichem Gruss,\nArbeitsteam virtuelle Surfer.");
define("_ROT_CUEN_CUERPO2","Überprüfe diese Page");
define("_ROT_CUEN_CUERPO3","Danke für die Weitermpfehlung");
define("_ROT_CUEN_CUERPO4","\nE-Mail des Empfängers:");
define("_ROT_CUEN_NOTIFICACION","Benachrichtigung: Empfehlung auf der Page");
define("_ROT_CUEN_ENVIADO","Gesandte Nachricht.<br>Danke");
define("_ROT_RECOMENDAR_NOTICIA","Empfehle diese Nachricht");

// Variables para Emisoras
define("_ROT_EMISORA_NOMBRE","Name");
define("_ROT_EMISORA_RESUMEN","Beschreibung");
define("_ROT_EMISORA_IDENTIFICACION","Indentifikaiton");
define("_ROT_EMISORA_URL","Wegpage");
define("_ROT_EMISORA_EMAIL","E-Mail");

// Variables para Login
define("_ROT_LOGIN","Schreiben Sie Ihren Nutzername und Ihr Password");
define("_ROT_LOGIN_USUARIO"    ,"Nutzer: ");
define("_ROT_LOGIN_PASSWORD"   ,"Password: ");

// Variables para Mapa
define("_ROT_MAPA_GENERAL"     ,"Allgemein");
define("_ROT_MAPA_DETALLADO"   ,"Detailliert");
define("_ROT_MAPA_COMPLETO"    ,"Vollständiges");

// Variables Edición
define("_ROT_EDICION"            ,"Die Felder, <span id=\"fieldRequired\">die markiert sind</span> sind obligatorisch");
define("_ROT_EDICION_ERROR"      ,"Der Name der Kategorie ist obligatorisch");
define("_ROT_EDICION_ANTETITULO" ,"Vortitel:");
define("_ROT_EDICION_NOMBRE"     ,"Name:");
define("_ROT_EDICION_SUBTITULO"  ,"Untertitel:");
define("_ROT_EDICION_RESUMEN" ,"Zusammenfassung:");
define("_ROT_EDICION_CONTENIDO"  ,"Inhalt:");
define("_ROT_EDICION_AUTOR"      ,"Autor:");
define("_ROT_EDICION_IMAGEN"     ,"Bild:");
define("_ROT_EDICION_ACTIVA"     ,"Aktiv:");
define("_ROT_EDICION_ORDEN"      ,"Auftrag:");
define("_ROT_EDICION_FECHA1"     ,"Erstellungs- / Aktualisierungsdatum:");
define("_ROT_EDICION_FECHA2"     ,"Höchstdatum im Home:");
define("_ROT_EDICION_FECHA3"     ,"Datum 3:");
define("_ROT_EDICION_RESTRINGIDA","Alle User einschränken, bis auf:");
define("_ROT_EDICION_TIPOSECCION","Haupttitel:");
define("_ROT_EDICION_TIPOSECCION_SUB","Art der Unterkategorien:");
define("_ROT_EDICION_TEMPLATE"   ,"Graphisches Template:");
define("_ROT_EDICION_PLANTILLA"   ,"Grafische Vorlage:");
define("_ROT_EDICION_CRITERIO_ORDENA"   ,"Kennzeichen der Anordnung der Unterkategorien:");
define("_ROT_EDICION_TIPO_ORDENA"   ,"Art der Anordnung der Unterkategorien:");
define("_ROT_EDICION_NUMERO_SUB"   ,"Maximale Anzahl der Unterkategorien pro Seite:");
define("_ROT_EDICION_ESROOT"   ,"Ist Home:");
define("_ROT_EDICION_NUMERO_SUB_INFO"   ,"Lassen Sie 0, um den Wert zu erben");
define("_ROT_EDICION_ENBUSQUEDA"	,'Sichtbar in der Suche:');
define("_ROT_EDICION_ENMAPA"	,'Sichtbar auf der Homepagestruktur:');
define("_ROT_EDICION_IDIOMA"	,'Sprache der Kategorie:');
define("_ROT_EDICION_ESRSS"     ,"Ist RSS:");
define("_ROT_INDEXAR"     ,"Indexar Archivo:");

define("_ROT_EDICION_VOLVER"   ,"Klicken Sie hier um auf Normalmodus zurückzukehren");
define("_ROT_SUBMENU_EDICION"   ,"Unterkategorien");

//Encuestas
define("_ROT_ENCUESTA"   ,"Umfrage");
define("_ROT_ENCUESTA_RESULTADO"   ,"Ergebnisse");
define("_ROT_ENCUESTA_VOTAR"   ,"Wählen");

/**
 * FOROS
 **/
define("_ROT_FORO_RESPUESTA"	,"Sie geben Antwort auf:");
define("_ROT_FORO_AUTOR"		,"Geschrieben von:");
define("_ROT_FORO_NOMBRE"       ,"Name:");
define("_ROT_FORO_RESPONDER"	,"Antworten");

/**
 * Variables Licitaciones
 **/
define("_ROT_LICITACION_OBJETO","Subjekt");
define("_ROT_LICITACION_ESTADOS","Stand");
define("_ROT_LICITACION_CUANTIA","Menge");
define("_ROT_LICITACION_FECHA_APERTURA","Eröffnungsdatum");
define("_ROT_LICITACION_FECHA_CIERRE","Abschlussdatum und -uhrzeit");
define("_ROT_LICITACION_ORDENADOR_GASTO","Kostenanrechner");
define("_ROT_LICITACION_UNIDADES_TACTICAS","Taktishe Einheiten");
define("_ROT_LICITACION_VINCULO","Bezogene Datei");

/**
 * Campañas
 **/
define("_ROT_CONOZCAMAS","Lernen Sie mehr über die Kampagne kennen ");

/**
 * Quejas y Reclamos
 **/
define("_ROT_QUEJAS"            ,"An diesem Ort könne Sie Ihre Klagen, Reklamationen und Meldungen aufschreiben,
 		   						  diese werden von der Generalinspektion der Armee erhalten. <br><br>
			   					  Tragen Sie bitte folgende Daten ein und drücken Sie den Knopf Senden.
								  (die mit * markieten Felder sind obligatorisch)<br><br>Diese Page ist nicht EmpfÄnger dieser nachrichten und in ihrer Kondition als Vermittler, hat sie keine Kompetenzen, um sich diesbezüglich zu äussern, die Privatpersonen, die diese Leitsung nutzen, sind für die Wahrheit und Genauigkeit der meldungen verantwortlich, im Falle falsche oder ungenaue Informationen anzugeben, können gegen sie anliegende Strafaktionen gestartet werden.
								  Wenn die Klagen der Reklamationen die nach dem Recht vorgesehenen Anforderungen, zur Ausübung des Begehrensrechts, erfüllen, werden sie als solche behandelt, gemäss der legalen Anordnungen, die im Recht anwendbar sind.<br><br>Die <span id=\"fieldRequired\">markierten Felder sind</span> obligatorisch");
define("_ROT_QUEJAS_NOMBRE", "Vorname(s)");
define("_ROT_QUEJAS_NOMBRE_ERROR", "Name ist leer.");
define("_ROT_QUEJAS_APELLIDO", "Nachnamen");
define("_ROT_QUEJAS_APELLIDO_ERROR", "Nachnamen sind leer.");
define("_ROT_QUEJAS_IDENTIFICACION", "Identifikaiton");
define("_ROT_QUEJAS_IDENTIFICACION_ERROR", "Die Indentifikation kann nur Zahlen enthalten.");
define("_ROT_QUEJAS_DIRECCION", "Anscrift");
define("_ROT_QUEJAS_TELEFONO", "Telefon");
define("_ROT_QUEJAS_CORREO", "E.Mail Adresse");
define("_ROT_QUEJAS_CORREO_ERROR1", "E-Mail Adresse ist leer.");
define("_ROT_QUEJAS_CORREO_ERROR2", "E-Mail Adresse ist nicht gültig.");
define("_ROT_QUEJAS_PAIS", "Land");
define("_ROT_QUEJAS_CIUDAD", "Stadt");
define("_ROT_QUEJAS_LABEL", "Klage oder Reklamation");
define("_ROT_QUEJAS_LABEL_ERROR", "Sie müssen klage oder Reklamation eintragen.");

define("_ROT_QUEJAS_ENVIO_CONFIRMA", "Klage erfolgreich versandt.");
define("_ROT_QUEJAS_ENVIO_ERROR", "Es gab einen Fehler im Versand der Klage, versuchen Sie es bitte später nochmal.");

/**
 * VISITA
 **/
define("_ROT_VISITA"            ,"Hier können Sie die Dienste  des Symphonischen Blasorchesters  beantragen ,  dieser  Antrag wird von der Direktion   der Luftwaffeschule.
								 <br>Markierte <span id=\"fieldRequired\">Felder</span> sind  obligatorisch");

define("_ROT_VISITA_NOMBRE_INSTITUCION", "Name  Institución");
define("_ROT_VISITA_NOMBRE_INSTITUCION_ERROR", "Feld  Name der Institution ist leer.");

define("_ROT_VISITA_NOMBRE", "Vorname  Antragssteller");
define("_ROT_VISITA_NOMBRE_ERROR", "Das  Feld Vorname ist leer.");
define("_ROT_VISITA_APELLIDO", "Familienname Antragsteller");
define("_ROT_VISITA_APELLIDO_ERROR", "Das  Feld Familienname ist leer.");
define("_ROT_VISITA_IDENTIFICACION", "Identifikation");
define("_ROT_VISITA_IDENTIFICACION_ERROR", "Die  Identifikation darf nur numerische zahlen enthalten.");
define("_ROT_VISITA_DIRECCION", "Adresse");
define("_ROT_VISITA_TELEFONO", "Telefonnummer");
define("_ROT_VISITA_CORREO", "E-Mail-Adresse");
define("_ROT_VISITA_CORREO_ERROR1", "Das Feld  E-Mail-Adresse ist leer.");
define("_ROT_VISITA_CORREO_ERROR2", "Ungültige E-Mail-Adresse. ");

define("_ROT_VISITA_NOMBRE_EVENTO", "Name des Events");
define("_ROT_VISITA_NOMBRE_EVENTO_ERROR", "Das Feld Name des Events  ist leer.");

define("_ROT_VISITA_FECHA_EVENTO", "Das Feld Datum des Events ist leer");
define("_ROT_VISITA_FECHA_EVENTO_ERROR", "Das Feld Datum  des Events ist  leer.");

define("_ROT_VISITA_HORA_EVENTO", "Uhrzeit des Events");
define("_ROT_VISITA_HORA_EVENTO_ERROR", "Das Feld Uhrzeit des Events ist  leer.");

define("_ROT_VISITA_PAIS", "Land");
define("_ROT_VISITA_CIUDAD", "Stadt");
define("_ROT_VISITA_LABEL", "Anmerkungen");
define("_ROT_VISITA_LABEL_ERROR", "Sie müssen  Anmerkungen eingeben.");

define("_ROT_VISITA_ENVIO_CONFIRMA", "Beschwerde/Reklamation  erfolgreich  versandt.");
define("_ROT_VISITA_ENVIO_ERROR", "Es ist ein Fehler beim Versenden  der Beschwerde /Reklamation eingetreten ,  Versuchen Sie es bitte später noch einmal.");

/**
 * Suscripciones
 **/
define("_ROT_SUSCRIPCION_NOMBRE_ERROR", "Das Feld Vorname fehlt");
define("_ROT_SUSCRIPCION_APELLIDO_ERROR", "Das Feld  Familienname Fehlt");
define("_ROT_SUSCRIPCION_CC_ERROR", "Das Fel d   C.C. fehlt oder enthält ungültige Zeichen");
define("_ROT_SUSCRIPCION_EMAIL_ERROR", "E-Mail-Adresse fehlt");
define("_ROT_SUSCRIPCION_EMAIL_ERROR2", "ungültige  Syntax-E-Mailadresse");
define("_ROT_SUSCRIPCION_TELEFONO_ERROR", "Telefonnummer fehlt oder enthält ungültige Zeichen");
define("_ROT_SUSCRIPCION_DIRECCION_ERROR", "Fehlt  Adresse");
define("_ROT_SUSCRIPCION_CIUDAD_ERROR", "Stadt fehlt");
define("_ROT_SUSCRIPCION_FECHA_SUSCRIPCION_ERROR", "Datum ab dem Sie das Abonnement wünschen fehlt");
define("_ROT_SUSCRIPCION_TIEMPO_SUSCRIPCION_ERROR", "Abonnement-Dauer fehlt");
define("_ROT_SUSCRIPCION_COMENTARIO_ERROR", "Kommentar fehlt");

define("_ROT_SUSCRIPCION_ENVIO_CONFIRMA", "Die Nachricht wurde erfolgreich versandt");
define("_ROT_SUSCRIPCION_ENVIO_ERROR", "Die Nachricht konnte nicht versandt werden. Bitte, versuchen Sie es noch einmal.");

/**
 * Servicios (Visitas)
 **/
define("_ROT_SERVICIO_NOMBRE_INSTITUCION_ERROR", "Falta el Campo 'Das Feld  Name der Instituion fehlt'");
define("_ROT_SERVICIO_NOMBRE_SOLICITANTE_ERROR", "Das  Feld Vorname des Antragstellers fehlt'");
define("_ROT_SERVICIO_APELLIDO_SOLICITANTE_ERROR", "Das  Feld Familienname des Antragstellers fehlt'");
define("_ROT_SERVICIO_DIRECCION_ERROR", "Das  Feld Adresse des Antragstellers fehlt'");
define("_ROT_SERVICIO_TELEFONO_ERROR", "Das  Feld  Telefonnummer fehlt. Bitte,  geben Sie nur Zahlen ein.");
define("_ROT_SERVICIO_CORREO_ERROR", "Das  Feld E-Mail-Adresse fehlt'");
define("_ROT_SERVICIO_CORREO_ERROR2", "Ungültige E-Mail-Adresse-Syntax");
define("_ROT_SERVICIO_PAIS_ERROR", "Das  Feld Land  fehlt'");
define("_ROT_SERVICIO_CIUDAD_ERROR", "Das  Feld  Stadt fehlt'");
define("_ROT_SERVICIO_NOMBRE_EVENTO_ERROR", "Das  Feld Name des Events fehlt'");
define("_ROT_SERVICIO_FECHA_EVENTO_ERROR", "Das  Feld Datum des Events fehlt'");

/**
 * Formato de datetotext
 **/
define('FORMAT_DATETOTEXT', '%d . %B %Y');

/**
 * Rotulos de los Meses de las Fechas del Filtro Avanzado
 **/
define("_ROT_FILTRO_BUSCAR", "Suchen");
define("_ROT_FILTRO_FECHA", "Alle Daten");
define("_ROT_FILTRO_FECHA_ENERO", "Januar");
define("_ROT_FILTRO_FECHA_FEBRERO", "Februar");
define("_ROT_FILTRO_FECHA_MARZO", "März");
define("_ROT_FILTRO_FECHA_ABRIL", "April");
define("_ROT_FILTRO_FECHA_MAYO", "Mai");
define("_ROT_FILTRO_FECHA_JUNIO", "Junio");
define("_ROT_FILTRO_FECHA_JULIO", "Juli");
define("_ROT_FILTRO_FECHA_AGOSTO", "August");
define("_ROT_FILTRO_FECHA_SEPTIEMBRE", "September");
define("_ROT_FILTRO_FECHA_OCTUBRE", "Oktober");
define("_ROT_FILTRO_FECHA_NOVIEMBRE", "November");
define("_ROT_FILTRO_FECHA_DICIEMBRE", "Dezember");

// Cabezote
define("_ROT_GO_CONTENT","Zum Inhalt gehen");
define("_ROT_INICIO","Anfang");
define("_ROT_DESCARGA","Diese Homepage nutzt Macromedia Flash, um einige Inhalte zu zeigen. Sie können plugin herunterladen");
define("_ROT_AQUI","Hier");
define("_ROT_HORA_LEGAL", "Hora Legal Colombiana");
define("_ROT_NOSCRIPT", "Ihr Navigator kann JavaScript nicht tragen!");
define("_ROT_NAV_TOOLS", "Navigationssäule Hilfsmittel");
define("_ROT_SKIP_TOOLS", "Navigationssäule Hilfsmittel überspringen");
define("_ROT_END_TOOLS", "Ende Navigationssäule Hilfsmittel");

define("_ROT_IMAGENES", "Bilder");
define("_ROT_VIDEO", "Video");
define("_ROT_AUDIO", "Audio");


// Laterales
define("_ROT_MENU_INST","institutionellen Menüs</span>");
define("_ROT_MENU_INSTITUCIONAL","Hauptmenü");
define("_ROT_NAV_INST","Institutionelles Navigationsmenü");
define("_ROT_SKIP_INST","Institutionelles Navigationsmenü überspringen");
define("_ROT_END_OF","Ende von");
define("_ROT_END_MENU_INST","Ende des institutionellen Menüs");
define("_ROT_GO_TO","Gehe zu");
define("_ROT_AMPLIAR_NOTA","Bericht erweitern");


define("_ROT_RECOMENDADOS","Empfohlene Abteilungen");
define("_ROT_NAV_RECOMENDADOS","Navigationssäule der empfohlenen Abteilungen");
define("_ROT_SKIP_RECOMENDADOS","Navigationssäule der empfohlenen Abteilungen überspringen");
define("_ROT_END_RECOMENDADOS","Ende der Navigationssäule der empfohlenen Abteilungen");
define("_ROT_ENLACES","Institutionelle Verbindungen");
define("_ROT_INCORPORACIONES","Eingliederungen");
define("_ROT_VIDEOS","Videos");
define("_ROT_PREGUNTAS","Häufige Fragen");
define("_ROT_CATEGORIA_DESTACADA","Ausgezeichnete Kategorie");

// Menu usuario
define("_ROT_MENU_USER","Nutzermenü");
define("_ROT_NAV_USER", "Navigationsmenü des Nutzers");
define("_ROT_SKIP_USER", "Saltar el men&uacute; de navegaci&oacute;n del usuario");
define("_ROT_END_MENU_USER", "Ende des Nutzermeüs");
define("_ROT_ADMIN", "Administraci&oacute;n");
//define("_ROT_ADMIN", "Verwaltung");
define("_ROT_VER_PAGINA", "Ver p&aacute;gina");
//define("_ROT_VER_PAGINA", "Siehe Seite");
define("_ROT_EDITAR_PAGINA", "Editar esta p&aacute;gina");
//define("_ROT_EDITAR_PAGINA", "Diese Seite bearbeiten");
define("_ROT_MI_PORTAL", "Mi portal");
//define("_ROT_MI_PORTAL", "Meine Homepage");
define("_ROT_TERMINAR_SESION", "Terminar Sesi&oacute;n");
//define("_ROT_TERMINAR_SESION", "Sitzung beenden ");

// Nube
define("_ROT_TAG_CLOUD", "Etikettenwolke");
define("_ROT_RELATED_TAGS", "Das meist gesehene");
define("_ROT_NAV_CLOUD", "Navigationssäule der Etikettenwolke");
define("_ROT_SKIP_CLOUD", "Navigationssäule der Etikettenwolke überspringen");
define("_ROT_END_CLOUD", "Ende der Navigationssäule der Etikettenwolke");

// Migas
define("_ROT_BREAD_CRUMBS", "Gehalt");
define("_ROT_NAV_BREAD_CRUMBS", "Navigationssäule Gehalt");
define("_ROT_BREAD_CRUMBS_HERE", "Sie befinden sich her:");
define("_ROT_SKIP_BREAD_CRUMBS", "Navigationssäule Gehalt überspringen");
define("_ROT_END_BREAD_CRUMBS", "Ende der Navigationssäule Gehalt");

// Home y Home Generico
define("_ROT_CONTENT","Inhalt");
define("_ROT_AUTOR","Por");
define("_ROT_VERMAS_HOME","Mehr Information sehen");
define("_ROT_VERMAS","Meh sehen");
define("_ROT_AMPLIAR","Vergrössern");
define("_ROT_PUBLICADO","Veröffentliche am");
define("_ROT_ACTUALIZACION","Letzte Aktualisierung");
define("_ROT_END_SECTION","Ende der Abteilung");

// Pie
define("_ROT_DESTACADOS","Ausgezeichnet");
define("_ROT_NAV_HIGHLIGHTS","Navigationssäule der ausgezeichneten Abteilungen");
define("_ROT_SKIP_HIGHLIGHTS","Navigationssäule der ausgezeichneten Abteilungen überspringen");
define("_ROT_END_HIGHLIGHTS","Ende der Navigationssäule der ausgezeichneten Abteilungen");
define("_ROT_INSTITUCIONES","Staatseinrichtungen");
define("_ROT_NAV_INSTITUCIONES","Navigationssäule Staatseinrichtungen");
define("_ROT_SKIP_INSTITUCIONES","Staatseinrichtungen überspringen");
define("_ROT_END_INSTITUCIONES", "Ende der Staatseinrichtungen");
define("_ROT_INFO_COMPANY","Information über die Entität");
define("_ROT_DEVELOPED","Homepage entwickelt von");
define("_ROT_GOTO","Gehe zur Seite");
define("_ROT_LOGO","Logo de la empresa Micrositios Ltda.");

// Default
define("_ROT_IMAGEN","Bild vergössern");
define("_ROT_AMPLIAR_IMAGEN","Bild in Originalgösse sehen");
define("_ROT_SUBCATEGORIAS","bezogenen Links");
define("_ROT_UTILIDADES","Nutzen");
define("_ROT_INICIO_PAGINA","Gehe zum Anfang dieser Seite");
define("_ROT_IMPRIMIR","Im Druckerfreundlichen Format sehen");
define("_ROT_ENVIAR_AMIGO","Diese Abteilung einem Freund weiterempfehln");

// Lista en cuadros
define("_ROT_SUMMARY","Kategorien mit  Zusammenfassung in Tabellen organisiert");

// Galeria de imagenes
define("_ROT_VERIMAGEN","Bild sehen");
define("_ROT_TITLE_IMAGEN","Gesamtbild sehen");
define("_ROT_INFORMACION","Information");
define("_ROT_TITLE_INFORMACION","Gehe zur Kategorie");

// Galeria de audio
define("_ROT_ESCUCHAR","Hören");

// Galeria de video
define("_ROT_VER_VIDEO","Ver Video");

// Paginacion
define("_ROT_PAGER","Seitensucher");
define("_ROT_NAV_PAGER","Navigationssäule des Seitensuchers");
define("_ROT_SKIP_PAGER", "Navigationssäule des Seitensuchers überspringen");
define("_ROT_END_PAGER", "Ende der Navigationssäule des Seitensuchers");
define("_ROT_PRIMERO","Erster");
define("_ROT_ANTERIOR","Vorherige");
define("_ROT_SIGUIENTE","Nächste");
define("_ROT_ULTIMO","Letzte");

// Descarga
define("_ROT_DESCARGAR","Descargar");

// url con marco
define("_ROT_VOLVER","Volver");

// Calendario
define("_ROT_CALENDARIO_MESES","Wählen Sie den Monat aus, um die Ereignisse zu sehen");
?>