<?php 
// controllers/menualmacen.php

require '../framework/fw.php';
require '../views/MenuAlmacen.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'almacen');

$vista = new MenuAlmacen;
$vista->render();

?>