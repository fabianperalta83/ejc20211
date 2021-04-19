<?php
/**
 * Class Funciones
 * Trae todas las funciones habidas y por haber para el reconocimiento
 * de categorias en el portal
 * @package Núcleo
 * @author Juan Manuel Hernández <jhernandez@micrositios.net>
 * @version
 * @copyright Copyright © 2005 Micrositios Ltda.
 */
class Funciones {


	/**
	 * Funciones :: contadorClickPagina
	 * Funcion para aumentar en el número de visitas a la página idcategoria
	 * @var global idcategoria
	 * @var db idcategoria
	 * @return
	 **/
	public static function contadorPagina()
    {
        if(!$_SESSION['count'])
        {
            global $db;
            session_start();           
            $_SESSION['count']=true;
            $query='SELECT varsubsitio FROM categoria WHERE idcategoria='._SINICIO;  		
			$result=$db->Execute($query);
            $array=$result?$result->GetRows():array();
            $array=stringtoarray($array[0]['varsubsitio']);
            $count=count($array);
            for($i=0;$i<$count;$i++)
            {
               if($array[$i]['n']=='_CONTADOR')
               {
                  $array[$i]['v']++;             
                  $string=arraytostring($array);
                  $query='UPDATE categoria SET varsubsitio=\''.$string.'\' WHERE idcategoria='._SINICIO;
                  $result=$db->Execute($query);  
                  break;
               }
            }           
        }
    }



	/**
	 * Funciones :: contadorClickPagina
	 * Funcion para aumentar en el número de visitas a la página idcategoria
	 * @var global idcategoria
	 * @var db idcategoria
	 * @return
	 **/
	public static function contadorClickPagina() {
		global $idcategoria;	/** @see variables.php */
		global $db;		/** @see variables.php */

		//La tabla categorias es una de las mas consultadas de la base de datos y este UPDATE constantemente hace que se bloquee
                //asi que dado que no realiza una funcion vital, opte por comentarlo
		//
		//$q = sprintf("UPDATE %s SET cuenta = cuenta + 1 WHERE idcategoria = %s", _TBLCATEGORIA, $idcategoria);
		//$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
	}
	/**
	 * Funciones :: BuscarRoot
	 * Función que busca la categoría raiz de la categoría consultada
	 * @param  integer $idcategoria
	 * @return integer
	 **/
	public static function BuscarRoot($idcategoria = 1) {
		global $db;	/** @see variables.php */

		$query = $db->prepare("SELECT * FROM ". _TBLCATEGORIA ." WHERE idcategoria = ? ");
		$result = $db->Execute($query,array($idcategoria)) or errorQuery(__LINE__, __FILE__);

		if ($result !== FALSE and $result->NumRows() > 0) {
			$num_rows = $result->NumRows();
			$row = $result->fields;

			if($num_rows > 0 && ($row["idcategoria"] == 1 || $row["es_root"] == 1)){
				return $row["idcategoria"];
			} else {
				return trim(Funciones::BuscarRoot($row["idpadre"]));
			}
		} else {
			headerLocation(FriendlyURL::idCat2FId( $db,352900));
			exit(0);
		}
	}
	/**
	 * Funciones :: BusquedaRecursiva
	 * Busca una caracteristica especifica de un idcategoria
	 * @param integer $idcategoria
	 * @param string $campo
	 * @param integer $retornar_id
	 * @return
	 **/
	public static function BusquedaRecursiva($idcategoria, $campo){

		global $trazaCategoria;	/** @see variables.php */

		$trazaCategoriaAux = array();

		if ($idcategoria > 0) {

			if (!isset($trazaCategoria[$idcategoria])) {
				$trazaCategoriaAux = Funciones::obtenerInfoCategoria($idcategoria);
			} else {
				$trazaCategoriaAux = $trazaCategoria;
			}
			$idAux = $idcategoria;

			/**
			 * En caso de que sea el root del sitio ó el inicio del portal
			 */
			if ($trazaCategoriaAux[$idAux]["idpadre"] == 0) {
				if (!empty($trazaCategoriaAux[$idAux][$campo])) {

					return $trazaCategoriaAux[$idAux][$campo];

				} else {
					/**
					 *  Si no encontro valores heredados, usamos los valores por default.
					 */
					$tmp = "_DEF_".strtoupper($campo);
					eval("\$val_default = $tmp;");
					return trim($val_default);
				}
			}

			/**
			 * En el caso de que no sea el root del sitio ni el inicio del portal
			 */

			while($idAux != 0) {
				$row = $trazaCategoriaAux[$idAux];
				if($row[$campo] != '' && $row[$campo] != '0') {
					return $trazaCategoriaAux[$idAux][$campo];
				} else {
					$idAux = $trazaCategoriaAux[$idAux]["idpadre"];
				}
			}

			/**
			 *  Si no encontro valores heredados, usamos los valores por default.
			 */
			$tmp = "_DEF_".strtoupper($campo);
			eval("\$val_default = $tmp;");
			return trim($val_default);
		} else {
			global $sroot;
			if (!isset($trazaCategoria[$sroot])) {
				$trazaCategoriaAux = Funciones::obtenerInfoCategoria($sroot);
			} else {
				$trazaCategoriaAux = $trazaCategoria;
			}
			return $trazaCategoriaAux[$sroot][$campo];
		}
	}
	/**
	 * Funciones :: BuscarNombre
	 *
	 *
	 * @param integer $idcategoria
	 * @return
	 **/
	function BuscarNombre($idcategoria = 1) {

		global $db;	/** @see variables.php */
		global $trazaCategoria;	/** @see variables.php */

		if (!isset($trazaCategoria[$idcategoria])) {
			$trazaCategoriaAux = Funciones::obtenerInfoCategoria($idcategoria);
		} else {
			$trazaCategoriaAux = $trazaCategoria;
		}

		$idcategoria = ($idcategoria == '')?0:$idcategoria;

		if (isset($trazaCategoria[$idcategoria])) {
			$link = $trazaCategoria[$idcategoria]["nombre"];
		} else {
			$link = "Home";
		}
		return str_replace("%","&divide;",$link);
	}

