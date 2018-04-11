<!-- html/MensajesContabilidad.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Mensajes Contabilidad');
	?>
	<body>
		<?php 
			$this->renderHeader('Mensajes Contabilidad');
		?>
		<nav>
			<div id="wrappernav">
				<ul id="navlist">				
					<li><a class="navi" href="menucontabilidad.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper" >
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
				<p><a class="navbar-brand form-control max-99" href="vermensaje.php?d=<?= $item['codigo_devolucion'] ?>&esCont=1" >Codigo de Devolucion: <?= $item['codigo_devolucion'] ?>, <?= $item['fecha_devolucion'] ?></a></p>
				<?php } ?>
			<?php	
			} ?>
		</div>
		<?php 
			$this->renderFooter();
		?>
	</body>
</html>