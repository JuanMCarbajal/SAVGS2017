
<!-- html/VerFacturasCliente.php -->

<!DOCTYPE html>
<html>	
	<?php 
		$this->renderHead('Facturas');
	?>
	<body>
		<?php 
			$this->renderHeader('Facturas');
		?>
		<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href='../controllers/menuvendedor.php'>Volver</a></li>					
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">	
		<?php
		if(count($this->facturas))
		{
		?>
		<table class="table table-hover">
		<tr><th>Nro</th><th>Medio de pago</th><th>Imp. total</th><th>Imp. pagado</th><th>Imp. deudor</th><th></th></tr>
		<?php
			foreach($this->facturas as $factura)
			{
		?>
				<tr>
						<td><?=$factura["nro_factura"]?></td>
						<td><?=$factura["descripcion_medio_pago"]?></td>
						<td>$<?=round($factura["importe_total_factura"],2)?></td>
						<td>$<?=round($factura["importe_pagado"],2)?></td>
						<td>$<?=round($factura["importe_total_factura"]-$factura["importe_pagado"],2)?></td>
						<td>
							<form action="confeccionarfactura.php" method="post" >
								<input type="hidden" value="<?=$factura["nro_factura"]?>" name="num_factura" />
								<input type="submit" class="boton" value="Ver"/>
							</form>
						</td>
				</tr>
		<?php
			}
		?>
		</table>
		<?php
		}
		else
		{
		?>
			<p>No presenta facturas en el sistema</p>	
		<?php
		}
		?>
		</div>	
		<?php 
			$this->renderFooter();
		?>
	</body>
</html>