<?php 
// controllers/modificarvendedor.php

require '../framework/fw.php';
require '../models/Vendedores.php';
require '../models/TiposDocumento.php';
require '../views/ModificarVendedor.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'gerente');

$v=new Vendedores;
$td=new TiposDocumento;

if(isset($_POST["codigo"]))
{		
	$vendedor=$v->getPorCodigo($_POST["codigo"]);
		
	$vista=new ModificarVendedor;
	$vista->tiposDoc = $td->getTodos();
	$vista->vendedor=$vendedor;
	$vista->render();
}
else
{
	try
	{
		if(strlen($_POST['fecha-inicio']))
		{
			$dia=substr($_POST['fecha-inicio'],0,2);
			$mes=substr($_POST['fecha-inicio'],3,2);
			$ano=substr($_POST['fecha-inicio'],6,4);
			$_POST['fecha-inicio']=$ano."-".$mes."-".$dia;
		}
		if(strlen($_POST['fecha-nac']))
		{
			$dia=substr($_POST['fecha-nac'],0,2);
			$mes=substr($_POST['fecha-nac'],3,2);
			$ano=substr($_POST['fecha-nac'],6,4);
			$_POST['fecha-nac']=$ano."-".$mes."-".$dia;
		}
		$v->modificar($_POST,$td);
		header("location:abmvendedores.php");
	}
	catch (Exception $e) 
	{
		echo 'Excepción capturada: ',  $e->getMessage(), "\n";
	}
}


?>