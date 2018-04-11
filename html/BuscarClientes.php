<?php
// html/BuscarClientes.php

if(count($this->resultados))
{?>
<input type="hidden" value="<?=count($this->resultados)?>" id="cant-res"/>
<table class="table table-hover">
<tr><th>Nombre</th><th>Tipo Doc.</th><th>Num. Doc.</th><th></th></tr>
<?php
	foreach($this->resultados as $item)
	{ ?>
	<tr ><td><?=$item['nombre_cliente']?></td><td><?=$item['descripcion_tipo_documento']?></td><td id="doc<?=$item['codigo_cliente']?>" ><?=$item['nro_documento_cliente']?></td>
	<td><input data-tip-doc="<?=$item['codigo_tipo_documento']?>" class="boton agregar" id="agr<?=$item['codigo_cliente']?>" type="button" value="ingresar" /></td></tr>
<?php
	} ?>
</table>
<?php
}else
{?>
	<p>No se encontraron resultados</p>	
<?php
} ?>