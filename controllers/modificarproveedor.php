<?php 
// controllers/modificarproveedor.php

require '../framework/fw.php';
require '../models/Proveedores.php';
require '../views/ModificarProveedor.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

$p=new Proveedores;

if(isset($_POST["codigo"]))
{	
	$mdp=$p->getProveedorCodigo($_POST["codigo"]);
		
	$vista=new ModificarProveedor;
	$vista->Proveedor=$mdp;
	$vista->render();
}
else
{
	$p->modificar($_POST);
	header("location:abmproveedores.php");
}


?>