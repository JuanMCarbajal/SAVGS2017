<!-- html/ABMProductos.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('ABM productos - proyecto');
	?>
	<body>
		<?php 
			$this->renderHeader('ABM Productos');
		?>
			<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="nuevoproducto.php" >Nuevo Producto</a></li>
					<li><a class="navi" href="menugerente.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		
		
		<div id="wrapper">		
			<div class="form-inline">
				<h2>Busqueda de Productos</h2>
				<input class="form-control" type="text" id="busqueda" placeholder="Ingrese su Busqueda"/>
				<input class="btn btn-default" type="button" id="todos" value="Todos" />
				<select class="form-control" id="codigo-tipo-producto" name="codigo-tipo-producto">
					<option value="0">Tipo</option>
					<?php foreach($this->tipos_producto as $item)
					{ ?>
						<option value="<?=$item['codigo_tipo_producto'] ?>"> <?=$item['descripcion_tipo'] ?></option>
					<?php } ?>
				</select>
				<select class="form-control" id="codigo-proveedor" name="codigo-proveedor">
					<option value="0">Proveedor</option>
					<?php foreach($this->proveedores as $item)
					{ ?>
						<option value="<?=$item['codigo_proveedor'] ?>"> <?=$item['descripcion_proveedor'] ?></option>
					<?php } ?>
				</select>
			</div>			
			<div class="form-inline">
				<label class="form-control" for="porcentaje">Cambiar porcen. venta</label>
				<input type="text" class="form-control" id="porcentaje" placeholder="Ingrese porcentaje" 
				alt="El monto ingresado aqui reemplazara el porcentaje de venta de los productos segun el filtro que ya este realizado"/>%
				<input type="button" class="btn btn-default" id="cambiar-porcen" value="Cambiar" />
			</div>
			<div class="form-inline">
				<label class="form-control" for="costo">Cambiar costo</label>
				<input class="form-control" type="text" id="costo" placeholder="Ingrese porcentaje" 
				alt="El monto ingresado aqui podra aumentar o disminuir el costo de los productos segun el filtro que ya este realizado"/>%
				<input type="button" class="btn btn-default costo-cambio" value="Aumentar" />
				<input type="button" class="btn btn-default costo-cambio" value="Disminuir" />
			</div>
			<div id="resultados" ></div>
		</div>
		<?php 
			$this->renderFooter();
		?>
		<script>
			$(document).ready(function(){
				
				var eliminar = function(){								
								var id=($(this).attr("id")).substr(3);
								if(confirm("¿Esta seguro que desea dar de baja este producto?"))
								{
									$.ajax({
										type:'post',
										url:'abmproductos.php',
										data:"codigo-producto="+id										
									});
									$("#cant-res").val( parseInt($("#cant-res").val())-1);
									if($("#cant-res").val()==0)
										$("#resultados").html("");
									$(this).parent().parent().remove();
								}
								}		
				
				var buscar = function(){	
					$.ajax({
						type:'post',
						url:'buscarproductos.php',
						data:"busqueda="+$("#busqueda").val()+"&proveedor="+$("#codigo-proveedor").val()
						+"&tipo="+$("#codigo-tipo-producto").val(),
						success:function(respuesta){
							if(respuesta!="0"){
								$("#resultados").html(respuesta);		
								
								$(".eliminar").click( eliminar );								
							}
							else{
								alert("Error");
							}
						}
					});
				};
				
				$("#busqueda, #codigo-proveedor, #codigo-tipo-producto").change(buscar);	
				
				$("#todos").click(function()
				{
					$("#codigo-proveedor, #codigo-tipo-producto").val("0");
					buscar();
				});	
				
				$("#buscar").click(buscar());	
				
				$("#busqueda").on('keyup',function(){
					if($("#busqueda").val()=="")
					{
						$('#buscar').val("Todos");
						$('#buscar').attr("id","todos");
					}
					else
					{
						$('#todos').val("Buscar");
						$('#todos').attr("id","buscar");
					}
				});				
				
				$("#cambiar-porcen").click(function(){	
					if(esNumeroReal("porcentaje")&&confirm("¿Esta seguro que cambiar el porcentaje de venta a los productos en pantalla?"))
					{									
						$.ajax({
							type:'post',
							url:'modificarprecioproductos.php',
							data:"busqueda="+$("#busqueda").val()+"&proveedor="+$("#codigo-proveedor").val()
							+"&tipo="+$("#codigo-tipo-producto").val()+"&porcentaje="+$("#porcentaje").val(),
							success:function(respuesta){
								if(respuesta!="0"){		
									$("#porcentaje").val("");					
									$("#resultados").html(respuesta);		
									$(".eliminar").click( eliminar );								
								}
								else{
									alert("Error");
								}
							}
						});
					}
				});
				
				$(".costo-cambio").click(function(){	
					if(esNumeroReal("costo")&&confirm("¿Esta seguro que cambiar el costo a los productos en pantalla?"))
					{	
						$esAumento = "False";
						if($(this).val() == "Aumentar")
							$esAumento = "True";
						$.ajax({
							type:'post',
							url:'modificarprecioproductos.php',
							data:"busqueda="+$("#busqueda").val()+"&proveedor="+$("#codigo-proveedor").val()
							+"&tipo="+$("#codigo-tipo-producto").val()+"&porcentaje="+$("#costo").val()+
							"&esAumento="+$esAumento,
							success:function(respuesta){
								if(respuesta!="0"){	
									$("#costo").val("");	
									$("#resultados").html(respuesta);		
									$(".eliminar").click( eliminar );								
								}
								else{
									alert("Error");
								}
							}
						});
					}
				});
			
				<?php if(isset($_SESSION['busqueda']))
				{?>
				$("#busqueda").val("<?= $_SESSION['busqueda'] ?>");
				$("#busqueda").change();
				<?php
				}
				?>				
			});
			
			
		</script>
	</body>
</html>	
	