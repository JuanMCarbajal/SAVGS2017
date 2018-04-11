<?php 
// controllers/mensajescontabilidad.php

require '../framework/fw.php';
require '../models/Devoluciones.php';
require '../views/MensajesContabilidad.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'contabilidad');

$d=new Devoluciones;

if(isset($_POST['d']))
{
	$d->mensajeVisto($_POST['d']);
}
$vista = new MensajesContabilidad;
$vista->mensajesDevoluciones = $d->getMensajes();
$vista->render();


?>