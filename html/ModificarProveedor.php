<!-- html/ModificarProveedor.php -->

<!DOCTYPE html>
<html>	
	<?php 
		$this->renderHead('Modificar Proveedor');
	?>
	<body>
		<?php 
			$this->renderHeader('Modificar Proveedor');
		?>
			<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="abmproveedores.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">
			
			<form id="form" action="" method="post" >
				<table>
					<tr class="form-inline">
						<td>
						<input class="form-control" type="hidden" name="codigo-proveedor" id="codigo-proveedor" value="<?= $this->Proveedor['codigo_proveedor'] ?>" /> 
						<label class="form-control" for="descripcion-proveedor">Descripcion:</label>
						</td>
						<td>
						<input class="form-control" type="text" id="descripcion-proveedor" name="descripcion-proveedor" value="<?= $this->Proveedor['descripcion_proveedor']?>"/>
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
			
			if(!existe("descripcion-proveedor"))
				isValid=false;
			if(!esPalabra("descripcion-proveedor"))
				isValid=false;					
			
			if(existeMedioPago("descripcion-proveedor",$("#codigo-proveedor").val()))
				isValid=false;
			
			if(isValid)
				if (confirm("¿Esta seguro que desea modificar este proveedor?"))
					return true;
			return false;
		})
		
			$("#cancelar").click(function (){
			if (confirm("¿Esta seguro que desea cancelar la modificacion de este proveedor?"))
				$(location).attr("href","abmproveedores.php")
			return false;
		});		
	</script>
</html>