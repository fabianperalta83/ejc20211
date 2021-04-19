<?php
/**
 * Clase Edicion
 *
 * Esta Clase contiene todos las funciones del formulario de Edición
 * @return
 * 2005 copyright
 **/

class Edicion {

	/**
	 * Edicion :: indexarContenido
	 * @param integer $id
	 * @return
	 */
	function indexarContenido ($id, $contenido) {

		define('_DEBUGLEXEMA', FALSE);
		require_once (_DIRBUSCAR."funciones.php");
		require_once (_DIRBUSCAR."Transform.class.php");
		require_once (_DIRBUSCAR."Idf.class.php");
		require_once (_DIRBUSCAR."Frecuencia.class.php");

		/**
		 * Inicializacion de variables
		 **/
		$lexemas = array();// Guarda los lexemas resultantes de la reduccion de un documento.
		$categoriaProcesado = 0;

		/**
		 * inicializacion de objetos
		 **/
		$unTransform = new Transform(); // Objeto tranform que realiza la reduccion de terminos de un documento.
		$unFrecuencia = new Frecuencia();
		$unIdf = new Idf();

		$lexemas = $unTransform->reducir($contenido);
		$unFrecuencia->guardarDocumento($id, $lexemas);
		$unIdf->copiarValorTIdfId($id);
		$unIdf->calcularIDXIdCategoria($id);

	}
	/**
	 * Edicion :: borrarIndiceIdCategoria
	 * Borra el Indice de la Categoria
	 * @param integer $id
	 * @return
	 */
	function borrarIndiceIdCategoria ($id) {
		global $db;	/** @see variables.php */
		/**
		 * primero borramos los datos que se tienen del idarticulo que se tiene
		 **/
		$q1 = sprintf("DELETE FROM frecuencia_original WHERE articulo_id = '%s'", $id);
		$db->Execute($q1) or errorQuery(__LINE__, __FILE__);
	}
	/**
	 * Edicion :: checkCambio
	 * mira la diferencia entre los dos array, y saca un string unicamente con los cambios
	 * @param
	 * return
	 */
	function checkCambio($arrayActual, $arrayNuevo) {
		$msg = '';
		while (list($k, $v) = each($arrayNuevo)) {
			if (!isset($arrayActual[$k])) {
				$msg .= "<br>El campo $k no existe en el actual ";
			} elseif ($k == 'fecha1' or $k == 'fecha2') {
				if ("'".$arrayActual[$k]."'" != $arrayNuevo[$k]) {
					$msg .= "<br><strong>".strtoupper($k).":</strong>'$arrayActual[$k]' -> '$arrayNuevo[$k]'";
				}
			} else {
				if ($arrayActual[$k] != $arrayNuevo[$k]) {
					$msg .= "<br><strong>".strtoupper($k).":</strong> '$arrayActual[$k]' -> '$arrayNuevo[$k]'";
				}
			}
		}
		if (!empty($msg)) {
			return "Los siguientes campos fueron cambiados:".$msg;
		} else {
			return "";
		}
	}
	/**
	 * Edicion :: TemplateEdicion
	 * Funcion que procesa todos las acciones de la edicion
	 * @param integer $idcategoria
	 * @return
	 */
	function TemplateEdicion($idcategoria) {
		require_once(_DIRCORE."Validacion.class.php");

		global $db;	/** @see variables.php */
		global $trazaCategoria;	/** @see variables.php */

		$arrayPreActualizacion = $trazaCategoria[$idcategoria];

		$error = array();

		$smarty = new Smarty_Plantilla;
		$pagina = basename($_SERVER['PHP_SELF']);
		$pagina .= sprintf("?idcategoria=%s", $idcategoria);
		$phpself = $pagina;

		$smarty->assign('userInfo', $_SESSION['info_usuario']);

		// Captura de todas las variables que vienen por POST del formulario de edición

		$idpadre_form			= getVariable('idpadre_form');
		$idborrar				= getVariable('idborrar');
		$idduplicar				= getVariable('idduplicar');
		$idactivar				= getVariable('idactivar');
		$idrenum			 	= getVariable('idrenum');
		$validacion				= getVariable('validacion');


		if(!isset($idpadre_form) || $idpadre_form==0 || $idpadre_form==""){
			// ini_set('display_errors', 1);
			// error_reporting(E_ALL);
			require_once (_DIRCORE."Rectifier.class.php");

			$options = array(
				'delimiter' => '_',
				'limit' => null,
				'lowercase' => true,
				'replacements' => array(
						'/\b&aacute;\b/i' => 'a',
						'/\b&eacute;\b/i' => 'e',
						'/\b&iacute;\b/i' => 'i',
						'/\b&oacute;\b/i' => 'o',
						'/\b&uacute;\b/i' => 'u'
					),
				'transliterate' => true
			);
			
			$name = $trazaCategoria[$idcategoria]["nombre"];
			$name = Rectifier::url_slug($name,$options);
			$path = "masivos".DIRECTORY_SEPARATOR.$name."_".$idcategoria.DIRECTORY_SEPARATOR;

			$smarty->assign("path",$path);
		}


		/**
		 * Validaciones
		 */
		$pattern = "[^\\\\]";

		/** nombre */
		
		$nombre_form			= strip_tags(trim(getVariable('nombre_form'))); 
		if (Validacion::isEmpty($nombre_form) and empty($idborrar) and empty($idduplicar) and empty($idrenum) and empty($idactivar)) {
			array_push($error, "El Nombre no puede estar vac&iacute;o.");
		}
		if (!Validacion::isEmpty($nombre_form) and !Validacion::isCustom($nombre_form, $pattern)) {
			array_push($error, "El Nombre contiene caracteres no permitidos.");
		}
		//$nombre_form			= htmlentities($nombre_form, ENT_QUOTES); configuración anterior a actualización PHP
		/* Nueva validación debido a la actualización de la versión del php*/
		if(htmlentities($nombre_form, ENT_QUOTES)){
                      $nombre_form = htmlentities($nombre_form, ENT_QUOTES);
        }

		/** imagen */
		$imagen_form			= getVariable('imagen_form');
		$patternImage = "^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚüÜ \.&_\(\)\/,;#-]+$";
		if (!empty($imagen_form) and !Validacion::isCustom($imagen_form, $patternImage)) {
			array_push($error, "La Imagen contiene caracteres no permitidos.");
		}
		
		/** fecha1 */
		$fecha1_form			= strip_tags(trim(getVariable('fecha1_form')));	
		if ($fecha1_form == "0000-00-00" || $fecha1_form == "0000-00-00 00:00:00" || $fecha1_form == "0") {
			$fecha1_form = '';
		}elseif($fecha1_form == ''){
			$hoy = mktime(date("G"),date("i"),date("s"),date("m"), date("d"), date("Y"));
			$fecha1_form = date("Y-m-d H:i:s", $hoy);
		}
		if (!Validacion::isEmpty($fecha1_form) and !(Validacion::isDateTime($fecha1_form) || Validacion::isDate($fecha1_form) )) {
			array_push($error, "La Fecha de creaci&oacute;n tiene un formato incorrecto (YYYY-MM-DD) .");
		}
		$fecha1_form = "'" . $fecha1_form . "'";

		/** fecha2 */
		$fecha2_form			= strip_tags(trim(getVariable('fecha2_form')));
		if ($fecha2_form == "0000-00-00" || $fecha2_form == "0000-00-00 00:00:00" || $fecha2_form == "0") {
			$fecha2_form = '';
		}elseif($fecha2_form == ''){
			$caduca = mktime(date("G"),date("i"),date("s"),date("m"), date("d") + 10, date("Y"));
			$fecha2_form = date("Y-m-d H:i:s", $caduca);
		}
		if (!Validacion::isEmpty($fecha2_form) and !Validacion::isDateTime($fecha2_form)) {
			array_push($error, "La Fecha m&aacute;xima en Home tiene un formato incorrecto (YYYY-MM-DD HH:MM:SS) .");
		}
		$fecha2_form = "'" . $fecha2_form . "'";

		/** autor */
		$autor_form				= strip_tags(trim(getVariable('autor_form')));
		if (!Validacion::isEmpty($autor_form) and !Validacion::isCustom($autor_form, $pattern)) {
			array_push($error, "El Autor contiene caracteres no permitidos.");
		}
		//$autor_form				= htmlentities($autor_form, ENT_QUOTES); configuración anterior a actualización PHP
		/* Nueva validación debido a la actualización de la versión del php*/
		if(htmlentities($autor_form, ENT_QUOTES)){
                      $autor_form = htmlentities($autor_form, ENT_QUOTES);
        }

		/** antetitulo */
		$antetitulo_form		= strip_tags(trim(getVariable('antetitulo_form')));
		if (!Validacion::isEmpty($antetitulo_form) and !Validacion::isCustom($antetitulo_form, $pattern)) {
			array_push($error, "El Antetitulo contiene caracteres no permitidos.");
		}
		//$antetitulo_form		= htmlentities($antetitulo_form, ENT_QUOTES); configuración anterior a actualización PHP
		/* Nueva validación debido a la actualización de la versión del php*/
		if(htmlentities($antetitulo_form, ENT_QUOTES)){
                      $antetitulo_form = htmlentities($antetitulo_form, ENT_QUOTES);
        }
		

		/** subtitulo */
		$subtitulo_form			= strip_tags(trim(getVariable('subtitulo_form')));
		if (!Validacion::isEmpty($subtitulo_form) and !Validacion::isCustom($subtitulo_form, $pattern)) {
			array_push($error, "El Subtitulo contiene caracteres no permitidos.");
		}
		//$subtitulo_form			= htmlentities($subtitulo_form, ENT_QUOTES); configuración anterior a actualización PHP
		/* Nueva validación debido a la actualización de la versión del php*/
		if(htmlentities($subtitulo_form, ENT_QUOTES)){
                      $subtitulo_form = htmlentities($subtitulo_form, ENT_QUOTES);
        }
		
		

		/** entradilla */
		$entradilla_form		= trim(getVariable('entradilla_form'));
		if (!Validacion::isEmpty($entradilla_form) and !Validacion::isCustom($entradilla_form, $pattern)) {
			array_push($error, "El Resumen contiene caracteres no permitidos.");
		}
		$entradilla_form		= addslashes($entradilla_form); 
		


		/** Contenido */

		$activa_form			= getVariable('activa_form');
		$vinculo_form			= getVariable('vinculo_form');
		$restringida_form		= getVariable('restringida_form');
		$iddisplay_form			= getVariable('iddisplay_form');
		$iddisplay_sub_form		= getVariable('iddisplay_sub_form');
		$estado					= getVariable('estado');
		$idtemplate_form		= getVariable('idtemplate_form');
		$criterio_ordena_form	= getVariable('criterio_ordena_form');
		$tipo_ordena_form		= getVariable('tipo_ordena_form', 0);
		$Text1					= addslashes(trim(getVariable('Text1')));
		
                      
                      $pie_imagen_form		= trim(getVariable('pie_imagen_form'));

		// El uso de tinymce produce que la inclusion de un archivo contenga codigo HTML innecesario.
		if($iddisplay_form == "1" || $iddisplay_form == "3" || $iddisplay_form == "5" || $iddisplay_form == "4"|| $iddisplay_form == "10" || $iddisplay_form == "12")
		{
			$Text1 = strip_tags($Text1);
		}
		
		/* Nueva validación debido a la actualización de la versión del php*/
		if(htmlentities($Text1, ENT_QUOTES)){
                      $Text1 = htmlentities($Text1, ENT_QUOTES);
        }
		

		$numero_sub_form		= getVariable('numero_sub_form', 0);
		if (!Validacion::isEmpty($numero_sub_form) and !Validacion::isNum($numero_sub_form)) {
			array_push($error, "El N&uacute;mero de elementos de paginaci&oacute;n debe ser un n&uacute;mero.");
		}

		$orden_form				= getVariable('orden_form');
		if (!Validacion::isEmpty($orden_form) and !Validacion::isNum($orden_form)) {
			array_push($error, "El orden debe ser un n&uacute;mero.");
		}

		$esroot_form			= getVariable('esroot_form', 0);
		$enbusqueda_form		= getVariable('enbusqueda_form', 1);
		$enmapa_form			= getVariable('enmapa_form', 1);
		$idioma_form			= getVariable('idioma_form', 0);
		$rss_form				= getVariable('rss_form', 0);

		
		// Campo Justificacion de Edicion de la Categoria//
		$justificar				= getVariable('justificar');
		$validar 				= getVariable('validar');
		if($validar == 1){
			if (Validacion::isEmpty($justificar)) {
				array_push($error, "Por favor ingrese el motivo por el que esta editando esta Categoria.");
			}
		}


		if (isset($_SESSION["info_usuario"])) {
			$es_Admin = Funciones::esAdministrador($_SESSION["info_usuario"]['username'], $_SESSION["info_usuario"]['password']);
		}

		/**
		 * En esta parte se ajusta las carpetas para que cada micrositio
		 * tenga su propia carpeta y se guarde en la base de datos correctamente.
		 * Antes de todo esta variables de sesion se utilizan en el administrador
		 * de imágenes.
		 * Especificamente en los archivos: manager.php, config.inc.php que se
		 * encuentran en el directorio "funciones/image_manager/"
		 **/
		$_SESSION["admin_imagen"] = array();

		if (defined("_DIRIMAGES_MS")) {
			$_SESSION["admin_imagen"]["rel_url_dir"] = _DIRIMAGES_MS;
		} else {
			$_SESSION["admin_imagen"]["rel_url_dir"] = '';
		}

		$_SESSION["admin_imagen"]["base_dir"] = _RUTABASE._DIRIMAGES_USER;
		$_SESSION["admin_imagen"]["base_url"] =  "../../"._DIRIMAGES_USER;

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
		$smarty -> assign('idcategoria', $idcategoria);
		$smarty -> assign('c_titulo', $c_titulo);
		


		/****************************************
			PROCESO DE BORRADO DE UNA CATEGORIA
		****************************************/

		// El control, para no permitir el borrado de una categoría con subcategorías se hace al mostrar
		// los botones de borrar

		//  $validacion = (isset($_GET['validacion']))?$_GET['validacion']:'';

		if ($idborrar != '' && $validacion != ''){

			$query_sel  = sprintf("SELECT * FROM %s WHERE idcategoria=%s AND validacion='%s'", _TBLCATEGORIA, $idborrar ,$validacion);
			$result_sel = $db->Execute($query_sel) or errorQuery(__LINE__, __FILE__);

			// Borrado de la categoria
			$query_del  = sprintf("UPDATE %s SET eliminado = 1, activa = 0 WHERE idcategoria=%s AND validacion='%s'", _TBLCATEGORIA, $idborrar ,$validacion);
			$result_del = $db->Execute($query_del) or errorQuery(__LINE__, __FILE__);
			/**
			 * Registramos la Eliminacion
			 * 2 = Borrar
			 */
			Autenticacion::Registrar($idborrar, 2);

			if ($result_del && $result_sel->NumRows() == 1){
				$error[] = sprintf('Borrado exitoso de la categor&iacute;a %s',$idborrar);
				$smarty1 = new Smarty_Plantilla;
				$smarty1 -> assign('rotMensaje' , _ROT_CONFIRMACION);
				$smarty1 -> assign('tipo' , "exito");
				$smarty1 -> assign('elementoMenu', $error);
				$show = $smarty1 -> fetch('tpl_display_mensaje.html');
				$smarty -> assign('subMenuError' , $show);
			} else {
				$error[] = sprintf('No se pudo borrar la categoria %s<br>Posibles errores: La categor&iacute;a ya fu&eacute; borrada o no esta vac&iacute;a.',$idborrar);
				$smarty1 = new Smarty_Plantilla;
				$smarty1 -> assign('rotMensaje' , _ROT_ADVERTENCIA);
				$smarty1 -> assign('tipo' , "error");
				$smarty1 -> assign('elementoMenu', $error);
				$show = $smarty1 -> fetch('tpl_display_mensaje.html');
				$smarty -> assign('subMenuError' , $show);
			}
		}

		/****************************************
			PROCESO DE DUPLICACION DE UNA CATEGORIA
		****************************************/

		// El control, para no permitir el borrado de una categoría con subcategorías se hace al mostrar
		// los botones de borrar


		if ($idduplicar != '' && $validacion != '') {

			$nombre = 'Copia';

			/**
			 * @see index.php linea 37
			 * Fix: Cuando Invoca una categoria de edicion, la invoca 2 veces
			 * 		, entonces ocurre la duplicacion de la duplicacion.
			 */
			if ($_SESSION['duplicacion']['accion'] == "TRUE" and $_SESSION['duplicacion']['id'] == $idduplicar) {
				$duplica = 1;
			} else {
				$duplica = Edicion::DuplicarPrototipo($idduplicar,$idcategoria,$nombre,-1);
				$_SESSION['duplicacion']['accion'] = TRUE;
				$_SESSION['duplicacion']['id'] = $idduplicar;
			}


			if ($duplica >= 0){
				/**
				 * Registramos la Duplicacion
				 * 6 = Duplicado
				 */
				Autenticacion::Registrar($idduplicar, 6);
				$error[] = sprintf('Copia exitosa de la categor&iacute;a %s y %s subcategorias',$idduplicar,$duplica);
				$smarty1 = new Smarty_Plantilla;
				$smarty1 -> assign('rotMensaje' , _ROT_CONFIRMACION);
				$smarty1 -> assign('tipo' , "exito");
				$smarty1 -> assign('elementoMenu', $error);
				$show = $smarty1 -> fetch('tpl_display_mensaje.html');
				$smarty -> assign('subMenuError' , $show);
			} else {
				$error[] = sprintf('No se pudo duplicar la categoria %s',$idborrar);
				$smarty1 = new Smarty_Plantilla;
				$smarty1 -> assign('rotMensaje' , _ROT_ADVERTENCIA);
				$smarty1 -> assign('tipo' , "error");
				$smarty1 -> assign('elementoMenu', $error);
				$show = $smarty1 -> fetch('tpl_display_mensaje.html');
				$smarty -> assign('subMenuError' , $show);
			}

		}

		/**
			PROCESO DE ACTIVAR/DESACTIVAR DE UNA CATEGORIA
		**/
		// El control, para no permitir el borrado de una categoría con subcategorías se hace al mostrar los botones de borrar
		if ($idactivar != '' && $validacion != '' & $estado !== ''){
			$query_del  = sprintf("UPDATE %s SET activa=%s WHERE idcategoria=%s AND validacion='%s'", _TBLCATEGORIA, $estado, $idactivar, $validacion);
			$result_del = $db->Execute($query_del) or errorQuery(__LINE__, __FILE__);
			if ($result_del !== FALSE) {
				/**
				 * Registramos la Accion de activacion o desactivacion
				 * 2 = Borrar
				 */
				if ($estado == 1) { // Proceso de Activacion
					Autenticacion::Registrar($idactivar, 5);
				} elseif ($estado == 0) { // Proceso de Desactivacion
					Autenticacion::Registrar($idactivar, 4);
				}

				$accion = ($estado == 1) ? "Activada " : "Desactivada ";
				$error[] = sprintf('%s exitosamente la categor&iacute;a %s',$accion,$idactivar);
				$smarty1 = new Smarty_Plantilla;
				$smarty1 -> assign('rotMensaje' , _ROT_CONFIRMACION);
				$smarty1 -> assign('tipo' , "exito");
				$smarty1 -> assign('elementoMenu', $error);
				$show = $smarty1 -> fetch('tpl_display_mensaje.html');
				$smarty -> assign('subMenuError' , $show);
			} else {
				$accion = ($estado == 1)?"activar ":"desactivar ";
				$error[] = sprintf('No se pudo %s la categoria %s',$accion,$idactivar);
				$smarty1 = new Smarty_Plantilla;
				$smarty1 -> assign('rotMensaje' , _ROT_ADVERTENCIA);
				$smarty1 -> assign('tipo' , "error");
				$smarty1 -> assign('elementoMenu', $error);
				$show = $smarty1 -> fetch('tpl_display_mensaje.html');
				$smarty -> assign('subMenuError' , $show);
			}
		}

		/**
		 * PROCESO RENUMERAR UNA CATEGORIA
		 */
		// El control, para no permitir el borrado de una categoría con subcategorías se hace al mostrar los botones de borrar
		if ($idrenum != '' && $validacion != '') {

			$result_renum = Edicion::Renumerar($idrenum,$validacion);

			if ($result_renum) {
				$error[] = sprintf('Renumerada exitosamente la categor&iacute;a %s',$idrenum);
				$smarty1 = new Smarty_Plantilla;
				$smarty1 -> assign('rotMensaje' , _ROT_CONFIRMACION);
				$smarty1 -> assign('tipo' , "exito");
				$smarty1 -> assign('elementoMenu', $error);
				$show = $smarty1 -> fetch('tpl_display_mensaje.html');
				$smarty -> assign('subMenuError' , $show);
			} else {
				$error[] = sprintf('No se pudo renumer la categor&iacute;a %s',$idrenum);
				$smarty1 = new Smarty_Plantilla;
				$smarty1 -> assign('rotMensaje' , _ROT_ADVERTENCIA);
				$smarty1 -> assign('tipo' , "error");
				$smarty1 -> assign('elementoMenu', $error);
				$show = $smarty1 -> fetch('tpl_display_mensaje.html');
				$smarty -> assign('subMenuError' , $show);
			}
		}

		/**
		 * CONDICIONES DE ERROR
		 */
		// El único campo requerido es el nombre de la categoría, el id es automático
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
		 * PROCESO DE INSERCION Y ACTUALIZACION
		 */
		// Si hay algún error no se procesa nada y se vuelve a formulario de edición
		if (!$total_errores) {
			srand((double)microtime()*1000000);
			$validacion = md5(rand(0,9999999));

			/**
			 * PROCESO DE INSERCION
			 */
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
					case 11:
						$iddisplay_form = 16; 
					break;
				}
				$orden_sugerido = Edicion::CalcularOrden($idpadre_form);
				$query = sprintf("INSERT INTO %s ", _TBLCATEGORIA);
				if($es_Admin) {
					$query .= "(idpadre,nombre,descripcion,imagen,pie_imagen,activa,orden,iddisplay,iddisplay_sub,fecha1,fecha2,fecha3,autor,antetitulo,subtitulo,entradilla,template,validacion,orden_sub,asc_sub,paginas_sub,es_root,en_buscador,en_mapa,idioma,es_rss) VALUES ";
					$query .= sprintf("(%s,'%s','%s','%s','%s',%s,%s,%s,%s,%s,%s,'%s','%s','%s','%s','%s','%s','%s','%s','%s',%s,%s,%s ,%s,'%s',%s)",
										$idpadre_form,
										$nombre_form,
										($iddisplay_form == 12) ? 0 : $Text1,
										$imagen_form,
										$pie_imagen_form,
										$activa_form,
										($orden_form == '')?$orden_sugerido:$orden_form,
										$iddisplay_form,
										$iddisplay_sub_form,
										$fecha1_form,
										$fecha2_form,
										date("Y-m-d H:i:s"),
										$autor_form,
										$antetitulo_form,
										$subtitulo_form,
										$entradilla_form,
										$idtemplate_form,
										$validacion,
										$criterio_ordena_form,
										$tipo_ordena_form,
										empty($numero_sub_form) ? 0 : $numero_sub_form,
										$esroot_form,
										$enbusqueda_form,
										$enmapa_form,
										$idioma_form,
										$rss_form
									);

				} else {
					
					$query .= "(idpadre,nombre,descripcion,imagen,pie_imagen,activa,orden,fecha1,fecha2,fecha3,autor,antetitulo,subtitulo,entradilla,validacion,iddisplay,iddisplay_sub,orden_sub,asc_sub) values ";
					$query .= sprintf("(%s,'%s','%s','%s','%s',%s,%s,%s,%s,'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
										$idpadre_form,
										$nombre_form,
										($iddisplay_form == 12) ? 0 : $Text1,
										$imagen_form,
										$pie_imagen_form,
										$activa_form,
										($orden_form == '') ? $orden_sugerido : $orden_form,
										$fecha1_form,
										$fecha2_form,
										date("Y-m-d H:i:s"),
										$autor_form,
										$antetitulo_form,
										$subtitulo_form,
										$entradilla_form,
										$validacion,
										empty($iddisplay_form) ? 0 : $iddisplay_form,
										$iddisplay_sub_form,
										$criterio_ordena_form,
										$tipo_ordena_form
									);
				}
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
				 * Guardamos el id de la Sección a la que pertenece la categoria
				 */
				$idbusqueda = Funciones::BuscarRoot($ultimoid);
				//El idbusqueda lo dejamos en 1 para que desde todo el portal sea
				//accesible por el motor de busqueda los subportales y su informacion
				//$idbusqueda = 1;
				$qb2 = sprintf("UPDATE %s SET idbusqueda = '%s' WHERE idcategoria = '%s'", _TBLCATEGORIA, $idbusqueda, $ultimoid);
				$rb2 = $db->Execute($qb2) or errorQuery(__LINE__, __FILE__);

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
					$this->indexarContenido($ultimoid, $nombre_form." ".$autor_form." ".$antetitulo_form." ".$subtitulo_form." ".$entradilla_form." ".$Text1);
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
				$GLOBALS['idcategoria']	= $idpadre_form;
				$idpadre_form			= "";
				$GLOBALS['idpadre_form']= "";

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

					$error[] = sprintf('Creaci&oacute;n exitosa de la categor&iacute;a %s -> %s',$maximo,$nombre_form);
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
				$query .= sprintf("SET nombre='%s', descripcion='%s', imagen='%s',pie_imagen='%s', activa=%s, orden=%s, ",
									$nombre_form,
									($iddisplay_form == 12)?trim($Text1):$Text1,
									$imagen_form,
									$pie_imagen_form,
									$activa_form,
									$orden_form
								);

				if($es_Admin) {

					$arrayActualizacion = array ("nombre" => $nombre_form
												,"descripcion" => $Text1
												,"imagen" => $imagen_form
												,"pie_imagen" => $pie_imagen_form
												,"activa" => $activa_form
												,"orden" => $orden_form

												,"iddisplay" => $iddisplay_form
												,"iddisplay_sub" => $iddisplay_sub_form
												,"fecha1" => $fecha1_form
												,"fecha2" => $fecha2_form
												,"autor" => $autor_form
												,"antetitulo" => $antetitulo_form
												,"subtitulo" => $subtitulo_form
												,"entradilla" => $entradilla_form
												,"orden_sub" => $criterio_ordena_form
												,"asc_sub" => $tipo_ordena_form
												,"paginas_sub" => $numero_sub_form
												,"template" => $idtemplate_form
												,"es_root" => $esroot_form
												,"idioma" => $idioma_form
												,"en_buscador" => $enbusqueda_form
												,"en_mapa" => $enmapa_form
												);

	
					$query .= sprintf("iddisplay=%s, iddisplay_sub=%s, fecha1='%s', fecha2='%s', fecha3='%s', autor='%s', antetitulo='%s', subtitulo='%s', entradilla='%s', template='%s', validacion='%s', orden_sub='%s', asc_sub=%s, paginas_sub=%s, es_root=%s, en_buscador=%s, en_mapa=%s, idioma='%s', es_rss='%s' ",
										$iddisplay_form,
										$iddisplay_sub_form,
										($fecha1_form = "0000-00-00 00:00:00") ? date("Y-m-d H:i:s") : $fecha1_form ,
										($fecha2_form = "0000-00-00 00:00:00") ? date("Y-m-d H:i:s") : $fecha2_form ,
										date("Y-m-d H:i:s"),
										$autor_form,
										$antetitulo_form,
										$subtitulo_form,
										$entradilla_form,
										$idtemplate_form,
										$validacion,
										$criterio_ordena_form,
										$tipo_ordena_form,
										empty($numero_sub_form) ? 0 : $numero_sub_form,
										$esroot_form,
										$enbusqueda_form,
										$enmapa_form,
										$idioma_form,
										$rss_form
									);
					// Actualizacion de los accesos
					$query0  = sprintf("DELETE FROM %s WHERE idcategoria = %s",_TBLACCESO, $idcategoria);
					$result0  = $db->Execute($query0) or errorQuery(__LINE__, __FILE__);

					if(is_array($restringida_form) && count($restringida_form) > 0){
						for($i = 0 ; $i < count($restringida_form) ; $i++){
							$query1   = sprintf("INSERT INTO %s ", _TBLACCESO);
							$query1  .= sprintf("(idcategoria,idlista) VALUES ");
							$query1  .= sprintf("(%s,%s)",$idcategoria,$restringida_form[$i]);
							$result1  = $db->Execute($query1) or errorQuery(__LINE__, __FILE__);
						}
					}
				} else {
					$arrayActualizacion = array ("nombre" => $nombre_form
												,"descripcion" => $Text1
												,"imagen" => $imagen_form
												,"pie_imagen" => $pie_imagen_form
												,"activa" => $activa_form
												,"orden" => $orden_form
												,"fecha1" => $fecha1_form
												,"fecha2" => $fecha2_form
												,"autor" => $autor_form
												,"antetitulo" => $antetitulo_form
												,"subtitulo" => $subtitulo_form
												,"entradilla" => $entradilla_form
												,"idcategoria" => $idcategoria
												,"idpadre" => $idpadre_form
												,"orden_sub" => $criterio_ordena_form
												,"asc_sub" => $tipo_ordena_form
												,"paginas_sub" => $numero_sub_form
												,"iddisplay" => $iddisplay_form
												,"iddisplay_sub" => $iddisplay_sub_form
												,"template" => $idtemplate_form
												,"es_root" => $esroot_form
												,"idioma" => $idioma_form
												);

					$query .= sprintf("fecha1=%s, fecha2=%s, fecha3='%s', autor='%s', antetitulo='%s', subtitulo='%s', entradilla='%s', validacion='%s', iddisplay='%s' ,iddisplay_sub='%s', orden_sub='%s', asc_sub='%s'",
										$fecha1_form,
										$fecha2_form,
										date("Y-m-d H:i:s"),
										$autor_form,
										$antetitulo_form,
										$subtitulo_form,
										$entradilla_form,
										$validacion,
										$iddisplay_form,
										$iddisplay_sub_form,
										$criterio_ordena_form,
										$tipo_ordena_form
										
									);
				}
				$query .= sprintf(" WHERE idcategoria=%s", $idcategoria);
				$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);

