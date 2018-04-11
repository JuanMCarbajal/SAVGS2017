<!-- html/NuevoProducto.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Nuevo producto');
	?>
	<body>
		<?php 
			$this->renderHeader('Nuevo producto');
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
			
			<form id="form" action="nuevoproducto.php" method="post" id="form">
				<div class="control-group input-append ">
			<table>
			<tr class="form-inline">
				<td>
					<label class="form-control" for="descripcion-producto">Descripcion:</label>
				</td>
				<td>
					<input class="form-control" type="text" id="descripcion-producto" name="descripcion-producto"/>
					</td>
			</tr>
			<tr class="form-inline">
				<td>
					<label class="form-control" for="en-venta">En Venta:</label>
				</td>
				<td>
					<label class="form-control" for="en-venta-si"><input type="radio" id="en-venta-si" name="en-venta" value="Si" checked>Si</label>
					<label class="form-control" for="en-venta-no"><input type="radio" id="en-venta-no" name="en-venta" value="No">No</label>
					</td>
			</tr>
			<tr class="form-inline">
				<td>
					<label class="form-control" for="costo-producto" >Costo del producto:</label>
				</td>
				<td>
					$<input type="text" class="precio form-control" id="costo-producto" name="costo-producto"/>
					</td>
			</tr>			
			<tr class="form-inline">
				<td>
					<label class="form-control" for="porcen-venta-producto" >Porcentaje de Venta:</label>
				</td>
				<td>
					%<input type="text" class="precio form-control" id="porcen-venta-producto" name="porcen-venta-producto"/>
					</td>
			</tr>
			<tr class="form-inline">
				<td>
					<label class="form-control" for="precio-venta" >Precio de Venta:</label>
				</td>
				<td>
					$<input type="text" class="precio form-control" id="precio-venta" name="precio-venta"/>
					</td>
			</tr>
			<tr class="form-inline">
				<td>
					<label class="form-control" for="pto-reposicion">Punto de Reposicion:</label>
				</td>
				<td>
					<input type="text" class="cantidad form-control" id="pto-reposicion" value="100" name="pto-reposicion"/>
					</td>
			</tr>
			<tr class="form-inline">
				<td>
					<label class="form-control" for="stock">Stock:</label>
				</td>
				<td>
					<input type="text"  class="cantidad form-control" id="stock" value="0" name="stock"/>
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
					
					<input class="btn btn-default" type="submit" value="Crear" />
					<button class="btn btn-default" id="cancelar" >Cancelar </button>
			</div>	
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
			if(!esPalabra("descripcion-producto"))
				isValid=false;
			
			if(!radioChecked("en-venta-si","en-venta-no"))
				isValid=false;
			
			if(!existe("costo-producto"))
				isValid=false;
			if(!esNumeroReal("costo-producto"))
				isValid=false;				
			
			if(!existe("porcen-venta-producto"))
				isValid=false;
			if(!esNumeroReal("porcen-venta-producto"))
				isValid=false;	
			
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
			
			if(existeMercaderia("descripcion-producto",0))
				isValid=false;
			
			if(isValid)
				if (confirm("Esta seguro que desea crear un nuevo producto"))
					return true;
			return false;
		})
		
		$("#cancelar").click(function (){
			if (confirm("¿Esta seguro que desea cancelar la creacion de este nuevo producto?"))
				$(location).attr("href","abmproductos.php");
			return false;
		});	
		
		$("#precio-venta").change(function(){
			var costo = $("#costo-producto").val();
			var precio = $("#precio-venta").val();
			if($.isNumeric(costo)&&$.isNumeric(precio))
			{
				var porcentaje = ((precio-costo)*100)/costo;
				$("#porcen-venta-producto").val( porcentaje.toFixed(2) );
			};
		});
		
		$("#porcen-venta-producto").change(function(){
			var costo = $("#costo-producto").val();
			var porcentaje = $("#porcen-venta-producto").val();
			if($.isNumeric(costo)&&$.isNumeric(porcentaje))
			{					
				var precio = ((porcentaje/100)+1)*costo;
				$("#precio-venta").val( precio.toFixed(2) );
			};
		});
		
		$("#costo-producto").change( function(){
		$("#porcen-venta-producto").change();
		});			
	</script>
</html>