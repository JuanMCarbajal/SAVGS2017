<!-- html/ABMVendedores.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('ABM vendedores - proyecto');
	?>
	<body>	
		<?php 
			$this->renderHeader('ABM Vendedores');
		?>
			<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="nuevovendedor.php" >Nuevo Vendedor</a></li>
					<li><a class="navi" href="menugerente.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">
			<h2>Busqueda de Vendedores</h2>
			<div class="form-inline">
				<input class="btn btn-default" type="text" id="busqueda" placeholder="Ingrese su Busqueda"/>
				<input class="btn btn-default" type="button" id="buscar" value="Buscar" />		
			</div>
			<div id="resultados" ></div>
			<?php if($this->mensaje!="")
					echo $this->mensaje
					?>	
		</div>
		<?php 
			$this->renderFooter();
		?>
		<script>
			$(document).ready(function(){
				
				var eliminar = function(){								
								var id=($(this).attr("id")).substr(3);
								if(confirm("¿Esta seguro que desea dar de baja este vendedor?"))
								{
									$.ajax({
										type:'post',
										url:'abmvendedores.php',
										data:"codigo-vendedor="+id										
									});
									$("#cant-res").val( parseInt($("#cant-res").val())-1);
									if($("#cant-res").val()==0)
										$("#resultados").html("");
									$(this).parent().parent().remove();
								}
								}		
				
				$("#buscar").click(function(){			

					if(esBusquedaValida("busqueda"))
					{$.ajax({
						type:'post',
						url:'buscarvendedores.php',
						data:"busqueda="+$("#busqueda").val(),
						success:function(respuesta){
							if(respuesta!="0"){
								$("#busqueda").val("");
								
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
				$("#buscar").click();
				<?php
				}
				?>
			});
			
			
		</script>
	</body>
</html>	
	