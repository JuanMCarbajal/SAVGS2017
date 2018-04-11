<?php 

// models/Recibos.php


/**
* Clase para el manejo de los recibos para S.A.V.G.S.
*
* Esta clase maneja tanto la entrada como la salida de datos de la tabla recibos.
*
* @package S.A.V.G.S.
* @author Juan <juanmcarbajal95@gmail.com>
* @version 1.7
*/
class Recibos extends Model
{
	/**
	* Función que retorna datos de todos los recibos pagados.
	*
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getTodos()
	{
		$q = "SELECT * FROM recibos";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que crea y carga un recibo a la base de datos
	*
	* Esta función recibe los datos necesarios para realizar una carga en la 
	* tabla recibos de la base de datos.
	* 
	* @param array $datos un array que contiene los datos para realizar la carga.
	* @return array retorna un array vacio si se logra la carga.
	*/
	/*public function crearNuevo($datos)
	{
		if($this->validarTodo($datos))
		{	
		$q = "INSERT INTO recibos(fecha_recibo,importe_recibo,
								codigo_cliente)
				VALUES (NOW(),{$datos['importe_recibo']},
						{$datos['cod_cliente']})";
		
		$this->db->query($q);
		}
		return Array();
	}*/
	
	public function crearNuevo($importe, $cod)
	{		
		if(!isset($importe)) throw new Exception("error3");
		if(!is_numeric($importe)) throw new Exception("error4");
		if(strlen($importe)<1) throw new Exception("error5");
		if(strlen($importe)>20)throw new Exception("error6");
			
		$datos = $this -> getFacturasImpagasCliente($cod);
				
		if(count($datos))
		{			
			//si hay facturas impagas
			$q = "INSERT INTO recibos(fecha_recibo,importe_recibo,
									codigo_cliente)
					VALUES (NOW(),$importe,$cod)";
					
			$this->db->query($q);
					
			$nro_recibo=$this->getUltimoRecibo($cod);
			
			$saldo = $this->crearPagosFacturas($importe,$nro_recibo,$datos,$cod);		
			
			if($saldo != 0)
			{
				$importe = $importe - $saldo;
				
				$q = "UPDATE recibos SET importe_recibo = $importe
						WHERE nro_recibo = $nro_recibo";			
						
				$this->db->query($q);
			}
		}
		else
		{
			//si no hay facturas impagas
			$saldo = $importe;
		}
		
