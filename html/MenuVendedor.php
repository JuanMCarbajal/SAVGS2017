<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Menu vendedor - proyecto');
	?>
	<style>
		#form{
			width:auto;
		}
	</style>	
	<body>
		<?php 
		$this->renderHeader('Menu Vendedor');
		?>
		<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href='../controllers/nuevocliente.php'>Registrar Cliente</a></li>
					<li><a class="navi dir" href='../controllers/registrarventa.php'>Registrar Venta</a></li>
					<li><a class="navi dir" href='../controllers/registrardevolucion.php'>Registrar Devolucion</a></li>
					<li><a class="navi dir" href='../controllers/verfacturascliente.php'>Ver Facturas</a></li>
					<li><a class="navi dir" href='../controllers/verreciboscliente.php'>Ver Recibos</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">
			
			<div id="wrapper2">
			<?php
			if(!isset($_SESSION['cliente']) || $_SESSION['cliente']==0 || isset($_POST['cambiar']))
			{ ?>
			<form id="form" method="POST" action="">			
				<input type="hidden" id="num_doc" name="num_doc" />	
				<input type="hidden" id="tip_doc" name="tip_doc" />	
			</form>
			<h2 >Busqueda de Clientes</h2>
			<div class="form-inline">
				<input class="form-control" type="text" id="busqueda" placeholder="Ingrese su Busqueda"/>
				<input type="button" class="btn btn-default" id="buscar" value="Todos" />
			</div>
			<div id="resultados" ></div>
			<?php
			}
			else
			{
			?>
					<p class='formres'>Nombre: <?=$_SESSION['nom_cliente']?></p>
					<br/><br/>		
					<form id='form' method='post' action=''>
						<input type='hidden' name='cambiar' value='1'/>
						<input type='submit' class="btn btn-default" value='Cambiar Usuario'/>
					</form>
					<br/><br/>
					<p>Saldo a favor: $<?=$this->saldo?></p>
					<br/><br/>
					<p>Deuda : $<?=$this->deuda+0?></p>
					<br/><br/>
					<div class="form-inline">						
						$<input type="text" class="form-control precio" id="pago" placeholder="pago"/>
						<input type="button" class="btn btn-default" id="nuevo_pago" value="Nuevo pago">
					</div>
					
			<?php
			}
			?>
			</div>
		</div>		
		<?php 
			$this->renderFooter();
		?>
		<script>
		
		<?php
			if(!isset($_SESSION['cliente']) || $_SESSION['cliente']==0 || isset($_POST['cambiar']))
			{ ?>
						
			$("#buscar").click(function(){			
				$.ajax({
					type:'post',
					url:'buscarclientes.php',
					data:"busqueda="+$("#busqueda").val(),
					success:function(respuesta){
						if(respuesta!="0"){
							$("#busqueda").val("");
							
							$('#buscar').val("Todos");
							
							$("#resultados").html(respuesta);	

							$(".agregar").click(agregar);
						}
						else{
							alert("Error");
						}
					}
				});
			});
			
			
			var agregar =function(){								
				var id=($(this).attr("id")).substr(3);
				var This = $(this);
				if(confirm('¿Esta seguro que desea ingresar este cliente?'))
				{
					$("#tip_doc").val(This.attr("data-tip-doc"));
					$("#num_doc").val($("#doc"+id).html());
					$("#form").submit();
				}								
			};		
		
			$(".dir").click(function (){
				if(!($(".formres").length))
				{
					alert("Ingrese un Cliente primero");
					return false;
				}				
			});
			
			$("#busqueda").on('keyup',function(){
					if($("#busqueda").val()=="")
					{
						$('#buscar').val("Todos");
					}
					else
					{
						$('#buscar').val("Buscar");
					}
				});		
			<?php
			}
			else
			{?>
			$("#nuevo_pago").click(function()
			{
				if(!(existe('pago'))){
					return false;
				}
				if(!esNumeroReal('pago')){
					return false;
				}
				if(confirm('¿Esta seguro que desea ingresar un nuevo pago por '+$("#pago").val()+'?'))
				{
					$.ajax({
						type:'post',
						url:'confeccionarrecibo.php',
						data:('importe='+$("#pago").val()),
						success:function(respuesta)
						{
							if(respuesta=="0")
							{
								alert("Error");
							}
							window.location.href = "../controllers/menuvendedor.php";
						},
						error : function(jqXHR, textStatus, errorThrown) { alert("Error: Status: "+textStatus+" Message: "+errorThrown); }
						
					})
					};
				});	
			<?php
			}
			?>
		</script>
		
	</body>
</html>