	/**
	 * Funciones :: buscarNombreTemplate
	 *
	 * Encuentra el nombre del template para el idcategoria actual
	 * @param integer $idcategoria
	 * @param string $nombre
	 * @return
	 **/
	public static function buscarNombreTemplate($idcategoria,$nombre='')	{
		global $db;	/** @see variables.php */

		$template = Funciones::BusquedaRecursiva($idcategoria, 'template');

		if(is_file(_DIRTEMPLATES . _SLASH . $template . _SLASH . "templates" . _SLASH  .$nombre)) {
			return $template;
		} else {
			return "Default";
		}
	}

	function Removeaccents($string){
		$string = strtr($string, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
		"aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
		return $string;
	}
	/**
	 * Funciones :: BuscarTipoSeccion
	 * @param integer $idcategoria
	 * @return
	 */
	function BuscarTipoSeccion($idcategoria = 1) {
		global $trazaCategoria;	/** @see variables.php */
		$idcategoria = ($idcategoria == '') ? 0 : $idcategoria;

		if (!isset($trazaCategoria[$idcategoria])) {
			$trazaCategoriaAux = Funciones::obtenerInfoCategoria($idcategoria);
		} else {
			$trazaCategoriaAux = $trazaCategoria;
		}

		if (isset($trazaCategoria[$idcategoria])) {
			$link = $trazaCategoria[$idcategoria]['iddisplay'];
		} else {
			$link = 0;
		}
		return $link;
	}

	function BuscarSubTipoSeccion($idcategoria = 1){
		global $trazaCategoria;	/** @see variables.php */
		$idcategoria = ($idcategoria == '') ? 0 : $idcategoria;

		if (!isset($trazaCategoria[$idcategoria])) {
			$trazaCategoriaAux = Funciones::obtenerInfoCategoria($idcategoria);
		} else {
			$trazaCategoriaAux = $trazaCategoria;
		}

		if (isset($trazaCategoria[$idcategoria])) {
			$link = $trazaCategoria[$idcategoria]['iddisplay_sub'];
		} else {
			$link = 0;
		}
		return $link;
	}

	/**
	 * Funciones :: BuscarHijos
	 * Esta funcion busca los hijos de la categoria $idcategoria
	 * @param integer $idcategoria
	 * @return
	 **/
	public static function BuscarHijos($idcategoria = 0){
		global $db;	/** @see variables.php */

		if (0 != $idcategoria){

			$orden_tmp = Funciones::BusquedaRecursiva(Funciones::BuscarPadre($idcategoria),"orden_sub");
			$tmp = Funciones::BusquedaRecursiva($idcategoria,"asc_sub");

			switch ($tmp) {
				case 1: $asc_tmp = "desc"; break;
				case 2: $asc_tmp = "asc"; break;
			}

//			$phpself = sprintf("%s", FriendlyURL::idCat2FId( $db, $idcategoria ));

			$query		= $db->prepare("SELECT * FROM ". _TBLCATEGORIA ." WHERE activa != 0 AND idpadre = ? ORDER BY ? ?");
			$result		= $db->Execute($query,array($idcategoria,$orden_tmp,$asc_tmp)) or errorQuery(__LINE__, __FILE__);

			if ($result !== FALSE and $result->NumRows() > 0 and $idcategoria > 0){
			    
				$i = 0;
				$categorias = array();
				while (!$result->EOF){
					$row = $result->fields;
					$i++;
					$categoria['id'] = $row["idcategoria"];
					$categoria['vinculo'] = FriendlyURL::idCat2FId($db, $row["idcategoria"] );
					$categoria['nombre'] = $row["nombre"];
					$categoria['imagen'] = $row["imagen"];
					$categoria['entradilla'] = $row['entradilla'];
					$categoria['subtitulo'] = $row['subtitulo'];
					$categoria['antetitulo'] = $row['antetitulo'];
					$categoria['descripcion'] = $row['descripcion'];
					switch ($i) {
						case 1: $posicion = 1; break;
						case $result->NumRows(): $posicion = 3; break;
						default: $posicion = 2; break;
					}
					$categoria['posicion'] = $posicion;
					$categorias[] = $categoria;

					$result->MoveNext();
				}
				return $categorias;
			}
		}
	}

	function BuscarTipoDisplay($matriz=0,$iddisplay=10){
		//	Función que Busca todas las categorías que tienen
		//  aplicado un template Específico
		//	$matriz:	1 si se espera el resultado como una matriz
		//				0 si se quieren ver los resultados en una variable
		//				separada por comas
		//	$iddisplay: número con que se identifica el template que se quiere buscar
		//				(ver el arreglo $display en la función DisplayCategoria)

		global $db;	/** @see variables.php */

		$query = sprintf("SELECT idcategoria FROM %s WHERE iddisplay = '%s'", _TBLCATEGORIA,$iddisplay);
		$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);
		$Validos = array();

		if($result !== FALSE and $result->NumRows() > 0) {

			while (!$result->EOF){
				$row = $result->fields;
				array_push($Validos ,$row["idcategoria"]);
			}

			if(!$matriz) {
				$Validos=implode(",",$Validos);
			}
			return $Validos;

		} else {

			return;

		}
	}
	/**
	 * Funciones :: DisplayCategoria
	 * Muesta el template segun el iddisplay de la categoria
	 * @param integer $idcategoria
	 * @return HTML del iddisplay del idcategoria
	 **/
	public static function DisplayCategoria($idcategoria){

		global $db;	/** @see variables.php */
		global $trazaCategoria; /** @see variables.php */
		global $display; /** @see variables.php */
		require_once(_DIRCORE."Edicion.class.php");
		
		$idcategoria = (0 == $idcategoria)?1:$idcategoria;
		$infoCategoria = $trazaCategoria[$idcategoria]; /** Cargamos la informacion de la categoria actual */

		if (count($infoCategoria) > 0) {

			if(isset($display[$infoCategoria["iddisplay"]][0])) {

				/**
				 * Verificamos que no este llamando a un objeto especifico
				 */
				$seCargoObjDisplay = FALSE;
				$seCargoObjEdicion = FALSE;

				if (!empty($display[$infoCategoria["iddisplay"]][3])) {

					$nameObj = $display[$infoCategoria["iddisplay"]][3];

					if(is_file(_DIRCORE.$nameObj.".class.php")) {

						require_once(_DIRCORE.$nameObj.".class.php");

						if(class_exists($nameObj)) {
							$unFuncionesDisplay = new $nameObj();
							/**
							 * Por ultimo verificamos que existan la funcion de display en el objeto
							 */
							if (method_exists($unFuncionesDisplay, $display[$infoCategoria["iddisplay"]][0])) {
								$seCargoObjDisplay = TRUE;
							}
							/**
							 * Tambien verificamos si el
							 */
							$unEdicion = new $nameObj();
							if (method_exists($unEdicion, "TemplateEdicion")) {
								$seCargoObjEdicion = TRUE;
							}
						}
					}
				}
				/**
				 * Se cargo el objeto personalizado para el template actual?
				 */
				if($seCargoObjEdicion === FALSE) { /** Si no se cargo, cargamos los default */
					require_once(_DIRCORE."Edicion.class.php");
					$unEdicion =  new Edicion();
				}
				if($seCargoObjDisplay === FALSE) { /** Si no se cargo, cargamos los default */
					$unFuncionesDisplay = new FuncionesDisplay();
				}

				if (isset($_SESSION['info_usuario']) and $_SESSION["modo_edicion"] === TRUE and $_SESSION["modo_edicion_aprovado"] === TRUE) {
					if(method_exists($unFuncionesDisplay, $display[$infoCategoria["iddisplay"]][0])) {

						if ($display[$infoCategoria["iddisplay"]][1]) {

							$show = $unEdicion->TemplateEdicion($idcategoria);

						} else {

							$show = $unFuncionesDisplay->$display[$infoCategoria["iddisplay"]][0]($idcategoria);

						}

					} else {

						$show = sprintf ("<div class=advertencia>Tipo de secci&oacute;n %s sin implementar<br>Escoja otro!!</div>", $display[$infoCategoria["iddisplay"]][2]);
						$show .= $unEdicion->TemplateEdicion($idcategoria);

					}

				} else {

					if(method_exists($unFuncionesDisplay, $display[$infoCategoria["iddisplay"]][0])) {

						$show = $unFuncionesDisplay->$display[$infoCategoria["iddisplay"]][0]($idcategoria);

					} else {

						$show = $unFuncionesDisplay->TemplateDefault($idcategoria);

					}

				}

			} else {

				if (isset($_SESSION['info_usuario']) and $_SESSION["modo_edicion"] === TRUE	and $_SESSION["modo_edicion_aprovado"] === TRUE) {
			  		$unEdicion = new Edicion();
					$show = $unEdicion->TemplateEdicion($idcategoria);

				} else {

					$unFuncionesDisplay = new FuncionesDisplay();
					$show = $unFuncionesDisplay->TemplateDefault($idcategoria);

				}
			}
			return $show;
		}
	}
	/**
	 * Funciones :: DisplaySubMenu
	 *
	 * @return
	 **/
	function DisplaySubMenu($idcategoria, $iddisplay_sub){

		global $display_sub; /** @see variables.php */

		if($idcategoria != 0){

			switch ($iddisplay_sub) {
				case 1:$show = FuncionesDisplay::$display_sub[$iddisplay_sub][0]($idcategoria, 'tpl_subMenuLista');
					break;
				case 2:$show = FuncionesDisplay::$display_sub[$iddisplay_sub][0]($idcategoria, 'tpl_subMenuResumen');
					break;
				case 3:$show = FuncionesDisplay::$display_sub[$iddisplay_sub][0]($idcategoria, 'tpl_subMenuContenido');
					break;
				case 4:$show = FuncionesDisplay::$display_sub[$iddisplay_sub][0]($idcategoria, 'tpl_subMenuDescarga');
					break;
				case 0:
				case 5:
				case 6:
				case 7:
				case 8:
				case 9:
				case 12:
				case 11: $show = FuncionesDisplay::$display_sub[$iddisplay_sub][0]($idcategoria); break;
				case 10: $show = "";break;
				case 13: $show = FuncionesDisplay::$display_sub[$iddisplay_sub][0]($idcategoria); break;
				case 14: $show = FuncionesDisplay::$display_sub[$iddisplay_sub][0]($idcategoria) ;break;
			    case 15: $show = FuncionesDisplay::$display_sub[$iddisplay_sub][0]($idcategoria); break;
				case 16: $show = FuncionesDisplay::$display_sub[$iddisplay_sub][0]($idcategoria); break;
				case 17: $show = FuncionesDisplay::$display_sub[$iddisplay_sub][0]($idcategoria); break;
				case 18: $show = FuncionesDisplay::$display_sub[$iddisplay_sub][0]($idcategoria); break;
				case 19: $show = FuncionesDisplay::$display_sub[$iddisplay_sub][0]($idcategoria); break;
				case 20: $show = FuncionesDisplay::$display_sub[$iddisplay_sub][0]($idcategoria); break;
				default:
					$show = FuncionesDisplay::$display_sub[0][0]($idcategoria);
			}
			return $show;
		}

	}
	/**
	 * Funciones :: CantidadUsuarios
	 * Devuelve la cantidad de usuarios dada una lista
	 * @param int $idlista
	 * @return int
	 */
	function CantidadUsuarios($idlista){
		global $db;
		$query	 = sprintf("SELECT * FROM %s WHERE idlista = '%s'", _TBLDETALLELISTA, $idlista);
		$result	= $db->Execute($query) or errorQuery(__LINE__, __FILE__);
		if ($result !== FALSE and $result->NumRows() > 0) {
			return $result->NumRows();
		} else {
			return 0;
		}
	}
	/**
	 * Funciones :: BuscarPadre
	 *
	 * Busca el padre de la categoria Actual
	 * @param integer $idcategoria
	 * @return
	 **/
	public static function BuscarPadre($idcategoria = 1){

		global $trazaCategoria;

		$idcategoria = ($idcategoria == '') ? 0 : $idcategoria;

		if (isset($trazaCategoria[$idcategoria])) {

			return $trazaCategoria[$idcategoria]["idpadre"];

		} else {
			global $db;
			$query = $db->prepare("SELECT * FROM ". _TBLCATEGORIA ." WHERE idcategoria = ?");
			$result = $db->Execute($query,array($idcategoria)) or errorQuery(__LINE__, __FILE__);

			if ($result !== FALSE and $result->NumRows() > 0){

				$row = $result->fields;
				$link = $row["idpadre"];

			} else {

				$link = 0;

			}
			return $link;

		}
	}
	/**
	 * Funciones :: buscarSeccionPrimerNivel
	 *
	 * Esta función saca el primer nivel al cual pertenece el idcategoria actual
	 * @param integer $idcategoria
	 * @param integer $j
	 * @return integer
	 **/
	public static function buscarSeccionPrimerNivel($idcategoria = 0,$j = 0){

		global $db;
		$j++;
		$query = $db->prepare("SELECT * FROM ". _TBLCATEGORIA ." WHERE idcategoria = ? and activa != 0");
		$result = $db->Execute($query,array($idcategoria)) or errorQuery(__LINE__, __FILE__);

		if ($result !== FALSE and $result->NumRows() > 0) {
			$num_rows= $result->NumRows();
			$row = $result->fields;
			if($row["idpadre"] == _SINSTITUCIONAL || $row["idpadre"] == _SUTILIDADES){
				$ev[0] = $idcategoria;
				$ev[1] = $row['nombre'];
				$ev[2] = $row['subtitulo'];
				$ev[3] = $j;
				return $ev;
				break;
			} else {
				return Funciones::buscarSeccionPrimerNivel($row["idpadre"], $j);
				break;
			}

		} else {
			return 0;
		}
	}
	