		if($saldo != 0)
		{
			$q = "UPDATE clientes SET saldo_a_favor = saldo_a_favor+$saldo
					WHERE codigo_cliente = $cod";
			
			$this->db->query($q);
		}
		
		
	}
	
	public function crearPagosFacturas($importe,$nro_recibo, $datos, $cod_clie)
	{			
		foreach($datos as $dat)
		{
			if($importe == 0)
			{
				break;
			}
			
			$imp = $dat['deuda'];
			if($importe < $imp)
			{
				$imp = (float)$importe ;
			}
			$q = "INSERT INTO recibos_facturas (nro_factura, nro_recibo,
					importe_pagado)
					VALUES (".$dat['nro_factura'].",$nro_recibo,
					$imp);";
			
			$this->db->query($q);
			$importe = (float)$importe - (float)$imp ;
		}
		
		return $importe;
	}
	
	/**
	* Función que busca el ultimo recibo pagado de un cliente y retorna su codigo identificador.
	*
	* Esta función recibe un codigo identificador de un cliente y los compara con los codigos
	* en la tabla recibos de la base de datos y devuelve los datos del
	* recibo cuyo codigo concuerde en su totalidad con el codigo recibido.
	*
	* @param string $cliente un string que contiene el codigo identificador	de un cliente.
	* @return string retorna un string que contiene el codigo identificador del recibo.
	*/
	public function getUltimoRecibo($cliente)
	{
		if(!isset($cliente)) throw new Exception("error7");
		if(!ctype_digit($cliente)) throw new Exception("error8");
		$q = "SELECT nro_recibo FROM recibos 
				WHERE codigo_cliente=$cliente
				ORDER BY nro_recibo DESC
				LIMIT 1";
		$this->db->query($q);
		$aux=$this->db->fetch();
		$aux=$aux['nro_recibo'];
		return $aux;
	}
	
	/**
	* Función que busca un recibo y retorna sus datos.
	*
	* Esta función recibe un codigo identificador y los compara con los codigos
	* en la tabla recibos de la base de datos y devuelve los datos del
	* recibo cuyo codigo concuerde en su totalidad con el codigo recibido.
	*
	* @param string $nro_recibo un string que contiene el codigo identificador	
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getReciboCodigo($nro_recibo)
	{
		if(!isset($nro_recibo)) throw new Exception("error7");
		if(!ctype_digit($nro_recibo)) throw new Exception("error8");
		$q = "SELECT * FROM recibos WHERE nro_recibo=$nro_recibo";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
	/**
	* Función que busca un recibo y retorna sus datos.
	*
	* Esta función recibe un codigo identificador y los compara con los codigos
	* en la tabla recibos de la base de datos y devuelve los datos del
	* recibo cuyo codigo concuerde en su totalidad con el codigo recibido.
	* 
	* Esta funcion retorna arrays con claves que describen los datos devueltos.
	*
	* @param string $nro_recibo un string que contiene el codigo identificador	
	* @return array retorna un array con los datos de la consulta y las claves detalladas sobre los datos
	* o vacio si no hay resultados.
	*/
	public function getReciboCodigoVenta($nro_recibo)
	{
		if(!isset($nro_recibo)) throw new Exception("error7");
		if(!ctype_digit($nro_recibo)) throw new Exception("error8");
		$q = "SELECT
					nro_recibo as 'Numero de Recibo', 
					fecha_recibo 'Fecha',
					importe_recibo 'Importe Total'
				FROM recibos WHERE nro_recibo=$nro_recibo";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
	/**
	* Función que recibe 2 fechas y retorna la sumatoria del importe pagado total de todos los recibos entre ambas fechas.
	*
	* @param string $fecha_inic un string que contiene la fecha inicial para realizar la busqueda
	* @param string $fecha_fin un string que contiene la fecha final para realizar la busqueda
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/
	public function getTotalVentas($fecha_inic,$fecha_fin)
	{
		if(!isset($fecha_inic)) throw new Exception("error16");
		if(strlen($fecha_inic)!=10) throw new Exception("error17");
		if(!isset($fecha_fin)) throw new Exception("error16");
		if(strlen($fecha_fin)!=10) throw new Exception("error17");
		$q="SELECT SUM(importe_recibo) as 'total' FROM recibos
			WHERE (fecha_recibo BETWEEN '$fecha_inic' AND '$fecha_fin');";
		$this->db->query($q);
		return $this->db->fetch();
	}
		
	public function getDeudaCliente($cod)
	{
		if(!isset($cod)) throw new Exception("error7");
		if(!ctype_digit($cod)) throw new Exception("error8");
		$q = "	SELECT SUM(f.importe_total_factura)-IFNULL(SUM(r.importe_total_recibos),0) as 'deuda'
				FROM facturas as f
				LEFT JOIN
					(SELECT rf.nro_factura, SUM(rf.importe_pagado)+0 as 'importe_total_recibos'
					FROM recibos_facturas as rf, recibos as re
					WHERE re.codigo_cliente= $cod
					 AND rf.nro_recibo = re.nro_recibo
					GROUP BY rf.nro_factura) as r 
				ON f.nro_factura = r.nro_factura 
				WHERE  f.codigo_cliente= $cod";
		$this->db->query($q);
		$fetch = $this->db->fetch();
		return $fetch['deuda'];
	}
	
	public function getFacturasImpagasCliente($cod)
	{
		if(!isset($cod)) throw new Exception("error7");
		if(!ctype_digit($cod)) throw new Exception("error8");
		$q = "	SELECT f.nro_factura, (f.importe_total_factura-IFNULL(r.importe_total_recibos,0)) AS 'deuda'
				FROM facturas as f
				left join
					(SELECT rf.nro_factura, SUM(rf.importe_pagado) as 'importe_total_recibos'
					FROM recibos_facturas as rf, recibos as re
					WHERE re.codigo_cliente= $cod
					 AND rf.nro_recibo = re.nro_recibo
					GROUP BY rf.nro_factura) as r 
				on f.nro_factura = r.nro_factura 
				where( r.importe_total_recibos is null 
                     OR f.importe_total_factura - r.importe_total_recibos > 0)";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que busca el todos los recibos de pago de un cliente y los retorna.
	*
	* Esta función recibe un codigo identificador de un cliente y busca todos los 
	* recibos de este cliente y los retorna.
	*
	* @param string $cliente un string que contiene el codigo identificador	de un cliente.
	* @return string retorna un array que contiene la informacion de los recibos.
	*/
	public function getRecibosCliente($cliente)
	{
		if(!isset($cliente)) throw new Exception("error7");
		if(!ctype_digit($cliente)) throw new Exception("error8");
		$q = "SELECT * FROM recibos 
				WHERE codigo_cliente=$cliente
				ORDER BY nro_recibo DESC";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
}

?>