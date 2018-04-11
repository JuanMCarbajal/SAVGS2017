<?php 

// models/Mercaderia.php

/**
* Clase para manejo de la mercaderia para S.A.V.G.S.
*
* Esta clase maneja tanto la entrada como la salida de datos de la tabla mercaderia.
*
* @package S.A.V.G.S.
* @author Matias <matiascabral95@gmail.com>
* @version 1.7
*/

class Mercaderia extends Model 
{	

	/**
	* Función que busca productos y retorna sus datos.
	*
	* Esta función recibe un string el cual se compara con los nombres
	* de los productos de la tabla mercaderia de la base de datos y 
	* devuelve los datos de los productos cuyos nombres concuerdan 
	* parcialmente o en su totalidad con la string recibido, o en el caso
	* de que la string sea solo un numero se compara con el codigo del producto
	* y devuelve el producto cuyo codigo concuerde en su totalidad con la string
	* recibida, y recibe un parametro indicando si es compra, en el caso de que 
	* lo sea los productos devueltos deben estar a la venta.
	*
	* @param string $busqueda una string que sirve para realizar la busqueda.
	* @param bool $esCompra un boolean que indica si la busqueda es para una compra.
	* @return array retorna un array con los datos de la consulta.
	*/
	
	public function buscar($busqueda,$esCompra=true,$proveedor = 0, $tipo = 0)
	{			
		$q = "SELECT m.* , p.descripcion_proveedor, tp.descripcion_tipo
			FROM mercaderia as m
			LEFT JOIN proveedores as p on m.codigo_proveedor = p.codigo_proveedor
			LEFT JOIN tipos_producto as tp on m.codigo_tipo_producto = tp.codigo_tipo_producto
			WHERE m.baja_producto = false";
		
		
		if(ctype_digit($busqueda))
			$q= $q." AND m.codigo_producto = $busqueda";
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
				
				$q= $q." AND m.descripcion_producto LIKE '%$busqueda%'";
			}
		}	
	
		if($esCompra)
			$q= $q." AND m.en_venta = 'Si'";
		
		if($proveedor != 0)
			$q= $q." AND m.codigo_proveedor = $proveedor";
		
		if($tipo != 0)
			$q= $q." AND m.codigo_tipo_producto = $tipo";
		
		$this->db->query($q);		
		return $this->db->fetchAll();
	}
	
	/**
	* Función que indica si existe o no un producto en particular.
	*	
	* @param string $nombre una string que contiene la descripcion de un producto.
	* @param integer $codigo un entero con el codigo indentificador de un producto
	* en la base de datos, en caso de ser 0 este debe ser omitido en la consulta.
	* @return bool retorna un boolean que indica si existe o no el producto.
	*/	
	
	public function existe($nombre,$codigo)
	{
		if(strlen($nombre)<1) throw new Exception("error2");
		if(strlen($nombre)>50)
			$nombre=substr($nombre,0,50);
		$nombre=$this->db->escapeString($nombre);
		
		if(!ctype_digit($codigo)) throw new Exception("error7");
		
		$q = "SELECT * FROM mercaderia WHERE descripcion_producto = '$nombre' AND  baja_producto = false";
			
		if($codigo!=0)
			$q = $q." AND codigo_producto <> $codigo";
		
		$this->db->query($q);
		if($this->db->numRows()!=0)
			return true;
		return false;
	}
	
	/**
	* Función que elimina un producto en particular.
	*
	* @param integer $codigo un entero con el codigo indentificador de un producto
	* en la base de datos.
	*/	
	
	public function eliminar($codigo)
	{
		if(!ctype_digit($codigo)) throw new Exception("error eliminar 1");
		if($codigo<=0) throw new Exception("error eliminar 2");
		
		$q = "UPDATE mercaderia SET baja_producto = true WHERE codigo_producto = $codigo ";
		$this->db->query($q);
	}
		
	/**
	* Función que devuelve todos los productos.
	*	
	* @return array retorna un array con los datos de los productos encontrados.
	*/
	
	public function getTodos()
	{
		$q = "SELECT * FROM mercaderia WHERE en_venta = 'Si' AND baja_producto = false";
		
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que devuelve todos los productos que se encuentran en venta.
	*	
	* @return array retorna un array con los datos de los productos encontrados.
	*/
	
	public function getEnVenta()
	{
		$q = "SELECT * FROM mercaderia WHERE en_venta='Si' AND baja_producto = false";
		
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que devuelve todos los datos de un producto en particular.
	*	
	* @param integer $codigo un entero con el codigo indentificador de un producto.
	* @return array retorna un array con los datos del producto encontrado.
	*/
	
	public function getPorCodigo($codigo)
	{
		if(!ctype_digit($codigo))  throw new Exception("getPorCodigo");
		$q = "SELECT * FROM mercaderia WHERE codigo_producto=$codigo AND baja_producto = false ";		
		$this->db->query($q);		
		return $this->db->fetch();
	}
	
	/**
	* Función que devuelve todos los datos de un producto en particular mas el total 
	* del precio del producto por la cantidad recibida.
	*	
	* @param integer $codigo un entero con el codigo indentificador de un producto.
	* @param integer $cant un entero con la cantidad a vender de ese producto.
	* @return array retorna un array con los datos del producto encontrado o un
	* array vacio en caso de que no exista el producto.
	*/
	
	public function getParaVenta($codigo,$cant)
	{
		if(!ctype_digit($codigo))  throw new Exception("getParaVenta");
		if(!ctype_digit($cant))  throw new Exception("getParaVenta");
		$q = "SELECT m.codigo_producto,m.descripcion_producto,
					m.costo_producto*(m.porcen_venta_producto/100+1) as 'precio_venta' 
					, p.descripcion_proveedor, tp.descripcion_tipo
				FROM mercaderia as m
				LEFT JOIN proveedores as p on m.codigo_proveedor = p.codigo_proveedor
				LEFT JOIN tipos_producto as tp on m.codigo_tipo_producto = tp.codigo_tipo_producto
				WHERE codigo_producto=$codigo
				AND en_venta = 'Si' 
				AND baja_producto = false";		
		$this->db->query($q);
		if($this->db->numRows()==1){
			return $this->db->fetch();
		}
		else{
			return Array();
		} 
	}
	
	/**
	* Función que crea un nuevo producto a partir de los datos recibidos.
	*	
	* @param array $datos array con todos los datos necesarios de un producto.
	* @return array retorna un array con los datos del producto creado o un array
	* vacio en caso de que no validen los datos.
	*/
	
	public function crearNuevo($datos)
	{
		if($this->validarTodo($datos))
		{	
		$q = "INSERT INTO mercaderia (en_venta, costo_producto, descripcion_producto, stock, pto_reposicion, porcen_venta_producto, codigo_proveedor, codigo_tipo_producto )
		          VALUES ('".$datos['en-venta']."',".$datos['costo-producto'].",'".$datos['descripcion-producto']."', ".$datos['stock'].",".$datos['pto-reposicion']."
				  ,".$datos['porcen-venta-producto'].",".$datos['codigo-proveedor'].",".$datos['codigo-tipo-producto'].")";
		
		$this->db->query($q);
		
		$q = "SELECT codigo_producto FROM mercaderia ORDER BY codigo_producto DESC";
		$this->db->query($q);
		return $this->db->fetch();
		}
		return Array();
	}
	
	/**
	* Función que modifica un producto existente a partir de los datos recibidos.
	*	
	* @param array $datos array con todos los datos necesarios de un producto.
	* @return array retorna un array con los datos del producto modificado o un array
	* vacio en caso de que no validen los datos.
	*/
	
	public function modificar($datos)
	{
		if($this->validarTodo($datos))
		{			
		$q = "UPDATE mercaderia SET en_venta='".$datos['en-venta']."', costo_producto=".$datos['costo-producto'].", descripcion_producto
			='".$datos['descripcion-producto']."', stock=".$datos['stock'].", pto_reposicion=".$datos['pto-reposicion']."
			,porcen_venta_producto= ".$datos['porcen-venta-producto'].", codigo_proveedor=".$datos['codigo-proveedor']."
			,codigo_tipo_producto = ".$datos['codigo-tipo-producto']." 
			WHERE codigo_producto = ".$datos['codigo-producto'];
		$this->db->query($q);
		}
		return Array();		
	}
	
	/**
	* Función que valida todos los datos de un producto para introducirlos en
	* la base de datos.
	*	
	* @param array $datos array con todos los datos necesarios de un producto.
	* @return bool retorna true en caso de que el producto sea valido.
	*/
	
	
	public function validarTodo($datos)
	{
		if(!isset($datos['descripcion-producto'])) throw new Exception("error1");
		if(strlen($datos['descripcion-producto'])<1) throw new Exception("error2");
		if(strlen($datos['descripcion-producto'])>50)
			substr($datos['descripcion-producto'],0,50);
		$datos['descripcion-producto']=$this->db->escapeString($datos['descripcion-producto']);
		
		if(!isset($datos['costo-producto'])) throw new Exception("error3");
		if(!is_numeric($datos['costo-producto'])) throw new Exception("error4");
		if(strlen($datos['costo-producto'])<1) throw new Exception("error5");
		if(strlen($datos['costo-producto'])>10)throw new Exception("error6");		
		
		if(!isset($datos['pto-reposicion'])) throw new Exception("error7");
		if(!ctype_digit($datos['pto-reposicion'])) throw new Exception("error8");
		if(strlen($datos['pto-reposicion'])<1) throw new Exception("error9");
		if(strlen($datos['pto-reposicion'])>10)throw new Exception("error10");		
		
		if(!isset($datos['stock'])) throw new Exception("error11");
		if(!ctype_digit($datos['stock'])) throw new Exception("error12");
		if(strlen($datos['stock'])<1) throw new Exception("error13");
		if(strlen($datos['stock'])>10)throw new Exception("error14");				
				
		if(!isset($datos['en-venta'])) throw new Exception("error15");			
		if(strlen($datos['en-venta'])!=2) throw new Exception("error16");
		
		if(!isset($datos['porcen-venta-producto'])) throw new Exception("error3");
		if(!is_numeric($datos['porcen-venta-producto'])) throw new Exception("error4");
		if(strlen($datos['porcen-venta-producto'])<1) throw new Exception("error5");
		if(strlen($datos['porcen-venta-producto'])>10)throw new Exception("error6");	
		
		
		if(!isset($datos['codigo-proveedor'])) throw new Exception("error7");
		if(!ctype_digit($datos['codigo-proveedor'])) throw new Exception("error8");
		if(strlen($datos['codigo-proveedor'])<1) throw new Exception("error9");
		if(strlen($datos['codigo-proveedor'])>10)throw new Exception("error10");	
		
		if(!isset($datos['codigo-tipo-producto'])) throw new Exception("error7");
		if(!ctype_digit($datos['codigo-tipo-producto'])) throw new Exception("error8");
		if(strlen($datos['codigo-tipo-producto'])<1) throw new Exception("error9");
		if(strlen($datos['codigo-tipo-producto'])>10)throw new Exception("error10");
		
		return true;
	}
	
	/**
	* Función que devuelve los datos de todos los productos que no estan dados de baja.
	*
	* @return array retorna un array con los datos de todos los productos encontrados.
	*/	
	
	public function informeStock()
	{
		$q = "SELECT m.*, p.descripcion_proveedor, tp.descripcion_tipo
				FROM mercaderia as m
				LEFT JOIN proveedores as p on m.codigo_proveedor = p.codigo_proveedor
				LEFT JOIN tipos_producto as tp on m.codigo_tipo_producto = tp.codigo_tipo_producto
		WHERE m.baja_producto = false ORDER BY (m.stock-m.pto_reposicion), m.en_venta DESC";
		
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que modifica la cantidad disponible de un producto en particular.
	*	
	* @param integer $cod_prod entero que identifica un producto en particular de la tabla mercaderia.
	* @param integer $cant entero que idica la cantidad a modificar.
	* @return integer retorna un entero con la cantidad de stock del producto modificado.
	*/	
	
	public function modificarStock($cod_prod,$cant)
	{
		if(!isset($cod_prod)) throw new Exception("error11");
		if(!ctype_digit($cod_prod)) throw new Exception("error12");
		$producto=$this->getPorCodigo($cod_prod) ;
		if($producto == null) throw new Exception("error13");
		$q = "UPDATE mercaderia SET stock=stock+".$cant." 
			WHERE codigo_producto = ".$cod_prod;
		$this->db->query($q);
		$q = "SELECT stock FROM mercaderia WHERE codigo_producto = ".$cod_prod;
		$this->db->query($q);
		$res=$this->db->fetch();
		return $res['stock'];
	}
	
	/**
	* Función que devuelve los datos de los productos vendidos en facturas realizadas entre dos fechas.
	*	
	* @param string $fecha_inic una string que representa la fecha minima de las facturas de donde
	* se bucan los productos.
	* @param string $fecha_fin una string que representa la fecha maxima de las facturas de donde
	* se bucan los productos.
	* @return array retorna un array con los datos de los productos encontrados o 
	* un array vacio si no hay resultados.
	*/	
	
	public function getProductosInforme($fecha_inic,$fecha_fin)
	{
		if(!isset($fecha_inic)) throw new Exception("error16");
		if(strlen($fecha_inic)!=10) throw new Exception("error17");
		if(!isset($fecha_fin)) throw new Exception("error16");
		if(strlen($fecha_fin)!=10) throw new Exception("error17");
		$q="SELECT m.codigo_producto,m.descripcion_producto,SUM(rf.cantidad_renglonfactura) as cant,rf.precio_unitario,(rf.precio_unitario*SUM(rf.cantidad_renglonfactura)) as imp_total
			FROM mercaderia as m, renglon_factura as rf, facturas as f
			WHERE m.codigo_producto=rf.codigo_producto
			AND rf.nro_factura=f.nro_factura
			AND (f.fecha_factura BETWEEN '$fecha_inic' AND '$fecha_fin')
			GROUP BY m.codigo_producto
			ORDER BY cant DESC;";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	public function cambiarPorcentaje($busqueda,$proveedor = 0, $tipo = 0,$porcentaje)
	{			
		$q = "UPDATE mercaderia SET porcen_venta_producto = $porcentaje
			WHERE baja_producto = false";		
		
		if(ctype_digit($busqueda))
			$q= $q." AND codigo_producto = $busqueda";
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
				
				$q= $q." AND descripcion_producto LIKE '%$busqueda%'";
			}
		}	
			
		if($proveedor != 0)
			$q= $q." AND codigo_proveedor = $proveedor";
		
		if($tipo != 0)
			$q= $q." AND codigo_tipo_producto = $tipo";
				
		$this->db->query($q);
		return $this->buscar($busqueda,false,$proveedor,$tipo);
	}
	
	public function cambiarCosto($busqueda,$proveedor = 0, $tipo = 0,$porcentaje, $esAumento)
	{	
		if($esAumento == "True")
			$q = "UPDATE mercaderia SET costo_producto = costo_producto * ($porcentaje /100 +1)
				WHERE baja_producto = false";		
		else
			$q = "UPDATE mercaderia SET costo_producto = costo_producto * (1- $porcentaje /100 )
				WHERE baja_producto = false";	
		
		if(ctype_digit($busqueda))
			$q= $q." AND codigo_producto = $busqueda";
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
				
				$q= $q." AND descripcion_producto LIKE '%$busqueda%'";
			}
		}	
			
		if($proveedor != 0)
			$q= $q." AND codigo_proveedor = $proveedor";
		
		if($tipo != 0)
			$q= $q." AND codigo_tipo_producto = $tipo";
				
		$this->db->query($q);		
		return $this->buscar($busqueda,false,$proveedor,$tipo);
	}
}

?>