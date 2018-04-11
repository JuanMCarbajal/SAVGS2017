<!-- html/InformeVentas.php -->
<!DOCTYPE html>
<html>	
	<?php 
		$this->renderHead('Informe Ventas');
	?>
	<body>	
		<?php 
			$this->renderHeader('Informe Ventas');
		?>
		<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="menugerente.php">Volver</a></li>
					<li><a class="navi" href="<?='informeventas'.date('d-m-y').'.xlsx'?>"  >Descargar excel</a>		</li>
					<li><a class="navi" href="#" id="imprimir" >Imprimir</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">	
		<?php
		if(count($this->clientes))
		{?>			
		
					<div id="informe">
						<table class="table table-hover">
						<tr>
							<th>Codigo</th>
							<th>Nombre</th>		
							<th>Deuda Inicial</th>
							<th>Deuda Semanal</th>					
							<th>Deuda Total</th>
							<th class="pagado">Pagado</th>
						</tr>
						<?php
						foreach($this->clientes as $item)
						{?>
							<tr>
								<td><?=$item['codigo_cliente']?></td>
								<td><?=$item['nombre_cliente']?></td>
								<td>$<?=round($item['deuda_general']-$item['deuda_semanal'],2)?></td>
								<td>$<?=round($item['deuda_semanal'],2)?></td>
								<td>$<?=round($item['deuda_general'],2)?></td>
								<td></td>
							</tr>
						<?php
						}?>
						</table>
					</div>
		<?php
		}
		else
		{
			echo "<p>No se encuentran Clientes</p>";
		}
		?>
		</div>
		<?php 
			$this->renderFooter();
		?>
	</body>
	<script type="text/javascript">
		$("#imprimir").click(function ()
		{
			var impresion=$("#head").html()+$("#informe").html();
			var ventimp=window.open(' ','popimpr');
			ventimp.document.write(impresion);
			ventimp.document.close();
			ventimp.print();
			ventimp.close();
		});
	</script>
</html>