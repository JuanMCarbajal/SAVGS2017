<?php

// controllers/registrardevolucion.php

require '../framework/fw.php';
require '../models/Facturas.php';
require '../models/Devoluciones.php';
require '../models/RenglonDevolucion.php';
require '../models/MediosDePago.php';
require '../views/RegistrarDevolucion.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

if(!isset($_SESSION['cliente']))
{
	header("Location: menuvendedor.php");
	exit;
}

$vista=new RegistrarDevolucion;
$vista->render();

?>