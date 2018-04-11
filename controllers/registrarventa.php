<?php 
//controllers/registrarventa.php

require '../framework/fw.php';
require '../models/Clientes.php';
require '../models/Mercaderia.php';
require '../models/MediosDePago.php';
require '../views/RegistrarVenta.php';
require '../models/Proveedores.php';
require '../models/TiposProducto.php';
require '../models/Cuentas.php';

$cu = new Cuentas;
$cu->esCuenta($_SESSION['perfil'],'vendedor');

if(!isset($_SESSION['cliente']))
{
	header("Location: menuvendedor.php");
	exit;
}

$tp=new TiposProducto;
$p=new Proveedores;
$mer=new Mercaderia;
$cli=new Clientes;
$m=new MediosDePago;

$vista=new RegistrarVenta;
$vista->merc=$mer->getEnVenta();
$vista->mdp=$m->getTodosEnUso();
$vista->tipos_producto = $tp->getTodos();
$vista->proveedores = $p->getTodos();
$vista->render();



?>