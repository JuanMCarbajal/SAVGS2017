<!-- html/NuevoMedioDePago.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Nuevo Medio de Pago');
	?>
	
	<body>
		<?php 
			$this->renderHeader('Nuevo Medio de Pago');
		?>
		<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="abmmediosdepago.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">
			
			<form id="form" action="nuevomediodepago.php" method="post" >
			<table>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="descripcion-medio-pago">Descripcion:</label>
				</td>
				<td>
				<input class="form-control" type="text" id="descripcion-medio-pago" name="descripcion-medio-pago"/>
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
			
			if(!existe("descripcion-medio-pago"))
				isValid=false;
			if(!esPalabra("descripcion-medio-pago"))
				isValid=false;				
			
			if(existeMedioPago("descripcion-medio-pago",0))
				isValid=false;
			
			if(isValid)
				if (confirm("¿Esta seguro que desea crear un nuevo medio de pago?"))
					return true;
			return false;
		});
		
			$("#cancelar").click(function (){
			if (confirm("¿Esta seguro que desea cancelar la creacion de este nuevo medio de pago?"))
				$(location).attr("href","abmmediosdepago.php");
			return false;
		});		
	</script>
</html>