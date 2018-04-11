<?php 
// controllers/nuevocliente.php

require '../framework/fw.php';
require '../models/Clientes.php';
require '../models/TiposDocumento.php';
require '../views/NuevoCliente.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

$cli=new Clientes;
$td=new TiposDocumento;

if(isset($_POST["nombre"]))
{	
	try
	{
	$cli->crearNuevo($_POST,$td);
	$cli->getUltimoCliente();
	$_SESSION['cliente']=$cli->getUltimoCliente();
	header("location:registrarventa.php");
	}
	catch (Exception $e) 
	{
		echo 'Excepción capturada: ',  $e->getMessage(), "\n";
	}
}

$vista = new NuevoCliente;
$vista->clientes = $cli;
$vista->tipo_doc = $td->getTodos();
$vista->render();
?>