<!-- html/ModificarMedioDePago.php -->

<!DOCTYPE html>
<html>	
	<?php 
		$this->renderHead('Modificar Medio de Pago');
	?>
	<body>
		<?php 
			$this->renderHeader('Modificar Medio de Pago');
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
			
			<form id="form" action="" method="post" >
				<table>
					<tr	class="form-inline">
						<td>
						<input type="hidden" name="codigo-medio-pago" id="codigo-medio-pago" value="<?= $this->medioDePago['codigo_medio_pago'] ?>" /> 
						<label class="form-control" for="descripcion-medio-pago">Descripcion:</label>
						</td>
						<td>
						<input class="form-control" type="text" id="descripcion-medio-pago" name="descripcion-medio-pago" value="<?= $this->medioDePago['descripcion_medio_pago'] ?>"/>
						</td>
					</tr>
					<tr class="form-inline">
						<td>	
						<label class="form-control" for="en-uso">En Uso:</label>
						</td>
						<td>
						<label class="form-control" for="en-uso-si">
							<input type="radio" id="en-uso-si" name="en-uso" value="Si" <?php if($this->medioDePago['medio_pago_en_uso']=='Si'){ ?> checked <?php }?>>
							Si
						</label>
						<label class="form-control" for="en-uso-no">
							<input type="radio" id="en-uso-no" name="en-uso" value="No" <?php if($this->medioDePago['medio_pago_en_uso']=='No'){ ?> checked <?php }?>>
							No
						</label>
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
			
			if(!existe("descripcion-medio-pago"))
				isValid=false;
			if(!esPalabra("descripcion-medio-pago"))
				isValid=false;				
			
			if(!radioChecked("en-uso-si","en-uso-no"))
				isValid=false;	
			
			if(existeMedioPago("descripcion-medio-pago",$("#codigo-medio-pago").val()))
				isValid=false;
			
			if(isValid)
				if (confirm("¿Esta seguro que desea modificar este medio de pago?"))
					return true;
			return false;
		})
		
			$("#cancelar").click(function (){
			if (confirm("¿Esta seguro que desea cancelar la modificacion de este medio de pago?"))
				$(location).attr("href","abmmediosdepago.php")
			return false;
		});		
	</script>
</html>