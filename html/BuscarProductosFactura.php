<?php
// html/BuscarProductosFactura.php

if(count($this->resultados))
{?> <table class="table table-hover" id='resultados' >
	<tr><th>Nro de Factura</th><th class="1000px">Codigo</th><th>Descripcion</th><th>Precio Unit</th><th>Cantidad</th><th>Descuento</th><th>Precio U. final</th><th></th></tr>
	<?php
	foreach($this->resultados as $item)
	{ ?>
	
	<tr>
		<td class='nro_factura'><?=$item['nro_factura']?></td>
		<td class='cod_prod 1000px'><?=$item['codigo_producto']?></td>
		<td class='desc_prod'><?=$item['descripcion_producto']?></td>
		<td>$
			<span id='prec_<?=$item['codigo_producto']?>'>
				<?=ROUND($item['precio_unitario'],2)?>
			</span>
		</td>				
		<td class='cantidad' id='cant_<?=$item['codigo_producto']?>_<?=$item['nro_factura']?>'><?=$item['cantidad_renglonfactura']?></td>
		<td>%<?=$item['porcentaje']?></td>
		<td>$
			<span id='prec_<?=$item['codigo_producto']?>'>
				<?=$item['precio_final']?>
			</span>
		</td>
		<td class="form-inline"><input class="form-control precio" type='text' placeholder="cantidad" id='cdev_<?=$item['codigo_producto']?>'/></td>
		<td><button class='boton agregar' id='agregar_<?=$item['codigo_producto']?>'>Agregar</button></td>
	</tr>
<?php
	} ?>
	</table>
<?php
}else
{?>
	<p>No se encontraron resultados</p>	
<?php
} ?>