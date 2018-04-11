<?php 

// models/TiposProducto.php

/**
* Clase para manejo de los medios de pago para S.A.V.G.S.
*
* Esta clase maneja tanto la entrada como la salida de datos de la tabla tipos_producto.
*
* @package S.A.V.G.S.
* @author Matias <matiascabral95@gmail.com>
* @version 1.7
*/

class TiposProducto extends Model 
{
	
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
		
		$q = "DELETE FROM tipos_producto WHERE codigo_tipo_producto = $codigo ";
		$this->db->query($q);
	}
	
	/**
	* Función que devuelve todos los medios de pago.
	*	
	* @return array retorna un array con los datos de los medios de pago encontrados.
	*/
	
	public function getTodos()
	{
		$q = "SELECT * FROM tipos_producto";
		
		$this->db->query($q);
		return $this->db->fetchAll();
	}
		
	/**
	* Función que devuelve todos los datos de un medio de pago en particular.
	*	
	* @param integer $codigo un entero con el codigo indentificador de un medio de pago.
	* @return array retorna un array con los datos del medio de pago encontrado.
	*/
	
	public function getPorCodigo($codigo)
	{
		if(!ctype_digit($codigo))  throw new Exception("getPorCodigo");
		
		$q = "SELECT * FROM tipos_producto WHERE codigo_tipo_producto=$codigo ";		
		$this->db->query($q);		
		return $this->db->fetch();
	}
	
	/**
	* Función que crea un nuevo medio de pago a partir de los datos recibidos.
	*	
	* @param array $datos array con todos los datos necesarios de un medio de pago.
	* @return array retorna un array vacio en caso de que no validen los datos.
	*/
	
	public function crearNuevo($datos)
	{
		if($this->validarTodo($datos))
		{	
		$q = "INSERT INTO tipos_producto (descripcion_tipo)
		          VALUES ('".$datos['descripcion-tipo']."')";
		
		$this->db->query($q);
		}
		return Array();		
	}
	
	/**
	* Función que modifica un medio de pago existente a partir de los datos recibidos.
	*	
	* @param array $datos array con todos los datos necesarios de un medio de pago.
	* @return array retorna un array vacio en caso de que no validen los datos.
	*/
	
	public function modificar($datos)
	{
		if($this->validarTodo($datos, true))
		{			
		$q = "UPDATE tipos_producto SET descripcion_tipo='".$datos['descripcion-tipo']."'
			WHERE codigo_tipo_producto = ".$datos['codigo-tipo-producto'];
		$this->db->query($q);
		}
		return Array();
	}
	
	/**
	* Función que valida todos los datos de un medio de pago para introducirlos en
	* la base de datos.
	*	
	* @param array $datos array con todos los datos necesarios de un medio de pago.
	* @param bool $es_mod boolean que indica si es modificacion, en caso de serlo
	* se debe validar el dato que indica si esta en uso.
	* @return bool retorna true en caso de que el medio de pago sea valido.
	*/
	
	public function validarTodo($datos, $es_mod=false)
	{
		if(!isset($datos['descripcion-tipo'])) throw new Exception("error1");
		if(strlen($datos['descripcion-tipo'])<1) throw new Exception("error2");
		if(strlen($datos['descripcion-tipo'])>50)
			substr($datos['descripcion-tipo'],0,50);
		$datos['descripcion-tipo']=$this->db->escapeString($datos['descripcion-tipo']);
		
		return true;
	}
	
	public function existe($nombre,$codigo)
	{
		if(strlen($nombre)<1) throw new Exception("error2");
		if(strlen($nombre)>50)
			$nombre=substr($nombre,0,50);
		$nombre=$this->db->escapeString($nombre);
		
		if(!ctype_digit($codigo)) throw new Exception("error7");
		
		$q = "SELECT * FROM tipos_producto WHERE descripcion_tipo = '$nombre' ";
					
		if($codigo!=0)
			$q = $q." AND codigo_tipo_producto <> $codigo";
					
		$this->db->query($q);
		if($this->db->numRows()!=0)
			return true;
		return false;
	}
}

?>