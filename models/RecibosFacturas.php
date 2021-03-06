<?php 

// models/RecibosFacturas.php

/**
* Clase para manejo de los pagos a las facturas por recibo para S.A.V.G.S.
*
* Esta clase maneja tanto la entrada como la salida de datos de la tabla recibos_facturas.
*
* @package S.A.V.G.S.
* @author Juan <juanmcarbajal95@gmail.com>
* @version 1.7
*/
class RecibosFacturas extends Model
{
	/**
	* Función que retorna datos de todos los pagos realizados.
	*
	*
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getTodos()
	{
		$q = "SELECT * FROM recibos_facturas";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que busca los pagos de una factura y retorna sus datos.
	*
	* Esta función recibe un codigo identificador y los compara con los codigos
	* en la tabla recibos_facturas de la base de datos y devuelve los datos de 
	* los pagos de una factura cuyo codigo concuerde en su 
	* totalidad con el codigo recibido.
	*
	* @param string $nro_factura un string que contiene el codigo identificador	
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getPagoFactura($nro_factura)
	{
		if(!isset($nro_factura)) throw new Exception("error7");
		if(!ctype_digit($nro_factura)) throw new Exception("error8");
		$q = "SELECT importe_pagado FROM recibos_facturas
				WHERE nro_factura=$nro_factura";
		$this->db->query($q);		
		return $this->db->fetchAll();
	}
	
	/**
	*													Sin utilidad
	* Función que carga los pagos de un recibo
	*
	* Esta función recibe un codigo identificador de un recibo y los datos necesarios
	* para realizar una carga en la tabla recibos_facturas de la base de datos.
	* 
	* @param object $datos un objeto que contiene los datos para realizar la carga.
	* @param string $nro_factura un string que contiene un codigo identificador para realizar la carga	
	* @return array retorna un array vacio si se logra la carga.
	*/
	public function crearNuevo($datos,$nro_recibo)
	{
		if(!isset($nro_recibo)) throw new Exception("error1");
		if(!ctype_digit($nro_recibo)) throw new Exception("error12");
		if($this->validarTodo($datos))
		{	
		$q = "INSERT INTO recibos_facturas (nro_factura, nro_recibo,
						importe_pagado)
		          VALUES (".$datos->NRO_fact.",$nro_recibo,
				  ".$datos->impagar.");";
		
		$this->db->query($q);
		}
		return Array();
	}
		
	/**
	* Función que busca las facturas pagadas en un recibo y retorna sus datos.
	*
	* Esta función recibe un codigo identificador y los compara con los codigos
	* en la tabla recibos_facturas de la base de datos y devuelve los datos de 
	* los pagos de un recibo cuyo codigo concuerde en su 
	* totalidad con el codigo recibido.
	*
	* @param string $nro_recibo un string que contiene el codigo identificador
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getReciboFactura($nro_recibo)
	{
		if(!ctype_digit($nro_recibo)) throw new Exception("safas");
	
		$q = "SELECT rf.nro_recibo, rf.nro_factura, rf.importe_pagado, mp.descripcion_medio_pago
				FROM recibos_facturas as rf, medios_pago as mp, facturas as fac
				WHERE rf.nro_factura=fac.nro_factura
				AND fac.codigo_medio_pago=mp.codigo_medio_pago
				AND rf.nro_recibo=$nro_recibo
				ORDER BY rf.nro_factura ASC;";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que busca las facturas pagadas en un recibo y retorna sus datos.
	*
	* Esta función recibe un codigo identificador y los compara con los codigos
	* en la tabla recibos_facturas de la base de datos y devuelve los datos de 
	* los pagos de un recibo cuyo codigo concuerde en su 
	* totalidad con el codigo recibido. Esta funcion extrae solo datos usados para un informe de ventas.
	*
	* @param string $nro_recibo un string que contiene el codigo identificador
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getReciboFacturaVentas($nro_recibo)
	{
		if(!ctype_digit($nro_recibo)) throw new Exception("");
	
		$q = "SELECT rf.nro_factura,rf.importe_pagado,mp.descripcion_medio_pago
				FROM recibos_facturas as rf, medios_pago as mp, facturas as fac
				WHERE rf.nro_factura=fac.nro_factura
				AND fac.codigo_medio_pago=mp.codigo_medio_pago
				AND rf.nro_recibo=$nro_recibo;";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que valida los datos previo a una carga.
	*
	*
	* @param object $datos un objeto que contiene los datos para realizar la carga.	
	* @return bool retorna true si los datos son validos para realizar una carga.
	*/
	public function validarTodo($datos)
	{
		if(!isset($datos->NRO_fact)) throw new Exception("error1");
		if(!ctype_digit($datos->NRO_fact)) throw new Exception("error12");
		
		if(!isset($datos->impagar)) throw new Exception("error1");
		if(!is_numeric($datos->impagar)) throw new Exception("error12");
		
		return true;
	}
	
	/**
	* Función que busca los pagos que han realizado los clientes en determinada fecha
	* y retorna sus datos.
	*
	* Esta función recibe 2 fechas y extrae los pagos que han 
	* realizado los clientes entre ambas fechas.
	*
	* @param string $fecha_inic un string que contiene la fecha inicial para realizar la busqueda
	* @param string $fecha_fin un string que contiene la fecha final para realizar la busqueda
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getPagosInforme($fecha_inic,$fecha_fin)
	{
		if(!isset($fecha_inic)) throw new Exception("error16");
		if(strlen($fecha_inic)!=10) throw new Exception("error17");
		if(!isset($fecha_fin)) throw new Exception("error16");
		if(strlen($fecha_fin)!=10) throw new Exception("error17");
		$q="SELECT r.codigo_cliente, c.nombre_cliente,r.nro_recibo,r.importe_recibo
			FROM recibos as r, clientes as c
			WHERE r.codigo_cliente=c.codigo_cliente
			AND (r.fecha_recibo BETWEEN '$fecha_inic' AND '$fecha_fin')
			ORDER BY c.nombre_cliente ASC, r.nro_recibo ASC;";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
}