<?php 
// controllers/modificarprecioproductos.php

require '../framework/fw.php';
require '../models/Mercaderia.php';
require '../views/BuscarProductos.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

$m=new Mercaderia;	
$_SESSION['busqueda']=$_POST["busqueda"];
if(isset($_POST["esAumento"]))
	$res=$m->cambiarCosto($_POST["busqueda"], $_POST["proveedor"], $_POST["tipo"], $_POST["porcentaje"], $_POST["esAumento"]);
else
	$res=$m->cambiarPorcentaje($_POST["busqueda"], $_POST["proveedor"], $_POST["tipo"], $_POST["porcentaje"]);

$vista=new BuscarProductos;
$vista->resultados=$res;
$vista->render();


?>