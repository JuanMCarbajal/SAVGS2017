<?php 
// controllers/menugeneral.php

require '../framework/fw.php';
require '../views/MenuGeneral.php';
require '../models/Cuentas.php';
require '../models/Recibos.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'general');

unset($_SESSION['busqueda']);
$vista = new MenuGeneral;
$vista->render();


?>