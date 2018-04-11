<?php 
// controllers/abmmediosdepago.php

require '../framework/fw.php';
require '../models/Proveedores.php';
require '../views/ABMProveedores.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

if(!isset($_POST['codigo-proveedor']))
{	
	$p=new Proveedores;
	$res=$p->getTodos();
	
	$vista=new ABMProveedores;
	$vista->Proveedores=$res;
	$vista->render();
}
else
{
	$m=new Proveedores;
	$m->eliminar($_POST['codigo-proveedor']);		
}	
	


?>