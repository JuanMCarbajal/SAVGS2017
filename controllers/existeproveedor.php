<?php 
// controllers/existeproveedor.php

require '../framework/fw.php';
require '../models/Proveedores.php';

if(isset($_POST['nombre'])&&isset($_POST['codigo']))
{
	$m = new Proveedores;
	if($m->existe($_POST['nombre'],$_POST['codigo']))
		echo 'true';
	else
		echo 'false';
}

?>