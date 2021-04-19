<?php
 ini_set('display_errors','0');



/**
 * Class Contratacion
 * @package
 * @author Juan Manuel Hernández <jhernandez@micrositios.net>
 * @version 2.0
 * @copyright Copyright © 2005 Micrositios Ltda.
 */

class Contratacion {
	/**
	 * Variables del Objeto
	 */
	var $msg = array(); /** Guardamos los errores de error */
	var $extAllowed = array();	/** Array de extensiones permitidas */
	
	/**
	 * Contratacion :: Contratacion
	 * Constructor
	 * @return 
	 */
	function Contratacion() {
		//$this->extAllowed = array("doc", "pdf", "xls", "zip", "docx", "xlsx");
		$this->extAllowed = array("pdf");
	}
	/**
	 * Contratacion :: TemplateEdicion
	 * @param
	 * @return 
	 */
	function TemplateEdicion($idcategoria = 0) {
		require_once(_DIRCORE."Edicion.class.php"); /** Necesitamos algunas de las funciones del objeto Edicion */
		require_once(_DIRCORE."Validacion.class.php"); /** Necesitamos algunas de las funciones de Validaciones */

		global $db;	/** @see variables.php */
		global $trazaCategoria;	/** @see variables.php */
		
		$error = array();

		$smarty = new Smarty_Plantilla;
		$pagina = basename($_SERVER['PHP_SELF']);
		$pagina .= sprintf("?idcategoria=%s", $idcategoria);
		$phpself = $pagina;

		$smarty->assign('userInfo', $_SESSION['info_usuario']);
		
		// Captura de todas las variables que vienen por POST del formulario de edición
		// Y Validacion de los campos
		$pattern = "^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚüÜ \.&_\(\)\/,;#-]+$";
		$nombre_form			= strip_tags(trim(getVariable('nombre_form')));
		if (!Validacion::isCustom($nombre_form, $pattern)) {
			array_push($error, "El Nombre contiene caracteres no permitidos.");
		}elseif(Validacion::isEmpty($nombre_form)){
		
		   array_push($error, "El Nombre es un campo requerido.");
		
		}
		$nombre_form			= html_entity_decode($nombre_form, ENT_QUOTES);
		
		
		$activa_form			= getVariable('activa_form');
		$orden_form				= getVariable('orden_form');
		
		if (!Validacion::isEmpty($orden_form) and !Validacion::isNum($orden_form)) {
			array_push($error, "El Orden es un campo num&eacute;rico.");
			$orden_form = 0;
		} elseif (Validacion::isEmpty($orden_form)) {
			$orden_form = 0;
		}
		
		$iddisplay_form			= getVariable('iddisplay_form');
		$iddisplay_sub_form		= getVariable('iddisplay_sub_form');

		/** fecha1 */
		
		$fecha1_form			= strip_tags(trim(getVariable('fecha1_form')));
		
		if ($fecha1_form == "0000-00-00" || $fecha1_form == "0000-00-00 00:00:00" || $fecha1_form == "0") {
			$fecha1_form = '';
		}elseif($fecha1_form == ''){ 
			$hoy = mktime(0,0,0,date("m"), date("d"), date("Y"));
			$fecha1_form = date("Y-m-j", $hoy);
		}
		/*
		if (!Validacion::isEmpty($fecha1_form) and !Validacion::isDate($fecha1_form)) {
			array_push($error, "La Fecha de creación tiene un formato incorrecto (YYYY-MM-DD) .");
		}
		*/
		$fecha1_form = "'" . $fecha1_form . "'";
		
		/** fecha2 */
		$fecha2_form			= strip_tags(trim(getVariable('fecha2_form')));
		if ($fecha2_form == "0000-00-00" || $fecha2_form == "0000-00-00 00:00:00" || $fecha2_form == "0") {
			$fecha2_form = '';
		}elseif($fecha2_form == ''){
			$caduca = mktime(date("G"),date("i"),date("s"),date("m"), date("d") + 10, date("Y"));
			$fecha2_form = date("Y-m-j H:i:s", $caduca);
		}
		if (!Validacion::isEmpty($fecha2_form) and !Validacion::isDateTime($fecha2_form)) {
			array_push($error, "La Fecha m&aacute;xima en Home tiene un formato incorrecto (YYYY-MM-DD HH:MM:SS) .");
		}
		$fecha2_form = "'" . $fecha2_form . "'";
		
		$antetitulo_form		= strip_tags(trim(getVariable('antetitulo_form')));
		if (!Validacion::isEmpty($antetitulo_form) and !Validacion::isCustom($antetitulo_form, $pattern)) {
			array_push($error, "El Estado contiene caracteres no permitidos.");
		}
		$antetitulo_form		= htmlentities($antetitulo_form, ENT_QUOTES);
		
		$subtitulo_form			= strip_tags(trim(getVariable('subtitulo_form')));
		if (!Validacion::isEmpty($subtitulo_form) and !Validacion::isCustom($subtitulo_form, "^[a-zA-Z0-9 .\$\"',&#ñÑáéíóúÁÉÍÓÚüÜ]+$")) {
			array_push($error, "La Cuantia contiene caracteres no permitidos.");
		}elseif(Validacion::isEmpty($subtitulo_form)){
		    array_push($error,"La cuantia no puede estar vacio");
		}
		$subtitulo_form			= htmlentities($subtitulo_form, ENT_QUOTES);
		
		$entradilla_form		= addslashes(trim(getVariable('entradilla_form')));
		if (!empty($entradilla_form) and !Validacion::isCustom($entradilla_form, $pattern)) {
			array_push($error, "El Objeto contiene caracteres no permitidos.");
		}elseif(Validacion::isEmpty($entradilla_form)){
		    array_push($error,"El objeto no puede estar vacio");
		}
		
		$autor_form				= strip_tags(trim(getVariable('autor_form')));
		if (!empty($autor_form) and !Validacion::isCustom($autor_form, $pattern)) {
			array_push($error, "El Autor contiene caracteres no permitidos.");
		}elseif(Validacion::isEmpty($autor_form)){
		    array_push($error, "El campo Autor debe tener un valor");
		}
		$autor_form				= htmlentities($autor_form, ENT_QUOTES);
		
		$idpadre_form			= getVariable('idpadre_form');
		$estado					= getVariable('estado');
		$validacion				= getVariable('validacion');
		$enbusqueda_form		= getVariable('enbusqueda_form', 1);
		$enmapa_form			= getVariable('enmapa_form', 1);
		
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			
			/**
			 * INFORMACION COMPLEMENTARIA
			 */
			$infoComplementario = array();
			$infoOrden = array();
			while(list($k, $v) = each($_POST)) {
				if (strstr($k, 'info_') and !strstr($k, 'info_orden_')) {
					$indexPost = str_replace('info_', '', $k);
					
					if (Validacion::isNum($_POST['info_orden_'.$indexPost])) {
						$orden_aux = $_POST['info_orden_'.$indexPost];
					} else {
						$orden_aux = 0;
					}
					array_push($infoComplementario, array(	"nombre" => html_entity_decode(str_replace("_", " ", $indexPost), ENT_QUOTES),
															"valor" => html_entity_decode(str_replace('\\', '', $v), ENT_QUOTES),
															"orden" => $orden_aux
														)
								);
					array_push($infoOrden, $_POST['info_orden_'.$indexPost]);
				}
				unset($orden_aux);
			}
			/**
			 * Lo ordenamos por el orden dado
			 */
			array_multisort($infoOrden, SORT_ASC, SORT_NUMERIC, $infoComplementario);
			$Text1 = arraytostring($infoComplementario);
	
			/**
			 * Guardamos las etapas que llegaron
			 */
			$this->guardarEtapas($idcategoria, $nombre_form);
		}

