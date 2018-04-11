<?php 
// controllers/buscarclientes.php

require '../framework/fw.php';
require '../models/Clientes.php';
require '../views/BuscarClientes.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

if(isset($_POST["busqueda"]))
{	
	$c=new Clientes;
	$_SESSION['busqueda']=$_POST["busqueda"];
	$res=$c->buscar($_POST["busqueda"],false);
	
	$vista=new BuscarClientes;
	$vista->resultados=$res;
	$vista->render();
}

?>