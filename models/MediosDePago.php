<?php 

// models/MediosDePago.php

/**
* Clase para manejo de los medios de pago para S.A.V.G.S.
*
* Esta clase maneja tanto la entrada como la salida de datos de la tabla medios_pago.
*
* @package S.A.V.G.S.
* @author Matias <matiascabral95@gmail.com>
* @version 1.7
*/

class MediosDePago extends Model 
{
	
	/**
	* Función que elimina un medio de pago en particular.
	*
	* @param integer $codigo un entero con el codigo indentificador de un medio de pago
	* en la base de datos.
	*/	
	
	public function eliminar($codigo)
	{
		if(!ctype_digit($codigo)) throw new Exception("error eliminar 1");
		if($codigo<=0) throw new Exception("error eliminar 2");
		
		$q = "UPDATE medios_pago SET baja_medio_pago = true WHERE codigo_medio_pago = $codigo ";
		$this->db->query($q);
	}
	
	/**
	* Función que devuelve todos los medios de pago.
	*	
	* @return array retorna un array con los datos de los medios de pago encontrados.
	*/
	
	public function getTodos()
	{
		$q = "SELECT * FROM medios_pago WHERE baja_medio_pago = false";
		
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que devuelve todos los medios de pago en uso.
	*	
	* @return array retorna un array con los datos de los medios de pago encontrados.
	*/
	public function getTodosEnUso()
	{
		$q = "SELECT * FROM medios_pago WHERE baja_medio_pago = false AND medio_pago_en_uso='Si'";
		
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que indica si existe o no un medio de pago en particular.
	*	
	* @param string $nombre una string que contiene la descripcion de un medio de pago.
	* @param integer $codigo un entero con el codigo indentificador de un medio de pago
	* en la base de datos, en caso de ser 0 este debe ser omitido en la consulta.
	* @return bool retorna un boolean que indica si existe o no el medio de pago.
	*/
	
		public function existe($nombre,$codigo)
	{
		if(strlen($nombre)<1) throw new Exception("error2");
		if(strlen($nombre)>50)
			$nombre=substr($nombre,0,50);
		$nombre=$this->db->escapeString($nombre);
		
		if(!ctype_digit($codigo)) throw new Exception("error7");
		
		$q = "SELECT * FROM medios_pago WHERE descripcion_medio_pago = '$nombre' ";
					
		if($codigo!=0)
			$q = $q." AND codigo_medio_pago <> $codigo";
					
		$this->db->query($q);
		if($this->db->numRows()!=0)
			return true;
		return false;
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
		
		$q = "SELECT * FROM medios_pago WHERE codigo_medio_pago=$codigo AND baja_medio_pago = false";		
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
		$q = "INSERT INTO medios_pago (medio_pago_en_uso, descripcion_medio_pago )
		          VALUES ('Si','".$datos['descripcion-medio-pago']."');";
		
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
		$q = "UPDATE medios_pago SET descripcion_medio_pago='".$datos['descripcion-medio-pago']."'
		, medio_pago_en_uso='".$datos['en-uso']."'
			WHERE codigo_medio_pago = ".$datos['codigo-medio-pago'];
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
		if(!isset($datos['descripcion-medio-pago'])) throw new Exception("error1");
		if(strlen($datos['descripcion-medio-pago'])<1) throw new Exception("error2");
		if(strlen($datos['descripcion-medio-pago'])>50)
			substr($datos['descripcion-medio-pago'],0,50);
		$datos['descripcion-medio-pago']=$this->db->escapeString($datos['descripcion-medio-pago']);

		IF($es_mod)
		{
			if(!isset($datos['en-uso'])) throw new Exception("error7");			
			if(strlen($datos['en-uso'])!=2) throw new Exception("error8");
		}
		
		return true;
	}
}

?>