		if (isset($_SESSION["info_usuario"])) {
			$es_Admin = Funciones::esAdministrador($_SESSION["info_usuario"]['username'], $_SESSION["info_usuario"]['password']);
		}

		// Buscar el Titulo de la página en una imagen o leerlo de la base de datos
		$archivo = sprintf("%s/categoria_%s.png", _DIR_IMAGES_EDITOR, $idcategoria);

		if(!isset($_GET['idpadre_form'])){
			$c_titulo = "";
			if (file_exists($archivo)){
				$c_titulo .= sprintf("<img src=%s border=0 width=405 height=63 border=0  alt=\"\">", $archivo);
			} else {
				$c_titulo .= Funciones::BuscarNombre($idcategoria);
			}
		} else {
			$c_titulo = "Creando subcategor&iacute;a de:<br>" . Funciones::BuscarNombre($idcategoria);
		}
		$smarty -> assign('c_titulo', $c_titulo);

		/**
			CONDICIONES DE ERROR
		**/
		// El único campo requerido es el nombre de la categoría, el id es automático
		$error = array_merge($error, $this->msg);
		if (!$nombre_form) {
			$error[] = _ROT_EDICION_ERROR;
		}
		if(isset($error)) {
			$total_errores = count($error);
		} else {
			$total_errores = 0;
		}
		// Mostramos el menú de error
		if ($_SERVER['REQUEST_METHOD'] == "POST" && $total_errores) {
			$smarty1 = new Smarty_Plantilla;
			$smarty1 -> assign('rotMensaje' , _ROT_ADVERTENCIA);
			$smarty1 -> assign('tipo' , "error");
			$smarty1 -> assign('elementoMenu', $error);
			$show = $smarty1 -> fetch('tpl_display_mensaje.html');
			$smarty -> assign('subMenuError' , $show);
		}

