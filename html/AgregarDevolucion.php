<?php
// html/AgregarDevolucion.php

?>
	<tr id='<?=$this->item['codigo_producto']."_$this->factura"?>'>
		<td><?=$this->factura?></td>
		<td><?=$this->item['codigo_producto']?></td>
		<td><?=$this->item['descripcion_producto']?></td>
		<td id='cantrf_<?=$this->item['codigo_producto']."_$this->factura"?>'><?=$this->item['cantidad_renglonfactura']?></td>
		<td id='cantdev_<?=$this->item['codigo_producto']."_$this->factura"?>'><?=$this->cant?></td>
		<td id='unitdev_<?=$this->item['codigo_producto']."_$this->factura"?>'><?=$this->item['precio_final']?></td>
		<td id='precdev_<?=$this->item['codigo_producto']."_$this->factura"?>'>
		<?php $this->cant=ROUND($this->cant*$this->item['precio_final'],2);
				echo $this->cant;?></td>
		<td><button id='elim_<?=$this->item['codigo_producto']."_$this->factura"?>' class='boton eliminar'>Quitar</button></td>
	</tr>
