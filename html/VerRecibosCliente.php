<!-- html/VerRecibosCliente.php -->

<!DOCTYPE html>
<html>	
	<?php 
		$this->renderHead('Recibos');
	?>
	<body>
		<?php 
			$this->renderHeader('Recibos');
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
		if(count($this->recibos))
		{
		?>
		<table class="table table-hover">
		<tr><th>Nro</th><th>Fecha</th><th>Importe</th><th></th></tr>
		<?php
			foreach($this->recibos as $recibo)
			{
		?>
				<tr>
						<td><?=$recibo["nro_recibo"]?></td>
						<td><?=$recibo["fecha_recibo"]?></td>
						<td>$<?=round($recibo["importe_recibo"],2)?></td>
						<td>
							<form action="confeccionarrecibo.php" method="post" >
								<input type="hidden" value="<?=$recibo["nro_recibo"]?>" name="num_recibo" />
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
			<p>No presenta recibos en el sistema</p>	
		<?php
		}
		?>
		</div>	
		<?php 
			$this->renderFooter();
		?>
	</body>
</html>