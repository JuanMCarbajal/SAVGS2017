<?php 

/*nro_pago Clave Primaria
importe_pagocliente Not Null
fecha_pago Not Null
codigo_cliente Clave Foranea
Clientes.codigo_cliente
codigo_medio_pago Clave Foranea
Medios_Pago.codigo_medio_pago
*/

// models/PagosClientes.php

class PagosClientes extends Model
{
	public function getTodos()
	{
		$q = "SELECT * FROM recibos";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	public function crearNuevo($datos)
	{
		if($this->validarTodo($datos))
		{	
		$q = "INSERT INTO recibos(fecha_pago,importe_pagocliente,
								codigo_cliente,codigo_medio_pago)
				VALUES (NOW(),{$datos['importe_pagocliente']},
						{$datos['cod_cliente']},{$datos['cod_med_pago']})";
		
		$this->db->query($q);
		}
		return Array();
	}
	
	public function validarTodo($datos)
	{	
		if(!isset($datos['cod_cliente'])) throw new Exception("error7");
		if(!ctype_digit($datos['cod_cliente'])) throw new Exception("error8");
		if(strlen($datos['cod_cliente'])<1) throw new Exception("error9");
		if(strlen($datos['cod_cliente'])>10)throw new Exception("error10");
		
		if(!isset($datos['cod_med_pago'])) throw new Exception("error7");
		if(!ctype_digit($datos['cod_med_pago'])) throw new Exception("error8");
		if(strlen($datos['cod_med_pago'])<1) throw new Exception("error9");
		if(strlen($datos['cod_med_pago'])>10)throw new Exception("error10");
		
		if(!isset($datos['importe_pagocliente'])) throw new Exception("error3");
		if(!is_numeric($datos['importe_pagocliente'])) throw new Exception("error4");
		if(strlen($datos['importe_pagocliente'])<1) throw new Exception("error5");
		if(strlen($datos['importe_pagocliente'])>20)throw new Exception("error6");
		
		return true;
	}
	
	public function getUltimoPago()
	{
		$q = "SELECT nro_pago FROM recibos 
				ORDER BY nro_recibo DESC
				LIMIT 1";
		$this->db->query($q);
		$aux=$this->db->fetch();
		$aux=$aux['nro_pago'];
		return $aux;
	}
	
	public function getDeudaCliente($cod)
	{
		if(!isset($cod)) throw new Exception("error7");
		if(!ctype_digit($cod)) throw new Exception("error8");
		$q = "	SELECT SUM(f.importe_total_factura - r.importe_total_recibos)
				FROM facturas as f,
					(SELECT rf.nro_factura, SUM(rf.importe_pagado) as 'importe_total_recibos'
					FROM recibos_facturas as rf, recibos as re
					WHERE re.codigo_cliente= $cod
					 AND rf.nro_recibo = re.nro_recibo
					GROUP BY rf.nro_factura) as r 
				WHERE f.nro_factura = r.nro_factura";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
}