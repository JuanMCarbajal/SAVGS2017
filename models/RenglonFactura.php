<?php 

// models/RenglonFactura.php

/**
* Clase para manejo de los renglones de facturas para S.A.V.G.S.
*
* Esta clase maneja tanto la entrada como la salida de datos de la tabla renglon_factura.
*
* @package S.A.V.G.S.
* @author Juan <juanmcarbajal95@gmail.com>
* @version 1.7
*/
class RenglonFactura extends Model
{
	
	/**
	* Función que retorna datos de todos los renglones de las facturas realizadas.
	*
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getTodos()
	{	
		$q = "SELECT * FROM renglon_factura";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que busca los articulos vendidos en una factura y retorna sus datos.
	*
	* Esta función recibe un codigo identificador y los compara con los codigos
	* en la tabla renglon_factura de la base de datos y devuelve los datos de 
	* los articulos vendidos de una factura cuyo codigo concuerde en su 
	* totalidad con el codigo recibido.
	*
	* @param string $nro_factura un string que contiene el codigo identificador	
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getRenglonesFactura($nro_factura)
	{
		if(!ctype_digit($nro_factura)) throw new Exception("");
	
		$q = "SELECT rf.codigo_producto, rf.nro_factura as 'nro_factura', prod.descripcion_producto, rf.cantidad_renglonfactura,
					(rf.costo_producto * (rf.porcen_venta_producto/100)+1 )as 'precio_unitario',rf.porcen_desc_producto as 'porcentaje',
					ROUND(ROUND(ROUND(rf.costo_producto*(rf.porcen_venta_producto/100+1),2)*rf.cantidad_renglonfactura,2)*(1-rf.porcen_desc_producto/100),2) as 'precio_total',
					ROUND((rf.costo_producto * (rf.porcen_venta_producto/100)+1 )*(1-rf.porcen_desc_producto/100),2) as precio_final
					,rf.nro_renglon
				FROM renglon_factura as rf, mercaderia as prod
				WHERE rf.codigo_producto=prod.codigo_producto
				AND rf.nro_factura=$nro_factura
				ORDER BY rf.nro_renglon ASC;";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que busca los articulos vendidos en una factura y retorna sus datos.
	*
	* Esta función recibe un codigo identificador y los compara con los codigos
	* en la tabla renglon_factura de la base de datos y devuelve los datos de 
	* los articulos vendidos de una factura cuyo codigo concuerde en su 
	* totalidad con el codigo recibido. Esta funcion extrae datos usados
	* para un informe de ventas.
	*
	* @param string $nro_factura un string que contiene el codigo identificador	
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getRenglonesFacturaVentas($nro_factura)
	{
		if(!ctype_digit($nro_factura)) throw new Exception("");
	
		$q = "SELECT rf.nro_renglon,rf.codigo_producto, prod.descripcion_producto, rf.cantidad_renglonfactura,
				rf.costo_producto*(rf.porcen_venta_producto/100+1)as 'precio_unitario',rf.porcen_desc_producto as 'porcentaje',
				ROUND(ROUND(ROUND(rf.costo_producto*(rf.porcen_venta_producto/100+1),2)*rf.cantidad_renglonfactura,2)*(1-rf.porcen_desc_producto/100),2) as 'precio_final'
			FROM renglon_factura as rf, mercaderia as prod
			WHERE rf.codigo_producto=prod.codigo_producto
			AND rf.nro_factura=$nro_factura
			ORDER BY rf.nro_renglon ASC";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que busca un articulo vendido en una factura y retorna sus datos.
	*
	* Esta función recibe dos codigos identificadores y los compara con los codigos
	* en la tabla renglon_factura de la base de datos y devuelve los datos del articulo
	* vendido de una factura cuyos codigos concuerden en su 
	* totalidad con los codigos recibidos. Esta funcion tambien acepta un tercer parametro opcional
	* para que busque si la cantidad vendida del articulo en la factura es mayor al parametro.
	*
	* @param string $nro_factura un string que contiene el codigo identificador	
	* @param string $codigo_producto un string que contiene el codigo identificador
	* @param int $cant un entero que contiene por defecto el valor 0 y filtra los datos a devolver si
	* la cantidad vendida fue mayor al parametro.
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getRenglonFactura($nro_factura,$codigo_producto,$cant=0)
	{
		if(!ctype_digit($nro_factura)) throw new Exception("");
		if(!ctype_digit($codigo_producto)) throw new Exception("");
		if(!ctype_digit($cant)) throw new Exception("");
	
		$q = "SELECT rf.codigo_producto, rf.nro_factura as 'nro_factura', prod.descripcion_producto, rf.cantidad_renglonfactura,
					ROUND(rf.costo_producto * (rf.porcen_venta_producto/100)+1,2)as 'precio_unitario',
					ROUND(ROUND(ROUND(rf.costo_producto*(rf.porcen_venta_producto/100+1),2)*rf.cantidad_renglonfactura,2)*(1-rf.porcen_desc_producto/100),2) as 'precio_total',
					ROUND((rf.costo_producto * (rf.porcen_venta_producto/100)+1 )*(1-rf.porcen_desc_producto/100),2) as precio_final
					,rf.nro_renglon
				FROM renglon_factura as rf, mercaderia as prod
				WHERE rf.codigo_producto=prod.codigo_producto
				AND rf.nro_factura=$nro_factura
				AND rf.codigo_producto=$codigo_producto
				AND rf.cantidad_renglonfactura >= $cant
				ORDER BY rf.nro_renglon ASC;";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
	/**
	* Función que carga los articulos vendidos de una factura
	*
	* Esta función recibe un codigo identificador de una factura, un numero de renglon y los datos necesarios
	* para realizar una carga en la tabla renglon_factura de la base de datos.
	* 
	* @param object $datos un objeto que contiene los datos para realizar la carga.
	* @param string $nro_factura un string que contiene un codigo identificador para realizar la carga.
	* @param string $nro_renglon un string que contiene el numero del renglon de la factura.
	* @return array retorna un array vacio si se logra la carga.
	*/
	public function crearNuevo($datos,$nro_factura,$nro_renglon)
	{
		if(!isset($nro_factura)) throw new Exception("error1");
		if(!ctype_digit($nro_factura)) throw new Exception("error12");
		if(!isset($nro_renglon)) throw new Exception("error1");
		if($this->validarTodo($datos))
		{	
		$q = "INSERT INTO renglon_factura (nro_factura, codigo_producto,
						cantidad_renglonfactura, costo_producto, porcen_venta_producto,
						porcen_desc_producto, nro_renglon)
					SELECT $nro_factura,".$datos->ID_prod.",".$datos->prodCant.",
							m.costo_producto,m.porcen_venta_producto,
							".$datos->descProd.",$nro_renglon
					FROM mercaderia as m
					WHERE m.codigo_producto = ".$datos->ID_prod;
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
		if(!isset($datos->ID_prod)) throw new Exception("error1");
		if(!ctype_digit($datos->ID_prod)) throw new Exception("error12");
		
		if(!isset($datos->prodCant)) throw new Exception("error1");
		if(!ctype_digit($datos->prodCant)) throw new Exception("error12");
		
		if(!isset($datos->descProd)) throw new Exception("error1");
		if(!is_numeric($datos->descProd)) throw new Exception("error12");
		
		return true;
	}

}