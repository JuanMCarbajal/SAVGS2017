<?php 
// controllers/nuevomediodepago.php

require '../framework/fw.php';
require '../models/MediosDePago.php';
require '../views/NuevoMedioDePago.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

$mdp=new MediosDePago;

if(isset($_POST["descripcion-medio-pago"]))
{	
	$mdp->crearNuevo($_POST);
	header("location:abmmediosdepago.php");
}

$vista = new NuevoMedioDePago;
$vista->render();

?>