<?php 

// models/Proveedores.php

/**
* Clase para manejo de los proveedores para para S.A.V.G.S.
*
* Esta clase maneja tanto la entrada como la salida de datos de la tabla proveedores.
*
* @package S.A.V.G.S.
* @author Juan <juanmcarbajal95@gmail.com>
* @version 1.0
*/

class Proveedores extends Model 
{
	
	/**
	* Función que devuelve todos los proveedores.
	*	
	* @return array retorna un array con los datos de los proveedores encontrados.
	*/
	
	public function getTodos()
	{
		$q = "SELECT * FROM proveedores";
		
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que devuelve todos los datos de un proveedor en particular.
	*	
	* @param integer $codigo un entero con el codigo indentificador de un proveedor.
	* @return array retorna un array con los datos del proveedor encontrado.
	*/
	
	public function getProveedorCodigo($codigo)
	{
		if(!isset($codigo)) throw new Exception("error1");
		if(!ctype_digit($codigo)) throw new Exception("error2");
		$q = "SELECT * FROM proveedores WHERE codigo_proveedor=$codigo";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
	/**
	* Función que devuelve todos los datos de un proveedor en particular a partir de 
	* su descripcion
	*	
	* @param integer $nro_doc un entero con el numero de documento de un proveedor.
	* @param integer $tip_doc un entero que indica el tipo de documento de un proveedor.
	* @return array retorna un array con los datos del proveedor encontrado.
	*/
	
	public function getProveedorDescripcion($desc)
	{
		if(!isset($desc)) throw new Exception("error1");
		if(strlen($desc)<2) throw new Exception("error2");
		if(strlen($desc)>50)
			substr($desc,0,50);
		$desc=$this->db->escapeString($desc);
		$nombre=$desc;
		$q = "SELECT * FROM proveedores
				WHERE descripcion_proveedor=$nombre
				LIMIT 1";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
	/**
	* Función que crea un nuevo proveedor a partir de los datos recibidos.
	*	
	* @param array $datos array con todos los datos necesarios de un proveedor.
	* @param array $tipos_doc array con todos los datos de los tipos de documentos.
	* @return array retorna un array con los datos del proveedor creado.
	*/
	
	public function crearNuevo($datos)
	{	
		
		if(!isset($datos['descripcion-proveedor'])) throw new Exception("error1");
		if(strlen($datos['descripcion-proveedor'])<2) throw new Exception("error2");
		if(strlen($datos['descripcion-proveedor'])>50)
			substr($datos['descripcion-proveedor'],0,50);
		$datos['descripcion-proveedor']=$this->db->escapeString($datos['descripcion-proveedor']);
		$nombre=$datos['descripcion-proveedor'];
		/*
		if(!isset($datos['telefono'])) throw new Exception("error3");
		if(!ctype_digit($datos['telefono'])) throw new Exception("error4");
		if(strlen($datos['telefono'])<1) throw new Exception("error4.5");
		if(strlen($datos['telefono'])>20)
			substr($datos['telefono'],0,20);
		$telefono=$datos['telefono'];
		
		if(!isset($datos['direccion'])) throw new Exception("error5");
		if(strlen($datos['direccion'])<1) throw new Exception("error6");
		if(strlen($datos['direccion'])>50)
			substr($datos['direccion'],0,50);
		$datos['direccion']=$this->db->escapeString($datos["direccion"]);
		$direccion=$datos['direccion'];
		
		if(!isset($datos['localidad'])) throw new Exception("error8");
		if(strlen($datos['localidad'])<1) throw new Exception("error9");
		if(strlen($datos['localidad'])>50)
			substr($datos['localidad'],0,50);
		$datos['localidad']=$this->db->escapeString($datos['localidad']);
		$localidad=$datos['localidad'];
	
		if(!isset($datos['codigo-postal'])) throw new Exception("error11");
		if(!ctype_digit($datos['codigo-postal'])) throw new Exception("error11.5");
		if(strlen($datos['codigo-postal'])<1) throw new Exception("error12");
		if(strlen($datos['codigo-postal'])>10)
			substr($datos['codigo-postal'],0,10);
		$codigoPostal=$datos['codigo-postal'];
		
		if(!isset($datos['cuil'])) throw new Exception("error16");
		if(strlen($datos['cuil'])<1) throw new Exception("error17");
		if(strlen($datos['cuil'])>15)
			substr($datos['cuil'],0,15);
		$datos['cuil']=$this->db->escapeString($datos['cuil']);
		$cuil=$datos['cuil'];
		
		
		$q = "INSERT INTO proveedores (descripcion_proveedor, telefono_proveedor,
				direccion_proveedor, localidad_proveedor, codigo_postal_proveedor,
				nro_documento_proveedor, codigo_tipo_documento, cuil_proveedor, sexo_proveedor)
		         VALUES ('$nombre','$telefono','$direccion','$localidad','$codigoPostal','$nroDocumento',$tipodocumento,'$cuil','$sexo')";
		
		$this->db->query($q);
		*/
		$q = "INSERT INTO proveedores (descripcion_proveedor)
		         VALUES ('$nombre')";
		
		$this->db->query($q);
	}
	
	public function modificar($datos)
	{
		if(!isset($datos['descripcion-proveedor'])) throw new Exception("error1");
		if(strlen($datos['descripcion-proveedor'])<2) throw new Exception("error2");
		if(strlen($datos['descripcion-proveedor'])>50)
			substr($datos['descripcion-proveedor'],0,50);
		$datos['descripcion-proveedor']=$this->db->escapeString($datos['descripcion-proveedor']);
		$nombre=$datos['descripcion-proveedor'];
		
		if(!isset($datos['codigo-proveedor'])) throw new Exception("error1");
		if(!ctype_digit($datos['codigo-proveedor'])) throw new Exception("error2");
		
		$q = "UPDATE proveedores SET descripcion_proveedor='$nombre' 
			WHERE codigo_proveedor = ".$datos['codigo-proveedor'];
		$this->db->query($q);

		return Array();		
	}
	
	/**
	* Función que elimina un tipo de producto en particular.
	*
	* @param integer $codigo un entero con el codigo indentificador de un medio de pago
	* en la base de datos.
	*/	
	
	public function eliminar($codigo)
	{
		if(!ctype_digit($codigo)) throw new Exception("error eliminar 1");
		if($codigo<=0) throw new Exception("error eliminar 2");
		
		$q= "SELECT * FROM mercaderia WHERE codigo_proveedor=$codigo";
		$this->db->query($q);
		
		if($this->db->numRows()==0)
		{
			$q = "DELETE FROM proveedores WHERE codigo_proveedor = $codigo ";
			$this->db->query($q);
		}
	}
	
	/**
	* Función que indica si existe o no un proveedor en particular.
	*	
	* @param integer $nro un entero con el numero de documento de un proveedor.
	* @param integer $tipo un entero que indica el tipo de documento de un proveedor.
	* @param integer $cuil un entero con el cuil de un proveedor.
	* @param integer $codigo un entero con el codigo indentificador de un proveedor
	* en la base de datos, en caso de ser 0 este debe ser omitido en la consulta.
	* @return bool retorna un boolean que indica si existe o no el proveedor.
	*/
	
		public function existe($nombre,$codigo)
	{
		/*
		if(!ctype_digit($cuil)) throw new Exception("error3");
		if(strlen($cuil)<2) throw new Exception("error4");
		if(strlen($cuil)>11)
			$cuil=substr($cuil,0,11);
		*/
		if(!isset($nombre)) throw new Exception("error1");
		if(strlen($nombre)<2) throw new Exception("error2");
		if(strlen($nombre)>50)
			substr($nombre,0,50);
		$nombre=$this->db->escapeString($nombre);

		
		if(!ctype_digit($codigo)) throw new Exception("error7");
				
		$q = "SELECT * FROM proveedores WHERE descripcion_proveedor=$nombre";
		
		if($codigo!=0)
			$q = $q." AND codigo_proveedor <> $codigo";
		
		$this->db->query($q);
		if($this->db->numRows()!=0)
			return true;
		return false;

	}
}

?>