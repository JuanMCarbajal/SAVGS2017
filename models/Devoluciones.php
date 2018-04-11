<?php 	
	// models/Devoluciones.php
	
/**
* Clase para manejo de las devoluciones para S.A.V.G.S.
*
* Esta clase maneja tanto la entrada como la salida de datos de la tabla devoluciones.
*
* @package S.A.V.G.S.
* @author Matias <matiascabral95@gmail.com>
* @version 1.7
*/

class Devoluciones extends Model
{
	
	/**
	* Función que devuelve todos las devoluciones.
	*	
	* @return array retorna un array con los datos de las devoluciones encontradas.
	*/
	
	public function getTodos()
	{
		$q = "SELECT * FROM devoluciones";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que devuelve la ultima devolucion realizada por un cliente.
	*	
	* @param integer $datos entero que identifica el cliente del cual se busca la devolucion.	
	* @return array retorna un array con los datos de la ultima devolucion encontrada o 
	* un array vacio si no hay resultado.
	*/
	
	public function getUltimaDevolucion($datos)
	{
		if(!isset($datos)) throw new Exception("error1");
		if(!ctype_digit($datos)) throw new Exception("error12");
		$q="SELECT codigo_devolucion FROM devoluciones WHERE codigo_cliente=$datos
			ORDER BY codigo_devolucion DESC
			LIMIT 1";
		$this->db->query($q);
		$aux=$this->db->fetch();
		$aux=$aux['codigo_devolucion'];
		return $aux;
	}
	
	/**
	* Función que crea una nueva devolucion a partir de los datos recibidos.
	*	
	* @param array $datos array con todos los datos necesarios de una devolucion.
	*/
	
	public function crearNuevo($datos)
	{
		if($this->validarTodo($datos))
		{	
		$q = "INSERT INTO devoluciones(codigo_cliente,importe_total_devolucion,fecha_devolucion)
				VALUES ({$datos['cod_cliente']},{$datos['importe_devolucion']},NOW() );";
		$this->db->query($q);
		return $datos['importe_devolucion'];
		}
	}
	
	/**
	* Función que devuelve una devolucion buscada por codigo si existe.
	*	
	* @param integer $cod_devolucion entero que identifica una devolucion.	
	* @return array retorna un array con los datos de la devolucion encontrada o 
	* un array vacio si no hay resultado.
	*/
	
	public function getDevolucionCodigo($cod_devolucion)
	{
		if(!isset($cod_devolucion)) throw new Exception("error7");
		if(!ctype_digit($cod_devolucion)) throw new Exception("error8");
		$q = "SELECT * FROM devoluciones WHERE codigo_devolucion=$cod_devolucion";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
	/**
	* Función que valida todos los datos de una devolucion.
	*	
	* @param array $datos array con todos los datos necesarios de una devolucion.
	* @return bool retorna true en caso de que la devolucion sea valida.
	*/
	
	public function validarTodo($datos)
	{
		if(!isset($datos['importe_devolucion'])) throw new Exception("error3");
		if(!is_numeric($datos['importe_devolucion'])) throw new Exception("error4");
		if(strlen($datos['importe_devolucion'])<1) throw new Exception("error5");
		if(strlen($datos['importe_devolucion'])>10)throw new Exception("error6");		
		
		if(!isset($datos['cod_cliente'])) throw new Exception("error7");
		if(!ctype_digit($datos['cod_cliente'])) throw new Exception("error8");
		if(strlen($datos['cod_cliente'])<1) throw new Exception("error9");
		if(strlen($datos['cod_cliente'])>10)throw new Exception("error10");
		
		return true;
	}
	
	/**
	* Función que devuelve los datos de las devoluciones realizadas entre dos fechas.
	*	
	* @param string $fecha_inic una string que representa la fecha minima de las devoluciones buscadas.
	* @param string $fecha_fin una string que representa la fecha maxima de las devoluciones buscadas.
	* @return array retorna un array con los datos de las devoluciones encontradas o 
	* un array vacio si no hay resultados.
	*/	
	
	public function getTotalDevolucionesInforme($fecha_inic,$fecha_fin)
	{
		if(!isset($fecha_inic)) throw new Exception("error16");
		if(strlen($fecha_inic)!=10) throw new Exception("error17");
		if(!isset($fecha_fin)) throw new Exception("error16");
		if(strlen($fecha_fin)!=10) throw new Exception("error17");
		$q="SELECT SUM(importe_total_devolucion) as 'total' FROM devoluciones
			WHERE (fecha_devolucion BETWEEN '$fecha_inic' AND '$fecha_fin');";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
	/**
	* Función que devuelve la cantidad de devoluciones realizadas entre dos fechas.
	*	
	* @param string $fecha_inic una string que representa la fecha minima de las devoluciones buscadas.
	* @param string $fecha_fin una string que representa la fecha maxima de las devoluciones buscadas.
	* @return array retorna un array con el dato de la cantidad de devoluciones encontradas. 
	*/
	
	public function getCantidadDevolucionesInforme($fecha_inic,$fecha_fin)
	{
		if(!isset($fecha_inic)) throw new Exception("error16");
		if(strlen($fecha_inic)!=10) throw new Exception("error17");
		if(!isset($fecha_fin)) throw new Exception("error16");
		if(strlen($fecha_fin)!=10) throw new Exception("error17");
		$q="SELECT COUNT(codigo_devolucion) as 'total' FROM devoluciones
			WHERE (fecha_devolucion BETWEEN '$fecha_inic' AND '$fecha_fin');";
		$this->db->query($q);
		return $this->db->fetch();
	}
}
	
		
	
	
	