	/**
	 * Funcion para enviar mensaje de texto. 
	 * 
	 * Envia a traves de una pasarlela de envio de mensajes de texto.  Guarda en una tabla el log de la transaccion
	 * 
	 * @param $telefono 
	 * @param $mensaje
	 * @param $origen desde donde se invoca la funcion, puede ser un modulo o nombre de archivo. Para seguimiento.
	 * @return bool 1 - indica OK, 0 - ERROR
	 */
	function microsms($telefono, $mensaje, $origen = ''){
		global $db;

		//Armar Url para enviar mensaje
		$url = _SMS_SERVIDOR."?sessionid=".md5(_SMS_USUARIO._SMS_PASSWORD.$telefono)."&numero=".$telefono."&texto=".str_replace(' ','%20',$mensaje);

		//enviar el mensaje
		$estado = file_get_contents($url);

		//Verificar si viene un mensaje de OK
		if (stripos($estado, '=')!==false)
		{
			//Obtener parametros para registro de log
			list ($transaccion, $estado) = explode('=', $estado);
			$transaccion = substr($transaccion, strpos($transaccion,'[')+1, strpos($transaccion,']')-strpos($transaccion,'[')-1);
			
			//Guardar log
			$sql = sprintf("INSERT INTO %s VALUES ('%s','%s','%s','%s','%s')", _TBLSMS, $transaccion, $telefono, $origen, $mensaje, $estado);
			$db->Execute($sql) or die("Error: +".__LINE__.' en '.__FILE__);
			
			return (stripos($estado, "OK")!==false) ? 1 : 0 ;
		}
		else
		{
			return 0;
		}
	}

	
	function mailPqr($correo_encargado,$asunto_correo,$mensaje_responsable,$cabezote,$adjuntos){
	
	  global $db;
	  require_once(_DIRCORE."class.phpmailer.php");
	  require_once(_DIRCORE."class.smtp.php");
	  
	  $mail = new PHPMailer();
	  
	  $mail -> IsHTML (true);
	  $mail->Host = "smtp.gmail.com";
	  $mail->From = $cabezote;
      $mail->FromName = "Ejercito Nacional de Colombia";
      $mail->Subject = $asunto_correo;
      $mail->AddAddress($correo_encargado);
     /* $mail->AddCC("usuariocopia@correo.com");
      $mail->AddBCC("usuariocopiaoculta@correo.com"); */
 
      /*$body  = "Hola <strong>amigo</strong><br>";
      $body .= "probando <i>PHPMailer<i>.<br><br>";
      $body .= "<font color='red'>Saludos</font>";*/
      $mail->Body = $mensaje_responsable;
     /* $mail->AltBody = "Hola amigo\nprobando PHPMailer\n\nSaludos";*/
      $mail->AddAttachment($adjuntos);
      $mail->Send();
	  
	/*  
	  $mail -> From = $cabezote;
      $mail -> FromName = "Web Ejercito Nacional";
      $mail -> AddAddress($correo_encargado);
      $mail -> Subject = $asunto_correo;
      $mail -> Body = $mensaje_responsable;
      $mail -> IsHTML (true);

	  $mail->IsSMTP(); // telling the class to use SMTP
	  
      $mail->Host = 'ssl://smtp.gmail.com';
      $mail->Port = 587; //antes 465
      $mail->SMTPAuth = true;
      $mail->Username = 'ejercitomilco@gmail.com';
      $mail->Password = 'ejercito2009';
	  
       if(!$mail->Send()) {
         echo 'Error: ' . $mail->ErrorInfo;
       }
        else
        {       
	      echo 'Mail enviado!';
        }
		
	*/	
	
	}
	
	

