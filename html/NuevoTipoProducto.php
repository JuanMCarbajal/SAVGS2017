<!-- html/NuevoMedioDePago.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Nuevo Tipo de Producto');
	?>
	<body>
		<?php 
			$this->renderHeader('Nuevo Tipo de Producto');
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
			
			<form id="form" action="nuevotipoproducto.php" method="post" >
			<table>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="descripcion-tipo">Descripcion:</label>
				</td>
				<td>
				<input type="text" class="form-control" id="descripcion-tipo" name="descripcion-tipo"/>
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
			
			if(!existe("descripcion-tipo"))
				isValid=false;
			if(!esPalabra("descripcion-tipo"))
				isValid=false;				
			
			if(existeTipoProducto("descripcion-tipo",0))
				isValid=false;
			
			if(isValid)
				if (confirm("¿Esta seguro que desea crear un nuevo tipo de producto?"))
					return true;
			return false;
		});
		
			$("#cancelar").click(function (){
			if (confirm("¿Esta seguro que desea cancelar la creacion de este nuevo tipo de producto?"))
				$(location).attr("href","abmtiposproducto.php");
			return false;
		});
	</script>
</html>