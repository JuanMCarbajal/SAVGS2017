<?php 

// models/Vendedores.php

/**
* Clase para manejo de los vendedores para S.A.V.G.S.
*
* Esta clase maneja tanto la entrada como la salida de datos de la tabla vendedores.
*
* @package S.A.V.G.S.
* @author Matias <matiascabral95@gmail.com>
* @version 1.7
*/

class Vendedores extends Model 
{
	
	/**
	* Función que busca vendedores y retorna sus datos.
	*
	* Esta función recibe un string el cual se compara con los nombres
	* de los vendedores de la tabla vendedores de la base de datos y 
	* devuelve los datos de los vendedores cuyos nombres concuerdan 
	* parcialmente o en su totalidad con la string recibido.
	*
	* @param string $busqueda una string que sirve para realizar la busqueda.	
	* @return array retorna un array con los datos de la consulta o vacio si 
	* no hay resultados.
	*/

	public function buscar($busqueda)
	{
		if(ctype_digit($busqueda))
			$q = "SELECT v.codigo_vendedor,v.nombre_vendedor, v.telefono_vendedor,
					v.direccion_vendedor, v.localidad_vendedor,
					DATE_FORMAT(v.fecha_inicio, '%d/%m/%Y') f_inic,
					DATE_FORMAT(v.fecha_nac, '%d/%m/%Y') f_nac,
					v.nro_documento_vendedor, td.descripcion_tipo_documento, v.cuil_vendedor, v.sexo_vendedor
					FROM vendedores as v, tipos_documento as td
					WHERE v.codigo_tipo_documento=td.codigo_tipo_documento
					AND codigo_vendedor = $busqueda
					AND fecha_fin is null;";		
		else
		{		
			if(strlen($busqueda)<2) throw new Exception("error2");
			if(strlen($busqueda)>50)
				$busqueda=substr($busqueda,0,50);
			$busqueda=mysql_escape_string($busqueda);
			$busqueda=str_replace("%","\%",$busqueda);
			$busqueda=str_replace("_","\_",$busqueda);
			$q = "SELECT v.codigo_vendedor,v.nombre_vendedor, v.telefono_vendedor,
					v.direccion_vendedor, v.localidad_vendedor,
					DATE_FORMAT(v.fecha_inicio, '%d/%m/%Y') f_inic,
					DATE_FORMAT(v.fecha_nac, '%d/%m/%Y') f_nac,
					v.nro_documento_vendedor, td.descripcion_tipo_documento, v.cuil_vendedor, v.sexo_vendedor
					FROM vendedores as v, tipos_documento as td
					WHERE v.codigo_tipo_documento=td.codigo_tipo_documento
					AND nombre_vendedor LIKE '%$busqueda%'
					AND  fecha_fin is null;";		
		}		
		
		$this->db->query($q);
		if($this->db->numRows()>=1)
			return $this->db->fetchAll();
		return Array();
		
	}
	
	/**
	* Función que devuelve todos los vendedores.
	*	
	* @return array retorna un array con los datos de los vendedores encontrados.
	*/
	
	public function getTodos()
	{
		$q = "SELECT * FROM vendedores";
		
		$this->db->query($q);
		return $this->db->fetchAll();
	}
	
	/**
	* Función que devuelve todos los datos de un vendedor en particular.
	*	
	* @param integer $codigo un entero con el codigo indentificador de un vendedor.
	* @return array retorna un array con los datos del vendedor encontrado.
	*/
	
	public function getPorCodigo($codigo)
	{
		if(!ctype_digit($codigo))  throw new Exception("getPorCodigo");
		
		$q = "SELECT v.codigo_vendedor,v.nombre_vendedor, v.telefono_vendedor,
					v.direccion_vendedor, v.localidad_vendedor,
					DATE_FORMAT(v.fecha_inicio, '%d/%m/%Y') f_inic,
					DATE_FORMAT(v.fecha_nac, '%d/%m/%Y') f_nac,
					v.nro_documento_vendedor, v.codigo_tipo_documento, v.cuil_vendedor, v.sexo_vendedor
				FROM vendedores as v
				WHERE codigo_vendedor=$codigo AND fecha_fin IS NULL";		
		$this->db->query($q);		
		return $this->db->fetch();
	}
	
	/**
	* Función que elimina un vendedor en particular.
	*
	* @param integer $codigo un entero con el codigo indentificador de un vendedor
	* en la base de datos.
	*/	
	
