<?php 
//controllers/abmproductos.php

require '../framework/fw.php';
require '../Models/Mercaderia.php';
require '../views/ABMProductos.php';
require '../models/Proveedores.php';
require '../models/TiposProducto.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

if(!isset($_POST['codigo-producto']))
{	
	$tp=new TiposProducto;
	$p=new Proveedores;
	$vista=new ABMProductos;
	$vista->tipos_producto = $tp->getTodos();
	$vista->proveedores = $p->getTodos();
	$vista->render();
}
else
{
	$merc=new Mercaderia;
	$merc->eliminar($_POST['codigo-producto']);
		
}
?>