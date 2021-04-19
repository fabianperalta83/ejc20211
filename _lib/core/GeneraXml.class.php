<?php
/**
 * Class GeneraXml
 * @package Núcleo
 * @author Jeisson Leiva <jleiva@micrositios.net>
 * @version 1.0
 * @copyright Copyright © 2008 Micrositios Ltda.
 */

class GeneraXml
{
	/**
	 * GeneraXml::generaxml 
	 * Genera un archivo xml
	 * @param array encabezados, array resulset
	 * @return
	 */
	 function generaXml($encabezados, $resulset)
	 {
	 	/***** Traemos las variables globales *****/
	 	global $db; //see variables.php
	 	/***
	 	 * inicializamos las variables a usar 
	 	 ***/
	 	$eof			= "\n";
	 	$arregloindices = array();
	 	
	 	//$arregloindices = array_keys($resulset);		//metemos los indices en un arreglo para luego poderlos contar
	 	
	 	$contarencabezados 	= count($encabezados); 		//contamos los indices de los encabezados
	 	$contarindices 		= count($resulset[0]); 	//contamos los indices del resultset
	 	$tamano = count($resulset);
	 	
	 	$xml = '<?xml version="1.0" encoding="ISO-8859-1"?>'.$eof;
		$xml .= '<generaxml>'.$eof;
	 	//echo $contarencabezados."-".$contarindices;
		if($contarencabezados==$contarindices)
		{
			$cont = 0;
			
			while($cont < $tamano)
			{
				$xml .= '<entidad>'.$eof;
				
				$i=0; //inicializamos el contador
				
				foreach ($resulset[$cont] as $fila=>$valor)
				{
					if(trim($valor)=='')
					{
						$valor = '--';
					}
					$valor = ereg_replace('\&', ' y ', $valor);
					$xml .= '<'.$encabezados[$i].'>'.$valor.'</'.$encabezados[$i].'>'.$eof;
					$i++;								
				}	
				$xml .= '</entidad>'.$eof;
				$cont++;
			}
						
		}
		else 
		{
			
			return false;	
		}
		$xml .= '</generaxml>';
		header('Pragma: private');
		header('Cache-control: private, must-revalidate');
		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="archivo'.date("Ymd").'.xml"');
		//echo "<pre>";print_r($xml);echo "</pre>";
		echo $xml;
		exit(0);
	}
}
?>