	public function eliminar($codigo)
	{
		if(!ctype_digit($codigo)) throw new Exception("error eliminar 1");
		if($codigo<=0) throw new Exception("error eliminar 2");
		
		$q = "UPDATE vendedores SET fecha_fin = now() WHERE codigo_vendedor = $codigo ";
		$this->db->query($q);
	}
	
	/**
	* Función que crea un nuevo vendedor a partir de los datos recibidos.
	*	
	* @param array $datos array con todos los datos necesarios de un vendedor.
	* @param array $tipos_doc array con todos los datos de los tipos de documentos.
	* @return array retorna un array con los datos del vendedor creado o un array
	* vacio en caso de que no validen los datos.
	*/
	
	public function crearNuevo($datos, $tipos_doc )
	{	
		
		if($this->validarTodo($datos, $tipos_doc))
		{
		$q = "INSERT INTO vendedores ( nombre_vendedor, telefono_vendedor, direccion_vendedor, localidad_vendedor, fecha_inicio, fecha_nac, nro_documento_vendedor, codigo_tipo_documento, cuil_vendedor, sexo_vendedor)
		        VALUES ('".$datos['nombre']."','".$datos['telefono']."','".$datos['direccion']."','".$datos['localidad']."','".$datos['fecha-inicio']."','".$datos['fecha-nac']."','".$datos['nro-documento']."',".$datos['tipo-documento'].",'".$datos['cuil']."', '".$datos['sexo']."')";
		
		$this->db->query($q);
		
		$q = "SELECT * FROM vendedores ORDER BY codigo_vendedor DESC";
		$this->db->query($q);
		return $this->db->fetch();
		}
		return Array();
	}
	
	/**
	* Función que indica si existe o no un vendedor en particular.
	*	
	* @param integer $nro un entero con el numero de documento de un vendedor.
	* @param integer $tipo un entero que indica el tipo de documento de un vendedor.
	* @param integer $cuil un entero con el cuil de un vendedor.
	* @param integer $codigo un entero con el codigo indentificador de un vendedor
	* en la base de datos, en caso de ser 0 este debe ser omitido en la consulta.
	* @return bool retorna un boolean que indica si existe o no el vendedor.
	*/
	
	public function existe($nro,$tipo,$cuil,$codigo)
	{
		if(!ctype_digit($nro)) throw new Exception("error1");
		if(strlen($nro)<2) throw new Exception("error2");
		if(strlen($nro)>10)
			$nro=substr($nro,0,10);
		
		if(!ctype_digit($cuil)) throw new Exception("error3");
		if(strlen($cuil)<2) throw new Exception("error4");
		if(strlen($cuil)>11)
			$cuil=substr($cuil,0,11);
		
		if(!ctype_digit($tipo)) throw new Exception("error5");
		if(strlen($tipo)!=1) throw new Exception("error6");
		
		if(!ctype_digit($codigo)) throw new Exception("error7");
				
		$q = "SELECT * FROM vendedores WHERE (( nro_documento_vendedor = '$nro' AND  codigo_tipo_documento = $tipo ) OR cuil_vendedor = $cuil )";
			
		if($codigo!=0)
			$q = $q." AND codigo_vendedor <> $codigo";
			
		$this->db->query($q);
		if($this->db->numRows()!=0)
			return true;
		return false;
	}
	
	/**
	* Función que modifica un vendedor existente a partir de los datos recibidos.
	*	
	* @param array $datos array con todos los datos necesarios de un vendedor.
	* @param array $tipos_doc array con todos los datos de los tipos de documentos.
	* @return array retorna un array con los datos del vendedor modificado o un array
	* vacio en caso de que no validen los datos.
	*/
	
	public function modificar($datos, $tipos_doc)
	{
		if($this->validarTodo($datos, $tipos_doc))
		{			
		$q = "UPDATE vendedores SET nombre_vendedor='".$datos['nombre']."',telefono_vendedor='".$datos['telefono']."',
		direccion_vendedor='".$datos['direccion']."',localidad_vendedor='".$datos['localidad']."',
		fecha_inicio='".$datos['fecha-inicio']."',fecha_nac='".$datos['fecha-nac']."',nro_documento_vendedor='".$datos['nro-documento']."',
		codigo_tipo_documento=".$datos['tipo-documento'].",cuil_vendedor='".$datos['cuil']."',
		sexo_vendedor='".$datos['sexo']."'
			WHERE codigo_vendedor = ".$datos['codigo-vendedor'];
			
		$this->db->query($q);
		}
		return Array();
	}
	
	
	/**
	* Función que valida todos los datos de un vendedor para introducirlos en
	* la base de datos.
	*	
	* @param array $datos array con todos los datos necesarios de un vendedor.
	* @param array $tipos_doc array con todos los datos de los tipos de documentos.
	* @return bool retorna true en caso de que el vendedor sea valido.
	*/
	
