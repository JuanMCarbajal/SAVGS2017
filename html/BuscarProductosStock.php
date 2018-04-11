<?php
// html/BuscarProductosStock.php

if(count($this->resultados))
{?>
<table class="table table-hover" >
<tr><th class="h1000px">Codigo</th><th>Descripción</th><th>Stock</th><th>Proveedor</th><th>Tipo</th><th>Cantidad</th><th></th><th></th></tr>
<?php
	foreach($this->resultados as $item)
	{ ?>
	<tr >
		<td class="h1000px"><?=$item['codigo_producto']?></td>
		<td><?=$item['descripcion_producto']?></td>
		<td id='cant<?=$item['codigo_producto']?>'><?=$item['stock']?></td>
		<td class='desc_prod'><?=$item['descripcion_proveedor']?></td><td class='desc_prod'><?=$item['descripcion_tipo']?></td>
		<td class="form-inline"><input class="form-control precio text"  id="tex<?=$item['codigo_producto']?>" type="text" placeholder="cantidad" /></td>
		<td><input id="agr<?=$item['codigo_producto']?>" type="button" value="agregar" class="boton agregar" /></td>
		<td><input id="qui<?=$item['codigo_producto']?>" type="button" value="quitar" class="boton quitar" /></td></tr>
		<?php
		} ?>
</table>
<?php
}else
{?>
	<p>No se encontraron resultados</p>	
<?php
} ?>