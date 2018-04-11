<?php 

// models/TiposDocumento.php
/**
* Clase que identifica los Tipos de Documento para S.A.V.G.S.
*
* Esta clase permite obtener mediante sus metodos los Tipos de Documentos.
*
* @package S.A.V.G.S.
* @author Juan <0juankarbajal0@gmail.com>
* @version 1.7
*/
class TiposDocumento extends Model 
{
	
	/**
	* Funcion que retorna datos de un tipo de documento mediante un codigo identificador
	*
	* Esta funcion recibe un codigo identificador y retorna un array con
	* los datos del Tipo de Documento.
	* 
	* @param string $codigo Un string que contiene un codigo identificatorio
	* @return array retorna un array con los datos del Tipo de Documento si existe
	* o un array vacío si no existe.
	*/
	public function getPorCodigo( $codigo)
	{
		$q = "SELECT * FROM tipos_documento WHERE codigo_tipo_documento = $codigo";
		
		$this->db->query($q);
		return $this->db->fetch();
	}	
	
	/**
	* Funcion que retorna datos de todos los Tipos de Documentos
	*
	* Esta funcion retorna un array con los datos de los Tipos de Documentos.
	* 
	* @return array retorna un array que contiene arrays con los datos de los Tipos de Documentos
	* Si no existen los datos retorna un array vacío.
	*/
	public function getTodos()
	{
		$q = "SELECT * FROM tipos_documento";
		
		$this->db->query($q);
		return $this->db->fetchAll();
	}	
	
	/**
	* Funcion que retorna si existe el Tipo de Documento mediante un codigo identificador
	*
	* 
	* @param string $codigo Un string que contiene un codigo identificatorio
	* @return bool retorna un true si existe y retorna un false si no existe.
	*/
	public function existe($td)
	{
		$q = "SELECT * FROM tipos_documento WHERE codigo_tipo_documento = $td";
		$this->db->query($q);
		if($this->db->numRows()>0) return true;
		return false;
	}

}

?>