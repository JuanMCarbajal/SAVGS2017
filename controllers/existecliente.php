<?php 
// controllers/existecliente.php

require '../framework/fw.php';
require '../models/Clientes.php';

if(isset($_POST['nro'])&&isset($_POST['tipo'])&&isset($_POST['codigo']))
{
	$c = new Clientes;
	if($c->existe($_POST['nro'],$_POST['tipo'],$_POST['codigo']))
		echo 'true';
	else
		echo 'false';
}

?>