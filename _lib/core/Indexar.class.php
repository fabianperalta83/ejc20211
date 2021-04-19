<?php
require_once("buscar/lib/Transform.class.php");
require_once("buscar/lib/Idf.class.php");
require_once("buscar/lib/Frecuencia.class.php");
	
class Indexar {
	/**
	 * Indexar :: guardar
	 *
	 * @return 
	 **/
	function guardar($contenido) {
		$lexemas = array();
		$unTransform = new Transform();
		$lexemas = $unTransform->stem($contenido);
	}
}

?>