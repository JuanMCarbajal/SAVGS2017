<?php
// html/AgregarProductoFactura.php
$this->item['precio_venta'] = round($this->item['precio_venta'],2);
?>

<tr id='<?=$this->item['codigo_producto']?>'>
	<td class="h1000px"><?=$this->item['codigo_producto']?></td>
	<td><?=$this->item['descripcion_producto']?></td>
	<td>$
		<span id='precunit_<?=$this->item['codigo_producto']?>'>
			<?=round($this->item['precio_venta'],2)?>
		</span>
	</td>
	<td id='cantres_<?=$this->item['codigo_producto']?>'><?=$this->cantidad?></td>
	<td>$
		<span id='prectotal_<?=$this->item['codigo_producto']?>'>
		<?=round(round($this->item['precio_venta']*$this->cantidad,2)*(1-$this->descuento/100),2)?>
		</span>
	</td>
	<td id="descuento_<?=$this->item['codigo_producto']?>"><?=$this->descuento?></td>
	<td><button id='elim_<?=$this->item['codigo_producto']?>' class='boton eliminar'>Quitar</button></td>
</tr>