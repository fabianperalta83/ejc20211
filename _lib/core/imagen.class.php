<?php

/**
 * Clase de manejo de Imágenes
 * @author Juan Manuel Hernández
 * @version $Id: imagen.class.php,v 1.1 2008/12/15 16:33:16 aforero Exp $
 * @copyright 2005
 */
require_once('../_config/constantes.php');

define ('GIF', 1);
define ('JPEG', 2);
define ('PNG', 3);
 
 
Class ManejoImagen {
    /* Variables publicas */

    /* VARIABLES DE IMAGEN */
	var $nombreCompleto;
    var $ancho = 0; // width
    var $alto = 0; // height
    var $tipoArchivoImagen = 0; // tipo 1=gif,2=jpg,3=png,4=swf
    var $caracteristicasImagen = array();
	var $dirCache = _DIRCACHEIMG;

	/* VARIABLES DE THUMBNAIL PERSONALIZADO */
	var $anchoThumb = 0;
	var $altoThumb = 0;
	
    /* VARIABLES DE CARACTERISTICAS PARA REALIZAR EL THUMBNAIL GENERICO */
    var $distMax = _DISTMAX;
    var $distMed = _DISTMED;
	var $calidad = _CALIDADIMG;

    /* Variable de Error */
    var $thumbNail = ''; // archivo donde queda el thumbnail incluye path
    var $_mensaje = '';
	
    var $extensionAllowed = array("gif", "jpg", "png", "jpeg");

    /**
     * ManejoImagen::Imagen()
     * 
     * @param  $nombreArchivo 
     * @return 
     */
    function ManejoImagen($nombreArchivo) { 
		$this->nombreCompleto = $nombreArchivo;
		
		/**
		 * Verificamos que sea una imagen
		 */
		$partsFile = pathinfo($this->nombreCompleto);
		
		if (isset($partsFile['extension']) and !in_array(strtolower($partsFile['extension']), $this->extensionAllowed)) {
			$this->sacarWarning();
		}
    }
    /**
     * ManejoImagen :: sacarWarning
     * @param
     */
    function sacarWarning() {
    	
    	header("Content-Type: image/jpeg");
    	
    	if(function_exists("imagecreatetruecolor"))	{
    		$func1 = 'imagecreatetruecolor';
    		$func2 = 'imagecolorallocate';
    	} else {
    		$func1 = 'imageCreate';
    		$func2 = 'imagecolorclosest';
    	}

    	// *** Create the image resource ***
    	$image = $func1(125, 40);

    	/**
		 * Hacemos el background
		 */
    	$clr_back = ImageColorAllocate($image, 200, 200, 200);
    	// *** Make the background black ***
    	imagefill($image, 0, 0, $clr_back);

    	/**
		 * Generacion del Texto
		 */
    	$clr_font = ImageColorAllocate($image, 0, 0, 0);
    	imagestring($image, 1, 10,10, "La imagen no se", $clr_font);
    	imagestring($image, 1, 10,20, "encuentra disponible.", $clr_font);
    	
    	// *** Sale la imagen creada en formato jpeg ***
    	imagejpeg($image, null, 100);

    	// *** limpiamos algo de memoria... ***
    	imagedestroy($image);
    	exit(0);
    	
    }
	/**
	 * ManejoImagen::inicializar()
	 * 
	 * @return 
	 **/
	function inicializar() {
		$gdLoaded = TRUE;
	 	// Carga de los datos referentes a la imagen
        if (!$this->cargarInformacion()) {
            $this->_mensaje = "Imposible obtener informacion de la imagen $this->nombreCompleto.\n";
			return false;
        }
		
		// Verifica que la extensión "GD" este cargada
        if (!extension_loaded('gd')) {
            if (!dl('gd.so')) {
                $this->_mensaje = "No existe la extensión de gd de php, hay que instalarla.";
	        	$gdLoaded = FALSE;				
            } 
        }

		if ($gdLoaded === FALSE) {
			$this->mostrarImagen($this->nombreCompleto);
			return false;
		}
		
        return true;
	 }
    /**
     * ManejoImagen::cargarInformacion()
     * 
	 * Carga las propiedades de la imagen en la variable $caracteristicasImagen
	 * 
     * @return 
     **/
    function cargarInformacion() {
		//$this->caracteristicasImagen [];
        $this->nombreCompleto = realpath('../'.$this->nombreCompleto); 
		
        // El archivo si existe carge la informacion
        if (is_file($this->nombreCompleto)) {
		
			// Obtenga los componentes basado en el nombre del archivo
        	$pathParts = pathinfo($this->nombreCompleto);
			// Informacion de la Imagen
			$infoImagen = getimagesize($this->nombreCompleto);
			
			if ($infoImagen === FALSE) {
				$this->sacarWarning();
				return false;
			}
			
			$this->caracteristicasImagen["ancho"] = $infoImagen["0"]; //ancho de la imagen
			$this->caracteristicasImagen["alto"] = $infoImagen["1"]; //alto de la imagen
			$this->caracteristicasImagen["tipo"] = $infoImagen["2"]; //tipo de la imagen
			
			$this->caracteristicasImagen["nombre"] = $pathParts["basename"];
			$this->caracteristicasImagen["directorio"] = $pathParts["dirname"];
			$this->caracteristicasImagen["extension"] = $pathParts["extension"];
			
			$this->caracteristicasImagen["tamano"] = filesize($this->nombreCompleto);
			$this->caracteristicasImagen["fechaModificacion"] = filemtime($this->nombreCompleto);
			$this->caracteristicasImagen["permiso"] = fileperms($this->nombreCompleto);
			
            $this->_mensaje = "Se cargo exitosamente la informacion de  $this->nombreCompleto.\n";
            return true;
        } else {
        	$this->sacarWarning();
            $this->_mensaje = "El $this->nombreCompleto no existe o no es un archivo.\n";
            return false;
        } 
    } 

    /**
     * ManejoImagen::calcularTamanoThumbnail()
     * 
     * @param  $ancho 
     * @param  $alto 
     * @return 
     */
    function calcularTamanoThumbnail($ancho=0, $alto=0) {
		if (!empty($ancho)) {
		    $ancho = round($ancho);
		}
		if (!empty($alto)) {
		    $alto = round($alto);
		}
		switch(true) {
			case !empty($ancho) and empty($alto): // solamente viene el ancho
				$AspectRatio = $this->caracteristicasImagen["ancho"] / $this->caracteristicasImagen["alto"];
				$this->altoThumb = round($ancho / $AspectRatio);
				$this->anchoThumb = round($ancho);
				break;
				
			case empty($ancho) and !empty($alto): //solamente viene el alto
				$AspectRatio = $this->caracteristicasImagen["ancho"] / $this->caracteristicasImagen["alto"];
				$this->altoThumb = round($alto);
				$this->anchoThumb = round($alto * $AspectRatio);
				break;
				
			case !empty($ancho) and !empty($alto): 
				$AspectRatio = $this->caracteristicasImagen["alto"] / $this->caracteristicasImagen["ancho"];
				if($AspectRatio > 1)
				{if(isset($_GET['me'])){echo 'pri';exit();}
					$proporcion = $alto / $this->caracteristicasImagen["alto"];
					$this->altoThumb = $proporcion * $this->caracteristicasImagen["alto"];
					$this->anchoThumb = $proporcion * $this->caracteristicasImagen["ancho"];
				}
				else if($AspectRatio < 1)
				{if(isset($_GET['me'])){echo 'sec';exit();}
					$proporcion = $ancho / $this->caracteristicasImagen["ancho"];
					$this->altoThumb = $proporcion * $this->caracteristicasImagen["alto"];
					$this->anchoThumb = $proporcion * $this->caracteristicasImagen["ancho"];
				}
				else
				{if(isset($_GET['me'])){echo 'ter';exit();}
				$this->altoThumb = $alto;
					$this->anchoThumb = $alto;
				}
				break;
				
			default:
		        $direccion = "";
			    $ancho = $this->caracteristicasImagen["ancho"];
		        $alto = $this->caracteristicasImagen["alto"];

		        if ($ancho > $alto) {
		            $direccion = "h";
		            $relacion = $ancho / $alto;
		        } else {
		            $direccion = "v";
		            $relacion = $alto / $ancho;
		        } 
		        if ($relacion >= 1.38) {
		            if ($direccion == "v") {
		                $porcentaje = $this->distMax / $alto;
		            } else {
		                $porcentaje = $this->distMax / $ancho;
		            } 
		        } else {
		            if ($direccion == "h") {
		                $porcentaje = $this->distMed / $alto;
		            } else {
		                $porcentaje = $this->distMed / $ancho;
		            } 
		        } 
				$this->altoThumb = round($alto * $porcentaje);
				$this->anchoThumb = round($ancho * $porcentaje);
		} // switch
    } 
    /**
     * ManejoImagen::crearThumbnail()
     * 
     * @param  $nuevoAncho 
     * @param  $nuevoAlto 
     * @return 
     */
    function crearThumbnail($archivoDestino, $ancho=0, $alto=0) {
        $this->calcularTamano($ancho, $alto);
        // Calcular el nombre del thumbnail
        if ($this->resizeImagen($archivoDestino)) {
            $this->_mensaje = "No pudo ser creado el thumbnail de la imagen";
            return false;
        } else {
            $this->thumbNail = $archivoDestino;
            return true;
        } 
    } 
	/**
	 * ManejoImagen::gd_version()
	 * 
	 * @return 
	 **/
	function gd_version() {
		if (version_compare(phpversion(), '4.3.0', '>=')) return '2.0';
			ob_start();
			phpinfo();
			$buffer = ob_get_contents();
			ob_end_clean();
			preg_match('|<B>GD Version</B></td><TD ALIGN="left">([^<]*)</td>|i', $buffer, $matches);
		return (float) substr($matches[1], 0, 3);
	}
	/**
     * ManejoImagen::resizeImagen()
     * 
     * @param  $archivoDestino 
     * @param  $nuevoAncho 
     * @param  $nuevoAlto 
     * @param  $mantengaRatio 
     * @return 
     */
    function resizeImagen($archivoDestino)
    { 
		$nuevoAlto = $this->altoThumb;
		$nuevoAncho = $this->anchoThumb;
		
		if ($nuevoAlto == 0) {
            $nuevoAlto = $this->caracteristicasImagen["alto"];
        } 
        if ($nuevoAncho == 0) {
            $nuevoAncho = $this->caracteristicasImagen["ancho"];
        } 
		
        // Si conserva el mismo Ancho y Alto no hay que hacerle nada a la imagen
        if (($nuevoAncho >= $this->caracteristicasImagen["ancho"]) && ($nuevoAlto >= $this->caracteristicasImagen["alto"])) {
            $this->_mensaje = "La imagen fue manipulada de forma correcta\n";
            return false;
        } 

        // Crea el identificador de imagen para la imagen dada segun el tipo de imagen
		if (function_exists('ImageCreate')) {
			ini_set("memory_limit", "83886080"); // 80 MB
			$imagenFuente = @ImageCreateFromString(file_get_contents($this->nombreCompleto));
		}

        if ($imagenFuente) {
		
			if ($this->gd_version() >= 2.0) {
				$imagenDestino  = ImageCreateTrueColor($nuevoAncho , $nuevoAlto);
				ImageCopyResampled($imagenDestino, $imagenFuente, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $this->caracteristicasImagen["ancho"], $this->caracteristicasImagen["alto"]);
			} else {
				$imagenDestino  = ImageCreate($nuevoAncho , $nuevoAlto);
				ImageCopyResized($imagenDestino, $imagenFuente, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $this->caracteristicasImagen["ancho"], $this->caracteristicasImagen["alto"]);
			}
			
            switch ($this->caracteristicasImagen["tipo"]) {
                case GIF: $resultado = imagegif($imagenDestino, $archivoDestino);
                    break;
                case JPEG: $resultado = imagejpeg($imagenDestino, $archivoDestino, $this->calidad);
                    break;
                case PNG: $resultado = imagepng($imagenDestino, $archivoDestino);
                    break;
            }
			
            imagedestroy($imagenFuente);
            imagedestroy($imagenDestino);
            return true;
        } else {
            $this->_mensaje = "No se pudo crear la imagen fuente para el procesamiento\n";
            return false;
        } 
    }
    /**
     * ManejoImagen::imagenOnFly()
     * 
     * @param $width
     * @param $height
     * @return 
     **/
    function imagenOnFly($ancho = 0, $alto = 0) {
		$hacerThumbnail = FALSE;
		
		//cuadrar el tamaño de la imagen
		$this->calcularTamanoThumbnail($ancho, $alto);
		
		// realizar el thumbnail
		if ($this->caracteristicasImagen["ancho"] == $this->anchoThumb and $this->caracteristicasImagen["alto"] == $this->altoThumb) {
		    $this->mostrarImagen($this->nombreCompleto);
		} else {
			
			$nombreFichero = explode(".", $this->caracteristicasImagen["nombre"]);
			
			$nombreArchivo = $this->dirCache
							.$nombreFichero[0]
							.$this->anchoThumb
							.$this->altoThumb
							.".".$this->caracteristicasImagen["extension"];
			
			if (is_file(realpath($nombreArchivo))) {
				$fechaModificacion = filemtime(realpath($nombreArchivo));
				if ($fechaModificacion <= $this->caracteristicasImagen["fechaModificacion"]) {
					$hacerThumbnail = TRUE;
				} else {
					$this->mostrarImagen($nombreArchivo);
					$hacerThumbnail = FALSE;
				}
			} else {
				$hacerThumbnail = TRUE;
			}

			//Hacer el thumbnail
			if ($hacerThumbnail === TRUE) {
				if ($this->resizeImagen($nombreArchivo)) {
					if (is_file(realpath($nombreArchivo))) {
						$this->mostrarImagen(realpath($nombreArchivo));
					} else {
						$this->mostrarImagen($this->nombreCompleto);
					}
				} else {
					$this->mostrarImagen($this->nombreCompleto);
				}
			}
		}
    }
	/**
	 * ManejoImagen::mostrarImagen()
	 * 
	 * @param $contenido
	 * @return 
	 **/
	function mostrarImagen($nombreArchivo) {
	
		if ($fp = @fopen($nombreArchivo, 'rb')) {
			$OriginalImageData = fread($fp, filesize($nombreArchivo));
			fclose($fp);
			switch ($this->caracteristicasImagen["tipo"]) {
				case GIF:
					header('Content-type: image/gif');
					break;
				case JPEG:
					header('Content-type: image/jpeg');
					break;
				case PNG:
					header('Content-type: image/png');
					break;
			}
			$year = date("Y") + 1;
			header("Expires: ".date("D, d M ")." $year 05:00:00 GMT");
			echo $OriginalImageData;
		}
	}
} 

?>