	/**
	 * Funciones :: microsmail
	 * @param
	 * @return
	 */
	function microsmail($p1,$p2,$p3,$p4 = '',$p6='',$p7='', $kalive = false){
		global $db;
		
		/*aramirez: para intentar enviar el newsletter debido a que no llegan a ***@ejercito.mil.co */
		/* Se usa la clase phpmailer para enviar el correo a través
		de un servidor smpt remoto */
		require_once(_DIRCORE."class.phpmailer.php");
		require_once(_DIRCORE."class.smtp.php");

		$mail = new PHPMailer();
		
		$mail->IsSMTP(); // telling the class to use SMTP
		/* $mail->Host       = "mail.yourdomain.com"; // SMTP server */
		$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
		
		
		/*** Nueva configuración envio de correo por medio del host localhost ***/
	$mail->Host = "localhost";
	$mail->Port = 25;
/* 
		
		 $mail->SMTPAuth   = true;  
        	 $mail->SMTPSecure = "ssl"; 
		 $mail->Host       = "smtp.gmail.com"; 
		$mail->Port       = 587;
		$mail->Username   = "ejercitomilco@gmail.com";
		 $mail->Password   = "ejercito2009";
*/		
		
	 $mail->FromName   = "Web Ejercito Nacional de Colombia";
//	 $mail->From       = "webejercito@gmail.com";
	 $mail->From       = "webejercito@ejercito.mil.co";
		
		
		
		if($kalive == true)
		{
			$mail->SMTPKeepAlive = true;
		}
		
		/* Define el remitente */
		if(!$p4 || $p4 == 'From:')
		{
			$mail->SetFrom(_EMAIL, _NOMBRESITIO);
			$p4				= _EMAIL;
		}
		else
		{
			$mail->SetFrom($p4, _NOMBRESITIO);
		}
		
		/*Is the OS Windows or Mac or Linux*/
		if (strtoupper(substr(PHP_OS,0,3)=='WIN'))
		{
			$eol="\r\n";
		}
		elseif (strtoupper(substr(PHP_OS,0,3)=='MAC'))
		{
			$eol="\r";
		}
		else
		{
			$eol="\n";
		}

		$mail->Subject    = $p2;

		$premsg = strip_tags($p3,'<br><br /><br/>');
		$premsg .= str_ireplace("<br>",$eol,$premsg);
		$premsg .= str_ireplace("<br />",$eol,$premsg);
		$premsg .= str_ireplace("<br/>",$eol,$premsg);

		$mail->AltBody    = $premsg; // optional, comment out and test
		$mail->MsgHTML($p3);

		$mail->AddAddress($p1, "");

		/* $mail->AddAttachment("images/phpmailer.gif");      // attachment */
		/* $mail->AddAttachment("images/phpmailer_mini.gif"); // attachment */

		if($mail->Send())
		{
			$p5 = "exito";
		}
		else
		{
			/*$mail->ErrorInfo;*/
			$p5 = "fracaso";
		}
		if($kalive == false)
		{
			$mail->SmtpClose();
		}
		
		
		/* original */
		// if('' == $p4)
		// {
			// $p4 = "From:"._EMAIL."\r\nContent-Type:text/html";
		// }
		// else
		// {
			// $p4 = "From:".$p4."\r\nContent-Type:text/html";
		// }
		
		// if( mail($p1,$p2,$p3,$p4)){
			// $p5 = 'exito';
		// } else {
			// $p5 = 'fracaso';
		// }

		$p4 = explode("\r\n",$p4);

		$p3 = str_replace(chr(39),'',$p3);
		if(!isset($p4[1]) || strpos($p4[1],"html") === false){
			$p3 = str_replace("\t",'&nbsp;',$p3);
			$p3 = str_replace("\n",'<br />',$p3);
			$p3 = nl2br($p3);
		}

		$query = sprintf("INSERT INTO %s (mail_para,mail_asunto,mail_mensaje,mail_de,mail_adicional,mail_fecha_hora,mail_status,mail_pagina,mail_info) VALUES ('%s','%s','%s','%s','%s',null,'%s','%s','%s')"
						,_TBLMAIL
						,$p1
						,$p2
						,$p3
						,trim(str_replace("From:","",$p4[0]))
						,(isset($p4[1]))?$p4[1]:""
						,$p5
						,$p6
						,$p7
						);
		//echo $query;
		$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);

