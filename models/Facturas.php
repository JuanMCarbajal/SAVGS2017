<?php 
	// models/Facturas.php
	
/**
* Clase para el manejo de las facturas para S.A.V.G.S.
*
* Esta clase maneja tanto la entrada como la salida de datos de la tabla facturas.
*
* @package S.A.V.G.S.
* @author Juan <juanmcarbajal95@gmail.com>
* @version 1.7
*/	
class Facturas extends Model
{
	/**
	* Función que retorna datos de todas las facturas realizadas.
	*
	*
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getTodos()
	{
		$q = "SELECT * FROM facturas";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que busca la ultima factura ingresada de un vendedor y retorna su codigo identificador.
	*
	* Esta función recibe un codigo identificador y los compara con los codigos
	* en la tabla facturas de la base de datos y devuelve los datos de 
	* la factura cuyo codigo concuerde en su totalidad con el codigo recibido.
	*
	* @param string $datos un string que contiene el codigo identificador	
	* @return string retorna un string que contiene el codigo identificador de la factura.
	*/
	public function getUltFactIng($datos)
	{
		if(!isset($datos)) throw new Exception("error1");
		if(!ctype_digit($datos)) throw new Exception("error12");
		$q="SELECT nro_factura FROM facturas WHERE codigo_vendedor=$datos
			ORDER BY nro_factura DESC
			LIMIT 1";
		$this->db->query($q);
		$aux=$this->db->fetch();
		$aux=$aux['nro_factura'];
		return $aux;
	}
	
