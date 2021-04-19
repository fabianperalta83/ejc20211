<?php
/**
 * Class Captcha
 * Genera la imagen captcha
 * @package Núcleo
 * @author Juan Manuel Hernandez <jhernandez@micrositios.net>
 * @version 3.0
 * @copyright Copyright © 2006 Micrositios Ltda.
 */
class Captcha {
	
	var $lx;
	var $ly;
	
	var $minsize = 15;
	var $maxsize = 22;
	
	var $r;
	var $b;
	var $g;
	
	var $text;
	var $chars;
	
	var $maxrotation = 30;
	
	var $font = array('arial.ttf', 'verdana.ttf', 'tahoma.ttf');
	var $font_actual;
	
	var $jpeg_quality = 80;
	
	/**
	 * captcha :: captcha
	 * Funcion Constructora
	 * @param
	 */
	function captcha($pass) {
		$this->text = $pass;
		$this->chars = strlen($this->text);
	}
	/**
	 * captcha :: random_font
	 * Pone un random de fuentes
	 * @param
	 */
	function random_font() {
		$this->font_actual = $this->font[intval(rand(0,count($this->font)-1))];
		return $this->font_actual;
	}
	/**
	 * captcha :: random_color
	 * Creacion de ramdom de color
	 * @param
	 */
	function random_color($min,$max)
	{
		srand((double)microtime() * 1000000);
		$this->r = intval(rand($min,$max));
		srand((double)microtime() * 1000000);
		$this->g = intval(rand($min,$max));
		srand((double)microtime() * 1000000);
		$this->b = intval(rand($min,$max));
	}

	// *** Function List ***
	function create_image()
	{
		
		if(function_exists("imagecreatetruecolor"))
		{
			$func1 = 'imagecreatetruecolor';
			$func2 = 'imagecolorallocate';
		}
		else
		{
			$func1 = 'imageCreate';
			$func2 = 'imagecolorclosest';
		}

		// set dimension of image
		$this->lx = ($this->chars + 1) * (int)(($this->maxsize + $this->minsize) / 1.5);
		$this->ly = (int)(2.4 * $this->maxsize);
		
		// *** Create the image resource ***
		$image = $func1($this->lx,$this->ly);
		
		/**
		 * Hacemos el background
		 */
		//$this->random_color(224, 255);
		//$this->random_color(0, 0);
		//$clr_back = ImageColorAllocate($image, $this->r, $this->g, $this->b);
		$clr_back = ImageColorAllocate($image, 218, 226, 229);
		// *** Make the background black ***
		imagefill($image, 0, 0, $clr_back);
		
		
		/**
		 * Generacion del grid para generar algo de ruido 
		 */
		for($i=0; $i < $this->lx; $i += (int)($this->minsize / 1.5))
		{
			//$this->random_color(160, 224);
			//$this->random_color(255, 255);
			//$color	= $func2($image, $this->r, $this->g, $this->b);
			$color	= $func2($image, 136, 163, 172);
			@imageline($image, $i, 0, $i, $this->ly, $color);
		}

		for($i=0 ; $i < $this->ly; $i += (int)($this->minsize / 1.8))
		{
			//$this->random_color(160, 224);
			//$this->random_color(255, 255);
			//$color	= $func2($image, $this->r, $this->g, $this->b);
			$color	= $func2($image, 136, 163, 172);
			@imageline($image, 0, $i, $this->lx, $i, $color);
		}	
			
		/**
		 * Recuadro de la imagen
		 */
		$color	= $func2($image, 0,0,0);
		@imageline($image, 0, 0, 0, $this->ly, $color);
		@imageline($image, 0, $this->ly - 1, $this->lx, $this->ly - 1, $color);
		@imageline($image, $this->lx - 1, 0, $this->lx - 1, $this->ly, $color);
		@imageline($image, 0, 0, $this->lx, 0, $color);
		
		/**
		 * Generacion del Texto
		 */
		for($i=0, $x = intval(rand($this->minsize,$this->maxsize)); $i < $this->chars; $i++)
		{
			$text	= strtoupper(substr($this->text, $i, 1));
			
			srand((double)microtime()*1000000);
			$angle	= intval(rand(($this->maxrotation * -1), $this->maxrotation));
			
			srand((double)microtime()*1000000);
			$size	= intval(rand($this->minsize, $this->maxsize));
			
			srand((double)microtime()*1000000);
			$y		= intval(rand((int)($size * 1.5), (int)($this->ly - ($size / 7))));
			
			//$this->random_color(0, 127);
			//$this->random_color(255, 255);
			//$color	=  $func2($image, $this->r, $this->g, $this->b);
			$color	= $func2($image, 83, 109, 119);
			
			//$this->random_color(0, 127);
			//$this->random_color(255, 255);
			//$shadow = $func2($image, $this->r + 127, $this->g + 127, $this->b + 127);
			$shadow = $func2($image, $this->r + 127, $this->g + 127, $this->b + 127);
			
			@ImageTTFText($image, $size, $angle, $x + (int)($size / 15), $y, $shadow, $this->random_font(),  $text);
			@ImageTTFText($image, $size, $angle, $x, $y - (int)($size / 15), $color, $this->font_actual, $text);
			
			$x += (int)($size + ($this->minsize / 5));
		}
		
		// *** Sale la imagen creada en formato jpeg ***
		imagejpeg($image, null, $this->jpeg_quality);

		// *** limpiamos algo de memoria... ***
		imagedestroy($image);
	}
}
?>