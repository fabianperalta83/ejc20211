<?php
/**
 * FriendlyURL es una clase con las herramientas basicas para generar y administrar urls amigables
 * alter table categoria add column friendly_name varchar(200) unique;
 *
 * @author ajacosta
 */
class FriendlyURL {

	const NODO_RAIZ = 1;
	const LONGITUD_MAX_NOMBRE_UNICO = 300; 
	const LONGITUD_MAX_URL = 500; 
	const LONGITUD_MAX_NIVEL_URL = 35; 
	const LONGITUD_MIN_URL = 5; 
	const LONGITUD_MAX_SECCION_URL = 20; 
	const LONGITUD_MIN_SECCION_URL = 5; 
	const LONGITUD_DIFERENCIADOR = 5; 

	public static $debug = true;
	public static $enable = true;
	public static $debugLevel = 1;
	public static $max_nombre_nivel = 4; // El siguiente nivel se poblara con el idcategoria
	
	
	public static $urlRegex = "/(https?:\/\/)?([\da-z\.-\/]+)?(\.\/)*(index\.php)\?idcategoria=(\d+)((&[^\"'>])*)/";
	public static $urlRegexWindowOpen = "/(window.open\()([\"'])(_include|tools|_interfaz)/";

	/**
	* Converts all accent characters to ASCII characters.
	*
	* If there are no accent characters, then the string given is just returned.
	*
	* @param string $string Text that might have accent characters
	* @return string Filtered string with replaced "nice" characters.
	*/
	public static function remove_accents($string) {
		if ( !preg_match('/[\x80-\xff]/', $string) )
			return $string;

		if (FriendlyURL::seems_utf8($string)) {
			$chars = array(
			// Decompositions for Latin-1 Supplement
			chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
			chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
			chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
			chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
			chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
			chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
			chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
			chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
			chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
			chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
			chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
			chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
			chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
			chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
			chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
			chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
			chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
			chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
			chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
			chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
			chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
			chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
			chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
			chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
			chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
			chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
			chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
			chr(195).chr(191) => 'y',
			// Decompositions for Latin Extended-A
			chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
			chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
			chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
			chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
			chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
			chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
			chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
			chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
			chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
			chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
			chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
			chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
			chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
			chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
			chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
			chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
			chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
			chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
			chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
			chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
			chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
			chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
			chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
			chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
			chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
			chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
			chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
			chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
			chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
			chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
			chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
			chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
			chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
			chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
			chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
			chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
			chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
			chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
			chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
			chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
			chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
			chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
			chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
			chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
			chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
			chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
			chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
			chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
			chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
			chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
			chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
			chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
			chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
			chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
			chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
			chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
			chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
			chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
			chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
			chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
			chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
			chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
			chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
			chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
			// Euro Sign
			chr(226).chr(130).chr(172) => 'E',
			// GBP (Pound) Sign
			chr(194).chr(163) => '');

			$string = strtr($string, $chars);
		} else {
			// Assume ISO-8859-1 if not UTF-8
			$chars['in'] = chr(128).chr(131).chr(138).chr(142).chr(154).chr(158)
				.chr(159).chr(162).chr(165).chr(181).chr(192).chr(193).chr(194)
				.chr(195).chr(196).chr(197).chr(199).chr(200).chr(201).chr(202)
				.chr(203).chr(204).chr(205).chr(206).chr(207).chr(209).chr(210)
				.chr(211).chr(212).chr(213).chr(214).chr(216).chr(217).chr(218)
				.chr(219).chr(220).chr(221).chr(224).chr(225).chr(226).chr(227)
				.chr(228).chr(229).chr(231).chr(232).chr(233).chr(234).chr(235)
				.chr(236).chr(237).chr(238).chr(239).chr(241).chr(242).chr(243)
				.chr(244).chr(245).chr(246).chr(248).chr(249).chr(250).chr(251)
				.chr(252).chr(253).chr(255);

			$chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

			$string = strtr($string, $chars['in'], $chars['out']);
			$double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
			$double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
			$string = str_replace($double_chars['in'], $double_chars['out'], $string);
		}

		return $string;
	}

