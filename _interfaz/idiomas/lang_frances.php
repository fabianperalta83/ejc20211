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
define("_R_IDIOMA", 'french');
define("_ROT_PAGINA_INEXISTENTE" ,"Il se peut que la page soit inactive<br>Merci de bien vouloir contacter l’administrateur du site Web");
define("_ROT_MENSAJE_RESTRICCION","Page restreinte niveau");
define("_ROT_PAGINA_RESTRINGIDA" ,sprintf(str_replace("  "," ","<ul>
        <li>Pour accéder aux services de notre portail, merci de créer votre compte <a href=index.php?idcategoria=%s><span class=tpl_titulo_mensaje_error><strong>aqui</strong></span></a>
        <li>L’ <strong>Utilisateur</strong> Et <strong>Mot de passe</strong> vous seront envoyés automatiquement à votre compte de messagerie électronique.
        </ul>"),_SREGISTRO));

// Idioma principal del documento
define("_ROT_LANG", "fr");

// Archivo funciones.php
define("_ROT_SUBMENU"    ,"");
define("_ROT_SUBMENU_LINEA","");
define("_ROT_SUBMENU_MARCA","");
define("_ROT_SUBMENU_PUBLICACIONES","<strong>ACCUEIL</strong>");
define("_ROT_VER_MAS","Lire Nouvelles");
define("_ROT_BOLETIN_TXT_1","Entrer votre adresse de messagerie pour recevoir notre bulletin électronique.");

define("_ROT_ENCUESTA1"   ,"Choisissez une option et votez !");
define("_ROT_ENCUESTA2"   ,"Résultat des votes");
define("_ROT_ENCUESTA3"   ,"Nombre total de votes");
define("_ROT_REDIRECCION","Vous avez été redirigé automatiquement vers une autre section de la page Web");
define("_ROT_DOWNLOAD"   ,"Cliquez sur le lien pour ouvrir le fichier.<br>Pour l’enregistrer sur votre disque dur, cliquez<br>avec le bouton droit de la souris et choisissez<br> \"Enregistrer sous...\"<br>");
define("_ROT_CADUCIDAD"  ,"Bien que cette information ne soit pas actuelle, elle reste stockée dans l’historique du site Web");

define("_ROT_ADMIN_DOCUMENTOS"     ,"Administrateur de documents");
// Archivo contacto.php
define("_ROT_ADVERTENCIA"          ,"ADVERTENCIA");
define("_ROT_ERROR"                ,"ERROR");
define("_ROT_CONFIRMACION"         ,"CONFIRMATION");
define("_ROT_CONTACTO_NOMBRE"      ,"Prénom complet:");
define("_ROT_CONTACTO_NOMBRE_ERROR","Le champ « Prénom » est obligatoire");
define("_ROT_CONTACTO_EMAIL"      ,"Messagerie électronique:");
define("_ROT_CONTACTO_EMAIL_ERROR1","Le champ « Messagerie électronique » est obligatoire");
define("_ROT_CONTACTO_EMAIL_ERROR2","Adresse e-mail incorrecte");
define("_ROT_CONTACTO_EMPRESA"      ,"Activité/Fonction/Profession:");
define("_ROT_CONTACTO_EMPRESA_ERROR","Le champ « Activité/Fonction/Profession » est obligatoire");
define("_ROT_CONTACTO_CARGO"      ,"Poste :");
define("_ROT_CONTACTO_CARGO_ERROR","Le champ « Poste » est obligatoire");
define("_ROT_CONTACTO_DIRECCION"      ,"Ville / Pays:");
define("_ROT_CONTACTO_DIRECCION_ERROR","Le champ « Ville / Pays » est obligatoire");
define("_ROT_CONTACTO_TELEFONOS"      ,"Téléphone:");
define("_ROT_CONTACTO_TELEFONOS_ERROR","Le champ « Téléphone » est obligatoire");
define("_ROT_CONTACTO_COMENTA"      ,"Commentaire:");
define("_ROT_CONTACTO_COMENTA_ERROR","Le champ « Commentaire » est obligatoire");
define("_ROT_CONTACTO",              "<ul><li>Tous vos commentaires, suggestions ou questions sont les bienvenus.
                                     <li>Les champs <span id=\"fieldRequired\">mis en exergue</span> sont obligatoires.</ul>");
define("_ROT_CONTACTO_ADVERTENCIA","LE FORMULAIRE N’A PAS PU ÊTRE ENVOYÉ!<br>Merci de vérifier que les champs");
define("_ROT_CONTACTO_REQUERIDO","(obligatoires ont été remplis)");

define("_ROT_CONTACTO_ENVIO_CONFIRMA"   ,"Le message a été envoyé à <strong>%s</strong>, Merci de votre intérêt");
define("_ROT_CONTACTO_ENVIO_ERROR","Le message n’a pas pu être envoyé à <strong>%s</strong>,<br>Merci d’essayer ultérieurement ou d’utiliser votre compte de messagerie habituel.");

// Archivo certificado.php

define("_ROT_CERTIFICADO_NOMBRE"      ,"Prénoms complets:");
define("_ROT_CERTIFICADO_NOMBRE_ERROR","Le champ « Prénoms » est obligatoire");
define("_ROT_CERTIFICADO_EMAIL"      ,"Messagerie électronique:");
define("_ROT_CERTIFICADO_EMAIL_ERROR1","Le champ « Messagerie électronique » est obligatoire");
define("_ROT_CERTIFICADO_EMAIL_ERROR2","Adresse de messagerie incorrecte");
define("_ROT_CERTIFICADO_FECHA"      ,"Date de la demande:");
define("_ROT_CERTIFICADO_FECHA_ERROR","Le champ « Date » est obligatoire");
define("_ROT_CERTIFICADO_CEDULA"      ,"Code ou Numéro de carte d’identité:");
define("_ROT_CERTIFICADO_CEDULA_ERROR","Le champ « Code ou Numéro de carte d’identité » est obligatoire");
define("_ROT_CERTIFICADO_TIPO"      ,"Type de demande:");
define("_ROT_CERTIFICADO_TIPO_ERROR","Le champ « Type de demande » est obligatoire");
define("_ROT_CERTIFICADO_DESTINO"      ,"Destinataire Certificat:");
define("_ROT_CERTIFICADO_DESTINO_ERROR","Le champ « Destinataire du Certificat » est obligatoire");
define("_ROT_CERTIFICADO_APELLIDO"      ,"Noms complets:");
define("_ROT_CERTIFICADO_APELLIDO_ERROR","Le champ « Nom » est obligatoire");
define("_ROT_CERTIFICADO_TELEFONOS"      ,"Téléphone:");
define("_ROT_CERTIFICADO_TELEFONOS_ERROR","Le champ « Téléphone » est obligatoire");
define("_ROT_CERTIFICADO_DIRECCION"      ,"Adresse Permanente:");
define("_ROT_CERTIFICADO_DIRECCION_ERROR","Le champ « Adresse » est obligatoire");
define("_ROT_CERTIFICADOS","<br>Remplissez le formulaire et cliquez sur Envoyer");
define("_ROT_CERTIFICADO_ADVERTENCIA","Merci de vérifier que les champs");
define("_ROT_CERTIFICADO_REQUERIDO","(obligatoires ont été remplis)");

// Archivo acreedores.php

define("_ROT_ACREEDORES"                     ,"CRÉANCIERS");
define("_ROT_ACREEDORES_TIPOIDENTIFICACION"  ,"Type Document d’identité:");
define("_ROT_ACREEDORES_IDENTIFICACION"      ,"Numéro Document d’identité:");
define("_ROT_ACREEDORES_IDENTIFICACION_ERROR","Le champ « Numéro Document d’identité » est obligatoire");
define("_ROT_ACREEDORES_CLAVE"               ,"Mot de passe:");
define("_ROT_ACREEDORES_REQUERIDO"           ,"(obligatoires ont été remplis)");


// Archivo registro_evento.php
define("_ROT_REGISTRO_FORMA_PAGO_ERROR"      ,"Sélectionnez un mode de paiement ");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO1"   ,"Vous êtes déjà enregistré pour cet événement");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO2"   ,"Un courrier électronique a été envoyé à votre messagerie <strong>%s</strong> avec les instructions détaillées pour finaliser le processus d'enregistrement");
define("_ROT_REGISTRO_YA_ESTA_REGISTRADO3"   ,"Si vous souhaitez annuler ou modifier votre inscription à cet événement, merci de nous contacter directement par téléphone");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA1"   ,"Si vous cliquez sur « Accepter », vous pourrez uniquement modifier ou annuler votre enregistrement par téléphone");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA2"   ,"Une fois votre enregistrement terminé, un courrier électronique de confirmation et description détaillé du processus d'inscription vous sera envoyé.");
define("_ROT_REGISTRO_EVENTO_ADVERTENCIA3"   ,"Cette transaction est protégée par le décret XXXX et a une durée de validité de DDDD");
define("_ROT_INFO"                           ,"INFORMACION");


// Archivo registro.php

define("_ROT_REGISTRO","<ul><li>L’enregistrement vous permet d’obtenir plus d’information sur nos événements.
                            <li>L’enregistrement est <strong>GRATUIT</strong>
                            <li>Votre nom d’utilisateur et mot de passe vous seront envoyés à votre compte de messagerie électronique.
                            <li>Les champs <span id=\"fieldRequired\">mis en exergue</span> sont obligatoires.</ul>");
define("_ROT_MICUENTA"                           ,"Ces informations sont personnelles, pensez à changer votre mot de passe régulièrement.<br>Les champs <span id=\"fieldRequired\">mis en exergue</span> sont obligatoires.");
define("_ROT_MICUENTA_ACTUALIZACION"             ,"CONFIRMATION!");
define("_ROT_REGISTRO_USERNAME"                  ,"Nom d’utilisateur:");
define("_ROT_REGISTRO_USERNAME_ERROR"            ,"Le champ « Nom d’utilisateur » est obligatoire");
define("_ROT_REGISTRO_NOMBRE"                    ,"Prénom(s):");
define("_ROT_REGISTRO_NOMBRE_ERROR"              ,"Le champ « Prénom » est vide ou contient des caractères non autorisés.");
define("_ROT_REGISTRO_PASSWORD_ACTUAL"           ,"Mot de passe actuel:");
define("_ROT_REGISTRO_PASSWORD1"                 ,"Mot de passe:");
define("_ROT_REGISTRO_PASSWORD2"                 ,"Confirmez le mot de passe:");
define("_ROT_REGISTRO_PASSWORD_EXITO"            ,"Votre mot de passe a été correctement modifié!");
define("_ROT_REGISTRO_PASSWORD_ERROR1"           ,"Le champ « Mot de Passe » est obligatoire");
define("_ROT_REGISTRO_PASSWORD_ERROR2"           ,"Le champ « Confirmation du mot de passe » est obligatoire");
define("_ROT_REGISTRO_PASSWORD_ERROR3"           ,"Le mot de passe et la confirmation ne correspondent pas");
define("_ROT_REGISTRO_PASSWORD_ERROR4"           ,"Le mot de passe n’a pas pu être modifié.");
define("_ROT_REGISTRO_PASSWORD_ERROR5"           ,"Le mot de passe actuel est incorrect, merci de bien vouloir vérifier.!");
define("_ROT_REGISTRO_APELLIDO"                  ,"Nom(s):");
define("_ROT_REGISTRO_APELLIDO_ERROR"            ,"Le champ « Nom(s) » est vide ou contient des caractères non autorisés.");
define("_ROT_REGISTRO_EMAIL"                     ,"Adresse de messagerie électronique:");
define("_ROT_REGISTRO_EMAIL_ERROR1"              ,"Le champ « Adresse de messagerie électronique » est obligatoire");
define("_ROT_REGISTRO_EMAIL_ERROR2"              ,"Adresse de messagerie incorrecte");
define("_ROT_REGISTRO_EMAIL_ERROR3"              ,"L’adresse de messagerie indiquée pour le PAIEMENT est incorrecte");
define("_ROT_REGISTRO_EMPRESA"                   ,"Nom de l’Entreprise (Raison Sociale):");
define("_ROT_REGISTRO_EMPRESA_ERROR"             ,"Le champ « Nom de l’Entreprise » est obligatoire");
define("_ROT_REGISTRO_CIUDAD"                    ,"Ville:");
define("_ROT_REGISTRO_CIUDAD_ERROR"              ,"Le champ « Ville » est obligatoire");
define("_ROT_REGISTRO_PAIS"                      ,"Pays:");
define("_ROT_REGISTRO_PAIS_ERROR"                ,"Le champ « Pays » est obligatoire");
define("_ROT_REGISTRO_PROFESION"                 ,"Profession:");
define("_ROT_REGISTRO_PROFESION_ERROR"           ,"Le champ « Profession » est obligatoire");
define("_ROT_REGISTRO_TELEFONO"                  ,"Téléphone:");
define("_ROT_REGISTRO_TELEFONO_EMPRESA"          ,"Téléphone(s):<ul class=texto_mini><li>Vous pouvez entrer plusieurs numéros de téléphone.<liExtension.<li>Ne pas entrer d’indicatifs téléphoniques.</ul>");
define("_ROT_REGISTRO_FAX_EMPRESA"               ,"Fax:");
define("_ROT_REGISTRO_TELEFONO_ERROR"            ,"Le champ « Téléphone » est obligatoire");
define("_ROT_REGISTRO_DIRECCION"                 ,"Adresse:");
define("_ROT_REGISTRO_DIRECCION_ERROR"           ,"Le champ « Adresse » est obligatoire");
define("_ROT_REGISTRO_CARGO"                     ,"Poste:");
define("_ROT_REGISTRO_EVENTOS"                   ,"Thèmes sur lesquels vous souhaiterez recevoir des informations:");
define("_ROT_REGISTRO_EMPRESA_NIT"               ,"Numéro fiscal:");
define("_ROT_REGISTRO_EMPRESA_ACTIVIDAD"         ,"Activité économique:");

define("_ROT_REGISTRO_EMPRESA_MEDIO"             ,"Moyen par lequel vous avez été informé de nos activités:");
define("_ROT_REGISTRO_EMPRESA_MEDIO_OTRO"        ,"Si vous avez été informé d’une autre manière, merci de l'indiquer:");

define("_ROT_REGISTRO_REQUERIDO"    ,"(obligatoires ont été remplis)");
define("_ROT_REGISTRO_CORREO"       ,"Souhaitez-vous recevoir des informations par courrier électronique?");
define("_ROT_REGISTRO_RED"          ,"Je souhaite souscrire au Réseau d’Actions pour la Paix");
define("_ROT_REGISTRO_ADVERTENCIA"  ,"Merci de vérifier les informations indiquées");
define("_ROT_REGISTRO_ADVERTENCIA2"  ,"Vos informations n’ont pas été actualisées.");
define("_ROT_REGISTRO_EXISTENTE"    ,"Un utilisateur est déjà inscrit avec cette adresse de messagerie électronique.  Merci d’utiliser une autre adresse de messagerie électronique.");
define("_ROT_REGISTRO_EXISTENTE2"    ,"Un utilisateur est déjà inscrit avec ce Nom d’Utilisateur.  Merci d’utiliser un autre Nom d’utilisateur. ");
define("_ROT_REGISTRO_EXITO"        ,"Vos informations ont été correctement actualisées.");

define("_ROT_REGISTRO_RECORDAR","<strong>¿Vous vous êtes déjà inscrit mais vous avez oublié votre Nom d’utilisateur ou Mot de Passe?</strong><br>Entrer l’adresse de messagerie avec laquelle vous vous êtes inscrit.");

// Archivo buscar.php
define("_ROT_BUSCAR"            ,"Chercher");
define("_ROT_BUSCAR_TXT"            ,"La recherche est restreinte<br>à l’information contenue sur cette page.");
define("_ROT_BUSCAR_PALABRA"    ,"Mot à chercher");
define("_ROT_BUSCAR_RESULTADOS" ,"%s résultats ont été trouvés avec le mot <span style=\"color:green;\"><em>%s</em></span>");
define("_ROT_BUSCAR_ADVERTENCIA","LA RECHERCHE N’A PAS PU ÊTRE EFFECTUÉE!<br>Merci de vérifier les informations indiquées");
define("_ROT_BUSCAR_ADVERTENCIA_MENSAJE"      ,"Le mot à chercher doit contenir au moins trois lettres");


//Variable en MostrarCuentele
define("_ROT_CUEN_TIT","Envoyer à un ami");
define("_ROT_CUEN_MEN1","Votre e-mail:");
define("_ROT_CUEN_MEN2","Adresse de messagerie électronique de votre ami :");
define("_ROT_CUEN_CUERPO","Vous envoie le commentaire suivant:\n\n");
define("_ROT_CUEN_CUERPO1","Cher ami:\nMerci de nous recommander.\nInvitez vos amis à faire partie de ce projet.\nCordialement,\nL’Équipe de Travail Navigateurs Virtuels.");
define("_ROT_CUEN_CUERPO2","Révisez les informations de cette page");
define("_ROT_CUEN_CUERPO3","Merci de nous recommander");
define("_ROT_CUEN_CUERPO4","\nAdresse de messagerie électronique du destinataire:");
define("_ROT_CUEN_NOTIFICACION","Note : Recommandation sur la page");
define("_ROT_CUEN_ENVIADO","Message envoyé.<br>Merci");
define("_ROT_RECOMENDAR_NOTICIA","Partagez cette Nouvelle");

// Variables para Emisoras
define("_ROT_EMISORA_NOMBRE","Nom");
define("_ROT_EMISORA_RESUMEN","Description");
define("_ROT_EMISORA_IDENTIFICACION","Document d’identité");
define("_ROT_EMISORA_URL","Page Web");
define("_ROT_EMISORA_EMAIL","Messagerie électronique");

// Variables para Login
define("_ROT_LOGIN","Entrez votre nom d’utilisateur et mot de passe");
define("_ROT_LOGIN_USUARIO"    ,"Nom d’utilisateur: ");
define("_ROT_LOGIN_PASSWORD"   ,"Mot de passe: ");

// Variables para Mapa
define("_ROT_MAPA_GENERAL"     ,"Général");
define("_ROT_MAPA_DETALLADO"   ,"Détails");
define("_ROT_MAPA_COMPLETO"    ,"Complet");

// Variables Edición
define("_ROT_EDICION"            ,"Les champs <span id=\"fieldRequired\">mis en exergue</span> sont obligatoires");
define("_ROT_EDICION_ERROR"      ,"Le nom de la catégorie est obligatoire");
define("_ROT_EDICION_ANTETITULO" ,"Surtitre:");
define("_ROT_EDICION_NOMBRE"     ,"Nom:");
define("_ROT_EDICION_SUBTITULO"  ,"Sous-titre:");
define("_ROT_EDICION_RESUMEN" ,"Résumé:");
define("_ROT_EDICION_CONTENIDO"  ,"Contenu:");
define("_ROT_EDICION_AUTOR"      ,"Auteur:");
define("_ROT_EDICION_IMAGEN"     ,"Image:");
define("_ROT_EDICION_ACTIVA"     ,"Active:");
define("_ROT_EDICION_ORDEN"      ,"Ordre:");
define("_ROT_EDICION_FECHA1"     ,"Date de création / actualisation:");
define("_ROT_EDICION_FECHA2"     ,"Date maximum sur la page d’Accueil:");
define("_ROT_EDICION_FECHA3"     ,"Date 3:");
define("_ROT_EDICION_RESTRINGIDA","Restreindre à tous les utilisateurs sauf à:");
define("_ROT_EDICION_TIPOSECCION","Type principal:");
define("_ROT_EDICION_TIPOSECCION_SUB","Type des sous-catégories:");
define("_ROT_EDICION_TEMPLATE"   ,"Template graphique:");
define("_ROT_EDICION_PLANTILLA"   ,"Modèle graphique:");
define("_ROT_EDICION_CRITERIO_ORDENA"   ,"Critère de classement des sous-catégories:");
define("_ROT_EDICION_TIPO_ORDENA"   ,"Type de classement des sous-catégories:");
define("_ROT_EDICION_NUMERO_SUB"   ,"Nombre maximum de sous-catégories par page:");
define("_ROT_EDICION_ESROOT"   ,"Page d’Accueil:");
define("_ROT_EDICION_NUMERO_SUB_INFO"   ,"Laissez “0” pour hériter la valeur");
define("_ROT_EDICION_ENBUSQUEDA"	,'Visible dans la Recherche:');
define("_ROT_EDICION_ENMAPA"	,'Visible sur la Carte du Site:');
define("_ROT_EDICION_IDIOMA"	,'Langue de la Catégorie:');
define("_ROT_EDICION_ESRSS"     ,"C’est Rss:");
define("_ROT_INDEXAR"     ,"Indexar Archivo:");

define("_ROT_EDICION_VOLVER"   ,"Cliquez ici pour retourner en mode normal");
define("_ROT_SUBMENU_EDICION"   ,"Sous-catégories");

//Encuestas
define("_ROT_ENCUESTA"   ,"Enquête");
define("_ROT_ENCUESTA_RESULTADO"   ,"Résultats");
define("_ROT_ENCUESTA_VOTAR"   ,"Voter");

/**
 * FOROS
 **/
define("_ROT_FORO_RESPUESTA"	,"Vous répondez à:");
define("_ROT_FORO_AUTOR"		,"Écrit par:");
define("_ROT_FORO_NOMBRE"       ,"Nom:");
define("_ROT_FORO_RESPONDER"	,"Répondre");

/**
 * Variables Licitaciones
 **/
define("_ROT_LICITACION_OBJETO","Objet");
define("_ROT_LICITACION_ESTADOS","États");
define("_ROT_LICITACION_CUANTIA","Montant");
define("_ROT_LICITACION_FECHA_APERTURA","Date d’ouverture");
define("_ROT_LICITACION_FECHA_CIERRE","Date et Heure de Fermeture");
define("_ROT_LICITACION_ORDENADOR_GASTO","Responsable de la Dépense");
define("_ROT_LICITACION_UNIDADES_TACTICAS","Unités Tactiques");
define("_ROT_LICITACION_VINCULO","Fichier relié");

/**
 * Campañas
 **/
define("_ROT_CONOZCAMAS","Plus d’information sur la campagne");

/**
 * Quejas y Reclamos
 **/
define("_ROT_QUEJAS"            ,"Vous pouvez écrire ici vos plaintes, réclamations et dénonciations,
 		   						  qui seront reçues par l’Inspection Générale de l’Armée de Terre. <br><br>
			   					  Merci d’indiquer les données suivantes et de cliquer sur Envoyer.
								  (Les champs marqués d’une * sont obligatoires.)<br><br>Cette page ne reçoit pas directement ces messages et en tant que simple intermédiaire, elle n’est pas en mesure de se prononcer sur son contenu. Les particuliers qui utilisent ce service sont responsables de la véracité et de la précision de leurs déclarations. En cas d’information erronée ou non précise, des actions pénales pourraient être prises à leur encontre.
								  Lorsque les plaintes ou réclamations respectent les conditions prévues par la loi, dans l’exercice du droit de pétition, elles seront traitées comme telles en accord avec les dispositions légales applicable au droit.<br><br>Les champs <span id=\"fieldRequired\">mis en exergue</span> sont obligatoires");
define("_ROT_QUEJAS_NOMBRE", "Prénom(s)");
define("_ROT_QUEJAS_NOMBRE_ERROR", "Le champ « Prénom » est vide.");
define("_ROT_QUEJAS_APELLIDO", "Nom(s)");
define("_ROT_QUEJAS_APELLIDO_ERROR", "Le champ « Nom » est vide.");
define("_ROT_QUEJAS_IDENTIFICACION", "Document d’identité");
define("_ROT_QUEJAS_IDENTIFICACION_ERROR", "Le numéro d’identité ne doit contenir que des caractères numériques.");
define("_ROT_QUEJAS_DIRECCION", "Adresse");
define("_ROT_QUEJAS_TELEFONO", "Téléphone");
define("_ROT_QUEJAS_CORREO", "Adresse de messagerie électronique");
define("_ROT_QUEJAS_CORREO_ERROR1", "Le champ « Adresse de messagerie » est vide.");
define("_ROT_QUEJAS_CORREO_ERROR2", "Adresse de messagerie électronique incorrecte.");
define("_ROT_QUEJAS_PAIS", "Pays");
define("_ROT_QUEJAS_CIUDAD", "Ville");
define("_ROT_QUEJAS_LABEL", "Plainte ou Réclamation");
define("_ROT_QUEJAS_LABEL_ERROR", "Indiquez la plainte ou réclamation.");

define("_ROT_QUEJAS_ENVIO_CONFIRMA", "Votre plainte a été correctement envoyée.");
define("_ROT_QUEJAS_ENVIO_ERROR", "Une erreur s’est produite durant l’envoi de votre plainte, merci d'essayer ultérieurement..");

/**
 * VISITA
 **/
define("_ROT_VISITA"            ,"En este lugar usted puede solicitar los servicios de la Banda Sinfónica, esta solicitud sera recibida por la Dirección de la Escuela Militar de Aviación.
								 <br>Les champs <span id=\"fieldRequired\">mis en exergue</span> sont obligatoires");


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
define('FORMAT_DATETOTEXT', '%d %B %Y');

/**
 * Rotulos de los Meses de las Fechas del Filtro Avanzado
 **/
define("_ROT_FILTRO_BUSCAR", "Rechercher");
define("_ROT_FILTRO_FECHA", "Todas las fechas");
define("_ROT_FILTRO_FECHA_ENERO", "Janvier");
define("_ROT_FILTRO_FECHA_FEBRERO", "Février");
define("_ROT_FILTRO_FECHA_MARZO", "Mars");
define("_ROT_FILTRO_FECHA_ABRIL", "Avril");
define("_ROT_FILTRO_FECHA_MAYO", "Mai");
define("_ROT_FILTRO_FECHA_JUNIO", "Juin");
define("_ROT_FILTRO_FECHA_JULIO", "Juillet");
define("_ROT_FILTRO_FECHA_AGOSTO", "Août");
define("_ROT_FILTRO_FECHA_SEPTIEMBRE", "Septembre");
define("_ROT_FILTRO_FECHA_OCTUBRE", "Octobre");
define("_ROT_FILTRO_FECHA_NOVIEMBRE", "Novembre");
define("_ROT_FILTRO_FECHA_DICIEMBRE", "Décembre");

// Cabezote
define("_ROT_GO_CONTENT","Voir le contenu");
define("_ROT_INICIO","Accueil");
define("_ROT_DESCARGA","Ce site utilise Macromedia Flash pour l’affichage de certains éléments de son contenu. Télécharger le plug-in.");
define("_ROT_AQUI","Ici");
define("_ROT_HORA_LEGAL", "Hora Legal Colombiana");
define("_ROT_NOSCRIPT", "Votre navigateur ne supporte pas JavaScript!");
define("_ROT_NAV_TOOLS", "Barre d'outils");
define("_ROT_SKIP_TOOLS", "Ignorer la barre d'outils");
define("_ROT_END_TOOLS", "Fin barre d'outils");

define("_ROT_IMAGENES", "Images");
define("_ROT_VIDEO", "Vidéo");
define("_ROT_AUDIO", "Audio");


// Laterales
define("_ROT_MENU_INST","Institution</span>");
define("_ROT_MENU_INSTITUCIONAL","Menu principal");
define("_ROT_NAV_INST","Menu de navigation de l’Institution");
define("_ROT_SKIP_INST","Ignorer le Menu de navigation de l’Institution");
define("_ROT_END_OF","Fin");
define("_ROT_END_MENU_INST","Fin Menu Institution");
define("_ROT_GO_TO","Aller à");
define("_ROT_AMPLIAR_NOTA","Plus d’information");


define("_ROT_RECOMENDADOS","Sections Recommandées");
define("_ROT_NAV_RECOMENDADOS","Barre de navigation des sections recommandées");
define("_ROT_SKIP_RECOMENDADOS","Ignorer Barre de navigation des sections recommandées");
define("_ROT_END_RECOMENDADOS","Fin Barre de navigation des sections recommandées");
define("_ROT_ENLACES","Liens Institutionnels");
define("_ROT_INCORPORACIONES","Inscriptions");
define("_ROT_VIDEOS","Videos");
define("_ROT_PREGUNTAS","Questions fréquentes");
define("_ROT_CATEGORIA_DESTACADA","Catégorie sélectionnée");

// Menu usuario
define("_ROT_MENU_USER","Menu de l’utilisateur");
define("_ROT_NAV_USER", "Menu de navigation de l’utilisateur");
define("_ROT_SKIP_USER", "Ignorer Menu de navigation de l’utilisateur");
define("_ROT_END_MENU_USER", "Fin du menu de navigation de l’utilisateur");
define("_ROT_ADMIN", "Administraci&oacute;n");
//define("_ROT_ADMIN", "Administration");
define("_ROT_VER_PAGINA", "Ver p&aacute;gina");
//define("_ROT_VER_PAGINA", "Voir page");
define("_ROT_EDITAR_PAGINA", "Editar esta p&aacute;gina");
//define("_ROT_EDITAR_PAGINA", "Éditer cette page");
define("_ROT_MI_PORTAL", "Mi portal");
//define("_ROT_MI_PORTAL", "Mon portail");
define("_ROT_TERMINAR_SESION", "Terminar Sesi&oacute;n");
//define("_ROT_TERMINAR_SESION", "Fermer la Session");

// Nube
define("_ROT_TAG_CLOUD", "Nuage d’Étiquettes");
define("_ROT_RELATED_TAGS", "Le plus visité");
define("_ROT_NAV_CLOUD", "Barre de navigation du nuage d’étiquettes");
define("_ROT_SKIP_CLOUD", "Ignorer la Barre de navigation du nuage d’étiquettes");
define("_ROT_END_CLOUD", "Fin de la Barre de navigation du nuage d’étiquettes");

// Migas
define("_ROT_BREAD_CRUMBS", "Fil d’Arianne");
define("_ROT_NAV_BREAD_CRUMBS", "Barre de navigation du Fil d’Arianne");
define("_ROT_BREAD_CRUMBS_HERE", "Vous êtes ici:");
define("_ROT_SKIP_BREAD_CRUMBS", "Ignorer la barre de navigation du Fil d’Arianne");
define("_ROT_END_BREAD_CRUMBS", "Fin de la barre de navigation du Fil d’Arianne");

// Home y Home Generico
define("_ROT_CONTENT","Contenu");
define("_ROT_AUTOR","Por");
define("_ROT_VERMAS_HOME","Plus d’information");
define("_ROT_VERMAS","Plus d’information");
define("_ROT_AMPLIAR","Agrandir");
define("_ROT_PUBLICADO","Publié le");
define("_ROT_ACTUALIZACION","Dernière actualisation");
define("_ROT_END_SECTION","Fin de la section");

// Pie
define("_ROT_DESTACADOS","Démarqués");
define("_ROT_NAV_HIGHLIGHTS","Barre de navigation des sections démarquées");
define("_ROT_SKIP_HIGHLIGHTS","Ignorer la Barre de navigation des sections démarquées");
define("_ROT_END_HIGHLIGHTS","Fin de la Barre de navigation des sections démarquées");
define("_ROT_INSTITUCIONES","Institutions de l’État");
define("_ROT_NAV_INSTITUCIONES","Barre de navigation des Institutions de l’État");
define("_ROT_SKIP_INSTITUCIONES","Ignorer les Institutions de l’État");
define("_ROT_END_INSTITUCIONES", "Fin des Institutions de l’État");
define("_ROT_INFO_COMPANY","Information sur l’Entité");
define("_ROT_DEVELOPED","Portail développé par");
define("_ROT_GOTO","Aller à la page");
define("_ROT_LOGO","Logo de la empresa Micrositios Ltda.");


// Default
define("_ROT_IMAGEN","Agrandir l’Image");
define("_ROT_AMPLIAR_IMAGEN","Voir l’image dans sa taille d’origine");
define("_ROT_SUBCATEGORIAS","Liens en relation");
define("_ROT_UTILIDADES","Utilités");
define("_ROT_INICIO_PAGINA","Aller en haut de la page");
define("_ROT_IMPRIMIR","Voir en format compatible avec l’imprimante");
define("_ROT_ENVIAR_AMIGO","Recommander cette section à un ami");

// Lista en cuadros
define("_ROT_SUMMARY","Catégories avec résumés organisées en tableau");

// Galeria de imagenes
define("_ROT_VERIMAGEN","Voir Image");
define("_ROT_TITLE_IMAGEN","Voir Image complète");
define("_ROT_INFORMACION","Information");
define("_ROT_TITLE_INFORMACION","Aller à la catégorie");

// Galeria de audio
define("_ROT_ESCUCHAR","Écouter");

// Galeria de video
define("_ROT_VER_VIDEO","Ver Video");

// Paginacion
define("_ROT_PAGER","Pagineur");
define("_ROT_NAV_PAGER","Barre de navigation du Pagineur");
define("_ROT_SKIP_PAGER", "Ignorer la barre de navigation du Pagineur");
define("_ROT_END_PAGER", "Fin de la Barre de navigation du Pagineur");
define("_ROT_PRIMERO","Premier");
define("_ROT_ANTERIOR","Précédent");
define("_ROT_SIGUIENTE","Suivant");
define("_ROT_ULTIMO","Dernier");

// Descarga
define("_ROT_DESCARGAR","Descargar");

// url con marco
define("_ROT_VOLVER","Volver");

// Calendario
define("_ROT_CALENDARIO_MESES","Sélectionnez le Mois pour voir les Activités");
?>