<?php 
// controllers/existemercaderia.php

require '../framework/fw.php';
require '../models/Mercaderia.php';

if(isset($_POST['nombre'])&&isset($_POST['codigo']))
{
	$m = new Mercaderia;
	if($m->existe($_POST['nombre'],$_POST['codigo']))
		echo 'true';
	else
		echo 'false';
}

?>