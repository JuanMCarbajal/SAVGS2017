<!-- html/ModificarStock.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Modificar Stock');
	?>
	<body>
		<?php 
			$this->renderHeader('Modificar Stock');
		?>
		<nav>
			<div id="wrappernav">
				<ul id="navlist">				
					<li><a class="navi" href="menualmacen.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper" >
			<div id="modificaciones" ></div>
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
			<div id="resultados" ></div>	
		</div>
		<?php 
			$this->renderFooter();
		?>		
	</body>
	<script>
		$(document).ready(function(){
			
			esprimero=true;
			
			var modificar = function(){			
							var confirmar=false;
							var cant,cantMod;
							var id=($(this).attr("id")).substr(3);
							var esValido=true;
							if(!existe("tex"+id))
								esValido=false;
							if(!esDigito("tex"+id))
								esValido=false;
							if(esValido)
							{
								if($(this).attr("id")==("qui"+id))
								{
									cant=parseInt($("#tex"+id).val());	
									$("#tex"+id).val("");
									preStock=parseInt($("#cant"+id).html());		
									if((preStock-cant)<0)
									{
										alert("Valor mayor a la cantidad de stock disponible");
										exit;
									}	
									var mje="¿Esta seguro que desea quitar "+cant+" unidades de stock del producto "+id+"?";
									if(confirm(mje))
									{
										confirmar=true;
										cant=cant*(-1);										
									}
								}
								else
								{   
									var mje="¿Esta seguro que desea agregar "+$("#tex"+id).val()+" unidades de stock del producto "+id+"?";
									if(confirm(mje))
									{
										confirmar=true;
										cant=parseInt($("#tex"+id).val());		
										$("#tex"+id).val("");										
									}
								}
								if(confirmar)
								{	
									$.ajax({
										type:'post',
										url:'modificarstock.php',
										data:{ 'codigo-producto' : id , 'cantidad' : cant },
										success: function(stock){
											if(esprimero)
											{
												$("#modificaciones").append("<h2>Cambios realizados:</h2>"+
												"<table class='table table-hover' id='mod'>"+
												"<tr><th>Codigo</th><th>Cantidad</th><th>Stock</th></tr></table>");
												esprimero=false;
											}
											if($("#mod"+id).length)
											{
												cantMod=cant+parseInt($("#can"+id).text());
												$("#mod"+id).remove();
											}
											else
												cantMod=cant;
											$("#mod").append("<tr id='mod"+id+"'><td>"+id+"</td><td id='can"+id+"'>"+cantMod+"</td><td>"+stock+"</td></tr>");
											cant+=parseInt($("#cant"+id).text());
											$("#cant"+id).text(cant);
										}
									});		
								}
							}
						}	
						
				var buscar = function(){	
					$.ajax({
						type:'post',
						url:'modificarstock.php',
						data:"busqueda="+$("#busqueda").val()+"&proveedor="+$("#codigo-proveedor").val()
						+"&tipo="+$("#codigo-tipo-producto").val(),
						success:function(respuesta){
							if(respuesta!="0")
							{								
								$("#resultados").html(respuesta);	
								$(".agregar, .quitar").click(modificar);								
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
		});		
	</script>
</html>	
	