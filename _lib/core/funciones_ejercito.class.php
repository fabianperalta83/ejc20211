<?php
//incluyo el archivo de las funciones
//require('Funciones.class.php');

class ejercito extends Funciones
{
	//funcion que parsea los datos del menu lateral
	function separaDatos($constante,$tipo_home)
	{
		global $db;
		$datos	=	explode('#',$constante);
		$categoria		=	$datos[0];	//id categoria a consultar
		$cantidad_hijos	=	$datos[1];	//limite de hijos
		$con_imagen		=	$datos[2];	//cuantos con imagen
		if($tipo_home	==	'1')
		{
			//creo la consulta que me traera los hijos de la categoria enviada
			$consulta_categoria		=	sprintf("SELECT * FROM categoria WHERE idpadre=%s AND eliminado=0 AND activa=1 AND fecha3 >= CURDATE() ORDER BY fecha2 DESC LIMIT %s",$categoria,$cantidad_hijos);
		}
		if($tipo_home=='0')
		{
		if ($cantidad_hijos==6){//Ausmerley
		$cantidad_hijos	=7;}
			$consulta_categoria		=	sprintf("SELECT * FROM categoria WHERE idpadre=%s AND eliminado=0 AND activa=1 ORDER BY fecha2 DESC, idcategoria DESC LIMIT %s",$categoria,$cantidad_hijos);
		}
		//ejecuto la consulta
		//$resultado_categoria	=	$db->GetAll($consulta_categoria);
		$resultado_categoria	=	$db->Execute($consulta_categoria);
		$datos_finales			=	array();
	//recorro el resultado para empezar a saber si trae cono adjunto unarchivo mp3
		while(!$resultado_categoria->EOF)
		{
			//ahora procedo a pasar los campos que necesito
			
//aramirez, esta funcion se utiliza varias veces, dañaba el calendario, pendiente de que pudo dejar de funcionar
			// $datos	=	array("iddisplay_sub"=>$resultado_categoria->fields['iddisplay_sub'],
							  // "idcategoria"=>$resultado_categoria->fields['idcategoria'],
							  // "nombre"=>$resultado_categoria->fields['nombre'],
							  // "fecha1"=>$resultado_categoria->fields['fecha1'],
							  // "imagen"=>$resultado_categoria->fields['imagen'],
							  // "descripcion"=>$resultado_categoria->fields['descripcion'],
                                                          // "autor"=>$resultado_categoria->fields['autor'],
							  // "adjunto_tipo"=>substr($resultado_categoria->fields['descripcion'],-3));
			
			$datos	=	$resultado_categoria->fields;
			//concateno todo en un arreglo que es el encargado de pasar todo al home.
			array_push($datos_finales,$datos);
			$resultado_categoria->MoveNext();
		}
		
		//retorno el resultado
		return $datos_finales;

	}
	
		//funcion que verifica los eventos del calendario
		function calendario($constante,$tipo_home)
	{
		global $db;
		$datos	=	explode('#',$constante);
		$categoria		=	$datos[0];	//id categoria a consultar
		$cantidad_hijos	=	$datos[1];	//limite de hijos
		$con_imagen		=	$datos[2];	//cuantos con imagen
		if($tipo_home	==	'1')
		{
			//creo la consulta que me traera los hijos de la categoria enviada
			$consulta_categoria		=	sprintf("SELECT * FROM categoria WHERE idpadre=%s AND eliminado=0 AND activa=1 AND fecha2 >= CURDATE() ORDER BY fecha2 DESC LIMIT %s",$categoria,$cantidad_hijos);
			//var_dump($consulta_categoria);
		}
		if($tipo_home=='0')
		{
			$consulta_categoria		=	sprintf("SELECT * FROM categoria WHERE idpadre=%s AND eliminado=0 AND activa=1 ORDER BY fecha3 DESC LIMIT %s",$categoria,$cantidad_hijos);
		}
		//ejecuto la consulta
		$resultado_categoria	=	$db->GetAll($consulta_categoria);
		//retorno el resultado
		return $resultado_categoria;

	}
	
