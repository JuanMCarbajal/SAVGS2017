<?php
// html/BuscarFactura.php

if($this->resultado === false)
{ ?>
	<p>No se encontraron resultados</p>
<?php 
}
else
{ ?>
	<table class="table table-hover"  id='resultado'>
					<tr><th>Codigo Factura</th><th>Medio de Pago</th><th>Importe pagado</th><th>Importe a Pagar</th><th>Pago a Realizar</th></tr>
					<tr>
						<td id='codigofact'><?=$this->factura?></td>
						<td id='mp'><?=$this->medio?></td>
						<td id='imp_pag'>$ <?=$this->imp_pag?></td>
						<td id='a_pagar'>$ <?=$this->facturatotal?></td>
						<td><input type='text' placeholder='Ingrese pago' id='pagofactura'/></td>
						<td><button id='agregapago' class="boton">Agregar</button></td>
					</tr>
			</table>
<?php }
?>