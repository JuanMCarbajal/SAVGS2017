<?php 
//controllers/agregar_devolucion.php

require '../framework/fw.php';
require '../models/RenglonFactura.php';
require '../views/AgregarDevolucion.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

$vista=new AgregarDevolucion;
$rf=new RenglonFactura;
$vista->item=$rf->getRenglonFactura($_POST['factura'],$_POST['id_prod'],$_POST['cant']);
$vista->factura=$_POST['factura'];
$vista->cant=$_POST['cant'];
$vista->render();
?>