<!-- html/ABMProveedores.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('ABM Proveedores');
	?>
	<body>
		<?php 
			$this->renderHeader('ABM Proveedores');
		?>	
		<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="nuevoproveedor.php" >Nuevo Proveedor</a></li>
					<li><a class="navi" href="menugerente.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		
		
	<div id="wrapper">	
		<div id="resultados">
		<?php
		if(count($this->Proveedores))
		{?>
		<input type="hidden" value="<?=count($this->Proveedores)?>" id="cant-res"/>
		<table class="table table-hover w_600px" >
		<tr><th>Codigo</th><th>Descripcion</th><th></th><th></th></tr>
		<?php
			foreach($this->Proveedores as $item)
			{ ?>
			<tr>
				<td><?=$item['codigo_proveedor']?></td><td><?=$item['descripcion_proveedor']?></td>
				<td>
					<form action="modificarproveedor.php" method="post">
						<input type="hidden" name="codigo" value="<?=$item['codigo_proveedor']?>"/>
						<button type="submit" class="boton modificar" >
							<img class="img_boton" src="../img/modificar.png" alt="modificar"/>
						</button>
					</form>
				</td>		
			<td>
				<button id="eli<?=$item['codigo_proveedor']?>" class="boton eliminar" >
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
			<p>No hay Proveedores</p>
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
					if(confirm("¿Esta seguro que desea dar de baja a este proveedor?"))
					{
						$.ajax({
							type:'post',
							url:'abmproveedores.php',
							data:"codigo-proveedor="+id										
						});
						$("#cant-res").val( parseInt($("#cant-res").val())-1);
						if($("#cant-res").val()==0)
							$("#resultados").html("<p>No hay Proveedores</p>");
						$(this).parent().parent().remove();
					}
				} );	
			});
			
			
		</script>
	</body>
</html>