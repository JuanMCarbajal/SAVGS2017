<!-- html/MenuGeneral.php -->

<!DOCTYPE html>
<html>	
	<?php 
		$this->renderHead('Menu General');
	?>
	<body>
		<?php 
			$this->renderHeader('Menu General');
		?>
		<nav>
			<div id="wrappernav">
				<ul id="navlist">	
					<li><a class="navi" href="login.php?esGeneral=1" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">
			<div>
				<h1>Bienvenido</h1>
			</div>
			<div id="wrapper2">
				<form id="form" method="post" action="menugerente.php">
					<input type="submit" class="btn btn-default" value="Menu Gerencial"/>
				</form>
				<form id="form" method="post" action="menuvendedor.php">
					<input type="submit" class="btn btn-default" value="Menu Vendedor"/>
				</form>
				<form id="form" method="post" action="menualmacen.php">
					<input type="submit" class="btn btn-default" value="Menu Almacen"/>
				</form>
			</div>
		</div>	
		<?php 
			$this->renderFooter();
		?>
	</body>
</html>
