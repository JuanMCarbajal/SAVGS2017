<?php 
// controllers/modificartipoproducto.php

require '../framework/fw.php';
require '../models/TiposProducto.php';
require '../views/ModificarTipoProducto.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

$m=new TiposProducto;

if(isset($_POST["codigo"]))
{	
	$mdp=$m->getPorCodigo($_POST["codigo"]);
		
	$vista=new ModificarTipoProducto;
	$vista->tipoProducto=$mdp;
	$vista->render();
}
else
{
	$m->modificar($_POST);
	header("location:abmtiposproducto.php");
}


?>