<?php 

// models/Empresa.php

/**
* Clase para tomar los datos de la empresa para S.A.V.G.S.
*
* Esta clase maneja la salida de datos de la tabla empresa, 
* la cual contiene todos los datos de la empresa.
*
* @package S.A.V.G.S.
* @author Matias <matiascabral95@gmail.com>
* @version 1.7
*/

class Empresa extends Model 
{
	
	/**
	* Función que retorna los datos de la empresa guardados en la tabla empresa.
	*
	* @return array retorna un array con los datos de la empresa.
	*/

	public function get()
	{
		$q = "SELECT razon_social_empresa as 'Razon Social',telefono_empresa as 'Telefono',
					direccion_empresa as 'Direccion',localidad_empresa as 'Localidad',codigo_postal_empresa as 'Codigo Postal'
		FROM empresa";
		$this->db->query($q);
		return $this->db->fetch();
	}
	
}

?>