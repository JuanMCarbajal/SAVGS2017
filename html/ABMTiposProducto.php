<!-- html/ABMTiposProducto.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('ABM Tipos de Producto');
	?>
	<body>	
		<?php 
			$this->renderHeader('ABM Tipos de Producto');
		?>
		<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="nuevotipoproducto.php" >Nuevo Tipo de Producto</a></li>
					<li><a class="navi" href="menugerente.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		
		
	<div id="wrapper">	
		<div id="resultados">
		<?php
		if(count($this->tiposProducto))
		{?>
		<input type="hidden" value="<?=count($this->tiposProducto)?>" id="cant-res"/>
		<table class="table table-hover w_600px" >
		<tr><th>Codigo</th><th>Descripcion</th><th></th><th></th></tr>
		<?php
			foreach($this->tiposProducto as $item)
			{ ?>
			<tr ><td><?=$item['codigo_tipo_producto']?></td><td><?=$item['descripcion_tipo']?></td>	
			<td>
				<form action="modificartipoproducto.php" method="post">
					<input type="hidden" name="codigo" value="<?=$item['codigo_tipo_producto']?>"/>
					<button type="submit" class="boton modificar" >
						<img class="img_boton" src="../img/modificar.png" alt="modificar"/>
					</button>
				</form>
			</td>		
			<td>
				<button id="eli<?=$item['codigo_tipo_producto']?>" class="boton eliminar" >
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
			<p>No hay tipos de producto</p>
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
					if(confirm("¿Esta seguro que desea dar de baja este tipo de producto?"))
					{
						$.ajax({
							type:'post',
							url:'abmtiposproducto.php',
							data:"codigo-tipo-producto="+id										
						});
						$("#cant-res").val( parseInt($("#cant-res").val())-1);
						if($("#cant-res").val()==0)
							$("#resultados").html("<p>No hay tipos de producto</p>");
						$(this).parent().parent().remove();
					}
				} );	
			});
			
			
		</script>
	</body>
</html>