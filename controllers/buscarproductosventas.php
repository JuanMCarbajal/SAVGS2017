<?php  
// controllers/buscarproductosventas.php

require '../framework/fw.php';
require '../models/Mercaderia.php';
require '../views/BuscarProductosVentas.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

if(isset($_POST["busqueda"])||isset($_POST["proveedor"]))
{	
	$m=new Mercaderia;
	$res=$m->Buscar($_POST["busqueda"], True, $_POST["proveedor"], $_POST["tipo"]);
	
	$vista=new BuscarProductosVentas;
	$vista->resultados=$res;
	$vista->render();
}

?>