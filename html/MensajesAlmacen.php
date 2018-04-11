<!-- html/MensajesAlmacen.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Mensajes Almacen');
	?>
	<body>
		<?php 
			$this->renderHeader('Mensajes Almacen');
		?>
		<nav>
			<div id="wrappernav">
				<ul id="navlist">				
					<li><a class="navi" href="menualmacen.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">			
			<h2>Nuevas Ventas:</h2>
			<?php if(!count($this->mensajesFacturas))
			{ ?>
			<p>No hay Nuevas Ventas</p>
			<?php 
			}
			else
			{ 
				foreach($this->mensajesFacturas as $item)
				{
					?>
				<p><a class="navbar-brand form-control max-99" href="vermensaje.php?f=<?= $item['nro_factura'] ?>" >Factura Nro:<?= $item['nro_factura'] ?>, <?= $item['fecha_factura'] ?></a></p>
				<?php } ?>
			<?php	
			} ?>	
			<hr/>
			<h2>Nuevas Devoluciones:</h2>
			<?php if(!count($this->mensajesDevoluciones))
			{ ?>
			<p>No hay Nuevas Devoluciones</p>
			<?php 
			}
			else
			{ 
				foreach($this->mensajesDevoluciones as $item)
				{
					?>
				<p><a class="navbar-brand form-control max-99" href="vermensaje.php?d=<?= $item['codigo_devolucion'] ?>&esCont=0" >Codigo de Devolucion: <?= $item['codigo_devolucion'] ?>, <?= $item['fecha_devolucion'] ?></a></p>
				<?php } ?>
			<?php	
			} ?>
		</div>
		<?php 
			$this->renderFooter();
		?>
	</body>
</html>