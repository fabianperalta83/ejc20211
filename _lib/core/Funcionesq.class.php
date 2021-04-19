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
	function contadorClickPagina() {
		global $idcategoria;	/** @see variables.php */
		global $db;		/** @see variables.php */
		$q = sprintf("UPDATE %s SET cuenta = cuenta + 1 WHERE idcategoria = %s", _TBLCATEGORIA, $idcategoria);
		$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
	}
	/**
	 * Funciones :: BuscarRoot
	 * Función que busca la categoría raiz de la categoría consultada
	 * @param  integer $idcategoria
	 * @return integer
	 **/
	function BuscarRoot($idcategoria = 1) {
		global $db;	/** @see variables.php */

		$query = sprintf("SELECT * FROM %s WHERE idcategoria = '%s' " , _TBLCATEGORIA , $idcategoria);
		$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);

		if ($result !== FALSE and $result->NumRows() > 0) {
			$num_rows = $result->NumRows();
			$row = $result->fields;

			if($num_rows > 0 && ($row["idcategoria"] == 1 || $row["es_root"] == 1)){
				return $row["idcategoria"];
			} else {
				return trim(Funciones::BuscarRoot($row["idpadre"]));
			}
		} else {
			headerLocation('index.php?idcategoria=6');
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
	function BusquedaRecursiva($idcategoria, $campo){

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
	function buscarNombreTemplate($idcategoria,$nombre='')	{
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
	function BuscarHijos($idcategoria = 0){
		global $db;	/** @see variables.php */

		if (0 != $idcategoria){

			$orden_tmp = Funciones::BusquedaRecursiva(Funciones::BuscarPadre($idcategoria),"orden_sub");
			$tmp = Funciones::BusquedaRecursiva($idcategoria,"asc_sub");

			switch ($tmp) {
				case 1: $asc_tmp = "desc"; break;
				case 2: $asc_tmp = "asc"; break;
			}

			$phpself	= basename($_SERVER['PHP_SELF']);
			$query		= sprintf("SELECT * FROM %s WHERE activa != 0 AND idpadre = '%s' ORDER BY %s %s" , _TBLCATEGORIA , $idcategoria, $orden_tmp, $asc_tmp);
			$result		= $db->Execute($query) or errorQuery(__LINE__, __FILE__);

			if ($result !== FALSE and $result->NumRows() > 0 and $idcategoria > 0){
				$i = 0;
				while (!$result->EOF){
					$row = $result->fields;
					$i++;
					$categoria['id'] = $row["idcategoria"];
					$categoria['vinculo'] = sprintf("%s?idcategoria=%s"
													,$phpself
													,$row["idcategoria"]
													);
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
	function DisplayCategoria($idcategoria){

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

						$show = sprintf ("<div class=advertencia>Tipo de sección %s sin implementar<br>Escoja otro!!</div>", $display[$infoCategoria["iddisplay"]][2]);
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
				case 14: $show=FuncionesDisplay::$display_sub[$iddisplay_sub][0]($idcategoria) ;break;
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
	function BuscarPadre($idcategoria = 1){

		global $trazaCategoria;

		$idcategoria = ($idcategoria == '') ? 0 : $idcategoria;

		if (isset($trazaCategoria[$idcategoria])) {

			return $trazaCategoria[$idcategoria]["idpadre"];

		} else {
			global $db;
			$query = sprintf("SELECT * FROM %s WHERE idcategoria = '%s'", _TBLCATEGORIA, $idcategoria);
			$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);

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
	function buscarSeccionPrimerNivel($idcategoria = 0,$j = 0){

		global $db;
		$j++;
		$query = sprintf("SELECT * FROM %s WHERE idcategoria = '%s' and activa != 0" ,_TBLCATEGORIA, $idcategoria);
		$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);

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
	 * Funciones :: microsms
	 * Envio mensajes de texto CLICKATELL
	 * @param
	 * @return
	 */
	function microsms($p1,$p2,$p3,$p4 = ''){
		global $db;

		$text = urlencode($p2);
		$url = "http://api.clickatell.com/http/sendmsg?user=micros&password=micros12&api_id=3202435&to=57$p1&text=$text&callback=3";
		// do sendmsg call
		$ret = file($url);
		$send = split(":",$ret[0]);
		if ($send[0] == "ID")
		$p5 = 'Enviado';
		else
		$p5 = 'No Enviado';
		

		$query = sprintf("INSERT INTO %s (sms_remite,sms_destino,sms_contenido,sms_fecha_hora,estado,formulario) VALUES ('%s','%s','%s',null,'%s','%s')"
						,_TBLSMS
						,trim($send[1])
						,$p1
						,$p2
						,$p5
						,$p3
						);
					
		$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);

		if($p5 == 'exito'){
			return 1;
		} else {
			return 0;
		}
	}
	
	/**
	 * Funciones :: microsmail
	 * @param
	 * @return
	 */
	function microsmail($p1,$p2,$p3,$p4 = '',$p6='',$p7=''){
		global $db;
		if('' == $p4)
		{
			$p4 = "From:"._EMAIL."\r\nContent-Type:text/html";
		}
		else
		{
			$p4 = "From:".$p4."\r\nContent-Type:text/html";
		}
		if( mail($p1,$p2,$p3,$p4)){
			$p5 = 'exito';
		} else {
			$p5 = 'fracaso';
		}

		$p4 = explode("\r\n",$p4);

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
		//die($query);
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
		$query = sprintf("SELECT * FROM %s WHERE username='%s' AND password = '%s'", _TBLUSUARIO, $usuario, $password);
		$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);
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
	function obtenerInfoCategoria($idcategoria) {
		global $db;
		global $trazaCategoria;

		$arrayCategorias = array();
		$select = " idcategoria, idpadre, activa, orden, orden_sub, asc_sub, paginas_sub, restringida, iddisplay, iddisplay_sub
					, template, fecha1, fecha2, fecha3, es_prototipo, es_root, autor, nombre, antetitulo, subtitulo, entradilla
					, descripcion, imagen, validacion, idioma, eliminado, varsubsitio, en_buscador, en_mapa, es_rss, pie_imagen";
		$q = sprintf("SELECT %s FROM %s WHERE idcategoria = '%s'", $select, _TBLCATEGORIA, $idcategoria);
		$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);

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
}
?>
