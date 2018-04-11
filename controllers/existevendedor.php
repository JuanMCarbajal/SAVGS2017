<?php 
// controllers/existevendedor.php

require '../framework/fw.php';
require '../models/Vendedores.php';

if(isset($_POST['nro'])&&isset($_POST['tipo'])&&isset($_POST['cuil'])&&isset($_POST['codigo']))
{
	$c = new Vendedores;
	if($c->existe($_POST['nro'],$_POST['tipo'],$_POST['cuil'],$_POST['codigo']))
		echo 'true';
	else
		echo 'false';
}

?>