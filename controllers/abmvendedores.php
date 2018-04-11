<?php 
//controllers/abmvendedores.php

require '../framework/fw.php';
require '../Models/Vendedores.php';
require '../views/ABMVendedores.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

if(!isset($_POST['codigo-vendedor']))
{	
	$vista=new ABMVendedores;
	if(isset($_SESSION['cuentaNueva']))
		$vista->mensaje="cuenta creada: usuario=".$_SESSION['cuentaNueva']['usuario'].", contraseña=".$_SESSION['cuentaNueva']['contraseña'];
	unset($_SESSION['cuentaNueva']);
	$vista->render();
}
else
{
	$vend=new Vendedores;
	$vend->eliminar($_POST['codigo-vendedor']);		
}



?>