				// Si es root guardamos las variables del nuevo sitio con las variables del viejo root
				if ($esroot_form == 1 and empty($trazaCategoria[$idcategoria]['varsubsitio'])) {
					global $sroot; /** @see variables.php */
					/**
					 * Copiando las variables de entorno del root padre mas cercano
					 */
					$qsubsitio = sprintf("UPDATE %s SET varsubsitio = '%s' WHERE idcategoria = %s", _TBLCATEGORIA, $trazaCategoria[$sroot]['varsubsitio'], $idcategoria);
					$rsubsitio = $db->Execute($qsubsitio) or errorQuery(__LINE__, __FILE__);
				}

				/**
				 * Guardamos el id de la Sección a la que pertenece la categoria
				 */
				$idbusqueda = Funciones::BuscarRoot($idcategoria);
				//El idbusqueda lo dejamos en 1 para que desde todo el portal sea
				//accesible por el motor de busqueda los subportales y su informacion
				//$idbusqueda = 1;
				$qb2 = sprintf("UPDATE %s SET idbusqueda = '%s' WHERE idcategoria = '%s'", _TBLCATEGORIA, $idbusqueda, $idcategoria);
				$rb2 = $db->Execute($qb2) or errorQuery(__LINE__, __FILE__);

				/**
				 * Registramos la Actualizacion
				 * 1 = Actualizacion
				 */
				
