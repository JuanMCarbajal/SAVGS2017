<!-- html/NuevoVendedor.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Nuevo Vendedor');
	?>	
	<body>	
		<?php 
			$this->renderHeader('Nuevo Vendedor');
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
			
			<form id="form" action="nuevovendedor.php" method="post" >
			<table>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="nombres">Nombre:</label>
				</td>
				<td>
				<input type="text" class="form-control" id="nombres" name="nombre"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="telefono">Telefono:</label>
				</td>
				<td>
				<input type="text" class="form-control tel" id="telefono" name="telefono"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="direccion">Direccion:</label>
				</td>
				<td>
				<input type="text" class="form-control" id="direccion" name="direccion"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>				
				<label class="form-control" for="localidad">Localidad:</label>
				</td>
				<td>
				<input type="text" class="form-control" id="localidad" name="localidad"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="fecha-inicio">Fecha de Contrato:</label>
				</td>
				<td>
				<input type="text" class="form-control fecha" id="fecha-inicio" name="fecha-inicio" placeholder="dd/mm/aaaa" />
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="fecha-nac">Fecha de Nacimiento:</label>
				</td>
				<td>
				<input type="text" class="form-control fecha" id="fecha-nac" name="fecha-nac" placeholder="dd/mm/aaaa" />
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
					<option value="<?=$item['codigo_tipo_documento'] ?>"> <?=$item['descripcion_tipo_documento'] ?></option>
				<?php } ?>
				</select>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="nro-documento">Nro. de Documento:</label>
				</td>
				<td>
				<input type="text" class="form-control documento" id="nro-documento" name="nro-documento"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="cuil">CUIL:</label>
				</td>
				<td>
				<input type="text" id="cuil" class="form-control cuil" name="cuil"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="sexo">Sexo:</label>
				</td>
				<td>
				<label class="form-control" for="sexo-f"><input type="radio" name="sexo" id="sexo-f" value="F">Femenino</label>
				<label class="form-control" for="sexo-m"><input type="radio" name="sexo" id="sexo-m" value="M">Masculino</label>
				</td>
			</tr>
			</table>	
				<br/>		
				<input class="btn btn-default" type="submit" value="Crear" />
				<button class="btn btn-default" id="cancelar" >Cancelar </button>
			</form>
		</div>
		<?php 
			$this->renderFooter();
		?>
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
			
			if(existeVendedor("nro-documento","tipo-documento","cuil",0))
				isValid=false;
			
			if(isValid)
				if (confirm("¿Esta seguro que desea crear un nuevo vendedor?"))
					return true;
			return false;
		})
	
		$("#cancelar").click(function (){
			if (confirm("¿Esta seguro que desea cancelar la creacion de este nuevo vendedor?"))
				$(location).attr("href","abmvendedores.php");
			return false;
		});
	</script>
</html>