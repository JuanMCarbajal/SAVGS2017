<?php 

// models/Clientes.php

/**
* Clase para manejo de los clientes para para S.A.V.G.S.
*
* Esta clase maneja tanto la entrada como la salida de datos de la tabla clientes.
*
* @package S.A.V.G.S.
* @author Matias <matiascabral95@gmail.com>
* @version 1.7
*/

class Clientes extends Model 
{
	
	/**
	* Función que devuelve todos los clientes.
	*	
	* @return array retorna un array con los datos de los clientes encontrados.
	*/
	
	public function getTodos()
	{
		$q = "SELECT c.*, td.descripcion_tipo_documento
					FROM clientes as c, tipos_documento as td
					WHERE c.codigo_tipo_documento=td.codigo_tipo_documento";
		
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	
	public function buscar($busqueda)
	{
		$q = "SELECT c.*, td.descripcion_tipo_documento
					FROM clientes as c, tipos_documento as td
					WHERE c.codigo_tipo_documento=td.codigo_tipo_documento";
		
		
		if(ctype_digit($busqueda))
			$q= $q." AND nro_documento_cliente LIKE '%$busqueda%' 
						OR cuil_cliente LIKE '%$busqueda%' ";
		else
		{
			if(strlen($busqueda)>0)
			{
				if(strlen($busqueda)<1) throw new Exception("error2");
				if(strlen($busqueda)>50)
					$busqueda=substr($busqueda,0,50);
				$busqueda=$this->db->escapeString($busqueda);
				$busqueda=str_replace("%","\%",$busqueda);
				$busqueda=str_replace("_","\_",$busqueda);
				
				$q= $q." AND nombre_cliente LIKE '%$busqueda%'";
			}
		}	
			
		$this->db->query($q);		
		return $this->db->fetchAll();
	}
	
	
	/**
	* Función que devuelve todos los datos de un cliente en particular.
	*	
	* @param integer $codigo un entero con el codigo indentificador de un cliente.
	* @return array retorna un array con los datos del cliente encontrado.
	*/
	
	public function getClienteCodigo($codigo)
	{
		if(!isset($codigo)) throw new Exception("error1");
		if(!ctype_digit($codigo)) throw new Exception("error2");
		$q = "SELECT * FROM clientes WHERE codigo_cliente=$codigo";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
	/**
	* Función que devuelve todos los datos de un cliente en particular a partir de 
	* su numero y tipo de documento.
	*	
	* @param integer $nro_doc un entero con el numero de documento de un cliente.
	* @param integer $tip_doc un entero que indica el tipo de documento de un cliente.
	* @return array retorna un array con los datos del cliente encontrado.
	*/
	
	public function getClienteDocumento($nro_doc,$tip_doc)
	{
		if(!isset($nro_doc)) throw new Exception("error1");
		if(!ctype_digit($nro_doc)) throw new Exception("error2");
		if(!isset($tip_doc)) throw new Exception("error1");
		if(!ctype_digit($tip_doc)) throw new Exception("error2");
		$q = "SELECT * FROM clientes
				WHERE codigo_tipo_documento=$tip_doc
				AND nro_documento_cliente=$nro_doc";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
	/**
	* Función que devuelve todos los datos de un cliente en particular para una venta.
	*	
	* @param integer $codigo un entero con el codigo indentificador de un cliente.
	* @return array retorna un array con los datos del cliente encontrado.
	*/
	
	public function getClienteCodigoVenta($codigo)
	{
		if(!isset($codigo)) throw new Exception("error1");
		if(!ctype_digit($codigo)) throw new Exception("error2");
		$q = "SELECT
				nombre_cliente as 'Nombre',
				nro_documento_cliente as 'Nro Documento',
				telefono_cliente as 'Telefono',
				direccion_cliente as 'Direccion',
				localidad_cliente as 'Localidad',
				codigo_postal_cliente as 'Codigo Postal',
				cuil_cliente as 'CUIL'
			FROM clientes WHERE codigo_cliente=$codigo";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
	/**
	* Función que crea un nuevo cliente a partir de los datos recibidos.
	*	
	* @param array $datos array con todos los datos necesarios de un cliente.
	* @param array $tipos_doc array con todos los datos de los tipos de documentos.
	* @return array retorna un array con los datos del cliente creado.
	*/
	
	public function crearNuevo($datos, $tipos_doc )
	{	
		
		if(!isset($datos['nombre'])) throw new Exception("error1");
		if(strlen($datos['nombre'])<2) throw new Exception("error2");
		if(strlen($datos['nombre'])>50)
			substr($datos['nombre'],0,50);
		$datos['nombre']=$this->db->escapeString($datos['nombre']);
		$nombre=$datos['nombre'];
		
		if(isset($datos['telefono']) && strlen($datos['telefono']))
		{
			if(!ctype_digit($datos['telefono'])) throw new Exception("error4");
			if(strlen($datos['telefono'])<1) throw new Exception("error4.5");
			if(strlen($datos['telefono'])>20)
				substr($datos['telefono'],0,20);
			$telefono=$datos['telefono'];
		}
		
		if(isset($datos['direccion']) && strlen($datos['direccion']))
		{
			if(strlen($datos['direccion'])<1) throw new Exception("error6");
			if(strlen($datos['direccion'])>50)
				substr($datos['direccion'],0,50);
			$datos['direccion']=$this->db->escapeString($datos["direccion"]);
		}
		$direccion=$datos['direccion'];
		
		if(isset($datos['localidad']) && strlen($datos['localidad']))
		{
			if(strlen($datos['localidad'])<1) throw new Exception("error9");
			if(strlen($datos['localidad'])>50)
				substr($datos['localidad'],0,50);
			$datos['localidad']=$this->db->escapeString($datos['localidad']);
		}
		$localidad=$datos['localidad'];
	
		if(isset($datos['codigo-postal']) && strlen($datos['codigo-postal']))
		{
			if(!ctype_digit($datos['codigo-postal'])) throw new Exception("error11.5");
			if(strlen($datos['codigo-postal'])<1) throw new Exception("error12");
			if(strlen($datos['codigo-postal'])>10)
				substr($datos['codigo-postal'],0,10);
		}
		$codigoPostal=$datos['codigo-postal'];
		
		if(!isset($datos['tipo-documento'])) throw new Exception("error13");
		if(!ctype_digit($datos['tipo-documento'])) throw new Exception("error13.5");
		if(!$tipos_doc->existe($datos['tipo-documento'])) throw new Exception("error13.55");
		$tipodocumento=$datos['tipo-documento'];

		
		if(!isset($datos['nro-documento'])) throw new Exception("error14");
		if(!ctype_digit($datos['nro-documento'])) throw new Exception("error15");
		if(strlen($datos['nro-documento'])<1) throw new Exception("error15.5");
		if(strlen($datos['nro-documento'])>20)
			substr($datos['nro-documento'],0,20);
		$nroDocumento=$datos['nro-documento'];
		
		if(isset($datos['cuil']) && strlen($datos['cuil']))
		{
			if(strlen($datos['cuil'])<1) throw new Exception("error17");
			if(strlen($datos['cuil'])>15)
				substr($datos['cuil'],0,15);
			$datos['cuil']=$this->db->escapeString($datos['cuil']);
		}
		$cuil=$datos['cuil'];
		
		if(!isset($datos['sexo'])) throw new Exception("error16");
		if(strlen($datos['sexo'])<1) throw new Exception("error17");
		if(strlen($datos['sexo'])>2)
			substr($datos['sexo'],0,2);
		$datos['sexo']=$this->db->escapeString($datos['sexo']);
		$sexo=$datos['sexo'];

		
		
		$q = "INSERT INTO clientes (nombre_cliente, telefono_cliente, direccion_cliente, localidad_cliente, codigo_postal_cliente, nro_documento_cliente, codigo_tipo_documento, cuil_cliente, sexo_cliente)
		          VALUES ('$nombre','$telefono','$direccion','$localidad','$codigoPostal','$nroDocumento',$tipodocumento,'$cuil','$sexo')";
		
		$this->db->query($q);
	}
	
	/**
	* Función que indica si existe o no un cliente en particular.
	*	
	* @param integer $nro un entero con el numero de documento de un cliente.
	* @param integer $tipo un entero que indica el tipo de documento de un cliente.
	* @param integer $cuil un entero con el cuil de un cliente.
	* @param integer $codigo un entero con el codigo indentificador de un cliente
	* en la base de datos, en caso de ser 0 este debe ser omitido en la consulta.
	* @return bool retorna un boolean que indica si existe o no el cliente.
	*/
	
		public function existe($nro,$tipo,$codigo)
	{
		if(!ctype_digit($nro)) throw new Exception("error1");
		if(strlen($nro)<2) throw new Exception("error2");
		if(strlen($nro)>10)
			$nro=substr($nro,0,10);
				
		if(!ctype_digit($tipo)) throw new Exception("error5");
		if(strlen($tipo)!=1) throw new Exception("error6");
		
		if(!ctype_digit($codigo)) throw new Exception("error7");
				
		$q = "SELECT * FROM clientes WHERE ( nro_documento_cliente = '$nro' AND  codigo_tipo_documento = $tipo )";
		
		if($codigo!=0)
			$q = $q." AND codigo_cliente <> $codigo";
		
		$this->db->query($q);
		if($this->db->numRows()!=0)
			return true;
		return false;
	}
	
	/**
	* Función que devuelve el codigo identificador del ultimo cliente ingresado.
	*	
	* @return integer retorna un entero que es el codigo identificador del cliente encontrado.
	*/
	
	public function getUltimoCliente()
	{
		$q = "SELECT codigo_cliente FROM clientes
				ORDER BY codigo_cliente DESC
				LIMIT 1;";
		$this->db->query($q);
		$aux = $this->db->fetch();
		$aux=$aux['codigo_cliente'];
		return $aux;
	}
	
	public function getClienteVenta()
	{
		$q = "SELECT pagado.*, SUM(f.importe_total_factura) as 'total', (pagado.saldo_a_favor + SUM(f.importe_total_factura)-pagado.pagado) as 'a_pagar' FROM
				(SELECT c.codigo_cliente, c.nombre_cliente, c.nro_documento_cliente,c.saldo_a_favor, SUM(r.importe_recibo) as 'pagado' FROM clientes c, recibos r
				WHERE c.codigo_cliente=r.codigo_cliente
				GROUP BY c.codigo_cliente) as pagado, facturas f
				WHERE pagado.codigo_cliente=f.codigo_cliente
				GROUP BY pagado.codigo_cliente
				ORDER BY pagado.codigo_cliente ASC;";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	public function getCuenta($cod)
	{
		$q = "SELECT saldo_a_favor FROM clientes
				WHERE codigo_cliente = $cod";
		$this->db->query($q);
		$saldo = $this->db->fetch();
		return $saldo['saldo_a_favor'];
	}
	
	public function setCuenta($cod, $saldo)
	{
		if($saldo > 0)
		{
			$q = "UPDATE clientes SET saldo_a_favor = saldo_a_favor+$saldo
				WHERE codigo_cliente = $cod";			
		}
		else
		{
			$saldo = $saldo * (-1);
			$q = "UPDATE clientes SET saldo_a_favor = saldo_a_favor-$saldo
				WHERE codigo_cliente = $cod";	
		}
		$this->db->query($q);
	}
	
	public function getDeudaTotal()
	{
		$q="SELECT c.codigo_cliente, c.nombre_cliente, (fimp.total_facturas-fimp.total_recibos) as 'deuda_general'
			, (fsem.total_facturas_s-fsem.total_recibos_s) as 'deuda_semanal'
			FROM
			(SELECT f.codigo_cliente, SUM(f.importe_total_factura) as 'total_facturas', SUM(IFNULL(r.importe_total_recibos,0)) as 'total_recibos'
				FROM facturas as f
				left join
					(SELECT re.codigo_cliente, rf.nro_factura, SUM(rf.importe_pagado) as 'importe_total_recibos'
					FROM recibos_facturas as rf, recibos as re
					WHERE rf.nro_recibo = re.nro_recibo
					GROUP BY re.codigo_cliente, rf.nro_factura) as r 
				on f.nro_factura = r.nro_factura AND f.codigo_cliente = r.codigo_cliente
				where( r.importe_total_recibos is null 
					OR f.importe_total_factura - r.importe_total_recibos > 0)
				group by f.codigo_cliente) as fimp,
			(SELECT f.codigo_cliente, SUM(f.importe_total_factura) as 'total_facturas_s', SUM(IFNULL(r.importe_total_recibos,0)) as 'total_recibos_s'
				FROM facturas as f
				left join
					(SELECT re.codigo_cliente, rf.nro_factura, SUM(rf.importe_pagado) as 'importe_total_recibos'
					FROM recibos_facturas as rf, recibos as re
					WHERE rf.nro_recibo = re.nro_recibo
					GROUP BY re.codigo_cliente, rf.nro_factura) as r 
				on f.nro_factura = r.nro_factura AND f.codigo_cliente = r.codigo_cliente
				where( r.importe_total_recibos is null 
					OR f.importe_total_factura - r.importe_total_recibos > 0)
					AND f.fecha_factura BETWEEN CURRENT_DATE()-7 AND CURRENT_DATE()  
				group by f.codigo_cliente) as fsem,
				clientes as c
			WHERE fimp.codigo_cliente = fsem.codigo_cliente
				AND	c.codigo_cliente = fimp.codigo_cliente";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
}

?>