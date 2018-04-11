<!-- html/ABMTiposProducto.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('ABM Medios de Pago');
	?>	
	<body>
		<?php 
			$this->renderHeader('ABM Medios de Pago');
		?>
		<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="nuevomediodepago.php" >Nuevo Medio de Pago</a></li>
					<li><a class="navi" href="menugerente.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		
		
	<div id="wrapper">	
		<div id="resultados">
		<?php
		if(count($this->mediosDePago))
		{?>
		<input type="hidden" value="<?=count($this->mediosDePago)?>" id="cant-res"/>
		<table class="table table-hover w_600px" >
		<tr><th>Codigo</th><th>Descripcion</th><th>En uso</th><th></th><th></th></tr>
		<?php
			foreach($this->mediosDePago as $item)
			{ ?>
			<tr ><td><?=$item['codigo_medio_pago']?></td><td><?=$item['descripcion_medio_pago']?></td>
			<td><?=$item['medio_pago_en_uso']?></td>	
			<td>
				<form action="modificarmediodepago.php" method="post">
					<input type="hidden" name="codigo" value="<?=$item['codigo_medio_pago']?>"/>
					<button type="submit" class="boton modificar" >
						<img class="img_boton" src="../img/modificar.png" alt="modificar"/>
					</button>
				</form>
			</td>		
			<td>
				<button id="eli<?=$item['codigo_medio_pago']?>" class="boton eliminar" >
					<img class="img_boton" src="../img/borrar.png" alt="borrar"/>
				</button>
			</td>
		</tr>
		<?php
			} ?>
		</table>
		</div>
		<?php
		}else
		{?>
			<p>No hay Medios de Pago</p>
		<?php
		} ?>	
	</div>
	<?php 
		$this->renderFooter();
	?>
	<script>
			$(document).ready(function(){				
				
				$(".eliminar").click( function(){								
					var id=($(this).attr("id")).substr(3);
					if(confirm("¿Esta seguro que desea dar de baja este medio de pago?"))
					{
						$.ajax({
							type:'post',
							url:'abmmediosdepago.php',
							data:"codigo-medio-pago="+id										
						});
						$("#cant-res").val( parseInt($("#cant-res").val())-1);
						if($("#cant-res").val()==0)
							$("#resultados").html("<p>No hay medios de pago</p>	");
						$(this).parent().parent().remove();
					}
				} );	
			});
			
			
		</script>
	</body>
</html>