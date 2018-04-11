<!-- html/ModificarVendedor.php.php -->

<!DOCTYPE html>
<html>		
	<?php 
		$this->renderHead('Modificar Vendedor');
	?>
	<body>
		<?php 
			$this->renderHeader('Modificar Vendedor');
		?>
		<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="abmvendedores.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">
			
			<form id="form" action="" method="post" >
			<table>
			<tr class="form-inline">
				<td>
				<input type="hidden" name="codigo-vendedor" id="codigo-vendedor" value="<?= $this->vendedor['codigo_vendedor'] ?>" /> 
				<label class="form-control" for="nombres">Nombre:</label>
				</td>
				<td>
				<input class="form-control" type="text" id="nombres" name="nombre" value="<?= $this->vendedor['nombre_vendedor'] ?>"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="telefono">Telefono:</label>
				</td>
				<td>
				<input type="text" class="form-control tel" id="telefono" name="telefono" value="<?= $this->vendedor['telefono_vendedor'] ?>"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="direccion">Direccion:</label>
				</td>
				<td>
				<input class="form-control" type="text" id="direccion" name="direccion" value="<?= $this->vendedor['direccion_vendedor'] ?>"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>				
				<label class="form-control" for="localidad">Localidad:</label>
				</td>
				<td>
				<input class="form-control" type="text" id="localidad" name="localidad" value="<?= $this->vendedor['localidad_vendedor'] ?>"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="fecha-inicio">Fecha de Contrato:</label>
				</td>
				<td>
				<input type="text" class="form-control fecha" id="fecha-inicio" name="fecha-inicio" placeholder="dd/mm/aaaa"  value="<?= $this->vendedor['f_inic'] ?>"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="fecha-nac">Fecha de Nacimiento:</label>
				</td>
				<td>
				<input type="text" class="form-control fecha" id="fecha-nac" name="fecha-nac" placeholder="dd/mm/aaaa"  value="<?= $this->vendedor['f_nac'] ?>"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="tipo-documento">Tipo de Documento:</label>
				</td>
				<td>
				<select class="form-control" id="tipo-documento" name="tipo-documento">
				<?php foreach($this->tiposDoc as $item)
				{ ?>
					<option value="<?=$item['codigo_tipo_documento'] ?>" <?php if($this->vendedor['codigo_tipo_documento']==$item['codigo_tipo_documento']){ ?> selected <?php }?>> <?=$item['descripcion_tipo_documento'] ?></option>
				<?php } ?>
				</select>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="nro-documento">Nro. de Documento:</label>
				</td>
				<td>
				<input type="text" class="form-control documento"  id="nro-documento" name="nro-documento" value="<?= $this->vendedor['nro_documento_vendedor'] ?>"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="cuil">CUIL:</label>
				</td>
				<td>
				<input type="text" class="form-control cuil"  id="cuil" name="cuil" value="<?= $this->vendedor['cuil_vendedor'] ?>"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="sexo">Sexo:</label>
				</td>
				<td>
				<label class="form-control" for="sexo-f">
					<input type="radio" name="sexo" id="sexo-f" value="F" <?php if($this->vendedor['sexo_vendedor']=='F'){ ?> checked <?php }?>>
					Femenino
				</label>
				<label class="form-control" for="sexo-m">
					<input type="radio" name="sexo" id="sexo-m" value="M" <?php if($this->vendedor['sexo_vendedor']=='M'){ ?> checked <?php }?>>				
					Masculino
				</label>
				</td>
			</tr>
			</table>
				<br/>		
				<input class="btn btn-default" type="submit" value="Modificar" />
				<button class="btn btn-default" id="cancelar" >Cancelar </button>
			</form>
		</div>
		<footer id="backfoot">
			<div><p>&copy;2015 S.A.V.G.S.</p></div>
			<div><p>Todos los derechos Reservados</p></div>
		</footer>
	</body>
	<script>		
		$("#form").submit( function(){
			
			var isValid=true;
			
			if(!existe("nombres"))
				isValid=false;
			if(!esNombre("nombres"))
				isValid=false;
			
			if(!esDigito("telefono"))
				isValid=false;	
			
			if(!esPalabra("direccion"))
				isValid=false;
			
			if(!esPalabra("localidad"))
				isValid=false;
			
			if(!esFecha("fecha-inicio"))
				isValid=false;
			
			if(!esFecha("fecha-nac"))
				isValid=false;
			
			if(!esDigito("cuil"))
				isValid=false;				
				
			if(!existe("nro-documento"))
				isValid=false;
			if(!esDigito("nro-documento"))
				isValid=false;	
				
			if(!radioChecked("sexo-f","sexo-m"))
				isValid=false;
			
			if(existeVendedor("nro-documento","tipo-documento","cuil",$("#codigo-vendedor").val()))
				isValid=false;
			
			if(isValid)
				if (confirm("¿Esta seguro que desea modificar este vendedor?"))
					return true;
			return false;
		})
		
		$("#cancelar").click(function (){
			if (confirm("¿Esta seguro que desea cancelar la modificacion de este vendedor?"))
				$(location).attr("href","abmvendedores.php");
			return false;
		});
	</script>	
</html>