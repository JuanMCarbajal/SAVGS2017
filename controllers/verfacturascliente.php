<?php 
//controllers/verfacturascliente.php

require '../framework/fw.php';
require '../models/Facturas.php';
require '../views/VerFacturasCliente.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

$fac=new Facturas;
$vista=new VerFacturasCliente;

$vista->facturas = $fac->getFacturasCliente($_SESSION['cliente']);

$vista->render();
?>
