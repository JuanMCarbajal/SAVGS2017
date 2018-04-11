<?php 
// controllers/buscarproductos.php

require '../framework/fw.php';
require '../models/Mercaderia.php';
require '../views/BuscarProductos.php';

if($_SESSION['perfil']!='almacen' 
	&& $_SESSION['perfil']!='gerente'
	&& $_SESSION['perfil']!='general')
{
	header("Location: login.php");
	exit;
}


if(isset($_POST["busqueda"]))
{	
	$m=new Mercaderia;	
	$_SESSION['busqueda']=$_POST["busqueda"];
	$res=$m->buscar($_POST["busqueda"], false, $_POST["proveedor"], $_POST["tipo"]);
	
	$vista=new BuscarProductos;
	$vista->resultados=$res;
	$vista->render();
}

?>