				Autenticacion::Registrar($idcategoria, 1, addslashes(Edicion::checkCambio($arrayPreActualizacion, $arrayActualizacion)),$justificar);
				/**
				 * Miramos si indexamos o no la categoria
				 * $enbusqueda_form : 1 = Si | 0 = No
				 */
				if ($enbusqueda_form == 1) {
					/**
					 * Indexamos la categoria
					 **/
					$this->indexarContenido($idcategoria, $nombre_form." ".$autor_form." ".$antetitulo_form." ".$subtitulo_form." ".$entradilla_form." ".$Text1);
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

					$error[] = sprintf('Actualizaci&oacute;n exitosa de la categor&iacute;a %s<br><i>%s</i>',$idcategoria,$nombre_form);
					$smarty1 = new Smarty_Plantilla;
					$smarty1 -> assign('rotMensaje' , _ROT_CONFIRMACION);
					$smarty1 -> assign('tipo' , "exito");
					$smarty1 -> assign('elementoMenu', $error);
					$show = $smarty1 -> fetch('tpl_display_mensaje.html');
					$smarty -> assign('subMenuError' , $show);
				}
			}
		}

		if(!$idpadre_form){
			/**
			 * Cargamos la informacion del idcategoria actual
			 * y se carga de nuevo para reflejar el cambio en una insercion o actualizacion
			 */
			$q = sprintf("SELECT * FROM %s WHERE idcategoria = '%s'", _TBLCATEGORIA, $idcategoria);
			$r = $db->Execute($q) or errorQuery(__LINE__, __FILE__);
			$row = $r->fields;

			$nombre_form		= $row["nombre"];
			$Text1				= trim($row["descripcion"]);
			$imagen_form		= $row["imagen"];
			$pie_imagen_form	= $row["pie_imagen"];
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
			$idtemplate_form	= $row["template"];
			$criterio_ordena_form  = $row["orden_sub"];
			$tipo_ordena_form	= $row["asc_sub"];
			$numero_sub_form	= $row["paginas_sub"];
			$esroot_form		= $row["es_root"];
			$enbusqueda_form	= $row["en_buscador"];
			$enmapa_form		= $row["en_mapa"];
			$idioma_form		= $row["idioma"];
			$rss_form			= $row["es_rss"];

			$q2 = sprintf("SELECT * FROM %s WHERE username = '%s'", _TBLUSUARIO, $_SESSION['info_usuario']['username']);
			$r2 = $db->Execute($q2) or errorQuery(__LINE__, __FILE__);
			
			
			if ($r2 !== FALSE and $r2->NumRows() > 0) {
				$infoUsuario = $r2->fields;	
				$validar_edicion = $infoUsuario['confirmar_edicion'];
			}
			

			if ($fecha3_form == "" or $fecha3_form == "0000-00-00" or $fecha3_form == "null"){
				$fecha3_form = "0000-00-00";
			}else{
				$fecha3_form = $fecha3_form;
			}

			$validacion = $row["validacion"];

			$c_submenu = trim($this->DisplaySubMenuEdicion($idcategoria, 2));
			$smarty -> assign('c_submenu', $c_submenu);
		} else {
			$activa_form = 1;
			$restringida_form = 0;
			$validacion = "";
			$c_submenu = "";
		}

		$smarty -> assign('c_action' , $pagina);
		$smarty -> assign('c_formulario_titulo', _ROT_EDICION);

		/**
		  NAVEGACION Y UTILIDADES EN MODO EDICION
		 **/
		$inf = (isset($_GET['inf']) && $_GET['inf'] > 0)?$_GET['inf']: 0;
		$inf = (isset($_POST['inf']) && $_POST['inf'] > 0)?$_POST['inf']: $inf;
		$variables = array(
							"idcategoria"  => $idcategoria,
							"idpadre_form" => $idpadre_form,
							"c_submenu"	=> $c_submenu,
							"validacion"   => $validacion,
							"inf"		  => $inf,
							"es_Admin"	 => $es_Admin,
							"contratacion" => 0
							);
		$smarty = $this->menuNavegacion($variables,$smarty);

		$campo['nombre'] = _ROT_EDICION_NOMBRE;
		$campo['clase'] = "requerido";
		$campo['input'] = sprintf("<input type=text name=nombre_form size=60 value='%s' class='edicion_input_requerido form-control'>", $nombre_form);
		$campos[] = $campo;

		$campo['nombre'] = utf8_decode(_ROT_EDICION_ANTETITULO);
		$campo['clase'] = "";
		$campo['input'] = sprintf("<input type=text name=antetitulo_form size=60 value='%s' class='edicion_input form-control'>", $antetitulo_form);
		$campos[] = $campo;

		$campo['nombre'] = utf8_decode(_ROT_EDICION_SUBTITULO);
		$campo['clase'] = "";
		$campo['input'] = sprintf("<input type=text name=subtitulo_form size=60 value='%s' class='edicion_input form-control'>", $subtitulo_form);
		$campos[] = $campo;

		$campo['nombre'] = _ROT_EDICION_RESUMEN;
		$campo['clase'] = "";
		$comilla = "'";
		$campo['input'] = sprintf("<textarea name=entradilla_form id='entradilla_form' rows=10 cols=60 class='edicion_input form-control'>%s</textarea> <INPUT TYPE='button' VALUE='...' onClick=validar_caracteres(".$comilla."entradilla_form".$comilla.");>",stripslashes($entradilla_form));
		$campos[] = $campo;


		$campo['nombre'] = _ROT_EDICION_CONTENIDO;
		$campo['clase'] = "";


		if (_MOSTRAR_EDITOR === TRUE) {

			$_SESSION['wfa_id'] = $idcategoria;
			$campo['input'] = sprintf(  "<textarea name=Text1 id=Text1 rows=15 cols=60 class='edicion_input form-control'>%s</textarea><INPUT TYPE='button' VALUE='...' onClick=validar_caracteres(".$comilla."Text1".$comilla.");><br>" .
										"<a class=normal style=\"cursor:pointer;\" onclick=\"var wfa = window.open('tools/arcmic.php', 'wfa', 'width=800,height=600,scrollbars=yes,resizable=yes');wfa.focus();text = toogleEditorMode(false);\" title=\"Seleccionar un archivo\"><img src=\"%s/admin_archivos.gif\" style=\"vertical-align:middle;\" border=0 alt=\"Seleccionar un archivo\"></a>&nbsp;&nbsp;Administrador de Archivos"
									, stripslashes($Text1)
									, _DIR_IMAGES_EDITOR
									);
		} else {

			$campo['input'] = sprintf("<textarea name=Text1 id=Text1 rows=15 cols=60>%s</textarea>", stripslashes($Text1));
                                                                                   
		}

		$campos[] = $campo;

		$campo['nombre'] = _ROT_EDICION_AUTOR;
		$campo['clase'] = "";
		$campo['input'] = sprintf("<input type=text name=autor_form size=60 value='%s' class='edicion_input form-control'>", $autor_form);
		$campos[] = $campo;

		$fotos = sprintf("<a href=fotos.php class=normal target=_blanck><img src=%s/boton_subir.gif border=0 alt=\"\"></a>", _DIR_IMAGES_EDITOR);

		/**
		 * Prueba de carga de imagen thumbnail en tiempo real
		 */
		$campo['nombre'] = _ROT_EDICION_IMAGEN;
		$campo['clase'] = "";
		$campo['input'] = "
			<img src=\"\" alt=\"\" id=\"imgth\" style=\"display:block;border:1px solid #3366AA\">
			<input type=\"text\" id=\"imagen_form\" class=\"edicion_input_select form-control\" size=\"52\" onkeyup=\"cargarImagen(this.value);\" name=\"imagen_form\" value=\"".$imagen_form."\"/>
			&nbsp;<a style=\"cursor:pointer;\"><img src=\""._DIR_IMAGES_EDITOR."/admin_imagenes.gif\" border=\"0\" onclick=\"ImageSelector.select('imagen_form');\" alt=\"\" align=\"absmiddle\"></a>
			<script language=\"Javascript\" type=\"text/javascript\">cargarImagen('".$imagen_form."');</script>
			";
		$campos[] = $campo;

		$campo['nombre'] = "Pie de Imagen";
		$campo['clase'] = "";
		$campo['input'] = sprintf("<input type=text name=pie_imagen_form size=60 value='%s' class='edicion_input form-control'>", $pie_imagen_form);
		$campos[] = $campo;

		$campo['nombre'] = _ROT_EDICION_ACTIVA;
		$campo['clase'] = "";
		$campo['input'] = sprintf("<select name=activa_form class='edicion_input form-control'><option value=1 %s>Si</option><option value=0 %s>No</option></select>" , ($activa_form == 1)?"selected":"" , ($activa_form == 0)?"selected":"");
		$campos[] = $campo;

		$campo['nombre'] = _ROT_EDICION_ORDEN;
		$campo['clase'] = "";
		$campo['input'] = sprintf("<input type=text name=orden_form size=5 value='%s' class='edicion_input form-control'>", $orden_form);
		$campos[] = $campo;

		$campo['nombre'] = utf8_decode(_ROT_EDICION_FECHA1);
		$campo['clase'] = "";
		$campo['input'] = sprintf("<input type=text name=fecha1_form id=fecha1_form size=55 value='%s' class='edicion_input form-control'>", $fecha1_form);
		$campo['input'] .= "&nbsp;<button type=\"reset\" id=\"f_trigger_a\" style=\"border:1px solid;font:0.8em\">...</button>
							<script type=\"text/javascript\">
							    Calendar.setup({
							        inputField     :    \"fecha1_form\", // id of the input field
							        ifFormat       :    \"%Y-%m-%d\",    // format of the input field
							        showsTime      :    true,            // will display a time selector
							        button         :    \"f_trigger_a\", // trigger for the calendar (button ID)
							        singleClick    :    false,           // double-click mode
							        step           :    1                // show all years in drop-down boxes (instead of every other year as default)
							    });
							</script>";
		$campos[] = $campo;


		$campo['nombre'] = utf8_decode(_ROT_EDICION_FECHA2);
		$campo['clase'] = "";
		$campo['input'] = sprintf("<input type=text name=fecha2_form id=fecha2_form size=55 value='%s' class='edicion_input form-control'>", $fecha2_form);
		$campo['input'] .= "&nbsp;<button type=\"reset\" id=\"f_trigger_b\" style=\"border:1px solid;font:0.8em\">...</button>
							<script type=\"text/javascript\">
							    Calendar.setup({
							        inputField     :    \"fecha2_form\",      	// id of the input field
							        ifFormat       :    \"%Y-%m-%d %H:%M:%S\",  // format of the input field
							        showsTime      :    true,            		// will display a time selector
							        button         :    \"f_trigger_b\",   		// trigger for the calendar (button ID)
							        singleClick    :    false,           		// double-click mode
							        step           :    1                		// show all years in drop-down boxes (instead of every other year as default)
							    });
							</script>";
		$campos[] = $campo;

		if($es_Admin) {

			$campo['nombre'] = _ROT_EDICION_RESTRINGIDA;
			$campo['clase'] = "";
			$campo['input'] = FuncionesInterfaz::CrearCheckRestringida($idcategoria, $idpadre_form);
			//  $campo['input'] = sprintf("<select name=restringida_form class='edicion_input_select'><option value=0 %s>Pública</option><option value=1 %s>Visitantes Registrados</option><option value=2 %s>Personal de la %s</option></select>" , ($restringida_form == 0)?"selected":"" , ($restringida_form == 1)?"selected":"" , ($restringida_form == 2)?"selected":"" , _NOMBRESITIO);
			$campos[] = $campo;
		}//se permite ver el tipo principal y el tipo de las subcategorias y tambien los ornamientos
			$campo['nombre'] = _ROT_EDICION_TIPOSECCION;
			$campo['clase'] = "";
			$campo['input'] = FuncionesInterfaz::CrearSelect($iddisplay_form);
			$campos[] = $campo;
		
			$campo['nombre'] = utf8_decode(_ROT_EDICION_TIPOSECCION_SUB);
			$campo['clase'] = "";
			$campo['input'] = FuncionesInterfaz::CrearSelect_sub($iddisplay_sub_form);
			$campos[] = $campo;

			$campo['nombre'] = utf8_decode(_ROT_EDICION_CRITERIO_ORDENA);
			$campo['clase'] = "";
			$campo['input'] = FuncionesInterfaz::CrearSelectCriterio($criterio_ordena_form);
			$campos[] = $campo;

			$campo['nombre'] = utf8_decode(_ROT_EDICION_TIPO_ORDENA);
			$campo['clase'] = "";
			$campo['input'] = FuncionesInterfaz::CrearSelectTipo($tipo_ordena_form);
			$campos[] = $campo;
		if($es_Admin) {

			$campo['nombre'] = utf8_decode(_ROT_EDICION_NUMERO_SUB);
			$campo['clase'] = "";
			$campo['input'] =  sprintf("<input type=text name=numero_sub_form size=5 value='%s' class='edicion_input form-control'> <span class=tpl_migas>(%s)</span>", $numero_sub_form,_ROT_EDICION_NUMERO_SUB_INFO);
			$campos[] = $campo;

			$campo['nombre'] = _ROT_EDICION_ESROOT;
			$campo['clase'] = "";
			$campo['input'] =  sprintf("<select name=\"esroot_form\" class=\"edicion_input form-control\"><option value=\"0\">No</option><option value=\"1\">Si</option></select><script language=\"Javascript\" type=\"text/javascript\">document.wEditor.esroot_form.value='%s'</script>", $esroot_form);
			$campos[] = $campo;

			$campo['nombre'] = utf8_decode(_ROT_EDICION_PLANTILLA);
			$campo['clase'] = "";
			$campo['input'] = FuncionesInterfaz::SelectTemplates($idtemplate_form);  //CrearSelect($iddisplay_form);
			$campos[] = $campo;

			$campo['nombre'] = _ROT_EDICION_ENBUSQUEDA;
			$campo['clase'] = "";
			$campo['input'] =  sprintf("<select name=\"enbusqueda_form\" class=\"edicion_input form-control\"><option value=\"1\">Si</option><option value=\"0\">No</option></select><script language=\"Javascript\" type=\"text/javascript\">document.wEditor.enbusqueda_form.value='%s'</script>", $enbusqueda_form);
			$campos[] = $campo;

			$campo['nombre'] = _ROT_EDICION_ENMAPA;
			$campo['clase'] = "";
			$campo['input'] =  sprintf("<select name=\"enmapa_form\" class=\"edicion_input form-control\"><option value=\"1\">Normal</option><option value=\"2\">No Mostrar Hijos</option><option value=\"3\">No Mostrar</option></select><script language=\"Javascript\" type=\"text/javascript\">document.wEditor.enmapa_form.value='%s'</script>", $enmapa_form);
			$campos[] = $campo;

			$campo['nombre'] = _ROT_EDICION_IDIOMA;
			$campo['clase'] = "";
			$campo['input'] =  sprintf("<select name=\"idioma_form\" class=\"edicion_input form-control\"><option value=\"0\">-- Heredar --</option><option value=\"aleman\">Aleman</option><option value=\"spanish\">Spanish</option><option value=\"english\">English</option><option value=\"portugues\">Portugues</option></select><script language=\"Javascript\" type=\"text/javascript\">document.wEditor.idioma_form.value='%s'</script>", $idioma_form);
			$campos[] = $campo;

			$campo['nombre'] = _ROT_EDICION_ESRSS;
			$campo['clase'] = "";
			$campo['input'] =  sprintf("<input type=\"checkbox\" name=\"rss_form\" value=\"1\" %s>", ($rss_form == 1) ? "checked" : "");
			$campos[] = $campo;
		}
			//Campo Validacion de Ventana Modal de Edicion
			if($validar_edicion == 1){
				$campo['nombre']= "Escriba el por qu&eacute; esta modificando la categoria";
				$campo['clase']= "requerido";
				$campo['input']= sprintf("<textarea name='justificar' id='justificar' rows=10 cols=60 class='edicion_input_requerido form-control'>%s</textarea> <INPUT TYPE='button' VALUE='...' onClick=validar_caracteres(".$comilla."justificar".$comilla.");><textarea name='validar' id='validar' class='hidden'>%s</textarea>",stripslashes($justificar),$validar_edicion);
				$campos[] = $campo;
			}
			if($es_Admin) {
			// Verificamos que se encuentre en el dominio del ejercito, de lo contrario no se muestra la opción.
			
			if(_URL=="http://www.ejercito.mil.co/"){
		
			$campo['nombre'] = "Conectarme a Facebook:";
			$campo['clase']  = "";
			$campo['input']  = "<div id=\"conectar_facebook\" style=\"background-position:center\"> <a href=\"#\" onclick=\"login(); return false;\">Contectarse a Facebook</a> </div>"; 
			$campos[] = $campo;
        
		
		    $campo['nombre'] =  "Publicar en muro:";
			$campo['clase']  = "";
			$campo['input']  = "<p><a onclick=\"publish(); return false;\" href=\"#\">Publicar en el muro</a></p>";
			$campos[] = $campo;
		
			$campo['nombre'] = "";
			$campo['clase']  = "";
			$campo['input']  = sprintf("<input type=hidden id=link name=link value='%s' />",$idcategoria);
			$campos[] = $campo; 
			}
			else{
			
			}
         
		} 
		/*else {
			$campo['nombre'] = "";
			$campo['clase'] = "";
			$campo['input'] = sprintf("<input type=hidden value='%s' name=iddisplay_form>", $iddisplay_form);
			$campos[] = $campo;

		}*/

		if ($idpadre_form) {
			$campo['nombre'] = "";
			$campo['clase'] = "";
			$campo['input'] = sprintf("<input type=hidden value='%s' name=idpadre_form>", $idpadre_form);
			$campos[] = $campo;
		}

		if ($inf) {
			$campo['nombre'] = "";
			$campo['clase'] = "";
			$campo['input'] = sprintf("<input type=hidden value='%s' name=inf>", $inf);
			$campos[] = $campo;
		}

		$campo['nombre'] = "";
		$campo['clase'] = "";
		$campo['input'] = sprintf("<input type=hidden value='%s' name=idcategoria>", $idcategoria);
		$campos[] = $campo;
		$smarty -> assign('campos', $campos);
		$smarty -> assign('iddisplay_form', $iddisplay_form); // Para cargar el HTML WYSIWYG

		$c_version = _VERSION;
		$smarty -> assign('c_version', $c_version);
		$smarty -> assign('image_language', _IMAGE_ADMIN_LANGUAGE);
		
		$smarty -> assign('idcategoria', $idcategoria);
		$smarty -> assign('idpadre_form', $idpadre_form);
		$smarty->assign('administrador', Funciones::esAdministrador(
											$_SESSION["info_usuario"]["username"], $_SESSION["info_usuario"]["password"]));			
		
		return $smarty -> fetch('tpl_edicion_full.html');
	}
	/**
	 * Edicion :: envioCorreoAdministrador
	 * Envia el correo de la creacion o modificacion de una categoria al administrador del sistema
	 * @param $accion
	 * @param $idcategoria
	 * @param $tituloCategoria
	 * @return
	 */
	function envioCorreoAdministrador($accion, $idcategoria, $tituloCategoria) {

		global $db;	/** @see variables.php */

		$mensaje = "";
		$accionValida = FALSE;
		$infoUsuario = array();

		$q1 = sprintf("SELECT * FROM %s WHERE username = '%s'", _TBLUSUARIO, $_SESSION['info_usuario']['username']);
		$r1 = $db->Execute() or errorQuery(__LINE__, __FILE__);

		if ($r1 !== FALSE and $r1->NumRows() > 0) {
			$infoUsuario = $r1->fields;
		}

		switch ($accion) {
			case 'INSERTAR':
				$mensaje =  "Inserci&oacute;n de la categoria ".$idcategoria."\n\n"
							."Accion Realizada por ".$infoUsuario["nombres"]." ".$infoUsuario["apellidos"]." (".$infoUsuario["email"].")\n\n"
							."La p&aacute;gina generada es : \"".strip_tags($tituloCategoria)."\"\n"._URL."/?idcategoria=".$idcategoria
							."\nPara modificarla haga click en la siguiente direccion:\n"._URL."/index.php?e&idcategoria=".$idcategoria;
				$accionValida = TRUE;
				break;
			case 'MODIFICAR':
				$mensaje = 	"Modificaci&oacute;n de la categoria ".$idcategoria ."\n\n"
							."Accion Realizada por ".$infoUsuario["nombres"]." ".$infoUsuario["apellidos"]." (".$infoUsuario["email"].")\n\n"
							."La p&aacute;gina modificada es:\"".strip_tags($tituloCategoria)."\"\n"._URL."/?idcategoria=".$idcategoria
							."\nPara modificarla haga click en la siguiente direccion:\n"._URL."/index.php?e&idcategoria=".$idcategoria;
				$accionValida = TRUE;
				break;
		}

		if ($accionValida === TRUE) {
			microsmail(_EMAIL_ADMINISTRADOR, "Cambio en la P&aacute;gina "._NOMBRESITIO, $mensaje, "From: ".$infoUsuario["email"], 'index.php','1');
			microsmail("auditoriaweb@micrositios.net", "Cambio en la P&aacute;gina "._NOMBRESITIO, $mensaje, "From: ".$infoUsuario["email"], 'index.php','1');
		}
	}
	/**
	 * Edicion :: menuNavegacion
	 * @param $variables
	 * @param $smarty
	 * @return
	 */
	function menuNavegacion($variables,$smarty){

		$idcategoria  = $variables["idcategoria"];
		$idpadre_form = $variables["idpadre_form"];
		$c_submenu	= $variables["c_submenu"];
		$validacion   = $variables["validacion"];
		$inf		  = $variables["inf"];
		$es_Admin	 = $variables["es_Admin"];
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

		/* RENUMERAR */
		if(isset($c_submenu) && trim($c_submenu) != '' && $idcategoria != _SCONTRATACION && $auth_categoria >= 3){
			$renumerar_temp = "boton_renum_on.gif";
		}else if(isset($c_submenu) && trim($c_submenu) != '' && $idcategoria != _SCONTRATACION && $auth_categoria < 3){
			$renumerar_temp = "boton_renum_non.gif";
		}else if(((!isset($c_submenu) || trim($c_submenu) == '') || $idcategoria == _SCONTRATACION) && $auth_categoria >= 3){
			$renumerar_temp = "boton_renum_off.gif";
		}else{
			$renumerar_temp = "boton_renum_noff.gif";
		}
		$renumerar		= (isset($c_submenu) && trim($c_submenu) != '')?sprintf("<a href=index.php?e&amp;idcategoria=%s&amp;idrenum=%s&amp;validacion=%s&amp;inf=%s>%s</a>", $idcategoria, $idcategoria,$validacion,$inf,sprintf("<img src=%s%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$renumerar_temp)):sprintf("<img src=%s%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$renumerar_temp);


		/* RELOAD */
		$reload_tem1	  = (!$idpadre_form)?"boton_reload_on.gif":"boton_reload_off.gif";
		$reload		   = (!$idpadre_form)?sprintf("<a href=index.php?e&amp;idcategoria=%s&amp;inf=%s>%s</a>", $idcategoria,$inf,sprintf("<img src=%s/%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$reload_tem1)):sprintf("<img src=%s%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$reload_tem1);

		/* NUEVA */
		if((!$idpadre_form && $contratacion!=1) && $idcategoria!=_SCONTRATACION && $auth_categoria>=1) {
			$insertar_tem1 = "boton_nuevo_on.gif";
		} else if((!$idpadre_form && $contratacion!=1) && $idcategoria!=_SCONTRATACION && $auth_categoria<1) {
			$insertar_tem1 = "boton_nuevo_non.gif";
		} else if((($idpadre_form || $contratacion==1) || $idcategoria==_SCONTRATACION) && $auth_categoria>=1) {
			$insertar_tem1 = "boton_nuevo_off.gif";
		} else {
			$insertar_tem1 = "boton_nuevo_noff.gif";
		}
		$insertar		 = (!$idpadre_form && $contratacion!=1)?sprintf("<a href=index.php?e&amp;idcategoria=%s&amp;idpadre_form=%s>%s</a>",$idcategoria,$idcategoria,sprintf("<img src=%s/%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$insertar_tem1)):sprintf("<img src=%s/%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$insertar_tem1);

		/* VER */
		$volver  = sprintf("<a href=index.php?ne&amp;idcategoria=%s&amp;inf=%s>%s</a>", $idcategoria, $inf, sprintf("<img src=%s/boton_modo_normal.gif border=0 alt=\"\">",_DIR_IMAGES_EDITOR));

		/* TERMINAR */
		$terminar = sprintf("<a href=index.php?idcategoria=1&amp;logout=1>%s</a>", sprintf("<img src=%s/boton_terminar.gif border=0 alt=\"\">",_DIR_IMAGES_EDITOR));



		$ancho = 53;
		$boton_salvar = "<table border=0 align=center summary=''><tr>";
		$boton_salvar .= sprintf("<td align=center width=%s>%s</td>",$ancho,$anterior);
		$boton_salvar .= sprintf("<td align=center width=%s>%s</td>",$ancho,$padre);
		$boton_salvar .= sprintf("<td align=center width=%s>%s</td>",$ancho,$siguiente);
		$boton_salvar .= sprintf("<td align=center width=%s>%s</td>",$ancho,$renumerar);

		/* SALVAR */
		$boton_salvar .= ($auth_categoria>=3 || $idpadre_form)?sprintf("<td align=center width=%s><input type=image src=%sboton_salvar.gif></td>",$ancho,_DIR_IMAGES_EDITOR):sprintf("<td align=center width=%s><img src=%sboton_salvar_n.gif alt=\"\"></td>",$ancho,_DIR_IMAGES_EDITOR);

		$boton_salvar .= sprintf("<td align=center width=%s>%s</td>",$ancho,$reload);
		$boton_salvar .= sprintf("<td align=center width=%s>%s</td>",$ancho,$insertar);
		$boton_salvar .= sprintf("<td align=center width=%s>%s</td>",$ancho,$volver);
		$boton_salvar .= sprintf("<td align=center width=%s>%s</td>",$ancho,$terminar);

		$boton_salvar .= "</tr><tr>";

		$boton_salvar .= "<td align=center class=edicion_elemento valign=top>Anterior</td>";
		$boton_salvar .= sprintf("<td align=center class=edicion_elemento valign=top>%s</td>",$padre_tem2);
		$boton_salvar .= "<td align=center class=edicion_elemento valign=top>Siguiente</td>";
		$boton_salvar .= "<td align=center class=edicion_elemento valign=top>Renum</td>";
		$boton_salvar .= "<td align=center class=edicion_elemento valign=top>Salvar</td>";
		$boton_salvar .= "<td align=center class=edicion_elemento valign=top>Reload</td>";
		$boton_salvar .= "<td align=center class=edicion_elemento valign=top>Nueva</td>";
		$boton_salvar .= "<td align=center class=edicion_elemento valign=top>Ver</td>";
		$boton_salvar .= "<td align=center class=edicion_elemento valign=top>Terminar</td>";
		$boton_salvar .= "</tr>";
		$boton_salvar .= "</table>";

		$smarty -> assign('c_salvar',$boton_salvar);

		/* PREVIEW */
		$preview_temp   = "boton_preview.gif";
		$preview		= ($es_Admin)?sprintf("<a onclick='preview(\""._URL."\",".$idcategoria.",\"admin\");'>%s</a>",sprintf("<img src=%s/%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$preview_temp)):sprintf("<a onclick='preview(\""._URL."\",".$idcategoria.",\"editor\");'>%s</a>",sprintf("<img src=%s/%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$preview_temp));

		/* MICROS */
		$micros_temp   = "boton_micros.gif";
		$micros		= sprintf("<a href='http://www.micrositios.net' target=_blank>%s</a>",sprintf("<img src=%s/%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$micros_temp));

		/* INFO */
		$info_temp	 = "boton_info.gif";
		$info		  = sprintf("<a href='http://www.micrositios.net' target=_blank>%s</a>",sprintf("<img src=%s/%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$info_temp));

		/* ADMINISTRAR */
		$info_admin	= ($es_Admin)?"boton_admin_on.gif":"boton_admin_off.gif";
		$admin		 = ($es_Admin)?sprintf("<a href='?idcategoria=%s&ne' target='_blank'>%s</a>", _SADMIN, sprintf("<img src=%s/%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$info_admin)):sprintf("<img src=%s/%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$info_admin);

		$ancho = 53;
		$boton_micrositios = "<table border=0 align=center summary=''><tr>";

		$boton_micrositios .= sprintf("<td align=center width=%s>%s</td>",$ancho,$preview);
		$boton_micrositios .= sprintf("<td align=center width=%s>%s</td>",$ancho,$admin);
		$boton_micrositios .= sprintf("<td align=center width=%s>%s</td>",$ancho,$info);
		$boton_micrositios .= sprintf("<td align=center width=%s>%s</td>",$ancho,$micros);

		$boton_micrositios .= "</tr><tr>";

		$boton_micrositios .= "<td align=center class=edicion_elemento valign=top>Vista Previa</td>";
		$boton_micrositios .= "<td align=center class=edicion_elemento valign=top>Config</td>";
		$boton_micrositios .= "<td align=center class=edicion_elemento valign=top>Info</td>";
		$boton_micrositios .= "<td align=center class=edicion_elemento valign=top>Ayuda</td>";

		$boton_micrositios .= "</tr>";
		$boton_micrositios .= "</table>";

		$smarty -> assign('c_micrositios',$boton_micrositios);

		return $smarty;
	}
	/**
	 * Edicion :: DisplaySubMenuEdicion
	 * @param $idcategoria
	 * @param $limite
	 * @return
	 */
	function DisplaySubMenuEdicion($idcategoria = 0, $limite = 1) {

		global $trazaCategoria;	/** @see variables.php */
		global $db;	/** @see variables.php */
		$smarty = new Smarty_Plantilla;

		if (0 != $idcategoria){
			$phpself = basename($_SERVER['PHP_SELF']);

			$row0	= $trazaCategoria[$idcategoria];
			settype($row0, 'object'); // Lo cambiamos a objeto ya que todo esta como objeto

			$inf = (isset($_GET['inf'])  && $_GET['inf'] > 0)?$_GET['inf']: 0;
			$inf = (isset($_POST['inf']) && $_POST['inf'] > 0)?$_POST['inf']: $inf;

			$orden_tmp = Funciones::BusquedaRecursiva($idcategoria,"orden_sub");
			$pag	   = Funciones::BusquedaRecursiva($idcategoria,"paginas_sub");

			$tmp = Funciones::BusquedaRecursiva($idcategoria,"asc_sub");
			switch ($tmp) {
				case 1:
				$asc_tmp = "desc";
				break;
				case 2:
				$asc_tmp = "asc";
				break;
			}
			if($idcategoria == _SCONTRATACION && !Funciones::esAdministrador($_SESSION['info_usuario']['username'], $_SESSION['info_usuario']['password'])) {

				$query  = "SELECT c.* FROM "._TBLCATEGORIA." c,"._TBLEDITORES." e WHERE c.idpadre = ".$idcategoria." AND c.idcategoria=e.idcategoria ";
				$query .= "AND e.idusuario=".$_SESSION['info_usuario']['idusuario']." ORDER BY c.".$orden_tmp." ".$asc_tmp;

				$query_max  = "SELECT c.* FROM "._TBLCATEGORIA." c,"._TBLEDITORES." e WHERE c.idpadre = ".$idcategoria." AND c.idcategoria=e.idcategoria ";
				$query_max .= "AND e.idusuario=".$_SESSION['info_usuario']["idusuario"]." ";
				$result_max = $db->Execute($query_max) or errorQuery(__LINE__, __FILE__);
				$maximo_max = $result_max->NumRows();

			} else {

				$query = sprintf("SELECT * FROM %s WHERE eliminado = 0 AND idpadre = %s ORDER BY %s %s" , _TBLCATEGORIA , $idcategoria, $orden_tmp, $asc_tmp);

				$query_max = sprintf("SELECT idcategoria FROM %s WHERE eliminado = 0 AND idpadre = %s" , _TBLCATEGORIA , $idcategoria);
				$result_max = $db->Execute($query_max) or errorQuery(__LINE__, __FILE__);
				$maximo_max = $result_max->NumRows();

			}

			$result = $db->SelectLimit($query, $pag, $inf) or errorQuery(__LINE__, __FILE__);
			$maximo = $result->NumRows();

			if ($maximo > 0) {

				if($idcategoria) {

					while (!$result->EOF) {
						$row = $result->fields;
						settype($row, 'object');	/** Lo cambiamos a objeto para manejarlo como estaba y no hacer tantos cambios */

						$auth_categoria = (!Autenticacion::esEditor($_SESSION['info_usuario']['username'],$row->idcategoria, 1)) ? 0 : Autenticacion::esEditor($_SESSION['info_usuario']['username'], $row->idcategoria, 1);
						$auth_categoria = (Funciones::esAdministrador($_SESSION['info_usuario']['username'], $_SESSION['info_usuario']['password'])) ? 4 : $auth_categoria;

						$query3 = sprintf("SELECT * FROM %s WHERE idpadre = '%s'", _TBLCATEGORIA, $row->idcategoria);

						$result3 = $db->Execute($query3) or errorQuery(__LINE__, __FILE__);

						if ($result3->NumRows() > 0) {

							if($auth_categoria != 4) {
								$temp1 = sprintf("<span class=warning2><img src=%s/boton_borrar_noff.gif border=0 alt=\"\"></span>", _DIR_IMAGES_EDITOR);
							} else {
								$temp1 = sprintf("<span class=warning2><img src=%s/boton_borrar_off.gif border=0 alt=\"\"></span>", _DIR_IMAGES_EDITOR);
							}

						} else {

							if($auth_categoria != 4) {

								$temp1 = sprintf("<span class=warning2><img src=%s/boton_borrar_non.gif border=0 alt=\"\"></span>", _DIR_IMAGES_EDITOR);

							} else {
								$temp1 = sprintf("<a class=warning1 href=%s %s><img src=%s/boton_borrar_on.gif border=0 alt=\"\"></a>",
													sprintf("%s?idcategoria=%s&amp;idborrar=%s&amp;validacion=%s&amp;inf=%s",
																$phpself,
																$idcategoria,
																$row->idcategoria,
																$row->validacion,
																$inf
															),
													sprintf("onclick=\"return confirmLink(this,'BORRAR PERMANENTEMENTE la categoria %s');\"", $row->nombre),
												_DIR_IMAGES_EDITOR
										);
							}
						}

						$temp2 = sprintf("<a class=warning1 href=%s %s><img src=%s/boton_duplicar.gif border=0 alt=\"\"></a>",
											sprintf("%s?idcategoria=%s&amp;idduplicar=%s&amp;validacion=%s&amp;inf=%s",
													$phpself,
													$idcategoria,
													$row->idcategoria,
													$row->validacion,
													$inf
													),

											sprintf("onclick=\"return confirmLink(this,'DUPLICAR la categoria %s y todas sus subcategorías');\"",
													$row->nombre
													),
											_DIR_IMAGES_EDITOR
										);

						if($auth_categoria < 3) {
							$boton_activar = ($row->activa == 1)?"boton_categoria_non.gif":"boton_categoria_noff.gif";
						} else {
							$boton_activar = ($row->activa == 1)?"boton_categoria_on.gif":"boton_categoria_off.gif";
						}

						$estado = ($row->activa == 1) ? 0 : 1 ;
						$accion = ($row->activa == 1) ? "DESACTIVAR" : "ACTIVAR" ;

						if($auth_categoria < 3) {
							$temp3 = sprintf("<span class=warning2><img src=%s/%s border=0 alt=\"\"></span>", _DIR_IMAGES_EDITOR, $boton_activar);
						} else {
							$temp3  = sprintf("<a class=warning1 href=%s %s><img src=%s/%s border=0 alt=\"\"></a>",
												sprintf("%s?idcategoria=%s&amp;idactivar=%s&amp;validacion=%s&amp;estado=%s&amp;inf=%s",
														$phpself,
														$idcategoria,
														$row->idcategoria,
														$row->validacion,
														$estado,
														$inf
														),
												sprintf("onclick=\"return confirmLink(this,'%s la categoria %s y todas sus subcategorías');\"",
														$accion,
														$row->nombre
														),
												_DIR_IMAGES_EDITOR,
												$boton_activar
											);
						}

						$boton_mini_subir = "mini_subir_on.gif";
						$temp4 = sprintf("<img src=%s/%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$boton_mini_subir);
						$boton_mini_bajar = "mini_bajar_on.gif";
						$temp5 = sprintf("<img src=%s/%s border=0 alt=\"\">",_DIR_IMAGES_EDITOR,$boton_mini_bajar);
						$categoria['boton_borrar']		= $temp1;
						$categoria['boton_duplicar']	= $temp2;
						$categoria['boton_activo']		= $temp3;
						$categoria['boton_mini_subir']  = $temp4;
						$categoria['boton_mini_bajar']  = $temp5;
						$categoria['orden']				= $row->orden;
						$categoria['vinculo']			= sprintf("<a href='%s'><strong>%s</strong></a>\n",sprintf("%s?idcategoria=%s",$phpself,$row->idcategoria),$row->nombre);
						$categoria['info_candado']		= ($row->restringida > 0)?sprintf("<img src='%s/%s'  alt='Restringida'>",_DIR_IMAGES_EDITOR,"mini_candado.gif"):"";
						$hoy = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
						$hoy = date("Y-m-d", $hoy);
						$categoria['info_home']	   = ($row->fecha2 >= $hoy)?sprintf("<img src='%s/%s' alt='En Home'>",_DIR_IMAGES_EDITOR,"mini_home.gif"):"";
						$categorias[] = $categoria;

						$result->MoveNext();
					}
				}
			}
		}

		$convenciones  = sprintf("<table align=left cellpadding=2 cellspacing=0 summary=''>");
		$convenciones .= sprintf("<tr><td class=edicion_elemento colspan=2><strong>Convenciones</strong></td></tr>");
		$convenciones .= sprintf("<tr><td><img src='%s/%s' alt='Restringida'></td><td class='edicion_elemento'>Informa que la categor&iacute;a esta restringida</td></tr>",_DIR_IMAGES_EDITOR,"mini_candado.gif");
		$convenciones .= sprintf("<tr><td><img src='%s/%s' alt='En Home'></td><td class='edicion_elemento'>Informa que la categor&iacute;a aparece en el home</td></tr>",_DIR_IMAGES_EDITOR,"mini_home.gif");
		$convenciones .= sprintf("<tr><td><img src='%s/%s' alt='Borrar'></td><td class='edicion_elemento'>Borra la categor&iacute;a (No se puede deshacer)</td></tr>",_DIR_IMAGES_EDITOR,"mini_borrar_on.gif");
		$convenciones .= sprintf("<tr><td><img src='%s/%s' alt='Bloqueada'></td><td class='edicion_elemento'>Informa que la categor&iacute;a no es borrable debido a que no esta vac&iacute;a</td></tr>",_DIR_IMAGES_EDITOR,"mini_borrar_off.gif");
		$convenciones .= sprintf("<tr><td><img src='%s/%s' alt='Duplicar'></td><td class='edicion_elemento'>Duplica la categor&iacute;a y sus subcategor&iacute;as</td></tr>",_DIR_IMAGES_EDITOR,"mini_duplicar.gif");
		$convenciones .= sprintf("<tr><td><img src='%s/%s' alt='Activar'></td><td class='edicion_elemento'>Activa o desactiva la categor&iacute;a y sus subcategor&iacute;as</td></tr>",_DIR_IMAGES_EDITOR,"mini_categoria_on.gif");
		$convenciones .= sprintf("</table>");

		$smarty -> assign('rotSubMenu', _ROT_SUBMENU_EDICION);
		$smarty -> assign('rotSubMenuConvenciones', $convenciones);

		if(isset($insertar)) {
			$smarty -> assign('c_insertar', $insertar);
		}
		if(isset($categorias)) {
			$smarty -> assign('subMenu', $categorias);
		}
		if($pag!=0) {
			$menos = (($inf - $pag) >0) ? ($inf-$pag) : 0;
			$base = ceil($maximo_max/$pag);
			$mas = ($maximo >= $pag) ? ($inf+$pag) : 0;
			$ultimo = (($base - ceil($maximo_max/$pag)) == 0) ? ($base-1)*$pag : $base*$pag;
			$str = "";
			$link_menos   = ($menos >= 0 && $inf > 0)?sprintf("<a href=?idcategoria=%s&amp;inf=%s%s><img src=%s/%s alt=\"\" border='0'></a>",$idcategoria,$menos,$str,_DIR_IMAGES_EDITOR,"boton_atras_on.gif"):sprintf("<img src=%s/%s alt=\"\" border='0'>",_DIR_IMAGES_EDITOR,"boton_atras_off.gif");
			$link_primero = ($menos >= 0 && $inf > 0)?sprintf("<a href=?idcategoria=%s&amp;inf=%s%s><img src=%s/%s alt=\"\" border='0'></a>",$idcategoria,0,$str,_DIR_IMAGES_EDITOR,"boton_primero_on.gif"):sprintf("<img src=%s/%s alt=\"\" border='0'>",_DIR_IMAGES_EDITOR,"boton_primero_off.gif");
			$link_mas	 = ($ultimo > $inf)?sprintf("<a href=?idcategoria=%s&amp;inf=%s%s><img src=%s/%s alt=\"\" border='0'></a>",$idcategoria,$mas,$str,_DIR_IMAGES_EDITOR,"boton_adelante_on.gif"):sprintf("<img src=%s/%s alt=\"\" border='0'>",_DIR_IMAGES_EDITOR,"boton_adelante_off.gif");
			$link_ultimo  = ($ultimo > $inf)?sprintf("<a href=?idcategoria=%s&amp;inf=%s%s><img src=%s/%s alt=\"\" border='0'></a>",$idcategoria,$ultimo,$str,_DIR_IMAGES_EDITOR,"boton_ultimo_on.gif"):sprintf("<img src=%s/%s alt=\"\" border='0'>",_DIR_IMAGES_EDITOR,"boton_ultimo_off.gif");
			$verMas	   = sprintf("%s %s %s %s",$link_primero,$link_menos,$link_mas,$link_ultimo);
			$tmp		  = ($maximo_max > $pag)?trim($verMas):"";
		} else {
			$tmp = "";
		}

		$smarty -> assign('verMas',$tmp);
		return $smarty -> fetch('tpl_display_submenu_edicion.html');
	}

	/**
	 * activarcategoria()
	 *
	 * @return
	 **/
	function activarcategoria($estado, $idactivar, $validacion, $smarty) {
		global $db;

		$smarty1 = new Smarty_Plantilla;
		$query_del  = sprintf("UPDATE %s SET activa=%s WHERE idcategoria=%s AND validacion='%s'", _TBLCATEGORIA, $estado, $idactivar, $validacion);
		$result_del = $db->Execute($query_del) or errorQuery(__LINE__, __FILE__);

		if ($result_del !== FALSE){
			$accion = ($estado == 1)?"Activada ":"Desactivada ";
			$error[] = sprintf('%s exitosamente la categor&iacute;a %s',$accion,$idactivar);
			$smarty1 -> assign('rotMensaje' , _ROT_CONFIRMACION);
			$smarty1 -> assign('tipo' , "exito");
			$smarty1 -> assign('elementoMenu', $error);
			$show = $smarty1 -> fetch('tpl_display_mensaje.html');
			$smarty -> assign('subMenuError' , $show);
		} else {
			$accion = ($estado == 1)?"activar ":"desactivar ";
			$error[] = sprintf('No se pudo %s la categoria %s',$accion,$idactivar);
			$smarty1 -> assign('rotMensaje' , _ROT_ADVERTENCIA);
			$smarty1 -> assign('tipo' , "error");
			$smarty1 -> assign('elementoMenu', $error);
			$show = $smarty1 -> fetch('tpl_display_mensaje.html');
			$smarty -> assign('subMenuError' , $show);
		}
		return $smarty;
	}

	/**
	 * enumerarCategoria()
	 *
	 * @return
	 **/
	function enumerarCategoria($idrenum,$validacion,$smarty) {
		$smarty1 = new Smarty_Plantilla;
		$result_renum = Renumerar($idrenum,$validacion);

		if ($result_renum){
			$error[] = sprintf('Renumerada exitosamente la categor&iacute;a %s',$idrenum);
			$smarty1 -> assign('rotMensaje' , _ROT_CONFIRMACION);
			$smarty1 -> assign('tipo' , "exito");
			$smarty1 -> assign('elementoMenu', $error);
			$show = $smarty1 -> fetch('tpl_display_mensaje.html');
			$smarty -> assign('subMenuError' , $show);
		} else {
			$error[] = sprintf('No se pudo renumer la categor&iacute;a %s',$idrenum);
			$smarty1 -> assign('rotMensaje' , _ROT_ADVERTENCIA);
			$smarty1 -> assign('tipo' , "error");
			$smarty1 -> assign('elementoMenu', $error);
			$show = $smarty1 -> fetch('tpl_display_mensaje.html');
			$smarty -> assign('subMenuError' , $show);
		}
		return $smarty;
	}

	/**
	 * borrarCategoria()
	 *
	 * @return
	 **/
	function borrarCategoria($idborrar,$validacion,$smarty) {
		global $db;
		$smarty1 = new Smarty_Plantilla;

		$query_sel  = sprintf("SELECT * FROM %s WHERE idcategoria=%s AND validacion='%s'", _TBLCATEGORIA, $idborrar ,$validacion);
		$result_sel = $db->Execute($query_sel) or errorQuery(__LINE__, __FILE__);

		// Borrado de la categoria
		$query_del  = sprintf("DELETE FROM %s WHERE idcategoria=%s AND validacion='%s'", _TBLCATEGORIA, $idborrar ,$validacion);
		$result_del = $db->Execute($query_del) or errorQuery(__LINE__, __FILE__);

		if ($result_del !== FALSE && $result_sel->NumRows() == 1){
			$arr = $result_sel->fields;
			// Borrado de los entradas en la tabla de acceso a la categoria
			$query_del1  = sprintf("DELETE FROM %s WHERE idcategoria=%s", _TBLACCESO, $idborrar);
			$result_del1 = $db->Execute($query_del1) or errorQuery(__LINE__, __FILE__);
			// Borrado de los entradas en la tabla de edición
			$query_del2  = sprintf("DELETE FROM %s WHERE idcategoria=%s", _TBLEDITORES, $idborrar);
			$result_del2 = $db->Execute($query_del2) or errorQuery(__LINE__, __FILE__);
			// Borrado de archivos relacionados
			if($arr["vinculo"]!='' && is_file (_DIRDOWNLOADS."/".$arr["vinculo"])){
				unlink(_DIRDOWNLOADS."/".$arr["vinculo"]);
			}
		}

		if ($result_del !== FALSE && $result_sel->NumRows() == 1){
			$error[] = sprintf('Borrado exitoso de la categor&iacute;a %s',$idborrar);
			$smarty1 -> assign('rotMensaje' , _ROT_CONFIRMACION);
			$smarty1 -> assign('tipo' , "exito");
			$smarty1 -> assign('elementoMenu', $error);
			$show = $smarty1 -> fetch('tpl_display_mensaje.html');
			$smarty -> assign('subMenuError' , $show);
		} else {
			$error[] = sprintf('No se pudo borrar la categoria %s<br>Posibles errores: La categor&iacute;a ya fu&eacute; borrada o no esta vac&iacute;a.',$idborrar);
			$smarty1 -> assign('rotMensaje' , _ROT_ADVERTENCIA);
			$smarty1 -> assign('tipo' , "error");
			$smarty1 -> assign('elementoMenu', $error);
			$show = $smarty1 -> fetch('tpl_display_mensaje.html');
			$smarty -> assign('subMenuError' , $show);
		}
		return $smarty;
	}
	/**
	 * Edicion :: DuplicarPrototipo
	 * @param
	 * @return
	 */
	function DuplicarPrototipo($idcategoria_prototipo, $idcategoria_contenedor, $nombre='', $conta) {

		global $db; /** @see variables.php */

		$conta++;

		// Obtenemos la información de la categoria que se copiará
		$select0 = sprintf("SELECT * FROM %s WHERE idcategoria = '%s' ORDER BY orden",_TBLCATEGORIA,$idcategoria_prototipo);
		$query0 = $db->Execute($select0) or errorQuery(__LINE__, __FILE__);
		$row0 = $query0->fields;

		// Insertamos la categoria_prototipo en la categoria_contenedor
		$select1 = sprintf("INSERT INTO %s (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s) "
							,_TBLCATEGORIA
							,'idpadre'
							,'nombre'
							,'descripcion'
							,'imagen'
							,'pie_imagen'
							,'activa'
							,'orden'
							,'restringida'
							,'iddisplay'
							,'iddisplay_sub'
							,'fecha1'
							,'fecha2'
							,'fecha3'
							,'autor'
							,'antetitulo'
							,'subtitulo'
							,'entradilla'
							,'validacion'
							,'template'
							,'orden_sub'
							,'asc_sub'
							,'paginas_sub'
							,'eliminado'
							,'es_root'
							,'en_mapa'
							,'en_buscador'
							,'varsubsitio'
							,'idbusqueda'
							,'es_rss'
							,'idioma'
							);

		srand((double)microtime()*1000000);
		$validacion = md5(rand(0,9999999));

		$select1 .= sprintf("values ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',0,'%s','%s','%s','%s','%s','%s','%s')"
							,$idcategoria_contenedor
							,($nombre != '')?"Copia de " . $row0["nombre"]:$row0["nombre"]
							,addslashes($row0["descripcion"])
							,$row0["imagen"]
							,$row0["pie_imagen"]
							,$row0["activa"]
							//	  ,($nombre != '')?CalcularOrden($idcategoria_contenedor):$row0->orden
							,Edicion::CalcularOrden($idcategoria_contenedor)
							,($row0["restringida"])?$row0["restringida"]:0
							,$row0["iddisplay"]
							,$row0["iddisplay_sub"]
							,($row0["fecha1"])?$row0["fecha1"]:'now()'
							,($row0["fecha2"])?$row0["fecha2"]:'now()'
							,date("Y-m-d H:i:s")
							,$row0["autor"]
							,$row0["antetitulo"]
							,$row0["subtitulo"]
							,addslashes($row0["entradilla"])
							,$validacion
							,$row0["template"]
							,($row0["orden_sub"] != '') ? $row0["orden_sub"] : ''
							,($row0["asc_sub"] != 0) ? $row0["asc_sub"] : 0
							,($row0["paginas_sub"] != 0) ? $row0["paginas_sub"] : 0
							,($row0["es_root"] != 0) ? $row0["es_root"] : 0
							,($row0["en_mapa"] != 0) ? $row0["en_mapa"] : 0
							,($row0["en_buscador"] != 0) ? $row0["en_buscador"] : 0
							,(!empty($row0["varsubsitio"])) ? $row0["varsubsitio"] : ''
							,(!empty($row0["idbusqueda"])) ? $row0["idbusqueda"] : 1
							,(!empty($row0["es_rss"])) ? $row0["es_rss"] : 0
							,(!empty($row0["idioma"])) ? $row0["idioma"] : 0
							);

		/**
		 * Ejecutamos la duplicacion
		 */
		$query1 = $db->Execute($select1) or errorQuery(__LINE__, __FILE__);

		// Buscamos el nuevo padre (el recién insertado)
		$ultimoid	= $db->Insert_ID();

		unset($select1);
		unset($query1);

		// Inserción de registro de seguridad de lectura y escritura para el usuario que hace la copia de la categoría (solo el primer registro)
		if( Autenticacion::esEditor($_SESSION['info_usuario']['username'],$idcategoria_contenedor,1) < 4 &&
		    !Funciones::esAdministrador($_SESSION['info_usuario']['username'], $_SESSION['info_usuario']['password']) && $conta == 0) {

			if(isset($_SESSION['info_usuario'])) {

				$query = "INSERT INTO "._TBLEDITORES." (idusuario,idcategoria,tipoedicion,permisos) VALUES (".$_SESSION['info_usuario']['idusuario'].",".$ultimoid.",1,3)";
				$db->Execute($query) or errorQuery(__LINE__, __FILE__);

			}
		}

		/**
		 * Buscamos las subcategorias del padre actual para duplicarlas
		 * Para ponerlas en la categoria acabada de ingresar "$ultimoid"
		 */
		$select2 = sprintf("SELECT * FROM %s WHERE idpadre = '%s' ORDER BY orden"
							,_TBLCATEGORIA
							,$idcategoria_prototipo
						  );
		$query2  = $db->Execute($select2) or errorQuery(__LINE__, __FILE__);

		if ($query2->NumRows() > 0) {
			while (!$query2->EOF) {
				$conta = Edicion::DuplicarPrototipo($query2->fields["idcategoria"], $ultimoid, '', $conta);
				$query2->MoveNext();
			}
		}
		return $conta;
	}
	/**
	 * Edicion :: CalcularOrden
	 * Busca el numero máximo en la categoria y le pone el número siguiente
	 * @param
	 * @return
	 */
	function CalcularOrden($idcategoria) {
		global $db;
		$select	= sprintf("SELECT MAX(orden) AS maximo FROM %s WHERE idpadre = '%s'", _TBLCATEGORIA, $idcategoria);
		$result	= $db->Execute($select) or errorQuery(__LINE__, __FILE__);
		$numero_actual = $result->fields['maximo'];
		return $numero_actual + 10;
	}
	/**
	 * Edicion :: BuscarAnterior
	 * Busca la categoria que está antes de la categoria actual
	 * @param integer $idcategoria
	 * @return
	 */
	function BuscarAnterior($idcategoria){

		$idcategoria = ($idcategoria == '')?0:$idcategoria;
		$idpadre = Funciones::BuscarPadre($idcategoria);

		$orden_tmp = Funciones::BusquedaRecursiva($idpadre,"orden_sub");
		$tmp = Funciones::BusquedaRecursiva($idpadre,"asc_sub");

		switch ($tmp) {
			case 1:
			$asc_tmp = "desc";
			break;
			case 2:
			$asc_tmp = "asc";
			break;
		}

		if($idpadre) {
			global $db;
			$query = sprintf("SELECT * FROM %s WHERE idpadre = '%s' ORDER BY %s %s", _TBLCATEGORIA, $idpadre, $orden_tmp, $asc_tmp);
			$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);

			if ($result !== FALSE and $result->NumRows() > 0){
				$link = 0;
				$anterior = 0;
				while(!$result->EOF){
					$row = $result->fields;
					if($idcategoria == $row["idcategoria"]){
						$link = $anterior;
						break;
					}
					$anterior = $row["idcategoria"];
					$result->MoveNext();
				}
			}else{
				$link = 0;
			}
		} else {
			$link = 0;
		}
		return $link;
	}
	/**
	 * Edicion :: BuscarSiguiente
	 * Busca la categoria siguiente a la actual
	 * @param integer $idcategoria
	 * @return
	 */
	function BuscarSiguiente($idcategoria) {

		$idcategoria = ($idcategoria == '')?0:$idcategoria;
		$idpadre = Funciones::BuscarPadre($idcategoria);

		$orden_tmp = Funciones::BusquedaRecursiva($idpadre,"orden_sub");
		$tmp = Funciones::BusquedaRecursiva($idpadre,"asc_sub");
		switch ($tmp) {
			case 1:
			$asc_tmp = "desc";
			break;
			case 2:
			$asc_tmp = "asc";
			break;
		}

		if($idpadre) {
			global $db;

			$query = sprintf("SELECT * FROM %s WHERE idpadre = '%s' ORDER BY %s %s", _TBLCATEGORIA, $idpadre, $orden_tmp, $asc_tmp);
			$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);

			if ($result !== FALSE and $result->NumRows() > 0){

				$link = 0;
				$siguiente = 0;

				while(!$result->EOF){
					$row = $result->fields;
					if($idcategoria == $row["idcategoria"]) {

						if ($result->MoveNext()) {
							$siguiente = $result->fields["idcategoria"];
						} else {
							$siguiente = 0;
						}

						$link = $siguiente;
						break;
					}
					$siguiente = $row["idcategoria"];
					$result->MoveNext();
				}

			} else {
				$link = 0;
			}
		} else {
			$link = 0;
		}
		return $link;
	}
	/**
	 * Edicion :: Renumerar
	 * Renumerar las categorias
	 * @param integer $idcategoria
	 * @param integer $validacion
	 * @return
	 */
	function Renumerar($idcategoria,$validacion) {
		global $db;

		$select0 = sprintf("SELECT idcategoria FROM %s WHERE idcategoria = '%s' AND validacion = '%s'",_TBLCATEGORIA,$idcategoria,$validacion);
		$result0 = $db->Execute($select0) or errorQuery(__LINE__, __FILE__);

		if($result0->NumRows() == 1) {

			$select	= sprintf("SELECT idcategoria FROM %s WHERE idpadre = '%s' ORDER BY orden", _TBLCATEGORIA, $idcategoria);
			$result = $db->Execute($select) or errorQuery(__LINE__, __FILE__);

			$nuevo_orden = 0;
			while(!$result->EOF) {

				$row = $result->fields;
				$nuevo_orden = $nuevo_orden + 10;
				$select1 = sprintf("UPDATE %s SET orden = %s WHERE idcategoria = '%s'", _TBLCATEGORIA, $nuevo_orden, $row['idcategoria']);
				$db->Execute($select1) or errorQuery(__LINE__, __FILE__);
				$result->MoveNext();

			}
			return 1;
		}
	}
	/**
	 * Edicion :: Navegacion
	 * Muestra la navegacion de categorias
	 * @param integer $idcategoria
	 * @return
	 */
	function Navegacion($idcategoria){

		global $db;

		$infoCategoriaActual = FuncionesDisplay::cargarSesionPaginaActual($idcategoria);
		$inf = $infoCategoriaActual['inf'];

		$pag = Funciones::BusquedaRecursiva($idcategoria,"paginas_sub");
		$result = FuncionesDisplay::cargarInfoSubCategoria($idcategoria, $plus);
		$maximo = $result->NumRows();

		$query_max = sprintf("SELECT idcategoria FROM %s WHERE activa != 0 AND idpadre = %s %s" , _TBLCATEGORIA, $idcategoria, $plus);
		$result_max = $db->Execute($query_max) or errorQuery(__LINE__, __FILE__);
		$maximo_max = $result_max->NumRows();

		if($pag != 0){

			$menos		= (($inf - $pag) >0)	 ?($inf-$pag):0;
			$base		 = ceil($maximo_max/$pag);
			$mas		  = ($maximo >= $pag)?($inf+$pag):0;
			$ultimo	   = (($base - ceil($maximo_max/$pag))==0)?($base-1)*$pag:$base*$pag;

			$str = "";

			$link_menos   = ($menos >= 0 && $inf > 0)?sprintf("<a href=?idcategoria=%s&amp;inf=%s  title=\"anterior\"><img src=\"%s/%s\" alt=\"anterior\" border=\"0\"></a>",$idcategoria,$menos,_DIR_IMAGES_EDITOR,"boton_atras_on.gif"):sprintf("<img src=\"%s/%s\" alt=\"\">",_DIR_IMAGES_EDITOR,"boton_atras_off.gif");
			$link_primero = ($menos >= 0 && $inf > 0)?sprintf("<a href=?idcategoria=%s&amp;inf=%s  title=\"primero\"><img src=\"%s/%s\" alt=\"primero\" border=\"0\"></a>",$idcategoria,0,_DIR_IMAGES_EDITOR,"boton_primero_on.gif"):sprintf("<img src=\"%s/%s\" alt=\"\">",_DIR_IMAGES_EDITOR,"boton_primero_off.gif");
			$link_mas	 = ($ultimo > $inf)?sprintf("<a href=?idcategoria=%s&amp;inf=%s  title=\"siguiente\"><img src=\"%s/%s\" border=\"0\" alt=\"siguiente\"></a>",$idcategoria,$mas,_DIR_IMAGES_EDITOR,"boton_adelante_on.gif"):sprintf("<img src=\"%s/%s\" alt=\"\">",_DIR_IMAGES_EDITOR,"boton_adelante_off.gif");
			$link_ultimo  = ($ultimo > $inf)?sprintf("<a href=?idcategoria=%s&amp;inf=%s  title=\"&uacute;ltimo\"><img src=\"%s/%s\" border=\"0\" alt=\"&uacute;ltimo\"></a>",$idcategoria,$ultimo,_DIR_IMAGES_EDITOR,"boton_ultimo_on.gif"):sprintf("<img src=\"%s/%s\" alt=\"\">",_DIR_IMAGES_EDITOR,"boton_ultimo_off.gif");
			$verMas	   = sprintf("%s &nbsp; %s &nbsp; %s &nbsp; %s",$link_primero,$link_menos,$link_mas,$link_ultimo);
			$tmp		  = ($maximo_max > $pag)?trim($verMas):"";

			return $tmp;
		}else{
			return "";
		}
	}
}
?>
