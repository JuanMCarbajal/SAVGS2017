<?php 

// models/Cuentas.php

/**
* Clase para manejo de las cuentas para S.A.V.G.S.
*
* Esta clase maneja tanto la creacion de cuentas como su consulta 
* necesaria para el login sobre la tabla cuentas.
*
* @package S.A.V.G.S.
* @author Matias <matiascabral95@gmail.com>
* @version 1.7
*/


class Cuentas extends Model 
{
	
	
	/**
	* Función de login que retorna los datos del usuario o un array vacio.
	*
	* Esta función recibe un array con los datos del nombre de usuario introducido y 
	* la contraseña, que esta es el resultado de la contraseña introducida pasada por 
	* el metodo de encriptacion SHA1, y al resultado concatenarlo con la string recibida
	* en el parametro $salt, y a este nuevo resultado volverle a pasar por el metodo SHA1.
	* 
	* En la funcion se compara el nombre introducido con los nombres de usuario de la tabla 
	* cuentas, y si se encuentra uno exactamente igual se procede a comparar la contraseña	
	* con la contraseña de la base de datos concatenada con el contenido de la string $salt
	* pasado por el metodo SHA1, si son iguales se retorna los datos del usuario, en caso
	* contrario se retorna un array vacio. 
	*
	* @param array $datos con un string de nombre de usuario y otro de contraseña encriptada.
	* @param string $salt una string para seguridad sobre la contraseña.
	* @return array retorna un array con los datos de nombre y perfil del usuario o vacio si 
	* no hay resultados.
	*/
	
	public function login($datos,$salt)
	{
		sleep(3);
	
		if(strlen($datos['usuario'])<2) throw new Exception("error1");
		$datos['usuario'] = substr($datos['usuario'],0,50);
		$datos['usuario'] = $this->db->escapeString($datos['usuario']);
		$usuario = $datos['usuario']; 

		$q =  "SELECT *	FROM cuentas where usuario = '$usuario'";
		
		$this->db->query($q);					
		$error=false;
		if($this->db->numRows()!=1)  $error = true; 
		
		if(!$error) 
		{
			$comp = $this->db->fetch();
						
			if($datos['password']==sha1($comp['password'].$salt))
				return Array('usuario'=>$comp['nro_usuario'],'perfil'=>$comp['perfil']);
			else return Array();
		}
	}		
	
	
	/**
	* Función de creacion de cuentas que retorna los datos del usuario.
	*
	* Esta función recibe el tipo de documento, el numero de documento, el numero de usuario
	* , y el perfil de la cuenta a crear, y estos dos ultimos datos los guarda en la tabla 
	* cuentas de la base de datos junto con el nombre de usuario generado por la  
	* concatenacion del tipo y numero de documento, y una contraseña generada con el metodo
	* generarContraseña, y retorna el nombre de usuario y la contraseña generada.
	*
	* @param integer $nro_user para numero del usuario.
	* @param integer $numero_documento para numero de documento del nombre de usuario.
	* @param string $tipo_documento una string para el tipo de documento del nombre de usuario.
	* @param string $perfil una string para el perfil del usuario.
	* @return array retorna un array con los datos de nombre y contraseña del usuario.
	*/
	
	public function crearCuenta($nro_user,$tipo_documento,$numero_documento,$perfil)
	{
		if(strlen($tipo_documento)<2) throw new Exception("error11");
		$tipo_documento = substr($tipo_documento,0,50);
		$tipo_documento = $this->db->escapeString($tipo_documento);
		
		if(!ctype_digit($numero_documento)) throw new Exception("error12");
		if(strlen($numero_documento)<2) throw new Exception("error13");
		$numero_documento = substr($numero_documento,0,10);
		
		if(!ctype_digit($nro_user)) throw new Exception("error12");
		
		$pass = $this->generarContraseña();
		
		$q = "INSERT INTO cuentas ( nro_usuario, perfil, usuario, password)
			values ($nro_user ,'$perfil','".$tipo_documento.$numero_documento."',sha1('$pass'))";
			
		$this->db->query($q);			
		
		return Array('usuario'=>$tipo_documento.$numero_documento,'contraseña'=>$pass);
	}
	
	/**
	* Función de creacion de string al azar el cual es retornado.
	*
	* Esta funcion genera un string al azar y lo retorna.	
	*	
	* @return string retorna una string generada al azar.
	*/
	
	public function generarContraseña()
	{		
	$vocales 	= array('a', 'e', 'i', 'o', 'u');
	$consonantes 	= array('b', 'c', 'd', 'f', 'g', 'j', 'l', 'm', 'n', 'p', 'r', 's', 't');
	$tamano 	= intval(rand(4,8));
	$actual		= intval(rand(1,2));		
	$nombre 	= '';	
	for($x=0;$x<$tamano;$x++)
	{			
		if($actual == 0)
		{
			$actual	= 1;
			$pos 	= rand(0,count($vocales)-1);
			$nombre	.=  $vocales[$pos];				
		}
		else			
		{
			$actual	= 0;
			$pos 	= rand(0,count($consonantes)-1);
			$nombre	.=  $consonantes[$pos];				
		}				
	}
	return ucfirst($nombre);
	}
	
	public function esCuenta($perfil, $tipoCuenta)
	{
		if($perfil != $tipoCuenta && $perfil != 'general')
		{
			switch($perfil)
			{						
				case 'almacen' :				
					header("Location: menualmacen.php");
					exit;
					break;
				case 'gerente' :	
					header("Location: menugerente.php");
					exit;	
					break;
				case 'vendedor' :		
					header("Location: menuvendedor.php");
					exit;
					break;
				default :
					header("Location: login.php");
					exit;				
					break;
			}
		}
	}
}

?>