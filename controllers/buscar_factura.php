<?php 
//controllers/agregar_factura.php

require '../framework/fw.php';
require '../models/Facturas.php';
require '../models/Recibos.php';
require '../models/RecibosFacturas.php';
require '../views/BuscarFactura.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

$fac=new Facturas;
$pcf=new RecibosFacturas;
$vista=new BuscarFactura;

$facturatotal = $fac->getImportes($_POST['factura']);
$mediospago = $facturatotal['descripcion_medio_pago'];
$facturatotal = $facturatotal['importe_total_factura'];
$importe_pagado = 0;
$pagos = $pcf->getPagoFactura($_POST['factura']);
if($pagos)
{
	foreach($pagos as $pago){
	$importe_pagado=$importe_pagado+$pago['importe_pagado'];
	}
}
$facturatotal=$facturatotal-$importe_pagado;



if($importe_pagado==0 && $facturatotal==0)
{
	$vista->resultado=false;
	$vista->render();
}
else
{
	$vista->resultado=true;
	$vista->factura=$_POST['factura'];
	$vista->imp_pag=$importe_pagado;
	$vista->facturatotal=$facturatotal;
	$vista->medio=$mediospago;
	$vista->render();
}

?>