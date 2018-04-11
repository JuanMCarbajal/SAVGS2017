<!-- html/ModificarMedioDePago.php -->

<!DOCTYPE html>
<html>	
	<?php 
		$this->renderHead('Modificar Tipo de Producto');
	?>
	<body>
		<?php 
			$this->renderHeader('Modificar Tipo de Producto');
		?>
			<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="abmtiposproducto.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">
			
			<form id="form" action="" method="post" >
			<table>
			<tr class="form-inline">
				<td>
				<input class="form-control" type="hidden" name="codigo-tipo-producto" id="codigo-tipo-producto" value="<?= $this->tipoProducto['codigo_tipo_producto'] ?>" /> 
				<label class="form-control" for="descripcion-tipo">Descripcion:</label>
				</td>
				<td>
				<input class="form-control" type="text" id="descripcion-tipo" name="descripcion-tipo" value="<?= $this->tipoProducto['descripcion_tipo'] ?>"/>
				</td>
			</tr>
			</table>
			<br/>
			<input class="btn btn-default" type="submit" value="Modificar" />
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
			
			if(!existe("descripcion-tipo"))
				isValid=false;
			if(!esPalabra("descripcion-tipo"))
				isValid=false;					
			
			if(existeTipoProducto("descripcion-tipo",$("#codigo-tipo-producto").val()))
				isValid=false;
			
			if(isValid)
				if (confirm("¿Esta seguro que desea modificar este tipo de producto?"))
					return true;
			return false;
		})
		
			$("#cancelar").click(function (){
			if (confirm("¿Esta seguro que desea cancelar la modificacion de este tipo de producto?"))
				$(location).attr("href","abmtiposproducto.php")
			return false;
		});
	
	</script>
</html>