<?php

// controllers/confeccionardevolucion.php

require '../framework/fw.php';
require '../models/Devoluciones.php';
require '../models/Recibos.php';
require '../models/RenglonDevolucion.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

$rec=new Recibos;
$dev=new Devoluciones;
$rdev=new RenglonDevolucion;

$importeDev = $dev->crearNuevo($_POST);

$rec->CrearNuevo($importeDev, $_SESSION['cliente']);

$_POST['datosdevoluciones']=json_decode($_POST['datosdevoluciones']);

$cod_dev_aux=$dev->getUltimaDevolucion($_POST['cod_cliente']);

foreach($_POST['datosdevoluciones'] as $df)
{
	$rdev->crearNuevo($df,$cod_dev_aux);	
}

header("location:menuvendedor.php");
exit;
	
?>