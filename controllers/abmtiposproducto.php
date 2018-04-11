<?php 
// controllers/abmtiposproducto.php

require '../framework/fw.php';
require '../models/TiposProducto.php';
require '../views/ABMTiposProducto.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

if(!isset($_POST['codigo-tipo-producto']))
{	
	$t=new TiposProducto;
	$res=$t->getTodos();
	
	$vista=new ABMTiposProducto;
	$vista->tiposProducto=$res;
	$vista->render();
}
else
{
	$t=new TiposProducto;
	$t->eliminar($_POST['codigo-tipo-producto']);		
}	
	


?>