	public function validarTodo($datos, $tipos_doc)
	{
		if(!isset($datos['nombre'])) throw new Exception("error1");
		if(strlen($datos['nombre'])<2) throw new Exception("error2");
		if(strlen($datos['nombre'])>50)
			substr($datos['nombre'],0,50);
		$datos['nombre']=$this->db->escapeString($datos['nombre']);
		
		if(isset($datos['telefono']) && strlen($datos['telefono']))
		{
			if(!ctype_digit($datos['telefono'])) throw new Exception("error4");
			if(strlen($datos['telefono'])<1) throw new Exception("error4.5");
			if(strlen($datos['telefono'])>20)
				substr($datos['telefono'],0,20);
		}
		
		if(isset($datos['direccion']) && strlen($datos['direccion']))
		{
			if(strlen($datos['direccion'])<1) throw new Exception("error6");
			if(strlen($datos['direccion'])>50)
				substr($datos['direccion'],0,50);
			$datos['direccion']=$this->db->escapeString($datos["direccion"]);
		}
		
		if(isset($datos['localidad']) && strlen($datos['localidad']))
		{
			if(strlen($datos['localidad'])<1) throw new Exception("error9");
			if(strlen($datos['localidad'])>50)
				substr($datos['localidad'],0,50);
			$datos['localidad']=$this->db->escapeString($datos['localidad']);
		}
	
		if(!isset($datos['tipo-documento'])) throw new Exception("error13");
		if(!ctype_digit($datos['tipo-documento'])) throw new Exception("error13.5");
		if(!$tipos_doc->existe($datos['tipo-documento'])) throw new Exception("error13.55");
		
		if(isset($datos['fecha-inicio']) && strlen($datos['fecha-inicio']))
		{
			if(strlen($datos['fecha-inicio'])!=10) throw new Exception("error91");	
			$datos['fecha-inicio']=$this->db->escapeString($datos['fecha-inicio']);
		}
		
		if(isset($datos['fecha-nac']) && strlen($datos['fecha-nac']))
		{
			if(strlen($datos['fecha-nac'])!=10) throw new Exception("error92");	
			$datos['fecha-nac']=$this->db->escapeString($datos['fecha-nac']);
		}
		
		if(!isset($datos['nro-documento'])) throw new Exception("error14");
		if(!ctype_digit($datos['nro-documento'])) throw new Exception("error15");
		if(strlen($datos['nro-documento'])<1) throw new Exception("error15.5");
		if(strlen($datos['nro-documento'])>20)
			substr($datos['nro-documento'],0,20);		
		
		if(isset($datos['cuil']) && strlen($datos['cuil']))
		{
			if(strlen($datos['cuil'])<1) throw new Exception("error17");
			if(strlen($datos['cuil'])>15)
				substr($datos['cuil'],0,15);
			$datos['cuil']=$this->db->escapeString($datos['cuil']);
		}
		
		if(!isset($datos['sexo'])) throw new Exception("error18");
		if(strlen($datos['sexo'])!=1) throw new Exception("error17");	
		
		return true;
	}
	
	/**
	* Función que devuelve los datos de los vendedores que realizaron ventas entre dos fechas.
	*	
	* @param string $fecha_inic una string que representa la fecha minima de las ventas de donde
	* se bucan los vendedores.
	* @param string $fecha_fin una string que representa la fecha maxima de las ventas de donde
	* se bucan los vendedores.
	* @return array retorna un array con los datos de los vendedores encontrados.
	*/	
	
	public function getVendedoresInforme($fecha_inic,$fecha_fin)
	{
		if(!isset($fecha_inic)) throw new Exception("error16");
		if(strlen($fecha_inic)!=10) throw new Exception("error17");
		if(!isset($fecha_fin)) throw new Exception("error16");
		if(strlen($fecha_fin)!=10) throw new Exception("error17");
		$q="SELECT v.codigo_vendedor, v.nombre_vendedor, SUM(f.importe_total_factura) as 'total_ventas', COUNT(v.codigo_vendedor) as 'cant_ventas'
		FROM vendedores as v, facturas as f
		WHERE v.codigo_vendedor=f.codigo_vendedor
		AND (f.fecha_factura BETWEEN '$fecha_inic' AND '$fecha_fin')
		GROUP BY v.codigo_vendedor
		ORDER BY v.nombre_vendedor ASC;";
		$this->db->query($q);
		return $this->db->fetchAll();
	}
}

?>