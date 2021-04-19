<?php
//Función de presentación de la plantilla de Home

function TemplateHome() {
	global $template;
	global $idcategoria;

	$plantilla		= _PLANTILLA;//_PLANTILLA;substr(_PLANTILLA,0,strlen(_PLANTILLA)-4);

	if(ereg('^[a-zA-Z_-]+[0-9]{4}$',$plantilla))
	{   
		return TemplateHomeNuevo();
	}
	else
	{   
		return TemplateHomeDefault();
	}
/*
switch(_PLANTILLA) {
//		case 'Default2009':
			return TemplateHomeNuevo();
		break;
		default:
			return TemplateHomeDefault();
	}
*/
}

function TemplateHomeDefault() {
	global $db;	/** @see variables.php */
	global $idcategoria;
	global $trazaCategoria;

	$smarty = new Smarty_Plantilla;
	$query = sprintf("SELECT * FROM %s WHERE activa != 0 AND idcategoria = '%s'" , _TBLCATEGORIA , $idcategoria);
	$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);

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
			*	Verifica que la categoria escogida esté activa
			**/
			$queryActiva = sprintf("SELECT activa FROM %s WHERE idcategoria = '%s'" , _TBLCATEGORIA , $seccionBuscar);
			$resultActiva = $db->Execute($queryActiva) or errorQuery(__LINE__, __FILE__);

			if ($resultActiva->NumRows() > 0 && $resultActiva->fields['activa'] == 1)
			{
				/**
				 * Buscando los hijos de la seccion elegida
				 **/
				$queryHijos = sprintf("SELECT * FROM %s WHERE activa != 0 AND idpadre = '%s' and fecha2 >= '%s' ORDER BY fecha2 DESC" , _TBLCATEGORIA , $seccionBuscar, date('Y-m-d'));

				$resultHijos = $db->SelectLimit($queryHijos, $cantidad) or errorQuery(__LINE__, __FILE__);

				if ($resultHijos->NumRows() > 0) {

					/**
					 *  Buscando info de la seccion elegida
					 **/
					$querySeccion = sprintf("SELECT * FROM %s WHERE activa != 0 AND idcategoria = '%s'" , _TBLCATEGORIA , $seccionBuscar);
					$resultSeccion = $db->Execute($querySeccion) or errorQuery(__LINE__, __FILE__);
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
						$auxHijos['antetitulo'] = $dHijos['antetitulo'];
						$fecha3 = explode(" ",date("Y-m-d h:i a",strtotime($dHijos['fecha3'])) );
						$auxHijos['fecha3'] = $fecha3[1].' '.$fecha3[2] ;
						array_push($arrayhijos, $auxHijos);

						$resultHijos->MoveNext();
					}

					$arraySeccionActual['hijos'] = $arrayhijos;
					array_push($arraySecciones, $arraySeccionActual);
				}
			}
		}

/**
		 * Informacion de Top 5
		 */

			/**
			 * papa de Top 5
			 */
			 global $idcategoria;
			
			if ($idcategoria==430)
			{
			
			$query = sprintf("SELECT idcategoria, nombre FROM %s WHERE activa != 0 AND idcategoria = %s" , _TBLCATEGORIA , 94728);
			$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);
            
			if ($result->NumRows() > 0) {

				$smarty->assign('tituloTop', $result->fields['nombre']);
				$smarty->assign('idcategoriaTop', $result->fields['idcategoria']);

				/**
				 * hijos de Top 5
				 */
				$top5 = array();
				define('max_cat', 5);
				$query = sprintf("SELECT idcategoria, nombre, entradilla, subtitulo, imagen,antetitulo FROM %s WHERE activa != 0 AND idpadre = %s ORDER BY fecha2 DESC" , _TBLCATEGORIA , 94728);
				$result = $db->SelectLimit($query, max_cat) or errorQuery(__LINE__, __FILE__);

				if ($result->NumRows() > 0) {
					while(!$result->EOF) {
						$data = $result->fields;
						array_push($top5, $data);
						$result->MoveNext();
					}
				}
				$smarty->assign('top5', $top5);
			}
            
           }


		$smarty->assign('secciones', $arraySecciones);
		$smarty->assign('resumen', stripslashes($d["entradilla"]));

	}

	/*** Verifica si existe el flash foto_noticia.swf ***/

	if (file_exists("recursos_foto_noticia/foto_noticias.swf")){
   		$smarty->assign('archivo_flash', true);
	}else{
   		$smarty->assign('archivo_flash', false);
	}
	/*** Verifica si existe el flash foto_noticia_ingles.swf ***/
	if (file_exists("recursos_foto_noticia/foto_noticias_ingles.swf")){
   		$smarty->assign('archivo_flash_ingles', true);
	}else{
   		$smarty->assign('archivo_flash_ingles', false);
	}
	/*** Verifica si existe el flash foto_noticia_frances.swf ***/
	if (file_exists("recursos_foto_noticia/foto_noticias_frances.swf")){
   		$smarty->assign('archivo_flash_frances', true);
	}else{
   		$smarty->assign('archivo_flash_frances', false);
	}

	/**** Parte del Usuario ****/
    if (isset($_SESSION['info_usuario'])) {
		$smarty -> assign('homeUsuario',	FuncionesInterfaz::homeUsuario());
		$smarty -> assign('existsUsuario',	TRUE);
	}
	$smarty->assign('infoPrincipal', $trazaCategoria[$idcategoria]);
	$smarty->assign('idcategoria', $idcategoria);

	return $smarty -> fetch('tpl_home.html');
}