		/**
			PROCESO DE INSERCION Y ACTUALIZACION
		**/
		// Si hay algún error no se procesa nada y se vuelve a formulario de edición
		if (!$total_errores) {
			srand((double)microtime()*1000000);
			$validacion = md5(rand(0,9999999));

			/**
				PROCESO DE INSERCION
			**/
			// Si hay idpadre es porque se va a INSERTAR una categoría
			if ($idpadre_form){
				$display_default = 0;
				$iddisplay_padre = Funciones::BuscarSubTipoSeccion($idpadre_form);
				// Experimento para determinar a partir de la categoria del padre, cuál debe ser la categoría del hijo
				switch ($iddisplay_padre){
					// Si el padre es una Encuesta Pregunta entonces el hijo es Auxiliar
					case 7:
					// Si el padre es una Foro inicio entonces por default el hijo es Auxiliar
					case 8: $iddisplay_form = 6; break;
				}
				$orden_sugerido = Edicion::CalcularOrden($idpadre_form);
				$query = sprintf("INSERT INTO %s ", _TBLCATEGORIA);

				$query .= "(idpadre,nombre,descripcion,activa,orden,fecha1,fecha2,fecha3,autor,antetitulo,subtitulo,entradilla,validacion ) values ";
				$query .= sprintf("(%s,'%s','%s',%s,%s,%s,%s,'%s','%s','%s','%s','%s','%s')",
									$idpadre_form,
									$nombre_form,
									($iddisplay_form == 12) ? 0 : $Text1,
									$activa_form,
									($orden_form == '') ? $orden_sugerido : $orden_form,
									$fecha1_form,
									$fecha2_form,
									date("Y-m-d H:i:s"),
									$autor_form,
									$antetitulo_form,
									$subtitulo_form,
									$entradilla_form,
									$validacion
								);

				$result	= $db->Execute($query) or errorQuery(__LINE__, __FILE__);

				// Inserción de permisos de seguridad
				$ultimoid = $db->Insert_ID();

				// Si es root guardamos las variables del nuevo sitio con las variables del viejo root
				if ($esroot_form == 1) {
					global $sroot; /** @see variables.php */
					$qsubsitio = sprintf("UPDATE %s SET varsubsitio = '%s' WHERE idcategoria = %s", _TBLCATEGORIA, $trazaCategoria[$sroot]['varsubsitio'], $ultimoid);
					$rsubsitio = $db->Execute($qsubsitio) or errorQuery(__LINE__, __FILE__);
				}
				/**
				 * Registramos la Insercion
				 * 3 = Accion de Creación
				 */
				Autenticacion::Registrar($ultimoid, 3);

				/**
				 * Miramos si indexamos o no la categoria
				 * $enbusqueda_form : 1 = Si | 0 = No
				 */
				if ($enbusqueda_form == 1) {
					/**
					 * Indexamos la categoria
					 **/
					Edicion::indexarContenido($ultimoid, $nombre_form." ".$autor_form." ".$antetitulo_form." ".$subtitulo_form." ".$entradilla_form." ".$Text1);
				}

				/**
				 * Avisar al Administrador de la página del cambio.
				 **/
				//envioCorreoAdministrador('INSERTAR',$ultimoid, $nombre_form);

				if(Autenticacion::esEditor($_SESSION['info_usuario']['username'],$idpadre_form,1) < 4 && !Funciones::esAdministrador($_SESSION['info_usuario']['username'], $_SESSION['info_usuario']['password'])) {
					$query = "INSERT INTO "._TBLEDITORES." (idusuario,idcategoria,tipoedicion,permisos) VALUES (".$_SESSION['info_usuario']['idusuario'].",".$ultimoid.",1,3)";
					$db->Execute($query) or errorQuery(__LINE__, __FILE__);
				}

				// Después de INSERTAR la categoría, permitimos que la categoría actual sea nuevamente la del padre
				// para que el sistema regrese a la categoría desde la que iniciamos el proceso
				$idcategoria			= $idpadre_form;
				$idpadre_form			= "";

				// Buscamos cual fué la categoría que acabamos de insertar, ya que el id fué asignado automáticamente
				$query2		= sprintf("SELECT MAX(idcategoria) AS maximo FROM %s", _TBLCATEGORIA);
				$result2	= $db->Execute($query2) or errorQuery(__LINE__, __FILE__);
				$maximo		= $result2->fields['maximo'];

				// Insertamos los permisos de acceso
				if(is_array($restringida_form) && count($restringida_form) > 0) {

					for($i=0; $i < count($restringida_form) ; $i++) {

						$query1	= sprintf("INSERT INTO %s ", _TBLACCESO);
						$query1	.= sprintf("(idcategoria,idlista) VALUES ");
						$query1	.= sprintf("(%s,%s)",$maximo,$restringida_form[$i]);
						$result1 = $db->Execute($query1) or errorQuery(__LINE__, __FILE__);

					}

				}

				// Le presentamos al usuario un mensaje de éxito
				if ($_SERVER['REQUEST_METHOD'] == "POST" && !$total_errores) {

					$error[] = sprintf('Creación exitosa de la categor&iacute;a %s -> %s',$maximo,$nombre_form);
					$smarty1 = new Smarty_Plantilla;
					$smarty1 -> assign('rotMensaje' , _ROT_CONFIRMACION);
					$smarty1 -> assign('tipo' , "exito");
					$smarty1 -> assign('elementoMenu', $error);
					$show = $smarty1 -> fetch('tpl_display_mensaje.html');
					$smarty -> assign('subMenuError' , $show);

				}

				/**
					PROCESO DE ACTUALIZACION
				**/
				// Si NO hay idpadre es porque se va a ACTUALIZAR una categoría
			} else {

				$query  = sprintf("UPDATE %s ", _TBLCATEGORIA);
				// Si esta activo el editor de HTML hacemos el cambio, para dejarlo standard
				$query .= sprintf("SET nombre='%s', descripcion='%s', activa=%s, orden=%s, ",
				$nombre_form,
				($iddisplay_form == 12)?trim($Text1):$Text1,
				$activa_form,
				$orden_form
				);


				$query .= sprintf("fecha1=%s, fecha2=%s, autor='%s', antetitulo='%s', subtitulo='%s', entradilla='%s', validacion='%s'",
				$fecha1_form,
				$fecha2_form,
				$autor_form,
				$antetitulo_form,
				$subtitulo_form,
				$entradilla_form,
				$validacion
				);

				$query .= sprintf(" WHERE idcategoria=%s", $idcategoria);
				$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);

				/**
				 * Registramos la Actualizacion
				 * 1 = Actualizacion
				 */
				Autenticacion::Registrar($idcategoria, 1);
				/**
				 * Miramos si indexamos o no la categoria
				 * $enbusqueda_form : 1 = Si | 0 = No
				 */
				if ($enbusqueda_form == 1) {
					/**
					 * Indexamos la categoria
					 **/
					Edicion::indexarContenido($idcategoria, $nombre_form." ".$autor_form." ".$antetitulo_form." ".$subtitulo_form." ".$entradilla_form." ".$Text1);
				} else {
					/**
					 * Borramos el indice de la categoria
					 */
					$this->borrarIndiceIdCategoria($idcategoria);
				}

				/**
				 * Avisar al Administrador de la página del cambio.
				 * @todo -c areglar el indexar envioCorreoAdministrador
				 */
				//envioCorreoAdministrador('MODIFICAR', $idcategoria, $nombre_form);

				if ($_SERVER['REQUEST_METHOD'] == "POST" && !$total_errores) {
					$error[] = sprintf('Actualización exitosa de la categor&iacute;a %s<br><i>%s</i>',$idcategoria,$nombre_form);
					$smarty1 = new Smarty_Plantilla;
					$smarty1 -> assign('rotMensaje' , _ROT_CONFIRMACION);
					$smarty1 -> assign('tipo' , "exito");
					$smarty1 -> assign('elementoMenu', $error);
					$show = $smarty1 -> fetch('tpl_display_mensaje.html');
					$smarty -> assign('subMenuError' , $show);
				}
			}
		}

		if(!$idpadre_form) {
			/**
			 * Cargamos la informacion del idcategoria actual 
			 * y se carga de nuevo para reflejar el cambio en una insercion o actualizacion
			 */
			$q = sprintf("SELECT * FROM %s WHERE idcategoria = '%s'", _TBLCATEGORIA, $idcategoria);
			$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
			$row = $r->fields;

			$nombre_form		= $row["nombre"];
			$Text1				= trim($row["descripcion"]);
			$activa_form		= $row["activa"];
			$orden_form			= $row["orden"];
			$restringida_form	= $row["restringida"];
			$iddisplay_form		= $row["iddisplay"];
			$iddisplay_sub_form	= $row["iddisplay_sub"];
			$fecha1_form		= $row["fecha1"];
			$fecha2_form		= $row["fecha2"];
			$fecha3_form		= $row["fecha3"];
			$autor_form			= $row["autor"];
			$antetitulo_form	= $row["antetitulo"];
			$subtitulo_form		= $row["subtitulo"];
			$entradilla_form	= $row["entradilla"];
			$esroot_form		= $row["es_root"];
			$enbusqueda_form	= $row["en_buscador"];
			$enmapa_form		= $row["en_mapa"];
			$idioma_form		= $row["idioma"];
			$validacion 		= $row["validacion"];

		} else {
			$activa_form = 1;
			$restringida_form = 0;
			$validacion = "";
		}

		$smarty -> assign('c_action' , $pagina);
		$smarty -> assign('c_formulario_titulo', _ROT_EDICION);

		/**
		 * Cargamos el listado de estados
		 */
		$q = sprintf("SELECT * FROM %s", _TBLCONTRATACION_ESTADOS);
		$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
		$contratacionEstados = array();
		while(!$r->EOF) {
			array_push($contratacionEstados, array("id" => $r->fields['estado_id'], "nombre" => $r->fields['estado_nombre']));
			$r->MoveNext();
		}
		$smarty->assign('estados', $contratacionEstados);

		/**
		  NAVEGACION Y UTILIDADES EN MODO EDICION
		 **/
		$inf = (isset($_GET['inf']) && $_GET['inf'] > 0)?$_GET['inf']: 0;
		$inf = (isset($_POST['inf']) && $_POST['inf'] > 0)?$_POST['inf']: $inf;
		$variables = array(	"idcategoria"  => $idcategoria,
							"idpadre_form" => $idpadre_form,
							"validacion"   => $validacion,
							"inf"		  => $inf,
							"es_Admin"	 => $es_Admin,
							"contratacion" => 0
							);
		$smarty = $this->menuNavegacion($variables,$smarty);
		$smarty -> assign('c_version', _VERSION);
		
		/**
		 * Pasamos la informacion básica del contrato
		 */
		$infoContrato = array(	"idcategoria" => $idcategoria,
								"antetitulo" => $antetitulo_form,
								"subtitulo" => $subtitulo_form,
								"nombre" => $nombre_form,
								"entradilla" => $entradilla_form,
								"autor" => $autor_form,
								"activa" => $activa_form,
								"orden" => $orden_form,
								"fecha1" => $fecha1_form,
								"fecha2" => $fecha2_form,
								"fecha3" => $fecha3_form
								);
		$smarty->assign('infocontrato', $infoContrato);
		
		/**
		 * Informacion de la informacion complementaria
		 */
		$arrayAux = stringtoarray($Text1); /** @see variables.php */
		$arrayAux2 = array();
		if (is_array($arrayAux) and count($arrayAux) > 0) {
			while(list($k, $v) = each($arrayAux)) {
				array_push($arrayAux2, array(	"nombre" => html_entity_decode($v["nombre"],ENT_QUOTES), 
												"valor" => html_entity_decode($v["valor"], ENT_QUOTES), 
												"orden" => $v["orden"]
											)
						);
			}
			$this->variables = $arrayAux2;
		}		
		
		
		$smarty->assign('infocomp', $arrayAux2);
		$smarty->assign('zona', $_SESSION['info_usuario']['idzona']);
		$smarty->assign('infopaso', $this->obtenerEtapas($idcategoria));
		$smarty->assign('image_language', _IMAGE_ADMIN_LANGUAGE);

		return $smarty -> fetch('tpl_edicion_contratacion.html');
	}
	/**
	 * Contratacion :: guardarEtapas
	 * @param
	 * @return array
	 */
	function guardarEtapas($idcategoria, $nombreContrato) {
		require_once(_DIRCORE."Validacion.class.php");
		global $db;	/** @see variables.php */
		
		reset($_POST);
		$idxEtapa = 0;

		/**
		 * Actualizamos las etapas
		 * Primero borramos los archivos que tengamos que borrar
		 */
		if (!empty($_POST['idFileBorrar'])) {
			$sePudoBorrarFile = FALSE;
			$idxFileBorrar = $_POST['idFileBorrar'];
			$qBorrar = sprintf("SELECT idcategoria, descripcion FROM %s WHERE idcategoria = %s", _TBLCATEGORIA, $idxFileBorrar);
			$rBorrar = $db->Execute($qBorrar) or errorQuery(__LINE__, __FILE__);

			if (is_file(_DIRRECURSOS_USER.$rBorrar->fields['descripcion'])) {

				if(unlink(_DIRRECURSOS_USER.$rBorrar->fields['descripcion'])) {
					$sePudoBorrarFile = TRUE;
				} else {
					array_push($this->msg, "No se pudo Borrar el archivo, por favor avisar este suceso al Administrador.");
				}

			} else {
				$sePudoBorrarFile = TRUE;
			}
			/**
			 * Si se borro correctamente, borramos el nodo del archivo
			 */
			if ($sePudoBorrarFile === TRUE){
				$qBorrar = sprintf("DELETE FROM %s WHERE idcategoria = %s", _TBLCATEGORIA, $idxFileBorrar);
				$rBorrar = $db->Execute($qBorrar) or errorQuery(__LINE__, __FILE__);
			}
		}
		
		/**
		 * Luego Actualizamos las etapas del contrato
		 */
		while(list($k, $v) = each($_POST)) {
			
			if(strstr($k, 'nombre_etapa')) {
				
				$idx = str_replace('nombre_etapa', '', $k);

				if ($_POST['activa'.$idx] == '1') {
					/**
					 * Validamos los campos editables de la etapa "Fecha Apertura / Fecha cierre"
					 */
					if (Validacion::isDate($_POST['fecha_apertura'.$idx], TRUE) and Validacion::isDateTime($_POST['fecha_cierre'.$idx], TRUE)) {

						$q = sprintf("SELECT * FROM %s WHERE idpadre = '%s' AND nombre = '%s'", _TBLCATEGORIA, $idcategoria, $_POST[$k]);
						$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
						$idxEtapa = $r->fields['idcategoria'];
	
						/**
						 * Si existe, lo activamos poniendo "activa" en 1
						 */
						if ($r->NumRows() > 0) {
							$q = sprintf("UPDATE %s SET activa = 1, fecha1 = '%s', fecha2 = '%s' WHERE idpadre = '%s' AND nombre = '%s'"
										, _TBLCATEGORIA, $_POST['fecha_apertura'.$idx], $_POST['fecha_cierre'.$idx], $idcategoria, $_POST[$k]);
							$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
						} else {
							$q = sprintf("INSERT INTO %s (idpadre, nombre, fecha1, fecha2, descripcion, iddisplay, validacion, activa) values (%s,'%s','%s','%s','%s','%s','%s', 1)"
							, _TBLCATEGORIA, $idcategoria, $_POST[$k], $_POST['fecha_apertura'.$idx], $_POST['fecha_cierre'.$idx], $idcategoria, 4, $_POST[$k]);
							$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
							$idxEtapa = $db->Insert_ID();
						}
						/**
						 * Guardamos los archivos que se hayan adjuntado
						 */
						if ($_POST['uploadfile'.$idx] == '1') {
							$this->guardarArchivo($idcategoria, $nombreContrato, $idxEtapa, $idx);
						}
					} else {
						array_push($this->msg, "Error al ingresar la etapa '".$_POST[$k]."' debido a que le falta datos o hay error en el formato de las fechas. (Apertura: [yyyy-mm-dd] - Cierre: [yyyy-mm-dd hh:mm:ss])");
					}

				} elseif ($_POST['activa'.$idx] == '0') {

					$q = sprintf("SELECT * FROM %s WHERE idpadre = '%s' AND nombre = '%s'", _TBLCATEGORIA, $idcategoria, $_POST[$k]);
					$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
					/**
					 * Si existe, lo desactivamos borrando todo
					 */
					if ($r->NumRows() > 0) {
						/**
						 * Borramos los archivos adjuntos a la etapa
						 */
						$sePudoBorrarFile = TRUE;
						$qBorrar = sprintf("SELECT idcategoria, descripcion FROM %s WHERE idpadre = %s", _TBLCATEGORIA, $r->fields['idcategoria']);
						$rBorrar = $db->Execute($qBorrar) or errorQuery(__LINE__, __FILE__);
						
						while (!$rBorrar->EOF and $sePudoBorrarFile) {
							if (is_file(_DIRRECURSOS_USER.$rBorrar->fields['descripcion'])) {
				
								if(unlink(_DIRRECURSOS_USER.$rBorrar->fields['descripcion'])) {
									$sePudoBorrarFile = TRUE;
								} else {
									array_push($this->msg, "No se pudo Borrar el archivo, por favor avisar este suceso al Administrador.");
									$sePudoBorrarFile = FALSE;
								}
				
							} else {
								$sePudoBorrarFile = TRUE;
							}
							/**
							 * Si se borro correctamente, borramos el nodo del archivo
							 */
							if ($sePudoBorrarFile === TRUE){
								$qBorrar = sprintf("DELETE FROM %s WHERE idcategoria = %s", _TBLCATEGORIA, $rBorrar->fields['idcategoria']);
								$rBorrar = $db->Execute($qBorrar) or errorQuery(__LINE__, __FILE__);
							}	
						}
						
						/**
						 * Borramos la etapa si se borraron todos los archivos correctamente
						 */
						if ($sePudoBorrarFile === TRUE) {
							$q = sprintf("DELETE FROM %s WHERE idcategoria = '%s' AND nombre = '%s'", _TBLCATEGORIA, $r->fields['idcategoria'], $_POST[$k]);
							$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
						}
					}
				}
			}
		}
		/**
		 * Guardamos el grafico de gantt
		 */
		$this->hacerGraficoGantt($idcategoria);
	}
	/**
	 * Contratacion :: guardarArchivo
	 * @param
	 * @return 
	 */
	function guardarArchivo($idcategoriaContrato, $nombreContrato, $idcategoriaEtapa, $idx) {
		global $db;	/** @see variables.php */
		require_once(_DIRCORE."Validacion.class.php");
		require_once(_DIRCORE."validar_archivos.class.php");
		/**
		 * Validamos el nombre del archivo
		 */
		if (!Validacion::isCadena($_POST['upname'.$idx])) {
			array_push($this->msg, "El nombre del archivo [".$_POST['upname'.$idx]."] tiene car&aacute;cteres no permitidos (Sólo letras, numeros y espacios).");
			return FALSE;
		}
		
		$nombreContrato = preg_replace("/\W/", "_", $nombreContrato);
		
		if (isset($_POST['upname'.$idx]) and !empty($_POST['upname'.$idx]) and
			isset($_FILES['upfile'.$idx]['name']) and !empty($_FILES['upfile'.$idx]['name'])){
				
			/**
			 * Verificamos las extension del archivo para permitir o no la carga
			 */
			$partsFile = pathinfo($_FILES['upfile'.$idx]['name']);
			
		    if (in_array(strtolower($partsFile['extension']), $this->extAllowed)){

				/** Le quitamos "recursos_user/" para que sirva en el template "descarga" */
				$_DIRDOCS_USER = str_replace(_DIRRECURSOS_USER, '', _DIRDOCS_USER);
	
				/**
				 * Vemos que el directorio de documentos exista
				 */
				if (!is_dir(substr(_DIRDOCS_USER, 0, strlen(_DIRDOCS_USER) - 1))) { // le quitamos el slash del fin de la constante
					mkdir(substr(_DIRDOCS_USER, 0, strlen(_DIRDOCS_USER) - 1), 0755);
				}
	
				/**
				 * Vemos que el directorio para el contrato exista
				 */
				if (!is_dir(_DIRDOCS_USER.$idcategoriaContrato)) {
					mkdir(_DIRDOCS_USER.$idcategoriaContrato, 0755);
					chmod(_DIRDOCS_USER.$idcategoriaContrato, 0755);
				}else
				{
					chmod(_DIRDOCS_USER.$idcategoriaContrato, 0755);
				}
				
				$nombreArchivo = $nombreContrato."_".str_replace(" ", "_", Funciones::Removeaccents(preg_replace("/\W/", "_", $_POST['upname'.$idx]))).".".$partsFile['extension'];
				if ($_FILES['upfile'.$idx]['size'] > 0) {
				    chmod(_DIRDOCS_USER.$idcategoriaContrato."/".$nombreArchivo, 0755);
					//if (!rename($_FILES['upfile'.$idx]['tmp_name'], _DIRDOCS_USER.$idcategoriaContrato."/".$nombreArchivo)) {
					//	array_push($this->msg, "No se pudo subir debido a problemas de Permisos. Etapa [".$_POST['nombre_etapa'.$idx]."]");
					//} else {
					if(validar_archivos::validar($_FILES['upfile'.$idx]['tmp_name'],$_FILES['upfile'.$idx]['type'])){
						if (!move_uploaded_file($_FILES['upfile'.$idx]['tmp_name'], _DIRDOCS_USER.$idcategoriaContrato."/".$nombreArchivo)){
							array_push($this->msg, "No se pudo subir debido a problemas de Permisos. Etapa [".$_POST['nombre_etapa'.$idx]."]");
						} else {
							/**
							 * Le cambiamos los permisos al archivo
							 */
							chmod(_DIRDOCS_USER.$idcategoriaContrato."/".$nombreArchivo, 0755);
							/**
							 * Asignamos el archivo al nodo de la etapa para que quede accequible desde el portal 
							 */
							$q = sprintf("SELECT * FROM %s WHERE idpadre = %s AND nombre = '%s'", _TBLCATEGORIA, $idcategoriaEtapa, $_POST['upname'.$idx]);
							$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
							/**
							 * Insertamos el archivo en caso de que no exista
							 * Si ya existe, entonces lo dejamos asi, y se sobreescribe
							 * el archivo
							 */
							if ($r->NumRows() == 0) { /** Insertamos */
								$q = sprintf("INSERT INTO %s (idpadre, nombre, descripcion, fecha1, iddisplay, validacion, activa, fecha3) VALUES (%s, '%s', '%s', '%s', '%s', '%s', 1, '%s')"
											,_TBLCATEGORIA , $idcategoriaEtapa, $_POST['upname'.$idx], $_DIRDOCS_USER.$idcategoriaContrato."/".$nombreArchivo, date("Y-m-d"), 10, "contratacion", date("Y-m-d H:i:s"));
								$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
								if($ultimoid_1){
									FriendlyURL::generarNombresBaseYUnicos($db);
									FriendlyURL::generarProfundidades($db);
									FriendlyURL::generarUrlsAmigables($db);
							    }
							}	
						}	
					//}	
					} else {
						//array_push($this->msg, "No se pudo subir el archivo [".$_FILES['upfile'.$idx]['name']."] debido a que el archivo es muy grande. Etapa [".$_POST['nombre_etapa'.$idx]."]");
						array_push($this->msg, "No se pudo subir el archivo [".$_FILES['upfile'.$idx]['name']."] debido a que el archivo tiene c&oacute;digo peligroso.");	
					}
				
				} else {
					//array_push($this->msg, "No tiene permitido subir archivos con extension '".$partsFile['extension']."'. Archivo [".$_FILES['upfile'.$idx]['name']."]. Etapa [".$_POST['nombre_etapa'.$idx]."]");
					array_push($this->msg, "No se pudo subir el archivo [".$_FILES['upfile'.$idx]['name']."] debido a que el archivo es muy grande. Etapa [".$_POST['nombre_etapa'.$idx]."]");
				}

			} else {
				//array_push($this->msg, "No se pudo subir debido a que el nombre del archivo o el archivo no fue ingresado. Etapa [".$_POST['nombre_etapa'.$idx]."]");
				array_push($this->msg, "No tiene permitido subir archivos con extension '".$partsFile['extension']."'. Archivo [".$_FILES['upfile'.$idx]['name']."]. Etapa [".$_POST['nombre_etapa'.$idx]."]");
			}
		
		} else {
			array_push($this->msg, "No se pudo subir debido a que el nombre del archivo, el archivo o la fecha no fue ingresado. Etapa [".$_POST['nombre_etapa'.$idx]."]");
		}
	}
	/**
	 * Contratacion :: hacerGraficoGantt
	 * Hace el grafico de gatt del contrato con $idcategoria
	 * Para hacerlo pide ayuda a las librerias de jpgraph, y guarda el
	 * resultado en una imagen guardada en el dir del contrato llamada "grafico.png"
	 * @param int idcategoria
	 * @return boolean
	 */
	function hacerGraficoGantt($idcategoria) {
		
		global $db;	/** @see variables.php */
		require_once (_DIRJPGRAPH."jpgraph.php");
		require_once (_DIRJPGRAPH."jpgraph_gantt.php");
		
		/**
		 * Obtenemos la informacion propia del contrato
		 */
		$q = sprintf("SELECT * FROM %s WHERE idcategoria = %s", _TBLCATEGORIA, $idcategoria);
		$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
		$row = $r->fields;

		/**
		 * Obtenemos el estado del contrato de la tabla de estados de contratos
		 */
		$q = sprintf("SELECT * FROM %s WHERE estado_id = '%s'", _TBLCONTRATACION_ESTADOS, $row['antetitulo']);
		$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
		$nombreEstadoContrato = '';
		if ($r->NumRows() > 0) {
			$nombreEstadoContrato = $r->fields['estado_nombre'];
		}

		$infoContrato = array("titulo" => $row['nombre']
		, "objeto" => $row['entradilla']
		, "fecha_creacion" => $row['fecha3']
		, "fecha_apertura" => $row['fecha1']
		, "fecha_cierre" => $row['fecha2']
		, "cuantia" => number_format($row['subtitulo'],0,'','.')
		, "estado" => $nombreEstadoContrato
		);
		
		$fecha_inicio = explode(' ', $infoContrato['fecha_apertura']);
		$fecha_cierre = explode(' ', $infoContrato['fecha_cierre']);
		
		/**
		 * Miramos si la fecha de cierre es menor que la de inicio
		 */
		$fecha_inicio_date = explode('-',$fecha_inicio[0]);
		$fecha_cierre_date = explode('-',$fecha_cierre[0]);
		if (mktime(0,0,0, $fecha_inicio_date[1], $fecha_inicio_date[2], $fecha_inicio_date[0])
			> mktime(0,0,0, $fecha_cierre_date[1], $fecha_cierre_date[2], $fecha_cierre_date[0])) {
			$fecha_cierre = $fecha_inicio;
		}

		/**
		 * Obtenemos las Etapas
		 */
		$infoEtapas = $this->obtenerEtapas($idcategoria);
		$counter = 0;
		$infoData = array();
		
		while(list($k, $v) = each($infoEtapas)) {
			array_push($infoData, array($counter, ACTYPE_GROUP, $v["titulo"], $fecha_inicio[0], $fecha_cierre[0], ''));
			$counter++;
			while(list($k2, $v2) = each($v['etapas'])) {
				if ($v2['activa'] === TRUE) {
					$fecha_iniciov2 = explode(' ', $v2['fecha_apertura']);
					$fecha_cierrev2 = explode(' ', $v2['fecha_cierre']);
					array_push($infoData, array($counter, ACTYPE_NORMAL, $v2["titulo"], $fecha_iniciov2[0], $fecha_cierrev2[0], ''));
					$counter++;
				}
			}
		}
		
		/** Creamos el grafico y hay mas de 2 (tags:"Contractual, Precontractual") */
		if (count($infoData) > 2) { 
			/** Ponemos la linea de inicio y de fin del periodo	 */
			$vline = new GanttVLine($fecha_inicio[0], 'Inicio', "#008040", 3, "solid");
			$vline2 = new GanttVLine($fecha_cierre[0], 'Fin', "#FF1A00", 3, "solid");
			
			$constrains = array();
			$progress = array();
			
			$graph = new GanttGraph();
			$graph->SetDateRange($fecha_inicio[0], $fecha_cierre[0]);
			$graph->title->Set(html_entity_decode($infoContrato["titulo"]));
			$graph->Add($vline);
			$graph->Add($vline2);
			
			
			// Setup scale
			$graph->ShowHeaders( GANTT_HYEAR | GANTT_HMONTH |  GANTT_HDAY | GANTT_HWEEK);
			$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAYWNBR);
	
			// Add the specified activities
			$graph->CreateSimple($infoData, $constrains, $progress);
			
			/**
			 * Vemos que el directorio para el contrato exista ante de guardar
			 */
			if (!is_dir(_DIRDOCS_USER.$idcategoria)) {
				if (!mkdir(_DIRDOCS_USER.$idcategoria, 0755)) {
					array_push($this->msg, "No se pudo crear el archivo por permisos en la carpeta, o esta no existe.");
				} else {
					// Guardamos la imagen
					$graph->Stroke(_DIRDOCS_USER.$idcategoria."/grafico.png");
				}
			} else {
				// Guardamos la imagen
				$graph->Stroke(_DIRDOCS_USER.$idcategoria."/grafico.png");
			}
		}
	}
	/**
	 * Contratacion :: obtenerEtapas
	 * @param
	 * @return array
	 */
	function obtenerEtapas($idcategoria) {
		global $db;	/** @see variables.php */

		$arrayPasos = array();
		$arrayOrdenPasos = array("Precontractual", "Contractual", "PostContractual");
		/**
		 * Sacamos las etapas que tenemos
		 */
		$q = sprintf("SELECT DISTINCT(etapa_nombre), etapa_estado FROM %s WHERE etapa_nombre = 'Solicitud de Oferta' ORDER BY idetapa desc", _TBLCONTRATACION_ETAPAS);
		$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);

		while(!$r->EOF) {
			$d = $r->fields;
			/**
			 * Sacamos los datos de la etapa actual que tiene el contrato actual "idcategoria"
			 */
			$q2 = sprintf("SELECT idcategoria, nombre, fecha1, fecha2, antetitulo, activa FROM %s WHERE nombre='%s' AND idpadre = %s"
			, _TBLCATEGORIA, $d['etapa_nombre'], $idcategoria);
			$r2 = $db->Execute($q2) or errorQuery(__LINE__, __FILE__);

			$arrayEtapas = array();

			if ($r2->NumRows() > 0) {
				$d2 = $r2->fields;

				$arrayEtapas['titulo'] = $d['etapa_nombre'];
				$arrayEtapas['paso'] = $d['etapa_estado'];

				$arrayEtapas['fecha_apertura'] = $d2["fecha1"];
				$arrayEtapas['fecha_cierre'] = $d2["fecha2"];
				$arrayEtapas['idcategoria'] = $d2["idcategoria"];
				$arrayEtapas['activa'] = ($d2["activa"] == 1) ? TRUE : FALSE;
				$arrayEtapas['archivos'] = array();

				/**
				 * Sacamos los archivos de la etapa actual del $d2[idcategoria] de la etapa
				 */
				$q3 = sprintf("SELECT idcategoria, nombre, descripcion, fecha1 FROM %s WHERE idpadre = %s", _TBLCATEGORIA, $d2["idcategoria"]);
				$r3 = $db->Execute($q3) or errorQuery(__LINE__, __FILE__);

				$arrayArchivos = array();

				if ($r3->NumRows() > 0) {
					while(!$r3->EOF) {
						$d3 = $r3->fields;
						
						/**
						 * Como parte de la interfaz sacamos el icono que relacione al tipo de archivo
						 * y la sacamos de nuestra carpeta de extensiones
						 */
						if (!empty($d3["descripcion"])) {
							$path = pathinfo($d3["descripcion"]);
							if (is_file(_DIRIMAGES.'extensiones/'.$path['extension'].'.gif')) {
								$extension = _DIRIMAGES.'extensiones/'.$path['extension'].'.gif';
							} else {
								$extension = _DIRIMAGES.'extensiones/fic.gif';
							}
						} else {
							$extension = _DIRIMAGES.'extensiones/fic.gif';
						}
						array_push($arrayArchivos, array("idcategoria" => $d3["idcategoria"], "nombre" => $d3["nombre"], "url" => $d3["descripcion"], "fecha" => $d3["fecha1"], "img_extension" => $extension));
						$r3->MoveNext();
					}
				}

				if (count($arrayArchivos) > 0) {
					$arrayEtapas['archivos'] = $arrayArchivos;
				} else {
					unset($arrayEtapas['archivos']);
				}

			} else {
				$arrayEtapas['titulo'] = $d['etapa_nombre'];
				$arrayEtapas['paso'] = $d['etapa_estado'];
				$arrayEtapas['activa'] = FALSE;
			}

			/**
			 * Guardamos las etapas
			 */
			if (($ind = array_search($d['etapa_estado'], $arrayOrdenPasos)) >= 0) {
				/** $ind : es el indice del paso, se puso asi, para ordenarlo y de una queda listo para smarty*/
				if (isset($arrayPasos[$ind])) {
					array_push($arrayPasos[$ind]['etapas'], $arrayEtapas);
				} else {
					$arrayPasos[$ind] = array();
					$arrayPasos[$ind]['etapas'] = array();
					$arrayPasos[$ind]['titulo'] = $d['etapa_estado'];
					array_push($arrayPasos[$ind]['etapas'], $arrayEtapas);
				}
			}
			$r->MoveNext();
		}
		return $arrayPasos;
	}
	/**
	 * Edicion :: menuNavegacion
	 * @param $variables
	 * @param $smarty
	 * @return 
	 */
	function menuNavegacion($variables, $smarty){

		$idcategoria  = $variables["idcategoria"];
		$idpadre_form = $variables["idpadre_form"];
		$validacion   = $variables["validacion"];
		$inf		  = $variables["inf"];
		$es_Admin	  = $variables["es_Admin"];
		$contratacion = $variables["contratacion"];

		$idpadre_temp	 = (!$idpadre_form)?Funciones::BuscarPadre($idcategoria):$idpadre_form;

		if(!$auth_categoria = Autenticacion::esEditor($_SESSION["info_usuario"]['username'],$idcategoria,1)){
			$auth_categoria = 0;
		}
		if(!$auth_padre = Autenticacion::esEditor($_SESSION["info_usuario"]['username'],$idpadre_temp,1)){
			$auth_padre = 0;
		}

		if (Funciones::esAdministrador($_SESSION["info_usuario"]['username'], $_SESSION["info_usuario"]['password'])) {
			$auth_categoria = 4;
			$auth_padre = 4;
		}

		/* ANTERIOR */
		$idanterior_temp  = (!$idpadre_form)?Edicion::BuscarAnterior($idcategoria):0;
		$anterior		 = ($idanterior_temp >= 1)? sprintf("<a href=index.php?e&amp;idcategoria=%s>%s</a>",$idanterior_temp,sprintf("<img src=%s/boton_anterior_on.gif border=0  alt=\"\">",_DIR_IMAGES_EDITOR)):sprintf("<img src=%s/boton_anterior_off.gif border=0 alt=\"\">",_DIR_IMAGES_EDITOR);

		/* SUBIR */
		$padre_tem1	   = ($idpadre_form) ? "boton_borrar_on.gif" : "boton_padre_on.gif";
		$padre_tem2	   = ($idpadre_form) ? "Cancelar" : "Subir";

		if($idpadre_temp >= 1 && $auth_padre > 0) {
			$imagen = "boton_padre_on.gif";
		} else if($idpadre_temp >= 1 && $auth_padre == 0) {
			$imagen = "boton_padre_non.gif";
		} else if($idpadre_temp < 1 && $auth_padre > 0) {
			$imagen = "boton_padre_off.gif";
		} else {
			$imagen = "boton_padre_noff.gif";
		}

		$padre			= ($idpadre_temp >= 1 && $auth_padre>0)?sprintf("<a href=index.php?e&amp;idcategoria=%s><img src=%s%s border=0 alt=\"\"></a>",$idpadre_temp,_DIR_IMAGES_EDITOR,$imagen):sprintf("<img src=%s%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$imagen);

		/* SIGUIENTE */
		$idsiguiente_temp = (!$idpadre_form)?Edicion::BuscarSiguiente($idcategoria):0;
		$siguiente		= ($idsiguiente_temp >= 1)? sprintf("<a href=index.php?e&amp;idcategoria=%s>%s</a>",$idsiguiente_temp,sprintf("<img src=%sboton_siguiente_on.gif border=0 alt=\"\">",_DIR_IMAGES_EDITOR)):sprintf("<img src=%sboton_siguiente_off.gif border=0 alt=\"\">",_DIR_IMAGES_EDITOR);

		/* RELOAD */
		$reload_tem1	  = (!$idpadre_form)?"boton_reload_on.gif":"boton_reload_off.gif";
		$reload		   = (!$idpadre_form)?sprintf("<a href=index.php?e&amp;idcategoria=%s&amp;inf=%s>%s</a>", $idcategoria,$inf,sprintf("<img src=%s/%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$reload_tem1)):sprintf("<img src=%s%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$reload_tem1);

		/* VER */
		$volver  = sprintf("<a href=index.php?ne&amp;idcategoria=%s&amp;inf=%s>%s</a>", $idcategoria, $inf, sprintf("<img src=%s/boton_modo_normal.gif border=0 alt=\"\">",_DIR_IMAGES_EDITOR));

		/* TERMINAR */
		$terminar = sprintf("<a href=index.php?idcategoria=1&amp;logout=1>%s</a>", sprintf("<img src=%s/boton_terminar.gif border=0 alt=\"\">",_DIR_IMAGES_EDITOR));



		$ancho = 53;
		$boton_salvar = "<table border=0 align=center summary=''><tr>";
		$boton_salvar .= sprintf("<td align=center width=%s>%s</td>",$ancho,$anterior);
		$boton_salvar .= sprintf("<td align=center width=%s>%s</td>",$ancho,$padre);
		$boton_salvar .= sprintf("<td align=center width=%s>%s</td>",$ancho,$siguiente);

		/* SALVAR */
		$boton_salvar .= ($auth_categoria>=3 || $idpadre_form)?sprintf("<td align=center width=%s><input type=image src=%sboton_salvar.gif></td>",$ancho,_DIR_IMAGES_EDITOR):sprintf("<td align=center width=%s><img src=%sboton_salvar_n.gif alt=\"\"></td>",$ancho,_DIR_IMAGES_EDITOR);

		$boton_salvar .= sprintf("<td align=center width=%s>%s</td>",$ancho,$reload);
		$boton_salvar .= sprintf("<td align=center width=%s>%s</td>",$ancho,$volver);
		$boton_salvar .= sprintf("<td align=center width=%s>%s</td>",$ancho,$terminar);

		$boton_salvar .= "</tr><tr>";

		$boton_salvar .= "<td align=center class=edicion_elemento valign=top>Anterior</td>";
		$boton_salvar .= sprintf("<td align=center class=edicion_elemento valign=top>%s</td>",$padre_tem2);
		$boton_salvar .= "<td align=center class=edicion_elemento valign=top>Siguiente</td>";
		$boton_salvar .= "<td align=center class=edicion_elemento valign=top>Salvar</td>";
		$boton_salvar .= "<td align=center class=edicion_elemento valign=top>Reload</td>";
		$boton_salvar .= "<td align=center class=edicion_elemento valign=top>Ver</td>";
		$boton_salvar .= "<td align=center class=edicion_elemento valign=top>Terminar</td>";
		$boton_salvar .= "</tr>";
		$boton_salvar .= "</table>";

		$smarty -> assign('c_salvar',$boton_salvar);


		return $smarty;
	}
	/**
	 * Contratacion :: FormatoContratacion
	 * @param
	 * @return 
	 */
	function FormatoContratacion($idcategoria) {
		global $db; /** @see variables.php */

		define("_ROT_LICITACION_COLOR_FECHA_PROYECTADA","#FFFF00");
		define("_ROT_LICITACION_COLOR_FECHA_PASADA","#FFBB00");
		define("_ROT_LICITACION_COLOR_FECHA_CURSO","#00CC00");

		/**
		 * Obtenemos la informacion propia del contrato
		 */
		$q = sprintf("SELECT * FROM %s WHERE idcategoria = %s", _TBLCATEGORIA, $idcategoria);
		$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
		$row = $r->fields;

		/**
		 * Obtenemos el estado del contrato de la tabla de estados de contratos
		 */
		$q = sprintf("SELECT * FROM %s WHERE estado_id = '%s'", _TBLCONTRATACION_ESTADOS, $row['antetitulo']);
		$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
		$nombreEstadoContrato = '';
		if ($r->NumRows() > 0) {
			$nombreEstadoContrato = $r->fields['estado_nombre'];
		}

		$infoContrato = array("titulo" => html_entity_decode($row['nombre'])
		, "objeto" => html_entity_decode($row['entradilla'])
		, "fecha_creacion" => $row['fecha3']
		, "fecha_apertura" => $row['fecha1']
		, "fecha_cierre" => $row['fecha2']
		, "cuantia" => number_format($row['subtitulo'],0,'','.')
		, "estado" => $nombreEstadoContrato
		, "estadoid" => $row['antetitulo']
		);

		/**
		 * Obtenemos la informacion complementaria
		 */
		$infoComplementaria = stringtoarray($row['descripcion']);
		$inFoComp2 = array();
		if (is_array($infoComplementaria) and count($infoComplementaria) > 0) {
			while(list($k, $v) = each($infoComplementaria)) {
				$inFoComp2[$k] = array("nombre" => $v["nombre"]
										, "valor" => FuncionesInterfaz::ReemplazarMail($v["valor"])
										, "orden" =>  $v["orden"]);
			}	
		}
		$infoComplementaria = $inFoComp2;

		/**
		 * Obtenemos las etapas con sus respectivos archivos para el contrato actual
		 * y lo ordenamos por fecha de manera ascendente
		 */
		$infoEtapas = $this->obtenerEtapas($idcategoria);
		$arrayEtapas = array();
		$arrayEtapasFecha = array();
		
		while(list(,$v) = each($infoEtapas)) {
			while(list(,$v2) = each($v['etapas'])) {
				if ($v2['activa'] === TRUE) {
					
					if($v2["fecha_apertura"] == '000-00-00 00:00:00') {
						$arrayEtapas['color_fecha_apertura'] = '#fff';
					} else {
						if ($v2["fecha_apertura"] < date("Y-m-d H:m:s") && $v2["fecha_cierre"] < date("Y-m-d H:m:s")) {
							$bgcolor = _ROT_LICITACION_COLOR_FECHA_PASADA;
						 }elseif($v2["fecha_apertura"] <= date("Y-m-d H:m:s") && $v2["fecha_cierre"] >= date("Y-m-d H:m:s")) {
							$bgcolor = _ROT_LICITACION_COLOR_FECHA_CURSO;
						} elseif($v2["fecha_apertura"] > date("Y-m-d H:m:s") && $v2["fecha_cierre"] > date("Y-m-d H:m:s")) {
							$bgcolor = _ROT_LICITACION_COLOR_FECHA_PROYECTADA;
						}
						$v2['color_fecha_apertura'] = $bgcolor;
					}
					
					array_push($arrayEtapas, $v2);
					array_push($arrayEtapasFecha, $v2['fecha_apertura']);
				}
			}
		}
		array_multisort($arrayEtapasFecha, SORT_DESC, SORT_REGULAR, $arrayEtapas); // se organizan ASC for fecha
		$infoEtapas = $arrayEtapas;

		/**
		 * Y lo ponemos en la plantilla
		 */
		$smarty = new Smarty_Plantilla;

		$smarty->assign('info', $infoContrato);
		$smarty->assign('infoComp', $infoComplementaria);
		$smarty->assign('infoEtapas', $infoEtapas);
		/**
		 * Miramos que el gráfico exista
		 */
		$imgUrl = _DIRDOCS_USER.$idcategoria."/grafico.png";
		if (is_file($imgUrl)) {
			$smarty->assign('imgPlan', $imgUrl);
		}
		
		
		/* Herramientas */
		/****************************************
		El vínculo para subir, se crea cuando el contenido
		es muy largo (2000 caracteres por default).
		El vínculo para imprimir solo si existe contenido.
		El vínculo de cuéntele solo si existe contenido.
		****************************************/

		/* Subir */
		$c_subir = sprintf("<a href=#top title='Ir al inicio de esta p&aacute;gina'><img src=%smini_subir.gif border=0 alt=\"Ir al inicio de esta p&aacute;gina\"></a>&nbsp;", _DIRIMAGES_AUX);
		$smarty -> assign('c_subir', trim($c_subir));
 
		/* Imprimir */
		if (isset($c_submenu)) {
			$c_imprimir = ($idcategoria == 1 || (strlen(trim($row["descripcion"])) == 0 && strlen(trim($c_submenu)) == 0 && strlen(trim($row["entradilla"])) == 0))?"":FuncionesInterfaz::Imprimir($idcategoria, '');
			$smarty -> assign('c_imprimir', trim($c_imprimir));
		}

		/* Cuéntele */
		$c_cuentele = ($idcategoria == 1 || strlen(trim($row["descripcion"])) == 0)?"":FuncionesInterfaz::Cuentele($idcategoria);
		$smarty -> assign('c_cuentele', $c_cuentele);

		return $smarty -> fetch('tpl_detalle_contratacion.html');
	}
	/**
	 * Contratacion :: imprimirListado
	 * @param
	 * @return 
	 */
	function imprimirListado($idcategoria) {
		global $db;	/** @see variables.php */
		/**
		 * Cargamos el listado de estados
		 */
		$q = sprintf("SELECT * FROM %s", _TBLCONTRATACION_ESTADOS);
		$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
		$contratacionEstados = array();
		while(!$r->EOF) {
			array_push($contratacionEstados, array("id" => $r->fields['estado_id'], "nombre" => $r->fields['estado_nombre']));
			$r->MoveNext();
		}
		/**
		 * Cargamos los años
		 */
		$anios = array();
		for($i="2003";$i<=date("Y");$i++){
			array_push($anios,array("ano_id" => $i,"ano_nombre" => $i));
		}
		
		
		/* NUEVO */
		$arrayAux2 = array();
		
		$smarty = new Smarty_Plantilla;
		$smarty->assign('estados', $contratacionEstados);
		$smarty->assign('anios', $anios);
		$smarty->assign('listado', $this->cargar($idcategoria, $smarty));
		$smarty->assign('infopaso', $this->obtenerEtapas($idcategoria));
		$smarty->assign('infocomp', $arrayAux2);
		
		return $smarty -> fetch('tpl_contratacion.html');
	}
	/**
	 * Contratacion :: filtroListado
	 * @param
	 * @return 
	 */
	function cargar($idcategoria, &$smarty) {
		
		require_once(_DIRLIB_ADMIN."Pager.class.php");
		global $db;	/** @see variables.php */
		global $idcategoria;	/** @see variables.php */
		global $trazaCategoria;	/** @see variables.php */
		
		$returnValue = array();

				// Verifying the CSRF Token
		$is_secure_form=true;
		if(
isset($_POST['anio']) ||
isset($_POST['orden']) ||
isset($_POST['tipoorden']) ||
isset($_POST['estado']) ||
isset($_POST['pag'])
		){
			$is_secure_form=false;
			if (!empty($_REQUEST['token'])) {
			    $is_secure_form=Funciones::hash_equals($_SESSION['token'], $_REQUEST['token']);
			}
			if(!$is_secure_form){
				print_r("Acceso incorrecto detectado.");
			}
		}

		if($is_secure_form){
			$q = sprintf("SELECT idcategoria, nombre, fecha1, fecha2, antetitulo, subtitulo, entradilla, autor FROM %s WHERE idpadre = '%s' AND activa = 1 %s"
						, _TBLCATEGORIA, $idcategoria, $this->filtro());
		}
		$r = $db->Execute($q);
		
		$filtros = $_SESSION['filtros'][$idcategoria]; // filtros de sesion para el listado actual
		/**
		 * Creamos el objeto de Paginacion
		 */
		$elementPag = 0;
		if ($trazaCategoria[$idcategoria]['paginas_sub'] > 0) {
			$elementPag = $trazaCategoria[$idcategoria]['paginas_sub'];
		} else {
			$elementPag = _NUMREG_LST_ADMIN;
		}
		$d = new Pager($r, $elementPag, isset($filtros['pag']) ? $filtros['pag'] : 1);
		$smarty->assign('paginas', $d->values);
		$smarty->assign('anio', $filtros['anio']);
		$smarty->assign('estado', $filtros['estado']);
		$smarty->assign('orden', $filtros['orden']);
		$smarty->assign('tipoorden', $filtros['tipoorden']);
		
		while (!$d->EOF) {
			$row = $d->fields;
			array_push($returnValue, $row);
			$d->MoveNext();
		}
		return $returnValue;
	}
	/**
	 * Contratacion :: filtro
	 * @param
	 * @return 
	 */
	function filtro() {
		require_once(_DIRCORE."Validacion.class.php");
		global $idcategoria;	/** @see variables.php */
		
		$yaPuso = TRUE;
		$filtro = "";
		
		/**
		 * Guardamos las variables en session
		 */
		$filtroCampos = array();
		
		/** Verificamos que el array de filtros exista */
		if (!isset($_SESSION['filtros'])) {
			$_SESSION['filtros'] = array();
		}
		
		/** Verificamos que el array de filtros para el $idcategoria exista */
		if (!isset($_SESSION['filtros'][$idcategoria])) {
			$_SESSION['filtros'][$idcategoria] = array();
		}
		
		$filtroCampos = $_SESSION['filtros'][$idcategoria];

		$filtroCampos['anio'] = (isset($_POST['anio'])) ? $_POST['anio'] : ((isset($filtroCampos['anio'])) ? $filtroCampos['anio'] : date("Y"));		
		$filtroCampos['orden'] = (isset($_POST['orden'])) ? $_POST['orden'] : ((isset($filtroCampos['orden'])) ? $filtroCampos['orden'] : 'fecha1');		
		$filtroCampos['tipoorden'] = (isset($_POST['tipoorden'])) ? $_POST['tipoorden'] : ((isset($filtroCampos['tipoorden'])) ? $filtroCampos['tipoorden'] : 'DESC');
		$filtroCampos['estado'] = (isset($_POST['estado'])) ? $_POST['estado'] : ((isset($filtroCampos['estado'])) ? $filtroCampos['estado'] : '');

		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$filtroCampos['pag'] = (isset($_POST['pag'])) ? $_POST['pag'] : ((isset($filtroCampos['pag'])) ? $filtroCampos['pag'] : '');
		}

		if (isset($filtroCampos['anio']) and !empty($filtroCampos['anio'])) {
			$filtro .= ($yaPuso === TRUE) ? " AND " : "";
			$filtro .= "fecha1 LIKE ('%".$filtroCampos['anio']."%')";
			$yaPuso = TRUE;
		}
		
		if (isset($filtroCampos['estado']) and !empty($filtroCampos['estado'])) {
			$filtro .= ($yaPuso === TRUE) ? " AND " : "";
			$filtro .= "antetitulo LIKE ('%".$filtroCampos['estado']."%')";
			$yaPuso = TRUE;
		}

		if (isset($filtroCampos['orden']) and !empty($filtroCampos['orden'])) {
			$filtro .= " ORDER BY ".$filtroCampos['orden']." ";
		}
		
		if (isset($filtroCampos['tipoorden']) and !empty($filtroCampos['tipoorden'])) {
			$filtro .= " ".$filtroCampos['tipoorden']." ";
		}
		
		$_SESSION['filtros'][$idcategoria] = $filtroCampos;
		if (!empty($filtro)) {
			return $filtro;
		}
	}
}
?>