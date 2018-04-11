<?php 
// controllers/modificarmediodepago.php

require '../framework/fw.php';
require '../models/MediosDePago.php';
require '../views/ModificarMedioDePago.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');
$m=new MediosDePago;

if(isset($_POST["codigo"]))
{	
	$mdp=$m->getPorCodigo($_POST["codigo"]);
		
	$vista=new ModificarMedioDePago;
	$vista->medioDePago=$mdp;
	$vista->render();
}
else
{
	$m->modificar($_POST);
	header("location:abmmediosdepago.php");
}


?>