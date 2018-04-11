<?php 
//controllers/login.php

require '../framework/fw.php';
require '../Models/Cuentas.php';
require '../views/Login.php';

$vista=new Login;
$vista->error=false;

if(!isset($_GET['esGeneral']) && isset($_SESSION['perfil']) && $_SESSION['perfil'] == 'general' )
{
	header("Location: menugeneral.php");
	exit;
}

if(isset($_POST['usuario']))
{
	$c= new Cuentas;
	$datos = $c->login($_POST,$_SESSION['salt']);
	if(count($datos))
	{
		$_SESSION['usuario'] = $datos['usuario'];
		$_SESSION['perfil'] = $datos['perfil'];
		
		switch($_SESSION['perfil'])
		{
			case 'gerente' : header("Location: menugerente.php");
				exit;
			case 'vendedor' : header("Location: menuvendedor.php");
				exit;
			case 'contabilidad' : header("Location: menucontabilidad.php");
				exit;
			case 'almacen' : header("Location: menualmacen.php");
				exit;
			case 'general' : header("Location: menugeneral.php");
				exit;
		}
	}
	else
	{
		$vista->error=true;
	}
}

session_destroy();
unset($_SESSION);
session_start();
$_SESSION['salt'] = mt_rand(11111111,99999999);
$vista->render();
?>