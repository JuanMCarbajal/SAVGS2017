<?php 

// models/RenglonDevolucion.php

/**
* Clase para manejo de los articulos devueltos para S.A.V.G.S.
*
* Esta clase maneja tanto la entrada como la salida de datos de la tabla renglon_devolucion.
*
* @package S.A.V.G.S.
* @author Juan <0juankarbajal0@gmail.com>
* @version 1.7
*/	
class RenglonDevolucion extends Model
{
	
	/**
	* Función que busca los articulos devueltos en una devolucion y retorna sus datos.
	*
	* Esta función recibe un codigo identificador y los compara con los codigos
	* en la tabla renglon_devolucion de la base de datos y devuelve los datos de 
	* los articulos devueltos de una devolucion cuyo codigo concuerde en su 
	* totalidad con el codigo recibido.
	*
	* @param string $codigo_devolucion un string que contiene el codigo identificador	
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getRenglonesDevolucion($codigo_devolucion)
	{
		if(!ctype_digit($codigo_devolucion)) throw new Exception("");
		
		$q = "SELECT d.codigo_producto, d.codigo_devolucion,d.nro_factura, prod.descripcion_producto, d.cantidad_devuelta,
				ROUND(rf.costo_producto * (rf.porcen_venta_producto/100)+1,2)as 'precio_unitario', rf.porcen_desc_producto,
				ROUND(ROUND(ROUND(rf.costo_producto*(rf.porcen_venta_producto/100+1),2)*rf.cantidad_renglonfactura,2)*(1-rf.porcen_desc_producto/100),2) as 'precio_final'
			FROM renglon_devolucion as d, mercaderia as prod, renglon_factura as rf
			WHERE d.codigo_producto=prod.codigo_producto
			AND	d.nro_factura = rf.nro_factura
			AND d.codigo_producto = rf.codigo_producto
			AND d.codigo_devolucion=$codigo_devolucion";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que busca los articulos devueltos en una factura y retorna sus datos.
	*
	* Esta función recibe un codigo identificador y los compara con los codigos
	* en la tabla renglon_devolucion de la base de datos y devuelve los datos de 
	* los articulos devueltos de una factura cuyo codigo concuerde en su 
	* totalidad con el codigo recibido.
	*
	* @param string $nro_factura un string que contiene el codigo identificador	
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getRenglonesDevolucionFactura($nro_factura)
	{
		if(!ctype_digit($nro_factura)) throw new Exception("");
		
		$q = "SELECT d.codigo_producto, d.codigo_devolucion,d.nro_factura, prod.descripcion_producto, d.cantidad_devuelta,
				ROUND(rf.costo_producto * (rf.porcen_venta_producto/100)+1,2)as 'precio_unitario', rf.porcen_desc_producto,
				ROUND(ROUND(ROUND(rf.costo_producto*(rf.porcen_venta_producto/100+1),2)*rf.cantidad_renglonfactura,2)*(1-rf.porcen_desc_producto/100),2) as 'precio_final'
			FROM renglon_devolucion as d, mercaderia as prod, renglon_factura as rf
			WHERE d.codigo_producto=prod.codigo_producto
			AND	d.nro_factura = rf.nro_factura
			AND d.codigo_producto = rf.codigo_producto
			AND d.nro_factura=$nro_factura";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que carga los articulos devueltos de una devolucion
	*
	* Esta función recibe un codigo identificador de una devolucion y los datos necesarios
	* para realizar una carga en la tabla renglon_devolucion de la base de datos.
	* 
	* @param object $datos un objeto que contiene los datos para realizar la carga.
	* @param string $cod_dev un string que contiene un codigo identificador para realizar la carga.
	* @return array retorna un array vacio si se logra la carga.
	*/
	public function crearNuevo($datos,$cod_dev)
	{
		if(!isset($cod_dev)) throw new Exception("error1");
		if(!ctype_digit($cod_dev)) throw new Exception("error12");
		if($this->validarTodo($datos))
		{	
		$q = "INSERT INTO renglon_devolucion (codigo_devolucion,nro_factura, codigo_producto, cantidad_devuelta)
		          VALUES ($cod_dev,".$datos->NRO_fact.",".$datos->cod_prod.",".$datos->cant.");";
		$this->db->query($q);
		}
		return Array();
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
		if(!isset($datos->cod_prod)) throw new Exception("error1");
		if(!ctype_digit($datos->cod_prod)) throw new Exception("error12");
		
		if(!isset($datos->cant)) throw new Exception("error1");
		if(!ctype_digit($datos->cant)) throw new Exception("error12");
		
		if(!isset($datos->NRO_fact)) throw new Exception("error1");
		if(!ctype_digit($datos->NRO_fact)) throw new Exception("error12");
				
		return true;
	}
	
	/**
	* Función que busca los articulos que han sido devueltos en determinada fecha
	* y retorna sus datos.
	*
	* Esta función recibe 2 fechas y extrae los articulos que han 
	* sido devueltos por los clientes entre ambas fechas.
	*
	* @param string $fecha_inic un string que contiene la fecha inicial para realizar la busqueda
	* @param string $fecha_fin un string que contiene la fecha final para realizar la busqueda
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getProductosDevolucionesInforme($fecha_inic,$fecha_fin)
	{
		if(!isset($fecha_inic)) throw new Exception("error16");
		if(strlen($fecha_inic)!=10) throw new Exception("error17");
		if(!isset($fecha_fin)) throw new Exception("error16");
		if(strlen($fecha_fin)!=10) throw new Exception("error17");
		$q="SELECT rd.codigo_producto,m.descripcion_producto, SUM(rd.cantidad_devuelta) as 'cant', (rd.valor_unitario_devolucion * SUM(rd.cantidad_devuelta)) as 'importe'
			FROM renglon_devolucion as rd, mercaderia as m,devoluciones as d
			WHERE rd.codigo_producto=m.codigo_producto
			AND rd.codigo_devolucion=d.codigo_devolucion
			AND (d.fecha_devolucion BETWEEN '$fecha_inic' AND '$fecha_fin')
			GROUP BY rd.codigo_producto
			ORDER BY cant DESC;";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
}