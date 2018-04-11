<?php
// html/BuscarVendedores.php

if(count($this->resultados))
{?>
<input type="hidden" value="<?=count($this->resultados)?>" id="cant-res"/>
<table class="table table-hover" >
<tr>
	<th class="h1300px">Codigo</th>
	<th>Nombre</th>
	<th class="h1000px">Telefono</th>
	<th>Direccion</th>
	<th class="h1000px">Localidad</th>
	<th class="h1000px">Fecha de Contrato</th>
	<th>Fecha de Nacimiento</th>
	<th>Tipo de Documento</th>
	<th>Nro. de Documento</th>
	<th class="h1300px">CUIL</th>
	<th>Sexo</th>
	<th></th>
	<th></th>
</tr>
<?php
	foreach($this->resultados as $item)
	{ ?>
<tr >
	<td class="h1300px"><?=$item['codigo_vendedor']?></td>
	<td><?=$item['nombre_vendedor']?></td>
	<td class="h1000px"><?=$item['telefono_vendedor']?></td>
	<td class="direc" ><?=$item['direccion_vendedor']?></td>
	<td class="h1000px"><?=$item['localidad_vendedor']?></td>
	<td class="h1000px"><?=$item['f_inic']?></td>
	<td><?=$item['f_nac']?></td>
	<td><?=$item['descripcion_tipo_documento']?></td>
	<td><?=$item['nro_documento_vendedor']?></td>
	<td class="h1300px"><?=$item['cuil_vendedor']?></td>
	<td><?=$item['sexo_vendedor']?></td>		
	<td class="tdmod">
		<form action="modificarvendedor.php" method="post">
			<input type="hidden" name="codigo" value="<?=$item['codigo_vendedor']?>"/>
			<button type="submit" class="boton modificar" >
				<img class="img_boton" src="../img/modificar.png" alt="modificar"/>
			</button>
		</form>
	</td>
	<td id="tdelim">
		<button id="eli<?=$item['codigo_vendedor']?>" class="boton eliminar" >
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