<?php 
// controllers/informestock.php

require '../framework/fw.php';
require '../models/Mercaderia.php';
require '../views/InformeStock.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

$m=new Mercaderia;

$vista = new InformeStock;
$vista->informe = $m->InformeStock();
$vista->render();

?>