<?php 
// controllers/nuevotipoproducto.php

require '../framework/fw.php';
require '../models/TiposProducto.php';
require '../views/NuevoTipoProducto.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');


$t=new TiposProducto;

if(isset($_POST["descripcion-tipo"]))
{	
	$t->crearNuevo($_POST);
	header("location:abmtiposproducto.php");
}

$vista = new NuevoTipoProducto;
$vista->render();

?>