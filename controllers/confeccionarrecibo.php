<?php

// controllers/confeccionarrecibo.php

require '../framework/fw.php';
require '../views/ConfeccionarRecibo.php';
require '../models/Clientes.php';
require '../models/Recibos.php';
require '../models/RecibosFacturas.php';
require '../models/Empresa.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

$cli=new Clientes;
$rfac=new RecibosFacturas;
$rec=new Recibos;
$emp=new Empresa;

if(isset($_POST["num_recibo"]))
{
	$nro_recibo_aux = $_POST["num_recibo"];	
}
else
{	
	$rec->crearNuevo($_POST['importe'],$_SESSION['cliente']);

	$aux=1;

	$_POST['datospago']=json_decode($_POST['datospago']);
}
if(!isset($_POST['importe'])){
	$vista=new ConfeccionarRecibo;
	$vista->cliente=$cli->getClienteCodigoVenta($_SESSION['cliente']);
	$vista->recibo=$rec->getReciboCodigoVenta($nro_recibo_aux);
	$vista->recibosfacturas=$rfac->getReciboFacturaVentas($nro_recibo_aux);
	$vista->empresa=$emp->get();
	$vista->render();
}

?>