	/**
	* Función que crea y carga una factura a la base de datos
	*
	* Esta función recibe los datos necesarios para realizar una carga en la 
	* tabla facturas de la base de datos.
	* 
	* @param array $datos un array que contiene los datos para realizar la carga.
	* @return array retorna un array vacio si se logra la carga.
	*/
	public function crearNuevo($datos)
	{
		if($this->validarTodo($datos))
		{	
		$q = "INSERT INTO facturas(fecha_factura,IVA,importe_total_factura,
								codigo_cliente,codigo_medio_pago,codigo_vendedor,codigo_empresa)
				VALUES (NOW(),{$datos['IVA']},{$datos['importe_total']},
						{$datos['cod_cliente']},{$datos['cod_med_pago']},
						{$datos['cod_vendedor']},1)";
		
		$this->db->query($q);
		return $datos['importe_total'];
		}
		return 0;
	}
	
	/**
	* Función que busca una factura y retorna sus datos.
	*
	* Esta función recibe un codigo identificador y los compara con los codigos
	* en la tabla facturas de la base de datos y devuelve los datos de 
	* la factura cuyo codigo concuerde en su totalidad con el codigo recibido.
	*
	* @param string $nro_factura un string que contiene el codigo identificador	
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getFacturaCodigo($nro_factura)
	{
		if(!isset($nro_factura)) throw new Exception("error7");
		if(!ctype_digit($nro_factura)) throw new Exception("error8");
		$q = "SELECT * FROM facturas WHERE nro_factura=$nro_factura";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
	/**
	* Función que busca una factura y retorna sus datos.
	*
	* Esta función recibe un codigo identificador y los compara con los codigos
	* en la tabla facturas de la base de datos y devuelve los datos de 
	* la factura cuyo codigo concuerde en su totalidad con el codigo recibido.
	* 
	* Esta funcion retorna arrays con claves que describen los datos devueltos.
	*
	* @param string $nro_factura un string que contiene el codigo identificador	
	* @return array retorna un array con los datos de la consulta y las claves detalladas sobre los datos
	* o vacio si no hay resultados.
	*/
	public function getFacturaCodigoVenta($nro_factura)
	{
		if(!isset($nro_factura)) throw new Exception("error7");
		if(!ctype_digit($nro_factura)) throw new Exception("error8");
		$q = "SELECT
					nro_factura as 'Numero de Factura', 
					fecha_factura 'Fecha',
					IVA 'IVA',
					importe_total_factura 'Importe Total',
					(importe_total_factura * (1+(IVA/100))) as 'Importe Total con IVA'
				FROM facturas WHERE nro_factura=$nro_factura";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
	/**
	* Función que valida los datos previo a una carga.
	*
	* @param array $datos un array que contiene los datos para realizar la carga.	
	* @return bool retorna true si los datos son validos para realizar una carga.
	*/
	public function validarTodo($datos)
	{
		if(!isset($datos['importe_total'])) throw new Exception("error3");
		if(!is_numeric($datos['importe_total'])) throw new Exception("error4");
		if(strlen($datos['importe_total'])<1) throw new Exception("error5");
		if(strlen($datos['importe_total'])>10)throw new Exception("error6");		
		
		if(!isset($datos['cod_cliente'])) throw new Exception("error7");
		if(!ctype_digit($datos['cod_cliente'])) throw new Exception("error8");
		if(strlen($datos['cod_cliente'])<1) throw new Exception("error9");
		if(strlen($datos['cod_cliente'])>10)throw new Exception("error10");	
		
		if(!isset($datos['cod_vendedor'])) throw new Exception("error7");
		if(!ctype_digit($datos['cod_vendedor'])) throw new Exception("error8");
		if(strlen($datos['cod_vendedor'])<1) throw new Exception("error9");
		if(strlen($datos['cod_vendedor'])>10)throw new Exception("error10");
		
		if(!isset($datos['IVA'])) throw new Exception("error3");
		if(!is_numeric($datos['IVA'])) throw new Exception("error4");
		if(strlen($datos['IVA'])<1) throw new Exception("error5");
		if(strlen($datos['IVA'])>10)throw new Exception("error6");
		
		return true;
	}
	
	/**
	* Función que busca una factura y retorna su importe total.
	*
	* Esta función recibe un codigo identificador y los compara con los codigos
	* en la tabla facturas de la base de datos y devuelve el importe total de 
	* la factura cuyo codigo concuerde en su totalidad con el codigo recibido.
	*
	* @param string $nro_factura un string que contiene el codigo identificador	
	* @return string retorna un string que contiene el importe total de la factura.
	*/
	public function getImportes($nro_factura)
	{
		if(!isset($nro_factura)) throw new Exception("error7");
		if(!ctype_digit($nro_factura)) throw new Exception("error8");
		$q = "SELECT f.importe_total_factura, mp.descripcion_medio_pago
				FROM facturas as f, medios_pago as mp
				WHERE f.codigo_medio_pago=mp.codigo_medio_pago
				AND nro_factura=$nro_factura";
		$this->db->query($q);
		$aux=$this->db->fetch();
		//$aux=$aux['importe_total_factura'];
		return $aux;
	}
	
	/**
	* Función que recibe 2 fechas y retorna la sumatoria del importe total de todas las facturas entre ambas fechas.
	*
	* @param string $fecha_inic un string que contiene la fecha inicial para realizar la busqueda
	* @param string $fecha_fin un string que contiene la fecha final para realizar la busqueda
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getFacturasInforme($fecha_inic,$fecha_fin)
	{
		if(!isset($fecha_inic)) throw new Exception("error16");
		if(strlen($fecha_inic)!=10) throw new Exception("error17");
		if(!isset($fecha_fin)) throw new Exception("error16");
		if(strlen($fecha_fin)!=10) throw new Exception("error17");
		$q="SELECT SUM(importe_total_factura) as total
			FROM facturas
			WHERE (fecha_factura BETWEEN '$fecha_inic' AND '$fecha_fin');";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
	public function getFacturasCliente($cod)
	{
		$q="SELECT f.nro_factura, f.importe_total_factura, i.importe_pagado, mp.descripcion_medio_pago
			FROM facturas as f
			left join (	SELECT rf.nro_factura, SUM(rf.importe_pagado) as 'importe_pagado'
					FROM recibos_facturas as rf, recibos as re
					WHERE re.codigo_cliente= $cod
					 AND rf.nro_recibo = re.nro_recibo
					GROUP BY rf.nro_factura
			) as i on f.nro_factura = i.nro_factura
			left join medios_pago as mp on f.codigo_medio_pago = mp.codigo_medio_pago
			WHERE  f.codigo_cliente = $cod
			ORDER BY f.fecha_factura desc";
			$this->db->query($q);
		$result = $this->db->fetchAll();
		foreach($result as $factura)
		{
			if($factura["importe_pagado"] == null)
				$factura["importe_pagado"] = 0;
		}
		return $result;
	}
}
	
		
	
	
	