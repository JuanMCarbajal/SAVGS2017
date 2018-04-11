<!-- html/InformeStock.php -->

<!DOCTYPE html>
<html>	
	<?php 
		$this->renderHead('Informe de Stock');
	?>
	<body>
		<?php 
			$this->renderHeader('Informe de Stock');
		?>
			<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="menugerente.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">			
			<?php if(count($this->informe))
			{ ?>
				<table class="table table-hover">
				<tr><th>Codigo</th><th>Descripcion</th><th>Pto. de Reposicion</th><th>En Venta</th><th>Stock</th><th>Proveedor</th><th>Tipo</th></tr>
				<?php
				foreach($this->informe as $item)
				{?>
					<tr <?php if($item['pto_reposicion']>=$item['stock']){ echo "class='reponer'"; } ?>><td><?= $item['codigo_producto'] ?></td>
					<td><?= $item['descripcion_producto'] ?></td><td><?= $item['pto_reposicion'] ?></td><td><?= $item['en_venta'] ?></td>
					<td><?= $item['stock'] ?></td><td class='desc_prod'><?=$item['descripcion_proveedor']?></td><td class='desc_prod'><?=$item['descripcion_tipo']?></td></tr>
				<?php
				}?>
				</table>
			<?php
			}
			else
			{?>
			<p> No se encuentran Productos Disponibles </p>
			<?php } ?>		
		</div>	
		<?php 
			$this->renderFooter();
		?>
	</body>
</html>