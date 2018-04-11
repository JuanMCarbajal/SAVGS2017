<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Nueva Devolucion');
	?>
	<body>
		<?php 
			$this->renderHeader('Nueva Devolucion');
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
			<div id="titledev">
				<p><h3>Devoluciones:</h3></p>
				
				<div id='devoluciones'>
				</div>
				<br/>			
				<form id='form' method='POST' action='confeccionardevolucion.php'>
					<input id='datosdev' name='datosdevoluciones' type='hidden' value=''/>
					<input id='importe_total' name='importe_devolucion' type='hidden' value=''/>
					<input id='cod_cliente' name='cod_cliente' type='hidden' value='<?=$_SESSION['cliente']?>'/>
					<input class="btn btn-primary" value="Registrar Devolucion" type='submit'/>
				</form>
				<hr/>
			</div>
			<div class="form-inline" id="wrapper2">
				<input class="form-control" type='text' placeholder='Ingrese numero de factura' id='fac_busqueda'/>
				<button class="btn btn-default" id='dosearch'>Cargar</button>
			</div>
			<div id='datosfactura'></div>			
		</div>		
		<?php 
			$this->renderFooter();
		?>
	</body>
	<script>
		var devoluciones=[];
		var total=0;
		var nro_factura=0;
		var tabla=0;
		$("#titledev").css("display","none");
		$("#total").html(total);
		var eliminar = function(){	
								var aux=($(this).attr("id")).substr(5);
								var cod_prod='';
								var nro_fact='';
								var flag=1;
								for(var i=0;i<aux.length;i++){
									var letra=aux.substr(i,1);
									if(letra!='_' && flag!=0){
										cod_prod=cod_prod+letra;
									}
									if(letra=='_'){
										for(var j=i+1;j<aux.length;j++){
											var auxletra=aux.substr(j,1);
											nro_fact=nro_fact+auxletra;
										}
										flag=0;
									}
									
								}
								total=total-parseFloat($('#precdev_'+aux).html());
								$(this).parent().parent().remove();
								for(index=0;index<devoluciones.length;index++){
								if(devoluciones[index].NRO_fact==nro_fact && devoluciones[index].cod_prod==cod_prod)
								{
									$('#total').html(total);
									var auxin=parseInt(devoluciones[index].cant);
									var auxin2=parseInt($("#cant_"+devoluciones[index].cod_prod+"_"+devoluciones[index].NRO_fact).html());
									auxin=auxin2+auxin;
									$("#cant_"+devoluciones[index].cod_prod+"_"+devoluciones[index].NRO_fact).html(auxin);
									devoluciones.splice(index, 1);
									if(!devoluciones.length)
									{
										$("#datosdevoluciones").remove();											
										$("#titledev").css("display","none");
										tabla=0;											
										$("#total").html(total);
									}	
								}
							}
		};
		
		$("#form").submit( function(){
			if(devoluciones.length==0){
				return false;
			}
			$('#datosdev').attr('value',JSON.stringify(devoluciones));
			alert("Devolucion realizada correctamente");
			$('#importe_total').attr('value',total);
			return true;
		});
		
		var buscarres=function (){
			if(!(existe('fac_busqueda'))){
				return false;
			}
			if(!esDigito('fac_busqueda')){
				return false;
			}
			var nro_fact=$('#fac_busqueda').val();
			buscarfact(nro_fact);
		}
		
		function buscarfact (nro_fact){
		$.ajax({
						type:'post',
						url:'buscarproductosfactura.php',
						data:('factura='+nro_fact),
						success:function(respuesta){
							if(respuesta!="0"){
								$("#fac_busqueda").val("");
								$("#datosfactura").html(respuesta);									
								nro_factura=nro_fact;
								for(index=0;index<devoluciones.length;index++)
								{
									if($("#cant_"+devoluciones[index].cod_prod+"_"+nro_fact).length)
									{
										var aux=parseInt(devoluciones[index].cant);
										var aux2=parseInt($("#cant_"+devoluciones[index].cod_prod+"_"+nro_fact).html());
										aux=aux2-aux;
										$("#cant_"+devoluciones[index].cod_prod+"_"+nro_fact).html(aux);
									}
								}
							}
							else{
								alert('Error');
							}
						}
					});
		return true;
		}
		
		var agregarres=function (){
			var id_prod=($(this).attr("id")).substr(8);
			if(!(existe('cdev_'+id_prod))){
				return false;
			}
			if(!esDigito('cdev_'+id_prod)){
				return false;
			}
			var cantidad=$("#cdev_"+id_prod).val();				
			if(cantidad>parseInt($("#cant_"+id_prod+"_"+nro_factura).html()))
			{
				alert("Ingrese un valor menor a la cantidad vendida");
				return false;
			}
			$("#cdev_"+id_prod).val("");
			agregardev(nro_factura,id_prod,cantidad);
		}
		
		function agregardev (nro_factura,id_prod,cantidad){
		$.ajax({
						type:'post',
						url:'agregar_devolucion.php',
						data:('factura='+nro_factura+'&id_prod='+id_prod+'&cant='+cantidad),
						success:function(respuesta){
							if(respuesta!="0"){									
								if(tabla==0){
									tabla=1;
									$("#titledev").css("display","block");
									$('#devoluciones').html(
									"<table class='table table-hover' >"+
										"<tbody id='datosdevoluciones'>"+
											"<tr><th>Nro Factura</th>"+
											"<th>ID del Producto</th>"+
											"<th>Descripcion del Producto</th>"+
											"<th>Cantidad</th>"+
											"<th>Cantidad a Devolver</th>"+
											"<th>Precio Unitario</th>"+
											"<th>Dinero a Devolver</th>"+
											"<th></th>"+
											"</tr>"+
										"</tbody>"+
									"</table>");
								}
								
								if($("#"+id_prod+"_"+nro_factura).length)
								{
									var auxcant=parseInt($("#cantdev_"+id_prod+"_"+nro_factura).html());
									cantidad=parseInt(cantidad);
									var cantMod=cantidad+auxcant;
									$("#cantdev_"+id_prod+"_"+nro_factura).html(cantMod);
									total=total-(parseFloat($("#precdev_"+id_prod+"_"+nro_factura).html().substr(2)));
									var precUnit = parseFloat($("#unitdev_"+id_prod+"_"+nro_factura).html().substr(2));
									var prectotal=cantMod*(precUnit);
									$("#precdev_"+id_prod+"_"+nro_factura).html(prectotal);
									for(index=0;index<devoluciones.length;index++)
									{
										if(devoluciones[index].cod_prod==id_prod && devoluciones[index].NRO_fact==nro_factura)
										{
											devoluciones[index].cant=String(cantMod);
											total=redondeo(total+prectotal);
											$('#total').html(total);
											var auxin=parseInt(cantidad);
											var auxin2=parseInt($("#cant_"+id_prod+"_"+nro_factura).html());
											auxin=auxin2-auxin;
											$("#cant_"+id_prod+"_"+nro_factura).html(auxin);
										}
									}
								}
								else
								{
									$("#datosdevoluciones").append(respuesta);
									var auxin=parseInt(cantidad);
									var auxin2=parseInt($("#cant_"+id_prod+"_"+nro_factura).html());
									auxin=auxin2-auxin;
									$("#cant_"+id_prod+"_"+nro_factura).html(auxin);
									var prec_unit=$('#unitdev_'+id_prod+'_'+nro_factura).html();
									devoluciones.push({NRO_fact:nro_factura, cod_prod:id_prod, cant:cantidad, prec_unit:prec_unit});
									total=total+parseFloat($('#precdev_'+id_prod+'_'+nro_factura).html());
									total=redondeo(total);
									$('#total').html(total);
								}
								$("#unitdev_"+id_prod+"_"+nro_factura).html("$"+$("#unitdev_"+id_prod+"_"+nro_factura).html());
								$('#precdev_'+id_prod+'_'+nro_factura).html("$"+$('#precdev_'+id_prod+'_'+nro_factura).html());
							}
							else
							{
								alert('Error');
							}
						}
					});
		return true;
		}
		
		$("#dosearch").click(buscarres);
		
		$( "body" ).on( "click", ".agregar", agregarres);
		
		$( "body" ).on( "click", ".eliminar", eliminar);
	</script>
</html>