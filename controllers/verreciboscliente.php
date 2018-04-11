<?php 
//controllers/verreciboscliente.php

require '../framework/fw.php';
require '../models/Recibos.php';
require '../views/VerRecibosCliente.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

$rec=new Recibos;
$vista=new VerRecibosCliente;

$vista->recibos = $rec->getRecibosCliente($_SESSION['cliente']);

$vista->render();
?>
