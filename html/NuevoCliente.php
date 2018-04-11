<!-- html/NuevoCliente.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Nuevo Cliente');
	?>
	<body>
		<?php 
			$this->renderHeader('Nuevo Cliente');
		?>
		<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href='../controllers/menuvendedor.php'>Volver</a></li>				
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>			
		</nav>
		<div id="wrapper">
			
			<form id="form" action="" method="post" >
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
				<label class="form-control" for="sexo">Sexo:</label>
				</td>
				<td>
				<label class="form-control" for="sexo-f"><input type="radio" name="sexo" id="sexo-f" value="F">Femenino</label>
				<label class="form-control" for="sexo-m"><input type="radio" name="sexo" id="sexo-m" value="M">Masculino</label>
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
				<label class="form-control" for="localidad" >Localidad:</label>
				</td>
				<td>
				<input type="text" class="form-control" id="localidad" name="localidad"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="codigo-postal">Codigo Postal:</label>
				</td>
				<td>
				<input type="text" class="form-control cp" id="codigo-postal" name="codigo-postal"/>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="tipo-documento">Tipo de Documento:</label>
				</td>
				<td>
				<select id="tipo-documento" class="form-control" name="tipo-documento">
				<?php foreach($this->tipo_doc as $item)
				{ ?>
					<option value="<?=$item['codigo_tipo_documento'] ?>"> <?=$item['descripcion_tipo_documento'] ?></option>
				<?php } ?>
				</select>
				</td>
			</tr>
			<tr class="form-inline">
				<td>
				<?php //var_dump($this->Clientes);	?>
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
				<input type="text" class="form-control cuil" id="cuil" name="cuil"/>
				</td>
			</tr>
			</table>
				<br/>
				<input type="submit" class="btn btn-default" value="Crear" />
				<button id="cancelar" class="btn btn-default">Cancelar </button>
			</form>
		</div>
		<?php 
			$this->renderFooter();
		?>		
	</body>
	<script>	
	
		$(function() {
			$("#nro-documento").val(parseInt(Math.random()*100000000));
		});
		
		$("#form").submit( function(){
			var isValid=true;
			
			if(!existe("nombres"))
				isValid=false;
			if(!esNombre("nombres"))
				isValid=false;
			
			if(!radioChecked("sexo-f","sexo-m"))
				isValid=false;
			
			if(!esDigito("telefono"))
				isValid=false;	
			
			if(!esPalabra("direccion"))
				isValid=false;
			
			if(!esPalabra("localidad"))
				isValid=false;
			
			if(!esDigito("codigo-postal"))
				isValid=false;	
			
			if(!existe("nro-documento"))
				isValid=false;
			if(!esDigito("nro-documento"))
				isValid=false;
			
			if(!esDigito("cuil"))
				isValid=false;
			
			if(existeCliente("nro-documento","tipo-documento","cuil",0))
				isValid=false;
			
			if(isValid)
			{
				if(confirm("Esta seguro que desea crear un nuevo cliente?"))
				{
					return true;
				}							
			}	
			return false;	
			
		})
		$("#cancelar").click(function ()
		{
			if(confirm("¿Esta seguro que desea cancelar el ingreso de este cliente?"))
			{
				$(location).attr("href","menuvendedor.php");
			}
			return false;
		});
	</script>
</html>