	//funcion que permite lograr la estructura del home
	function nuevoHome($idcategoria)
	{
		global $db;
		/**
		 * Limpiando contenido
		 **/
		$contenido = str_replace(' ', '', $idcategoria);
		$contenido = explode(',', $contenido);
		$arraySecciones = array();

		while(list($k, $seccionActual) = each($contenido)) {

			$seccion = explode('#', $seccionActual);
			$parametros	= count($seccion);
			$seccionBuscar = $seccion[0];

//			Verifica que la categoria este activa para traer los hijos
			$querySeccion = sprintf("SELECT * FROM %s WHERE activa != 0 AND idcategoria = '%s'" , _TBLCATEGORIA , $seccionBuscar);
			$resultSeccion = $db->Execute($querySeccion) or errorQuery(__LINE__, __FILE__);
			$dSeccion = $resultSeccion->fields;

			if ($resultSeccion->NumRows() > 0) {
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
				$queryHijos = sprintf("SELECT * FROM %s WHERE activa != 0 AND idpadre = '%s' and fecha2 >= '%s' ORDER BY fecha1 DESC, idcategoria DESC" , _TBLCATEGORIA , $seccionBuscar, date('Y-m-d'));
				$resultHijos = $db->SelectLimit($queryHijos, $cantidad) or errorQuery(__LINE__, __FILE__);

				if ($resultHijos->NumRows() > 0) {
//					Buscando info de la seccion elegida
//					$querySeccion = sprintf("SELECT * FROM %s WHERE activa != 0 AND idcategoria = '%s'" , _TBLCATEGORIA , $seccionBuscar);
//					$resultSeccion = $db->Execute($querySeccion) or errorQuery(__LINE__, __FILE__);
//					$dSeccion = $resultSeccion->fields;
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
						$auxHijos['antetitulo'] = $dHijos['antetitulo'];
						$auxHijos['subtitulo'] = $dHijos['subtitulo'];
						$auxHijos['nombre'] = $dHijos['nombre'];
						$auxHijos['resumen'] = stripslashes($dHijos['entradilla']);
						$auxHijos['contenido'] = stripslashes($dHijos['descripcion']);
						$auxHijos['imagen'] = $dHijos['imagen'];
						$auxHijos['autor'] = $dHijos['autor'];
						$auxHijos['fecha'] = $dHijos['fecha1'];
                        $auxHijos['fecha2'] = $dHijos['fecha1'];
                        if ($seccionBuscar == "413") {
                        	$auxHijos['subtitulo'] = mb_strtoupper($dHijos['subtitulo'],'iso-8859-1');
                        }
						array_push($arrayhijos, $auxHijos);

						$resultHijos->MoveNext();
					}

					$arraySeccionActual['hijos'] = $arrayhijos;
					array_push($arraySecciones, $arraySeccionActual);
				}
			}
		}//cierra primer while
		return $arraySecciones;
	}//cierra la funcion nuevoHome
	//funcion que retorna el nombre del padre la la categoria
	function NombrePadre($categoria)
	{
		//llamo la conexion a la bd
		global $db;
		//separo la constante de sitio
		$id_padre	=	explode('#',$categoria);
		//realizo la consulta que me traera los datos del padre
		$datos_padre	=	sprintf("SELECT * FROM categoria WHERE idcategoria=%s",$id_padre[0]);
		//ejecuto la consulta
		$resultado_datos_padre	=	$db->Execute($datos_padre);
		//retorno los datos
		return $resultado_datos_padre->fields;

	}
	
	//funcion que me permitira cambiar aleatoriamente los hijos de las categorias que consulta
	function nuevoHome2($idcategoria)
	{
		global $db;
		/**
		 * Limpiando contenido
		 **/
		$contenido = str_replace(' ', '', $idcategoria);
		$contenido = explode(',', $contenido);
		$arraySecciones = array();
	foreach($contenido as $llave=>$dato)
	{
			$seccion = explode('#', $dato);
			$parametros	= count($seccion);
			$seccionBuscar = $seccion[0];
			
//			Verifica que la categoria este activa para traer los hijos
			$querySeccion = sprintf("SELECT * FROM %s WHERE activa != 0 AND idcategoria = '%s'" , _TBLCATEGORIA , $seccionBuscar);
			$resultSeccion = $db->Execute($querySeccion) or errorQuery(__LINE__, __FILE__);
			$dSeccion = $resultSeccion->fields;
			if ($resultSeccion->NumRows() > 0) {
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

				//consulto la cantidad de hijos que tenga la categoria para formar un arreglo y poder llamarlo aleaotriamente		
				$queryHijos1 = sprintf("SELECT * FROM %s WHERE activa != 0 AND idpadre = '%s' and eliminado=0 ORDER BY fecha2 DESC" , _TBLCATEGORIA , $seccionBuscar);
				$resultHijos1 = $db->Execute($queryHijos1) or errorQuery(__LINE__, __FILE__);
				//recorro el resultado de la consulta par crear un arreglo
				$datos_final	=	array();
				$datos_final2	=	array();
				$datos_final3	=	array();
				//echo $resultHijos1->fields['idpadre']." ";
				
				while(!$resultHijos1->EOF)
				{
					if($seccionBuscar == $resultHijos1->fields['idpadre'] && $llave == 0)
					{
						$datos=array("titulo"=>$resultHijos1->fields['nombre'],
									 "idcategoria"=>$resultHijos1->fields['idcategoria'],
									 "resumen"=>$resultHijos1->fields['entradilla'],
									 "subtitulo"=>$resultHijos1->fields['subtitulo'],
									 "imagen"=>$resultHijos1->fields['imagen'],
									 "padre"=>$resultHijos1->fields['idpadre']);
						array_push($datos_final,$datos);
					}
					elseif($seccionBuscar == $resultHijos1->fields['idpadre']&& $llave == 1)
					{
						$datos=array("titulo"=>$resultHijos1->fields['nombre'],
									 "idcategoria"=>$resultHijos1->fields['idcategoria'],
									 "resumen"=>$resultHijos1->fields['entradilla'],
									 "imagen"=>$resultHijos1->fields['imagen'],
									 "subtitulo"=>$resultHijos1->fields['subtitulo'],
									 "padre"=>$resultHijos1->fields['idpadre']);
						array_push($datos_final2,$datos);
					}
					elseif($seccionBuscar == $resultHijos1->fields['idpadre']&& $llave == 2)
					{
						$datos=array("titulo"=>$resultHijos1->fields['nombre'],
									 "idcategoria"=>$resultHijos1->fields['idcategoria'],
									 "resumen"=>$resultHijos1->fields['entradilla'],
									 "imagen"=>$resultHijos1->fields['imagen'],
									 "subtitulo"=>$resultHijos1->fields['subtitulo'],
									 "padre"=>$resultHijos1->fields['idpadre']);
						array_push($datos_final3,$datos);
					}
					$resultHijos1->MoveNext();					
				}
				//cuento los respectivos arreglos segun por donde ingrese en los condicionales
				if($seccionBuscar == $seccionBuscar && $llave == 0)
				{
					$cuenta		=	count($datos_final);
					$aleatorio	=	rand(0,$cuenta - 1);
					$cat		=	$datos_final[$aleatorio]['idcategoria'];
					
				}
				elseif($seccionBuscar == $seccionBuscar && $llave == 1)
				{
					$cuenta		=	count($datos_final2);
					$aleatorio	=	rand(1,$cuenta);
					$cat		=	$datos_final2[$aleatorio]['idcategoria'];
				}
				elseif($seccionBuscar == $seccionBuscar && $llave == 2)
				{
					$cuenta		=	count($datos_final3);
					$aleatorio	=	rand(1,$cuenta);
					$cat		=	$datos_final3[$aleatorio]['idcategoria'];

				}
			//	echo $seccionBuscar."<br>";
				//genero un numero aleatorio para saber que posision mostrar
				
				//var_dump($datos_final);
				
				/**
				 * Buscando los hijos de la seccion elegida
				 **/
				//$queryHijos = sprintf("SELECT * FROM %s WHERE activa != 0 AND idpadre = '%s' and fecha2 >= '%s' LIMIT %s" , _TBLCATEGORIA , $seccionBuscar, date('Y-m-d'),$aleatorio);
				//$queryHijos = sprintf("SELECT * FROM %s WHERE activa != 0 AND idpadre = '%s' and fecha2 >= '%s' ORDER BY fecha2 DESC" , _TBLCATEGORIA , $seccionBuscar, date('Y-m-d'));
				$queryHijos = sprintf("SELECT * FROM %s WHERE activa != 0 AND idcategoria = '%s' " , _TBLCATEGORIA , $cat);
				
				//$resultHijos = $db->SelectLimit($queryHijos,$cantidad) or errorQuery(__LINE__, __FILE__);
				$resultHijos = $db->Execute($queryHijos) or errorQuery(__LINE__, __FILE__);
				//echo $queryHijos."<br>";
				if ($resultHijos->NumRows() > 0) {
//					Buscando info de la seccion elegida
//					$querySeccion = sprintf("SELECT * FROM %s WHERE activa != 0 AND idcategoria = '%s'" , _TBLCATEGORIA , $seccionBuscar);
//					$resultSeccion = $db->Execute($querySeccion) or errorQuery(__LINE__, __FILE__);
//					$dSeccion = $resultSeccion->fields;
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
						$auxHijos['subtitulo'] = $dHijos['subtitulo'];
						$auxHijos['autor'] = $dHijos['autor'];
						$auxHijos['fecha'] = $dHijos['fecha1'];
						array_push($arrayhijos, $auxHijos);

						$resultHijos->MoveNext();
					}

					$arraySeccionActual['hijos'] = $arrayhijos;
					array_push($arraySecciones, $arraySeccionActual);
				}
			}
		}//cierra primer while
		return $arraySecciones;
	}//cierra la funcion nuevoHome
}
?>
