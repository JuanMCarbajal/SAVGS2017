<!-- html/ModificarProducto.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Modificar Producto');
	?>
	<body>
		<?php 
			$this->renderHeader('Modificar Producto');
		?>
			<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="abmproductos.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">
			
			<form id="form" action="modificarproducto.php" method="post" >
				<table>
					<tr class="form-inline">
						<td>
						<input type="hidden" name="codigo-producto" id="codigo-producto" value="<?= $this->producto['codigo_producto'] ?>" /> 
						<label class="form-control" for="descripcion-producto">Descripcion:</label>
						</td>
						<td>
						<input class="form-control" type="text" id="descripcion-producto" name="descripcion-producto" value="<?= $this->producto['descripcion_producto'] ?>"/>
						</td>
					</tr>
					<tr class="form-inline">
						<td>
							<label class="form-control" for="costo-producto" >Costo del producto:</label>
						</td>
						<td>
							$<input type="text" class="form-control precio" id="costo-producto" name="costo-producto" value="<?= $this->producto['costo_producto'] ?>"/>
							</td>
					</tr>			
					<tr class="form-inline">
						<td>
							<label class="form-control" for="porcen-venta-producto" >Porcentaje de Venta:</label>
						</td>
						<td>
							%<input type="text" class="form-control precio" id="porcen-venta-producto" name="porcen-venta-producto" value="<?= $this->producto['porcen_venta_producto'] ?>"/>
							</td>
					</tr>
					<tr class="form-inline">
						<td>			
						<label class="form-control" for="precio-venta">Precio de Venta:</label>
						</td>
						<td>
						$<input type="text" class="form-control precio" id="precio-venta" name="precio-venta" />
						</td>
					</tr>
					<tr class="form-inline">
						<td>
						<label class="form-control" for="pto-reposicion">Punto de Reposicion:</label>
						</td>
						<td>
						<input type="text" class="form-control cp" id="pto-reposicion" name="pto-reposicion" value="<?= $this->producto['pto_reposicion'] ?>"/>
						</td>
					</tr>
					<tr class="form-inline">
						<td>
						<label class="form-control" for="stock">Stock:</label>
						</td>
						<td>
						<input type="text" class="form-control cp" id="stock" name="stock" value="<?= $this->producto['stock'] ?>"/>			
						</td>
					</tr>
					<tr class="form-inline">
						<td>
							<label class="form-control" for="en-venta">En Venta:</label>
						</td>
						<td>
							<label class="form-control" for="en-venta-si">
								<input type="radio" id="en-venta-si" name="en-venta" value="Si" <?php if($this->producto['en_venta']=='Si'){ ?> checked <?php }?>>
								Si
							</label>
							<label class="form-control" for="en-venta-no">
								<input type="radio" id="en-venta-no" name="en-venta" value="No" <?php if($this->producto['en_venta']=='No'){ ?> checked <?php }?>>
								No
							</label>
							</td>
					</tr>
					<tr class="form-inline">
						<td>
						<label class="form-control" for="codigo-tipo-producto">Tipo de Producto:</label>
						</td>
						<td>
						<select class="form-control" id="codigo-tipo-producto" name="codigo-tipo-producto">
						<?php foreach($this->tipos_producto as $item)
						{ ?>
							<option value="<?=$item['codigo_tipo_producto'] ?>"> <?=$item['descripcion_tipo'] ?></option>
						<?php } ?>
						</select>
						</td>
					</tr>
					<tr class="form-inline">
						<td>
						<label class="form-control" for="codigo-proveedor">Tipo de Producto:</label>
						</td>
						<td>
						<select class="form-control" id="codigo-proveedor" name="codigo-proveedor">
						<?php foreach($this->proveedores as $item)
						{ ?>
							<option value="<?=$item['codigo_proveedor'] ?>"> <?=$item['descripcion_proveedor'] ?></option>
						<?php } ?>
						</select>
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
			
			if(!existe("descripcion-producto"))
				isValid=false;
			if(!esPalabrbra("descripcion-producto"))
				isValid=false;
			
			if(!radioChecked("en-venta-si","en-venta-no"))
				isValid=false;
			
			$("#costo-producto").val(parseFloat($("#costo-producto").val()).toFixed(2));
			if(!existe("costo-producto"))
				isValid=false;
			if(!esNumeroReal("costo-producto"))
				isValid=false;						
			
			$("#porcen-venta-producto").val(parseFloat($("#porcen-venta-producto").val()).toFixed(2));
			if(!existe("porcen-venta-producto"))
				isValid=false;
			if(!esNumeroReal("porcen-venta-producto"))
				isValid=false;	
			
			$("#precio-venta").val(parseFloat($("#precio-venta").val()).toFixed(2));
			if(!existe("precio-venta"))
				isValid=false;
			if(!esNumeroReal("precio-venta"))
				isValid=false;	
			
			if(!existe("pto-reposicion"))
				isValid=false;
			if(!esDigito("pto-reposicion"))
				isValid=false;				
			
			if(!existe("stock"))
				isValid=false;				
			if(!esDigito("stock"))
				isValid=false;
			
			if(existeMercaderia("descripcion-producto",$("#codigo-producto").val()))
				isValid=false;
			
			if(isValid)
			if (confirm("¿Esta seguro que desea modificar este producto?"))
				return true;
			return false;
		})
		
		$("#cancelar").click(function (){
			if (confirm("¿Esta seguro que desea cancelar la modificacion de este producto?"))
				$(location).attr("href","abmproductos.php");
			return false;
		});
		
		$("#precio-venta").change(function(){
			var costo = $("#costo-producto").val();
			var precio = $("#precio-venta").val();
			if($.isNumeric(costo)&&$.isNumeric(precio))
			{
				var precio = $("#precio-venta").val();
				var porcentaje = ((precio-costo)*100)/costo;
				$("#porcen-venta-producto").val( porcentaje.toFixed(2) );
			};
		});
		
		var cargarPrecio = function(){
			var costo = $("#costo-producto").val();
			var porcentaje = $("#porcen-venta-producto").val();
			if($.isNumeric(costo)&&$.isNumeric(porcentaje))
			{
				var porcentaje = $("#porcen-venta-producto").val();
				var precio = ((porcentaje/100)+1)*costo;
				$("#precio-venta").val( precio.toFixed(2) );
			}
		};
		
		$("#porcen-venta-producto").change(cargarPrecio);			
		
		$("#costo-producto").change( function(){
		$("#porcen-venta-producto").change();
		});
					
		cargarPrecio();
	</script>
</html>