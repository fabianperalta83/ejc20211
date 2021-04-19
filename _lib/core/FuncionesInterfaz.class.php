<?php
/**
 * Class FuncionesInterfaz
 * Tiene funciones que sacan html con objetivos especificos
 * @package Núcleo
 * @author Juan Manuel Hernandez <jhernandez@micrositios.net>
 * @version 2.0
 * @static
 * @copyright Copyright © 2005 Micrositios Ltda.
 */
class FuncionesInterfaz {
	/**
	 * FuncionesInterfaz :: EnlacesSubMenu
	 * Función que genera los enlaces del
	 * submenú de navegación
	 * @param integer $idcategoria
	 * @param integer $seccion
	 * @param boolean $todo
	 * @return
	 **/
	public static function EnlacesSubMenu($idcategoria=_SINICIO, $seccion=0, $mostrarTodos = FALSE) {

		global $db;

		if($idcategoria == 1) // Si es el root del sitios (el sitio principal)
		$idcategoria = _SINSTITUCIONAL;

		if ($idcategoria > 0) {

			//$orden_tmp = Funciones::BusquedaRecursiva(Funciones::BuscarPadre($idcategoria),"orden_sub");
			
			$orden_tmp1 = Funciones::BusquedaRecursiva($idcategoria,"orden_sub");
                        
			if($orden_tmp1=='heredar')
			{
				$orden_tmp = Funciones::BusquedaRecursiva(Funciones::BuscarPadre($idcategoria),"orden_sub");
			}
			else
			{
				$orden_tmp=$orden_tmp1;
			}
			$tmp = Funciones::BusquedaRecursiva($idcategoria,"asc_sub");
			$asc_tmp	= $tmp == 1 ? "desc" : "asc";

			if($idcategoria == _SINSTITUCIONAL)
			{if(isset($_GET['alex'])){echo 'arriba';}
				$query	 = sprintf("select * from %s where activa != 0 and idpadre = '%s' order by orden asc" , _TBLCATEGORIA , $idcategoria);
			}
			else
			{if(isset($_GET['alex'])){echo 'abajo';}
				$query	 = sprintf("select * from %s where activa != 0 and idpadre = '%s' order by %s %s" , _TBLCATEGORIA , $idcategoria, $orden_tmp, $asc_tmp);
			}
			if(isset($_GET['yo'])){echo $query;}
			$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);

			if ($result !== FALSE and $result->NumRows() > 0 and $idcategoria > 0) {

				while (!$result->EOF){

					$row = $result->fields;

					$categoria['idcategoria'] = $row["idcategoria"];
					$categoria['nombre'] = $row["nombre"];
					$categoria['imagen'] = $row["imagen"];

					if($seccion == $row["idcategoria"] or $mostrarTodos === TRUE) {

						$orden_tmp = Funciones::BusquedaRecursiva($row["idcategoria"], "orden_sub");
						$tmp = Funciones::BusquedaRecursiva($row["idcategoria"], "asc_sub");

						$asc_tmp	= $tmp == 1 ? "desc" : "asc";

						$qr2 = sprintf("SELECT * FROM %s WHERE activa != 0 AND idpadre = '%s' ORDER BY %s %s" , _TBLCATEGORIA , $row["idcategoria"], $orden_tmp, $asc_tmp);
						$r2 = $db->Execute($qr2) or errorQuery(__LINE__, __FILE__);

						if ($r2 !== FALSE and $r2->NumRows() > 0) {

							$categoria['hijos'] = array();

							while (!$r2->EOF) {
								array_push($categoria['hijos'], array('idcategoria' => $r2->fields["idcategoria"]
																	,'nombre' => $r2->fields["nombre"]
																	,'fecha' => $r2->fields["fecha1"]
																	,'subtitulo' => $r2->fields["subtitulo"]
																	)
											);
								$r2->MoveNext();
							}
						}
					}
					$categorias[] = $categoria;
					$categoria = "";

					$result->MoveNext();
				}

				return $categorias;

			}
		}
	}
	/**
	 * FuncionesInterfaz :: RutaARoot
	 * Par de funciones para generar los submenus
	 * de manera dependiente del root actual
	 * @param integer $idcategoria
	 * @param string $orden
	 * @return
	 **/
	function RutaARoot($idcategoria,$orden="asc"){
		// Funcion que general la ruta con los idcategoria hasta un root
		global $db;	/** @see variables.php */
		global $trazaCategoria; /** @see variables.php */

		/**
		 * En caso de que no este cargados los ancestros del $idcategoria en caso de que se vuelvan a utilizar
		 */
		if (!isset($trazaCategoria[$idcategoria])) {
			$trazaCategoriaAux = Funciones::obtenerInfoCategoria($idcategoria);
		} else {
			$trazaCategoriaAux = $trazaCategoria;
		}

		$rutaroot = array();

		if (isset($trazaCategoriaAux[$idcategoria])) {
			/**
			 * Sacamos la traza del idcategoria a root
			 */
			$row = $trazaCategoriaAux[$idcategoria];

			array_push($rutaroot, $row["idcategoria"]);
			$idpadre = $row["idpadre"];

			while($idpadre != 0 and !($row["idcategoria"] == 1 || $row["es_root"] == 1)){
				$row = $trazaCategoriaAux[$idpadre];
				array_push($rutaroot, $row["idcategoria"]);
				$idpadre = $row["idpadre"];
			}

			if($orden<>"asc"){
				$rutaroot	= array_reverse($rutaroot);
			}
		}

		return $rutaroot;
	}
	/**
	 * FuncionesInterfaz :: CrearSubMenu
	 * Función que entrega los elementos del submenu
	 * dependiente del root actual
	 * @param integer $idcategoria
	 * @return
	 **/
	function CrearSubMenu($idcategoria){
		//	Función que entrega los elementos del submenu
		//	dependiente del root actual
		$rutaroot = RutaARoot($idcategoria);
		$root = array_pop($rutaroot);
		if($root == 1) $root = array_pop($rutaroot);
		$submenu = BuscarHijos(array_pop($rutaroot));

		return $submenu;
	}
	/**
	 * FuncionesInterfaz :: Imprimir
	 * Función que entrega el elemento de impresion
	 * @param integer $idcategoria
	 * @return HTML
	 **/
	function Imprimir($idcategoria, $resaltar){
		$inf = (isset($_GET['inf'])  && $_GET['inf'] > 0)?$_GET['inf']: 0;
		$inf = (isset($_POST['inf']) && $_POST['inf'] > 0)?$_POST['inf']: $inf;
		$var = sprintf("<a onkeypress=\"window.status='Ver Versi&oacute;n Imprimible'\" onclick=\"window.status='Ver Versi&oacute;n Imprimible'\" href=\"%s?idcategoria=%s&amp;print&amp;inf=%s\" target=\"_blank\" class=\"imprimir\" title=\"Ver en formato amigable para la impresora\"><img src=\"%smini_imprimir.gif\"  alt=\"Ver en formato amigable para la impresora\"></a>&nbsp;", "index.php", $idcategoria, $inf, _DIRIMAGES_AUX);
		return $var;
	}
	/**
	 * FuncionesInterfaz :: Cuentele
	 * Función que entrega el link de cuentele
	 * @param integer $idcategoria
	 * @return html
	 **/
	function Cuentele($idcategoria){
		return sprintf("<a href='javascript:openFrameless(%s)' title='Click para recomendar esta sección a un amigo'><img src='%smini_enviar.gif'  alt='Click para recomendar esta sección a un amigo'/></a>",$idcategoria, _DIRIMAGES_AUX);
	}
	/**
	 * FuncionesInterfaz :: ReemplazarMail
	 * Función para reemplazar un correo por un mailto:correo
	 * @param string $cadena
	 * @return
	 **/
	function ReemplazarMail($cadena){
		$cadena = preg_replace("/([\w\.]+)(@)([\w\.]+)/i", "<a href=\"mailto:$0\">$0</a>", $cadena);
		// $cadena = preg_replace("/((http(s?):\/\/)|(www\.))([\w\.]+)/i","<a href=\"http$3://$4$5\"target=\"_blank\">$2$4$5</a>", $cadena);
		return $cadena;
	}
	/**
	 * Retorna la ruta hasta la categoría marcada como Raiz (root) entregando un arreglo asociativo.
	 *
	 * @param int $idcategoria
	 * @param int $sroot
	 * @param byref array &$migas
	 * @return array con las
	 */
	public static function Migas($idcategoria=1, $sroot=1, &$migas){

		global $trazaCategoria;	/** @see variables.php */

		if (!isset($trazaCategoria[$idcategoria])) {
			$trazaCategoriaAux = Funciones::obtenerInfoCategoria($idcategoria);
		} else {
			$trazaCategoriaAux = $trazaCategoria;
		}


		if(isset($trazaCategoriaAux[$idcategoria])) {
			$migas = array();

			$row = $trazaCategoriaAux[$idcategoria];

			array_push($migas, array("idcategoria" => $row["idcategoria"], "nombre" => $row["nombre"]));
			$idpadre = $row["idpadre"];

			//while($row["idcategoria"] != $sroot){
			while($row["idcategoria"] != $sroot) {
				$row = $trazaCategoriaAux[$idpadre];
				array_push($migas, array("idcategoria" => $row["idcategoria"], "nombre" => $row["nombre"]));
				$idpadre = $row["idpadre"];
			}

			return $migas;

		} else {
			return false;
		}
	}
	/**
	 * FuncionesInterfaz :: datetotext
	 * @param
	 * @return
	 */
	public static function datetotext($fecha){
		$temp = explode("-",$fecha);
		if(isset($temp[1]) && $temp[1] <>0 && $temp[1] <>'00'){
			$year	= $temp[0];
			$mes	= $temp[1];
			$dia	= $temp[2];
			if (isset($mes)){
				setlocale (LC_TIME,_R_IDIOMA);
				$nuevafecha = strftime(FORMAT_DATETOTEXT, mktime(0,0,0,$mes,$dia,$year));
			} else {
				$nuevafecha = "";
			}
			return $nuevafecha;
		}else{
			return "";
		}
	}
	/**
	 * FuncionesInterfaz :: CrearSelectCriterio
	 * @param
	 * @return
	 */
	function CrearSelectCriterio($criterio_ordena_form) {
		global $db;

		$query = sprintf("explain %s" , _TBLCATEGORIA);
		$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);

		$select = sprintf("<select name=criterio_ordena_form class='edicion_input_select form-control'>");
		$i=0;

		while(!$result->EOF) {
			$row = $result->fields;
			switch ($row["Field"]) {
				case 'idcategoria':
					$campo[$i][1] = "Id Categoría [numérico]";
					$campo[$i][0] = $row["Field"];
				break;
				case 'antetitulo':
					$campo[$i][1] = "Antetítulo [texto]";
					$campo[$i][0] = $row["Field"];
				break;
				case 'orden':
					$campo[$i][1] = "Orden [numérico]";
					$campo[$i][0] = $row["Field"];
				break;
				case 'subtitulo':
					$campo[$i][1] = "Subtítulo [texto]";
					$campo[$i][0] = $row["Field"];
				break;
				case 'nombre':
					$campo[$i][1] = "Nombre [texto]";
					$campo[$i][0] = $row["Field"];
				break;
				case 'descripcion':
					$campo[$i][1] = "Contenido [texto]";
					$campo[$i][0] = $row["Field"];
				break;
				case 'fecha1':
					$campo[$i][1] = "Fecha de publicación [fecha]";
					$campo[$i][0] = $row["Field"];
				break;
				case 'fecha2':
					$campo[$i][1] = "Fecha máx. en home [fecha]";
					$campo[$i][0] = $row["Field"];
				break;
				case 'entradilla':
					$campo[$i][1] = "Resumen [texto]";
					$campo[$i][0] = $row["Field"];
				break;

				default:
					//$campo[$i][0] = $row["Field"];
					//$campo[$i][1] = $row["Field"];
				break;
			}
			//	$campo[$i][0] = $row["Field"];
			$i++;
			$result->MoveNext();
		}

		sort($campo);
		$select .= sprintf("<option value='' %s>%s</option>",
							($criterio_ordena_form == '')?"selected":"",
							"-- Heredar --");

		for($i=0;$i < count($campo);$i++) {

			$pos = strrpos($campo[$i][1], "�");
			if ($pos === false) { // nota: tres signos de igual
			    $select .= sprintf("<option value='%s' %s>%s</option>",
								$campo[$i][0],
								($criterio_ordena_form == $campo[$i][0])?"selected":"",
								$campo[$i][1]
							);

			}
			else
			{
				$select .= sprintf("<option value='%s' %s>%s</option>",
								$campo[$i][0],
								($criterio_ordena_form == $campo[$i][0])?"selected":"",
								$campo[$i][1]
							);

			}

			
		}

		$select .= sprintf("</select>");
		return $select;
	}
	/**
	 * FuncionesInterfaz :: CrearSelectTipo
	 * @param
	 * @return
	 */
	function CrearSelectTipo($tipo_ordena_form){
		$separador = "&nbsp;&nbsp;&nbsp;";
		switch ($tipo_ordena_form) {
			case 0:
			$select  = "<input type=radio name=tipo_ordena_form value=0 checked>-- Heredar --".$separador;
			$select .= "<input type=radio name=tipo_ordena_form value=1>Descendente".$separador;
			$select .= "<input type=radio name=tipo_ordena_form value=2>Ascendente"  ;
			break;
			case 1:
			$select  = "<input type=radio name=tipo_ordena_form value=0>-- Heredar --".$separador;
			$select .= "<input type=radio name=tipo_ordena_form value=1 checked>Descendente".$separador;
			$select .= "<input type=radio name=tipo_ordena_form value=2>Ascendente"  ;
			break;
			case 2:
			$select  = "<input type=radio name=tipo_ordena_form value=0>-- Heredar --".$separador;
			$select .= "<input type=radio name=tipo_ordena_form value=1>Descendente".$separador;
			$select .= "<input type=radio name=tipo_ordena_form value=2 checked>Ascendente"  ;
			break;
			default:
			$select  = "<input type=radio name=tipo_ordena_form value=0 checked>-- Heredar --".$separador;
			$select .= "<input type=radio name=tipo_ordena_form value=1>Descendente".$separador;
			$select .= "<input type=radio name=tipo_ordena_form value=2>Ascendente"  ;
			break;
		}

		return $select;

	}
	/**
	 * FuncionesInterfaz :: CrearSelectIdiomas
	 * @param
	 * @return
	 */
	function CrearSelectIdiomas() {

	}
	/**
	 * FuncionesInterfaz :: MostrarEncuesta
	 *
	 * Esta funcion se ocupa de busca si hay una encuesta en el portal
	 * @return
	 **/
	public static function MostrarEncuesta(){

		global $db;

		$hoy = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$hoy = date("Y-m-d", $hoy);

		$query = sprintf("SELECT * FROM %s WHERE fecha2 > '%s' AND iddisplay_sub = 9 AND activa != 0 ORDER BY orden ASC, idcategoria DESC" , _TBLCATEGORIA , $hoy);
		$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);

		$phpself = basename($_SERVER['PHP_SELF']);
		$idcategoria = $GLOBALS['idcategoria'];
		$pertenece = FALSE;

		if ($result !== FALSE and $result->NumRows() > 0){

			while(!$result->EOF) {
				$row = $result->fields;

				$idRoot = Funciones::BuscarRoot($row["idpadre"]);

				if($idRoot == _SINICIO) {
					$pertenece = TRUE;
				} elseif ($idRoot == 3) {
					$pertenece = TRUE;
				}

				if ($pertenece === TRUE) {

					$query1 = sprintf("SELECT * FROM %s WHERE idpadre = '%s' AND activa != 0" , _TBLCATEGORIA , $row["idcategoria"]);
					$result1 = $db->Execute($query1) or errorQuery(__LINE__, __FILE__);

					if ($result1 !== FALSE and $result1->NumRows() > 0) {

						$tmp["idcategoria"]	= $row["idcategoria"];
						$tmp["nombre"]		= nl2br($row["nombre"]);
						$tmp["entradilla"]	= nl2br($row["entradilla"]);
                                                $tmp["descripcion"]	= nl2br($row["descripcion"]);
						$tmp["formaction"]	= $phpself;
						$form	= sprintf("<input type=hidden name=idcategoria value=%s>",$row["idcategoria"]);
						$flag = 0;

						if(!isset($_COOKIE['Micrositios'.$row["idcategoria"]]) || $_COOKIE['Micrositios'.$row["idcategoria"]]!=1) {

							while(!$result1->EOF) {
								$row = $result1->fields;

								$form	.= sprintf("<input type='radio' class='opcion_encuesta' name='encuesta' id='%s' value='%s'/><label for='%s' class='li_encuesta'>%s</label><br/>",$row["nombre"],$row["idcategoria"],$row["nombre"],$row["nombre"]);
								$flag = 1;
								$tmp["label"]= _ROT_ENCUESTA_VOTAR;

								$result1->MoveNext();
							}

						} else {

							$flag = 1;
							$tmp["label"]=_ROT_ENCUESTA_RESULTADO;

						}

						$tmp["opciones"]=$form;
					}
					break;
				}

				$result->MoveNext();
			}
		}

		if (isset($flag) && $flag == 1) {
			return $tmp;
		} else {
			return;
		}
	}
	/**
	 * Genera el select-HTML de los posibles templates --- lista solo los directorios existentes en _DIRTEMPLATES ---
	 *
	 * @param  String $seleccion es el valor que ya esta seleccionado en el sistema
	 * @return String un select-HTML con los posibles valores de los templates
	 */
	function SelectTemplates($seleccion = "") {
		global $idcategoria;	/** @see variables.php */

		$dir1 = sprintf("%s",_DIRTEMPLATES);
		$select = "<select name=\"idtemplate_form\" class='edicion_input_select form-control'>";
		if (is_dir('.')) {
			chdir($dir1);
			$handle=opendir('.');

			$idcategoria = isset($_POST['idcategoria'])?$_POST['idcategoria']:(isset($_GET['idcategoria'])?$_GET['idcategoria']:1);

			$select .= ($idcategoria > 1)?"<option value=\"\">-- Heredar --</option>":"";

			while (($file = readdir($handle))!==false) {
				if (($file != ".") && ($file != "..")) {
					if (is_dir($file)){
						if ($seleccion == $file){
							$select .= "<option value=\"$file\" selected=\"selected\">$file</option>";
						}
						else{
							$select .= "<option value=\"$file\" >$file</option>";
						}
					}
				}
			}
			closedir($handle);
		}
		$select .= "</select>";
		chdir('..');//regreso a la ruta inicial
		return $select;
	}
	/**
	 * FuncionesInterfaz :: buscarSeccionPrimerNivel
	 * @param
	 * @return
	 */
	function buscarSeccionPrimerNivel($idcategoria = 0,$j = 0){

		global $trazaCategoria; /** @see variables.php */

		$j++;

		/**
		 * En caso de que no este cargados los ancestros del $idcategoria en caso de que se vuelvan a utilizar
		 */
		if (!isset($trazaCategoria[$idcategoria])) {
			$trazaCategoriaAux = Funciones::obtenerInfoCategoria($idcategoria);
		} else {
			$trazaCategoriaAux = $trazaCategoria;
		}

		if (isset($trazaCategoriaAux[$idcategoria]) and $trazaCategoriaAux[$idcategoria]["activa"] == 1) {

			$row = $trazaCategoriaAux[$idcategoria];

			while($row["idpadre"] != _SINSTITUCIONAL || $row["idpadre"] != _SUTILIDADES) {

				$row = $trazaCategoriaAux[$idpadre];
				$ev[0] = $idcategoria;
				$ev[1] = $row['nombre'];
				$ev[2] = $row['subtitulo'];
				$ev[3] = $j;

			}
			return $ev;

		} else {

			return 0;

		}
	}
	/**
	 * FuncionesInterfaz :: CrearCheckRestringida
	 * Crea los checkboxes para la restricion de grupos a idcategorias
	 * @param
	 * @return
	 */
	function CrearCheckRestringida($idcategoria, $idpadre_form = 0){

		global $db; /** @see variables.php */

		$query	 = sprintf("SELECT * FROM %s ORDER BY nombre", _TBLLISTAS);
		$result	= $db->Execute($query) or errorQuery(__LINE__, __FILE__);

		$query1	 = sprintf("SELECT * FROM %s WHERE idcategoria = '%s'", _TBLACCESO, $idcategoria);
		$result1 = $db->Execute($query1) or errorQuery(__LINE__, __FILE__);

		if ($result->NumRows() > 0) {

			$checks   = "<table border=0 cellpadding=0 cellspacing=0 align=left summary='Restricciones'>";

			while (!$result->EOF) {

				$row = $result->fields;
				settype($row, 'object');

				if (empty($row->consulta)) { // Se excluyen los listados dinamicos

					$tmp_check = '';
					if(!$idpadre_form) {
						if ($result1->NumRows() > 0){
							while (!$result1->EOF) {
								$row1 = $result1->fields;
								settype($row1, 'object');
								if($row->idlista == $row1->idlista) {
									$tmp_check = 'checked';
								}
								$result1->MoveNext();
							}
							/**
							 * Movemos el cursor del recordset al inicio para luego repetir la operacion
							 */
							$result1->Move(0);
						}
					}

					$cantidad = 0;
					$cantidad = Funciones::CantidadUsuarios($row->idlista);

					switch ($cantidad) {
						case 0:
							$mensaje = "<font color=red>(vacio!)</font>";
							break;
						case 1:
							$mensaje = "(1 inscrito)";
							break;
						default:
							$mensaje = "(".$cantidad." inscritos)";
					}
					$checks  .= sprintf("<tr><td><input type=checkbox name=restringida_form[] value=%s %s></td><td class='tpl_migas'>%s %s</td></tr>",$row->idlista,$tmp_check,$row->nombre,$mensaje);
				}
				$result->MoveNext();
			}
			$checks .= "</table>";
		}

		$checks = (isset($checks))?$checks:"";
		return $checks;
	}
	/**
	 * Funciones :: CrearSelect
	 * Crea el select de templates del portal en el formulario de edicion.
	 * @param int $iddisplay_form
	 * @return
	 */
	function CrearSelect($iddisplay_form){

		global $db;	/** @see variables.php */
		global $display; /** @see variables.php */

		/**
		 * Organizamos el listado por orden alfabético
		 */

		$displayArrayA = array();
		$displayArrayB = array();
		while (list($idx, $value) = each($display)) {
			$displayArrayA[$idx] = $value;
			$displayArrayA[$idx]['idx'] = $idx;
			$displayArrayB[$idx] = $value[2]; // Valores del nombre para organizar alfabeticamente
		}
		array_multisort($displayArrayB, SORT_ASC, SORT_STRING, $displayArrayA);

		/* ****************************** */


		if (isset($_SESSION["info_usuario"])) {
			$es_Admin = Funciones::esAdministrador($_SESSION["info_usuario"]['username'], $_SESSION["info_usuario"]['password']);
		}
		$select = sprintf("<select name=iddisplay_form class='edicion_input_select form-control' onchange=\"onChangeSelectDisplay(this)\">");

		$idpadre_form = (isset($GLOBALS['idpadre_form'])) ? $GLOBALS['idpadre_form'] : "";

		$tipo_seccion_padre = Funciones::BuscarTipoSeccion($idpadre_form);

		while(list($idx, $value) = each($displayArrayA)) {

			if ($value[1] == 1) {
				if( $es_Admin > 0)
				{
					$select .= sprintf("<option value=%s %s>%s</option>",
											$value['idx'],
											($iddisplay_form == $value['idx'])?"selected":"",
											$value[2]
										);
					
				}
				else
				{
					

					if ( $value['idx'] == "0" or $value['idx'] == "7" or $value['idx'] == "10"  or $value['idx'] == "23" or $value['idx'] == "4" or $value['idx'] == "12" or $value['idx'] == "5")
					{
						
						$select .= sprintf("<option value=%s %s>%s</option>",
											$value['idx'],
											($iddisplay_form == $value['idx'])?"selected":"",
											$value[2]
										);
					}
				}
			}

		}
		$select .= sprintf("</select>");
		return $select;
	}
	/**
	 * Funciones :: CrearSelect_sub
	 * crea el select de subcategorias del portal en el template de edicion
	 * @param int $iddisplay_sub_form
	 * @return
	 */
	function CrearSelect_sub($iddisplay_sub_form){

		global $display_sub; /** @see variables.php */

		/**
		 * Organizamos el listado por orden alfabético
		 */

		$displaySubArrayA = array();
		$displaySubArrayB = array();
		while (list($idx, $value) = each($display_sub)) {
			$displaySubArrayA[$idx] = $value;
			$displaySubArrayA[$idx]['idx'] = $idx;
			$displaySubArrayB[$idx] = $value[2]; // Valores del nombre para organizar alfabeticamente
		}
		array_multisort($displaySubArrayB, SORT_ASC, SORT_STRING, $displaySubArrayA);

		/* ****************************** */

		if (isset($_SESSION["info_usuario"])) {
			$es_Admin = Funciones::esAdministrador($_SESSION["info_usuario"]['username'], $_SESSION["info_usuario"]['password']);
		}

		$select = sprintf("<select name=iddisplay_sub_form class='edicion_input_select form-control'>");
		while(list($idx, $value) = each($displaySubArrayA)) {
			if($value[1] == 1){
				if( $es_Admin > 0)
				{
					$select .= sprintf("<option value=%s %s>%s</option>",
									$value['idx'],
									($iddisplay_sub_form == $value['idx'])?"selected":"",
									$value[2]
								  );
				}
				else
				{
					
					
					

					if ( $value['idx'] == "0"  or $value['idx'] == "10" or  $value['idx'] == "15" or $value['idx'] == "7" or $value['idx'] == "5" or $value['idx'] == "12" or $value['idx'] == "3" or $value['idx'] == "2" or $value['idx'] == "20" or $value['idx'] == "4" or $value['idx'] == "1")
					{
						
					
					
						$select .= sprintf("<option value=%s %s>%s</option>",
									$value['idx'],
									($iddisplay_sub_form == $value['idx'])?"selected":"",
									$value[2]
								  );
						
					}
				}
				
			}
		}
		$select .= sprintf("</select>");
		return $select;
	}
	/**
	 * Funciones :: formatBytes
	 * Saca el tamaño del archivo con las convension que es
	 * @param int $iddisplay_sub_form
	 * @return
	 */
	function formatBytes($val, $digits = 3, $mode = "SI", $bB = "B"){ //$mode == "SI"|"IEC", $bB == "b"|"B"
       $si = array("", "k", "M", "G", "T", "P", "E", "Z", "Y");
       $iec = array("", "Ki", "Mi", "Gi", "Ti", "Pi", "Ei", "Zi", "Yi");
       switch(strtoupper($mode)) {
           case "SI" : $factor = 1000; $symbols = $si; break;
           case "IEC" : $factor = 1024; $symbols = $iec; break;
           default : $factor = 1000; $symbols = $si; break;
       }
       switch($bB) {
           case "b" : $val *= 8; break;
           default : $bB = "B"; break;
       }
       for($i=0;$i<count($symbols)-1 && $val>=$factor;$i++)
           $val /= $factor;
       $p = strpos($val, ".");
       if($p !== false && $p > $digits) $val = round($val);
       elseif($p !== false) $val = round($val, $digits-$p);
       return round($val, $digits) . " " . $symbols[$i] . $bB;
   }
   /**
    * FuncionesInterfaz::homeUsuario
    * Home Personalizado del Usuario
    * @return string
    */
   function homeUsuario() {
		global $db;
		$smarty = new Smarty_Plantilla();

		$secciones = array(); /**** Secciones de usuarios ****/
		$cantSecciones = array(); /**** cantidad de noticias de las secciones ****/
		$personalizacion = array();

		/**** Capturando la personalizacion del usuario ****/
		$q = sprintf("SELECT personalizacion FROM %s WHERE idusuario = '%s'",
					_TBLUSUARIO,
					$_SESSION['info_usuario']['idusuario']
					);

		$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);

		if ($r->NumRows() > 0) {
			$d = $r->fields;
			/**
			 * Miramos que el usuario tenga la personalizacion, si no,
			 * colocamos el home normal
			 **/
			if (!empty($d['personalizacion'])) {
				$personalizacion = unserialize($d['personalizacion']);
				if (sizeof($personalizacion) == 0) {
					$smarty->assign('hayProgramacionUsuario', 'N');
				} else {
					$smarty->assign('hayProgramacionUsuario', 'S');
				}
			} else {
				$smarty->assign('hayProgramacionUsuario', 'N');
			}
		} else {
			$smarty->assign('hayProgramacionUsuario', 'N');
		}

		$customNews = array(); /**** recipiente de noticias finalmente organizadas ****/
		if (is_array($personalizacion)) {

			/**** Buscando las Noticias Personalizadas para buscar los padres ****/
			foreach ($personalizacion as $seccionActual) {

				/**** Sacando las noticias elegidas ****/
				$qNews = " SELECT * FROM "._TBLCATEGORIA
						." WHERE idpadre = ".$seccionActual['idSeccion']
						." ORDER BY fecha1 DESC"
						." LIMIT ".$seccionActual['cantidad'];

				$rNews = $db->Execute($qNews) or errorQuery(__LINE__, __FILE__);

				/**** Recorriendo las noticias ****/
				while (!$rNews->EOF) {

					$dNews = $rNews->fields;
					/**** Existe el padre en el array?? ****/
					if (!isset($customNews[$seccionActual['padre']])) {

						/**** Sacando el nombre del padre de la seccion seleccionada ****/
						$qPadre = "SELECT * FROM "._TBLCATEGORIA." WHERE idcategoria = ".$seccionActual['padre'];
						$rPadre = $db->Execute($qPadre) or errorQuery(__LINE__, __FILE__);

						if ($rPadre->NumRows() > 0) {
							$dPadre = $rPadre->fields;
							$customNews[$seccionActual['padre']] = array("idcategoria" => $dPadre['idcategoria']
																		,"nombre" => $dPadre["nombre"]
																		,"secciones" => array()
																		);
						}
					}

					/**** Existe la Seccion en el array?? ****/
					if (!isset($customNews[$seccionActual['padre']]['secciones'][$seccionActual['idSeccion']])) {

						/**** Sacando el nombre de la seccion actual ****/
						$qSeccion = "SELECT * FROM "._TBLCATEGORIA." WHERE idcategoria = ".$seccionActual['idSeccion'];
						$rSeccion = $db->Execute($qSeccion) or errorQuery(__LINE__, __FILE__);

						if ($rSeccion->NumRows() > 0) {
							$dSeccion = $rSeccion->fields;
							$customNews[$seccionActual['padre']]['secciones'][$seccionActual['idSeccion']] = array("idcategoria" => $dSeccion['idcategoria']
																													,"nombre" => $dSeccion["nombre"]
																													,"noticias" => array()
																													);
						}
					}
					array_push($customNews[$seccionActual['padre']]['secciones'][$seccionActual['idSeccion']]['noticias'], $dNews) ;
					$rNews->MoveNext();

				}
			}

			$customAux = array();

			foreach ($customNews as $padreActual) {

				$seccionAux = array();

				foreach ($padreActual['secciones'] as $seccionActual) {
					array_push($seccionAux, $seccionActual);
				}

				array_push($customAux, array("idcategoria" => $padreActual['idcategoria']
											,"nombre" => $padreActual['nombre']
											,"secciones" => $seccionAux
											)
							);
			}
			$smarty -> assign('customNews',	$customAux);
		}

		return $smarty -> fetch('tpl_home_usuario.html');
	}
	/**
	 * Funciones::buscarRSS
	 * @param
	 */
	function buscarRSS() {

	}
}

?>