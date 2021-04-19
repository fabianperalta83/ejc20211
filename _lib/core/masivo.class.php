<?php
ini_set('display_errors',1);
class masivo{
	
	public function ejecutar($db){
		$consulta="SELECT * FROM usuario where idzona<>'1' and idusuario='116655' order by idzona";
		$result = $db->getAll($consulta);
		echo "Registros encontrados: " . count($result);
		$texto='<br />';
		foreach ($result as $key => $usuario) {
			$confirma='';
			while ( $confirma != "seguro") {
				$caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_-=+:.";
				$password = substr(str_shuffle( $caracteres ), 0, 10 );
				if(preg_match("/^.*(?=.{10,})(?=.*\d)(?=.*\W+)(?=.*[a-z])(?=.*[A-Z]).*$/", $password)){
					$confirma='seguro';
				}
			}
			$password_sha1 = sha1($usuario['email'].$password);
			
			$consulta_pass=sprintf("UPDATE %s SET password='".$password_sha1."' where idusuario=%s",_TBLUSUARIO,$usuario['idusuario']);
			$result_pass = $db->Execute($consulta_pass);	
			$texto.="<br />Contraseña limpia: ".$usuario['username'];
			//modificacion de permsios
			//$consulta_mod=sprintf("UPDATE %s SET idzona='1' where idusuario='%s'",_TBLPORUSUARIOGEL,$usuario['idusuario']);
			//$result_mod=$db->Execute($consulta_mod);
			
			//notificacion por correo electronico
			
				$mensaje="Estimado(a) ".$usuario['nombres']." ".$usuario['apellidos']." <br /> Como parte de las medidas de seguridad del portal "._NOMBRESITIO." la estructura del password de acceso fue modificada para garantizar su integriadad,
				por favor ingrese al siguiente link para actualizarlo.<br />";
				$mensaje .= sprintf("<br /><br />%s/index.php?idcategoria=7  Opci&oacute;n --Recordar mis datos--",_URL);
				$from  = "From:"._EMAILREGISTRO;
				if(!Funciones::microsmail($usuario['email'],"Password de Seguridad Portal " . _NOMBRESITIO,$mensaje,$from)){
					$texto.= "--Error notificacion: " . $usuario["email"];
				}
			$texto.="<br />";
		}
		
		return $texto;
	}
}
?>