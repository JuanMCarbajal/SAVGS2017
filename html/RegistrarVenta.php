<!-- html/RegistrarVenta.php -->

<!DOCTYPE html>
<html>	
	<?php 
		$this->renderHead('Nueva Venta');
	?>
	<body>
		<?php 
			$this->renderHeader('Nueva Venta');
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
			<div id="totalfactura">
				<div id='cajafactura'><p><h3>Factura:</h3></p></div>
				<p><h3>Total: $<span id='total'></span></h3></p>				
			
			<form class="form-inline" id='form' method='POST' action='confeccionarfactura.php'>
				<input id='datosfactura' name='datosfactura' type='hidden' value=''/>
				<input id='IVA' name='IVA' type='hidden' value='21.00'/>
				<input id='importe_total' name='importe_total' type='hidden' value=''/>
				<label class="form-control" for='sel'>Medio de Pago</label>
				<select class="form-control" id='sel' name='cod_med_pago'><?php 
				foreach($this->mdp as $d)
				{
				?>
					<option value='<?=$d['codigo_medio_pago']?>'><?=$d['descripcion_medio_pago']?></option>
				<?php
				}
				?>
				</select>
				<br/><br/>
				<input id='cod_cliente' name='cod_cliente' type='hidden' value='<?=$_SESSION['cliente']?>'/>
				<input id='cod_vendedor' name='cod_vendedor' type='hidden' value='<?=$_SESSION['vendedor']?>'/>
				<input class="btn btn-primary" type='submit' value="Registrar Venta" />
			</form>			
			<hr/>
			</div>
			<br/><br/>
			<div id="wrapper2">
				<div class="form-inline">
					<input class="btn btn-default" type="text" id="q_busqueda" placeholder="Ingrese su Busqueda"/>			
					<button class="btn btn-default" id='dosearch'>Todos</button>		
				</div>
				<div class="form-inline">
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
			</div>	
			<br/><br/>
			<div id="resultadosdiv">	
			</div>
			<br/>
		</div>	
		<?php 
			$this->renderFooter();
		?>		
	</body>
	<script>
	$(document).ready(function()
	{
		var factura=[];
		var total=0;
		var esprimero=true;
		$("#totalfactura").css("display","none");
		$("#total").html(total);
		var eliminar = function(){	
								var aux=($(this).attr("id")).substr(5);
								var preciototal=parseFloat($("#prectotal_"+aux).html());
								$(this).parent().parent().remove();
								for(index=0;index<factura.length;index++){
								if(factura[index].ID_prod==aux){
									total=redondeo(total-preciototal);
									$('#total').html(total);
									var auxin=parseInt(factura[index].prodCant);
									var auxin2=parseInt($("#cantbus_"+factura[index].ID_prod).html());
									auxin=auxin2+auxin;
									$("#cantbus_"+factura[index].ID_prod).html(auxin);
									factura.splice(index, 1);
									if(!factura.length)
									{
										$("#factura").remove();
										esprimero=true;
										total=0;
										$("#total").html(total);											
										$("#totalfactura").css("display","none");
									}	
									}
								}
		};
		
		$("#form").submit( function(){
			if(factura.length==0){
				alert('Ingrese algun dato');
				return false;
			}
			var datosfactura=JSON.stringify(factura);
			$('#datosfactura').attr('value',datosfactura);
			$('#importe_total').attr('value',total);
			return true;
		});
		
		$('#dosearch').click(function(){
		var querybusqueda=$('#q_busqueda').val();
		$.ajax({
					type:'post',
					url:'buscarproductosventas.php',
					data:"busqueda="+querybusqueda+"&proveedor="+$("#codigo-proveedor").val()
						+"&tipo="+$("#codigo-tipo-producto").val(),
					success:function(respuesta){
						if(respuesta!="0"){
							$("#resultadosdiv").html(respuesta);
							for(index=0;index<factura.length;index++){
									if($("#cantbus_"+factura[index].ID_prod).length)
									{
										var aux=parseInt(factura[index].prodCant);
										var aux2=parseInt($("#cantbus_"+factura[index].ID_prod).html());
										aux=aux2-aux;
										$("#cantbus_"+factura[index].ID_prod).html(aux);
									}
								}
							$(".agregar").click(agregarres);
						}
						else{
							alert('Error');
						}
					}
				});
		});
		$("#codigo-proveedor, #codigo-tipo-producto").change(function(){
		var querybusqueda=$('#q_busqueda').val();
		$.ajax({
					type:'post',
					url:'buscarproductosventas.php',
					data:"busqueda="+querybusqueda+"&proveedor="+$("#codigo-proveedor").val()
						+"&tipo="+$("#codigo-tipo-producto").val(),
					success:function(respuesta){
						if(respuesta!="0"){
							$("#resultadosdiv").html(respuesta);
							for(index=0;index<factura.length;index++){
									if($("#cantbus_"+factura[index].ID_prod).length)
									{
										var aux=parseInt(factura[index].prodCant);
										var aux2=parseInt($("#cantbus_"+factura[index].ID_prod).html());
										aux=aux2-aux;
										$("#cantbus_"+factura[index].ID_prod).html(aux);
									}
								}
							$(".agregar").click(agregarres);
						}
						else{
							alert('Error');
						}
					}
				});
		});	
		
		$("#q_busqueda").on('keyup',function(){
			if($("#q_busqueda").val()=="")
			{
				$('#dosearch').text("Todos");
			}
			else
			{
				$('#dosearch').text("Buscar");
			}
		});
		
		var agregarres=function (){
			var id_prod=($(this).attr("id")).substr(8);
			if(!(existe("cant_"+id_prod))){
				return false;
			}
			if(!esDigito("cant_"+id_prod)){
				return false;
			}
			if(!(existe("desc_"+id_prod))){
				return false;
			}
			if(!esNumeroReal("desc_"+id_prod)){
				return false;
			}
			var cant=$("#cant_"+id_prod).val();
			$("#cant_"+id_prod).val("");	
			var desc=parseFloat($("#desc_"+id_prod).val());
			$("#desc_"+id_prod).val("0");			
			var cantaux=parseInt($("#cantbus_"+id_prod).html());
			if(cant>cantaux){
				if(!confirm("El stock pasará a negativo! ¿ Desea continuar ?"))
					return 0;
			}
			var prec=parseFloat($("#prec_"+id_prod).html()).toFixed(2);
			agregarprod(id_prod,cant,prec,desc);
		}
		
		function agregarprod (id_prod,cant,prec,desc){
		$.ajax({
						type:'post',
						url:'agregar_producto_factura.php',
						data:('codigo='+id_prod+'&cantidad='+cant+'&descuento='+desc),
						success:function(respuesta){
							if(respuesta!="0"){
								var cantMod;
								var precioUnit = parseFloat($("#precunit_"+id_prod).html());
								var precioTotal = parseFloat($("#prectotal_"+id_prod).html());								
								if($("#prectotal_"+id_prod).length)
								{
									if("%"+desc != $("#descuento_"+id_prod).html())
									{
										alert("Descuento diferente al ya establecido.");
										return false;
									}
									var auxcant=parseInt($("#cantres_"+id_prod).html());
									cant=parseInt(cant);
									cantMod=cant+auxcant;
									$("#cantres_"+id_prod).html(cantMod);
									total=total-precioTotal;
									var prectotal=redondeo(cantMod*precioUnit*(1-desc/100));
									$("#prectotal_"+id_prod).html(prectotal);
									for(index=0;index<factura.length;index++){
										if(factura[index].ID_prod==id_prod){
										factura[index].prodCant=String(cantMod);									
										factura[index].descProd=String(desc);
										total=redondeo(total+prectotal);
										$('#total').html(total);
										var auxin=parseInt(cant);
										var auxin2=parseInt($("#cantbus_"+factura[index].ID_prod).html());
										auxin=auxin2-auxin;
										$("#cantbus_"+factura[index].ID_prod).html(auxin);
										}
									}
								}
								else
								{
									if(esprimero)
									{
										$("#cajafactura").append("<table class='table table-hover' id='factura'>"
										+"<tr><th class='h1000px'>Codigo</th><th>Descripcion</th><th>Precio</th><th>Cantidad</th><th>Precio Total</th><th>Descuento</th><th></th></tr>"
										+"</table>");										
										$("#totalfactura").css("display","block");
										esprimero=false;
									}								
									$("#factura").append(respuesta);
									$("#descuento_"+id_prod).html("%"+desc);
									var aux=parseInt(cant);
									var aux2=parseInt($("#cantbus_"+id_prod).html());
									aux=aux2-aux;
									$("#cantbus_"+id_prod).html(aux);
									factura.push({ID_prod:id_prod, prodCant:cant, descProd:desc});
									total=redondeo(total+redondeo(prec*cant)*(1-desc/100));
									$('#total').html(total);
								}
							}
							else{
								alert('Error');
							}
						}
					});
		return true;
		}
	
		$( "body" ).on( "click", ".eliminar", eliminar);
	});
	</script>
</html>