<?php

// controllers/registrarpago.php

require '../framework/fw.php';
require '../models/Recibos.php';
require '../models/Clientes.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

if(!isset($_SESSION['cliente']))
{
	header("Location: menuvendedor.php");
	exit;
}
$rec=new Recibos;
$cli = new Clientes;
if( isset($_POST['importe'])) )
{
	$rec->crearNuevo($_POST['importe'],$_SESSION['cliente']);	
}

?>