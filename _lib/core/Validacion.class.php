<?php
/**
 * Validacion
 *
 * Ayuda a la validacion campos (Ej: formularios)
 * @return 
 * 2005 copyright
 **/

class Validacion {
    // Verifica email valido
    // (de la a-z y del 0-9)+@+(de la a-z y del 0-9)+.+(algo de la a-z de 2 o 3 posiciones)
    public static function isEmail(&$var, $esObligatorio = FALSE) {
    	if ($esObligatorio === TRUE) {
    		 if (Validacion::isEmpty($var)) {
    		 	return false;
    		 }
    	}
        $parts = preg_split("/,|\\n/", $var);
    	foreach($parts as $part){
            $coincidencias = preg_match( "/^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$/i", trim($part) ); // false on error
            if( $coincidencias===false || $coincidencias === 0 ) {
            	return false;
	        }
    	}
    	$var=implode(",",$parts);
    	return true;
    }

    // Verifica que una cadena sea solo numerica
    public static function isNum($var) {
        $coincidencias = preg_match( "/^[0-9]+$/", trim($var) ); // false on error
        if( $coincidencias===false || $coincidencias === 0 ) {
            return false;
        } else {
            return true;
        }
    }
    
    // Verifica que una cadena sea solo numerica
    public static function isCel($var) {
        $tamano = strlen($var);
        $coincidencias = preg_match( "/^[0-9]+$/", trim($var) ); // false on error
        if( $coincidencias===false || $coincidencias === 0 || $tamano != 10 ) {
            return false;
        } else {
            return true;
        }
    }
   
    // Verifica que una cadena de tipo telefono (numeros y espacio)
    public static function isNumTelephone($var) {
        $coincidencias = preg_match( "/^[0-9 ]+$/", trim($var) ); // false on error
        if( $coincidencias===false || $coincidencias === 0 ) {
            return false;
        } else {
            return true;
        }
    }
    // Verifica que una cadena este entre una longitud minima y maxima
    public static function isOfLength($var,$lengthMin,$lengthMax) {
        $long = strlen($var);
        if(($long < $lengthMin) | ($long > $lengthMax)) {
            return false;
        } else {
            return true;
        }
    }

    // Verifica que una cadena sea alfanumerica solamente
    public static function isAlnum($var) {
        $coincidencias = preg_match( "/^[[:alnum:]]+$/i", trim($var) ); // false on error
        if( $coincidencias===false || $coincidencias === 0 ) {
            return false;
        } else {
            return true;
        }
    }

    // Verifica que una cadena sea solo a-Z
    public static function isAlpha($var) {
        $coincidencias = preg_match( "/^[[:alpha:]]+$/i", trim($var) ); // false on error
        if( $coincidencias===false || $coincidencias === 0 ) {
            return false;
        } else {
            return true;
        }
    }
    // Verifica que una cadena sea solo a-Z y espacio
    public static function isCadena($var, $esObligatorio = FALSE) {
    	if ($esObligatorio === TRUE) {
    		 if (Validacion::isEmpty($var)) {
    		 	return false;
    		 }
    	}
        $coincidencias = preg_match( "/^[a-zA-Z0-9ρΡαινσϊΑΙΝΣΪόά&. ]+$/i", trim($var) ); // false on error
        if( $coincidencias===false || $coincidencias === 0 ) {
            return false;
        } else {
            return true;
        }
    }
    //	Verifica que una cadena sea vacia
    public static function isEmpty($var) {
    	$var = trim($var);
    	if (empty($var) and $var != "0") {
    		return true;
    	} else {
    		return false;
    	}
    }
    // Verifica que una cadena sea solo a-Z y espacio numeros y algunos caracteres
    public static function isTexto($var, $esObligatorio = FALSE) {
    	if ($esObligatorio === TRUE) {
    		 if (Validacion::isEmpty($var)) {
    		 	return false;
    		 }
    	}                                              
        $coincidencias = preg_match( "/^[a-zA-Z0-9 .&#ρΡαινσϊΑΙΝΣΪόά]+$/i", trim($var) ); // false on error
        if( $coincidencias===false || $coincidencias === 0 ) {
            return false;
        } else {
            return true;
        }
    }
    
	public static function isTextoAcento($var, $esObligatorio = FALSE){
	
	    if ($esObligatorio === TRUE) {
    		 if (Validacion::isEmpty($var)) {
    		 	return false;
    		 }
    	}
        $coincidencias = preg_match( "/^([a-z ραινσϊ])+$/i", trim($var)); // false on error
        if( $coincidencias===false || $coincidencias === 0 ) {
            return false;
        } else {
            return true;
        }
	   
	   
	}
	
    public static function soloTexto($var, $esObligatorio = FALSE) {
    	if ($esObligatorio === TRUE) {
                if (Validacion::isEmpty($var)) {
                    return false;
                }
    	}
        $coincidencias = preg_match( "/^[a-zA-Z .&#ρΡαινσϊΑΙΝΣΪόά]+$/i", trim($var) ); // false on error
        if( $coincidencias===false || $coincidencias === 0 ) {
            return false;
        } else {
            return true;
        }
    }
   
     // Verifica que una cadena sea solo a-Z y espacio
    public static function isUsername($var, $esObligatorio = FALSE) {
    	if ($esObligatorio === TRUE) {
    		 if (Validacion::isEmpty($var)) {
    		 	return false;
    		 }
    	}
        $coincidencias = preg_match( "/^[a-zA-Z .@_0-9]+$/i", trim($var) ); // false on error
        if( $coincidencias===false || $coincidencias === 0 ) {
            return false;
        } else {
            return true;
        }
    }

    // Verifica que una cadena no tenga espacios
    public static function noSpaces($var) {
        if( strpos(trim($var), " ") !== false ) {
            return false;
        } else {
            return true;
        }
    }

    // Verifica que una cadena sea una direccion IP valida
    public static function isIPAddr($var) {
        $coincidencias = preg_match( "/\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/", trim($var) ); // false on error
        if( $coincidencias===false || $coincidencias === 0 ) {
            return false;
        } else {
            return true;
        }
    }

    // Compara dos cadenas
    public static function isEqual($var1,$var2) {
        if($var1!=$var2) {
            return false;
        } else {
            return true;
        }
    }
    // Verifica date valido
    public static function isDate($var) {
        $coincidencias = preg_match( "/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/i", trim($var) ); // false on error
        if( $coincidencias===false || $coincidencias === 0 ) {
            return false;
        } else {
            return true;
        }
    }
    // Verifica date valido
    public static function isDateTime($var) {
        $coincidencias = preg_match( "/^[0-9]{4}\-[0-9]{2}\-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/i", trim($var) ); // false on error
        if( $coincidencias===false || $coincidencias === 0 ) {
            return false;
        } else {
            return true;
        }
    }
    // Verifica con una expresion dada y devuelve si o no
    public static function isCustom($var, $expression) {
        $coincidencias = preg_match( "/$expression/i", trim($var) ); // false on error
        if( $coincidencias===false || $coincidencias === 0 ) {
            return false;
        } else {
            return true;
        }
    }
}
?>