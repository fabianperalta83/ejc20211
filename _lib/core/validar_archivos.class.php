<?php


class validar_archivos{

public function validar($name,$type){
	if($type == 'application/pdf'){
		require_once(_DIRLIB.'tcpdf/tcpdf_import.php');					
		$pdf = new TCPDF_IMPORT();
		try {
			@$pdf->importPDF($name);
			return true;
			}
		catch (Exception $e) {
			@unlink($name);
			//echo "No es un archivo PDF";
			return false;
		}
							
	}elseif($type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
		require_once(_DIRLIB . 'Excel/PHPExcel.php');
		require_once(_DIRLIB . 'Excel/PHPExcel/IOFactory.php');
		try {
			$inputFileName = $name;                      
			$objectReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objectReader->setReadDataOnly(true);
			$objPHPExcel = $objectReader->load($inputFileName);
			try {
				$sheet = $objPHPExcel->getSheet(0); 
				$highestRow = $sheet->getHighestRow(); 
				$highestColumn = $sheet->getHighestColumn();
				return true;
			}
			catch (Exception $e) {
				@unlink($name);
				//echo "No es un archivo XLSX";
				return false;
			}
		}
		catch (Exception $e) {
			@unlink($name);
			//echo "No es un archivo XLSX";
			return false;
		}
	}elseif ($type == 'application/vnd.ms-excel'){
		require_once(_DIRLIB . 'Excel/PHPExcel.php');
		require_once(_DIRLIB . 'Excel/PHPExcel/IOFactory.php');
		try {
			$inputFileName = $name;
			$objectReader = PHPExcel_IOFactory::createReader('Excel5');
			$objectReader->setReadDataOnly(true);
			$objPHPExcel = $objectReader->load($inputFileName);
			try {
				$sheet = $objPHPExcel->getSheet(0); 
				$highestRow = $sheet->getHighestRow(); 
				$highestColumn = $sheet->getHighestColumn();
				return true;
			}
			catch (Exception $e) {
				@unlink($name);
				//echo "No es un archivo XLS";
				return false;
			}
		}
		catch (Exception $e) {
			@unlink($name);
			//echo "No es un archivo XLS";
			return false;
		}
	}else{	
		$file = fopen($name,'r');
		$contenido = fread($file,filesize($name));
		if (strstr($contenido,'<?php')){
			$_FILES["localfile"]["error"] = 1;
			//echo "el archivo posee codigo malicioso";
			@unlink($name);
			return false;
		}else{
			return true;
		}
	}
}

}

?>