<?php
require_once(_DIRCORE."FuncionesInterfaz.class.php");
require_once(_DIRCORE."FuncionesDisplay.class.php");
require_once(_DIRLIB."pqr/funciones_pqr.php");
require_once(_DIRINTERFAZ."tpl_cabezote.php");
require_once(_DIRINTERFAZ."tpl_contenido.php");
require_once(_DIRINTERFAZ."tpl_home.php");
require_once(_DIRINTERFAZ."tpl_lateral.php");
require_once(_DIRINTERFAZ."tpl_lateral_derecho.php");
require_once(_DIRINTERFAZ."tpl_pie.php");
require ('_include/fpdf.php');
require_once('_include/core.php'); /*PARA EL BARCODE*/

function CrearInformePdf(){
	$solicitudes_recibidas_actual	=	0;
	$reporte						=	getVariable('portya','');
	$reporte_mrecepcion				=	getVariable('por_mrecepcion','');
	$reporte_tipoyjef				=	getVariable('portyj','');
	$seguimiento					=	getVariable('seguimiento','');
	$conclusiones					=	getVariable('conclusiones','');
	$recomendaciones				=	getVariable('recomendaciones','');
	$select							=	getVariable('datos','');
	$asunto_dato					=	getVariable('asunto','');
	$al								=	getVariable('al','');
	$cargo_dato						=	getVariable('firma','');
	$numero_of						=	getVariable('oficio_numero','');
	$demo							=	getVariable('demo','');
	$apoyo							=	getVariable('apoyo','');
	$indicadores					=	getVariable('indicadores','');
	$rango							=	getVariable('rango','');
	$nombre							=	getVariable('nombre','');
	$desde							=	getVariable('fecha_inicial','');
	$hasta							=	getVariable('fecha_final','');
	$visto							=	getVariable('visto');
	$elaboro					    =	getVariable('elaboro');
	$ayudante						=	getVariable('ayudante');
	$ayudante_cargo					=	getVariable('ayudante_cargo');
	$periodo						=	getVariable('periodo');
	$fecha_inicial_traida			=	getVariable('fecha_inicial');
	$fecha_final_traida				=	getVariable('fecha_final');
if($select == 1)												/*SE VALIDA SI EL INFORME QUE SE SELCCIONO EL EL GERENCIAL*/
{
	global $db;
	
	$mes=date('F');
	
	if ($mes=='January'){
		$mes='Enero';
	}
	elseif ($mes=='February'){
		$mes='Febrero';
	}
	elseif ($mes=='March'){
		$mes='Marzo';
	}
	elseif ($mes=='April'){
		$mes='Abril';
	}
	elseif ($mes=='May'){
		$mes='Mayo';
	}
	elseif ($mes=='June'){
		$mes='Junio';
	}
	elseif ($mes=='July'){
		$mes='Julio';
	}
	elseif ($mes=='August'){
		$mes='Agosto';
	}
	elseif ($mes=='September'){
		$mes='Septiembre';
	}
	elseif ($mes=='October'){
		$mes='Octubre';
	}
	elseif ($mes=='November'){
		$mes='Noviembre';
	}
	elseif ($mes=='December'){
		$mes='Diciembre';
	}
	
	$pdf = new FPDF();
	$pdf=new PDF();
	$pdf->Open();
	$pdf->AliasNbPages();
	$pdf->AddPage('P');
	$pdf->SetMargins(2,2);
	$pdf->SetFont('Arial','',12);
	$pdf->SetDisplayMode('real');
	$pdf->SetTitle('Reporte Gerencial');
	$pdf->SetFillColor(255,255,255);
	$pdf->image('_templates/Default/recursos/images/encabezadoinforme.jpg',22,20,125,33);
	$pdf->Cell(178,118,'Bogotá, D.C., '.$mes.' '.date('d').' de '.date('Y'),0,0,'R',0);
	$pdf->SetY(90);
	$pdf->SetX(35);
	$pdf->SetFont('Arial','B',12);
	$pdf->SetAligns(array('L'));
	$pdf->SetWidths(array(150));
	$pdf->MultiCell(150,5,$numero_of,0,'L',0);
	$pdf->setY(106);
	$pdf->SetX(35);
	$pdf->SetAligns(array('L'));
	$pdf->SetWidths(array(30));
	$pdf->MultiCell(30,5,'ASUNTO      :',0,'L',0);
	$pdf->SetFont('Arial','',12);
	$pdf->setY(106);
	$pdf->SetX(65);
	$pdf->SetAligns(array('L'));
	$pdf->SetWidths(array(120));
	$pdf->MultiCell(120,5,$asunto_dato,0,'L',0);
	$pdf->SetY(120);
	$pdf->SetFont('Arial','B',12);
	$pdf->SetX(35);
	$pdf->SetAligns(array('L'));
	$pdf->SetWidths(array(30));
	$pdf->MultiCell(30,5,'AL                :',0,'L',0);
	$pdf->SetFont('Arial','',12);
	$pdf->setY(120);
	$pdf->SetX(65);
	$pdf->SetAligns(array('L'));
	$pdf->SetWidths(array(120));
	$pdf->MultiCell(120,5,$al,0,'L',0);
	$pdf->SetFont('Arial','B',12);
	$pdf->setY(125);
	$pdf->SetX(65);
	$pdf->SetAligns(array('L'));
	$pdf->SetWidths(array(120));
	$pdf->MultiCell(120,5,$cargo_dato,0,'L',0);
	$pdf->SetX(65);
	$pdf->MultiCell(15,5,'Gn.-',0,'L',0);		
/* ojo */
	
	$sql_consulta_partes = sprintf('SELECT * FROM pqr_informe_gerencial');
			
    $resultado_consulta_partes = $db->Execute($sql_consulta_partes) or errorQuery(__LINE__, __FILE__);	

    while(!$resultado_consulta_partes->EOF){    
    	/*FECHAS INICIALES*/
    	$fecha_inicial       = $resultado_consulta_partes->fields['fecha_inicial'];
    	$fecha_final		 = $resultado_consulta_partes->fields['fecha_final'];
  		
    	/*TITULO DEL INFORME*/
    	$titulo_informe_bd   = strtoupper(eregi_replace("año","AÑO",$resultado_consulta_partes->fields['titulo_informe']));     //mayusculas
		$titulo_informe_modi = strtolower(eregi_replace("año","del año",$resultado_consulta_partes->fields['titulo_informe'])); //minusculas
   		
		$oficio_numero 		 = $resultado_consulta_partes->fields['oficio_numero'];
		$textoasunto  		 = $resultado_consulta_partes->fields['asuntos_trimestres'];

   		/*ARRAY TITULO DEL INFORME*/
		$datos = explode(" ",$titulo_informe_modi);
		$dato1 = $datos[0];
		$dato2 = $datos[1];
		$dato3 = $datos[2];
		$dato4 = $datos[3];
		$dato5 = $datos[4];
		$titulo_informe_modi_1 = strtolower(eregi_replace("año","del año",$resultado_consulta_partes->fields['titulo_informe'])); 
		
		/*POSIBLES PERIODOS*/	
		$periodo1 				= 'PRIMER';
		$periodo2 				= 'SEGUNDO';
		$periodo3 				= 'TERCER';
		$periodo4 				= 'CUARTO';
		$mes_fecha_final_abrev  = '';
		$periodo_anterior  		= '';
		
		if(strtoupper($dato1)==$periodo1){
			$periodo_anterior=$periodo4;
		}
		if(strtoupper($dato1)==$periodo2){
			$periodo_anterior=$periodo1;
		}		
		if(strtoupper($dato1)==$periodo3){
			$periodo_anterior=$periodo2;
		}
		if(strtoupper($dato1)==$periodo4){
			$periodo_anterior=$periodo3;
		}					
		/*ARREGLOS FECHAS ACTUALES*/	
		$arreglo_fecha_inicial=explode("-",$fecha_inicial);
		$dia_fecha_inicial=$arreglo_fecha_inicial[2];
		$mes_fecha_inicial=$arreglo_fecha_inicial[1];
		$ano_fecha_inicial=$arreglo_fecha_inicial[0];	
		
		$arreglo_fecha_final=explode("-",$fecha_final);
		$dia_fecha_final=$arreglo_fecha_final[2];
		$mes_fecha_final=$arreglo_fecha_final[1];
		$ano_fecha_final=$arreglo_fecha_final[0];
					
		/*DEFINO FECHAS DE UN PERIODO ANTERIOR*/		
		$meses_periodo 		 = ($mes_fecha_final - $mes_fecha_inicial)+1;
		$fecha_inicial		 = strtotime($fecha_inicial);
		$fecha_inicial_nueva = strtotime("-".$meses_periodo." month",$fecha_inicial);
		$fecha_inicial_nueva = date("Y-m-d",$fecha_inicial_nueva);
		
		$fecha_final        = strtotime($fecha_final);
		$fecha_final_nueva  = strtotime("-".$meses_periodo." month",$fecha_final);
		$fecha_final_nueva  = date("Y-m-d",$fecha_final_nueva);
		
		$arreglo_fecha_final_nueva=explode("-",$fecha_final_nueva);
		$dia_fecha_final_nueva=$arreglo_fecha_final_nueva[2];
		$mes_fecha_final_nueva=$arreglo_fecha_final_nueva[1];
		$ano_fecha_final_nueva=$arreglo_fecha_final_nueva[0];
		
		if ($mes_fecha_final_nueva == '1' and $dia_fecha_final_nueva != '31'){
			$arreglo_fecha_final_nueva[2] = '31';
		}
		elseif ($mes_fecha_final_nueva == '2' and $ano_fecha_final_nueva%4 == '0' and $dia_fecha_final_nueva != '29'){
			$arreglo_fecha_final_nueva[2] = '29';		
		}
		elseif ($mes_fecha_final_nueva == '2' and $ano_fecha_final_nueva%4 != '0' and $dia_fecha_final_nueva != '28'){
			$arreglo_fecha_final_nueva[2] = '28';		
		}
		elseif ($mes_fecha_final_nueva == '3' and $dia_fecha_final_nueva != '31'){
			$arreglo_fecha_final_nueva[2] = '31';
		}
		elseif ($mes_fecha_final_nueva == '4' and $dia_fecha_final_nueva != '30'){
			$arreglo_fecha_final_nueva[2] = '30';
		}
		elseif ($mes_fecha_final_nueva == '5' and $dia_fecha_final_nueva != '31'){
			$arreglo_fecha_final_nueva[2] = '31';
		}
		elseif ($mes_fecha_final_nueva == '6' and $dia_fecha_final_nueva != '30'){
			$arreglo_fecha_final_nueva[2] = '30';
		}
		elseif ($mes_fecha_final_nueva == '7' and $dia_fecha_final_nueva != '31'){
			$arreglo_fecha_final_nueva[2] = '31';
		}
		elseif ($mes_fecha_final_nueva == '8' and $dia_fecha_final_nueva != '31'){
			$arreglo_fecha_final_nueva[2] = '31';
		}
		elseif ($mes_fecha_final_nueva == '9' and $dia_fecha_final_nueva != '30'){
			$arreglo_fecha_final_nueva[2] = '30';
		}
		elseif ($mes_fecha_final_nueva == '10' and $dia_fecha_final_nueva != '31'){
			$arreglo_fecha_final_nueva[2] = '31';
		}
		elseif ($mes_fecha_final_nueva == '11' and $dia_fecha_final_nueva != '30'){
			$arreglo_fecha_final_nueva[2] = '30';
		}
		elseif ($mes_fecha_final_nueva == '12' and $dia_fecha_final_nueva != '31'){
			$arreglo_fecha_final_nueva[2] = '31';
		}

		/*MOSTRANDO EL MES EN LETRAS ABREVIATURA*/	
		if ($mes_fecha_final_nueva=='1'){
			$mes_fecha_final_abrev='Ene';
		}
		elseif ($mes_fecha_final_nueva=='2'){
			$mes_fecha_final_abrev='Feb';
		}
		elseif ($mes_fecha_final_nueva=='3'){
			$mes_fecha_final_abrev='Mar';
		}
		elseif ($mes_fecha_final_nueva=='4'){
			$mes_fecha_final_abrev='Abr';
		}
		elseif ($mes_fecha_final_nueva=='5'){
			$mes_fecha_final_abrev='May';
		}
		elseif ($mes_fecha_final=='6'){
			$mes_fecha_final_abrev='Jun';
		}
		elseif ($mes_fecha_final_nueva=='7'){
			$mes_fecha_final_abrev='Jul';
		}
		elseif ($mes_fecha_final_nueva=='8'){
			$mes_fecha_final_abrev='Agos';
		}
		elseif ($mes_fecha_final_nueva=='9'){
			$mes_fecha_final_abrev='Sep';
		}
		elseif ($mes_fecha_final_nueva=='10'){
			$mes_fecha_final_abrev='Oct';
		}
		elseif ($mes_fecha_final_nueva=='11'){
			$mes_fecha_final_abrev='Nov';
		}
		elseif ($mes_fecha_final_nueva=='12'){
			$mes_fecha_final_abrev='Dic';
		}
		
		$dia_fecha_final_nueva=$arreglo_fecha_final_nueva[2];
		$fecha_final_nueva_agrupada = implode("-", $arreglo_fecha_final_nueva);
		
		$resultado_consulta_partes->MoveNext();	
    }	
    
    $resultado_solicitud = array();
     
    		
	//	echo $fecha_inicial_nueva, $fecha_final_nueva_agrupada;

	
    /******** CONSULTA PARA LLENAR LA TABLA SEGUIMIENTO SOLICITUDES PENDIENTES **********/
	
    /*CONSULTO LAS SOLICITUDES RECIBIDAS EN EL TRIMESTRE ANTERIOR*/
    
    $sql_solicitudes_recibidas	= sprintf('
								SELECT 	count(solicitud.solicitud_id) as cantidad
								FROM 	%s as solicitud, %s as transaccion, %s as tipo
								WHERE 	transaccion.solicitud_id=solicitud.solicitud_id and 
										tipo.tipo_id=transaccion.tipo_id and
									  	solicitud.creacion between "%s" and "%s" and
									  	transaccion.transaccion_id = solicitud.estado_actual',

								_TBL_PQR_SOLICITUD,
								_TBL_PQR_TRANSACCION,
								_TBL_PQR_TIPO,
								$fecha_inicial_nueva,
								$fecha_final_nueva_agrupada);
								
	$resultado_solicitudes_recibidas	= $db->Execute($sql_solicitudes_recibidas) or errorQuery(__LINE__, __FILE__);
	if($resultado_solicitudes_recibidas)
	{
		while(!$resultado_solicitudes_recibidas->EOF)
		{
			$solicitudes_recibidas = $resultado_solicitudes_recibidas->fields['cantidad'];
			$resultado_solicitudes_recibidas->MoveNext();
		}
	}	 

	
	$abierto_anterior     	= 0;
	$entramite_anterior   	= 0;
	$cerrado_anterior     	= 0;
	$incompleta_anterior  	= 0;
	$desistimiento_anterior = 0;
	
	$abierto_actual     	= 0;
	$entramite_actual   	= 0;
	$cerrado_actual     	= 0;
	$incompleta_actual  	= 0;
	$desistimiento_actual 	= 0;
	$porcentaje_cien 		= 100;
	
	/* CALCULAR EL AVANCE ANTERIOR */
	$sql_solicitudes_estado_anterior = sprintf('
							SELECT	count(t.solicitud_id) as cantidad, 
									e.estado_id, 
									left(e.estado_nombre,35) as estado_nombre
							FROM 	%s s, %s t, %s e 
							WHERE 	e.estado_id=t.estado_id and 
									t.solicitud_id=s.solicitud_id and 
									date(s.creacion) between "%s" and "%s" and 
								  	t.transaccion_id = s.estado_actual
							GROUP BY e.estado_id
							ORDER BY cantidad desc',

		_TBL_PQR_SOLICITUD,
		_TBL_PQR_TRANSACCION,
		_TBL_PQR_ESTADO,
		$fecha_inicial_nueva,
		$fecha_final_nueva_agrupada);
		
	$resultado_solicitudes_estado_anterior =$db->Execute($sql_solicitudes_estado_anterior);
	if($resultado_solicitudes_estado_anterior)
	{
		while(!$resultado_solicitudes_estado_anterior->EOF)
		{
			
			$cantidad      = $resultado_solicitudes_estado_anterior->fields['cantidad'];
			$estado_id     = $resultado_solicitudes_estado_anterior->fields['estado_id'];
			$estado_nombre = $resultado_solicitudes_estado_anterior->fields['estado_nombre'];
			
			if($estado_id==1)
			{
				$abierto_anterior  = $cantidad;
			}
			
			if($estado_id==2)
			{
				$entramite_anterior  = $cantidad;
			}
			
			if($estado_id==3)
			{
				$cerrado_anterior  = $cantidad;
			}
			
			if($estado_id==5)
			{
				$incompleta_anterior  = $cantidad;
			}
			
			if($estado_id==6)
			{
				$desistimiento_anterior  = $cantidad;
			}
						
			$resultado_solicitudes_estado_anterior->MoveNext();
		}
	}
		
	$solicitudes_incompletas_anterior  = $incompleta_anterior  + $desistimiento_anterior ;
	$solicitudes_resueltas_anterior    = $cerrado_anterior ;
	$solicitudes_pendientes_anterior   = $abierto_anterior  + $entramite_anterior;
	$avance_anterior                   = round(((($solicitudes_incompletas_anterior + $solicitudes_resueltas_anterior)*100)/$solicitudes_recibidas),2);
	
	/*CALCULAR EL AVANCE ACTUAL*/
	
		$fecha_final_nueva_agrupada = strtotime($fecha_final_nueva_agrupada);
		$fecha_final = strtotime("+".$meses_periodo." month",$fecha_final_nueva_agrupada);
		$fecha_final_nueva_agrupada = date("Y-m-d",$fecha_final_nueva_agrupada);
		$fecha_inicial = date("Y-m-d",$fecha_inicial);
		$fecha_final = date("Y-m-d",$fecha_final);

		$sql_solicitudes_estado_actual = sprintf('
							SELECT 	count(t.solicitud_id) as cantidad, 
									e.estado_id, 
									left(e.estado_nombre,35) as estado_nombre
							FROM 	%s s, %s t, %s e 
							WHERE 	e.estado_id=t.estado_id and 
									t.solicitud_id=s.solicitud_id and 
									date(s.creacion) between "%s" and "%s" and 
								  	t.transaccion_id = s.estado_actual
							GROUP BY e.estado_id
							ORDER BY cantidad desc',

		_TBL_PQR_SOLICITUD,
		_TBL_PQR_TRANSACCION,
		_TBL_PQR_ESTADO,
		$fecha_inicial_nueva,
		$fecha_final_nueva_agrupada);
		
	$resultado_solicitudes_estado_actual =$db->Execute($sql_solicitudes_estado_actual);
	if($resultado_solicitudes_estado_actual){
		while(!$resultado_solicitudes_estado_actual->EOF){
			
			$cantidad      = $resultado_solicitudes_estado_actual->fields['cantidad'];
			$estado_id     = $resultado_solicitudes_estado_actual->fields['estado_id'];
			$estado_nombre = $resultado_solicitudes_estado_actual->fields['estado_nombre'];
			
			if($estado_id==1)
			{
				$abierto_actual = $cantidad;
			}
			
			if($estado_id==2)
			{
				$entramite_actual = $cantidad;
			}
			
			if($estado_id==3)
			{
				$cerrado_actual = $cantidad;
			}
			
			if($estado_id==5)
			{
				$incompleta_actual = $cantidad;
			}
			
			if($estado_id==6)
			{
				$desistimiento_actual = $cantidad;
			}
						
			$resultado_solicitudes_estado_actual->MoveNext();
		}
	}
		
	$solicitudes_incompletas_actual = $incompleta_actual + $desistimiento_actual;
	$solicitudes_resueltas_actual   = $cerrado_actual;
	$solicitudes_pendientes_actual  = $abierto_actual + $entramite_actual;
	$avance_actual        = round(((($solicitudes_incompletas_actual + $solicitudes_resueltas_actual)*100)/$solicitudes_recibidas),2);
	
   
    $pdf->SetY(150);
   	$pdf->SetFont('Arial','',10);
	$pdf->SetX(70);
	$pdf->SetAligns(array('J'));
	$pdf->SetWidths(array(120));
	//$pdf->Row(array('En cumplimiento a lo ordenado en la Directiva Permanente Nr. 015-'));
	//$pdf->MultiCell(120,5,'En cumplimiento a lo ordenado en la Directiva',0,'L',0);
	
	if(strlen($dato1)>6)
	{
	$pdf->SetY(145);
	$pdf->SetX(65);
	$pdf->SetAligns(array('J'));
	$pdf->SetWidths(array(150));
	$pdf->MultiCell(130,6,'El Ejercito Nacional presenta el informe de resultados de Peticiones,',0,'J',0);
	$pdf->SetX(35);
	$pdf->MultiCell(150,5,'Quejas, Reclamos y Consultas de la Ciudadanía, Democratización de  la  Gestión  Pública  y  Lucha  Contra  la  Corrupción, correspondiente  al '.$periodo.' ,asi:',0,'J',0);
	}
	
	else 
	{
	$pdf->SetY(145);
	$pdf->SetX(65);
	$pdf->SetAligns(array('J'));
	$pdf->SetWidths(array(150));
	$pdf->MultiCell(130,6,'Con toda atención me permito presentar el informe de resultados de Peticiones,',0,'J',0);
	$pdf->SetX(35);
	$pdf->MultiCell(160,5,'Quejas, Reclamos y Consultas de la Ciudadanía, Democratización de  la  Gestión  Pública  y  Lucha  Contra  la  Corrupción, correspondiente  al '.$periodo.', asi:',0,'J',0);
	}
    
    $pdf->SetY(185);
    $pdf->SetX(35);
    $pdf->SetFont('Arial','B',12);
	$pdf->SetAligns(array('L'));
	$pdf->SetWidths(array(150));
	//$pdf->Row(array('I.  SOLICITUDES DEL CIUDADANO'));
	$pdf->MultiCell(150,5,'I.  SOLICITUDES DEL CIUDADANO',0,'L',0);
	
	$pdf->SetY(200);
    $pdf->SetX(35);
    $pdf->SetFont('Arial','',10);
	$pdf->SetAligns(array('L'));
	$pdf->SetWidths(array(150));
	//$pdf->Row(array('    1. SEGUIMIENTO SOLICITUDES PENDIENTES '.$periodo_anterior.' / '.$ano_fecha_final_nueva));
	$pdf->MultiCell(150,5,'    1. SEGUIMIENTO SOLICITUDES PENDIENTES '.$periodo_anterior.' / '.$ano_fecha_final_nueva,0,'L',0);
	
	$pdf->SetY(215);
    $pdf->SetX(35);
    $pdf->SetFont('Arial','',10);
	$pdf->SetAligns(array('C','C','C','C','C','C'));
	$pdf->SetWidths(array(25,25,25,25,25,25));
	$pdf->Row(array('Recibidas','Incompletas o Desistimientos','Resueltas a '.$dia_fecha_final_nueva.' '.$mes_fecha_final_abrev.' '.$ano_fecha_final_nueva,'Pendientes','Avance Anterior','Avance Actual'));
	
	$pdf->SetY(225);
	$pdf->SetX(35);
	$pdf->SetFont('Arial','',10);
	$pdf->SetAligns(array('C','C','C','C','C','C'));
	$pdf->SetWidths(array(25,25,25,25,25,25));
	$pdf->Row(array($solicitudes_recibidas,$solicitudes_incompletas_anterior,$solicitudes_resueltas_anterior,$solicitudes_pendientes_anterior,$avance_anterior,$avance_actual));
	
	
	
    
    $pdf->image('_templates/Default/recursos/images/piedepagina.jpg',40,260,142,21);
}

														/*TERMINA LA VALIDACION DEL REPORTE ESPECIFICO*/


elseif ($select == 2)									/*SE VALIDA SI EL REPORTE ES EL BASICO*/
{
	global $db;
	
	$pdf = new FPDF();
	$pdf=new PDF();
	$pdf->Open();
	$pdf->AliasNbPages();
	$pdf->AddPage('P');
	$pdf->SetMargins(2,2);
	$pdf->SetFont('Arial','',12);
	$pdf->SetDisplayMode('real');
	$pdf->SetTitle('Reporte Gerencial');
	$pdf->SetFillColor(255,255,255);
		
	$pdf->image('_templates/Default/recursos/images/encabezadoinforme.jpg',22,20,120,33);
	
	/*TRADUCIR MES*/
	$mes=date('F');
	
	if ($mes=='January'){
		$mes='Enero';
	}
	elseif ($mes=='February'){
		$mes='Febrero';
	}
	elseif ($mes=='March'){
		$mes='Marzo';
	}
	elseif ($mes=='April'){
		$mes='Abril';
	}
	elseif ($mes=='May'){
		$mes='Mayo';
	}
	elseif ($mes=='June'){
		$mes='Junio';
	}
	elseif ($mes=='July'){
		$mes='Julio';
	}
	elseif ($mes=='August'){
		$mes='Agosto';
	}
	elseif ($mes=='September'){
		$mes='Septiembre';
	}
	elseif ($mes=='October'){
		$mes='Octubre';
	}
	elseif ($mes=='November'){
		$mes='Noviembre';
	}
	elseif ($mes=='December'){
		$mes='Diciembre';
	}
	
	$pdf->Cell(178,118,'Bogotá, D.C., '.$mes.' '.date('d').' de '.date('Y'),0,0,'R',0);
	
	$pdf->ln(2);
	$pdf->SetFont('Arial','B',12);
	
	$pdf->Cell(200,155,'INFORME DE GESTIÓN EN ATENCIÓN AL CIUDADANO',0,0,'C',0);    
 
	$sql_consulta_partes = sprintf('SELECT fecha_inicial,fecha_final,titulo_informe,oficio_numero,asuntos_trimestres FROM pqr_informe_gerencial');
			
    $resultado_consulta_partes = $db->Execute($sql_consulta_partes) or errorQuery(__LINE__, __FILE__);	

    while(!$resultado_consulta_partes->EOF){    
    	/*FECHAS INICIALES*/
    	$fecha_inicial       = $resultado_consulta_partes->fields['fecha_inicial'];
    	$fecha_final		 = $resultado_consulta_partes->fields['fecha_final'];
  		
    	/*TITULO DEL INFORME*/
    	$titulo_informe_bd   = strtoupper(eregi_replace("año","AÑO",$resultado_consulta_partes->fields['titulo_informe']));     //mayusculas
		$titulo_informe_modi = strtolower(eregi_replace("año","del año",$resultado_consulta_partes->fields['titulo_informe'])); //minusculas
   		
		$oficio_numero 		 = $resultado_consulta_partes->fields['oficio_numero'];
		$textoasunto  		 = $resultado_consulta_partes->fields['asuntos_trimestres'];

   		/*ARRAY TITULO DEL INFORME*/
		$datos = explode(" ",$titulo_informe_modi);
		$dato1 = $datos[0];
		$dato2 = $datos[1];
		$dato3 = $datos[2];
		$dato4 = $datos[3];
		$dato5 = $datos[4];
		$titulo_informe_modi_1 = strtolower(eregi_replace("año","del año",$resultado_consulta_partes->fields['titulo_informe'])); 
		
		/*POSIBLES PERIODOS*/	
		$periodo1 				= 'PRIMER';
		$periodo2 				= 'SEGUNDO';
		$periodo3 				= 'TERCER';
		$periodo4 				= 'CUARTO';
		$mes_fecha_final_abrev  = '';
		$periodo_anterior  		= '';
		
		if(strtoupper($dato1)==$periodo1){
			$periodo_anterior=$periodo4;
		}
		if(strtoupper($dato1)==$periodo2){
			$periodo_anterior=$periodo1;
		}		
		if(strtoupper($dato1)==$periodo3){
			$periodo_anterior=$periodo2;
		}
		if(strtoupper($dato1)==$periodo4){
			$periodo_anterior=$periodo3;
		}					
		/*ARREGLOS FECHAS ACTUALES*/	
		$arreglo_fecha_inicial=explode("-",$fecha_inicial);
		$dia_fecha_inicial=$arreglo_fecha_inicial[2];
		$mes_fecha_inicial=$arreglo_fecha_inicial[1];
		$ano_fecha_inicial=$arreglo_fecha_inicial[0];	
		
		$arreglo_fecha_final=explode("-",$fecha_final);
		$dia_fecha_final=$arreglo_fecha_final[2];
		$mes_fecha_final=$arreglo_fecha_final[1];
		$ano_fecha_final=$arreglo_fecha_final[0];
					
		/*DEFINO FECHAS DE UN PERIODO ANTERIOR*/		
		$meses_periodo 		 = ($mes_fecha_final - $mes_fecha_inicial)+1;
		$fecha_inicial		 = strtotime($fecha_inicial);
		$fecha_inicial_nueva = strtotime("-".$meses_periodo." month",$fecha_inicial);
		$fecha_inicial_nueva = date("Y-m-d",$fecha_inicial_nueva);
		
		$fecha_final        = strtotime($fecha_final);
		$fecha_final_nueva  = strtotime("-".$meses_periodo." month",$fecha_final);
		$fecha_final_nueva  = date("Y-m-d",$fecha_final_nueva);
		
		$arreglo_fecha_final_nueva=explode("-",$fecha_final_nueva);
		$dia_fecha_final_nueva=$arreglo_fecha_final_nueva[2];
		$mes_fecha_final_nueva=$arreglo_fecha_final_nueva[1];
		$ano_fecha_final_nueva=$arreglo_fecha_final_nueva[0];
		
		if ($mes_fecha_final_nueva == '1' and $dia_fecha_final_nueva != '31'){
			$arreglo_fecha_final_nueva[2] = '31';
		}
		elseif ($mes_fecha_final_nueva == '2' and $ano_fecha_final_nueva%4 == '0' and $dia_fecha_final_nueva != '29'){
			$arreglo_fecha_final_nueva[2] = '29';		
		}
		elseif ($mes_fecha_final_nueva == '2' and $ano_fecha_final_nueva%4 != '0' and $dia_fecha_final_nueva != '28'){
			$arreglo_fecha_final_nueva[2] = '28';		
		}
		elseif ($mes_fecha_final_nueva == '3' and $dia_fecha_final_nueva != '31'){
			$arreglo_fecha_final_nueva[2] = '31';
		}
		elseif ($mes_fecha_final_nueva == '4' and $dia_fecha_final_nueva != '30'){
			$arreglo_fecha_final_nueva[2] = '30';
		}
		elseif ($mes_fecha_final_nueva == '5' and $dia_fecha_final_nueva != '31'){
			$arreglo_fecha_final_nueva[2] = '31';
		}
		elseif ($mes_fecha_final_nueva == '6' and $dia_fecha_final_nueva != '30'){
			$arreglo_fecha_final_nueva[2] = '30';
		}
		elseif ($mes_fecha_final_nueva == '7' and $dia_fecha_final_nueva != '31'){
			$arreglo_fecha_final_nueva[2] = '31';
		}
		elseif ($mes_fecha_final_nueva == '8' and $dia_fecha_final_nueva != '31'){
			$arreglo_fecha_final_nueva[2] = '31';
		}
		elseif ($mes_fecha_final_nueva == '9' and $dia_fecha_final_nueva != '30'){
			$arreglo_fecha_final_nueva[2] = '30';
		}
		elseif ($mes_fecha_final_nueva == '10' and $dia_fecha_final_nueva != '31'){
			$arreglo_fecha_final_nueva[2] = '31';
		}
		elseif ($mes_fecha_final_nueva == '11' and $dia_fecha_final_nueva != '30'){
			$arreglo_fecha_final_nueva[2] = '30';
		}
		elseif ($mes_fecha_final_nueva == '12' and $dia_fecha_final_nueva != '31'){
			$arreglo_fecha_final_nueva[2] = '31';
		}

		/*MOSTRANDO EL MES EN LETRAS ABREVIATURA*/	
		if ($mes_fecha_final_nueva=='1'){
			$mes_fecha_final_abrev='Ene';
		}
		elseif ($mes_fecha_final_nueva=='2'){
			$mes_fecha_final_abrev='Feb';
		}
		elseif ($mes_fecha_final_nueva=='3'){
			$mes_fecha_final_abrev='Mar';
		}
		elseif ($mes_fecha_final_nueva=='4'){
			$mes_fecha_final_abrev='Abr';
		}
		elseif ($mes_fecha_final_nueva=='5'){
			$mes_fecha_final_abrev='May';
		}
		elseif ($mes_fecha_final=='6'){
			$mes_fecha_final_abrev='Jun';
		}
		elseif ($mes_fecha_final_nueva=='7'){
			$mes_fecha_final_abrev='Jul';
		}
		elseif ($mes_fecha_final_nueva=='8'){
			$mes_fecha_final_abrev='Agos';
		}
		elseif ($mes_fecha_final_nueva=='9'){
			$mes_fecha_final_abrev='Sep';
		}
		elseif ($mes_fecha_final_nueva=='10'){
			$mes_fecha_final_abrev='Oct';
		}
		elseif ($mes_fecha_final_nueva=='11'){
			$mes_fecha_final_abrev='Nov';
		}
		elseif ($mes_fecha_final_nueva=='12'){
			$mes_fecha_final_abrev='Dic';
		}
		
		$dia_fecha_final_nueva=$arreglo_fecha_final_nueva[2];
		$fecha_final_nueva_agrupada = implode("-", $arreglo_fecha_final_nueva);
		
		$resultado_consulta_partes->MoveNext();	
    }	
    
    $resultado_solicitud = array();
     
    		
	//	echo $fecha_inicial_nueva, $fecha_final_nueva_agrupada;

	
    /******** CONSULTA PARA LLENAR LA TABLA SEGUIMIENTO SOLICITUDES PEN4NTES **********/
	
    /*CONSULTO LAS SOLICITUDES RECIBIDAS EN EL TRIMESTRE ANTERIOR*/
    
    $sql_solicitudes_recibidas	= sprintf('
								SELECT count(s.solicitud_id) as cantidad
								FROM %s as s, %s as t, %s as tipo
								WHERE t.solicitud_id=s.solicitud_id and tipo.tipo_id=t.tipo_id and
									  s.creacion between "%s" and "%s" and
									  t.transaccion_id = s.estado_actual',

								_TBL_PQR_SOLICITUD,
								_TBL_PQR_TRANSACCION,
								_TBL_PQR_TIPO,
								$fecha_inicial_nueva,
								$fecha_final_nueva_agrupada);
								
	$resultado_solicitudes_recibidas=$db->Execute($sql_solicitudes_recibidas) or errorQuery(__LINE__, __FILE__);
	if($resultado_solicitudes_recibidas){
		while(!$resultado_solicitudes_recibidas->EOF){
			$solicitudes_recibidas = $resultado_solicitudes_recibidas->fields['cantidad'];
			$resultado_solicitudes_recibidas->MoveNext();
		}
	}	 

	
		
	$abierto_anterior     	= 0;
	$entramite_anterior   	= 0;
	$cerrado_anterior     	= 0;
	$incompleta_anterior  	= 0;
	$desistimiento_anterior = 0;
	
	$abierto_actual     	= 0;
	$entramite_actual   	= 0;
	$cerrado_actual     	= 0;
	$incompleta_actual  	= 0;
	$desistimiento_actual 	= 0;
	$porcentaje_cien 		= 100;
	
	/* CALCULAR EL AVANCE ANTERIOR */
	$sql_solicitudes_estado_anterior = sprintf('
							SELECT count(t.solicitud_id) as cantidad, e.estado_id, left(e.estado_nombre,35) as estado_nombre
							FROM %s s, %s t, %s e 
							WHERE e.estado_id=t.estado_id and t.solicitud_id=s.solicitud_id  
								  and date(s.creacion) between "%s" and "%s" and 
								  t.transaccion_id = s.estado_actual
							GROUP BY e.estado_id
							ORDER BY cantidad desc',

		_TBL_PQR_SOLICITUD,
		_TBL_PQR_TRANSACCION,
		_TBL_PQR_ESTADO,
		$fecha_inicial_nueva,
		$fecha_final_nueva_agrupada,
		_TBL_PQR_SOLICITUD);
		
	$resultado_solicitudes_estado_anterior =$db->Execute($sql_solicitudes_estado_anterior);
	if($resultado_solicitudes_estado_anterior){
		while(!$resultado_solicitudes_estado_anterior->EOF){
			
			$cantidad      = $resultado_solicitudes_estado_anterior->fields['cantidad'];
			$estado_id     = $resultado_solicitudes_estado_anterior->fields['estado_id'];
			$estado_nombre = $resultado_solicitudes_estado_anterior->fields['estado_nombre'];
			
			if($estado_id==1){
				$abierto_anterior  = $cantidad;
			}
			
			if($estado_id==2){
				$entramite_anterior  = $cantidad;
			}
			
			if($estado_id==3){
				$cerrado_anterior  = $cantidad;
			}
			
			if($estado_id==5){
				$incompleta_anterior  = $cantidad;
			}
			
			if($estado_id==6){
				$desistimiento_anterior  = $cantidad;
			}
						
			$resultado_solicitudes_estado_anterior->MoveNext();
		}
	}
		
	$solicitudes_incompletas_anterior  = $incompleta_anterior  + $desistimiento_anterior ;
	$solicitudes_resueltas_anterior    = $cerrado_anterior ;
	$solicitudes_pendientes_anterior   = $abierto_anterior  + $entramite_anterior;
	$avance_anterior                   = round(((($solicitudes_incompletas_anterior + $solicitudes_resueltas_anterior)* 100)/$solicitudes_recibidas));
	
	
	/*CALCULAR EL AVANCE ACTUAL*/
	
		$fecha_final_nueva_agrupada = strtotime($fecha_final_nueva_agrupada);
		$fecha_final = strtotime("+".$meses_periodo." month",$fecha_final_nueva_agrupada);
		$fecha_final_nueva_agrupada = date("Y-m-d",$fecha_final_nueva_agrupada);
		$fecha_inicial = date("Y-m-d",$fecha_inicial);
		$fecha_final = date("Y-m-d",$fecha_final);

		$sql_solicitudes_estado_actual = sprintf('
							SELECT count(t.solicitud_id) as cantidad, e.estado_id, left(e.estado_nombre,35) as estado_nombre
							FROM %s s, %s t, %s e 
							WHERE e.estado_id=t.estado_id and t.solicitud_id=s.solicitud_id  
								  and date(s.creacion) between "%s" and "%s" and 
								  t.transaccion_id = s.estado_actual
							GROUP BY e.estado_id
							ORDER BY cantidad desc',

		_TBL_PQR_SOLICITUD,
		_TBL_PQR_TRANSACCION,
		_TBL_PQR_ESTADO,
		$fecha_inicial_nueva,
		$fecha_final_nueva_agrupada);
		
	$resultado_solicitudes_estado_actual =$db->Execute($sql_solicitudes_estado_actual);
	if($resultado_solicitudes_estado_actual){
		while(!$resultado_solicitudes_estado_actual->EOF){
			
			$cantidad      = $resultado_solicitudes_estado_actual->fields['cantidad'];
			$estado_id     = $resultado_solicitudes_estado_actual->fields['estado_id'];
			$estado_nombre = $resultado_solicitudes_estado_actual->fields['estado_nombre'];
			
			if($estado_id==1){
				$abierto_actual = $cantidad;
			}
			
			if($estado_id==2){
				$entramite_actual = $cantidad;
			}
			
			if($estado_id==3){
				$cerrado_actual = $cantidad;
			}
			
			if($estado_id==5){
				$incompleta_actual = $cantidad;
			}
			
			if($estado_id==6){
				$desistimiento_actual = $cantidad;
			}
						
			$resultado_solicitudes_estado_actual->MoveNext();
		}
	}
		
	$solicitudes_incompletas_actual = $incompleta_actual + $desistimiento_actual;
	$solicitudes_resueltas_actual   = $cerrado_actual;
	$solicitudes_pendientes_actual  = $abierto_actual + $entramite_actual;
	$avance_actual        = round(((($solicitudes_incompletas_actual + $solicitudes_resueltas_actual)*100)/$solicitudes_recibidas));
	
	$pdf->SetFont('Arial','',10);
    $pdf->ln(6);
    $pdf->Cell(200,155,$titulo_informe_bd,0,0,'C',0);
	$pdf->SetY(130);
	$pdf->SetX(65);
	$pdf->SetAligns(array('J'));
	$pdf->SetWidths(array(150));
	$pdf->MultiCell(130,6,'Con toda atención me permito presentar el Informe de Resultados de Peticiones,',0,'J',0);
	$pdf->SetX(35);
	$pdf->MultiCell(160,5,'Quejas, Reclamos y Consultas de la Ciudadanía, Democratización de  la  Gestión  Pública  y  Lucha  Contra  la  Corrupción, correspondiente  al '.$periodo.', Asi:',0,'J',0);

    $pdf->SetY(170);
    $pdf->SetX(35);
    $pdf->SetFont('Arial','B',12);
	$pdf->SetAligns(array('L'));
	$pdf->SetWidths(array(150));
	//$pdf->Row(array('I.  SOLICITUDES DEL CIUDADANO'));
	$pdf->MultiCell(150,5,'I.  SOLICITUDES DEL CIUDADANO',0,'L',0);
	
	$pdf->SetY(200);
    $pdf->SetX(35);
    $pdf->SetFont('Arial','',10);
	$pdf->SetAligns(array('L'));
	$pdf->SetWidths(array(150));
	//$pdf->Row(array('    1. SEGUIMIENTO SOLICITUDES PENDIENTES '.$periodo_anterior.' / '.$ano_fecha_final_nueva));
	$pdf->MultiCell(150,5,'    1. SEGUIMIENTO SOLICITUDES PENDIENTES '.$periodo_anterior.' / '.$ano_fecha_final_nueva,0,'L',0);
	
	$pdf->SetY(215);
    $pdf->SetX(35);
    $pdf->SetFont('Arial','',10);
	$pdf->SetAligns(array('C','C','C','C','C','C'));
	$pdf->SetWidths(array(25,25,25,25,25,25));
	$pdf->Row(array('Recibidas','Incompletas o Desistimientos','Resueltas a '.$dia_fecha_final_nueva.' '.$mes_fecha_final_abrev.' '.$ano_fecha_final_nueva,'Pendientes','Avance Anterior','Avance Actual'));
	
	$pdf->SetY(225);
	$pdf->SetX(35);
	$pdf->SetFont('Arial','',10);
	$pdf->SetAligns(array('C','C','C','C','C','C'));
	$pdf->SetWidths(array(25,25,25,25,25,25));
	$pdf->Row(array($solicitudes_recibidas,$solicitudes_incompletas_anterior,$solicitudes_resueltas_anterior,$solicitudes_pendientes_anterior,$avance_anterior,$avance_actual));
	
	
	
    
    $pdf->image('_templates/Default/recursos/images/piedepagina.jpg',40,260,142,21);
}
		/*-------TERMINA LA COMPARACION SI EL INFORME ES PARA PUBLICAR EN LA PAGINA WEB.-------------------------------------FP*/

	
											/*INICIO DE LA TABLA POR TIPO Y DEPENDENCIA****FP*/
	$pdf->ln(3);
	$pdf->AddPage('P');
	$pdf->SetMargins(2,2);
	$pdf->SetFont('Arial','I',9);
	$pdf->Cell(190,40,"                           ".$oficio_numero,0,0,'L',0);
	$pdf->SetFont('Arial','',12);
	$pdf->ln(15);
	$pdf->Cell(190,45,"                           2. DATOS ESTADÍSTICOS DE LOS REQUERIMIENTOS RECIBIDOS EN EL",0,0,'L',0);	
	$pdf->ln(6);
	$pdf->Cell(190,45,"                               TRIMESTRE",0,0,'L',0);		
	$pdf->SetFont('Arial','B',8);
	
	/*Pinto laprimer celda con el titulo del informe*/
	$pdf->SetFont('Arial','',5);
	$pdf->ln(12);
	$pdf->SetY(55);
	$pdf->SetX(25);
	$pdf->Cell(30,5,"JEFATURAS Y TIPO",1,0,'C',0);	
	
	/*Selecciono los tipos de solicitud*/
	$tipos=sprintf("select tipo_nombre from %s where eliminado=0 order by tipo_id",_TBL_PQR_TIPO);			/*Consulto todos los tipos de solicitud*/
	$resultado_tipos=$db->Execute($tipos);																	/*ejecuto la consulta anterior*/
	while(!$resultado_tipos->EOF)																			/*Creo el ciclo con los tipos de solicitud*/
	{
			$pdf->SetFont('Arial','',5);																	/*asigno el tipo de fuente para la celda que voy a pintar*/
			$pdf->Cell(15,5,$resultado_tipos->fields['tipo_nombre'],1,0,'C',0);								/*Creo las celdas que llevan el tipo de solicitud*/
			$resultado_tipos->MoveNext();																	/*paso al siguiente registro hasta terninar el ciclo*/													 
	}
	$pdf->Cell(10,5,"CANT",1,0,'C',0);																		/*Pinta la celda de la cantidad de forma Vertical*/
	$pdf->Cell(10,5,"%",1,0,'C',0);																			/*Pinta la celda delporcentaje de forma vertical*/
	$jefaturas = sprintf('																			
						SELECT DISTINCT d.dependencia_id, d.dependencia_nombre 
						FROM %s s, %s t, %s d 
						WHERE t.solicitud_id=s.solicitud_id and d.dependencia_id=t.dependencia_id 
	                    and date(s.creacion) between "%s" and "%s" and 
						t.transaccion_id = s.estado_actual
						order by d.dependencia_nombre',
	
			_TBL_PQR_SOLICITUD,
			_TBL_PQR_TRANSACCION,
			_TBL_PQR_DEPENDENCIA,
			$fecha_inicial_traida,
			$fecha_final_traida);																			/*Creo la sentencia que me trae todas las jefaturas ssegun las fechas seleccionadas*/
	$resultado_jefaturas=$db->Execute($jefaturas );															/*Ejecuto la consulta anterior*/	
	$pdf->SetY(60);
	while(!$resultado_jefaturas->EOF)																		/*creo el ciclo con los datos traidos*/
	{
			$pdf->SetX(25);																					/*distancia desde la izquierda a la derecha*/
			$pdf->SetFont('Arial','B',5);																	/*Le asigno el tipo de fuente*/
			$pdf->Cell(30,5,$resultado_jefaturas->fields['dependencia_nombre'],1,0,'L',0);					/*Creo las celdas que llevan las dependencias con respecto a la fecha seleccionada*/

			$tipos_2=sprintf("select tipo_id from pqr_tipo order by tipo_id");								/*Consulto nuevamente los tipos de solicitud para que se puedan pintar las celdas de la cantidad*/
			$resultado_tipos_2=$db->Execute($tipos_2);														/*ejecuto la consulta anterior*/	
			$X=55;																							/*Variable que lleva la posisión en X despues de las celdas donde van las jefaturas*/
			$max=0;																							/*Declaro la variable que llevara el ancho maximo de las celdas de la cantidad.*/
			$cantidad=0;																					/*inicializo la variable que me sumara las cantidades en forma horizontal*/
			while(!$resultado_tipos_2->EOF)																	/*creo el ciclo con los tipos para empezar a pintar las cantidades*/
			{
				$consulta=sprintf("
									select count(t.tipo_id) as cantidad from
									pqr_transaccion as t,pqr_solicitud as s 
									where t.transaccion_id=s.estado_actual and
									t.tipo_id=%s and t.dependencia_id=%s and 
									date(t.creacion) between '%s' and '%s' 
									order by t.tipo_id",
				$resultado_tipos_2->fields['tipo_id'],
				$resultado_jefaturas->fields['dependencia_id'],
				$fecha_inicial_traida,$fecha_final_traida);													/*Consulta que me traera las cantidades por dependencia y por el tipo*/
				$ejecuto=$db->Execute($consulta);															/*Ejecuto la consulta anterior*/
				
				$total_porcentaje=consultarSolicitudes($fecha_inicial_traida,$fecha_final_traida);			/*consulto todas las solicitudes para traer realizar los porcentajes*/	
				
				while(!$ejecuto->EOF)
				{
					$pdf->SetX($X + $max);																	/*Asigno la nueva posision para cada cajita de cantidades que sera de empezara de 55 y le sumara 15*/
					$pdf->SetFont('Arial','B',5);															/*Asigno el tipo de fuente*/
					$pdf->Cell(15,5,$ejecuto->fields['cantidad'],1,0,'C',0);								/*Creo las celdas que llevan las catidades de tipos por dependencias*/
					$X=$X+$max;																				/*la variable que se inicializo con 55 pasara a sumarse con el maximo en X*/
					$max=15;																				/*la variable aumenta en 15 mientras este en el ciclo, esto para poder sumar y cambiar la posision en X*/
					$cantidad	= $cantidad + $ejecuto->fields['cantidad'];									/*Sumo las cantidades de forma horizontal*/
					$arreglo[$resultado_tipos_2->fields['tipo_id']]= $ejecuto->fields['cantidad'];			/*Creo un arreglo que llevara las cantidades para sumarlas de forma vertical*/
					$ejecuto->MoveNext();																	/*Paso al siguiente registro del ciclo de las cantidades*/					
					//var_dump($consulta);																	/*Hago una impresion de la consulta para verificar que esta bien*/
				}
				
				$resultado_tipos_2->MoveNext();																/*Paso al siguiente registro de la consulta de los tipos de solicitud*/
				
				
			}
			
			$arreglos[]=$arreglo;																			/*Le asigno a un arreglo las cantidades que se sumaran verticalmente*/
			$gran_total = $gran_total + $cantidad;															/*Voy sumando las cantidades de forma horizontal*/	
			$pdf->Cell(10,5,$cantidad,1,0,'C',0);															/*creo las celdas que llevan la suma de las cantidades en forma horizontal*/
			$porcentaje=round(($cantidad * 100)/$total_porcentaje);											/*Calculo el porcentaje*/
			$pdf->Cell(10,5,$porcentaje."%",1,0,'C',0);														/*creo las celdas que lleva el porcentaje*/
			$pdf->ln(5);																					/*espacios de a 5 hacia abajo*/
			$resultado_jefaturas->MoveNext();																/*paso a la siguiente registro de la jefatura*/
	}
	
	$pdf->SetX(25);																							/*Posisiono la celda de los totales que esta al final de las dependencias*/		
	$pdf->Cell(30,5,"TOTALES",1,0,'L',0);																	/*Creo la celda totales del final de la tabla*/
	foreach($arreglos[0] as $key => $dato)																	/*Recorro el arreglo que me trae el arreglo con las sumas*/
	{
		$sum = 0;																							/*Declaro la variable que sumara las cantidades*/
		for($j=0; $j<sizeof($arreglos);$j++)																/*Recorro los datos que traia el primer arreglo en su interior*/
		{
			$sum = $sum + $arreglos[$j][$key];																/*sumo las cantidades de forma vertical*/
		}
		$suma2=$suma2 + $sum;
		
		$pdf->Cell(15,5,$sum ,1,0,'C',0);																	/*Pinto la celda con los totales en forma vertical*/	
	}
	$pdf->Cell(10,5,$total_porcentaje,1,0,'C',0);															/*Pinto la celda con el gran total en forma vertical*/
	$porcentaje_abajo=round(($suma2*100)/$suma2);
	$pdf->Cell(10,5,$porcentaje_abajo."%",1,0,'C',0);														/*Pinto la celda con el porcentaje*/
	$pdf->ln(15);		
	$pdf->SetFont('Arial','',12);
	
	$fecha_inicial_formateada=explode("-",$fecha_inicial_traida);											/*separo la fecha segun el guin para hacer las siguientes validaciones*/
	$arreglo_fecha_inicial[0]	=$fecha_inicial_formateada[0];												/*Trae el año de la fecha inicial*/
	$arreglo_fecha_inicial[1]	=$fecha_inicial_formateada[1];												/*Trae el mes de la fecha inicial*/
	$arreglo_fecha_inicial[2]	=$fecha_inicial_formateada[2];												/*Trae el dia de la fecha inicial*/
	
	$mes_inicial					=traducirMes($arreglo_fecha_inicial[1]);								/*Llamo la funcion para que me traduzca el mes inicial*/					

	$ano_inicial				=$arreglo_fecha_inicial[0];													/*Asigno el año de la fecah inicial*/
	$dia_inicial				=$arreglo_fecha_inicial[2];													/*Asigno el dia de la fecha inicial*/
	
	$fecha_final_formateada		=explode("-",$fecha_final_traida);											/*separo la fecha segun el guin para hacer las siguientes validaciones*/
	$arreglo_fecha_final[0]		=$fecha_final_formateada[0];												/*Trae el año de la fecha final*/
	$arreglo_fecha_final[1]		=$fecha_final_formateada[1];												/*Trae el mes de la fecha final*/
	$arreglo_fecha_final[2]		=$fecha_final_formateada[2];												/*Trae el dia de la fecha final*/
	
	$mes_final=traducirMes($arreglo_fecha_final[1]);														/*Llamo a la funcion para que me traduzca el mes final*/												

	$ano_final			=$arreglo_fecha_final[0];															/*Asigno el año de la fecha final*/
	$dia_final			=$arreglo_fecha_final[2];															/*Asigno el dia de la fecha final*/
	
	$total_cerradas		=traerEstado(3,$fecha_inicial_traida,$fecha_final_traida);							/*traigo las solicitudes que estan cerradas*/
	$total_en_tramite	=traerEstado(2,$fecha_inicial_traida,$fecha_final_traida);							/*traigo las solicitudes que estan en tramite*/
	$total_abiertas		=traerEstado(1,$fecha_inicial_traida,$fecha_final_traida);							/*traigo las solicitudes que estan abiertas*/
	
	$pdf->SetX(25);																							/*Posisiono en 25 de X*/
	$pdf->MultiCell(155,5,"Durante el periodo comprendido entre ".$dia_inicial." de ".$mes_inicial." de ".$ano_inicial." al ".$dia_final." de ".$mes_final." de ".$ano_final.", se recibieron ".$total_porcentaje." solicitudes de las cuales ".$total_cerradas." fueron respondidas de forma definitiva, ".$total_en_tramite." se encuentran en tramite y en las otras ".$total_abiertas." se espera que los solicitantes alleguen documentos  o adelanten acciones para poder continuar con el tramite.",0,'J',0);															
	$pdf->ln(5);
	$pdf->SetX(25);
	$pdf->MultiCell(155,5,$reporte_tipoyjef,0,'J',0);														/*Pinto lo que viene en el campo tipo y jefatura*/
	$pdf->image('_templates/Default/recursos/images/piedepagina.jpg',40,260,142,21);

						/*FIN DE LA TABLA DE SOLICITUDES POR TIPO Y DEPENDENCIA*/
	
										/*INICIO TABLA MEDIO DE RECEPCIÓN*/
	/* TERCERA PAGINA*/	
	$pdf->ln(3);
	$pdf->AddPage('P');
	$pdf->SetMargins(2,2);
	$pdf->SetFont('Arial','I',9);
	$pdf->Cell(190,40,"                           ".$oficio_numero,0,0,'L',0);
	
	$pdf->SetFont('Arial','BI',8);	
	$pdf->ln(3);
	$pdf->SetY(40);
	$pdf->SetX(60);
	$pdf->Cell(60,8,"MEDIO DE RECEPCIÓN",1,0,'C',0);	
	
	$pdf->SetFont('Arial','B',8);
	$pdf->SetY(40);
	$pdf->SetX(120);
	$pdf->Cell(20,8,"CANTIDAD",1,0,'C',0);	
	
	$pdf->SetFont('Arial','B',8);
	$pdf->SetY(40);
	$pdf->SetX(140);
	$pdf->Cell(14,8,"%",1,0,'C',0);
		
	/*CREAR LA TABLA CON LAS SOLICITUDES POR CADA MEDIO EXISTENTE*/
	
	$sql_solicitudes_medio =sprintf('
						SELECT count(s.medio_id) as cantidad, m.medio_id, medio_nombre
						FROM %s s, %s m, %s t
						WHERE 	s.medio_id=m.medio_id and s.solicitud_id=t.solicitud_id
								and date(s.creacion) between "%s" and "%s" and
								t.transaccion_id=s.estado_actual
						GROUP BY m.medio_id
						ORDER BY cantidad desc',

	_TBL_PQR_SOLICITUD,
	_TBL_PQR_MEDIO,
	_TBL_PQR_TRANSACCION,
	$fecha_inicial_traida,
	$fecha_final_traida);
	$resultado_solicitudes_medio = $db->Execute($sql_solicitudes_medio) or errorQuery(__LINE__, __FILE__);
		
	$pdf->SetFont('Arial','',7);
	$posY = 48;
	$masY = 0;	
	$maximo = 0;
	$contador = 0;
	$medio = "";
	$porcentaje = 0;
	
	
	if($resultado_solicitudes_medio){
		while(!$resultado_solicitudes_medio->EOF)
		{
			
			$cantidad      		= $resultado_solicitudes_medio->fields['cantidad'];
			$medio_id     		= $resultado_solicitudes_medio->fields['medio_id'];
			$medio_nombre 		= $resultado_solicitudes_medio->fields['medio_nombre'];
			$todas_solicitudes 	= consultarSolicitudes($fecha_inicial_traida,$fecha_final_traida);
			
			$pdf->SetY($posY+$masY);
			$pdf->SetX(60);
			$pdf->MultiCell(60,6,$medio_nombre,1,'J',0);	
			$pdf->SetY($posY+$masY);
			$pdf->SetX(120);
			$pdf->MultiCell(20,6,$cantidad,1,'C',0);
			
			$porcentaje_cantidad = round((($cantidad * 100)/$todas_solicitudes));
			
			$pdf->SetY($posY+$masY);
			$pdf->SetX(140);
			$pdf->MultiCell(14,6,round($porcentaje_cantidad)."%",1,'C',0);		
			
			if($contador==0){
				$maximo		= $cantidad;	
				$medio		= $medio_nombre;
				$porcentaje = $porcentaje_cantidad;
			}
			
			$contador++;
			$posY  = $posY+$masY;
			$masY  = 6;
			$resultado_solicitudes_medio->MoveNext();
		}
	}		
			
	$pdf->SetFont('Arial','B',8);	
	$pdf->SetY($posY+$masY);
	$pdf->SetX(60);
	$pdf->MultiCell(60,6,"TOTAL",1,'C',0);
			
	$pdf->SetY($posY+$masY);
	$pdf->SetX(120);
	$pdf->MultiCell(20,6,$todas_solicitudes,1,'C',0);
	
	$pdf->SetY($posY+$masY);
	$pdf->SetX(140);
	$pdf->MultiCell(14,6,"100%",1,'C',0);			
	
	$pdf->SetFont('Arial','',12);
    $posY  = $posY+$masY;
	$masY  = 18;
	
	$pdf->SetY($posY+$masY);
	$pdf->SetX(38);     
	$pdf->MultiCell(195,6,"El  medio  más  utilizado  durante  este  periodo fue el/la  ".$medio." ( ".$porcentaje."%  de",0,'J',0);	
	
	$posY  = $posY+$masY;
	$masY  = 6;
	
	$pdf->SetY($posY+$masY);
	$pdf->SetX(38);     
	$pdf->MultiCell(195,6,"las  veces).",0,'J',0);	
	
	$pdf->Ln(12);
	
	$posY  = $posY+$masY;
	$masY  = 13;
	
	$pdf->SetY($posY+$masY);
	$pdf->SetX(38);
	$pdf->MultiCell(195,6,"Se ha incrementado el uso que la ciudadanía hace de la línea gratuita nacional",0,'J',0);	

	$posY  = $posY+$masY;
	$masY  = 6;
	
	$pdf->SetY($posY+$masY);
	$pdf->SetX(38);
	$pdf->MultiCell(195,6,"en forma frecuente para el seguimiento de sus casos. ",0,'J',0);	
	
	
	
				/* ACA DEBO PONER EL TEXTO DE MEDIO DE RECEPCION----------------------------------------------FP*/
	
	$pdf->ln(3);
	$pdf->SetFont('Arial','',12);
	$pdf->SetX(38);
	/*$pdf->MultiCell(180,10,$reporte_mrecepcion,0,'J',0);*/
	$pdf->SetWidths(array(150));
	$pdf->SetAligns(array('J'));
	//$pdf->Row(array($reporte_mrecepcion));
	$pdf->MultiCell(150,5,$reporte_mrecepcion,0,'J',0);
	/* ACA TERMINA TEXTO DE MEDIO DE RECEPCION----------------------------------------------FP*/	
	$pdf->image('_templates/Default/recursos/images/piedepagina.jpg',40,260,142,21);
	
					/*CREAR LA TABLA CON LAS SOLICITUDES POR TIPO Y ASUNTO*/
	
	
												/*INICIO DE LA TABLA POR TIPO Y ASUNTO****FP*/
	$pdf->ln(3);
	$pdf->AddPage('P');
	$pdf->SetMargins(2,2);
	$pdf->SetFont('Arial','I',9);
	$pdf->Cell(190,40,"                           ".$oficio_numero,0,0,'L',0);
	$pdf->SetFont('Arial','',12);
	$pdf->ln(15);
	$pdf->Cell(190,45,"                           2. DATOS ESTADÍSTICOS DE LOS REQUERIMIENTOS RECIBIDOS EN EL",0,0,'L',0);	
	$pdf->ln(6);
	$pdf->Cell(190,45,"                               TRIMESTRE",0,0,'L',0);		
	$pdf->SetFont('Arial','B',8);
	
	/*Pinto laprimer celda con el titulo del informe*/
	$pdf->SetFont('Arial','',5);
	$pdf->ln(12);
	$pdf->SetY(55);
	$pdf->SetX(25);
	$pdf->Cell(30,5,"TIPO Y ASUNTO",1,0,'C',0);	
	
	/*Selecciono los tipos de solicitud*/
	$tipos=sprintf("select tipo_nombre from %s order by tipo_id",_TBL_PQR_TIPO);			/*Consulto todos los tipos de solicitud*/
	$resultado_tipos=$db->Execute($tipos);																	/*ejecuto la consulta anterior*/
	while(!$resultado_tipos->EOF)																			/*Creo el ciclo con los tipos de solicitud*/
	{
			$pdf->SetFont('Arial','',5);																	/*asigno el tipo de fuente para la celda que voy a pintar*/
			$pdf->Cell(15,5,$resultado_tipos->fields['tipo_nombre'],1,0,'C',0);								/*Creo las celdas que llevan el tipo de solicitud*/
			$resultado_tipos->MoveNext();																	/*paso al siguiente registro hasta terninar el ciclo*/													 
	}
	$pdf->Cell(10,5,"CANT",1,0,'C',0);																		/*Pinta la celda de la cantidad de forma Vertical*/
	$pdf->Cell(10,5,"%",1,0,'C',0);																			/*Pinta la celda delporcentaje de forma vertical*/
	$asuntos = sprintf('																			
						SELECT DISTINCT a.asunto_id, a.asunto_nombre 
						FROM %s s, %s t, %s a 
						WHERE t.solicitud_id=s.solicitud_id and a.asunto_id=t.asunto_id 
	                    and date(s.creacion) between "%s" and "%s" and 
						t.transaccion_id = s.estado_actual
						order by a.asunto_nombre',
	
			_TBL_PQR_SOLICITUD,
			_TBL_PQR_TRANSACCION,
			_TBL_PQR_ASUNTO,
			$fecha_inicial_traida,
			$fecha_final_traida);																			/*Creo la sentencia que me trae todas las jefaturas ssegun las fechas seleccionadas*/
			
	$resultado_asuntos=$db->Execute($asuntos);															/*Ejecuto la consulta anterior*/
		
	$pdf->SetY(60);
	while(!$resultado_asuntos->EOF)																		/*creo el ciclo con los datos traidos*/
	{
			$pdf->SetX(25);																					/*distancia desde la izquierda a la derecha*/
			$pdf->SetFont('Arial','B',5);																	/*Le asigno el tipo de fuente*/
			$pdf->Cell(30,5,$resultado_asuntos->fields['asunto_nombre'],1,0,'L',0);					/*Creo las celdas que llevan las dependencias con respecto a la fecha seleccionada*/

			$asuntos_2=sprintf("select tipo_id from %s order by tipo_id",_TBL_PQR_TIPO);								/*Consulto nuevamente los tipos de solicitud para que se puedan pintar las celdas de la cantidad*/
			$resultado_asuntos_2=$db->Execute($asuntos_2);														/*ejecuto la consulta anterior*/	
			$X=55;																							/*Variable que lleva la posisión en X despues de las celdas donde van las jefaturas*/
			$max=0;																							/*Declaro la variable que llevara el ancho maximo de las celdas de la cantidad.*/
			$cantidad_asuntos=0;																					/*inicializo la variable que me sumara las cantidades en forma horizontal*/
			while(!$resultado_asuntos_2->EOF)																	/*creo el ciclo con los tipos para empezar a pintar las cantidades*/
			{
				$consulta_asuntos_nueva=sprintf("
									select count(t.tipo_id) as cantidad from
									pqr_transaccion as t,pqr_solicitud as s 
									where t.transaccion_id=s.estado_actual and
									t.tipo_id=%s and t.asunto_id=%s and 
									date(t.creacion) between '%s' and '%s' 
									order by t.tipo_id",
				$resultado_asuntos_2->fields['tipo_id'],
				$resultado_asuntos->fields['asunto_id'],
				$fecha_inicial_traida,$fecha_final_traida);													/*Consulta que me traera las cantidades por dependencia y por el tipo*/
				$ejecuto_asuntos=$db->Execute($consulta_asuntos_nueva);															/*Ejecuto la consulta anterior*/
				
				$total_porcentaje_asuntos=consultarSolicitudes($fecha_inicial_traida,$fecha_final_traida);			/*consulto todas las solicitudes para traer realizar los porcentajes*/	
				
				while(!$ejecuto_asuntos->EOF)
				{
					
					$pdf->SetX($X + $max);																	/*Asigno la nueva posision para cada cajita de cantidades que sera de empezara de 55 y le sumara 15*/
					$pdf->SetFont('Arial','B',5);															/*Asigno el tipo de fuente*/
					$pdf->Cell(15,5,$ejecuto_asuntos->fields['cantidad'],1,0,'C',0);								/*Creo las celdas que llevan las catidades de tipos por dependencias*/
					$X=$X+$max;																				/*la variable que se inicializo con 55 pasara a sumarse con el maximo en X*/
					$max=15;																				/*la variable aumenta en 15 mientras este en el ciclo, esto para poder sumar y cambiar la posision en X*/
					$cantidad_asuntos	= $cantidad_asuntos + $ejecuto_asuntos->fields['cantidad'];									/*Sumo las cantidades de forma horizontal*/
					$arreglo_asuntos[$resultado_asuntos_2->fields['tipo_id']]= $ejecuto_asuntos->fields['cantidad'];			/*Creo un arreglo que llevara las cantidades para sumarlas de forma vertical*/
					$ejecuto_asuntos->MoveNext();																	/*Paso al siguiente registro del ciclo de las cantidades*/					
					//var_dump($consulta);																	/*Hago una impresion de la consulta para verificar que esta bien*/
				}
				
				$resultado_asuntos_2->MoveNext();																/*Paso al siguiente registro de la consulta de los tipos de solicitud*/
				
				
			}
			
			$arreglos_asuntos[]=$arreglo_asuntos;																			/*Le asigno a un arreglo las cantidades que se sumaran verticalmente*/
			$gran_total_asuntos = $gran_total_asuntos + $cantidad_asuntos;															/*Voy sumando las cantidades de forma horizontal*/	
			$pdf->Cell(10,5,$cantidad_asuntos,1,0,'C',0);															/*creo las celdas que llevan la suma de las cantidades en forma horizontal*/
			$porcentaje_asuntos=round(($cantidad_asuntos * 100)/$total_porcentaje_asuntos);											/*Calculo el porcentaje*/
			$pdf->Cell(10,5,$porcentaje_asuntos."%",1,0,'C',0);														/*creo las celdas que lleva el porcentaje*/
			$pdf->ln(5);																					/*espacios de a 5 hacia abajo*/
			$resultado_asuntos->MoveNext();																/*paso a la siguiente registro de la jefatura*/
	}
	
	$pdf->SetX(25);																							/*Posisiono la celda de los totales que esta al final de las dependencias*/		
	$pdf->Cell(30,5,"TOTALES",1,0,'L',0);																	/*Creo la celda totales del final de la tabla*/
	foreach($arreglos_asuntos[0] as $key_asuntos => $dato_asuntos)																	/*Recorro el arreglo que me trae el arreglo con las sumas*/
	{
		$sum_asuntos = 0;																							/*Declaro la variable que sumara las cantidades*/
		for($h=0; $h<sizeof($arreglos_asuntos);$h++)																/*Recorro los datos que traia el primer arreglo en su interior*/
		{
			$sum_asuntos = $sum_asuntos + $arreglos_asuntos[$h][$key_asuntos];																/*sumo las cantidades de forma vertical*/
		}
		$suma2_asuntos=$suma2_asuntos + $sum_asuntos;
		
		$pdf->Cell(15,5,$sum_asuntos ,1,0,'C',0);																	/*Pinto la celda con los totales en forma vertical*/	
	}
	$pdf->Cell(10,5,$suma2_asuntos,1,0,'C',0);															/*Pinto la celda con el gran total en forma vertical*/
	$porcentaje_abajo_asuntos=round(($suma2_asuntos * 100)/$suma2_asuntos);
	$pdf->Cell(10,5,$porcentaje_abajo_asuntos."%",1,0,'C',0);														/*Pinto la celda con el porcentaje*/
	$pdf->ln(15);		
	$pdf->SetFont('Arial','',12);
	
	$pdf->ln(5);
	$pdf->SetFont('Arial','',12);
	$pdf->SetX(25);
	$pdf->MultiCell(150,5,$reporte,0,'J',0);
	$pdf->image('_templates/Default/recursos/images/piedepagina.jpg',40,260,142,21);
						/*FIN DE LA TABLA DE SOLICITUDES POR TIPO Y ASUNTO*/
	
		
	/* QUINTA PAGINA	
	$pdf->ln(3);
	$longitud_cadena = strlen($textoasunto);
//	echo $longitud_cadena;

	$pdf->PrintChapter($textoasunto, $oficio_numero);
		
	$pdf->image('_templates/Default/recursos/images/piedepagina.jpg',40,260,142,21);
	*/
	
	/* SEXTA PAGINA*/	
	$pdf->ln(3);
	$pdf->AddPage('P');
	$pdf->SetMargins(2,2);
	$pdf->SetFont('Arial','I',9);
	$pdf->Cell(190,40,"                           ".$oficio_numero,0,0,'L',0);
	$pdf->SetFont('Arial','',12);
	$pdf->ln(15);
	$pdf->Cell(190,45,"                           3. SEGUIMIENTO RESPUESTA POR PARTE DE LAS INSTANCIAS COMPETENTES",0,0,'L',0);

	
	/*------------------------ ACA SE INTRODUCIRA EL TEXTO DEL SEGUIMIENTO----------------------------------FP----------*/
	$pdf->ln(28);
	$pdf->SetFont('Arial','',12);
	$pdf->SetX(38);
	/*$pdf->MultiCell(180,10,$reporte,0,'J',0);*/
	$pdf->SetWidths(array('145'));
	$pdf->SetAligns(array('J'));
	//$pdf->row(array($seguimiento));
	$pdf->MultiCell(150,5,$seguimiento,0,'J',0);
	
	
	/*--------------------------- ACA TERMINA EL TEXTO DEL SEGUIMIENTO--------------------------------------------FP----*/
	$porcent1=0;
	$porcent2=0;
	$suma_datos=0;
	
	/*$pdf->ln(6);
	$pdf->Cell(190,45,"                               TRIMESTRE",0,0,'L',0);	*/
		
	$pdf->image('_templates/Default/recursos/images/piedepagina.jpg',40,260,142,21);
	
/*
	
	// OCTAVA PAGINA	
	$pdf->ln(3);
	$pdf->AddPage('P');
	$pdf->SetMargins(2,2);
	$pdf->SetFont('Arial','I',9);
	$pdf->Cell(190,40,"                           ".$oficio_numero,0,0,'L',0);
	$pdf->SetFont('Arial','',12);
	$pdf->ln(15);
	$pdf->Cell(190,45,"                           5. INDICADORES DE EFECTIVIDAD",0,0,'L',0);	
	
*/
	
	
		
	$pdf->image('_templates/Default/recursos/images/piedepagina.jpg',40,260,142,21);
	
	/* NOVENA PAGINA*/	
	 $pdf->ln(3);
	$pdf->AddPage('P');
	$pdf->SetMargins(2,2);
	$pdf->SetFont('Arial','I',9);
	$pdf->Cell(190,40,"                           ".$oficio_numero,0,0,'L',0);
	$pdf->SetFont('Arial','',12);
	$pdf->ln(15);
	$pdf->Cell(190,45,"                           4. CONCLUSIONES",0,0,'L',0);	
	/*-------------------------- ACA SE AGREGA EL TEXTO DE LA CAJA DE LAS CONCLUCIONES----------------------------------FP---*/
	$pdf->ln(28);
	$pdf->SetFont('Arial','',12);
	$pdf->SetX(38);
	/*$pdf->MultiCell(180,10,$reporte,0,'J',0);*/
	$pdf->SetWidths(array('145'));
	$pdf->SetAligns(array('J'));
	//$pdf->row(array($conclusiones));
	$pdf->MultiCell(150,5,$conclusiones,0,'J',0);
	$pdf->ln(3);
	$pdf->SetFont('Arial','',12);
	$pdf->ln(15);
	$pdf->Cell(190,45,"                           5. RECOMENDACIONES",0,0,'L',0);	
	/*-------------------------- ACA SE AGREGA EL TEXTO DE LA CAJA DE LAS CONCLUCIONES----------------------------------FP---*/
	$pdf->ln(28);
	$pdf->SetFont('Arial','',12);
	$pdf->SetX(38);
	/*$pdf->MultiCell(180,10,$reporte,0,'J',0);*/
	$pdf->SetWidths(array('145'));
	$pdf->SetAligns(array('J'));
	//$pdf->row(array($recomendaciones));
	$pdf->MultiCell(150,5,$recomendaciones,0,'J',0);
	
	$pdf->image('_templates/Default/recursos/images/piedepagina.jpg',40,260,142,21);
	
	/*----------------------------ACA TERMINA EL TEXTO DE LA CAJA RECOMENDACIONES------------------------------FP----------*/
	
	/*DEMOCRATIZACIÓN DE LA GESTIÓN PUBLICA*************************************FP*/
	$pdf->ln(3);
	$pdf->AddPage('P');
	$pdf->SetMargins(2,2);
	$pdf->SetFont('Arial','I',9);
	$pdf->Cell(190,40,"                           ".$oficio_numero,0,0,'L',0);
	$pdf->SetFont('Arial','B',12);
	$pdf->ln(15);
	$pdf->Cell(190,45,"                           II. DEMOCRATIZACIÓN DE LA GESTIÓN PUBLICA",0,0,'L',0);	
	/*-------------------------- ACA SE AGREGA EL TEXTO DE LA CAJA DE LA CAJA DEMOCRATIZACIÓN DE LA GESTIÓN PUBLICA----------------------------------FP---*/
	$pdf->ln(28);
	$pdf->SetFont('Arial','',12);
	$pdf->SetX(38);
	/*$pdf->MultiCell(180,10,$reporte,0,'J',0);*/
	$pdf->SetWidths(array('145'));
	$pdf->SetAligns(array('J'));
	//$pdf->row(array($demo));
	$pdf->MultiCell(150,5,$demo,0,'J',0);
	$pdf->ln(3);
	$pdf->SetFont('Arial','',12);
	
	$pdf->image('_templates/Default/recursos/images/piedepagina.jpg',40,260,142,21);
	/*FIN DEMOCRATIZACIÓN DE LA GESTION PUBLICA.*/
	
	/******************PAOYO LUCHA CONTRA LA CORRUPCIÓN*************************************FP*/
	$pdf->ln(3);
	$pdf->AddPage('P');
	$pdf->SetMargins(2,2);
	$pdf->SetFont('Arial','I',9);
	$pdf->Cell(190,40,"                           ".$oficio_numero,0,0,'L',0);
	$pdf->SetFont('Arial','B',12);
	$pdf->ln(15);
	$pdf->Cell(190,45,"                           III. APOYO A LA LUCHA CONTRA LA CORRUPCIÓN",0,0,'L',0);	
	/*-------------------------- ACA SE AGREGA EL TEXTO DE LA CAJA APOYO A LA LUCHA CONTRA LA CORRUPCIÓN----------------------------------FP---*/
	$pdf->ln(28);
	$pdf->SetFont('Arial','',12);
	$pdf->SetX(38);
	/*$pdf->MultiCell(180,10,$reporte,0,'J',0);*/
	$pdf->SetWidths(array('145'));
	$pdf->SetAligns(array('J'));
	//$pdf->row(array($apoyo));
	$pdf->MultiCell(150,5,$apoyo,0,'J',0);
	$pdf->ln(3);
	$pdf->SetFont('Arial','',12);
	if($select == 1)
		{
					/*FIRMA DEL INFORME CUANDO ES GENERADO COMO ESPECIFICO***FP*/
			$pdf->ln(10);
			$pdf->SetX(50);
			$pdf->Cell(30,5,'Atentamente,',0,0,'L',0,0);
			$pdf->ln(25);
			$pdf->SetX(55);
			$pdf->Cell(20,5,$rango,0,0,'R',0);
			$pdf->SetFont('Arial','B',12);	
			$pdf->Cell(92,5,$nombre,0,0,'L',0);
			$pdf->ln();
			$pdf->SetFont('Arial','',12);
			$pdf->SetX(50);
			$pdf->Cell(100,5,'Oficial Atención y Orientación al Ciudadano Ejercito',0,0,'C',0);
			$pdf->ln(10);
			$pdf->SetFont('Arial','',12);
			$pdf->SetX(50);
			$pdf->ln(10);
			$pdf->SetX(80);
			$pdf->Cell(20,5,$ayudante_cargo,0,0,'R',0);
			$pdf->SetFont('Arial','B',12);	
			$pdf->Cell(112,5,$ayudante,0,0,'L',0);
			$pdf->ln();
			$pdf->SetFont('Arial','',12);
			$pdf->SetX(50);
			$pdf->Cell(100,5,'Ayudante General Comando Ejercito',0,0,'C',0);
			$pdf->ln(20);
			$pdf->SetFont('Arial','',6);
			$pdf->SetX(25);
			$pdf->Cell(10,5,'Elaboro: ',0,0,'C',0);
			$pdf->SetX(40);
			$pdf->Cell(10,5,$elaboro,0,0,'C',0);
			$pdf->SetFont('Arial','',8);
			$pdf->SetX(120);
			$pdf->Cell(10,5,'Vo Bo MV. ',0,0,'C',0);
			$pdf->SetX(145);
			$pdf->Cell(10,5,$visto,0,0,'C',0);
			$pdf->ln();
			$pdf->SetFont('Arial','',6);
			$pdf->SetX(42);
			$pdf->Cell(10,5,'Administrador Modulo AOC ',0,0,'C',0);
			$pdf->SetFont('Arial','',8);
			$pdf->SetX(145);
			$pdf->Cell(10,5,'Oficial. Atencion y Orientación al Ciudadano ',0,0,'C',0);
		//	$pdf->Cell(100,5,'ciudadano@armada.mil.co',0,0,'C',0);
	
		}
	
	
	$pdf->image('_templates/Default/recursos/images/piedepagina_2.jpg',30,260,142,21);
	/****************************************FIN APOYO LUCHA CONTRA LA CORRUPCIÓN***********************************************************FP*/
		/* GRAFICAS*/	
	$pdf->ln(3);
	$pdf->AddPage('P');
	$pdf->SetMargins(2,2);
	$pdf->SetFont('Arial','I',9);
	$pdf->Cell(190,40,"                           ".$oficio_numero,0,0,'L',0);
	$pdf->SetFont('Arial','',12);
	$pdf->ln(15);
	$pdf->SetX(95);
	$pdf->Cell(190,45,'ANEXO "A"',0,0,'L',0);
	$pdf->Ln(5);
	$pdf->SetX(40);
	$pdf->Cell(190,45,"INFORMACION GRÁFICA DEL CIUDADANO EJERCITO NACIONAL",0,0,'L',0);
	$pdf->ln(15);
	$pdf->image(_RUTABASE.'recursos_user/reporte/imagefile11.png',60,60,100,180,'PNG');
	$pdf->ln(3);
	$pdf->AddPage('P');
	$pdf->SetMargins(2,2);
	$pdf->SetFont('Arial','I',9);
	$pdf->Cell(190,40,"                           ".$oficio_numero,0,0,'L',0);
	$pdf->SetFont('Arial','',12);
	$pdf->ln(15);
	$pdf->image(_RUTABASE.'recursos_user/reporte/imagefile7.png',60,60,100,90,'PNG');
	$pdf->AddPage('P');
	$pdf->SetMargins(2,2);
	$pdf->SetFont('Arial','I',9);
	$pdf->Cell(190,40,"                           ".$oficio_numero,0,0,'L',0);
	$pdf->SetFont('Arial','',12);
	$pdf->ln(15);
	$pdf->image(_RUTABASE.'recursos_user/reporte/imagefile9.png',60,60,100,180,'PNG');
		
	
	
	$pdf->Output("Reporte_Gerencial.pdf",'D');
}

