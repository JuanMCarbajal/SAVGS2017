<!-- html/MenuGerente.php -->

<!DOCTYPE html>
<html>	
	<?php 
		$this->renderHead('Menu Gerente');
	?>
	<body>
		<?php 
			$this->renderHeader('Menu Gerente');
		?>		
		<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="abmproductos.php" >Gestion Mercaderia</a></li>
					<li><a class="navi" href="abmtiposproducto.php" >Gestion Tipo de Producto</a></li>
					<li><a class="navi" href="abmproveedores.php" >Gestion Proveedores</a></li>					
					<li><a class="navi" href="abmvendedores.php" >Gestion Vendedores</a></li>	
					<li><a class="navi" href="abmmediosdepago.php" >Gestion Medios de Pago</a></li>	
					<li><a class="navi" href="informestock.php" >Informe de Stock</a></li>	
					<li><a class="navi" href="informeventas.php" >Informe de Ventas</a></li>	
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">
			<div class="bienvenido">
				<h1>Bienvenido</h1>
			</div>
		</div>	
		<?php 
			$this->renderFooter();
		?>
	</body>
</html>