function TemplateHomeNuevo() {

	global $db;	/** @see variables.php */
	global $idcategoria;
	global $trazaCategoria;
	$home	=	new ejercito();
	$smarty = new Smarty_Plantilla;
	$query = sprintf("SELECT * FROM %s WHERE activa != 0 AND idcategoria = '%s'" , _TBLCATEGORIA , $idcategoria);
	$result = $db->Execute($query) or errorQuery(__LINE__, __FILE__);

	if ($result->NumRows() > 0) {
		$d = $result->fields;
		$contenido = $d["descripcion"];
		$arraySecciones = $home->nuevoHome($contenido);

		$smarty->assign('secciones', $arraySecciones);
		$smarty->assign('resumen', stripslashes($d["entradilla"]));
	}


	//////////////////PINTA EL FUNCIONAMIENTO DEL HOME EN EL LATERAL DERECHO//////////////////////
	if(defined('__LATERAL_DERECHO_1') and __LATERAL_DERECHO_1!='')
	{
		$resultado	=	$home->nuevoHome2(__LATERAL_DERECHO_1);

		$smarty->assign('secciones_derecho', $resultado);
		$smarty->assign('resumen_derecho', stripslashes($d["entradilla"]));
	}
	/////////////////////////////////////////////////////////////////////////////////////////////

	////////////////////////PINTA EL FUNCIONAMIENTO DE LOS RESUMENES CENTRALES//////////////////////////
	if(defined('__LADOFOTONOTICIA') and __LADOFOTONOTICIA!='')
	{
		//traigo los hijos de la catergria correspondiente
		$resultado_principales		=	$home->separaDatos(__LADOFOTONOTICIA,'0');
		//traigo el nombre de la categoria padre
		$nombre_padre_principales	=	$home->nuevoHome(__LADOFOTONOTICIA);
		$id_padre_principales	=	$home->nuevoHome(__LADOFOTONOTICIA);
		$smarty->assign('resumenes_centrales'					, $resultado_principales);
		$smarty->assign('nombre_padre_resumenes_centrales'		, $nombre_padre_principales[0]['nombre']);
		$smarty->assign('id_padre_resumenes_centrales'		    , $id_padre_principales[0]['idcategoria']);
	}
	////////////////////////////////////////////////////////////////////////////////////////////
$constante = '__RECOMENDADOS';
//echo (defined($constante))?"buena constante":"mala";
$parametros = '';
eval("\$parametros = $constante;");
//echo $parametros;

function algo($constante, &$funcionesHome, &$smarty)
{
	if(! defined($constante) ) return false;
	eval("\$parametros = $constante;");
    if($parametros=='' ) return false;

    //Informacion sobre la categoria
	$categoria	    =	$funcionesHome->NombrePadre($parametros);
	//Traemos los hijos
	$hijos		    =	$funcionesHome->separaDatos($parametros,'0');


	$smarty->assign('recomendados'					, $hijos);
	$smarty->assign('nombre_padre_recomendados'		, $categoria);
	return true;
}
algo('__RECOMENDADOS',$home, $smarty);
/*
	////////////////////////PINTA EL FUNCIONAMIENTO DE LOS RECOMENDADOS//////////////////////////
	if(defined('__RECOMENDADOS') and __RECOMENDADOS!='')
	{
		//traigo los hijos de la categoria correspondiente
		$resultado_recomendados		=	$home->separaDatos(__RECOMENDADOS,'0');
		//traigo el nombre de la categoria padre
		$nombre_padre_recomendados	=	$home->NombrePadre(__RECOMENDADOS);

		$smarty->assign('recomendados'					, $resultado_recomendados);
		$smarty->assign('nombre_padre_recomendados'		, $nombre_padre_recomendados);
	}
	////////////////////////////////////////////////////////////////////////////////////////////
*/
	////////////////////////PINTA EL FUNCIONAMIENTO DE LAS ESCUELAS DE FORMACION//////////////////////////
	if(defined('__ESCUELAS') and __ESCUELAS!='')
	{
		//traigo los hijos de la categoria correspondiente
		$resultado_escuelas		=	$home->separaDatos(__ESCUELAS,'0');
		//traigo el nombre de la categoria padre
		$datos_padre_escuelas	=	$home->NombrePadre(__ESCUELAS);
		

		$smarty->assign('escuelas'					, $resultado_escuelas);
		$smarty->assign('info_escuelas'				, $datos_padre_escuelas);

	}
	////////////////////////////////////////////////////////////////////////////////////////////

	////////////////////////PINTA EL FUNCIONAMIENTO DE LAS IMAGENES DESTACADAS//////////////////////////
	if(defined('__IMAGENES') and __IMAGENES!='')
	{
		//traigo los hijos de la categoria correspondiente
		$resultado_imagenes		=	$home->separaDatos(__IMAGENES,'0');
		//traigo el nombre de la categoria padre
		$nombre_padre_imagenes	=	$home->NombrePadre(__IMAGENES);
		$smarty->assign('imagenes'					, $resultado_imagenes);
		$smarty->assign('nombre_padre_imagenes'		, $nombre_padre_imagenes);
	}
	////////////////////////////////////////////////////////////////////////////////////////////
	
	
	////////////////////////SE MUESTRA EL LISTADO DE LAS DIVISIONES////////////////////////////
	if(defined('__DIVISIONES_EJERCITO') and  __DIVISIONES_EJERCITO != '')
	{

		$datos	=	explode('#',__DIVISIONES_EJERCITO);
		$categoria		=	$datos[0];	//id categoria a consultar
		$consulta=sprintf("select nombre from categoria where idcategoria=%s",$categoria);
		$nom_categoria = $db->GetAll($consulta);

		$div_ejercito			=	new ejercito();
		//llamo la funcion para que me traiga los hijos de la historia del ejercito
		$divisiones	                =	$div_ejercito->separaDatos( __DIVISIONES_EJERCITO,'0');
		$nombre_padre_divisiones	=	$div_ejercito->NombrePadre(__DIVISIONES_EJERCITO);

		//asigno un arreglo
		$arreglo_div_ejercito	=	array();
		//recorro el resultado
		foreach($divisiones as $info_divisiones)
		{
			array_push($arreglo_div_ejercito,$info_divisiones);
		}
		$num = count($arreglo_div_ejercito);
		$residuo = $num%2;

		//$reg_col = ($residuo == 0)?($num / 2):(round($num / 2));
         if (($residuo == 0))
		{
			$reg_col = $num / 2;
		}else
			{$reg_col= round($num / 2);}

		$smarty->assign('nombre_categoria', $nom_categoria);
		$smarty->assign('divisiones_ejercito', $arreglo_div_ejercito);
		$smarty->assign('reg_col', $reg_col);
		$smarty->assign('nombre_padre_divisiones', $nombre_padre_divisiones);

	}
	///////////////////////////////////////////////////////////////////////////////////////////




	/**
	 * Foto Noticia
	 */


	if(defined('_FOTONOTICIA'))
	{
		if(_FOTONOTICIA != '')
		{
			$smarty->assign('fotonoticia',true);
			$smarty->assign('fotonoticia_categorias',_FOTONOTICIA);

		}
	}



	/**** Parte del Usuario ****/
    if (isset($_SESSION['info_usuario'])) {
		$smarty -> assign('homeUsuario',	FuncionesInterfaz::homeUsuario());
		$smarty -> assign('existsUsuario',	TRUE);
	}
	$smarty->assign('infoPrincipal', $trazaCategoria[$idcategoria]);
if($idcategoria == 1) $encuesta = FuncionesInterfaz::MostrarEncuesta();

	$smarty->assign('encuesta'		,$encuesta);
	return $smarty -> fetch('tpl_home.html');
}

?>