	public static function seems_utf8($str)
	{
		$length = strlen($str);
		for ($i=0; $i < $length; $i++) {
			$c = ord($str[$i]);
			if ($c < 0x80) $n = 0; # 0bbbbbbb
			elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
			elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
			elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
			elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
			elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
			else return false; # Does not match any model
			for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
				if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
					return false;
			}
		}
		return true;
	}
	
	public static function reemplazarPalabrasConocidas( $nombre )
	{
		// Quitar No., Nro, Nros, etc.
		$nombre  = str_replace(" no 1"   , " 1", $nombre);
		$nombre  = str_replace(" no 2"   , " 2", $nombre);
		$nombre  = str_replace(" no 3"   , " 3", $nombre);
		$nombre  = str_replace(" no 4"   , " 4", $nombre);
		$nombre  = str_replace(" no 5"   , " 5", $nombre);
		$nombre  = str_replace(" no 6"   , " 6", $nombre);
		$nombre  = str_replace(" no 7"   , " 7", $nombre);
		$nombre  = str_replace(" no 8"   , " 8", $nombre);
		$nombre  = str_replace(" no 9"   , " 9", $nombre);
		$nombre  = str_replace(" no 0"   , " 0", $nombre);
		$nombre  = str_replace(" numero 1"   , " 1", $nombre);	 	 	 
		$nombre  = str_replace(" numero 2"   , " 2", $nombre);
		$nombre  = str_replace(" numero 3"   , " 3", $nombre);
		$nombre  = str_replace(" numero 4"   , " 4", $nombre);
		$nombre  = str_replace(" numero 5"   , " 5", $nombre);
		$nombre  = str_replace(" numero 6"   , " 6", $nombre);
		$nombre  = str_replace(" numero 7"   , " 7", $nombre);
		$nombre  = str_replace(" numero 8"   , " 8", $nombre);
		$nombre  = str_replace(" numero 9"   , " 9", $nombre);
		$nombre  = str_replace(" numero 0"   , " 0", $nombre);
		$nombre  = str_replace("1o."         , " 1 ", $nombre);	 
		$nombre  = str_replace("2o."         , " 2 ", $nombre);	 	 
		$nombre  = str_replace("2do."        , " 2 ", $nombre);
		$nombre  = str_replace(" 01"         , " 1", $nombre);	 
		$nombre  = str_replace(" 02"         , " 2", $nombre);
		$nombre  = str_replace(" 03"         , " 3", $nombre);
		$nombre  = str_replace(" 04"         , " 4", $nombre);
		$nombre  = str_replace(" 05"         , " 5", $nombre);
		$nombre  = str_replace(" 06"         , " 6", $nombre);
		$nombre  = str_replace(" 07"         , " 7", $nombre);
		$nombre  = str_replace(" 08"         , " 8", $nombre);
		$nombre  = str_replace(" 09"         , " 9", $nombre);
		$nombre  = str_replace(" 001"         , " 1", $nombre);	 
		$nombre  = str_replace(" 002"         , " 2", $nombre);
		$nombre  = str_replace(" 003"         , " 3", $nombre);
		$nombre  = str_replace(" 004"         , " 4", $nombre);
		$nombre  = str_replace(" 005"         , " 5", $nombre);
		$nombre  = str_replace(" 006"         , " 6", $nombre);
		$nombre  = str_replace(" 007"         , " 7", $nombre);
		$nombre  = str_replace(" 008"         , " 8", $nombre);
		$nombre  = str_replace(" 009"         , " 9", $nombre);

		// Quitar la palabra a?o antes de un a?o
		$nombre  = str_replace(" ano 1"   , " 1", $nombre);
		$nombre  = str_replace(" ano 2"   , " 2", $nombre);
		
		return $nombre;
	}
	
	public static function remove_stopWords( $nombre )
	{
		$remover1 = array(
			" a ",
			" ante ",	 
			" bajo ",
			" con ",	 
			" contra ",	 
			" de ",
			" desde ",	 
			" en ",
			" entre ",
			" hacia ",
			" hasta ",	 
			" para ",	 
			" por ",
			" segun ",	 
			" sin ",	 
			" sobre ",	 
			" tras ",

			" y ",
			" e ",
			" ni ",
			" que ",
			" o ",
			" y/o ",	 
			" u ",
			" mas ",
			" pero ",
			" sino ",
			" o sea ",	 
			" es decir ",
			" esto es ",

			" el ",
			" la ",
			" los ",
			" las ",	 
			" al ",
			" del ",

			" no.",
			" nro ",
			" nro."
		);
		
		$nombre  = str_replace($remover1, " ", $nombre);
		return $nombre;
	}

	public static function nombreCategoria_a_urlAmigable( $nombre )
	{
		require_once(_DIRCORE."Funciones.class.php");
		
		$debug = true; 
		// Siempre se trabaja en minusculas
		//$nombre = utf8_decode($nombre);
		$nombre;
		$nombre_nuevo = strtolower($nombre);
		if($debug) echo "[".__LINE__."] => $nombre_nuevo\n";

		// Separar numeros de letras
		$nombre_nuevo = preg_replace('/[a-z](?=\d)|\d(?=[a-z])/i', '$0 ', $nombre_nuevo);
		if($debug) echo "[".__LINE__."] => $nombre_nuevo\n";

		// Se trabaja sin espacios al principio y al final
		$nombre_nuevo = trim($nombre_nuevo);
		if($debug) echo "[".__LINE__."] => $nombre_nuevo\n";
		
		// remover espacios dobles
		$nombre_nuevo = preg_replace('/\s{2,}/s', ' ', $nombre_nuevo);
		if($debug) echo "[".__LINE__."] => $nombre_nuevo\n";
		
		
		// traducir entidades HTML
		$nombre_nuevo = html_entity_decode($nombre_nuevo, ENT_QUOTES, 'ISO-8859-1');
		if($debug) echo "[".__LINE__."] => $nombre_nuevo\n";

		
		
		// reemplazar palabras conocidas por otrs mas cortas y similares
		$nombre_nuevo = FriendlyURL::reemplazarPalabrasConocidas($nombre_nuevo);
		if($debug) echo "[".__LINE__."] => $nombre_nuevo\n";
		
		// remover stopwords
		$nombre_nuevo = FriendlyURL::remove_stopWords($nombre_nuevo);
		if($debug) echo "[".__LINE__."] => $nombre_nuevo\n";
		
		// remover acentos y UTF8
		// $nombre_nuevo = FriendlyURL::remove_accents($nombre_nuevo);
		$nombre_nuevo = Funciones::Removeaccents($nombre_nuevo);
		if($debug) echo "[".__LINE__."] => $nombre_nuevo\n";
		
		// Remover finalmente todo lo extrano por un espacio para poder hacer un trim y limpiar
		$nombre_nuevo = preg_replace('/[^a-zA-Z0-9]/s', ' ', $nombre_nuevo);
		if($debug) echo "[".__LINE__."] => $nombre_nuevo\n";

		// trim final para remover posibles caracteres de espacio traducidos de comillas
		$nombre_nuevo = trim($nombre_nuevo);
		if($debug) echo "[".__LINE__."] => $nombre_nuevo\n";
		
		// todo espacio a guion y dejar solo un guion
		$nombre_nuevo = preg_replace('/\s+/s', '_', $nombre_nuevo);
		if($debug) echo "[".__LINE__."] => $nombre_nuevo\n";
		// $nombre_nuevo = str_replace(" ", "_", $nombre_nuevo);
		
		// remover dobles guinoes bajos
		
		return $nombre_nuevo;
	}
	
	public static function idCat2FId( &$db, $idcategoria, $base_path = "" )
	{
		$url = $base_path.FriendlyURL::IdCategoria2FriendlyId($db, $idcategoria);
		return $url;
	}

	/**
	 * Retorna el friendly name segun el id categoria dado
	 * @param type $db
	 * @param type $idcategoria
	 * @param type $field
	 * @return boolean 
	 */
	public static function IdCategoria2FriendlyId( &$db, $idcategoria, $field = COLUMNA_NOMBRE_URL, $alt_ext = "" )
	{
		if( FriendlyURL::$enable )
		{
			if(!is_object($db))
			{
				throw new Exception("Error determinando la conexi&oacute;n a la base de datos");
			}
			$sql = "SELECT * FROM "._TBLCATEGORIA." WHERE idcategoria = '$idcategoria'";
	//		echo "$sql\n";
			$r = $db->Execute($sql);
			if(!$r)
			{
				die("Error buscando el url amigable para la categoria $idcategoria: ".$db->ErrorMsg()."\n");
			}
	//		echo "[$idcategoria]: ".$r->fields[$field]."<br>";
			if( $r->fields['es_root'] == "1" && isset($r->fields[$field]) && "{$r->fields[$field]}" == "" )
			{
				return $r->fields[$field].$alt_ext; // Solo se toman nombre_url vacio para caterogiras root
			}elseif( isset($r->fields[$field]) && "{$r->fields[$field]}" != "" )
			{
	//			echo "Categoria $idcategoria ->".$r->fields[$field].$alt_ext."\n<br>";
				return $r->fields[$field].$alt_ext;
			}
		}
		// En cualquier otro caso se retorna la categoria sola
		return "index.php?idcategoria=$idcategoria";
	}
	
	/**
	 * Retorna el idcategoria correspondiente al friendly name dado
	 * @param type $db
	 * @param type $value
	 * @param type $field
	 * @return boolean 
	 */
	public static function friendlyId2IdCategoria( &$db, $value, $field = COLUMNA_NOMBRE_URL )
	{
		$sql = "SELECT * FROM "._TBLCATEGORIA." WHERE $field = '$value'";
		$r = $db->Execute($sql);
		if(!$r)
		{
			return 1;

			//die("Error buscando la categoria desde el url amigable para el url $value: ".$db->ErrorMsg()."\n");
		}
		if( $r !== false && isset($r->fields['idcategoria']) && $r->fields['idcategoria'] != "" )
		{
			return $r->fields['idcategoria'];
		}
		return false;
	}
	
	public static function genConFriendlyName( &$db, $value, $inicial = 0, $field = 'friendly_name', $max_length = LONGITUD_MAX_NOMBRE_UNICO )
	{
		$value = substr( trim($value), 0, $max_length );
		$n_value = substr( trim("{$inicial}_{$value}"), 0, $max_length );
		if( $inicial == 0 )
			$sql = "SELECT * FROM "._TBLCATEGORIA." WHERE $field = '$value'";
		else
			$sql = "SELECT * FROM "._TBLCATEGORIA." WHERE $field = '$n_value'";
		$r = $db->Execute($sql);
		if( $r === false )
		{
			die("Error buscando el consecutivo de la categoria para su friendly name: ".$db->ErrorMsg()."\n");
		}
		if( !$r->EOF )
		{
			// Si ya existe busca otro disponible
			return FriendlyURL::genConFriendlyName($db, $value, $inicial+1, $field);
		}
		if( $inicial == 0 )
			return $value;
		else
			return $n_value;
	}
	
	public static function genConFriendlyName_uniqueIdCategoria( &$db, $value, $idcategoria, $field = COLUMNA_NOMBRE_UNICO, $max_length = LONGITUD_MAX_NOMBRE_UNICO )
	{
		$value = substr( trim($value), 0, $max_length );
		$n_value = substr( trim($value), 0, $max_length-strlen("_$idcategoria") );
		$n_value .= "_{$idcategoria}";
		
		$sql = "SELECT * FROM "._TBLCATEGORIA." WHERE $field = '$value' AND idcategoria <> '$idcategoria'";
		$sqlCategoria = "SELECT * FROM "._TBLCATEGORIA." WHERE $field = '$n_value' AND idcategoria <> '$idcategoria'";
		$rCat = $db->Execute($sqlCategoria);
		if( $rCat === false )
		{
			die("Error buscando el consecutivo de la categoria para su friendly name: ".$db->ErrorMsg()."\n");
		}
		if( !$rCat->EOF )
		{
			// Si ya existe busca otro disponible
			die("Error inesperado, otra categoria tiene el mismo nombre buscado: $n_value");
			return false;
		}
		$r = $db->Execute($sql);
		if( $r === false )
		{
			die("Error buscando el consecutivo de la categoria para su friendly name: ".$db->ErrorMsg()."\n");
		}
		if( !$r->EOF )
		{
			// Si ya existe busca otro disponible
			return $n_value;
		}
		return $value;
	}
	
	/**
	 * @todo: Remover entidad html, remover stopwords, nro categoria al final para unicidad
	 * @param type $db 
	 */
	public static function generateFriendlyName( &$db )
	{
		$sql = "SELECT * FROM "._TBLCATEGORIA." WHERE friendly_name IS NULL OR friendly_name = ''";
		$result = $db->Execute($sql);
		if(!$result)
		{
			die("Error buscando la columna para el nombre de urls amigables: ".$db->ErrorMsg()."\n");
		}
		if ($result !== FALSE && $result->NumRows() > 0){
			while (!$result->EOF){
				$idcategoria = $result->fields['idcategoria'];
				$nombre = trim($result->fields['nombre']);
				if($nombre=="")
				{
					$nombre = "SIN NOMBRE";
				}
				$nombre_friendly = FriendlyURL::nombreCategoria_a_urlAmigable($nombre);
				$nombre_friendly_con_consecutivo = FriendlyURL::genConFriendlyName($db, $nombre_friendly);
				$sqlUpdate = "UPDATE "._TBLCATEGORIA." SET friendly_name = '$nombre_friendly_con_consecutivo' WHERE idcategoria = '$idcategoria'";
				if( FriendlyURL::$debug )
					echo "[$nombre] => ".htmlentities($sqlUpdate)."<br>\n";
				if(!$db->Execute($sqlUpdate))
				{
					die("[idcatgoria: $idcategoria] => Error generando los nombres amigables: ".$db->ErrorMsg()."\n");
				}
				$result->MoveNext();
			}
		}

	}
	
	/**
	 * Si el nombre ya existe retorna false
	 * @param AdoDBConnexion $db
	 * @param String $nombre
	 * @return boolean 
	 */
	public static function validarNombreUnico( &$db, $nombre )
	{
		$sql = "SELECT * FROM "._TBLCATEGORIA." WHERE ".COLUMNA_NOMBRE_UNICO." = '$nombre'";
		$result = $db->Execute($sql);
		if(!$result)
		{
			die("Error verificando el nombre unico: ".$db->ErrorMsg()."\n");
		}
		if( $result->NumRows() > 0 )
		{
			return false; // ya existe
		}
		return true;
	}

	public static function generarNombresBaseYUnicos( &$db, $cantidad_registros)
	{
		$t0 = time();
		$sql = "SELECT * FROM "._TBLCATEGORIA." WHERE (nombre_base IS NULL) ORDER BY idcategoria ASC LIMIT $cantidad_registros";
		$result = $db->Execute($sql);
		if(!$result)
		{
			die("Error buscando la columna para el nombre base de amigables: ".$db->ErrorMsg()."\n");
		}
		if ($result !== FALSE && $result->NumRows() > 0){
			while (!$result->EOF){
				$idcategoria = $result->fields['idcategoria'];
				$nombre = trim($result->fields['nombre']);
				if($nombre=="")
				{
					$nombre = "$idcategoria";
				}
				$nombre_friendly = FriendlyURL::nombreCategoria_a_urlAmigable($nombre);
				$nombre_friendly_con_consecutivo = "{$nombre_friendly}_{$idcategoria}";
				while(!FriendlyURL::validarNombreUnico($db, $nombre_friendly_con_consecutivo))
				{
					$nombre_friendly_con_consecutivo .= "_{$idcategoria}"; // Si esta duplicado volvemos a pegar la categoria
				}
				if($nombre_friendly == ''){
					//die("NO HAY NOMBRE EN $idcategoria");
				}
				else{

					echo $nombre_friendly;
				}
				$sqlUpdate = "UPDATE "._TBLCATEGORIA." SET"
					."  ".COLUMNA_NOMBRE_BASE." = '$nombre_friendly'"
					.", ".COLUMNA_NOMBRE_UNICO." = '$nombre_friendly_con_consecutivo'"
					." WHERE idcategoria = '$idcategoria'";
				if( FriendlyURL::$debug )
					echo "[$nombre] => ".($sqlUpdate)."\n";
				if(!$db->Execute($sqlUpdate))
				{
					die("[idcatgoria: $idcategoria] => Error generando los nombres amigables: ".$db->ErrorMsg()."\n");
				}
				$result->MoveNext();
			}
		}
		$tf = time();
		$dt = $tf - $t0;
		echo __CLASS__."->".__METHOD__." tomo {$dt} segundos en terminar\n";
	}
	
	public static function generarProfundidades( &$db, $cantidad_registros)
	{
		$t0 = time();
		$sql = "SELECT * FROM "._TBLCATEGORIA." where (nombre_nivel IS NULL or nombre_nivel ='') ORDER BY idcategoria LIMIT $cantidad_registros";
		$result = $db->Execute($sql);
		if(!$result)
		{
			die("Error buscando la columna para el nombre base de amigables: ".$db->ErrorMsg()."\n");
		}
		if ($result !== FALSE && $result->NumRows() > 0){
			while (!$result->EOF){
				$idcategoria = $result->fields['idcategoria'];
				$nombre = trim($result->fields['nombre']);
				$profundidad = FriendlyURL::obtenerProfundidad($db, $idcategoria);
				$sqlUpdate = "UPDATE "._TBLCATEGORIA." SET"
					."  ".COLUMNA_NOMBRE_NIVEL." = '$profundidad'"
					." WHERE idcategoria = '$idcategoria'";
				if( FriendlyURL::$debug )
					echo "[$idcategoria] => ".($sqlUpdate)."\n";
				if(!$db->Execute($sqlUpdate))
				{
					die("Error actualizando el nivel para la categoria $idcategoria: ".$db->ErrorMsg()."\n");
				}
				$result->MoveNext();
			}
		}		
		$tf = time();
		$dt = $tf - $t0;
		echo __CLASS__."->".__METHOD__." tomo {$dt} segundos en terminar\n";
	}
	
	public static function obtenerProfundidad( &$db, $idcategoria )
	{
        $excluir = array("2","3","12");
		if($idcategoria == FriendlyURL::NODO_RAIZ) {
			return 0;
		}

		/*if($idcategoria == FriendlyURL::NODO_RAIZ || in_array($idcategoria, $excluir)) {
			return 0;
		}*/

        $s = "SELECT * FROM "._TBLCATEGORIA." WHERE idcategoria = '$idcategoria'";
        $r = $db->Execute($s);
		if( !$r )
		{
			die("Error buscando la informacion de la categoria $idcategoria: ".$db->ErrorMsg()."\n");
		}
		if( ($r->EOF) )
		{
			die("Error la categoria $idcategoria no existe");
		}
        $row = $r->fields;
		if( $row['es_root'] == "1" )
		{
			return 0;
		}
		return 1+FriendlyURL::obtenerProfundidad($db, $row['idpadre']);
	}
	
	public static function createPath(&$db, $idcategoria, $usar_unico = false) {
		if($idcategoria == FriendlyURL::NODO_RAIZ) {
			return "";
		}
        
        $s = "SELECT * FROM "._TBLCATEGORIA." WHERE idcategoria = '$idcategoria'";
        $r = $db->Execute($s);

		if( !$r )
		{
			die("Error buscando la informacion de la categoria $idcategoria: ".$db->ErrorMsg()."\n");
		}
		if( ($r->EOF) )
		{
			die("Error la categoria $idcategoria no existe");
		}
        $row = $r->fields;
        $excluir = array("2","3","12");
        if($row['idpadre'] == FriendlyURL::NODO_RAIZ || in_array($row['idpadre'],$excluir) || $row['es_root'] == "1") {
            return (($usar_unico)?$row[COLUMNA_NOMBRE_UNICO]:$row[COLUMNA_NOMBRE_BASE]);
        } else {
			$name = (($usar_unico)?$row[COLUMNA_NOMBRE_UNICO]:$row[COLUMNA_NOMBRE_BASE]);
			$name = FriendlyURL::truncarPorPalabras($db, $idcategoria, $name);
			//echo "<br>";
            return sprintf("%s/%s",FriendlyURL::createPath($db, $row['idpadre'], false), $name);
        }
    }
	
	public static function truncarPorPalabras( &$db, $idcategoria, $nombre, $no_postfix = false )
	{
		if( strlen($nombre) <= FriendlyURL::LONGITUD_MAX_NIVEL_URL )
		{
			// no hacemos nada si no super la cantidad de caracteres maxima por nivel
			return $nombre;
		}
		$partes = explode("_", $nombre);
		if(count($partes) <= 1)
		{
			// no se corta sin importar su largo si solo hay una palabra
			return $nombre;
		}
		$parteFinal = $partes[count($partes)-1]; // posible idcategoria
		$cadenaFinal = "";
		$i = 0;
		//echo $cadenaFinal."-".FriendlyURL::LONGITUD_MAX_NIVEL_URL."-".$partes;
		while(strlen($cadenaFinal)<FriendlyURL::LONGITUD_MAX_NIVEL_URL && $i<count($partes))
		{
			if( strlen($cadenaFinal.$partes[$i]) >= FriendlyURL::LONGITUD_MAX_NIVEL_URL )
			{
				if( $no_postfix )
					return "{$cadenaFinal}";
				
				return "{$cadenaFinal}_{$idcategoria}";
				// terminamos
				if( /*($i!=count($partes)-1) && */$parteFinal == $idcategoria )
				{
					return "{$cadenaFinal}_{$idcategoria}"; // retornamos con la categoria al final para mantener unicidad
				}
				return "{$cadenaFinal}";
			}
			if( $cadenaFinal == "" )
				$cadenaFinal = "{$partes[$i]}";
			else
				$cadenaFinal .= "_{$partes[$i]}";
			$i++;
		}
		return "{$cadenaFinal}";
	}
	
	public static function validarPathUnico( &$db, $path )
	{
		$sql = "SELECT * FROM "._TBLCATEGORIA." WHERE ".COLUMNA_NOMBRE_URL." = '$path'";
        $r = $db->Execute($sql);
		if( !$r )
		{
			die("Error buscando la informacion del path unico $path: ".$db->ErrorMsg()."\n");
		}
		if( ($r->EOF) )
		{
			// Si no existe otro entonces true
			return true;
		}
		return false;
	}
	
	public static function generarUrlsAmigables( &$db, $cantidad_registros)
	{
		$t0 = time();
		$sql = "SELECT * FROM "._TBLCATEGORIA." WHERE ".COLUMNA_NOMBRE_UNICO." IS NOT NULL AND ".COLUMNA_NOMBRE_UNICO." <> '' AND isnull(nombre_url)  and activa = 1 and nombre_nivel is not null ORDER BY idcategoria DESC LIMIT $cantidad_registros";
		$result = $db->Execute($sql);
		if(!$result)
		{
			die("Error buscando la columna para el nombre base de amigables: ".$db->ErrorMsg()."\n");
		}
		if ($result !== FALSE && $result->NumRows() > 0){
			while (!$result->EOF){
				$idcategoria = $result->fields['idcategoria'];
				$nombre = trim($result->fields['nombre']);
				$nombre_nivel = $result->fields['nombre_nivel'];
				
				$url_friendly = FriendlyURL::createPath($db, $idcategoria);
				
				while( !FriendlyURL::validarPathUnico($db, $url_friendly) )
				{
					$url_friendly .= "_{$idcategoria}";
				}
				
				if( $nombre_nivel > FriendlyURL::$max_nombre_nivel )
				{
					$partes = explode("/", $url_friendly);
					$i = 0;
					$nuevo_url_friendly = "";
					while( $i < FriendlyURL::$max_nombre_nivel )
					{
						if(strlen($nuevo_url_friendly) == 0)
							$nuevo_url_friendly = "{$partes[$i++]}";
						else
							$nuevo_url_friendly = "{$nuevo_url_friendly}/{$partes[$i++]}";
					}
					$nuevo_url_friendly .= "/{$idcategoria}";
					if( FriendlyURL::$debug )
						echo "[$idcategoria] Modificando el url por nivel:\n\t$url_friendly\n\t$nuevo_url_friendly\n";
					$url_friendly = $nuevo_url_friendly;
				}
				
				$sqlUpdate = "UPDATE "._TBLCATEGORIA." SET"
					."  ".COLUMNA_NOMBRE_URL." = '$url_friendly'"
					." WHERE idcategoria = '$idcategoria'";
				if( FriendlyURL::$debug )
					echo "[$nombre] => ".($sqlUpdate)."\n";
				if(!$db->Execute($sqlUpdate))
				{
					die("Error generando los urls amigables: ".$db->ErrorMsg()."\n");
				}
				
				$result->MoveNext();
			}
		}
		$tf = time();
		$dt = $tf - $t0;
		echo __CLASS__."->".__METHOD__." tomo {$dt} segundos en terminar\n";
	}
	
	public static function crearCampos( &$db )
	{
		$col = COLUMNA_NOMBRE_BASE;
		if(!$db->Execute(sprintf('ALTER TABLE `%s` ADD `%s` VARCHAR(%s)', _TBLCATEGORIA, $col, LONGITUD_MAX_NOMBRE_UNICO)))
			echo "Error creando la columna $col: {$db->ErrorMsg()}<br>\n";
		else
			echo "Se creo el campo $col<br>\n";
		$col = COLUMNA_NOMBRE_UNICO;
		if(!$db->Execute(sprintf('ALTER TABLE `%s` ADD `%s` VARCHAR(%s) UNIQUE', _TBLCATEGORIA, $col, LONGITUD_MAX_NOMBRE_UNICO)))
			echo "Error creando la columna $col: {$db->ErrorMsg()}<br>\n";
		else
			echo "Se creo el campo $col<br>\n";
		$col = COLUMNA_NOMBRE_NIVEL;
		if(!$db->Execute(sprintf('ALTER TABLE `%s` ADD `%s` INTEGER', _TBLCATEGORIA, $col)))
			echo "Error creando la columna $col: {$db->ErrorMsg()}<br>\n";
		else
			echo "Se creo el campo $col<br>\n";
		$col = COLUMNA_NOMBRE_URL;
		if(!$db->Execute(sprintf('ALTER TABLE `%s` ADD `%s` VARCHAR(%s) UNIQUE', _TBLCATEGORIA, $col, LONGITUD_MAX_URL)))
			echo "Error creando la columna $col: {$db->ErrorMsg()}<br>\n";
		else
			echo "Se creo el campo $col<br>\n";
	}
	
	public static function borrarCampos( &$db )
	{
		$cols = array( COLUMNA_NOMBRE_BASE, COLUMNA_NOMBRE_UNICO, COLUMNA_NOMBRE_NIVEL, COLUMNA_NOMBRE_URL );
		foreach ($cols as $col) {
			if(!$db->Execute(sprintf('ALTER TABLE `%s` DROP COLUMN `%s`', _TBLCATEGORIA, $col)))
				echo "Error borrando el campo $col: {$db->ErrorMsg()}<br>\n";
			else
				echo "Se elimno el campo $col<br>\n";
		}
	}
	
	public static function limpiarCampos( &$db )
	{
		if(!$db->Execute(sprintf("UPDATE `%s` SET %s = NULL, %s = NULL, %s = NULL, %s = NULL"
				, _TBLCATEGORIA, COLUMNA_NOMBRE_BASE, COLUMNA_NOMBRE_UNICO, COLUMNA_NOMBRE_NIVEL, COLUMNA_NOMBRE_URL)))
			echo "Error limpiando los campos: {$db->ErrorMsg()}<br>\n";
		else
			echo "Se limpiaron los campos correctamente\n";
	}
	
	public static function callback_replace( $matches )
	{
		global $db;
		$fu = $matches[0];
		$host = $matches[2];
		// fix de urls
		$host = str_replace("//", "/", $host);
		$host = str_replace("./", "", $host);
		if( trim($host) == "" && is_numeric($matches[5]))
		{
			$fu = FriendlyURL::idCat2FId($db, $matches[5], "/"._DIR_URI_BASE).$matches[6];
		}
		return $fu;
	}

	public static function callback_replace_wo( $matches )
	{
		global $db;

		$org = $matches[0];
		$wojs = $matches[1];
		$comillas = $matches[2];
		$url = $matches[3];
		$org = "{$wojs}{$comillas}/{$url}";
		return $org;
	}

	/**
	 * Retorna el true o false del update de la tabla categoria cuando se crea el nombre base y nombre unico
	 * @param type $db
	 * @param type $idcategoria
	 * @param type $nombre_categoria
	 * @return boolean 
	 */
	public static function generarNombresBaseYUnicosCategoria( &$db, $nombre_categoria, $idcategoria )
	{
		global $db;
		// $sql = "SELECT * FROM "._TBLCATEGORIA." WHERE (nombre_base IS NULL OR nombre_base = '') ORDER BY idcategoria ASC";
		$nombre_friendly = FriendlyURL::nombreCategoria_a_urlAmigable($nombre_categoria);
		$nombre_friendly_con_consecutivo = "{$nombre_friendly}_{$idcategoria}";
		while(!FriendlyURL::validarNombreUnico($db, $nombre_friendly_con_consecutivo))
		{
			$nombre_friendly_con_consecutivo .= "_{$idcategoria}"; // Si esta duplicado volvemos a pegar la categoria
		}
		$sqlUpdate = "UPDATE "._TBLCATEGORIA." SET"
					."  ".COLUMNA_NOMBRE_BASE." = '$nombre_friendly'"
					.", ".COLUMNA_NOMBRE_UNICO." = '$nombre_friendly_con_consecutivo'"
					." WHERE idcategoria = '$idcategoria'";
		$result = $db->Execute($sqlUpdate);
		if($result){
			return true;
		}else{
			return false;
		}
		
	}

	/**
	 * Retorna el nivel de profundidad o false del update de la tabla categoria cuando se crea el nivel donde se encuentra la categoria
	 * @param type $db
	 * @param type $idcategoria
	 * @param type $nombre_categoria
	 * @return boolean 
	 */
	public static function generarProfundidadesCategoria( &$db, $idcategoria )
	{
		global $db;
		$profundidad = FriendlyURL::obtenerProfundidad($db, $idcategoria);
		$sqlUpdate = "UPDATE "._TBLCATEGORIA." SET"
					."  ".COLUMNA_NOMBRE_NIVEL." = '$profundidad'"
					." WHERE idcategoria = '$idcategoria'";
		$result = $db->Execute($sqlUpdate);
		if($result){
			return $profundidad;
		}else{
			return false;
		}

	}

	/**
	 * Retorna el nombre ur amigable o false del update de la tabla categoria cuando se crea el nombre de la url amigable
	 * @param type $db
	 * @param type $idcategoria
	 * @param type $nombre_categoria
	 * @return boolean 
	 */
	public static function generarUrlsAmigablesCategoria( &$db, $idcategoria, $nombre, $nombre_nivel )
	{	
		global $db;
		$url_friendly = FriendlyURL::createPath($db, $idcategoria);
		while( !FriendlyURL::validarPathUnico($db, $url_friendly) )
		{
			$url_friendly .= "_{$idcategoria}";
		}
		
		if( $nombre_nivel > FriendlyURL::$max_nombre_nivel )
		{
			$partes = explode("/", $url_friendly);
			$i = 0;
			$nuevo_url_friendly = "";
			while( $i < FriendlyURL::$max_nombre_nivel )
			{
				if(strlen($nuevo_url_friendly) == 0)
					$nuevo_url_friendly = "{$partes[$i++]}";
				else
					$nuevo_url_friendly = "{$nuevo_url_friendly}/{$partes[$i++]}";
			}
			$nuevo_url_friendly .= "/{$idcategoria}";
			if( FriendlyURL::$debug )
				echo "[$idcategoria] Modificando el url por nivel:\n\t$url_friendly\n\t$nuevo_url_friendly\n";
			$url_friendly = $nuevo_url_friendly;
		}
		
		$sqlUpdate = "UPDATE "._TBLCATEGORIA." SET"
			."  ".COLUMNA_NOMBRE_URL." = '$url_friendly'"
			." WHERE idcategoria = '$idcategoria'";
		
		$result = $db->Execute($sqlUpdate);
		if($result){
			return $url_friendly;
		}else{
			return false;
		}
	}

	public static function generarNombresBaseYUnicosNuevos( $db, $cantidad_registros)
	{
		$t0 = time();
		$fecha3=date("Y-m-d"." 00:00:00"); 
		$sql = "SELECT  * FROM "._TBLCATEGORIA." WHERE (nombre_base IS NULL OR nombre_base = '') ORDER BY idcategoria DESC LIMIT $cantidad_registros";

		$result = $db->Execute($sql);
	
		if(!$result)
		{
			die("Error buscando la columna para el nombre base de amigables: ".$db->ErrorMsg()."\n");
		}
		if ($result !== FALSE && $result->NumRows() > 0){
			while (!$result->EOF){
				$idcategoria = $result->fields['idcategoria'];
				$nombre = trim($result->fields['nombre']);
				if($nombre=="")
				{
					$nombre = "$idcategoria";
				}
				$nombre_friendly = FriendlyURL::nombreCategoria_a_urlAmigable($nombre);
				$nombre_friendly_con_consecutivo = "{$nombre_friendly}_{$idcategoria}";
				while(!FriendlyURL::validarNombreUnico($db, $nombre_friendly_con_consecutivo))
				{
					$nombre_friendly_con_consecutivo .= "_{$idcategoria}"; // Si esta duplicado volvemos a pegar la categoria
				}
				$sqlUpdate = "UPDATE "._TBLCATEGORIA." SET"
					."  ".COLUMNA_NOMBRE_BASE." = '$nombre_friendly'"
					.", ".COLUMNA_NOMBRE_UNICO." = '$nombre_friendly_con_consecutivo'"
					." WHERE idcategoria = '$idcategoria'";

				if( FriendlyURL::$debug )
					echo "[$nombre] => ".($sqlUpdate)."\n";
				if(!$db->Execute($sqlUpdate))
				{
					die("[idcatgoria: $idcategoria] => Error generando los nombres amigables: ".$db->ErrorMsg()."\n");
				}
				$result->MoveNext();
			}
		}
		$tf = time();
		$dt = $tf - $t0;
		echo __CLASS__."->".__METHOD__." tomo {$dt} segundos en terminar\n";
	}

	public static function generarProfundidadesNuevos( $db, $cantidad_registros)
	{
		$t0 = time();
		$fecha3=date("Y-m-d"." 00:00:00"); 
		$sql = "SELECT  * FROM "._TBLCATEGORIA." where (nombre_nivel IS NULL OR nombre_nivel = '' or isnull(nombre_nivel)) and activa = 1 ORDER BY idcategoria DESC LIMIT $cantidad_registros";
		$result = $db->Execute($sql);
		
		if(!$result)
		{
			die("Error buscando la columna para el nombre base de amigables: ".$db->ErrorMsg()."\n");
		}
		if ($result !== FALSE && $result->NumRows() > 0){
			while (!$result->EOF){
				$idcategoria = $result->fields['idcategoria'];
				$nombre = trim($result->fields['nombre']);
				$profundidad = FriendlyURL::obtenerProfundidad($db, $idcategoria);
				$sqlUpdate = "UPDATE "._TBLCATEGORIA." SET"
					."  ".COLUMNA_NOMBRE_NIVEL." = '$profundidad'"
					." WHERE idcategoria = '$idcategoria'";
				if( FriendlyURL::$debug )
					echo "[$idcategoria] => ".($sqlUpdate)."\n";
				if(!$db->Execute($sqlUpdate))
				{
					die("Error actualizando el nivel para la categoria $idcategoria: ".$db->ErrorMsg()."\n");
				}
				$result->MoveNext();
			}
		}		
		$tf = time();
		$dt = $tf - $t0;
		echo __CLASS__."->".__METHOD__." tomo {$dt} segundos en terminar\n";
	}

	public static function generarNuevasUrlsAmigables( $db, $cantidad_registros)
	{
		$t0 = time();
		$fecha3=date("Y-m-d"." 00:00:00"); 
		$sql = "SELECT  * FROM "._TBLCATEGORIA." WHERE isnull(nombre_url)  and length(nombre_unico) > 5 ORDER BY idcategoria DESC LIMIT $cantidad_registros";
		$result = $db->Execute($sql);
		if(!$result)
		{
			die("Error buscando la columna para el nombre base de amigables: ".$db->ErrorMsg()."\n");
		}
		if ($result !== FALSE && $result->NumRows() > 0){
			while (!$result->EOF){
				$idcategoria = $result->fields['idcategoria'];
				$nombre = trim($result->fields['nombre']);
				$nombre_nivel = $result->fields['nombre_nivel'];
				
				$url_friendly = FriendlyURL::createPath($db, $idcategoria);
				while( !FriendlyURL::validarPathUnico($db, $url_friendly) )
				{
					$url_friendly .= "_{$idcategoria}";
				}
				
				if( $nombre_nivel > FriendlyURL::$max_nombre_nivel )
				{
					$partes = explode("/", $url_friendly);
					$i = 0;
					$nuevo_url_friendly = "";
					while( $i < FriendlyURL::$max_nombre_nivel )
					{
						if(strlen($nuevo_url_friendly) == 0)
							$nuevo_url_friendly = "{$partes[$i++]}";
						else
							$nuevo_url_friendly = "{$nuevo_url_friendly}/{$partes[$i++]}";
					}
					$nuevo_url_friendly .= "/{$idcategoria}";
					if( FriendlyURL::$debug )
						echo "[$idcategoria] Modificando el url por nivel:\n\t$url_friendly\n\t$nuevo_url_friendly\n";
					$url_friendly = $nuevo_url_friendly;
				}
				
					$sqlUpdate = "UPDATE "._TBLCATEGORIA." SET"
				."  ".COLUMNA_NOMBRE_URL." = '$url_friendly'"
				." WHERE idcategoria = '$idcategoria'";

				if( FriendlyURL::$debug )
					echo "[$nombre] => ".($sqlUpdate)."\n";
				if(!$db->Execute($sqlUpdate))
				{
					die("Error generando los urls amigables: ".$db->ErrorMsg()."\n");
				}
				
				$result->MoveNext();
			}
		}
		$tf = time();
		$dt = $tf - $t0;
		echo __CLASS__."->".__METHOD__." tomo {$dt} segundos en terminar\n";
	}

	public static function actualizandoNombresBaseYUnicosNuevos( $db, $cantidad_registros )
	{
		$t0 = time();
		$fecha3=date("Y-m-d"." 00:00:00"); 
		$sql = "SELECT  * FROM "._TBLCATEGORIA." WHERE (nombre_base IS NOT NULL OR nombre_base != '') AND fecha3 >= '$fecha3' ORDER BY idcategoria DESC  LIMIT $cantidad_registros ";

		$result = $db->Execute($sql);
	
		if(!$result)
		{
			die("Error buscando la columna para el nombre base de amigables: ".$db->ErrorMsg()."\n");
		}
		if ($result !== FALSE && $result->NumRows() > 0){
			while (!$result->EOF){
				$idcategoria = $result->fields['idcategoria'];
				$nombre = trim($result->fields['nombre']);
				if($nombre=="")
				{
					$nombre = "$idcategoria";
				}
				$nombre_friendly = FriendlyURL::nombreCategoria_a_urlAmigable($nombre);
				$nombre_friendly_con_consecutivo = "{$nombre_friendly}_{$idcategoria}";
				while(!FriendlyURL::validarNombreUnico($db, $nombre_friendly_con_consecutivo))
				{
					$nombre_friendly_con_consecutivo .= "_{$idcategoria}"; // Si esta duplicado volvemos a pegar la categoria
				}
				$sqlUpdate = "UPDATE "._TBLCATEGORIA." SET"
					."  ".COLUMNA_NOMBRE_BASE." = '$nombre_friendly'"
					.", ".COLUMNA_NOMBRE_UNICO." = '$nombre_friendly_con_consecutivo'"
					." WHERE idcategoria = '$idcategoria'";

				if( FriendlyURL::$debug )
					echo "[$nombre] => ".($sqlUpdate)."\n";
				if(!$db->Execute($sqlUpdate))
				{
					die("[idcatgoria: $idcategoria] => Error generando los nombres amigables: ".$db->ErrorMsg()."\n");
				}
				$result->MoveNext();
			}
		}
		$tf = time();
		$dt = $tf - $t0;
		echo __CLASS__."->".__METHOD__." tomo {$dt} segundos en terminar\n";
	}

	public static function actualizandoProfundidadesNuevos( $db, $cantidad_registros)
	{
		$t0 = time();
		$fecha3=date("Y-m-d"." 00:00:00"); 
		$sql = "SELECT  * FROM "._TBLCATEGORIA." where (nombre_nivel IS NOT NULL OR nombre_nivel != '') and fecha3 >= '$fecha3' ORDER BY idcategoria DESC LIMIT $cantidad_registros";
		$result = $db->Execute($sql);
		
		if(!$result)
		{
			die("Error buscando la columna para el nombre base de amigables: ".$db->ErrorMsg()."\n");
		}
		if ($result !== FALSE && $result->NumRows() > 0){
			while (!$result->EOF){
				$idcategoria = $result->fields['idcategoria'];
				$nombre = trim($result->fields['nombre']);
				$profundidad = FriendlyURL::obtenerProfundidad($db, $idcategoria);
				$sqlUpdate = "UPDATE "._TBLCATEGORIA." SET"
					."  ".COLUMNA_NOMBRE_NIVEL." = '$profundidad'"
					." WHERE idcategoria = '$idcategoria'";
				if( FriendlyURL::$debug )
					echo "[$idcategoria] => ".($sqlUpdate)."\n";
				if(!$db->Execute($sqlUpdate))
				{
					die("Error actualizando el nivel para la categoria $idcategoria: ".$db->ErrorMsg()."\n");
				}
				$result->MoveNext();
			}
		}		
		$tf = time();
		$dt = $tf - $t0;
		echo __CLASS__."->".__METHOD__." tomo {$dt} segundos en terminar\n";
	}

	public static function ActualizarUrlsAmigables( $db, $cantidad_registros )
	{
		$t0 = time();
		$fecha3=date("Y-m-d"." 00:00:00"); 
		//$sql = "SELECT * FROM "._TBLCATEGORIA." where (nombre_url IS NULL OR nombre_url = '' or isnull(nombre_url))  and fecha3 >= '$fecha3' ORDER BY idcategoria DESC LIMIT $cantidad_registros";

		$sql = "SELECT  * FROM "._TBLCATEGORIA." WHERE isnull(nombre_url)  and length(nombre_unico) > 5 ORDER BY idcategoria DESC LIMIT $cantidad_registros";

		$result = $db->Execute($sql);
		if(!$result)
		{
			die("Error buscando la columna para el nombre base de amigables: ".$db->ErrorMsg()."\n");
		}
		if ($result !== FALSE && $result->NumRows() > 0){
			while (!$result->EOF){
				$idcategoria = $result->fields['idcategoria'];
				$nombre = trim($result->fields['nombre']);
				$nombre_nivel = $result->fields['nombre_nivel'];
				
				$url_friendly = FriendlyURL::createPath($db, $idcategoria);
				while( !FriendlyURL::validarPathUnico($db, $url_friendly) )
				{
					$url_friendly .= "_{$idcategoria}";
				}
				
				if( $nombre_nivel > FriendlyURL::$max_nombre_nivel )
				{
					$partes = explode("/", $url_friendly);
					$i = 0;
					$nuevo_url_friendly = "";
					while( $i < FriendlyURL::$max_nombre_nivel )
					{
						if(strlen($nuevo_url_friendly) == 0)
							$nuevo_url_friendly = "{$partes[$i++]}";
						else
							$nuevo_url_friendly = "{$nuevo_url_friendly}/{$partes[$i++]}";
					}
					$nuevo_url_friendly .= "/{$idcategoria}";
					if( FriendlyURL::$debug )
						echo "[$idcategoria] Modificando el url por nivel:\n\t$url_friendly\n\t$nuevo_url_friendly\n";
					$url_friendly = $nuevo_url_friendly;
				}
				
				$sqlUpdate = "UPDATE "._TBLCATEGORIA." SET"
					."  ".COLUMNA_NOMBRE_URL." = '$url_friendly'"
					." WHERE idcategoria = '$idcategoria'";
				if( FriendlyURL::$debug )
					echo "[$nombre] => ".($sqlUpdate)."\n";
				if(!$db->Execute($sqlUpdate))
				{
					die("Error generando los urls amigables: ".$db->ErrorMsg()."\n");
				}
				
				$result->MoveNext();
			}
		}
		$tf = time();
		$dt = $tf - $t0;
		echo __CLASS__."->".__METHOD__." tomo {$dt} segundos en terminar\n";
	}

	public static function ObtieneNombreUrl ($idcategoria){
		global $db;
		$sql = "SELECT nombre_url FROM "._TBLCATEGORIA." WHERE idcategoria = ".$idcategoria;
		$rst = $db->Execute($sql);

		return $rst->fields['nombre_url'];
	}

}

?>
