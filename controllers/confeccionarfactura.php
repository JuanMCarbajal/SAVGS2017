<?php

// controllers/confeccionarfactura.php

require '../framework/fw.php';
require '../models/Clientes.php';
require '../models/Mercaderia.php';
require '../models/Facturas.php';
require '../models/Recibos.php';
require '../models/RenglonFactura.php';
require '../models/MediosDePago.php';
require '../models/Empresa.php';
require '../views/ConfeccionarFactura.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

$mer=new Mercaderia;
$cli=new Clientes;
$fac=new Facturas;
$rec=new Recibos;
$rfac=new RenglonFactura;
$emp=new Empresa;

$vista=new ConfeccionarFactura;
if(isset($_POST["num_factura"]))
{
	$nro_factura_aux = $_POST["num_factura"];
	$vista->esVenta = false;
}
else
{
	$importe = $fac->crearNuevo($_POST);

	$aux=1;

	$_POST['datosfactura']=json_decode(stripslashes(html_entity_decode($_POST['datosfactura'])));

	$nro_factura_aux=$fac->getUltFactIng($_POST['cod_vendedor']);


	foreach($_POST['datosfactura'] as $df)
	{
		$mer->modificarStock($df->ID_prod, ($df->prodCant*(-1)));
		$rfac->crearNuevo($df,$nro_factura_aux,$aux);
		$aux++;
	}
	$vista->esVenta = true;
	
	$cuenta = $cli->getCuenta($_SESSION['cliente']);
	if($cuenta != 0)
	{
		if($cuenta > $importe)
		{
			$cuenta = $importe;		
		}
		$cli->setCuenta($_SESSION['cliente'], $cuenta*(-1));
		$rec->CrearNuevo($cuenta,$_SESSION['cliente']);
	}
}
$vista->cliente=$cli->getClienteCodigoVenta($_SESSION['cliente']);
$vista->factura=$fac->getFacturaCodigoVenta($nro_factura_aux);
$_SESSION['factura_cargada']=$nro_factura_aux;
$vista->renglonfactura=$rfac->getRenglonesFacturaVentas($nro_factura_aux);
$vista->empresa=$emp->get();
$vista->render();
	
?>