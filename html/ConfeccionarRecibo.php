<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Recibo');
	?>
	<body>
		<?php 
			$this->renderHeader('Recibo');
		?>
			<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="#" id="imprimir" >Imprimir</a></li>
					<li><a class="navi" href='../controllers/verreciboscliente.php'>Volver</a></li>					
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">		
			<div id="recibo">
				<pre ><h1 class="text-left"><small>RECIBO #<?=str_pad((int)$this->recibo['Numero de Recibo'],4,"0",STR_PAD_LEFT);?></small></h1></pre>
				<div class="row">
					<div class="col-xs-5">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4>De: <?= $this->empresa["Razon Social"] ?></h4>
							</div>
							<div class="panel-body text-left">
								<?php
									foreach($this->empresa as $clave=>$dato)
									{
										if($clave != "Razon Social" && $dato != null && $dato != "")
											echo "$clave : $dato<br/>";
									}
									echo "Fecha : ".$this->recibo["Fecha"];								
								?>
							</div>
						</div>
					</div>
					<div class="col-xs-5 col-xs-offset-2 text-right">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4>Para : <?= $this->cliente["Nombre"] ?></h4>
							</div>
							<div class="panel-body text-left">
								<?php
									foreach($this->cliente as $clave=>$dato)
									{
										if($clave != "Nombre" && $dato != null && $dato != "")
											echo "$clave : $dato<br/>";
									} 
								?>
							</div>
			
						</div>
					</div>
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nro Factura</th>
							<th>Importe</th>
							<th>Medio de Pago</th>
							</tr>
					</thead>
					<tbody>
						<?php
							foreach($this->recibosfacturas as $rf)
							{
						?> 
							<tr> 
							<?php
								foreach($rf as $clave=>$dato)
									if($clave == "importe_pagado"  )
										echo '<td class="text-right">$'.$dato.'</td>';
									else
										echo "<td>$dato</td>";
							?>
							</tr>
						<?php
							}
						?>
					</tbody>
				</table>
				<pre>Sección Totales</pre>
				<div class="row text-right">
					<div class="col-xs-3 col-xs-offset-7">
						<strong>
							Total:<br/>						
						</strong>
					</div>
					<div class="col-xs-2">	
						<strong>
							$<?= round($this->recibo["Importe Total"],2) ?><br/>							
						</strong>
					</div>
				</div>
			</div>
		</div>	
		<?php 
			$this->renderFooter();
		?>		
	</body>
	<script type="text/javascript">
		$("#imprimir").click(function ()
		{
			var impresion=$("#head").html()+$("#recibo").html();
			var ventimp=window.open(' ','popimpr');
			ventimp.document.write(impresion);
			ventimp.document.close();
			ventimp.print();
			ventimp.close();
		});
	</script>	
</html>