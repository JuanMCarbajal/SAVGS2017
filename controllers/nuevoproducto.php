<?php 
// controllers/nuevoproducto.php

require '../framework/fw.php';
require '../models/Mercaderia.php';
require '../models/TiposProducto.php';
require '../models/Proveedores.php';
require '../views/NuevoProducto.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

$m=new Mercaderia;
$tp=new TiposProducto;
$p=new Proveedores;

if(isset($_POST["precio-venta"]))
{	
	$nuevo=$m->crearNuevo($_POST);
	$_SESSION['busqueda']=$nuevo['codigo_producto'];	
	header("location:abmproductos.php");
}

$vista = new NuevoProducto;
$vista->tipos_producto = $tp->getTodos();
$vista->proveedores = $p->getTodos();
$vista->render();

?>