<?php 
// controllers/buscarvendedores.php

require '../framework/fw.php';
require '../models/Vendedores.php';
require '../views/BuscarVendedores.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

if(isset($_POST["busqueda"]))
{	
	$v=new Vendedores;
	$_SESSION['busqueda']=$_POST["busqueda"];
	$res=$v->buscar($_POST["busqueda"],false);
	
	$vista=new BuscarVendedores;
	$vista->resultados=$res;
	$vista->render();
}

?>