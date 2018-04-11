<?php 
// controllers/nuevovendedor.php

require '../framework/fw.php';
require '../models/Vendedores.php';
require '../models/TiposDocumento.php';
require '../models/Cuentas.php';
require '../views/NuevoVendedor.php';

$c = new Cuentas;
$c->esCuenta($_SESSION['perfil'],'gerente');

$cli=new Vendedores;
$td=new TiposDocumento;

if(isset($_POST["nombre"]))
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
		$nuevo=$cli->crearNuevo($_POST,$td);
		$_SESSION['busqueda']=$nuevo['codigo_vendedor'];	
		$tipo = $td->getPorCodigo($nuevo['codigo_tipo_documento']);
		$_SESSION['cuentaNueva'] = $c->crearCuenta($nuevo['codigo_vendedor'],$tipo['descripcion_tipo_documento'],$nuevo['nro_documento_vendedor'],'vendedor');
		header("location:abmvendedores.php");
	}
	catch (Exception $e) 
	{
		echo 'Excepción capturada: ',  $e->getMessage(), "\n";
	}
}

$vista = new NuevoVendedor;
$vista->tiposDoc = $td->getTodos();
$vista->render();
?>