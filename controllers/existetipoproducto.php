<?php 
// controllers/existetipoproducto.php

require '../framework/fw.php';
require '../models/TiposProducto.php';

if(isset($_POST['nombre'])&&isset($_POST['codigo']))
{
	$m = new TiposProducto;
	if($m->existe($_POST['nombre'],$_POST['codigo']))
		echo 'true';
	else
		echo 'false';
}

?>