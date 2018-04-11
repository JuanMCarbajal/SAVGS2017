<!-- html/MenuAlmacen.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Menu Almacen');
	?>	
	<body>
		<?php 
			$this->renderHeader('Menu Almacen');
		?>

		<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="modificarstock.php" >Gestion de Stock</a></li>
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