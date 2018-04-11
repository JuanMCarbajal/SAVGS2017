<?php 
// controllers/modificarstock.php

require '../framework/fw.php';
require '../models/Mercaderia.php';
require '../models/Proveedores.php';
require '../models/TiposProducto.php';
require '../views/BuscarProductosStock.php';
require '../views/ModificarStock.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'almacen');

if(!isset($_POST["busqueda"])&&!isset($_POST["codigo-producto"]))
{	
	$tp=new TiposProducto;
	$p=new Proveedores;
	$vista = new ModificarStock;
	$vista->tipos_producto = $tp->getTodos();
	$vista->proveedores = $p->getTodos();
	$vista->render();
}
else
	if(isset($_POST["busqueda"]))
	{		
		$m=new Mercaderia;	
		$res=$m->buscar($_POST["busqueda"], false, $_POST["proveedor"], $_POST["tipo"]);
		
		$vista=new BuscarProductosStock;
		$vista->resultados=$res;
		$vista->render();	
	}
	else
		if(isset($_POST["codigo-producto"]))
		{
			$m=new Mercaderia;	
			$stock=$m->ModificarStock($_POST["codigo-producto"],$_POST["cantidad"]);	
			echo $stock;
		}

?>