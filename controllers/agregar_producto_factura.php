<?php 
//controllers/agregar_producto_factura.php

require '../framework/fw.php';
require '../models/Mercaderia.php';
require '../views/AgregarProductoFactura.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

$vista=new AgregarProductoFactura;
$merc=new Mercaderia;
$vista->item=$merc->getParaVenta($_POST['codigo'],$_POST['cantidad']);
$vista->cantidad=$_POST['cantidad'];
$vista->descuento=$_POST['descuento'];
$vista->render();
?>