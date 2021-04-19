<?php
/**
 * Class FuncionesDisplay
 * Trae todas las funciones de visualizacion de templates
 * @package Núcleo
 * @author Juan Manuel Hernández <jhernandez@micrositios.net>
 * @version
 * @copyright Copyright Â© 2005 Micrositios Ltda.
 */
class FuncionesDisplay {

	/***************************/
	//Template:TemplateCategoria
	//Archivo Destino:
	//tpl_default
	/***************************/
	function TemplateCategoria($idcategoria = 0, $html = 0) {

		global $db; /** @see variables.php */
		global $sroot; /** @see variables.php */
		global $trazaCategoria; /** @see variables.php */


		$smarty = new Smarty_Plantilla;

		$hoy = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$hoy = date("Y-m-d", $hoy);

		$phpself = basename($_SERVER['PHP_SELF']);
		$pagina = $phpself."?idcategoria=".$idcategoria;

		// Selección de los datos de la categoría
		$row = $trazaCategoria[$idcategoria];

		if ($row["activa"] == 1){

			$smarty -> assign('c_antetitulo', $row["antetitulo"]);/* Antetitulo */
			$smarty -> assign('c_titulo', $row["nombre"]);		/* Titulo */
			$smarty -> assign('c_subtitulo', $row["subtitulo"]);	/* Subtitulo */
			$smarty -> assign('c_entradilla', stripslashes(nl2br($row["entradilla"])));	/* Resumen */
			$smarty -> assign('c_iddisplay_sub', $row['iddisplay_sub']); /* Iddisplau_sub */

			$c_descripcion = $html ? trim($row["descripcion"]) : nl2br(trim($row["descripcion"]));

			$smarty -> assign('c_descripcion', html_entity_decode(stripslashes($c_descripcion))); /* Contenido */

			$smarty -> assign('c_autor', $row["autor"]);	/* Autor */

			/****************************************
			DEFINICION DEL SUBMENU QUE ES LO QUE REALMENTE
			DIFERENCIA A UNA CATEGORIA DE OTRA
			(DEFAULT = SECCIONES CON RESUMEN = SECCIONES COMPLETAS )
			****************************************/

			$c_submenu = Funciones::DisplaySubMenu($idcategoria, Funciones::BusquedaRecursiva($idcategoria, "iddisplay_sub"));
			$smarty -> assign('c_submenu', $c_submenu);

			/* Fecha */
			$fecha = trim(substr($row["fecha1"],0,10));
			$fecha = FuncionesInterfaz::datetotext($fecha);
			$smarty -> assign('c_fecha', $fecha);

			/* Submenu auxiliar */
			/****************************************
			Se crea cuando el contenido es muy largo ya que
			se pierde el menu (debido a que va en la parte
			inferior), por lo tanto se duplica en la parte
			superior, si tiene demasiados hijos (por default
			10) entonces NO se crea el submenu adicional porque
			se pierde el contenido.
			Solo esta impelmentado en la categoría Default.
			****************************************/
			$cantidad_hijos = count(Funciones::BuscarHijos($idcategoria));
			if(strlen($row["descripcion"]) > 2000 && $cantidad_hijos <= 10){
				$smarty -> assign('c_submenu_plus', $c_submenu);
			}

			/* Herramientas */
			/****************************************
			El vínculo para subir, se crea cuando el contenido
			es muy largo (2000 caracteres por default).
			El vínculo para imprimir solo si existe contenido.
			El vínculo de cuéntele solo si existe contenido.
			****************************************/

			/* Subir */
			$c_subir = ((strlen($row["descripcion"]) > 2000) || strlen($c_submenu) > 2000)?sprintf("<a href='#top' title='Ir al inicio de esta página'><img src='%smini_subir.gif' alt='\"Ir al inicio de esta página\"' /></a>&nbsp;", _DIRIMAGES_AUX):"";
			$smarty -> assign('c_subir', trim($c_subir));

			/* Imprimir */
			$c_imprimir = ($idcategoria == 1 || (strlen(trim($row["descripcion"])) == 0 && strlen(trim($c_submenu)) == 0 && strlen(trim($row["entradilla"])) == 0))?"":FuncionesInterfaz::Imprimir($idcategoria, '');
			$smarty -> assign('c_imprimir', trim($c_imprimir));

			/* Cuéntele */
			$c_cuentele = ($idcategoria == 1 || strlen(trim($row["descripcion"])) == 0)?"":FuncionesInterfaz::Cuentele($idcategoria);
			$smarty -> assign('c_cuentele', $c_cuentele);

			/* Imagen */
			/* Verificamos que el archive exista físicamente */
			$img_tmp = _DIRIMAGES_USER . $row["imagen"];

			$con_imagen = (file_exists($img_tmp) && is_file($img_tmp)) ? 1 : 0;

			/* Si la imagen tiene 300px o menos la dejamos del tamaño original ajustada a la izquierda*/
			/* Si la imagen tiene menos entre 300px y 500px la dejamos del tamaño original pero en nuevo renglon y centrada */
			/* Si la imagen tiene mas de 500px la reducimos en nuevo renglon y centrada */

			if ($con_imagen){
				$l_imagen = sprintf("%s%s",_DIRIMAGES_USER,$row["imagen"]);
				$pie_imagen = $row["pie_imagen"];
				$ancho1 = _IMGANCHOMEDIO;
				$ancho2 = _IMGANCHOMAXIMO;
				$ImageSize = GetImageSize($img_tmp);
				$alto0  = $ImageSize[1];
				$ancho0 = $ImageSize[0];
				if ($ancho0 <= $ancho1) {
					$alinea = _IMGALINEACION;
					$fwidth=$ancho0;
				} elseif ($ancho0 > $ancho1 && $ancho0 <= $ancho2) {
					$alinea = "center";
					$fwidth=$ancho0;
				} else {
					$alinea = "center";
					$fwidth=$ancho2;
				}
				$smarty -> assign('l_imagen', $l_imagen);
				$smarty -> assign('pie_imagen', $pie_imagen);
				$smarty -> assign('anchomedio', $ancho1);
				$smarty -> assign('alinea'	, $alinea);
				$smarty -> assign('fwidth'	, $fwidth);
				$smarty -> assign('width'	, $ancho0);
				$smarty -> assign('imagen'	,$row["imagen"]);
			}

			/**
			 * Miramos si tiene la parte del RSS
			 */
			$idpadre = $trazaCategoria[$idcategoria]['idpadre'];
			switch(true) {
				case ($trazaCategoria[$idcategoria]['es_rss'] == 1):
					$smarty->assign('rss_id', $idcategoria);
					$smarty->assign('rss_nombre', $trazaCategoria[$idcategoria]['nombre']);
					$smarty->assign('rss_id_actual', TRUE);
					break;
				case ($trazaCategoria[$idpadre]['es_rss'] == 1):
					$smarty->assign('rss_id', $idpadre);
					$smarty->assign('rss_nombre', $trazaCategoria[$idpadre]['nombre']);
					$smarty->assign('rss_id_actual', FALSE);
					break;
			}
		}
		// Cambio # 1
		$consulta = $db->prepare("Select * from "._TBLCATEGORIA." where idcategoria = ?");
		$res = $db->Execute($consulta, array($idcategoria)) /* or errorQuery(__LINE__, __FILE__) */;
		
		
			$delicious = "http://del.icio.us/post?url="._URL."index.php?idcategoria=".$res->fields['idcategoria']."&title=".str_replace(" ","+",$res->fields['nombre']);
			
			/* parametro que tenia antes la pagina web */
			
			/*$facebook = "http://www.facebook.com/sharer.php?u="._URL."index.php?idcategoria=".$res->fields['idcategoria']."&t=".str_replace(" ","+",$res->fields['nombre']);*/
			
			
			
			
			
			/*NUEVO PARAMETRO PARA LA URL BOTON ME GUSTA
			*/
			$facebook1 = "http://www.facebook.com/plugins/like.php?href="._URL."index.php?idcategoria=".$res->fields['idcategoria']."&t=".str_replace(" ","+",$res->fields['nombre']);
            
			
			
			/* Boton compartir en facebook */
			
			$share_facebook = _URL."index.php?idcategoria=".$res->fields['idcategoria']."&t=".str_replace(" ","+",$res->fields['nombre']);
			
			/* Creacion de boton para twitter */
			//$twitter = 'http://'._URL.'index.php?idcategoria='.$res->fields['idcategoria'].'&t='.str_replace(' ','+',$res->fields['nombre']);
			
			/* Asignacion variable categoria */
			$categoriaComp = $res->fields['idcategoria'];
			
	        $twitter = _URL.'?idcategoria='.$categoriaComp;
			
            $text  = 'Comparte en:'; 			
			
			$digg = "http://digg.com/submit?phase=2&url="._URL."index.php?idcategoria=".$res->fields['idcategoria']."&t=".str_replace(" ","+",$res->fields['nombre']);
			
			$link_delicious = sprintf("<a href='%s' target='_blank'><img src='%sdelicious.jpg' alt='Delicious' /></a>",$delicious,_DIRIMAGES);
			/*vinculo antiguo de facebook*/
			
			/*$link_facebook = sprintf("<a href='%s' target='_blank'><img src='%sfacebook.jpg'></a>",$facebook,_DIRIMAGES);*/
			
			
			/* PARA BOTON  ME GUSTA FACEBOOK*/

            $link_sharefb = "<a name='fb_share' type='button_count' share_url='".$share_facebook."' href='http://www.facebook.com/sharer.php'>Compartir</a><script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>";			
            
			/*
			$link_facebook = "<div data-href='".$facebook1."' data-send='true' data-layout='button_count' data-width='30' data-show-faces='false' data-font='arial' data-colorscheme='dark'></div>";
			*/
			
			$link_facebook =
			"<script type=\"text/javascript\">
				function goclicky(meh)
                {
                  var x = screen.width/2 - 700/2;
                  var y = screen.height/2 - 450/2;
                  window.open(meh, 'facebook','height=485,width=700,left='+x+',top='+y);
                }
            </script>
			
            <a style=\"text-decoration:none\"onclick=\"goclicky('https://www.facebook.com/sharer/sharer.php?u=".$share_facebook."'); return false;\" href=\"#\">Me gusta</a>";
			
			
			
			
			
			
			/* twitter ejercito */
	        $link_twitter  = "<a href='https://twitter.com/share' target='_blank' data-url='".$twitter."' data-lang='es' data-related='COL_EJERCITO' data-hashtags='COL_EJERCITO' data-dnt='true' data-via='COL_EJERCITO' data-lang='es'>Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='//platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','twitter-wjs');</script>";		
			
			/* twitter ingenieros */
			$link_twitter_ingenieros ="<a href='http://twitter.com/share' class='twitter-share-button' data-url='".$twitter."' data-via='ING_MILITARES' data-count='none' data-lang='es'>Tweet</a><script type='text/javascript' src='http://platform.twitter.com/widgets.js'></script>";
			
			/*$google_mas = "<div class='g-plusone' data-annotation='inline' data-width='120'></div><script type='text/javascript'>window.___gcfg = {lang: 'es-419'};(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();</script>";*/
			$google_mas = "<script type='text/javascript'>
			                    function goclicky(meh){
								       var x = screen.width/2 - 700/2;
									   var y = screen.height/2 - 450/2;
									   window.open(meh, 'google+','height=485,width=700,left='+x+',top='+y);
									}
								</script>
			                    <a style=\"text-decoration:none\" onclick=\"goclicky('https://plus.google.com/share?url=".$twitter."'); return false;\" href=\"#\">Compartir</a>";
						   
			
			
			$link_digg = sprintf("<a href='%s' target='_blank'><img src='%sdigg.jpg' alt='Digg' /></a>",$digg,_DIRIMAGES);
            
			$smarty -> assign('twitter_esing', $link_twitter_ingenieros);
			$smarty -> assign('delicious', $link_delicious);
			$smarty -> assign('facebook', $link_facebook);
			$smarty -> assign('texto_compartir', $text);
			$smarty -> assign('facebook_share', $link_sharefb);
			$smarty -> assign('twitter', $link_twitter);
			$smarty -> assign('digg', $link_digg);
			$smarty -> assign('google', $google_mas);
			$smarty -> assign('idcategoria', $idcategoria);	
		$smarty->assign('root', $sroot);
		return $smarty -> fetch('tpl_default.html');
	}
	/**
	 * FuncionesDisplay :: TemplateDefault
	 * Template: Default
	 * Archivo Destino: tpl_default.html
	 * @param integer $idcategoria
	 * @return
	 **/
	function TemplateDefault($idcategoria){
		return FuncionesDisplay::TemplateCategoria($idcategoria);
	}

