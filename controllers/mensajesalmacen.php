<?php 
// controllers/mensajesalmacen.php

require '../framework/fw.php';
require '../models/Facturas.php';
require '../models/Devoluciones.php';
require '../views/MensajesAlmacen.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'almacen');

$f=new Facturas;
$d=new Devoluciones;
if(isset($_POST['f']))
{
	$f->mensajeVisto($_POST['f']);
}
else
	if(isset($_POST['d']))
	{
		$d->mensajeVisto($_POST['d'],true);
	}
$vista = new MensajesAlmacen;
$vista->mensajesFacturas = $f->getMensajes();
$vista->mensajesDevoluciones = $d->getMensajes(true);
$vista->render();


?>