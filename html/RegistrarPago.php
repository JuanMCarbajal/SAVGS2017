<!DOCTYPE html>
<html>	
	<?php 
		$this->renderHead('Nuevo Pago');
	?>
	<body>
		<?php 
			$this->renderHeader('Nuevo Pago');
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
			
			<div id="wrapper2">
				<input type='text' placeholder='Ingrese numero de factura' id='fac_busqueda'/>
				<button id='dosearch'>Cargar</button>
			</div>
			<div id='datosfactura'></div>
			<p><h3>Recibo:</h3></p>
			<div id="cajapago">
			</div>
			<br/>
			<p><h3>Total: $<span id='total'></span></h3></p>
			<form id='form' method='POST' action='confeccionarrecibo.php'>
				<input id='datospagos' name='datospago' type='hidden' value=''/>
				<input id='importe_total' name='importe_recibo' type='hidden' value=''/>
				<input id='cod_cliente' name='cod_cliente' type='hidden' value='<?=$_SESSION['cliente']?>'/>
				<input id='cod_med_pago' name='cod_med_pago' type='hidden' value='1'/>
				<input type='submit' value="Registrar Pago" />
			</form>
		</div>	
		<?php 
			$this->renderFooter();
		?>
	</body>
	<script>
		var pagos=[];
		var total=0;
		var esprimero=false;
		$("#total").html(total);
		var eliminar = function(){	
								var aux=($(this).attr("id")).substr(5);
								var sacarpago=($("#pagado_"+aux).html()).substr(2);
								var sacarpago=parseFloat(sacarpago);
								$(this).parent().parent().remove();
								for(index=0;index<pagos.length;index++){
								if(pagos[index].NRO_fact==aux){
									var auxin=parseFloat(pagos[index].impagar);
									var auxin2=parseFloat($("#a_pagar").html().substr(2));
									auxin=auxin2+auxin;
									auxin=String(auxin);
									auxin="$ "+auxin;
									if($("#codigofact").html()==aux)
										$("#a_pagar").html(auxin);
									pagos.splice(index, 1);
									total=total-sacarpago;
									if(!pagos.length)
									{
										$("#datospago").remove();
										esprimero=false;
									}	
									$('#total').html(total);
								}
							}
		};
		
		$("#form").submit( function(){
			if(pagos.length==0){
				alert('Ingrese algun dato');
				return false;
			}
			var datospagos=JSON.stringify(pagos);
			$('#datospagos').attr('value',datospagos);
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
						url:'buscar_factura.php',
						data:('factura='+nro_fact),
						success:function(respuesta){
							if(respuesta!="0"){
								$("#datosfactura").html(respuesta);
								for(index=0;index<pagos.length;index++){
									if($("#codigofact").html() == pagos[index].NRO_fact)
									{
										var aux=parseFloat(pagos[index].impagar);
										var aux2=parseFloat($("#a_pagar").html().substr(2));
										aux=aux2-aux;
										aux=String(aux);
										aux="$ "+aux;
										$("#a_pagar").html(aux);
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
			if(!(existe('pagofactura'))){
				return false;
			}
			if(!esNumeroReal('pagofactura')){
				return false;
			}
			var nro_fact=$('#codigofact').html();
			var imp_pag=$("#imp_pag").html().substr(2);
			var pagado=$("#pagofactura").val();
			if(pagado>parseFloat($("#a_pagar").html().substr(2)))
			{
				alert("Ingrese un valor menor al valor que hay que pagar");
				return false;
			}
			agregarfact(nro_fact,imp_pag,pagado);
		}
		
		function agregarfact (nro_fact,imp_pag,pagado){
		$.ajax({
						type:'post',
						url:'agregar_factura.php',
						data:('factura='+nro_fact+'&imp_pag='+imp_pag+'&pagado='+pagado),
						success:function(respuesta)
						{
							if(respuesta!="0")
							{
								if(esprimero==false)
								{
									$("#cajapago").html("<table  id='datospago'><tr><th>Nro Factura</th><th>Medio de Pago</th><th>Importe Pagado</th><th>Importe a Pagar</th></tr></table>");
									esprimero=true;
								}
								if($("#cod_"+nro_fact).length)
								{
									var aux=parseFloat($("#pagado_"+nro_fact).html().substr(2));
									var aux2=parseFloat(pagado);
									var aux3=parseFloat($("#a_pagar").html().substr(2));
									aux3=aux3-aux2;
									aux3=String(aux3);
									aux3="$ "+aux3;
									$("#a_pagar").html(aux3);
									total=total-aux;
									aux=aux2+aux;
									for(index=0;index<pagos.length;index++)
									{
										if(nro_fact == pagos[index].NRO_fact)
										{
											pagos[index].impagar=String(aux);
										}
									}
									total=total+aux;
									aux=String(aux);
									aux="$ "+aux;
									$("#pagado_"+nro_fact).html(aux);
									$("#total").html(total);
								}
								else
								{
									$("#datospago").append(respuesta);
									var aux=parseFloat($("#a_pagar").html().substr(2));
									var aux2=parseFloat(pagado);
									aux=aux-aux2;
									aux=String(aux);
									aux="$ "+aux;
									$("#a_pagar").html(aux);
									pagos.push({NRO_fact:nro_fact, impag:imp_pag, impagar:pagado});
									total=total+parseFloat(pagado);
									$('#total').html(total);
								}
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
		
		$( "body" ).on( "click", "#agregapago", agregarres);
		
		$( "body" ).on( "click", ".eliminar", eliminar);
		
		<?php 
		if($this->factura_cargada!=0)
		{ ?>
		$("#fac_busqueda").val("<?= $this->factura_cargada ?>");	
		$("#dosearch").click();
		<?php
		} ?>
	</script>
</html>