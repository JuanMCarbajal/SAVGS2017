<?php 
// controllers/nuevoproveedor.php

require '../framework/fw.php';
require '../models/Proveedores.php';
require '../views/NuevoProveedor.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

$p=new Proveedores;

if(isset($_POST["descripcion-proveedor"]))
{	
	$p->crearNuevo($_POST);
	header("location:abmproveedores.php");
}

$vista = new NuevoProveedor;
$vista->render();

?>