<?php 
//controllers/buscarproductosfactura.php

require '../framework/fw.php';
require '../models/Facturas.php';
require '../models/RenglonFactura.php';
require '../models/RenglonDevolucion.php';
require '../models/Recibos.php';
require '../models/RecibosFacturas.php';
require '../views/BuscarProductosFactura.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

if(isset($_POST["factura"]))
{	
	$fac=new Facturas;
	$rfac=new RenglonFactura;
	$rdev=new RenglonDevolucion;
	$vista=new BuscarProductosFactura;
	$vista->resultados=$rfac->getRenglonesFactura($_POST['factura']);
	$aux=$rdev->getRenglonesDevolucionFactura($_POST['factura']);
	foreach($vista->resultados as $claveitem => $item)
	{
		foreach($aux as $claveauxitem => $auxitem)
		{
			if($auxitem['codigo_producto']===$item['codigo_producto'])
			{
				$vista->resultados[$claveitem]['cantidad_renglonfactura']=$vista->resultados[$claveitem]['cantidad_renglonfactura']-$auxitem['cantidad_devuelta'];
			}
		}
	}
	$vista->render();
}
