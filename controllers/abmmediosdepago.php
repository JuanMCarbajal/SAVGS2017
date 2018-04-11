<?php 
// controllers/abmmediosdepago.php

require '../framework/fw.php';
require '../models/MediosDePago.php';
require '../views/ABMMediosDePago.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');


if(!isset($_POST['codigo-medio-pago']))
{	
	$m=new MediosDePago;
	$res=$m->getTodos();
	
	$vista=new ABMMediosDePago;
	$vista->mediosDePago=$res;
	$vista->render();
}
else
{
	$m=new MediosDePago;
	$m->eliminar($_POST['codigo-medio-pago']);		
}	
	


?>