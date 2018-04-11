<?php 

require '../framework/fw.php';
require '../models/Clientes.php';
require '../models/Cuentas.php';		
require '../views/MenuVendedor.php';
require '../models/Recibos.php';	

$cu = new Cuentas; 
$cu->esCuenta($_SESSION['perfil'],'vendedor');

$cl=new Clientes;
$r= new Recibos;
$vista=new MenuVendedor;
$_SESSION['vendedor']=$_SESSION['usuario'];
	
if(isset($_POST['num_doc']))
{
	$vista->cliente=$cl->getClienteDocumento($_POST['num_doc'],$_POST['tip_doc']);
	if(count($vista->cliente))
	{
		$_SESSION['cliente']=$vista->cliente['codigo_cliente'];
		$_SESSION['nom_cliente']=$vista->cliente['nombre_cliente'];
		$vista->saldo = $cl->getCuenta($_SESSION['cliente']);
		$vista->deuda = $r->getDeudaCliente($_SESSION['cliente']);
	}
	else
	{
		$_SESSION['cliente']=0;
		$_SESSION['nom_cliente']=null;
	}
}
if(isset($_SESSION['cliente']))
{
	if(ctype_digit($_SESSION['cliente']))
	{
	$vista->cliente=$cl->getClienteCodigo($_SESSION['cliente']);
	$_SESSION['nom_cliente']=$vista->cliente['nombre_cliente'];
	$vista->saldo = $cl->getCuenta($_SESSION['cliente']);
	$vista->deuda = $r->getDeudaCliente($_SESSION['cliente']);
	}
	
}
if(isset($_POST['cambiar']))
{
	unset($_SESSION['nom_cliente']);
	unset($_SESSION['cliente']);
}

$vista->render();

?>