<?php
// html/BuscarProductosVentas.php

if(count($this->resultados))
{?> <table class="table table-hover"  id='resultados'>
	<tr>
		<th class="h1000px">Codigo</th>
		<th>Descripcion</th>
		<th>Precio</th>
		<th>Cantidad</th>
		<th>Proveedor</th>
		<th>Tipo</th>
		<th>Cantidad a vender</th>
		<th></th>
		<th></th>
	</tr>
	<?php
	foreach($this->resultados as $item)
	{ ?>
	
	<tr>
		<td class='h1000px cod_prod'><?=$item['codigo_producto']?></td>
		<td class='desc_prod'><?=$item['descripcion_producto']?></td>
		<td class='precio'>$<span id='prec_<?=$item['codigo_producto']?>'><?=round(($item['costo_producto']*($item['porcen_venta_producto']/100+1)),2)?></span></td>
		<td class='stock' id='cantbus_<?=$item['codigo_producto']?>'><?=$item['stock']?></td>
		<td class='desc_prod'><?=$item['descripcion_proveedor']?></td><td class='desc_prod'><?=$item['descripcion_tipo']?></td>
		<td class="form-inline"><input class="form-control precio" type='text' placeholder="cantidad" id='cant_<?=$item['codigo_producto']?>'/></td>
		<td >%<span class="form-inline"><input class="form-control precio" type='text' placeholder="descuento" value="0" id='desc_<?=$item['codigo_producto']?>'/></span></td>
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