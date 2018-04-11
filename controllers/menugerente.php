<?php 
// controllers/menugerente.php

require '../framework/fw.php';
require '../views/MenuGerente.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

unset($_SESSION['busqueda']);
$vista = new MenuGerente;
$vista->render();

?>