<?php
// html/BuscarProductos.php

if(count($this->resultados))
{?>
<input type="hidden" value="<?=count($this->resultados)?>" id="cant-res"/>
<table class="table table-hover" >
<tr><th class="h1000px">Cod</th><th class="h1000px">Venta</th><th>Descripcion</th><th>Precio</th><th>Costo</th><th>P.V.</th><th>Proveedor</th><th>Tipo</th><th>Stock</th><th>Rep</th><th></th><th></th></tr>
<?php
	foreach($this->resultados as $item)
	{ ?>
	<tr >
		<td class="h1000px"><?=$item['codigo_producto']?></td>
		<td class="h1000px"><?=$item['en_venta']?></td>
		<td><?=$item['descripcion_producto']?></td>
		<td>$<?=round(($item['costo_producto']*($item['porcen_venta_producto']/100+1)),2)?></td>
		<td>$<?=$item['costo_producto']?></td>
		<td><?=$item['porcen_venta_producto']?>%</td>
		<td class='desc_prod'><?=$item['descripcion_proveedor']?></td>
		<td class='desc_prod'><?=$item['descripcion_tipo']?></td><td><?=$item['stock']?></td>
		<td><?=$item['pto_reposicion']?></td>
		<td class="tdmod">
			<form action="modificarproducto.php" method="post" target="_blank">
				<input type="hidden" name="codigo" value="<?=$item['codigo_producto']?>"/>
				<button type="submit" class="boton modificar" >
					<img class="img_boton" src="../img/modificar.png" alt="modificar" />
				</button>
			</form>
		</td>	
		<td class="tdelim">
			<button id="eli<?=$item['codigo_producto']?>" class="boton eliminar" >
				<img class="img_boton" src="../img/borrar.png" alt="borrar"/>
			</button>
		</td>
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