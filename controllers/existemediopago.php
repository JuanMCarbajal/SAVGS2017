<?php 
// controllers/existemediopago.php

require '../framework/fw.php';
require '../models/MediosDePago.php';

if(isset($_POST['nombre'])&&isset($_POST['codigo']))
{
	$m = new MediosDePago;
	if($m->existe($_POST['nombre'],$_POST['codigo']))
		echo 'true';
	else
		echo 'false';
}

?>