		if($p5 == 'exito'){
			return 1;
		} else {
			return 0;
		}
	}
	/**
	 * Funciones :: esAdministrador
	 * @param $usuario
	 * @param $password
	 * @return
	 */
	function esAdministrador($usuario, $password){
		global $db;
		$query = $db->prepare("SELECT * FROM "._TBLUSUARIO." WHERE username=? AND password = ?");
		$result = $db->Execute($query,array($usuario,$password));
		if($result->fields["idzona"] == _ZONAADMIN){
			return 1;
		}else{
			return 0;
		}
	}
	/**
	 * Funciones :: obtenerInfoCategoria
	 * @param
	 * @return
	 */
	public static function obtenerInfoCategoria($idcategoria) {
		global $db;
		global $trazaCategoria;

		$arrayCategorias = array();
		$select = " idcategoria, idpadre, activa, orden, orden_sub, asc_sub, paginas_sub, restringida, iddisplay, iddisplay_sub
					, template, fecha1, fecha2, fecha3, es_prototipo, es_root, autor, convert(cast(convert(nombre using utf8) as binary) using latin1) AS nombre, antetitulo, subtitulo, entradilla
					, descripcion, imagen, validacion, idioma, eliminado, varsubsitio, en_buscador, en_mapa, es_rss, pie_imagen";
		$q = $db->prepare("SELECT ".$select." FROM "._TBLCATEGORIA." WHERE idcategoria = ?");
		$r = $db->Execute($q,array($idcategoria));

		if ($r !== FALSE and $r->NumRows() > 0) {

			$arrayCategorias[$r->fields["idcategoria"]] = $r->fields;

			//while($r->fields["es_root"] != 1) {
			while($r->fields["idpadre"] != 0) {

				$q = sprintf("SELECT * FROM %s WHERE idcategoria = '%s'", _TBLCATEGORIA, $r->fields['idpadre']);
				$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
				$arrayCategorias[$r->fields["idcategoria"]] = $r->fields;

				/**
				 * En caso de que no tenga en la traza general la metemos
				 */
				if (!isset($trazaCategoria[$r->fields["idcategoria"]])) {
					$trazaCategoria[$r->fields["idcategoria"]] = $r->fields;
				}

			}

		}
		return $arrayCategorias;
	}
	/**
	 * Funciones::Navegacion
	 * @param $idcategoria
	 * @param object $result
	 */
	function Navegacion($idcategoria, $result) {

		global $db; /** @see variables.php */
		$smarty = new Smarty_Plantilla();
		$smarty->assign('paginas', $result->values);
		$smarty->assign('numPaginas', $result->numPaginas);

		$smarty->assign('idcategoria', $idcategoria);
		$smarty->assign('rutaRecursos',_DIRRECURSOS);

		return $smarty->fetch('tpl_paginacion.html');

	}
	/**
	 * Funciones::BuscarRSSCategoria
	 * @param integer $idcat
	 */
	function BuscarRSSCategoria($idcat = '') {
		global $idcategoria; /** @see $idcat */

		$idElegido = (!empty($idcat) and is_numeric($idcat)) ? $idcat : $idcategoria;


	}

	/**
	 * Funciones::hash_equals
	 * SOLO PARA VERSIONES PHP < 5.6.0
	 * Comparación de strings segura contra ataques de temporización
	 * @param string $str2
	 * @param string $str2
	 */
	  function hash_equals($str1, $str2) {
	    if(strlen($str1) != strlen($str2)) {
	      return false;
	    } else {
	      $res = $str1 ^ $str2;
	      $ret = 0;
	      for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
	      return !$ret;
	    }
	  }
		


}
?>