class PDF extends FPDF{
	//Pie de página
	function Footer(){
	    //Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    $this->SetX(150);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //Número de página
	    $this->Cell(0,10,'Página  '.$this->PageNo().'  de  {nb}',0,0,'C');
	}
	
	function RotatedText($x,$y,$txt,$angle){
	    //Text rotated around its origin
	    $this->Rotate($angle,$x,$y);
	    $this->Text($x,$y,$txt);
	    $this->Rotate(0);
	}
		
	
	function Rotate($angle,$x=-1,$y=-1)
	{
		if($x==-1)
			$x=$this->x;
		if($y==-1)
			$y=$this->y;
		if($this->angle!=0)
			$this->_out('Q');
		$this->angle=$angle;
		if($angle!=0)
		{
			$angle*=M_PI/180;
			$c=cos($angle);
			$s=sin($angle);
			$cx=$x*$this->k;
			$cy=($this->h-$y)*$this->k;
			$this->_out(sprintf('q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
		}
	}

	
	function ChapterBody($file, $oficio)
	{
		$txt = $file;	    
		$this->SetFont('Arial','I',9);
		$this->Cell(190,40,"                           ".$oficio,0,0,'L',0);
		$this->SetFont('Arial','',12);
	    //Imprimimos el texto justificado
    	$this->SetY(33);
    	$this->SetX(38);
	    $this->MultiCell(150,6,$txt,0,'J');
	    //Salto de línea
	    $this->Ln();
	}
	
	function PrintChapter($file, $oficio)
	{      
		$this->AddPage('P');
		$this->SetMargins(2,2);
	    $this->ChapterBody($file,$oficio);
	}
	var $widths;
var $aligns;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
?>