<?php 
// controllers/modificarproducto.php

require '../framework/fw.php';
require '../models/Mercaderia.php';
require '../models/TiposProducto.php';
require '../models/Proveedores.php';
require '../views/ModificarProducto.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

$m=new Mercaderia;
$tp=new TiposProducto;
$pr=new Proveedores;


if(isset($_POST["codigo"]))
{	
	$p=$m->getPorCodigo($_POST["codigo"]);
		
	$vista=new ModificarProducto;
	$vista->producto=$p;
	$vista->tipos_producto = $tp->getTodos();
	$vista->proveedores = $pr->getTodos();
	$vista->render();
}
else
{
	$m->modificar($_POST);
	header("location:abmproductos.php");
}


?>