<?php 
//controllers/agregar_factura.php

require '../framework/fw.php';
require '../models/Facturas.php';
require '../models/Recibos.php';
require '../models/RecibosFacturas.php';
require '../views/AgregarFactura.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

$fac=new Facturas;
$pcf=new RecibosFacturas;
$vista=new AgregarFactura;

$fac->getFacturaCodigo($_POST['factura']);
$fac_total=$fac->getImportes($_POST['factura']);
$medio=$fac_total['descripcion_medio_pago'];
$fac_total=$fac_total['importe_total_factura'];
$pagado=0;
$pagos = $pcf->getPagoFactura($_POST['factura']);
if($pagos)
{
	foreach($pagos as $pago){
	$pagado=$pagado+$pago['importe_pagado'];
	}
}
if($pagado != $_POST['imp_pag']) throw new Exception('Error1');
$fac_total=$fac_total-$pagado;
if($_POST['pagado']>$fac_total) throw new Exception('Error2');

$vista->factura=$_POST['factura'];
$vista->imp_pag=$_POST['imp_pag'];
$vista->pagado=$_POST['pagado'];
$vista->medio=$medio;

$vista->render();
?>
