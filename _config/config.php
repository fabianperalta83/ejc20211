<?php

/**
 * Define el tipo de autenticacion "ldap" o "portal"
 */
define("_DBCONNECT"             ,"mysql");      // Tipo de base de datos
define("_DBUSER"                ,"ejercitomil_portal");   // Usuario de la base de datos
define("_DBHOST"                ,"10.100.10.4");  // 127.0.0.1 Host donde se encuentra la base de datos
//define("_DBHOST"		,"127.0.0.1");
define("_DBNAME"                ,"ejercitomil_portal");      // Nombre de la base de datos
define("_DBPASSWORD"    ,'VMM37Kr3GJPDYsL7gb2XRs8aWRXRDg');  // Password de la Base de Datos

/**
* VARIABLES DE LA CONEXION AL LDAP
*/
$ldap_params[0]["servidor"]   = "192.168.0.105"; // el servidor AD al que se quiere conectar
$ldap_params[0]["puerto"]   = 30389; // el puerto a traves del cual se conectara
$ldap_params[0]["user"]     = "uid=etaadmin,ou=colombia,dc=com,dc=br"; // Username del administrador del AD creado para el portal
$ldap_params[0]["pass"]     = "etaadmin"; // Password del administrador del AD creado para el portal
$ldap_params[0]["dn"]     = "ou=colombia,dc=com,dc=br"; // Clasificador del dominio

/**
 * Variables para la conexi�n al servidor de correo electr�nico
 */
define("_SMTP_AUTH"        ,true);                      //Default false
define("_SMTP_HOST"        ,"smtp.gmail.com");          //Default localhost
define("_SMTP_USER"        ,"envios.correo.masivos@gmail.com");            //Default ''
define("_SMTP_PASS"        ,"Envios2018@");            //Default ''
define("_SMTP_PORT"        ,587);                         //Default 25
define("_SMTP_WORDWRAP"    ,50);
define("_SMTP_ISHTML"      ,true);
define("_SMTP_TIMEOUT"     ,"");
define("_SMTP_SECURE"      ,"tls");    //Default '' posible ssl y tls
define("_SMTP_DEBUG"       ,"6");    //Default ''
