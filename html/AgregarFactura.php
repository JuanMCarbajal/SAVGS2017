<?php
// html/AgregarFactura.php

?>
	<tr>
		<td id='<?=$this->factura?>'><?=$this->factura?></td>
		<td id='mp<?=$this->factura?>'><?=$this->medio?></td>
		<td id='imp_pag_<?=$this->factura?>'><?=$this->imp_pag?></td>
		<td id='pagado_<?=$this->factura?>'><?=$this->pagado?></td>
		<td><button id='elim_<?=$this->factura?>' class='eliminar'>Quitar</button></td>
	</tr>