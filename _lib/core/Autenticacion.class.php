<?php
/**
 * Class Autenticacion EJERCITO
 * @package Núcleo
 * @author Juan Manuel Hernandez <jhernandez@micrositios.net>
 * @version 2.0
 * @copyright Copyright © 2005 Micrositios Ltda.
 */
class Autenticacion {
	/**
	 * Autenticacion :: ValidarActiva
	 * Valida si el idcategoria es una pagina activa en el portal
	 * @param int $idcategoria
	 * @return
	 */


	//echo "<script type='text/javascript'>alert('$usu');</script>";
	function ValidarActiva($idcategoria) {

		global $trazaCategoria;

		// Si la página no tiene idcategoria se supone que es home
		$idcategoria = ($idcategoria=='') ? 0 : $idcategoria;

		if (!isset($trazaCategoria[$idcategoria])) {
			$trazaCategoriaAux = Funciones::obtenerInfoCategoria($idcategoria);
		} else {
			$trazaCategoriaAux = $trazaCategoria;
		}

		// Verifica que la página no sea administrativa (edicion o indexadmin)
		if ($_SESSION['modo_edicion'] === FALSE or $_SESSION["modo_edicion_aprovado"] === FALSE) {

			$idAux = $idcategoria;

			/**
			 * Por default una pagina activa tiene el valor 1, entonces busca una que tenga cero para
			 * verificar que este activa
			 */
			while($idAux != 0) {
				$row = $trazaCategoriaAux[$idAux];
				if($row["activa"] == '0') {
					return $trazaCategoriaAux[$idAux]["activa"];
				} else {
						$idAux = $trazaCategoriaAux[$idAux]["idpadre"];
				}
			}

			return 1; // Si no encontró nada con 0 pues es por que está activa

		} else { // Si es página administrativa siempre esta activa

			return 1; // devuelve "Activa"

		}
	}
	/**
	 * Autenticacion :: ValidarSeguridad
	 * Valida la seguridad de la pagina $idcategoria
	 * @param int $idcategoria
	 * @param int $listasegura
	 * @return
	 */
	function ValidarSeguridad($idcategoria, &$listasegura) {

		global $db;

		// Si la página no tiene idcategoria se supone que es home
		$idcategoria   = ($idcategoria == '') ? 0 : $idcategoria ;

		// Verifica que la página no sea administrativa (edicion o indexadmin)
		if ($_SESSION['modo_edicion'] === FALSE or $_SESSION["modo_edicion_aprovado"] === FALSE) {

			$query   = sprintf("SELECT * FROM %s WHERE idcategoria = %s",_TBLCATEGORIA,$idcategoria);
			$result = $db->Execute($query);

			// Regreso en home page
			if (!$idcategoria) {

				return $listasegura;

				// En caso de que no sea home page siempre se hace validación

			} else {

				$query1  = sprintf("SELECT * FROM %s WHERE idcategoria = %s", _TBLACCESO, $idcategoria);
				$result1 = $db->Execute($query1);

				if ($result1 !== FALSE and $result1->NumRows() > 0){

					while (!$result1->EOF){
						array_push($listasegura, $result1->fields["idlista"]);
						$result1->MoveNext();
					}
					return $listasegura;

				} else {

					$row = $result->fields;
					return $this->ValidarSeguridad($row["idpadre"], $listasegura);

				}
			}
			// Si la página es administrativa (edicion o indexadmin) siempre devuelve zona máxima
		} else {

			array_push($listasegura, _ZONAADMIN);
			return $listasegura;

		}
	}
	/**
	 * Autenticacion :: BuscarUser
	 * @param string $username Nombre de Usuario
	 * @param boolean $fullData Dice si devuelve todos los datos del usuario o solo el id
	 * @return
	 */
	function BuscarUser($username, $fullData = FALSE) {

		global $db;

		$query  = sprintf("SELECT * FROM %s WHERE username = '%s'",_TBLUSUARIO,$username);
		$result = $db->Execute($query);

		if ($result !== FALSE and $result->NumRows() > 0) {
			if ($fullData === TRUE) {
				return $result->fields;
			} else {
				return $result->fields["idusuario"];
			}
		} else {
			return FALSE;
		}

	}
	/**
	 * Autenticacion :: esEditor
	 * Verifica que el usuario actual es editor del idcategoria donde se encuentra
	 * @param string $username
	 * @param integer $idcategoria
	 * @param integer $nivel
	 * @return
	 */
	function esEditor($username, $idcategoria ,$nivel = 0){

		global $db;	/** @see variables.php */
		global $trazaCategoria;	/** @see variables.php */

		$idusuario = Autenticacion::BuscarUser($username);
		$idusuario = (!$idusuario) ? 0 : $idusuario;

		if(!$idcategoria){$idcategoria = 0;}

		$query  = sprintf("SELECT * FROM %s E , %s U WHERE U.idusuario = E.idusuario and U.idzona = 2 and E.idusuario = %s AND idcategoria = %s"
						, _TBLEDITORES
						, _TBLUSUARIO
						, $idusuario
						, $idcategoria
						);
		$result = $db->Execute($query);
		$row    = $result->fields;


		$query2  = sprintf("SELECT * FROM %s WHERE idcategoria = %s",_TBLCATEGORIA,$idcategoria);
		$result2 = $db->Execute($query2);
		$row2    = $result2->fields; // Contenido del idcategoria

		// Ningun editor puede ser asignado a todo el sitio, solo a categorías específicas
		if($idcategoria == 0 || $idcategoria == "") {

			$es_editor = 0;
			return $es_editor;

		} else {

			if ($result->NumRows() > 0 && $nivel == 0) {

				$es_editor = 1;
				return $es_editor;

			} elseif ($result->NumRows() > 0 && $nivel > 0 && $row["tipoedicion"] > 0) {

				$es_editor = $row["tipoedicion"];
				return $row["permisos"];

			} else {
				return Autenticacion::esEditor($username, $row2["idpadre"], 1);
			}

		}
	}
	/**
	 * Autenticacion :: esAutorizado
	 * verifica que el usuario este autorizado
	 * @param
	 * @return
	 */
	function esAutorizado($username, $valseg) {
		global $db;	/** @see variables.php */

		$idusuario = $this->BuscarUser($username);
		$idusuario = (!$idusuario) ? 0 : $idusuario;

		$query     = sprintf("SELECT * FROM %s WHERE idusuario = %s", _TBLDETALLELISTA, $idusuario);
		$result    = $db->Execute($query);

		if ($result !== FALSE and $result->NumRows() > 0) {

			while (!$result->EOF){
				$row = $result->fields;
				for($i=0;$i < count($valseg); $i++){
					$es_autorizado = ($row["idlista"] == $valseg[$i])?1:0;
					if($es_autorizado){
						return 1;
						break;
					}
				}
				$result->MoveNext();
			}

		}
		return 0;
	}
	/**
	 * Autenticacion :: Registrar
	 * Registra la accion que realiza el usuario
	 * @param integer $idcategoria
	 * @param integer $accion
	 * @param integer $dato2
	 * @return
	 */
	function Registrar($idcategoria, $accion = 1, $cambioRealizado = '',$justificar){

		if (isset($_SESSION['info_usuario'])) {

			global $db;	/** @see variables.php */
			$registrar = sprintf("INSERT INTO %s (idcategoria,idusuario,accion,tiempo,ip,querystring,cambio,justificacion) VALUES ('%s','%s','%s',%s,'%s','%s','%s','%s')"
									,_TBLREGISTRO
									,$idcategoria
									,$_SESSION['info_usuario']['idusuario']
									,$accion
									,"now()"
									,$_SERVER['REMOTE_ADDR']
									,Autenticacion::secureSQL(($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:"",'indice')
									,$cambioRealizado
									,$justificar
								);
			$queryregistrar = $db->Execute($registrar);
		}
	}

	/**
	 * Autenticacion :: validarUsuario
	 * Valida que el usuario este loggeado, y guarda los valores del usuario en session
	 * para saber si está correctamente loggeado, mire si está seteado la variable $_SESSION["info_usuario"]
	 * @param $usuario
	 * @param $password
	 * @return
	 */
	function validarUsuario($usuario, $password) {

		//$hola2= $_SESSION['modo_edicion'];
		//echo "<script type='text/javascript'>alert('validarUsuario');</script>";

		//echo "<script type='text/javascript'>alert(' $usuario - $password');</script>";
		require_once(_DIRLIB_ADMIN."Usuario.class.php");

		global $db;	/** @see variables.php */
		global $ldap_params;

		/* Cuenta el numero de dominios posibles para hacer la autenticacion */
		$cantidad_ldap 	= count($ldap_params);

		/* Crea en inicializa la variable de control */
		$cargar_datos 	= false;
		$contador		= 0;
		$info["count"]	= 0;
		/**
		 * Modificacion para validar contra el Active Directory.
		 *
		 * Se busca el usuario con el username
		 * Si se encuentra
		 * 		se crea usuario y se ingresa clave de lo contrario
		 * 		se muestra mensaje de error
		 *
		 * @Milton Gonzalez
		 * @mayo 3 2007
		 * @Modified by Andres Lancheros
		 * @October 17 2007
		 */

		if("ldap" == _AUTH_TYPE)
		{
			while($contador < $cantidad_ldap && 0 == $info["count"])
			{
				// Se almacena el esquema en una variable
				$dn = $ldap_params[$contador]['dn'];

				//Hacemos la conexion a LDAP
				$conexion 	= ldap_connect($ldap_params[$contador]["servidor"], $ldap_params[$contador]["puerto"]);

				//Ejecutamos un bind con usuario de administracion creado para el portal
				$bind = ldap_bind($conexion,$ldap_params[$contador]["user"],$ldap_params[$contador]["pass"]);

				//Ejecutamos una busqueda consultando por el nombre de usuario
				$attributes = array ("cn"
									 ,"givenName"
									 );
				$filter 	= "(uid=$usuario)";

				$sr = ldap_search($conexion,$dn,$filter,$attributes);

				$info = ldap_get_entries($conexion, $sr);
				print($info);
				/* Incrementa el contador */
				$contador++;
			}

			//Verificamos si trae informacion
			if ($info["count"] > 0)
			{
				//hacemos un bind con el usuario y el password entregado
				$bind_user = @ldap_bind($conexion,$info[0]["uid"][0],$password);

				if($bind_user) //si es true el bind entonces el password corresponde
				{
					/* Obtiene la informacion del usuario del ldap */
					$nombres 		= Funciones::Removeaccents((isset($info[0]["givenname"][0]))?$info[0]["givenname"][0]:"");
					$apellidos 		= Funciones::Removeaccents((isset($info[0]["sn"][0]))?$info[0]["sn"][0]:"");
					$email 			= (isset($info[0]["userprincipalname"][0]))?$info[0]["userprincipalname"][0]:"";
					$telefono 		= (isset($info[0]["telephonenumber"][0]))?$info[0]["telephonenumber"][0]:"";
					$direccion 		= Funciones::Removeaccents((isset($info[0]["streetaddress"][0]))?$info[0]["streetaddress"][0]:"");
					$ciudad 		= Funciones::Removeaccents((isset($info[0]["l"][0]))?$info[0]["l"][0]:"");
					$pais 			= Funciones::Removeaccents((isset($info[0]["c"][0]))?$info[0]["c"][0]:"");
					$empresa 		= Funciones::Removeaccents((isset($info[0]["company"][0]))?$info[0]["company"][0]:"");

				    /* Si el usuario existe actualiza los datos y los carga en session
				     * Si no existe el usuario es creado en la tabla de usuarios del portal
					 */
				    $sql_info_usuario = sprintf("SELECT idusuario
				    							   FROM %s
				    							   WHERE username = '%s'",
				    							_TBLUSUARIO,
				    							$info[0]["samaccountname"][0]);
					$result_info_usuario = $db->Execute($sql_info_usuario);

					if($result_info_usuario && $result_info_usuario->NumRows()>0)
					{
						/* Obtiene el idusuario para hacer la actualizacion*/
						$idusuario 		= $result_info_usuario->fields['idusuario'];

						/* Crea el objeto que representa el usuario */
						$usuario_actual = new Usuario();
						if($usuario_actual->cargar($idusuario))
						{
							/* Actualiza la informacion del usuario */
							$usuario_actual->asignar($usuario,sha1($usuario.$password),$usuario_actual->idzona,$nombres,$apellidos,$email,$telefono,$direccion,$ciudad,$pais,$usuario_actual->cargo,$empresa,$usuario_actual->tipoidentificacion,$usuario_actual->identificacion,$usuario_actual->profesion,1);
							if($usuario_actual->modificar())
							{
								$cargar_datos=true;
							}
						}
					}
					else
					{
						$usuario_nuevo = new Usuario();
						$usuario_nuevo->asignar($usuario,$password,1,$nombres,$apellidos,$email,$telefono,$direccion,$ciudad,$pais,"",$empresa,"CC","","",1);
						if($usuario_nuevo->insertar())
						{
							$cargar_datos=true;
						}
					}
				}
			}

			/* Cierra la conexion al AD*/
			ldap_unbind($conexion);
		}
		else
		{
			$cargar_datos=true;
		}

		if($cargar_datos===true)
		{
			//Hacemos el HASH SHA1 del password y lo comparamos
			$password_sha1 = sha1($usuario.$password);
			//echo $usuario.$password;

			$sql = $db->prepare("SELECT * FROM " . _TBLUSUARIO . " WHERE password = ? and username = ? and activo = ?");
            $r = $db->Execute($sql, array($password_sha1,$usuario,1)) or errorQuery(__LINE__, __FILE__);
			/*$q = sprintf("SELECT * FROM %s WHERE username = '%s' and password = '%s' and activo = 1", _TBLUSUARIO, $usuario, $password_sha1);
			$r = $db->Execute($q);*/

			if ($r !== FALSE and $r->NumRows() > 0)
			{
				$_SESSION['info_usuario'] = $r->fields;
			}
			else
			{
				$sql = $db->prepare("SELECT * FROM " . _TBLUSUARIO . " WHERE password = ? and username = ? and activo = ?");
            	$r = $db->Execute($sql, array($password,$usuario,1)) or errorQuery(__LINE__, __FILE__);
				//$q = sprintf("SELECT * FROM %s WHERE username = '%s' and password = '%s' and activo = 1", _TBLUSUARIO, $usuario, $password);
				//var_dump($q);
				//$r = $db->Execute($q);
				if ($r !== FALSE and $r->NumRows() > 0)
				{
					$_SESSION['info_usuario'] = $r->fields;
				}
			}
		}

	}

	/**
	 * Funciones :: Logout
	 * Realiza la tarea de desloggear a la persona que se encuentra autenticada
	 * @return
	 **/
	function Logout(){

		$logout		 = (isset($_GET['logout']))?$_GET['logout']:(isset($_POST['logout'])?$_POST['logout']:"");

		if($logout == 1) {
			session_unset();	// Destruye las variables de session
			session_destroy();	//	Destruye la sesion

			/**
			 * Iniciamos la sesion para continuar con las variables basicas
			 */
			session_name(preg_replace('/\s+/', '', strtolower(_DBNAME)));
			session_start();
			$_SESSION['modo_edicion'] = FALSE;
			$_SESSION['modo_edicion_aprovado'] = FALSE;
			headerLocation('index.php?idcategoria='._SINICIO); // Lo manda al Home del Subsitio.
		}

		return;
	}
	/**
	 * Autenticacion :: validarUsuarioCategoria
	 * Validacion de acceso
	 * @param integer $idcategoria
	 * @return
	 */
	function validarUsuarioCategoria ($idcategoria) {

		$idcategoria = (isset($idcategoria)) ? $idcategoria : 0;
//echo $this->ValidarActiva($idcategoria).$idcategoria;
//die('..actualizando..');
		/**
		 * Está Activa la Categoria?
		 */
		if (!$this->ValidarActiva($idcategoria)){
			//header("HTTP/1.x 404 Not Found");
			$_SESSION['msg']='La categor&iacute;a a la que intenta acceder est&aacute; desactivada o no existe!!!';
        	header('Location:' . _URL . 'index.php?idcategoria='._SCONTACTO);
			// Cambio # 1
			//exit;
		}
		/**
		 * Validamos la seguridad del acceso al idcategoria actual.
		 */
		$listasegura = array();
		$this->ValidarSeguridad($idcategoria, $listasegura);
		$haySeguridad = count($listasegura); // si listasegura tiene campos es por que la categoria tiene seguridad

		if ($_SESSION['modo_edicion'] === TRUE) {
			/**
			 * Si entra a modo edicion
			 */
			if (!isset($_SESSION['info_usuario']) or $_SESSION['info_usuario']["activo"] != 1) { // verificamos el estado del usuario

				$_SESSION['modo_edicion_aprovado'] = FALSE;
				/**
				 * 2 = Para editar tiene que estar AUTENTICADO.
				 * @see login.php
				 */
				$this->enviarALogin($idcategoria, 2);

			} else {

				$es_editor = $this->esEditor($_SESSION['info_usuario']['username'],$idcategoria);
				$_SESSION['info_usuario']["es_editor"] = $es_editor;
				/**
				 * Verificamos si el usuario es un superadmin o si es un editor permitido
				 */
				if ($es_editor > 0 or $_SESSION['info_usuario']["idzona"] == _ZONAADMIN) {

					$_SESSION['modo_edicion_aprovado'] = TRUE;

				} else {

					//$_SESSION['modo_edicion'] = FALSE;
					$_SESSION['modo_edicion_aprovado'] = FALSE;
					/**
					 * 3 = NO tiene Permitido editar en esta categoria.
					 * @see login.php
					 */
					//$this->enviarALogin($idcategoria, 3);
				}
			}

		} elseif ($haySeguridad > 0) { // tiene seguridad la categoria ?

			if (isset($_SESSION['info_usuario'])) {	// Verificamos que este loggeado alguien para comprobar autorizacion
				/**
				 * Verificamos que sea permitido el acceso a la categoria
				 */
				$es_autorizado = $this->esAutorizado($_SESSION['info_usuario']['username'], $listasegura);

				/**
				 * Verificacion del permiso de edicion sobre la categoria
				 */
				$es_editor = $this->esEditor($_SESSION['info_usuario']['username'],$idcategoria);
				$_SESSION['info_usuario']["es_editor"] = $es_editor;

				if ($es_editor > 0 or $_SESSION['info_usuario']["idzona"] == _ZONAADMIN) {
					$_SESSION['modo_edicion_aprovado'] = TRUE;
				} else {
					$_SESSION['modo_edicion_aprovado'] = FALSE;
				}

				/**
				 * Verificacion de que este autorizado para ingresar
				 */
				if ($es_autorizado == 0 and $_SESSION['info_usuario']['idzona'] != 9) {
					/**
					 * 4 = NO tiene Permitido ingresar a esta categoria.
					 * @see login.php
					 */
					$this->enviarALogin($idcategoria, 4);
				}

			} else {
				/**
				 * 5 = Para entrar a esta zona tiene que estar AUTENTICADO
				 * @see login.php
				 */
				$this->enviarALogin($idcategoria, 5);

			}
		} else {
			if (isset($_SESSION['info_usuario'])) {	// Verificamos que este loggeado alguien para comprobar autorizacion

				$es_editor = $this->esEditor($_SESSION['info_usuario']['username'],$idcategoria);
				$_SESSION['info_usuario']["es_editor"] = $es_editor;

				if ($es_editor > 0 or $_SESSION['info_usuario']["idzona"] == _ZONAADMIN) {
					$_SESSION['modo_edicion_aprovado'] = TRUE;
				} else {
					$_SESSION['modo_edicion_aprovado'] = FALSE;
				}

			}
}

		/* Código para indicar si el usuario tiene acceso al panel de administración de pqr */
		/* Si el usuario es gestor o administrador, se indica en la variable de sesion, de tal forma que en el menú lateral tenga acceso al panel de administración de pqr */
		if( !function_exists("esGestorPqr") )
		    require('_lib/pqr/FuncionesPQR.php');
		if (isset($_SESSION['info_usuario'])) {	// Verificamos que este loggeado alguien para comprobar autorizacion
			if(esGestorPqr($_SESSION['info_usuario']['idusuario']) || esAdministradorPqr($_SESSION['info_usuario']['idusuario']) || esDigitadorPqr($_SESSION['info_usuario']['idusuario']))
			{
				$_SESSION['info_usuario']['acceso_pqr']	= true;
			}
			else
			{
				$_SESSION['info_usuario']['acceso_pqr']	= false;
			}
		}
		/* Fin de código para indicar si el usuario tiene acceso al panel de administración de pqr */

		/**
		 * Guardamos la navegacion del usuario registrado
		 */
		if (isset($_SESSION['info_usuario']) and isset($_SESSION['info_usuario']['nombres'])) {
			Autenticacion::Registrar($idcategoria, 0);
		}
	}
	/**
	 * Autenticacion :: enviarALogin
	 * Envia a la categoria login del sitio
	 * @param
	 * @return
	 */
	function enviarALogin($idcategoria, $tipoMsg) {
		if ($idcategoria != _SLOGIN) {

			if(isset($_GET['solicitud_id'])){
				$locat = sprintf("index.php?idcategoria=%s&cat_origen=%s&archivo_origen=%s&msg=%s&solicitud_id=%s"
							,_SLOGIN
							,$idcategoria
							,basename($_SERVER['PHP_SELF'])
							,$tipoMsg
							,$_GET['solicitud_id']
						);
			}
			else{
				$locat = sprintf("index.php?idcategoria=%s&cat_origen=%s&archivo_origen=%s&msg=%s"
							,_SLOGIN
							,$idcategoria
							,basename($_SERVER['PHP_SELF'])
							,$tipoMsg
						);
			}
			headerLocation($locat);
			// Cambio # 1
			//exit(0); // No ejecutamos nada mas
		}
	}

	/**
     * Autenticacion :: secureSQL
     * Realiza limpieza de caracteres y palabras peligrosas
     * @param string $strVar Cadena a validar
	 * @param String $autoSendReport Si es un correo electronico el sistma intenta enviar un correo en caso de detectar una posible intrusion.
     * @param string $key Llave para validaciones especiales.
     */
public static function secureSQL($strVar, $key = '', $autoSendReport = null)
	{
	 
	    if (is_array($strVar)) {
	        foreach($strVar as $id => $valor)
	        {
	            $strVar[$id] = Autenticacion::secureSQL($valor, $id);
	        }
	    } else {
	    	// convertir urls a texto
			$final = urldecode($strVar);
			// http://developers.evrsoft.com/articles/ref_extended_chars.shtml
			$caracteres_validos_esp = "".chr(188).chr(189).chr(190).chr(192).chr(193).chr(194).chr(195).chr(196).chr(197).chr(198).chr(199).chr(200).chr(201).chr(202).chr(203).chr(204).chr(205).chr(206).chr(207).chr(208).chr(209).chr(210).chr(211).chr(212).chr(213).chr(214).chr(215).chr(216).chr(217).chr(218).chr(219).chr(220).chr(221).chr(222).chr(223).chr(224).chr(225).chr(226).chr(227).chr(228).chr(229).chr(230).chr(231).chr(232).chr(233).chr(234).chr(235).chr(236).chr(237).chr(238).chr(239).chr(240).chr(241).chr(242).chr(243).chr(244).chr(245).chr(246).chr(247).chr(248).chr(249).chr(250).chr(251).chr(252).chr(253).chr(254).chr(255);
			//Tener cuidado en esta parte, ya que algunos portales necesitan el utf8_encode
			$caracteres_validos_esp = utf8_encode($caracteres_validos_esp);
			//Reemplazamos caracteres no alfanumericos y especiales
			$final = preg_replace( "/[^\w\s".$caracteres_validos_esp."\.;,@#()!<>%\\\\\/&_\:\-\?=~\[\]\\\"]/", "", $strVar );

			$arregloExpresiones = array("/\binsert\b/i","/\bprompt\b/i","/\bselect\b/i","/\bdelete\b/i","/\blike\b/i","/\bscript\b/i","/\bjavascript\b/i","/\bcookie\b/i","/\bnull\b/i","/\bdrop\b/i","/\balter\b/i","/\bprompt\b/i","/\bschema\b/i","/\binformation_schema\b/i","/\belse\b/i","/\bif\b/i","/\bdatabase\b/i","/\b table \b/i","/\bgrant\b/i","/\bsetuser\b/i","/\btrigger\b/i","/\bvalues\b/i","/\bexists\b/i","/\bdump\b/i","/\bconcat\b/i","/\bunlock\b/i","/\brevoke\b/i","/\breplicate\b/i","/\bsynchronize\b/i","/\bimplicit_schema\b/i","/\btruncate\b/i","/\bremane\b/i","/\bjoin\b/i","/\bcommit\b/i","/\bsavepoint\b/i","/\brollback\b/i","/\bmerge\b/i","/\bcall\b/i","/\bexplain\b/i","/\block\b/i","/\bconnect\b/i","/\busage\b/i","/\btransaction\b/i","/\bshow\b/i","/\bdescribe\b/i","/\bsynonym\b/i","/\bdistinct\b/i","/\bdeclare\b/i","/\bfetch\b/i","/\bopen\b/i","/\bclose\b/i","/\binner\b/i","/\bintersect\b/i","/\bminus\b/i","/\bouter\b/i");
			// Se eliminan comandos peligrsos
			$final = preg_replace( $arregloExpresiones, "", $final );
	        // Se hace un strip tags (quitar etiquetas html y php) y definimos arreglo de caracteres adicionales a filtrar
			//se hace una excepcion de seguridad para restringir solo un conjunto reducido de caracteres
			//Si es el campo descripcion permitimos ciertas etiquetas
			if ( $key =="entradilla_form" || $key == 'Text1' || $key == '_INFO_ADICIONAL'|| substr($key,0,2) == '__' ||  $key == 'pie_imagen_form') {
				$final = strip_tags($final, '<p><br><a><table><td><tr><th><img><li><ul><ol><strong><em><div><hr><embed><object><param><span><iframe><h1><h2><h3><h4><h5><h6>');
	        } else {
	        	// Tenga cuidado con los carácteres que restringe aquí
	        	// ya que pueden coincidir con los que hagan parte de la contrseña de algún usuario
	        	$peligros = ["||",";", "--", "'","<",">","*","\\","(",")","+"];
	            $final = strip_tags($final);
			}

			if (!is_null($autoSendReport) && $autoSendReport != "" && strlen($final) != strlen($strVar)) {
				// Envio de reporte automatico y deteccion de cambio en la longitud de la cadena original
				$e = new Exception();
				try {
					$body = "El portal "._RUTABASE." ha detectado un intento invalido de datos en las peticiones, a continuacion va el dump de la variable \$_SEVER<br>";
					foreach ($_SERVER as $key => $value) {
						if (is_string($value)) {
							$body .= "$key => $value<br>";
						}
					}
					// @Funciones::microsmail($autoSendReport, "Posible intento de hack", $body, $autoSendReport, __FILE__);
				} catch( Exception $e ) {
					// print($e);
				}
			}

	        //Reemplazamos caracteres peligrosos
	        if (isset($peligros)) {
	        	$final = str_replace($peligros, "", $final);
	        }
	        $strVar = $final;
	    }
//echo "<script type='text/javascript'>alert('$strVar');</script>";
	  return $strVar;
    }

	function getRealIpAddr() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

}
?>
