<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Factura');
	?>
	<body>
		<?php 
			$this->renderHeader('Factura');
		?>
			<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="#" id="imprimir" >Imprimir</a></li>
					<?php
						if($this->esVenta)
						{
					?>
					<li><a class="navi" href='../controllers/menuvendedor.php'>Volver</a></li>	
					<?php
						}
						else
						{
					?>
					<li><a class="navi" href='../controllers/verfacturascliente.php'>Volver</a></li>	
					<?php
						}
					?>					
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">		
			<div id="factura">
				<pre ><h1 class="text-left"><small>FACTURA #<?=str_pad((int)$this->factura['Numero de Factura'],4,"0",STR_PAD_LEFT);?></small></h1></pre>
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
									echo "Fecha : ".$this->factura["Fecha"];								
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
							<th><h4>Nro Renglon</h4></th>
							<th><h4>Codigo</h4></th>
							<th><h4>Descripcion</h4></th>
							<th><h4>Cantidad</h4></th>
							<th><h4>Valor Unitario</h4></th>
							<th><h4>Descuento</h4></th>
							<th><h4>Total</h4></th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($this->renglonfactura as $rf)
							{
						?> 
							<tr> 
							<?php
								foreach($rf as $clave=>$dato)
									if($clave == "precio_unitario" || $clave == "precio_total"  )
										echo '<td class="text-right">$'.round($dato,2).'</td>';
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
							$<?= $this->factura["Importe Total"] ?><br/>							
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
			/*var impresion=$("#head").html()+$("#factura").html();
			var ventimp=window.open(' ','popimpr');
			ventimp.document.write(impresion);
			ventimp.document.close();
			ventimp.print();
			ventimp.close();*/		
		var contents = $("#factura").html();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>'+$("#head").html());
        frameDoc.document.write('<body>');
        //Append the DIV contents.
        frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);	
		});
	</script>	
</html>