	/**
	 * FuncionesDisplay :: TemplateDefaultNoticias
	 * Template: Default_noticias
	 * Archivo Destino: tpl_default_noticias.html
	 * @param integer $idcategoria
	 * @return
	 **/
	function TemplateDefaultNoticias($idcategoria){
		global $db; /** @see variables.php */
		global $sroot; /** @see variables.php */
		global $trazaCategoria; /** @see variables.php */


		$smarty = new Smarty_Plantilla;

		$hoy = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$hoy = date("Y-m-d", $hoy);

		$phpself = basename($_SERVER['PHP_SELF']);
		$pagina = $phpself."?idcategoria=".$idcategoria;

		// Selección de los datos de la categoría
		$row = $trazaCategoria[$idcategoria];

		if ($row["activa"] == 1){

			$smarty -> assign('c_antetitulo', $row["antetitulo"]);/* Antetitulo */
			$smarty -> assign('c_titulo', $row["nombre"]);		/* Titulo */
			$smarty -> assign('c_subtitulo', $row["subtitulo"]);	/* Subtitulo */
			$smarty -> assign('c_entradilla', stripslashes(nl2br($row["entradilla"])));	/* Resumen */
			$smarty -> assign('c_iddisplay_sub', $row['iddisplay_sub']); /* Iddisplau_sub */

			$c_descripcion = $html ? trim($row["descripcion"]) : nl2br(trim($row["descripcion"]));

			$smarty -> assign('c_descripcion', html_entity_decode(stripslashes($c_descripcion))); /* Contenido */

			$smarty -> assign('c_autor', $row["autor"]);	/* Autor */

			/****************************************
			DEFINICION DEL SUBMENU QUE ES LO QUE REALMENTE
			DIFERENCIA A UNA CATEGORIA DE OTRA
			(DEFAULT = SECCIONES CON RESUMEN = SECCIONES COMPLETAS )
			****************************************/

			$c_submenu = Funciones::DisplaySubMenu($idcategoria, Funciones::BusquedaRecursiva($idcategoria, "iddisplay_sub"));
			$smarty -> assign('c_submenu', $c_submenu);

			/* Fecha */
			$fecha = trim(substr($row["fecha1"],0,10));
			$fecha = FuncionesInterfaz::datetotext($fecha);
			$smarty -> assign('c_fecha', $fecha);

			/* Submenu auxiliar */
			/****************************************
			Se crea cuando el contenido es muy largo ya que
			se pierde el menu (debido a que va en la parte
			inferior), por lo tanto se duplica en la parte
			superior, si tiene demasiados hijos (por default
			10) entonces NO se crea el submenu adicional porque
			se pierde el contenido.
			Solo esta impelmentado en la categoría Default.
			****************************************/
			$cantidad_hijos = count(Funciones::BuscarHijos($idcategoria));
			if(strlen($row["descripcion"]) > 2000 && $cantidad_hijos <= 10){
				$smarty -> assign('c_submenu_plus', $c_submenu);
			}

			/* Herramientas */
			/****************************************
			El vínculo para subir, se crea cuando el contenido
			es muy largo (2000 caracteres por default).
			El vínculo para imprimir solo si existe contenido.
			El vínculo de cuéntele solo si existe contenido.
			****************************************/

			/* Subir */
			$c_subir = ((strlen($row["descripcion"]) > 2000) || strlen($c_submenu) > 2000)?sprintf("<a href='#top' title='Ir al inicio de esta página'><img src='%smini_subir.gif' alt='\"Ir al inicio de esta página\"' /></a>&nbsp;", _DIRIMAGES_AUX):"";
			$smarty -> assign('c_subir', trim($c_subir));

			/* Imprimir */
			$c_imprimir = ($idcategoria == 1 || (strlen(trim($row["descripcion"])) == 0 && strlen(trim($c_submenu)) == 0 && strlen(trim($row["entradilla"])) == 0))?"":FuncionesInterfaz::Imprimir($idcategoria, '');
			$smarty -> assign('c_imprimir', trim($c_imprimir));

			/* Cuéntele */
			$c_cuentele = ($idcategoria == 1 || strlen(trim($row["descripcion"])) == 0)?"":FuncionesInterfaz::Cuentele($idcategoria);
			$smarty -> assign('c_cuentele', $c_cuentele);

			/* Imagen */
			/* Verificamos que el archive exista físicamente */
			$img_tmp = _DIRIMAGES_USER . $row["imagen"];

			$con_imagen = (file_exists($img_tmp) && is_file($img_tmp)) ? 1 : 0;

			/* Si la imagen tiene 300px o menos la dejamos del tamaño original ajustada a la izquierda*/
			/* Si la imagen tiene menos entre 300px y 500px la dejamos del tamaño original pero en nuevo renglon y centrada */
			/* Si la imagen tiene mas de 500px la reducimos en nuevo renglon y centrada */

			if ($con_imagen){
				$l_imagen = sprintf("%s%s",_DIRIMAGES_USER,$row["imagen"]);
				$pie_imagen = $row["pie_imagen"];
				$ancho1 = _IMGANCHOMEDIO;
				$ancho2 = _IMGANCHOMAXIMO;
				$ImageSize = GetImageSize($img_tmp);
				$alto0  = $ImageSize[1];
				$ancho0 = $ImageSize[0];
				if ($ancho0 <= $ancho1) {
					$alinea = _IMGALINEACION;
					$fwidth=$ancho0;
				} elseif ($ancho0 > $ancho1 && $ancho0 <= $ancho2) {
					$alinea = "center";
					$fwidth=$ancho0;
				} else {
					$alinea = "center";
					$fwidth=$ancho2;
				}
				$smarty -> assign('l_imagen', $l_imagen);
				$smarty -> assign('pie_imagen', $pie_imagen);
				$smarty -> assign('anchomedio', $ancho1);
				$smarty -> assign('alinea'	, $alinea);
				$smarty -> assign('fwidth'	, $fwidth);
				$smarty -> assign('width'	, $ancho0);
				$smarty -> assign('imagen'	,$row["imagen"]);
			}

			/**
			 * Miramos si tiene la parte del RSS
			 */
			$idpadre = $trazaCategoria[$idcategoria]['idpadre'];
			switch(true) {
				case ($trazaCategoria[$idcategoria]['es_rss'] == 1):
					$smarty->assign('rss_id', $idcategoria);
					$smarty->assign('rss_nombre', $trazaCategoria[$idcategoria]['nombre']);
					$smarty->assign('rss_id_actual', TRUE);
					break;
				case ($trazaCategoria[$idpadre]['es_rss'] == 1):
					$smarty->assign('rss_id', $idpadre);
					$smarty->assign('rss_nombre', $trazaCategoria[$idpadre]['nombre']);
					$smarty->assign('rss_id_actual', FALSE);
					break;
			}
		}

		//Ingreso de comentario --Respuesta
		if (isset($_POST['comentario'])&& $_POST['comentario']!="") {

			$validacion = md5(rand(0,9999999));

			//Verificación si el mensaje ya existe
            // Cambio # 7 
			$q2	= $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE idpadre= ? AND descripcion= ? AND autor=?");
			$r2	= $db->Execute($q2, array($_POST['padre'], nl2br(strip_tags($_POST['comentario'])), strip_tags($_POST['nombreRespuesta']))) /* or errorQuery(__LINE__, __FILE__) */;

			if($r2 !== FALSE and $r2->NumRows() == 0) {
				//Inserción del Nuevo Mensaje
				$consulta	= $db->prepare("INSERT INTO "._TBLCATEGORIA." (idpadre,descripcion,autor,fecha1,nombre,iddisplay,validacion) VALUES
										(?,?,?,NOW(),?,?,? )");
				$result = $db->Execute($consulta, array
                (
                     $_POST['padre'], nl2br(strip_tags($_POST['comentario'])), strip_tags($_POST['nombreRespuesta']), substr($_POST['comentario'],0,30)." ...", 12, nl2br($validacion)
                )) or errorQuery(__LINE__, __FILE__) ; 
                // die();
			}
		}

		// if (isset($_POST['idRespuesta'])) {
		// 	$consulta = $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE idcategoria = ? AND activa != ? ");
		// 	$result  = $db->Execute($consulta, array($_POST['idRespuesta'], 0)) /* or errorQuery(__LINE__, __FILE__) */;

		// 	if ($result !== FALSE and $result->NumRows() > 0) {
		// 		$row				= $result->fields;
		// 		$tema['comentario'] = $row["descripcion"];
		// 		$tema['fecha']		= $row["fecha1"];
		// 		$tema['autor']		= $row["autor"];
		// 		$tema['id']			= $_POST['idRespuesta'];
		// 	}
		// 	$smarty -> assign('rotuloRespuesta',_ROT_FORO_RESPUESTA);
		// 	$smarty -> assign('rotuloNombre',_ROT_FORO_NOMBRE);
		// 	$smarty -> assign('tema',$tema);
		// 	$smarty -> assign('respuesta',"si");

		// } else { 
		$consulta = $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE idpadre = ? AND activa != ? ORDER BY fecha1 DESC");
		$result = $db->Execute($consulta, array($idcategoria, 0)) /* or errorQuery(__LINE__, __FILE__) */;
		if ($result !== FALSE and $result->NumRows() > 0) {


			while (!$result->EOF) {

				$row = $result->fields;
				settype($row, 'object');
				//Segundas Respuestas
				$consulta = $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE idpadre = ? AND activa != ? ORDER BY fecha1 DESC");
				$result2 = $db->Execute($consulta, array($row->idcategoria, 0)) /* or errorQuery(__LINE__, __FILE__) */;
				if ($result2 !== FALSE and $result2->NumRows() > 0){

					while (!$result2->EOF) {
						$row2 = $result2->fields;
						settype($row2, 'object');
						$subSec2['id']	 = $row2 -> idcategoria;
						$subSec2['nombre'] = $row2 -> descripcion;
						$subSec2['autor']  = $row2 -> autor;
						$subSec2['fecha']  = $row2 -> fecha1;
						$c_subSec2[]	   = $subSec2;
						$result2->MoveNext();
					}

				}
				$subSec['id']	 = $row -> idcategoria;
				$subSec['nombre'] = $row -> descripcion;
				$subSec['autor']  = $row -> autor;
				$subSec['fecha']  = $row -> fecha1;
				$subSec['hijos']  = isset($c_subSec2) ? $c_subSec2 : "";
				unset($c_subSec2);
				$c_subSec[] = $subSec;

				$result->MoveNext();
			}
			$smarty -> assign('subSec', $c_subSec);
		}
		// }
		
		$consulta = $db->prepare("Select * from "._TBLCATEGORIA." where idcategoria = ?");
		$res = $db->Execute($consulta, array($idcategoria)) /* or errorQuery(__LINE__, __FILE__) */;
	
	
		$delicious = "http://del.icio.us/post?url="._URL."index.php?idcategoria=".$res->fields['idcategoria']."&title=".str_replace(" ","+",$res->fields['nombre']);
		
		/* parametro que tenia antes la pagina web */
		
		/*$facebook = "http://www.facebook.com/sharer.php?u="._URL."index.php?idcategoria=".$res->fields['idcategoria']."&t=".str_replace(" ","+",$res->fields['nombre']);*/

		/*NUEVO PARAMETRO PARA LA URL BOTON ME GUSTA
		*/
		$facebook1 = "http://www.facebook.com/plugins/like.php?href="._URL."index.php?idcategoria=".$res->fields['idcategoria']."&t=".str_replace(" ","+",$res->fields['nombre']);
        
		/* Boton compartir en facebook */
		
		$share_facebook = _URL."index.php?idcategoria=".$res->fields['idcategoria']."&t=".str_replace(" ","+",$res->fields['nombre']);
		
		/* Creacion de boton para twitter */
		//$twitter = 'http://'._URL.'index.php?idcategoria='.$res->fields['idcategoria'].'&t='.str_replace(' ','+',$res->fields['nombre']);
		
		/* Asignacion variable categoria */
		$categoriaComp = $res->fields['idcategoria'];
        $twitter = _URL.'?idcategoria='.$categoriaComp;
        $text  = 'Comparte en:'; 			
		$digg = "http://digg.com/submit?phase=2&url="._URL."index.php?idcategoria=".$res->fields['idcategoria']."&t=".str_replace(" ","+",$res->fields['nombre']);
		$link_delicious = sprintf("<a href='%s' target='_blank'><img src='%sdelicious.jpg' alt='Delicious' /></a>",$delicious,_DIRIMAGES);
		/*vinculo antiguo de facebook*/
		
		/*$link_facebook = sprintf("<a href='%s' target='_blank'><img src='%sfacebook.jpg'></a>",$facebook,_DIRIMAGES);*/
		
		/* PARA BOTON  ME GUSTA FACEBOOK*/
        $link_sharefb = "<a name='fb_share' type='button_count' share_url='".$share_facebook."' href='http://www.facebook.com/sharer.php'>Compartir</a><script src='http://static.ak.fbcdn.net/connect.php/js/FB.Share' type='text/javascript'></script>";			
        
		/*
		$link_facebook = "<div data-href='".$facebook1."' data-send='true' data-layout='button_count' data-width='30' data-show-faces='false' data-font='arial' data-colorscheme='dark'></div>";
		*/
		
		$link_facebook =
		"<script type=\"text/javascript\">
			function goclicky(meh)
            {
              var x = screen.width/2 - 700/2;
              var y = screen.height/2 - 450/2;
              window.open(meh, 'facebook','height=485,width=700,left='+x+',top='+y);
            }
        </script>
		
        <a style=\"text-decoration:none\"onclick=\"goclicky('https://www.facebook.com/sharer/sharer.php?u=".$share_facebook."'); return false;\" href=\"#\">Me gusta</a>";
		
		/* twitter ejercito */
        $link_twitter  = "<a href='https://twitter.com/share' target='_blank' data-url='".$twitter."' data-lang='es' data-related='COL_EJERCITO' data-hashtags='COL_EJERCITO' data-dnt='true' data-via='COL_EJERCITO' data-lang='es'>Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='//platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','twitter-wjs');</script>";		
		
		/* twitter ingenieros */
		$link_twitter_ingenieros ="<a href='http://twitter.com/share' class='twitter-share-button' data-url='".$twitter."' data-via='ING_MILITARES' data-count='none' data-lang='es'>Tweet</a><script type='text/javascript' src='http://platform.twitter.com/widgets.js'></script>";
		
		/*$google_mas = "<div class='g-plusone' data-annotation='inline' data-width='120'></div><script type='text/javascript'>window.___gcfg = {lang: 'es-419'};(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();</script>";*/
		$google_mas = "<script type='text/javascript'>
		                    function goclicky(meh){
							       var x = screen.width/2 - 700/2;
								   var y = screen.height/2 - 450/2;
								   window.open(meh, 'google+','height=485,width=700,left='+x+',top='+y);
								}
							</script>
		                    <a style=\"text-decoration:none\" onclick=\"goclicky('https://plus.google.com/share?url=".$twitter."'); return false;\" href=\"#\">Compartir</a>";
					   
		
		
		$link_digg = sprintf("<a href='%s' target='_blank'><img src='%sdigg.jpg' alt='Digg' /></a>",$digg,_DIRIMAGES);
        
		$smarty -> assign('twitter_esing', $link_twitter_ingenieros);
		$smarty -> assign('delicious', $link_delicious);
		$smarty -> assign('facebook', $link_facebook);
		$smarty -> assign('texto_compartir', $text);
		$smarty -> assign('facebook_share', $link_sharefb);
		$smarty -> assign('twitter', $link_twitter);
		$smarty -> assign('digg', $link_digg);
		$smarty -> assign('google', $google_mas);
		$smarty -> assign('idcategoria', $idcategoria);	
		$smarty->assign('root', $sroot);
		$smarty -> assign('infoUsuario', isset($_SESSION['info_usuario']) ? $_SESSION['info_usuario'] : '');

		return $smarty -> fetch('tpl_default_noticias.html');
	}
	/**
	 * FuncionesDisplay :: TemplateHTML
	 * Template: Default
	 * Archivo Destino: tpl_default.html
	 * @param integer $idcategoria
	 * @return
	 **/
	function TemplateHTML($idcategoria){
		return FuncionesDisplay::TemplateCategoria($idcategoria,true);
	}
	/**
	 * FuncionesDisplay :: cargarInfoSubCategoria()
	 *
	 * @param int $idcategoria
	 * @param int $plus
	 * @return resource
	 **/
	function cargarInfoSubCategoria($idcategoria, &$plus) {

        global $db;	/** @see variables.php */
		/**** Verificacion de que se envió un idcategoria ****/
		if (!empty($idcategoria)){

			$infoCategoriaActual = FuncionesDisplay::cargarSesionPaginaActual($idcategoria);

			global $db;

			$inf = $infoCategoriaActual['inf'];

			/**** Ordenamiento de los elementos ****/
			$orden_tmp = Funciones::BusquedaRecursiva($idcategoria, "orden_sub");
			$pag = Funciones::BusquedaRecursiva($idcategoria, "paginas_sub");
			$tmp = Funciones::BusquedaRecursiva($idcategoria, "asc_sub");
			switch ($tmp) {
				case 1:	$asc_tmp = "desc";break;
				case 2:	$asc_tmp = "asc";break;
			}

			/**** Filtro por fecha ****/
			if (isset($infoCategoriaActual['filtro_fecha']) && $infoCategoriaActual['filtro_fecha'] <> 0){
				$plus = sprintf(" and fecha1 >= '%s-01' and fecha1 <= '%s-31' ",$infoCategoriaActual['filtro_fecha'],$infoCategoriaActual['filtro_fecha']);
			} elseif (isset($infoCategoriaActual['filtro_fecha']) && $infoCategoriaActual['filtro_fecha'] == 0) {
				$plus = "";
			} else {
				$plus = "";
			}

			/**** Filtro por Autor ****/
			if (isset($infoCategoriaActual["filtro_autor"]) and !empty($infoCategoriaActual["filtro_autor"])) {
				$plus .= " and autor = '".$infoCategoriaActual["filtro_autor"]."' ";
			}

			/**** Filtro por Antetitulo ****/
			if (isset($infoCategoriaActual["filtro_antetitulo"]) and !empty($infoCategoriaActual["filtro_antetitulo"])) {
				$plus .= " and antetitulo = '".urldecode($infoCategoriaActual["filtro_antetitulo"])."' ";
			}

			/**** Filtro por Búsqueda ****/
			if (isset($infoCategoriaActual["filtro_buscar"]) and !empty($infoCategoriaActual["filtro_buscar"])) {
				$busqueda = trim($infoCategoriaActual["filtro_buscar"]);
				if(!empty($busqueda)) {
					$plus .= " AND (entradilla LIKE ('%".$busqueda."%') "
					." OR descripcion LIKE ('%".$busqueda."%') "
					." OR nombre LIKE ('%".$busqueda."%')) ";

				}
			}


			/**** Paginación ****/
            // Cambio # 2
			$query = $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE activa != ? AND idpadre = ".$idcategoria." ".$plus." ORDER BY ".$orden_tmp." ".$asc_tmp);
			
			$result = $db->Execute($query,array(0));
		
			/*$query = sprintf("SELECT * FROM %s WHERE activa != 0 AND idpadre = %s %s ORDER BY %s %s", _TBLCATEGORIA, $idcategoria,$plus, $orden_tmp, $asc_tmp);
			
			$result = $db->Execute($query);*/

			/**
		 	 * Creamos el objeto de Paginacion
		 	 */
			require_once(_DIRLIB_ADMIN."Pager.class.php");
			$d = new Pager($result, $pag, isset($infoCategoriaActual['pag']) ? $infoCategoriaActual['pag'] : 1);

			$maximo = $d->numRows;

			if ($maximo == 0) {
				return FALSE;
			} else {
				//return $result;
				return $d;
			}
			$db->Execute($query) /* or errorQuery(__LINE__, __FILE__) */;
		} else {
			return FALSE;
		}
	}

	/***************************/
	//Template:DisplaySubCategorias
	//Archivo Destino:
	//tpl_subMenuResumen
	//tpl_subMenuLista
	//tpl_subMenuContenido
	/***************************/
    
	function DisplaySubCategorias($idcategoria=0, $tplFile = 'tpl_subMenuLista') {

		global $db; /** @see variables.php */

		$smarty = new Smarty_Plantilla;

		if ($idcategoria != 0){

			$result = FuncionesDisplay::cargarInfoSubCategoria($idcategoria, $plus);

			if ($result !== FALSE and $result->numRows > 0){
				$categorias = array();

				while (!$result->EOF){
					$row = $result->fields;

					$categoria = array();
					$categoria['vinculo'] = sprintf("index.php?idcategoria=%s", $row["idcategoria"]);
					$categoria['idcategoria'] = $row["idcategoria"];
					$categoria['nombre'] = $row["nombre"];
					$categoria['antetitulo'] = $row["antetitulo"];
					$categoria['subtitulo'] = trim($row["subtitulo"]);
					$categoria['entradilla'] = stripslashes(nl2br(trim($row["entradilla"])));
					$categoria['descripcion'] = stripslashes(nl2br(trim($row["descripcion"])));
					$categoria['fecha1'] = ($row["fecha1"] != '0000-00-00')?$row["fecha1"]:"";
					if ($row["imagen"] && is_file(_DIRIMAGES_USER . $row["imagen"])){
						$categoria['imagen'] = $row["imagen"];
					}
					$categorias[] = $categoria;

					unset($categoria);

					$result->MoveNext();
				}
			} else {return "";}

			if(isset($categorias) and sizeof($categorias) > 0){
				$smarty -> assign('subMenu', $categorias);
			}

			$smarty->assign('web_url'    				, _URL);
			$smarty -> assign('verMas', Funciones::Navegacion($idcategoria, $result));

			return $smarty -> fetch($tplFile.'.html');
		}
	}
	/**
	 * DisplayHomeGenerico
	 * Despliegue del Home Generico
	 * @param integer $idcategoria
	 * @return
	 **/
	function DisplayHomeGenerico($idcategoria = 0) {

		global $db;	/** @see variables.php */

		$smarty = new Smarty_Plantilla;
        
        // Cambio # 3
		$query = $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE activa != ? AND idcategoria = ?");
		$result = $db->Execute($query, array(0, $idcategoria)) /* or errorQuery(__LINE__, __FILE__) */;

		if ($result->NumRows() > 0) {
			$d = $result->fields;
			$contenido = $d["descripcion"];

			/**
			 * Limpiando contenido
			 **/
			$contenido = str_replace(' ', '', $contenido);
			$contenido = explode(',', $contenido);
			$arraySecciones = array();

			while(list($k, $seccionActual) = each($contenido)) {

				$seccion = explode('#', $seccionActual);
				$parametros	= count($seccion);
				$seccionBuscar = $seccion[0];

				$cantidad	= 3;
				$conresumen = 1;

				switch ($parametros){
					case 2 :
						$cantidad	= $seccion[1];
						break;
					case 3 :
						$conresumen	= $seccion[2];
						$cantidad	= $seccion[1];
						break;
				}

				/**
				 * Buscando los hijos de la seccion elegida
				 **/
				$queryHijos = sprintf("SELECT * FROM %s WHERE activa != 0 AND idpadre = '%s' ORDER BY fecha2 DESC" , _TBLCATEGORIA , $seccionBuscar);
				$resultHijos = $db->SelectLimit($queryHijos, $cantidad) /* or errorQuery(__LINE__, __FILE__) */;

				if ($resultHijos->NumRows() > 0) {

					/**
					 *  Buscando info de la seccion elegida
					 **/
                    
                    // Cambio # 4
					$querySeccion = $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE activa != ? AND idcategoria = ?");
					$resultSeccion = $db->Execute($querySeccion, array(0, $seccionBuscar)) /* or errorQuery(__LINE__, __FILE__) */;
					$dSeccion = $resultSeccion->fields;

					$arraySeccionActual = $dSeccion;
					$arraySeccionActual['cantidad'] = $cantidad - 1;
					$arraySeccionActual['conresumen'] = $conresumen < $cantidad ? $conresumen : $cantidad;
					$arraySeccionActual['sinresumen'] = $resultHijos->NumRows() - $arraySeccionActual['conresumen'];

					/**
					 * Sacando la informacion de los hijos
					 **/
					$arrayhijos = array();

					while(!$resultHijos->EOF) {
						$dHijos = $resultHijos->fields;

						$auxHijos = array();
						$auxHijos['idcategoria'] = $dHijos['idcategoria'];
						$auxHijos['nombre'] = $dHijos['nombre'];
						$auxHijos['resumen'] = stripslashes($dHijos['entradilla']);
						$auxHijos['contenido'] = stripslashes($dHijos['descripcion']);
						$auxHijos['imagen'] = $dHijos['imagen'];
						$auxHijos['autor'] = $dHijos['autor'];
						$auxHijos['fecha'] = $dHijos['fecha1'];
						$auxHijos['subtitulo'] = $dHijos['subtitulo'];
						array_push($arrayhijos, $auxHijos);

						$resultHijos->MoveNext();
					}

					$arraySeccionActual['hijos'] = $arrayhijos;
					array_push($arraySecciones, $arraySeccionActual);
				}
			}
			$smarty->assign('secciones', $arraySecciones);
			$smarty->assign('resumen', stripslashes($d["entradilla"]));
		}
		return $smarty -> fetch('tpl_home_generico.html');
	}
	/**
	 * DisplaySubMenuPrimerNivel
	 *
	 * @return
	 **/
	function DisplaySubMenuPrimerNivel($idcategoria=0){

		global $db;	/** @see variables.php */

		$smarty = new Smarty_Plantilla;

		if (!empty($idcategoria)) {

			$phpself = basename($_SERVER['PHP_SELF']);
			$result = FuncionesDisplay::cargarInfoSubCategoria($idcategoria, $plus);

			if ($result !== FALSE){

				while (!$result->EOF){
					$row  = $result->fields;

					$categoria['vinculo'] = sprintf("%s?idcategoria=%s", $phpself, $row["idcategoria"]);
					$categoria['nombre'] = $row["nombre"];
					$categoria['antetitulo'] = $row["antetitulo"];
					$categoria['entradilla'] = stripslashes(nl2br($row["entradilla"]));
					$categoria['imagen'] = $row["imagen"];
					$categoria['fecha1'] = ($row["fecha1"] != '0000-00-00')?$row["fecha1"]:"";

					if ($row["imagen"] && is_file(_DIRIMAGES_USER . "/" . $row["imagen"])){
						$ancho_deseado = 120;
						$alinea = "center";
						$ImageSize = GetImageSize(_DIRIMAGES_USER . "/" . $row["imagen"]);
						$alto1 = $ImageSize[1];
						$ancho1 = $ImageSize[0];
						$ancho = ($ancho1 > $ancho_deseado)?$ancho_deseado:$ancho1;
						$alto = $ancho * $alto1 / $ancho1;
						$c_imagen = sprintf("<img src=%s/%s width=%s height=%s border=0>",_DIRIMAGES_USER,$row["imagen"],floor($ancho),floor($alto));
					}
					if(isset($c_imagen) && trim($c_imagen) != ""){
						$categoria['imagen'] = $c_imagen;
						$categoria['ancho_imagen'] = floor($ancho);
					}
					$categorias[] = $categoria;
					$c_imagen = "";

					$result->MoveNext();
				}

			} else {
				return "";
			}

			if(isset($categorias)){
				$smarty -> assign('subMenu', $categorias);
			}

			$smarty -> assign('verMas', Funciones::Navegacion($idcategoria, $result));
			return $smarty -> fetch('tpl_subMenuPrimerNivel.html');
		}
	}
    /**
 * FuncionesDisplay :: DisplaySubMenuGaleriaMulti
 * Template Igual que la Galeria pero con el template para todo tipo de medio
 * @param
 * @return
*/ 
    function DisplaySubMenuGaleriaMulti($idcategoria=0) {
global $db; /** @see variables.php */

$smarty = new Smarty_Plantilla;
$categorias = array();

$jpg = array(255, 216, 255); //ff d8 ff
$png = array(137, 80, 78, 71, 13, 10, 26, 10); //89 50 4e 47 d a 1a a
$tif = array(73, 32, 73); // 49 20 49
$gif1 = array(71, 73, 70, 56, 55, 97); //47 49 46 38 37 61
$gif2 = array(71, 73, 70, 56, 57, 97); //47 49 46 38 39 61
$flv = array(70, 76, 86); //46 4c 56
$mp3 = array(255, 250); //ff fa

//los avi no los deja subir, aramirez 19-01-2010, original 52 49 46 46 xx xx xx xx 41 56 49 20 4C 49 53 54
//$avi1 = array(0x52, 0x49, 0x46, 0x46);
//$avi2 = array(0x41, 0x56, 0x49, 0x20, 0x4c, 0x49, 0x53, 0x54);

$flgimage = 0;
$flgaudio = 0;
$flgvideo = 0;
if ($idcategoria > 0)
{
$result = FuncionesDisplay::cargarInfoSubCategoria($idcategoria, $plus);
if ($result !== FALSE and $result->numRows > 0)
{
$max_height = 0;
while (!$result->EOF)
{
$row = $result->fields;

if(($row['descripcion'] != '' && is_file(_DIRRECURSOS_USER . $row['descripcion'])) || ($row['imagen'] != '' && is_file(_DIRIMAGES_USER . $row['imagen'])))
{
if($row['descripcion'] != '')
{
$file = _DIRRECURSOS_USER . $row['descripcion'];
}
elseif($row['imagen'] != '')
{
$file = _DIRIMAGES_USER . $row['imagen'];
}
if($file != '')
{
$byteArr = array();
$fhandle = fopen($file, "rb");
$cont = 0;
while(!feof($fhandle) && $cont <= 8)
{
$data = fread($fhandle, 1);
array_push($byteArr, ord($data));
$cont++;
}
fclose($fhandle);
$magicNumber=chr($byteArr[0]).chr($byteArr[1]).chr($byteArr[2]);

if( count(array_intersect_assoc($byteArr,$jpg)) == count($jpg)   ||
	 count(array_intersect_assoc($byteArr,$png)) == count($png)   ||
	 count(array_intersect_assoc($byteArr,$tif)) == count($tif)   ||
	 count(array_intersect_assoc($byteArr,$gif1)) == count($gif1) ||
	 count(array_intersect_assoc($byteArr,$gif2)) == count($gif2))
{
$row['selector'] = 1;
$flgimage = 1;
}

//MP3
if(count(array_intersect_assoc($byteArr,$mp3)) == count($mp3)){
  $row['selector'] = 2;
  $flgaudio = 1;
}

//ID3
if($magicNumber=="ID3"){
  $row['selector'] = 2;
  $flgaudio = 1;
}

if(count(array_intersect_assoc($byteArr,$flv)) == count($flv)){
  $row['selector'] = 3;
  $flgvideo = 1;
}

if ($row['selector'] == 1 && is_file($file))
{
$row['resumen'] = $row['entradilla'];
$ancho_deseado = 100;
$ImageSize = GetImageSize($file);
$alto1 = $ImageSize[1];
$ancho1 = $ImageSize[0];
$ancho = ($ancho1 > $ancho_deseado)?$ancho_deseado:$ancho1;
$alto = $ancho * $alto1 / $ancho1;
$alto > $max_height ? $max_height = $alto : null;
$row['i_ancho']= $ancho1;
$row['i_alto']= $alto1;
$row['ancho']= $ancho;
$row['alto']= $alto;
}

$row['archivo'] = $file;
}
else
{
$row['selector'] = 0;
}

array_push($categorias, $row);
}
$result->MoveNext();
}
}
else
{
return "";
}
if(isset($categorias))
{
//aca se sabe el tamaqo de la tabla
$categorias = array_chunk($categorias, 4);
$smarty -> assign('subMenu', $categorias);
}
$smarty -> assign('verMas', Funciones::Navegacion($idcategoria, $result));
$smarty->assign('flgimage', $flgimage);
$smarty->assign('flgaudio', $flgaudio);
$smarty->assign('flgvideo', $flgvideo);

return $smarty -> fetch("tpl_subMenuGaleriaMulti.html");
}
}
	/**
	 * FuncionesDisplay :: DisplaySubMenuGaleriaAudio
	 * Template Igual que la Galeria pero con el template para audio
	 * @param
	 * @return
	 */
	function DisplaySubMenuGaleriaAudio($idcategoria=0) {

		global $db; /** @see variables.php */
		$smarty = new Smarty_Plantilla;
		$categorias = array();

		if ($idcategoria > 0){
			$result = FuncionesDisplay::cargarInfoSubCategoria($idcategoria, $plus);

			if ($result !== FALSE and $result->numRows > 0){
				$max_height = 0;

				while (!$result->EOF){

					$row = $result->fields;
					if ($row['descripcion'] && is_file(_DIRRECURSOS_USER . $row['descripcion'])) {
						array_push($categorias, $row);
					}

					$result->MoveNext();
				}

			} else {
				return "";
			}

			if(isset($categorias)){
				$smarty -> assign('subMenu', $categorias);
			}

			$smarty -> assign('verMas', Funciones::Navegacion($idcategoria, $result));
			return $smarty -> fetch("tpl_subMenuGaleriaAudio.html");
		}
	}
	/*  
	 *  FuncionesDisplay :: DisplaySubMenuPublicaciones
	 *  Template que nos permite darle un formato especial a la seccion de publicaiones de Ejército
     *	@param
	 *  @return
	**/
	function DisplaySubMenuPublicaciones($idcategoria=0){
	
	   
	    global $db; /** @see variables.php */
		$smarty = new Smarty_Plantilla;
		$categorias = array();

		if ($idcategoria > 0){
			$result = FuncionesDisplay::cargarInfoSubCategoria($idcategoria, $plus);

			if ($result !== FALSE and $result->numRows > 0){
				$max_height = 0;

				while (!$result->EOF){

					$row = $result->fields;
					if ($row['descripcion']) { /*  && is_file(_DIRRECURSOS_USER . $row['descripcion'])   */
						array_push($categorias, $row);
					}

					$result->MoveNext();
				}

			} else {
				return "";
			}

			if(isset($categorias)){
				$smarty -> assign('subMenu', $categorias);
			}

			$smarty -> assign('verMas', Funciones::Navegacion($idcategoria, $result));
			return $smarty -> fetch("tpl_visualizacion_publicaciones.html");
		}
	
	}	
	/*  
	 *  FuncionesDisplay :: DisplaySubMenuVistaGaleria
	 *  Template que nos permite darle un formato especial a las fotogrfias cargadas en el portal web
     *	@param
	 *  @return
	**/
	function DisplaySubMenuVistaGaleria($idcategoria=0, $template = 'tpl_SubMenuVistaGaleria.html'){
	
	    global $db; /** @see variables.php */
		$smarty = new Smarty_Plantilla;
		$numColumnas = "3";
		$categorias = array();
		$display_sub = 19;

		if ($idcategoria > 0){
			$result = FuncionesDisplay::cargarInfoSubCategoria($idcategoria, $plus);

			if ($result !== FALSE and $result->numRows > 0){
				$max_height = 0;

				while (!$result->EOF){
					$row = $result->fields;

					if ($row['imagen'] && is_file(_DIRIMAGES_USER . $row['imagen'])) {
						$categoria['idcategoria'] = $row['idcategoria'];
						$categoria['nombre'] = $row["nombre"];
						$categoria['resumen'] = $row["descripcion"];

						$ancho_deseado = 100;
						$ImageSize = GetImageSize(_DIRIMAGES_USER . $row['imagen']);
						$alto1 = $ImageSize[1];
						$ancho1 = $ImageSize[0];
						$ancho = ($ancho1 > $ancho_deseado)?$ancho_deseado:$ancho1;
						$alto = $ancho * $alto1 / $ancho1;
						$alto > $max_height ? $max_height = $alto : null;

						$categoria['imagen']	= $row['imagen'];
						$categoria['i_ancho']	= $ancho1;
						$categoria['i_alto']	= $alto1;
						$categoria['ancho']		= $ancho;
						$categoria['alto']		= $alto;
						array_push($categorias, $categoria);

					}

					$result->MoveNext();
				}

				$smarty -> assign('max_height', $max_height+20);
			} else {
				return "";
			}

			if(isset($categorias)){
				$smarty -> assign('subMenu', $categorias);
			}
			$smarty -> assign('anchoColumna', intval(100 / $numColumnas));
			$smarty -> assign('display_sub', $display_sub);
			$smarty -> assign('verMas', Funciones::Navegacion($idcategoria, $result));
			return $smarty -> fetch($template);
		}
		
	}
	/*  
	 *  FuncionesDisplay :: DisplaySubMenuInfografia
	 *  Template que nos permite darle un formato especial a fotografias que  corresponden a infografias de Ejército
     *	@param
	 *  @return
	**/
	function DisplaySubMenuInfografia($idcategoria=0){
	
		global $db; /** @see variables.php */
		$smarty = new Smarty_Plantilla;
		$categorias = array();

		if ($idcategoria > 0){
			$result = FuncionesDisplay::cargarInfoSubCategoria($idcategoria, $plus);

			if ($result !== FALSE and $result->numRows > 0){
				$max_height = 0;

				while (!$result->EOF){

					$row = $result->fields;
					if ($row['imagen']) { 
						array_push($categorias, $row);
					}

					$result->MoveNext();
				}

			} else {
				return "";
			}

			if(isset($categorias)){
				$smarty -> assign('subMenu', $categorias);
			}

			$smarty -> assign('verMas', Funciones::Navegacion($idcategoria, $result));
			return $smarty -> fetch("tpl_visualizacion_infografia.html");
		}
	
	}
	/*  
	 *  FuncionesDisplay :: DisplaySubMenuResumenColumnas
	 *  Template que nos permite darle un formato especial de la lista con resumen pero dividida en cuadros
     *	@param
	 *  @return
	**/
	function DisplaySubMenuResumenColumnas($idcategoria=0){
	
	   
	    global $db; /** @see variables.php */
		$smarty = new Smarty_Plantilla;
		$categorias = array();

		if ($idcategoria > 0){
			$result = FuncionesDisplay::cargarInfoSubCategoria($idcategoria, $plus);

			if ($result !== FALSE and $result->numRows > 0){
				$max_height = 0;

				while (!$result->EOF){

					$row = $result->fields;
					if ($row['nombre']) { /*  && is_file(_DIRRECURSOS_USER . $row['descripcion'])   */
						array_push($categorias, $row);
					}

					$result->MoveNext();
				}

			} else {
				return "";
			}

			if(isset($categorias)){
				$smarty -> assign('subMenu', $categorias);
			}

			$smarty -> assign('verMas', Funciones::Navegacion($idcategoria, $result));
			return $smarty -> fetch("tpl_subMenuResumenColumnas.html");
		}
	
	}
	/**
	 * FuncionesDisplay :: get_youtube_id
	 * Obtener el id de youtube limpio, sin importar si es iframe o url youtube
	 * el id puede usarse para plugins externos de galeria de video y para obtener el thumbnail
	 * @param
	 * @return
	 */
	function get_youtube_id($url)
	{
	    if (strpos( $url,"v=") !== false)
	    {
	        return substr($url, strpos($url, "v=") + 2, 11);
	    }
	    elseif(strpos( $url,"embed/") !== false)
	    {
	        return substr($url, strpos($url, "embed/") + 6, 11);
	    }

	}

	/**
	 * FuncionesDisplay :: DisplaySubMenuGaleriaVideo
	 * Template Igual que la Galeria pero con el template para video
	 * @param
	 * @return
	 */
	function DisplaySubMenuGaleriaVideo($idcategoria=0) {

		global $db; /** @see variables.php */

		$smarty = new Smarty_Plantilla;
		$categorias = array();

		if ($idcategoria > 0){
			$result = FuncionesDisplay::cargarInfoSubCategoria($idcategoria, $plus);

			if ($result !== FALSE and $result->numRows > 0){
				$max_height = 0;

				while (!$result->EOF){
					$row = $result->fields;
					$tipo=strtolower(end(explode('.',$row['descripcion'])));
					// fix the images for videos
					if( ( isset($row['imagen']) && trim($row['imagen'])!='' && !is_file(_DIRIMAGES_USER.$row['imagen']) ) || ( $tipo=='flv' && ( !isset($row['imagen']) || trim($row['imagen'])=='' ) ) ){
						$row['imagen'] = 'tools/microsThumb.php?w=550&src='._DIRRECURSOS.'images/video_placeholder.png';
					}elseif( isset($row['imagen']) && trim($row['imagen'])!='' && is_file(_DIRIMAGES_USER.$row['imagen']) ) {
						$row['imagen'] = 'tools/microsThumb.php?w=550&src='._DIRIMAGES_USER.$row['imagen'];
					}else{
						$row['imagen'] = '';
					}
					if( $tipo == 'mp4'|| $tipo == 'flv' ){
						$row['tipo']=$tipo;
						$row['descripcion']=strip_tags($row['descripcion']);
					}else{
						$row['tipo']='youtube';
						// obtener el id-youtube del video, limpio sin otras variables GET
						$row['idvideo']=FuncionesDisplay::get_youtube_id($row['descripcion']);
					}
					array_push($categorias, $row);
					unset($row['idvideo'],$row['tipo']);
					$result->MoveNext();
				}
			} else {
				return "";
			}

			if(isset($categorias)){
				$smarty -> assign('subMenu', $categorias);
			}
			$smarty -> assign('verMas', Funciones::Navegacion($idcategoria, $result));
			return $smarty -> fetch("tpl_subMenuGaleriaVideo.html");
		}
	}
	/**
	 * Presenta una galería de imágenes
	 * @param int $idcategoria
	 * @param string $template Valor por defecto tpl_subMenuGaleria.html
	 * @return template
	 */
	function DisplaySubMenuGaleria($idcategoria=0, $template = 'tpl_subMenuGaleria.html') {

		global $db; /** @see variables.php */
		$smarty = new Smarty_Plantilla;
		$numColumnas = "3";
		$categorias = array();

		if ($idcategoria > 0){
			$result = FuncionesDisplay::cargarInfoSubCategoria($idcategoria, $plus);

			if ($result !== FALSE and $result->numRows > 0){
				$max_height = 0;

				while (!$result->EOF){
					$row = $result->fields;
					if ($row['imagen'] && is_file(_DIRIMAGES_USER . $row['imagen'])) {
						$categoria['idcategoria'] = $row['idcategoria'];
						$categoria['nombre'] = $row["nombre"];
						$categoria['resumen'] = $row["entradilla"];

						$ancho_deseado = 100;
						$ImageSize = GetImageSize(_DIRIMAGES_USER . $row['imagen']);
						$alto1 = $ImageSize[1];
						$ancho1 = $ImageSize[0];
						$ancho = ($ancho1 > $ancho_deseado)?$ancho_deseado:$ancho1;
						$alto = $ancho * $alto1 / $ancho1;
						$alto > $max_height ? $max_height = $alto : null;

						$categoria['imagen']	= $row['imagen'];
						$categoria['i_ancho']	= $ancho1;
						$categoria['i_alto']	= $alto1;
						$categoria['ancho']		= $ancho;
						$categoria['alto']		= $alto;
						array_push($categorias, $categoria);

					}

					$result->MoveNext();
				}

				$smarty -> assign('max_height', $max_height+20);
			} else {
				return "";
			}

			if(isset($categorias)){
				$smarty -> assign('subMenu', $categorias);
			}
			$smarty -> assign('anchoColumna', intval(100 / $numColumnas));
			$smarty -> assign('verMas', Funciones::Navegacion($idcategoria, $result));
			return $smarty -> fetch($template);
		}
	}
	/**
	 * FuncionesDisplay :: TemplateNoticiaAvanzado
	 * @param int $idcategoria
	 * @return
	 */
	function TemplateNoticiaAvanzado($idcategoria){

		global $db;
		global $trazaCategoria;

		$smarty = new Smarty_Plantilla;
		$smarty -> assign('idcategoria', $idcategoria);


		// Verifying the CSRF Token
		// sólo si hacen una busqueda
		$is_secure_form=true;
		if(
			isset($_GET['filtro_fecha']) ||
			isset($_GET['filtro_autor']) ||
			isset($_GET['filtro_antetitulo']) ||
			isset($_GET['filtro_buscar'])
		){
		    $is_secure_form=Funciones::hash_equals($_SESSION['token'], $_REQUEST['token']);
			if(!$is_secure_form){
				$smarty -> assign('c_subtitulo', "Acceso incorrecto detectado.");/* Subtitulo */
			}
		}



		if (isset($trazaCategoria[$idcategoria]) and $trazaCategoria[$idcategoria]["activa"] == 1 && $is_secure_form) {

			$row = $trazaCategoria[$idcategoria];
			$smarty -> assign('c_antetitulo', $row["antetitulo"]);	/** Antetitulo */
			$smarty -> assign('c_titulo', $row["nombre"]);	/** Titulo */
			$smarty -> assign('c_subtitulo', $row["subtitulo"]);/* Subtitulo */
			$smarty -> assign('c_entradilla', stripslashes(nl2br($row["entradilla"])));	/* Resumen */
			$smarty -> assign('c_descripcion',  stripslashes(FuncionesInterfaz::ReemplazarMail(nl2br(trim($row["descripcion"])))) ); /* Contenido */
			$smarty -> assign('c_autor', $row["autor"]);	/* Autor */

			$fecha = trim(substr($row["fecha1"],0,10));
			$fecha = FuncionesInterfaz::datetotext($fecha);
			$smarty -> assign('c_fecha', $fecha);	/* Fecha */

			/**** Mostramos las Subcategorias ****/
			$c_submenu = Funciones::DisplaySubMenu($idcategoria,$row["iddisplay_sub"]);
			$smarty -> assign('c_submenu', $c_submenu);

			/* Herramientas */
			/****************************************
			El vínculo para subir, se crea cuando el contenido es muy largo (2000 caracteres por default).
			El vínculo para imprimir solo si existe contenido.
			El vínculo de cuéntele solo si existe contenido.
			****************************************/

			/* Subir */
			$c_subir = ((strlen($row["descripcion"]) > 2000) || strlen($c_submenu) > 2000)?sprintf("<a href='#top' title='Ir al inicio de esta página'><img src='%s/mini_subir.gif' alt='\"Ir al inicio de esta página\"' /></a>&nbsp;", _DIRIMAGES_AUX):"";
			$smarty -> assign('c_subir', trim($c_subir));

			/* Imprimir */
			$c_imprimir = ($idcategoria == 1 || (strlen(trim($row["descripcion"])) == 0 && strlen(trim($c_submenu)) == 0 && strlen(trim($row["entradilla"])) == 0)) ? "" : FuncionesInterfaz::Imprimir($idcategoria,'');
			$smarty -> assign('c_imprimir', trim($c_imprimir));

			/* Cuéntele */
			$c_cuentele = ($idcategoria == 1 || strlen(trim($row["descripcion"])) == 0)?"":FuncionesInterfaz::Cuentele($idcategoria);
			$smarty -> assign('c_cuentele',$c_cuentele);
		}

		/* Select para archivo historico
			Posibles opciones:
			1.Ultimos 7 días (Default)
			2.Ultimos 30 días
			3.Mes/Año

			Orden:
			1.Descendente (Default)
			2.Ascendente

			Registros por página:
			1.10(Default)
			2.25
			3.50
			4.Ilimitado
		*/
	
		if($is_secure_form){

			$infoCategoriaActual = FuncionesDisplay::cargarSesionPaginaActual($idcategoria);


			$smarty->assign('selectFecha', FuncionesDisplay::filtroFecha($idcategoria, $infoCategoriaActual));
			/**** Cargamos el filtro de autor ****/
			$smarty->assign('filtro_autor', FuncionesDisplay::filtroAutor($idcategoria));
			$smarty->assign('valor_filtro_autor', isset($infoCategoriaActual["filtro_autor"]) ? $infoCategoriaActual["filtro_autor"] : "");

			/**** Cargamos el filtro de antetitulo ****/
			$smarty->assign('filtro_antetitulo', FuncionesDisplay::filtroAntetitulo($idcategoria));
			$smarty->assign('valor_filtro_antetitulo', isset($infoCategoriaActual["filtro_antetitulo"]) ? $infoCategoriaActual["filtro_antetitulo"] : "");

			/**** Cargamos el filtro de busqueda ****/
			$smarty->assign('valor_filtro_busqueda', stripslashes(isset($infoCategoriaActual["filtro_buscar"]) ? trim($infoCategoriaActual["filtro_buscar"]) : ""));
		}

		/* Imagen */
		/* Verificamos que el archive exista físicamente */
		$img_tmp = _DIRIMAGES_USER . $row["imagen"];
		if ((file_exists($img_tmp) && is_file($img_tmp))){
			$l_imagen = sprintf("%s%s",_DIRIMAGES_USER,$row["imagen"]);
			$ancho1 = _IMGANCHOMEDIO;
			$ancho2 = _IMGANCHOMAXIMO;
			$ImageSize = GetImageSize($img_tmp);
			$alto0  = $ImageSize[1];
			$ancho0 = $ImageSize[0];
			if ($ancho0 <= $ancho1) {
				$alinea = _IMGALINEACION;
				$fwidth=$ancho0;
			} elseif ($ancho0 > $ancho1 && $ancho0 <= $ancho2) {
				$alinea = "center";
				$fwidth=$ancho0;
			} else {
				$alinea = "center";
				$fwidth=$ancho2;
			}
			$smarty -> assign('l_imagen'	,$l_imagen);
			$smarty -> assign('anchomedio'	,$ancho1);
			$smarty -> assign('alinea'		,$alinea);
			$smarty -> assign('fwidth'		,$fwidth);
			$smarty -> assign('width'		,$ancho0);
			$smarty -> assign('imagen'		,$row["imagen"]);
		}
		return $smarty -> fetch('tpl_noticia_avanzado.html');
	}
	/**
	 * cargarSesionPaginaActual()
	 *
	 * Guarda y carga algunas variables necesarias para el filtro
	 * @param int $idcategoria
	 * @return resource
	 **/
	function cargarSesionPaginaActual($idcategoria) {
		$categoriaActual = array();

		/**** Existe la sesion para los filtros? ****/
		if (!isset($_SESSION['filtros'])) {
			$_SESSION['filtros'] = array();
		}

		/**** Existe el campo de sesion para la pagina? ****/
		if (!isset($_SESSION['filtros'][$idcategoria])) {
			$_SESSION['filtros'][$idcategoria] = array();
		} else {
			$categoriaActual = $_SESSION['filtros'][$idcategoria];
		}

		/**** Guardamos la info sobre la paginación ****/
		if (!isset($categoriaActual['inf'])) {
			$categoriaActual['inf'] = 0;
		}
		$categoriaActual['inf'] = (isset($_GET['inf']))?$_GET['inf']: $categoriaActual['inf'];
		$categoriaActual['inf'] = (isset($_POST['inf']))?$_POST['inf']: $categoriaActual['inf'];

		if (!isset($categoriaActual['pag'])) {
			$categoriaActual['pag'] = 0;
		}

		$categoriaActual['pag'] = (isset($_GET['pag']))?$_GET['pag']: $categoriaActual['pag'];
		$categoriaActual['pag'] = (isset($_POST['pag']))?$_POST['pag']: $categoriaActual['pag'];

		if(isset($_GET['btn_filtro'])) {
			$categoriaActual['inf'] = 0;
			$categoriaActual['pag'] = 0;
		}

		/**** Guardamos la info sobre el filtro ****/
		if (isset($_GET['filtro_fecha'])) { $categoriaActual['filtro_fecha'] = $_GET['filtro_fecha']; }
		if (isset($_GET['filtro_autor'])) { $categoriaActual['filtro_autor'] = $_GET['filtro_autor']; }
		if (isset($_GET['filtro_antetitulo'])) { $categoriaActual['filtro_antetitulo'] = $_GET['filtro_antetitulo']; }
		if (isset($_GET['filtro_buscar'])) { $categoriaActual['filtro_buscar'] = $_GET['filtro_buscar']; }

		  //Recien el usuario entra al buscador este debe aparecer vacio
		  if( !(isset($_GET['filtro_buscar']) ||  isset($_GET['pag'])) ){
		    unset($categoriaActual['filtro_buscar']);
		    unset($categoriaActual['pag']);
		  }

		$_SESSION['filtros'][$idcategoria] = $categoriaActual;
		return $categoriaActual;
	}
	/**
	 * Funciones :: filtroFecha()
	 * Creacion de la lista del filtro de fecha
	 * @return
	 **/
	function filtroFecha($idcategoria = 1, $infoCategoriaActual = array()) {

		global $db; /** @see variables.php */

		$hoy = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$anioActual  = date("Y", $hoy);

		// Creación del drop down de fechas posibles
		// Se realizo filtro del campo fecha1 para que se visualizara solo las noticias a partir del año 2010 a la fecha
        // Cambio # 5
		$query	   = $db->prepare("SELECT MONTH(fecha1) as mes, YEAR(fecha1) AS anio FROM "._TBLCATEGORIA." WHERE idpadre = ? AND activa <> ? AND fecha1 <> '' AND fecha1 <> ? AND year(fecha1)>= ? GROUP BY mes,anio ORDER BY fecha1 DESC");
		$result	  = $db->Execute($query, array($idcategoria, 0, '0000-00-00', '2010')) /* or errorQuery(__LINE__, __FILE__) */;

		if (isset($infoCategoriaActual['filtro_fecha']))
		{
			$noti_mes_anio = $infoCategoriaActual['filtro_fecha'];
		}

		$selectMesAnio = sprintf("<option value='0' %s>-- %s --</option>",(isset($noti_mes_anio) && $noti_mes_anio == 0)?"selected":"", _ROT_FILTRO_FECHA);

		if ($result->NumRows() > 0)	{
			while (!$result->EOF)	{
				$row = $result->fields;
				$fecha		= $row['anio']."-".$row['mes'];
				switch ($row['mes']) {
					case 1:  $mes = _ROT_FILTRO_FECHA_ENERO;	  break;
					case 2:  $mes = _ROT_FILTRO_FECHA_FEBRERO;	break;
					case 3:  $mes = _ROT_FILTRO_FECHA_MARZO;	  break;
					case 4:  $mes = _ROT_FILTRO_FECHA_ABRIL;	  break;
					case 5:  $mes = _ROT_FILTRO_FECHA_MAYO;	   break;
					case 6:  $mes = _ROT_FILTRO_FECHA_JUNIO;	  break;
					case 7:  $mes = _ROT_FILTRO_FECHA_JULIO;	  break;
					case 8:  $mes = _ROT_FILTRO_FECHA_AGOSTO;	 break;
					case 9:  $mes = _ROT_FILTRO_FECHA_SEPTIEMBRE; break;
					case 10: $mes = _ROT_FILTRO_FECHA_OCTUBRE;	break;
					case 11: $mes = _ROT_FILTRO_FECHA_NOVIEMBRE;  break;
					case 12: $mes = _ROT_FILTRO_FECHA_DICIEMBRE;  break;
					default: $mes="";
				}
				$selectMesAnio .= sprintf("<option value='%s-%s' %s>%s / %s</option>",$row['anio'],$row['mes'],(isset($noti_mes_anio) && $noti_mes_anio == $fecha)?"selected":"",$mes,$row['anio']);
				$result->MoveNext();
			}
		}

		return ($mes<>"")?$selectMesAnio:"";		//En caso de que la consulta venga en blanco se envía la variable vacía

	}
	/**
	 * filtroAutor()
	 * Creacion de la lista del filtro de autor
	 * @return
	 **/
	function filtroAutor($idcategoria = 1) {

		global $db; /** @see variables.php */

		$autor = array();

		$q = "SELECT DISTINCT(autor) FROM "._TBLCATEGORIA
			." WHERE idpadre = ".$idcategoria
			." ORDER BY autor ASC";
		$r = $db->Execute($q) /* or errorQuery(__LINE__, __FILE__) */;

		while(!$r->EOF) {
			$d = $r->fields;
			if (!empty($d["autor"])) {
				//array_push($autor, htmlentities($d["autor"], ENT_QUOTES));
				array_push($autor, stripslashes(strip_tags($d["autor"])));
			}
			$r->MoveNext();
		}
		return $autor;
	}
	/**
	 * filtroAntetitulo()
	 *
	 * @return
	 **/
	function filtroAntetitulo($idcategoria = 1) {

		global $db; /** @see variables.php */

		$antetitulo = array();

		$q = "SELECT DISTINCT(antetitulo) FROM "._TBLCATEGORIA
			." WHERE idpadre = ".$idcategoria
			." ORDER BY antetitulo ASC";
		$r = $db->Execute($q) /* or errorQuery(__LINE__, __FILE__) */;

		while(!$r->EOF) {
			$d = $r->fields;
			if (!empty($d["antetitulo"])) {
				//array_push($antetitulo, htmlentities($d[$GLOBALS["_antetitulo"]], ENT_QUOTES));
				$antetitulo_url = urlencode($d["antetitulo"]);	/** Antetitulo URL Encoded */
				array_push($antetitulo, array($d["antetitulo"],$antetitulo_url));
			}
			$r->MoveNext();
		}
		return $antetitulo;
	}
	/**
	 * FuncionesDisplay :: TemplateInclude
	 * Incluye un archivo php para ejecutar una operacion especifica.
	 * @param int $idcategoria
	 */
	function TemplateInclude($idcategoria) {
		global $db; /** @see variables.php */
		global $trazaCategoria;	/** @see variables.php */
		$idcategoria = (0 == $idcategoria)?1:$idcategoria;
		if (isset($trazaCategoria[$idcategoria]) and $trazaCategoria[$idcategoria]["activa"] == 1){
			$dr1 = $trazaCategoria[$idcategoria];
			$smarty = new Smarty_Plantilla();
			$recurso = trim($dr1["descripcion"]);

			//valida la extencion para no ejecutar archivos distintos que php
			$ext = explode(".", $recurso);
			$total = count($ext);

			//verifica si el archivo se encuentra en recursos_user para no ejecutarlo
			$dir_recursos = stristr($recurso, 'recursos_user', true);

			if ((substr($recurso,0,8) == '_include' || substr($recurso,0,15) == '_administracion') && ($ext[$total-1] == 'php' || $ext[$total-1] == 'PHP') && ($dir_recursos == '')){
				$show = include(trim($dr1["descripcion"]));
			}
			$smarty->assign('c_descripcion', $show);
			$smarty->assign('c_titulo', $dr1["nombre"]);
			$smarty->assign('c_entradilla', stripslashes($dr1["entradilla"]));
			$smarty->assign('c_iddisplay_sub', $dr1['iddisplay_sub']);
			/* Consulta de sus SubCategorias */
			$smarty->assign('c_submenu', Funciones::DisplaySubMenu($idcategoria,$dr1["iddisplay_sub"]));
			
			if (strstr($_SERVER["HTTP_USER_AGENT"], "Firefox")) {
				$smarty->assign('navegador','F');
			}
			return $smarty->fetch('tpl_default.html');
		}
	}
	
	/**
	 * FuncionesDisplay :: TemplateInclude
	 * Incluye un archivo php para ejecutar una operacion especifica.
	 * @param int $idcategoria
	 */
	function TemplateUnidades($idcategoria) 
	{
		global $db; /** @see variables.php */
		global $trazaCategoria;	/** @see variables.php */
		$idcategoria = (0 == $idcategoria)?1:$idcategoria;
		if (isset($trazaCategoria[$idcategoria]) and $trazaCategoria[$idcategoria]["activa"] == 1){
			$dr1 = $trazaCategoria[$idcategoria];
			$smarty = new Smarty_Plantilla();
			$recurso = trim($dr1["descripcion"]);

			//valida la extencion para no ejecutar archivos distintos que php
			$ext = explode(".", $recurso);
			$total = count($ext);

			//verifica si el archivo se encuentra en recursos_user para no ejecutarlo
			$dir_recursos = stristr($recurso, 'recursos_user', true);

			if ((substr($recurso,0,8) == '_include' || substr($recurso,0,15) == '_administracion') && ($ext[$total-1] == 'php' || $ext[$total-1] == 'PHP') && ($dir_recursos == '')){
				$show = include(trim($dr1["descripcion"]));
			}
			$smarty->assign('c_descripcion', $show);
			$smarty->assign('c_titulo', $dr1["nombre"]);
			$smarty->assign('c_entradilla', stripslashes($dr1["entradilla"]));
			$smarty->assign('c_iddisplay_sub', $dr1['iddisplay_sub']);
			/* Consulta de sus SubCategorias */
			$smarty->assign('c_submenu', Funciones::DisplaySubMenu($idcategoria,$dr1["iddisplay_sub"]));
			
			if (strstr($_SERVER["HTTP_USER_AGENT"], "Firefox")) {
				$smarty->assign('navegador','F');
			}
			$idpadre = _SECCION_MAPA_REGIONALES;

			$query_get_puntos 		= sprintf("SELECT nombre, antetitulo, entradilla, subtitulo, descripcion from %s WHERE idpadre = %s AND activa != 0 ", _TBLCATEGORIA, $idpadre);

			$result_query_puntos 	= $db->GetAll($query_get_puntos);

			$array_obj_puntos = [];
			if($result_query_puntos != ""){
				foreach ($result_query_puntos as $obj) {
					$nombre 	= $obj["nombre"];
					$url 		= $obj["descripcion"];
					$exp_coo 	= explode(",", $obj["entradilla"]);
					$lat 		= $exp_coo[0];
					$lon 		= $exp_coo[1];
					$array_obj_puntos[] = 	array(
												'title' => $nombre
												,'lat' 	=> $lat
												,'lon' 	=> $lon
												,'url' 	=> $url
											);
				}
				$json_puntos = json_encode($array_obj_puntos);

			}else{
				$json_puntos = "empty";
			}

			$smarty->assign('json_puntos'    ,$json_puntos);
			$smarty->assign('web_url'    , _URL);
			return $smarty->fetch('tpl_unidades.html');
		}
	}
	
	function TemplateDirectorioTelefonico($idcategoria) 
	{
		global $db; /** @see variables.php */
		global $trazaCategoria;	/** @see variables.php */
		$idcategoria = (0 == $idcategoria)?1:$idcategoria;
		if (isset($trazaCategoria[$idcategoria]) and $trazaCategoria[$idcategoria]["activa"] == 1){
			$dr1 = $trazaCategoria[$idcategoria];
			$smarty = new Smarty_Plantilla();
			$recurso = trim($dr1["descripcion"]);

			//valida la extencion para no ejecutar archivos distintos que php
			$ext = explode(".", $recurso);
			$total = count($ext);

			//verifica si el archivo se encuentra en recursos_user para no ejecutarlo
			$dir_recursos = stristr($recurso, 'recursos_user', true);

			if ((substr($recurso,0,8) == '_include' || substr($recurso,0,15) == '_administracion') && ($ext[$total-1] == 'php' || $ext[$total-1] == 'PHP') && ($dir_recursos == '')){
				$show = include(trim($dr1["descripcion"]));
			}
			$smarty->assign('c_descripcion', $show);
			$smarty->assign('c_titulo', $dr1["nombre"]);
			$smarty->assign('c_entradilla', stripslashes($dr1["entradilla"]));
			$smarty->assign('c_iddisplay_sub', $dr1['iddisplay_sub']);
			/* Consulta de sus SubCategorias */
			$smarty->assign('c_submenu', Funciones::DisplaySubMenu($idcategoria,$dr1["iddisplay_sub"]));
			
			if (strstr($_SERVER["HTTP_USER_AGENT"], "Firefox")) {
				$smarty->assign('navegador','F');
			}
			
			$idpadre = _SECCION_DIRECTORIO_TELEFONICO;
			$query_get_puntos 		= sprintf("SELECT nombre, antetitulo, entradilla, subtitulo, imagen from %s WHERE idpadre = %s AND activa != 0 ", _TBLCATEGORIA, $idpadre);
			$result_query_puntos 	= $db->GetAll($query_get_puntos);

			$array_obj_puntos = [];

			if($result_query_puntos != "")
			{
				foreach ($result_query_puntos as $obj) 
				{
					$nombre 			= 		$obj["nombre"];
					$antetitulo 		= 		$obj["antetitulo"];
					$imagen	 		= 		$obj["imagen"];
					
					if  ($imagen == "")
					{
						$imagen	 		= 		"https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcTSAEZ5wP5Om4yyTPam1M0yJVTHXRJ6Z5IgqYg_iA1UlEQYjMRx0A";
					}
					else
					{
						$imagen	 		= 		"recursos_user/imagenes//".$obj["imagen"];
					}
					
					$contenido		=		explode(",", $obj["entradilla"]);
					$direccion 		= 		$contenido[0];
					$correo			= 		$contenido[1];
					$telefono			= 		$contenido[2];
					$celular			= 		$contenido[3];
					$otros				= 		$contenido[4];
							
					$array_obj_puntos[] = 	array
					(
						'nombre' 		=> $nombre,
						'antetitulo' 	=> $antetitulo,
						'direccion' 	=> $direccion,
						'correo' 		=> $correo,
						'telefono' 	=> $telefono,
						'celular'		=> $celular,
						'otros' 			=> $otros,
						'imagen' 		=> $imagen
					);
				}
			}
			else
			{
				$json_puntos = "empty";
			}

			for ($i = 0; $i < count($array_obj_puntos); $i++) 
			{  
				if ($i == 0)
				{
					$retornar = 
					'
						<div class="class_segun_tamano col-md-4 col-lg-4 col-sm-4 col-xs-4">
							<div class="contact-box">
								<div class="col-sm-4">
									<div class="text-center">
										<center><img alt="image" class="m-t-xs img-responsive" src="'.$array_obj_puntos[$i]["imagen"].'"><br>
										<div class="m-t-xs font-bold">'.$array_obj_puntos[$i]["antetitulo"].'<center></div>
									</div>
								</div>
								<div class="col-sm-8">
									<h3><strong>'.$array_obj_puntos[$i]["nombre"].'</strong></h3>
									<p><i class="fa fa-map-marker">'.$array_obj_puntos[$i]["direccion"].'</i></p>
									<address>
										<strong>'.$array_obj_puntos[$i]["correo"].'</strong><br>
										<abbr title="Phone"></abbr>'.$array_obj_puntos[$i]["telefono"].'<br>
										<abbr title="Phone"></abbr>'.$array_obj_puntos[$i]["celular"].'<br>
										'.$array_obj_puntos[$i]["otros"].'
									</address>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					';
				}
				else
				{
					$retornar .= 
					'
						<div class="class_segun_tamano col-md-4 col-lg-4 col-sm-4 col-xs-4">
							<div class="contact-box">
								<div class="col-sm-4">
									<div class="text-center">
										<center><img alt="image" class="m-t-xs img-responsive" src="'.$array_obj_puntos[$i]["imagen"].'"><br>
										<div class="m-t-xs font-bold">'.$array_obj_puntos[$i]["antetitulo"].'<center></div>
									</div>
								</div>
								<div class="col-sm-8">
									<h3><strong>'.$array_obj_puntos[$i]["nombre"].'</strong></h3>
									<p><i class="fa fa-map-marker">'.$array_obj_puntos[$i]["direccion"].'</i></p>
									<address>
										<strong>'.$array_obj_puntos[$i]["correo"].'</strong><br>
										<abbr title="Phone"></abbr>'.$array_obj_puntos[$i]["telefono"].'<br>
										<abbr title="Phone"></abbr>'.$array_obj_puntos[$i]["celular"].'<br>
										'.$array_obj_puntos[$i]["otros"].'
									</address>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					';
				}
			}

			$json_puntos = $retornar;
			$smarty->assign('json_puntos'    ,$json_puntos);			
			return $smarty->fetch('tpl_directorio_telefonico.html');
		}
	}
	
	function TemplateNoticiasPrincipal($idcategoria) 
	{
		global $db;
		global $trazaCategoria;

		$smarty = new Smarty_Plantilla;
		$smarty -> assign('idcategoria', $idcategoria);
		
		if (isset($trazaCategoria[$idcategoria]) and $trazaCategoria[$idcategoria]["activa"] == 1) 
		{
			$row = $trazaCategoria[$idcategoria];	
			$smarty -> assign('c_antetitulo'		, $row["antetitulo"]);	/** Antetitulo */
			$smarty -> assign('c_titulo'			, $row["nombre"]);	/** Titulo */
			$smarty -> assign('c_subtitulo'			, $row["subtitulo"]);/* Subtitulo */
			$smarty -> assign('c_entradilla'		, stripslashes(nl2br($row["entradilla"])));	/* Resumen */
			$smarty -> assign('c_descripcion'		, stripslashes(FuncionesInterfaz::ReemplazarMail(nl2br(trim($row["descripcion"])))) ); /* Contenido */
			$smarty -> assign('c_autor'			, $row["autor"]);	/* Autor */
			$fecha = trim(substr($row["fecha1"],0,10));
			$fecha = FuncionesInterfaz::datetotext($fecha);
			$smarty -> assign('c_fecha', $fecha);	/* Fecha */

			/**** Mostramos las Subcategorias ****/
			$c_submenu = Funciones::DisplaySubMenu($idcategoria,$row["iddisplay_sub"]);
			$smarty -> assign('c_submenu', $c_submenu);

			/* Herramientas */
			/****************************************
			El vínculo para subir, se crea cuando el contenido es muy largo (2000 caracteres por default).
			El vínculo para imprimir solo si existe contenido.
			El vínculo de cuéntele solo si existe contenido.
			****************************************/

			/* Subir */
			$c_subir = ((strlen($row["descripcion"]) > 2000) || strlen($c_submenu) > 2000)?sprintf("<a href='#top' title='Ir al inicio de esta página'><img src='%s/mini_subir.gif' alt='\"Ir al inicio de esta página\"' /></a>&nbsp;", _DIRIMAGES_AUX):"";
			$smarty -> assign('c_subir', trim($c_subir));

			/* Imprimir */
			$c_imprimir = ($idcategoria == 1 || (strlen(trim($row["descripcion"])) == 0 && strlen(trim($c_submenu)) == 0 && strlen(trim($row["entradilla"])) == 0)) ? "" : FuncionesInterfaz::Imprimir($idcategoria,'');
			$smarty -> assign('c_imprimir', trim($c_imprimir));

			/* Cuéntele */
			$c_cuentele = ($idcategoria == 1 || strlen(trim($row["descripcion"])) == 0)?"":FuncionesInterfaz::Cuentele($idcategoria);
			$smarty -> assign('c_cuentele',$c_cuentele);
		}

		/* Select para archivo historico
			Posibles opciones:
			1.Ultimos 7 días (Default)
			2.Ultimos 30 días
			3.Mes/Año

			Orden:
			1.Descendente (Default)
			2.Ascendente

			Registros por página:
			1.10(Default)
			2.25
			3.50
			4.Ilimitado
		*/
		$infoCategoriaActual = FuncionesDisplay::cargarSesionPaginaActual($idcategoria);

		$smarty->assign('selectFecha', FuncionesDisplay::filtroFecha($idcategoria, $infoCategoriaActual));
		/**** Cargamos el filtro de autor ****/
		$smarty->assign('filtro_autor', FuncionesDisplay::filtroAutor($idcategoria));
		$smarty->assign('valor_filtro_autor', isset($infoCategoriaActual["filtro_autor"]) ? $infoCategoriaActual["filtro_autor"] : "");

		/**** Cargamos el filtro de antetitulo ****/
		$smarty->assign('filtro_antetitulo', FuncionesDisplay::filtroAntetitulo($idcategoria));
		$smarty->assign('valor_filtro_antetitulo', isset($infoCategoriaActual["filtro_antetitulo"]) ? $infoCategoriaActual["filtro_antetitulo"] : "");

		/**** Cargamos el filtro de busqueda ****/
		$smarty->assign('valor_filtro_busqueda', stripslashes(isset($infoCategoriaActual["filtro_buscar"]) ? trim($infoCategoriaActual["filtro_buscar"]) : ""));

		/* Imagen */
		/* Verificamos que el archive exista físicamente */
		$img_tmp = _DIRIMAGES_USER . $row["imagen"];
		if ((file_exists($img_tmp) && is_file($img_tmp)))
		{
			$l_imagen = sprintf("%s%s",_DIRIMAGES_USER,$row["imagen"]);
			$ancho1 = _IMGANCHOMEDIO;
			$ancho2 = _IMGANCHOMAXIMO;
			$ImageSize = GetImageSize($img_tmp);
			$alto0  = $ImageSize[1];
			$ancho0 = $ImageSize[0];
			if ($ancho0 <= $ancho1) 
			{
				$alinea = _IMGALINEACION;
				$fwidth=$ancho0;
			} 
			elseif ($ancho0 > $ancho1 && $ancho0 <= $ancho2) 
			{
				$alinea = "center";
				$fwidth=$ancho0;
			} 
			else 
			{
				$alinea = "center";
				$fwidth=$ancho2;
			}
			$smarty -> assign('l_imagen'			,$l_imagen);
			$smarty -> assign('anchomedio'			,$ancho1);
			$smarty -> assign('alinea'				,$alinea);
			$smarty -> assign('fwidth'				,$fwidth);
			$smarty -> assign('width'				,$ancho0);
			$smarty -> assign('imagen'				,$row["imagen"]);
		}
		
		// Query de ultimas 8 noticias 

		$nombre_tabla = "categoria";
		$idpadre = 32;
		$query_ultimas_noticias		= sprintf("SELECT * from %s WHERE idpadre = %s AND activa != 0 order by idcategoria DESC limit 8", $nombre_tabla, $idpadre);
		$result_query_ultimas_noticias 	= $db->GetAll($query_ultimas_noticias);

		$array_obj_ultimas_noticias = array();
		if($result_query_ultimas_noticias != "")
		{
			setlocale(LC_TIME,"es_ES");
			foreach ($result_query_ultimas_noticias as $obj) 
			{
				$fecha 		= 	date("Y-m-d", strtotime($obj["fecha1"]));
				$fecha		=	explode("-",$fecha);  
				switch($fecha[1])  
				{  
					case "01":  
					$fecha[1]="ENE";  
					break;  
					case "02":  
					$fecha[1]="FEB";  
					break;  
					case "03":  
					$fecha[1]="MAR";  
					break;  
					case "04":  
					$fecha[1]="ABR";  
					break;  
					case "05":  
					$fecha[1]="MAY";  
					break;  
					case "06":  
					$fecha[1]="JUN";  
					break;  
					case "07":  
					$fecha[1]="JUL";  
					break;  
					case "08":  
					$fecha[1]="AGO";  
					break;  
					case "09":  
					$fecha[1]="SEP";  
					break;  
					case "10":  
					$fecha[1]="OCT";  
					break;  
					case "11":  
					$fecha[1]="NOV";  
					break;  
					case "12":  
					$fecha[1]="DIC";  
					break;  
					default:  
					$fecha[1]="";  
				} 
				
				setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
				
				$fecha_noticia 	= 	strtotime($obj["fecha1"]);  	
				$dia_total 		=	ucwords(strftime("%A", $fecha_noticia)); 
				$imagen 		= 	"recursos_user/imagenes//".$obj["imagen"];
				$subtitulo 		= 	utf8_encode($obj["subtitulo"]);
				$fecha1 		= 	utf8_encode(ucwords($dia_total)." ".date('H:i', strtotime($obj["fecha1"])));
				$nombre 		= 	utf8_encode($obj["nombre"]);
				$idcategoria 	= 	$obj["idcategoria"];
				$url_noticia 	= 	"index.php?idcategoria=".$obj["idcategoria"];
				$dia_noticia 	= 	date("d");
				$mes_noticia 	= 	$fecha[1];
				
				$array_obj_ultimas_noticias[] = 	
				array
				(
					'imagen' 		=> 	$imagen,
					'subtitulo' 	=> 	$subtitulo,
					'fecha1' 		=> 	$fecha1,
					'nombre' 		=> 	$nombre,
					'idcategoria' 	=> 	$idcategoria,
					'url_noticia' 	=> 	$url_noticia,
					'dia_noticia' 	=> 	$dia_noticia,
					'mes_noticia' 	=> 	$mes_noticia
				);
			}
			$json_array_noticias = json_encode($array_obj_ultimas_noticias);

		}
		else
		{
			$json_array_noticias = "empty";
		}
		
		// Query de ultimas 8 actualidad 

		$nombre_tabla = "categoria";
		$idpadre = 413;
		$query_ultimas_actualidad		= sprintf("SELECT * from %s WHERE idpadre = %s AND activa != 0 order by idcategoria DESC limit 8", $nombre_tabla, $idpadre);
		$result_query_ultimas_actualidad 	= $db->GetAll($query_ultimas_actualidad);

		$array_obj_ultimas_actualidad = array();
		if($result_query_ultimas_actualidad != "")
		{
			setlocale(LC_TIME,"es_ES");
			foreach ($result_query_ultimas_actualidad as $obj1) 
			{
				$fecha 		= 	date("Y-m-d", strtotime($obj1["fecha1"]));
				$fecha		=	explode("-",$fecha);  
				switch($fecha[1])  
				{  
					case "01":  
					$fecha[1]="ENE";  
					break;  
					case "02":  
					$fecha[1]="FEB";  
					break;  
					case "03":  
					$fecha[1]="MAR";  
					break;  
					case "04":  
					$fecha[1]="ABR";  
					break;  
					case "05":  
					$fecha[1]="MAY";  
					break;  
					case "06":  
					$fecha[1]="JUN";  
					break;  
					case "07":  
					$fecha[1]="JUL";  
					break;  
					case "08":  
					$fecha[1]="AGO";  
					break;  
					case "09":  
					$fecha[1]="SEP";  
					break;  
					case "10":  
					$fecha[1]="OCT";  
					break;  
					case "11":  
					$fecha[1]="NOV";  
					break;  
					case "12":  
					$fecha[1]="DIC";  
					break;  
					default:  
					$fecha[1]="";  
				} 
				
				setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
				
				$fecha_noticia 	= 	strtotime($obj1["fecha1"]);  	
				$dia_total 		=	ucwords(strftime("%A", $fecha_noticia)); 
				$imagen 		= 	"recursos_user/imagenes//".$obj1["imagen"];
				$subtitulo 		= 	utf8_encode($obj1["subtitulo"]);
				$fecha1 		= 	utf8_encode(ucwords($dia_total)." ".date('H:i', strtotime($obj1["fecha1"])));
				$nombre 		= 	utf8_encode($obj1["nombre"]);
				$idcategoria 	= 	$obj1["idcategoria"];
				$url_noticia 	= 	"index.php?idcategoria=".$obj1["idcategoria"];
				$dia_noticia 	= 	date("d");
				$mes_noticia 	= 	$fecha[1];
				
				$array_obj_ultimas_actualidad[] = 	
				array
				(
					'imagen' 		=> 	$imagen,
					'subtitulo' 	=> 	$subtitulo,
					'fecha1' 		=> 	$fecha1,
					'nombre' 		=> 	$nombre,
					'idcategoria' 	=> 	$idcategoria,
					'url_noticia' 	=> 	$url_noticia,
					'dia_noticia' 	=> 	$dia_noticia,
					'mes_noticia' 	=> 	$mes_noticia
				);
			}
			$json_array_actualidad = json_encode($array_obj_ultimas_actualidad);

		}
		else
		{
			$json_array_actualidad = "empty";
		}
		
		// Query de ultimas 8 Internacional 

		$nombre_tabla = "categoria";
		$idpadre = 399996;
		$query_ultimas_internacional		= sprintf("SELECT * from %s WHERE idpadre = %s AND activa != 0 order by idcategoria DESC limit 8", $nombre_tabla, $idpadre);
		$result_query_ultimas_internacional 	= $db->GetAll($query_ultimas_internacional);

		$array_obj_ultimas_internacional = array();
		if($result_query_ultimas_internacional != "")
		{
			setlocale(LC_TIME,"es_ES");
			foreach ($result_query_ultimas_internacional as $obj2) 
			{
				$fecha 		= 	date("Y-m-d", strtotime($obj2["fecha1"]));
				$fecha		=	explode("-",$fecha);  
				switch($fecha[1])  
				{  
					case "01":  
					$fecha[1]="ENE";  
					break;  
					case "02":  
					$fecha[1]="FEB";  
					break;  
					case "03":  
					$fecha[1]="MAR";  
					break;  
					case "04":  
					$fecha[1]="ABR";  
					break;  
					case "05":  
					$fecha[1]="MAY";  
					break;  
					case "06":  
					$fecha[1]="JUN";  
					break;  
					case "07":  
					$fecha[1]="JUL";  
					break;  
					case "08":  
					$fecha[1]="AGO";  
					break;  
					case "09":  
					$fecha[1]="SEP";  
					break;  
					case "10":  
					$fecha[1]="OCT";  
					break;  
					case "11":  
					$fecha[1]="NOV";  
					break;  
					case "12":  
					$fecha[1]="DIC";  
					break;  
					default:  
					$fecha[1]="";  
				} 
				
				setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
				
				$fecha_noticia 	= 	strtotime($obj2["fecha1"]);  	
				$dia_total 		=	ucwords(strftime("%A", $fecha_noticia)); 
				$imagen 		= 	"recursos_user/imagenes//".$obj2["imagen"];
				$subtitulo 		= 	utf8_encode($obj2["subtitulo"]);
				$fecha1 		= 	utf8_encode(ucwords($dia_total)." ".date('H:i', strtotime($obj2["fecha1"])));
				$nombre 		= 	utf8_encode($obj2["nombre"]);
				$idcategoria 	= 	$obj2["idcategoria"];
				$url_noticia 	= 	"index.php?idcategoria=".$obj2["idcategoria"];
				$dia_noticia 	= 	date("d"); 
				$mes_noticia 	= 	$fecha[1];
				
				$array_obj_ultimas_internacional[] = 	
				array
				(
					'imagen' 		=> 	$imagen,
					'subtitulo' 	=> 	$subtitulo,
					'fecha1' 		=> 	$fecha1,
					'nombre' 		=> 	$nombre,
					'idcategoria' 	=> 	$idcategoria,
					'url_noticia' 	=> 	$url_noticia,
					'dia_noticia' 	=> 	$dia_noticia,
					'mes_noticia' 	=> 	$mes_noticia
				);
			}
			$json_array_internacional = json_encode($array_obj_ultimas_internacional);

		}
		else
		{
			$json_array_internacional = "empty";
		}

		$smarty->assign('json_array_noticias'    	,$json_array_noticias);
		$smarty->assign('json_array_actualidad'    	,$json_array_actualidad);
		$smarty->assign('json_array_internacional'  ,$json_array_internacional);
		$smarty->assign('web_url'    				, _URL);
		
		return $smarty->fetch('tpl_noticia_principal.html');
	}
	
	/**
	 * FuncionesDisplay :: TemplateRedireccionInterna
	 * Redirecciona a una pagina que se encuentra en el sitio.
	 * @param integer $idcategoria
	 */
	function TemplateRedireccionInterna($idcategoria) {

		global $trazaCategoria;	/** @see variables.php */

		$idcategoria = (0 == $idcategoria)? 1 : $idcategoria;

		if (isset($trazaCategoria[$idcategoria]) and $trazaCategoria[$idcategoria]["activa"] == 1) {

			$row = $trazaCategoria[$idcategoria];

			//var_dump(is_numeric($row["descripcion"]));die();

			if(!empty($row["descripcion"])) {
				if(is_numeric($row["descripcion"])){
					headerLocation("index.php?idcategoria=".trim($row["descripcion"]));
				}
				else{
					headerLocation(_URL."/".trim($row["descripcion"]));
				}

			} else {
				headerLocation("index.php");
			}
		}
	}
	/**
	 * FuncionesDisplay :: TemplateRedireccionExterna
	 * Redirecciona a otra página que esta por fuera del sitio
	 * @param integer $idcategoria
	 */
	function TemplateRedireccionExterna($idcategoria){

		global $trazaCategoria;	/** @see variables.php */

		$idcategoria = (0 == $idcategoria)?1:$idcategoria;

		if (isset($trazaCategoria[$idcategoria]) and $trazaCategoria[$idcategoria]["activa"] == 1) {

			$row = $trazaCategoria[$idcategoria];
			echo ($row["descripcion"]);
			if (!empty($row["descripcion"])) {
				headerLocation($row["descripcion"]);
			} else {
				$smarty = new Smarty_Plantilla();
				$smarty->assign('c_titulo', $row["nombre"]);
				$advertencia = "La redirección está vacia, por favor reporte este error <a href=\"?idcategoria="._SCONTACTO."\".>aquí</a>.";
				$smarty->assign('c_entradilla', $advertencia);
				return $smarty->fetch('tpl_default.html');
			}
		}
	}
	/**
	 * FuncionesDisplay :: TemplateExternaConMarco
	 * Abre un marco con un cabezote propio de la pagina
	 * @param integer $idcategoria
	 * @return
	 */
	function TemplateExternaConMarco($idcategoria){
		headerLocation("tools/marco.php?idcategoria=".$idcategoria);
	}
	/**
	 * FuncionesDisplay :: TemplateAuxiliar
	 * @param integer $idcategoria
	 */
	function TemplateAuxiliar($idcategoria){

		global $infoCategoria; /** @see variables.php */
		global $db;	/** @see variables.php */

		$idcategoria = (0 == $idcategoria) ? 1 : $idcategoria;

		$phpself	 = basename($_SERVER['PHP_SELF']);
        
        // Cambio # 6
		$query	   = $db->prepare("SELECT idpadre FROM "._TBLCATEGORIA." WHERE activa != ? AND idcategoria = ? ORDER BY orden");
		$result	  = $db->Execute($query, array(0, $idcategoria)) /* or errorQuery(__LINE__, __FILE__) */;;

		if ($result->NumRows() > 0) {

			$padre = $result -> fields["idpadre"];
			//Redireccionar  al Padre
			headerLocation("$phpself?idcategoria=$padre");

		}
	}
	/**
	 * TEMPLATE FORO
	 *
	 * @param  int $idcategoria
	 * @return template
	 */
	function DisplaySubMenuForos($idcategoria) {
		global $db;	/** @see variables.php */

		$smarty		= new Smarty_Plantilla;
		$hoy		= mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$hoy		= date("Y-m-d", $hoy);
		$phpself	= basename($_SERVER['PHP_SELF'])."?idcategoria=".$idcategoria;

		//Ingreso de comentario --Respuesta
		if (isset($_POST['comentario'])&& $_POST['comentario']!="") {

			$validacion = md5(rand(0,9999999));

			//Verificación si el mensaje ya existe
            // Cambio # 7 
			$q2	= $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE idpadre= ? AND descripcion= ? AND autor=?");
			$r2	= $db->Execute($q2, array($_POST['padre'], nl2br(strip_tags($_POST['comentario'])), strip_tags($_POST['nombreRespuesta']))) /* or errorQuery(__LINE__, __FILE__) */;

			if($r2 !== FALSE and $r2->NumRows() == 0) {
				//Inserción del Nuevo Mensaje
                // Cambio # 8
				$consulta	= $db->prepare("INSERT INTO "._TBLCATEGORIA." (idpadre,descripcion,autor,fecha1,nombre,iddisplay,validacion) VALUES
										(?,?,?,NOW(),?,?,? )");
				$result = $db->Execute($consulta, array
                (
                     $_POST['padre'], nl2br(strip_tags($_POST['comentario'])), strip_tags($_POST['nombreRespuesta']), substr($_POST['comentario'],0,30)." ...", 12, nl2br($validacion)
                )) /* or errorQuery(__LINE__, __FILE__) */;
			}
		}


		//verifica si toca dar campo a respuestas
		if (isset($_POST['idRespuesta'])) {

            // Cambio # 9
			$consulta = $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE idcategoria = ? AND activa != ? ");
			$result  = $db->Execute($consulta, array($_POST['idRespuesta'], 0)) /* or errorQuery(__LINE__, __FILE__) */;

			if ($result !== FALSE and $result->NumRows() > 0) {
				$row				= $result->fields;
				$tema['comentario'] = $row["descripcion"];
				$tema['fecha']		= $row["fecha1"];
				$tema['autor']		= $row["autor"];
				$tema['id']			= $_POST['idRespuesta'];
			}
			$smarty -> assign('rotuloRespuesta',_ROT_FORO_RESPUESTA);
			$smarty -> assign('rotuloNombre',_ROT_FORO_NOMBRE);
			$smarty -> assign('tema',$tema);
			$smarty -> assign('respuesta',"si");

		} else {

			//Saca las respuestas
            // Cambio # 10
			$consulta = $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE idpadre = ? AND activa != ? ORDER BY fecha1 DESC");
			$result = $db->Execute($consulta, array($idcategoria, 0)) /* or errorQuery(__LINE__, __FILE__) */;
			if ($result !== FALSE and $result->NumRows() > 0) {


				while (!$result->EOF) {

					$row = $result->fields;
					settype($row, 'object');
					//Segundas Respuestas
                    // Cambio # 11
					$consulta = $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE idpadre = ? AND activa != ? ORDER BY fecha1 DESC");
					$result2 = $db->Execute($consulta, array($row->idcategoria, 0)) /* or errorQuery(__LINE__, __FILE__) */;
					if ($result2 !== FALSE and $result2->NumRows() > 0){

						while (!$result2->EOF) {
							$row2 = $result2->fields;
							settype($row2, 'object');
							$subSec2['id']	 = $row2 -> idcategoria;
							$subSec2['nombre'] = $row2 -> descripcion;
							$subSec2['autor']  = $row2 -> autor;
							$subSec2['fecha']  = $row2 -> fecha1;
							$c_subSec2[]	   = $subSec2;
							$result2->MoveNext();
						}

					}
					$subSec['id']	 = $row -> idcategoria;
					$subSec['nombre'] = $row -> descripcion;
					$subSec['autor']  = $row -> autor;
					$subSec['fecha']  = $row -> fecha1;
					$subSec['hijos']  = isset($c_subSec2) ? $c_subSec2 : "";
					unset($c_subSec2);
					$c_subSec[] = $subSec;

					$result->MoveNext();
				}
				$smarty -> assign('subSec', $c_subSec);
			}
		}

		$smarty -> assign('c_phpself'		,$phpself);
		$smarty -> assign('rotuloAutor'		,_ROT_FORO_AUTOR);
		$smarty -> assign('responder'		,"Responder");
		$smarty -> assign('idcategoria'		, $idcategoria );
		$smarty -> assign('infoUsuario'		, isset($_SESSION['info_usuario']) ? $_SESSION['info_usuario'] : '');
		return $smarty -> fetch('tpl_foro.html');

	}
	/**
	 * TEMPLATE ENCUESTA
	 *
	 * @param  int $idcategoria
	 * @return template
	 */
	function DisplaySubMenuEncuesta($idcategoria = 0) {
		global $db;
		global $trazaCategoria;

		$smarty		= new Smarty_Plantilla;
		$hoy		= mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$hoy		= date("Y-m-d", $hoy);
		$phpself	= basename($_SERVER['PHP_SELF'])."?idcategoria=".$idcategoria;

		if(isset($_POST['submit']) && $_POST['submit'] === "Ver resultado")
		{
			$smarty -> assign('votacion', '0');
		}
		elseif(!isset($_COOKIE['Micrositios'.$idcategoria]) || $_COOKIE['Micrositios'.$idcategoria]!=1)
		{
			$smarty -> assign('votacion', '1');
		}
		
		$guardeCookie = FALSE;

		//Suma de Datos
		if (isset($_POST['encuesta']) && !isset($_COOKIE['Micrositios'.$idcategoria])) {
			//sacar el contador
            // Cambio # 12
			$sql = $db->prepare("SELECT descripcion AS votos FROM "._TBLCATEGORIA." WHERE idcategoria=?");
			$result = $db->Execute($sql, array($_POST['encuesta'])) /* or errorQuery(__LINE__, __FILE__) */;

			if ($result->NumRows() > 0) {
				$row		 = $result->fields;
				$numeroVotos = $row["votos"];
			}

			//Sumar al contador
            // Cambio # 13
			$sql	= $db->prepare("UPDATE "._TBLCATEGORIA." SET descripcion=? WHERE idcategoria =?");
			$result = $db->Execute($sql, array($numeroVotos+1, $_POST['encuesta'])) /* or errorQuery(__LINE__, __FILE__) */;
			//crear Galleta
			setcookie("Micrositios".$idcategoria, 1, time()+10800, "/", "", TRUE, TRUE);
			$guardeCookie = TRUE;
		}

		if ( $guardeCookie === TRUE ) {
			headerLocation($_SERVER["PHP_SELF"]."?idcategoria=".$idcategoria);
		}

		//Saca las preguntas
        // Cambio # 14
		$consulta   = $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE idpadre = ? AND activa != ? ORDER BY orden");
		$totalVotos = 0;
		$result	 = $db->Execute($consulta, array($idcategoria, 0)) /* or errorQuery(__LINE__, __FILE__) */;

		if ($result->NumRows() > 0) {
			while (!$result->EOF) {
				$row = $result->fields;
				$subSec['id']		= $row['idcategoria'];
				$subSec['nombre']		= $row['nombre'];
				$subSec['contenido']	= stripslashes(sprintf("%d",$row['descripcion']));
				$totalVotos				+= $subSec['contenido'];
				$c_subSec[]				= $subSec;


				$result->MoveNext();
			}
		}

		$smarty -> assign('totalVotos'		,$totalVotos);

		if($totalVotos == 0)
			$totalVotos =1;

		//Calculo %

		$xmlEncuesta = "<graph caption='".$trazaCategoria[$idcategoria]['nombre']."' subCaption='".$totalVotos." voto(s) en total' xaxisname='Decisión' yaxisname='Porcentaje' numdivlines='3'>";
		for ($i=0;$i<sizeof($c_subSec);$i++) {
			$c_subSec[$i]['por'] = sprintf("%d",($c_subSec[$i]['contenido']*100)/$totalVotos);
			$c_subSec[$i]['dif'] = sprintf("%d",100-$c_subSec[$i]['por']);
			$xmlEncuesta .= "<set name='".$c_subSec[$i]['nombre']."' value='".$c_subSec[$i]['por']."' color='".rand(555555, 999999)."'/>";
		}
		$xmlEncuesta .= '</graph>';

		$smarty -> assign('subSec'			, $c_subSec);
		$smarty -> assign('votar'			, "Votar");
		$smarty -> assign('ver_resultado'	, "Ver resultado");
		$smarty -> assign('c_phpself'		, $phpself);

		/* Flash de Encuesta */
		$smarty -> assign('xmlEncuesta'		, $xmlEncuesta);
		$smarty -> assign('type'			, (isset($trazaCategoria[$idcategoria]['antetitulo']) and !empty($trazaCategoria[$idcategoria]['antetitulo'])) ? $trazaCategoria[$idcategoria]['antetitulo'] : "column" );

		return $smarty -> fetch('tpl_encuesta.html');
	}
	/**
	 * TemplateProducto()
	 *
	 * @return
	 * TODO: Por hacer la migracion del sistema viejo al nuevo
	 **/
	function TemplateProducto($idcategoria) {
		srand((double)microtime()*1000000);
		$ts = md5(rand(0,9999999));
		$smarty = new Smarty_Plantilla;
		$db = $GLOBALS['db'];
		define('categoria_producto',20);
		if (0 != $idcategoria){
			$phpself	= basename($_SERVER['PHP_SELF']);
            // Cambio # 15 (Cambio Extraño)
			$query		= $db->prepare("select * from "._TBLCATEGORIA." where idcategoria = ? ");
			$result		= $db->Execute($query, array($idcategoria));
            $row =      $result->fields;
			//$row		= $db["fetch_object"]($result);

			if($row -> $GLOBALS["_nombre"]==""){$row -> $GLOBALS["_nombre"]=$row ->nombre;}
			if($row -> $GLOBALS["_antetitulo"]==""){$row -> $GLOBALS["_antetitulo"]=$row ->antetitulo;}
			if($row -> $GLOBALS["_subtitulo"]==""){$row -> $GLOBALS["_subtitulo"]=$row ->subtitulo;}
			if($row -> $GLOBALS["_entradilla"]==""){$row -> $GLOBALS["_entradilla"]=$row ->entradilla;}
			if($row -> $GLOBALS["_descripcion"]==""){$row -> $GLOBALS["_descripcion"]=nl2br($row ->descripcion);}

			//Creación de una tabla a partir de la estructura definida para la descripción
			$filas=explode("\n",trim($row -> $GLOBALS["_descripcion"]));
			foreach($filas as $ln){
				$descripcion[]=explode("|",trim($ln));
			}

			$smarty->assign('idcategoria', $row -> idcategoria);
			$smarty->assign('nombre', $row -> nombre);
			$smarty->assign('precio', number_format($row -> $GLOBALS["_antetitulo"]));
			$smarty->assign('subtitulo', $row -> $GLOBALS["_subtitulo"]);
			$smarty->assign('descripcion', stripslashes($row -> $GLOBALS["_entradilla"]));
			$smarty->assign('caracteristicas', stripslashes($descripcion));
			$smarty->assign('fabricante', $row -> autor);
			if(is_file(trim(_DIRIMAGES."/".$row -> imagen))){
				$imagen		= _DIRIMAGES . "/" . $row->imagen;
				$smarty->assign('imagen', $imagen);
			}
			$c_submenu = DisplaySubMenu($idcategoria,$row->iddisplay_sub);
			$smarty -> assign('c_submenu', $c_submenu);
		}
		$db["free_result"]($result);
		$smarty -> assign('verMas', Funciones::Navegacion($idcategoria, $result));

		$smarty -> assign('t_descrip'	,_ROT_SHOP_DESCRIPCION);
		$smarty -> assign('t_caracter'	,_ROT_SHOP_CARACTERISTICAS);
		$smarty -> assign('valorunit'	,_ROT_SHOP_VALORUNITARIO);
		$smarty -> assign('rotfabricante'	,_ROT_SHOP_FABRICANTE);
		$smarty -> assign('comprar'		,_ROT_SHOP_COMPRAR);
		$smarty -> assign('cantidad'	,_ROT_SHOP_CANTIDAD);

		$smarty -> assign('document_root',_DOCUMENT_ROOT);
		$smarty -> assign('rutaRecursos',_RUTARECURSOS);
		return $smarty -> fetch('tpl_productos.html');
	}
	/**
	 * TemplateDescargar
	 *
	 * @return
	 **/
	function TemplateDescargar($idcategoria) 
	{

		global $db;	/** @see variales.php */
        // Cambio # 16
		$query = $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE idcategoria = ? ");
		$result	= $db->Execute($query, array($idcategoria)) /* or errorQuery(__LINE__, __FILE__) */;
		$row = $result->fields;

		if (isset($_GET["download"])) 
		{
			FuncionesDisplay::Descargar($row);
		}

		$archivo = _DOCUMENT_ROOT._DIRRECURSOS_USER.$row['descripcion'];
		$tamano = 0;
		$smarty = new Smarty_Plantilla;
		$extension = '';
		$path = pathinfo($archivo);
		
		$trozos = explode(".", $archivo); 
		$extension_archivo = end($trozos); 
		
		$smarty->assign('extension_archivo', $extension_archivo);
		
		if (is_file(_DIRIMAGES.'extensiones/'.$path['extension'].'.gif')) 
		{
			$extension = _DIRIMAGES.'extensiones/'.$path['extension'].'.gif';
		} 
		else 
		{
			$extension = _DIRIMAGES.'extensiones/fic.gif';
		}

		$smarty->assign('seccion', $row);

		if (($tamano = @filesize($archivo)) !== FALSE) 
		{
			$smarty->assign("idcategoria", $idcategoria);
			$smarty->assign("archivo", basename($archivo));
			$smarty->assign("extension", $extension);
			$smarty->assign("tamano", FuncionesInterfaz::formatBytes($tamano));
		}

		return $smarty -> fetch('tpl_descarga.html');

	}
	/**
	 * FuncionesDisplay :: Descargar
	 * Funcion para descargar archivos
	 * @return
	 **/
	function Descargar($row) 
	{
		$archivo = _DOCUMENT_ROOT._DIRRECURSOS_USER.$row['descripcion'];
		//$archivo = _DIRUSUARIO.$row['descripcion'];
		if (is_file($archivo)) 
		{
			include_once(_DIRCORE.'mimetype.php');
			$mime = new mimetype();
			header('Pragma: private');
			header('Cache-control: private, must-revalidate');
			header('Content-type: ' . $mime->getType($archivo)."\n");
			header('Content-Length: '.filesize($archivo)."\n");
			header('Content-Disposition: attachment; filename="'.basename($archivo).'"');
			header('Content-Transfer-Encoding: binary');
			readfile($archivo);
			exit(0);
		}
	}
	/**
	 * FuncionesDisplay :: DisplaySubMenuHeredar
	 * Es necesario cuando se hace login
	 * @param
	 * @return
	 */
	function DisplaySubMenuHeredar($idcategoria,$idcategoria_origen = 0){
		global $db;

		if(!$idcategoria_origen){ $idcategoria_origen = $idcategoria; }
		$smarty = new Smarty_Plantilla;
        
        // Cambio # 17
		$query   = $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE idcategoria = ? ");
		$result  = $db->Execute($query, array($idcategoria)) /* or errorQuery(__LINE__, __FILE__) */;
		$row	 = $result->fields;
        
        // Cambio # 18
		$query0  = $db->prepare("SELECT * FROM "._TBLCATEGORIA." WHERE idcategoria = ? ");
		$result0 = $db->Execute($query0, array( $row["idpadre"])) /* or errorQuery(__LINE__, __FILE__) */;
		$row0	 = $result0->fields;

		if($row["idpadre"] != 0){
			if($row0["iddisplay_sub"] != 0){
				return Funciones::DisplaySubMenu($idcategoria_origen,$row0["iddisplay_sub"]);
			} else {
				return FuncionesDisplay::DisplaySubMenuHeredar($row0["idcategoria"],$idcategoria_origen);
			}
		} else {
			return Funciones::DisplaySubMenu($idcategoria_origen,_DEF_ORDENACION_SUB);
		}

	}
	/**
	 * FuncionesDisplay :: TemplateHome
	 * Cargamos el archivo del home y lo mostramos
	 * @return
	 */
	function TemplateHome() {
		require_once(_DIRINTERFAZ."tpl_home.php");
		return TemplateHome();
	}
	/**
	 * FuncionesDisplay :: Workflow
	 * @param
	 * @return
	 */
	function Workflow($idcategoria) {
		if (isset($_GET['start'])) {
			global $trazaCategoria;
			$smarty = new Smarty_Plantilla;
			require_once(_DIRWORKFLOW."lib/Ejecutar.class.php");
			$unWf = new Ejecutar();
			$idProceso = $unWf->EjecutarWorkFlow($idcategoria);
			if ($idProceso !== FALSE) {
				$returnMsg = "Iniciado el proceso con caso numero ".$idProceso;
			} else {
				$returnMsg = "No se pudo iniciar el proceso, talvez el workflow esta mal o esta vencida la fecha de actividad";
			}
			$smarty -> assign('c_titulo', $trazaCategoria[$idcategoria]["nombre"]);
			$smarty->assign('c_entradilla', $returnMsg);

			return $smarty -> fetch('tpl_default.html');
		}
	}
	/**
	 * FuncionesDisplay :: DisplaySubMenuContratacion
	 * @param
	 * @return
	 */
	function DisplaySubMenuContratacion($idcategoria) {
		$nameObj = "Contratacion";
		if(is_file(_DIRCORE.$nameObj.".class.php")) {
			require_once(_DIRCORE.$nameObj.".class.php");
			$unContratacion = new $nameObj();
			return $unContratacion->imprimirListado($idcategoria);
		} else {
			$mesError = "No ha sido instalado el Módulo de Contratación. Si desea obtenerlo envienos un correo a "
						."<a href=\"mailto:info@micrositios.net\" style=\"color:#00e\">info@micrositios.net</a> para obtener mas información.<br><br>"
						."<a href=\"http://www.micrositios.net/\" style=\"color:#00e\">Micrositios LTDA.</a>";
			return msgError($mesError, FALSE);
		}
	}
    /**
	 * FuncionesDisplay :: DisplaySubMenuContratacionHV
	 * @param
	 * @return
	 */
	function DisplaySubMenuContratacionHV($idcategoria) {
		$nameObj = "ContratacionHV";
		if(is_file(_DIRCORE.$nameObj.".class.php")) {
			require_once(_DIRCORE.$nameObj.".class.php");
			$unContratacion = new $nameObj();
			return $unContratacion->imprimirListado($idcategoria);
		} else {
			$mesError = "No ha sido instalado el Módulo de Contratación. Si desea obtenerlo envienos un correo a "
						."<a href=\"mailto:info@micrositios.net\" style=\"color:#00e\">info@micrositios.net</a> para obtener mas información.<br><br>"
						."<a href=\"http://www.micrositios.net/\" style=\"color:#00e\">Micrositios LTDA.</a>";
			return msgError($mesError, FALSE);
		}
	}
    /*
	 * Funcion qque retorna los resultados de la encuesta de satisfaccion
	 * @AUTHOR Farez Prieto
	 * @DATE 20 noviembre 2009
	*/
    function resultadosEncuesta($idcategoria) {
		$mostrar_algo	=	0;
			
		global $db;
		//Primero que todo consulto el dato de la pregunta
        // Cambio # 19
        //ejecuto el resultado de las preguntas
		$query_pregunta		=	$db->prepare("SELECT * FROM categoria WHERE idpadre= ?  AND eliminado=? AND activa=?");
		$result_pregunta	=	$db->Execute($query_pregunta, array($idcategoria, 0, 1));
		//empiezo a pintar la tabla que va a mostrar la informacion
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment;filename=Reporte_satisfaccion_".$idcategoria.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		//creo un contador para poder llevar al control de cada fila
		$contador	= 0;
		//empiezo a pintar l tabla
		echo "<table border='1'>";
		echo "	<tr style='background:#000;color:#fff;font-weight:bold'>";
		echo "	<td align='center'>";
		echo "PREGUNTA";		
		echo "	</td>";
		echo "	<td align='center'>";
		echo "SUBTITULO";		
		echo "	</td>";
		echo "	<td>";
		echo "TEMA";		
		echo "	</td>";
		echo "	<td align='center'>";
		echo "OPCIONES";		
		echo "	</td>";
		echo "	<td align='center'>";
		echo "TOTAL";		
		echo "	</td>";
		echo "	</tr>";
		//recorro las preguntas para empezar pintarlas
		while(!$result_pregunta->EOF)
		{
			if(($contador % 2) == 0)
			{
				echo "<tr style='background:#F9E2CA;color:#000;font-weight:bold'>";
			}
			else
			{
				echo "<tr style='background:#ccc;color:#000;font-weight:bold'>";
			}
			//echo "<tr>";
			echo "	<td valign='middle'>";
			echo $result_pregunta->fields['nombre'];		
			echo "	</td>";
			echo "	<td valign='middle'>";
			echo $result_pregunta->fields['subtitulo'];		
			echo "	</td>";
			echo "	<td valign='middle'>";
			echo $result_pregunta->fields['antetitulo'];		
			echo "	</td>";
			echo "	<td>";
				//ahora debo consultar las opciones de pregunta
                // Cambio # 20
				$query_opciones		=	$db->prepare("SELECT * FROM categoria WHERE idpadre=? AND eliminado=? AND activa=?");	
				//ejecuto la cosnulta
				$result_opciones	=	$db->Execute($query_opciones, array($result_pregunta->fields['idcategoria'], 0, 1));
				//realizo la consulta para saber el total de los votos de cada opcion
            
                // Cambio # 21
				$query_total		=	$db->prepare("SELECT SUM(descripcion) as total FROM categoria WHERE idpadre=? AND eliminado=? AND activa=?");
				//ejecuto la consulta del total
				$result_total		=	$db->Execute($query_total, array($result_pregunta->fields['idcategoria'], 0, 1));
				//cuento cuantas opciones tiene cada pregunta
            
                // Cambio # 22
				$query_cantidad		=	$db->prepare("SELECT COUNT(idcategoria) as cantidad FROM categoria WHERE idpadre=? AND eliminado=? AND activa=?");
				//ejecuto la consulta del total
				$result_cantidad		=	$db->Execute($query_cantidad, array($result_pregunta->fields['idcategoria'], 0, 1));
            
				//pinto la tabla donde deben quedar
				echo "<table width='100%' border='1'>";
				if($mostrar_algo == 0)
				{
					echo "<tr style='background:#000;color:#fff;font-weight:bold'>";
					echo "<td>";
					echo "OPCION";
					echo "</td>";
					echo "<td>";
					echo "VOTOS";
					echo "</td>";
					echo "<td>";
					echo "%";
					echo "</td>";
					echo "</tr>";
					$mostrar_algo	=	1;
				}
				//recorro las opciones para pintarlas a la tabla
				while(!$result_opciones->EOF)
				{
					//calculo el porcentaje por pregunta
					$porcentaje	=	$result_opciones->fields['descripcion'] * $result_cantidad->fields['cantidad'] / 100;
					echo "<tr style='color:#000;font-weight:bold'>";
					echo "<td>";
					echo $result_opciones->fields['nombre'];
					echo "</td>";
					echo "<td align='center'>";
					echo $result_opciones->fields['descripcion'];
					echo "</td>";
					echo "<td align='center'>";
					echo $porcentaje." %";
					echo "</td>";
					echo "</tr>";
					$result_opciones->MoveNext();
				}
				echo "</table>";
			echo "	</td>";
			echo "<td align='center'>";
			echo $result_total->fields['total'];
			echo "</td>";
			echo "</tr>";
			$contador ++;
			$result_pregunta->MoveNext();
		}
		echo "</table>";
		die();
	}
	/*
	 * Funcion que controla el comportamiento de la encuesta de satisfaccion
	 * @AUTHOR Farez Prieto
	 * @DATE 05 noviembre 2009
	*/
	function DisplayEncuestaSatisfaccion($idcategoria) {
		global $db;
		global $smarty;
		$es_admin	=	false;
		//asigno el grafico por defecto
		$grafico	=	'pie3d';
		//priemro que todo valido si hay un usuario logueado
		if(isset($_SESSION['info_usuario']) and $_SESSION['info_usuario']['idzona']	== 9)
		{
			$es_admin	=	true;
		}
		else
		{
			$es_admin	=	false;
		}
		$bandera	=	false;
		//realizo la consulta que me traera los padres de la categoria
        
        // Cambio # 23
		$query_padre			=	$db->prepare("SELECT * FROM categoria WHERE idpadre=? AND activa=? AND eliminado=?");
		//ejecuto el resultado
		$result_padre			=	$db->Execute($query_padre, array($idcategoria, 1, 0));
		//arreglo que lleva las preguntas y las opciones de respuesta
		$arreglo_final			=	array();
		//cargalo xml para las graficas
		$xml					=	array();
		//variable que muestra los resultados sin haber votado
		$result					=	false;
		///recorro los padres para ponerlos en el arreglo
		while(!$result_padre->EOF)
		{
			//consulto los hijos de ese padre
            
            // Cambio # 24
			$consulta_hijos	= $db->prepare("SELECT * FROM categoria WHERE idpadre=? and activa=? AND eliminado=?");				  
			//resultado de los hijos
			$result_hijos	=	$db->Execute($consulta_hijos, array($result_padre->fields['idcategoria'], 1, 0));
			
            // Cambio # 25
			//creo la consulta que me traera el total de votos
			$query_total	=	$db->prepare("SELECT sum(descripcion) as total FROM categoria WHERE idpadre=? and activa=? AND eliminado=?");
			//capturo el resultado
			$result_total	=	$db->Execute($query_total, array($result_padre->fields['idcategoria'], 1, 0));
            
			//arreglo temporral de los hijos
			$hijos_2=array();
			//empiezo a crear el xml del grafico
			$xmlEncuesta = "<graph caption='".$result_padre->fields['nombre']."' subCaption='".$result_total->fields['total']." voto(s) en total' xaxisname='Decisión' yaxisname='Porcentaje' numdivlines='3'>";
			//recorro los hijos
			while(!$result_hijos->EOF)
			{
				//concateno en un areglo las opciones de respuesta	
				$hijos=array("nombre"=>$result_hijos->fields['nombre'],
							 "idcategoria"=>$result_hijos->fields['idcategoria'],
							 "contenido"=>$result_hijos->fields['descripcion']);
				//concateno el arreglo de las opciones totales
				array_push($hijos_2,$hijos);
   				//genero la parte que me muestra la cantidad de opciones en la grafica
				$xmlEncuesta .= "<set name='".$result_hijos->fields['nombre']."' value='".$result_hijos->fields['descripcion']."' color='".rand(555555, 999999)."'/>";
				//paso al siguiente registro de las opciones
				$result_hijos->MoveNext();
				
			}
			//cierro el xml
			$xmlEncuesta .= '</graph>';
			//concateno las preguntas junto con las opciones en un mismo arreglo
			$padres	=	array("idcategoria"=>$result_padre->fields['idcategoria'],
								"nombre"=>$result_padre->fields['nombre'],
								"resumen"=>$result_padre->fields['entradilla'],
								"subtitulo"=>$result_padre->fields['subtitulo'],
								"tema"=>$result_padre->fields['antetitulo'],
								"hijos"=>$hijos_2);
			//concateno en un arreglo final las preguntas y las opciones
			array_push($arreglo_final,$padres);
			//pongo en un arreglo el numero de graficas a mostrar para poder generar varios XML diferentes y cada uno en una posision por pregunta
			array_push($xml,$xmlEncuesta);
			//paso a la siguiente pregunta		
			$result_padre->MoveNext();				  
		}
		//valido si se presiono el boton de votar
		if(isset($_POST['votar']))
		{
			if(isset($_SESSION['voto']))
			{
				$error	=	'Ud ya ha realizado una votación el dia de hoy';	
			}
			else
			{
				foreach($_POST as $valor)
				{	
					//realizo el query que guardara el valor del voto en la base de datos
                    
                    // Cambio # 26
					$query_update	=	$db->prepare("UPDATE categoria SET descripcion=descripcion+? WHERE idcategoria=?");
					//realizo el resultado
					$result_voto	=	$db->Execute($query_update, array(1, $valor));
					//realizo ahora un query para poder hacer la graficas
                    
                   // Cambio # 27 
					$query_grafica	=	$db->prepare("SELECT * FROM categoria WHERE idcategoria= ?");
					//resultado
					$result_grafica	=	$db->Execute($query_grafica, array($valor));
				}
				//redirecciono hacia la catgeoria para ver el resultado de una vez
				//header("location:index.php?idcategoria=".$idcategoria);
				//debo levantar una session para que el usuario no pueda votar 2 veces
				$_SESSION['voto']	=	true;
				//guardo la session en una variable
				$voto				=	true;
				//mensaje
				$mensaje	=	"Su voto se ha procesado con Exito";
			}
		}
		//valido si presiono el boton de ver los resultados en torta
		if(isset($_POST['resultados']))
		{
			$result	=	true;
		}
		//valido si presiono el boton de ver los resultados en barras
		if(isset($_POST['resultados1']))
		{
			$result		=	true;
			$grafico	=	'column';
		}
		//valido si se dio la orden de generar el resultado en Excel
		if(isset($_POST['exportar']))
		{
			$this->resultadosEncuesta($idcategoria);
		}

		
		$smarty->assign("voto_realizado",(isset($_SESSION['voto']))?$_SESSION['voto']:false);
		$smarty->assign("xmlEncuesta",$xml);
		$smarty->assign("listado",$arreglo_final);
		$smarty->assign("mensaje",$mensaje);
		$smarty->assign("bandera",$bandera);
		$smarty->assign("error",$error);
		$smarty->assign("result",$result);
		$smarty->assign("es_admin",$es_admin);
		$smarty->assign("grafico",$grafico);
		$smarty->assign("idcategoria",$idcategoria);
		return $smarty->fetch('tpl_encuesta_satisfaccion.html');
	}
    
    function DisplaySubMenuResumenNoticias($idcategoria=0){
	
	    global $db; /** @see variables.php */
		$smarty = new Smarty_Plantilla;
		$categorias = array();

		if ($idcategoria > 0){
			$result = FuncionesDisplay::cargarInfoSubCategoria($idcategoria, $plus);

			if ($result !== FALSE and $result->numRows > 0){
				$max_height = 0;

				while (!$result->EOF){

					$row = $result->fields;
					if ($row['nombre']) { /*  && is_file(_DIRRECURSOS_USER . $row['descripcion'])   */
						array_push($categorias, $row);
					}

					$result->MoveNext();
				}

			} else {
				return "";
			}

			if(isset($categorias)){
				$smarty -> assign('subMenu', $categorias);
			}

			$smarty -> assign('verMas', Funciones::Navegacion($idcategoria, $result));
			return $smarty -> fetch("tpl_subMenuResumenNoticias.html");
		}
	
	}
}
?>