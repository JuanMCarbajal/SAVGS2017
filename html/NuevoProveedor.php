<!-- html/NuevoProveedor.php -->

<!DOCTYPE html>
<html>
	<head><meta charset='UTF-8'/>
		<title>Nuevo Proveedor</title>
		<script src='../script/jquery-1.11.3.min.js'></script>
		<script src="../script/validacion.js"></script>
		<link rel="stylesheet" href="../css/base.css">
		<link rel="stylesheet" href="../css/bootstrap.css" />
	</head>
	
	<body>
	<header id="backhead">
		<img src="../img/UTN.gif" alt="utn"/>
		<h1>Nuevo Proveedor</h1>
	</header>
			<nav>
			<div id="wrappernav">
				<ul id="navlist">
					<li><a class="navi" href="abmproveedores.php" >Volver</a></li>
					<li><a class="navi" href="login.php" >Salir</a></li>
				</ul>
			</div>
		</nav>
		<div id="wrapper">
			
			<form id="form" action="nuevoproveedor.php" method="post" >
			<table>
			<tr class="form-inline">
				<td>
				<label class="form-control" for="descripcion-proveedor">Descripcion:</label>
				</td>
				<td>
				<input class="form-control" type="text" id="descripcion-proveedor" name="descripcion-proveedor"/>
				</td>
			</tr>
			</table>	
				<br/>
				<input class="btn btn-default" type="submit" value="Crear" />
				<button class="btn btn-default" id="cancelar" >Cancelar </button>
			</form>
		</div>
		<footer id="backfoot">
			<div><p>&copy;2015 S.A.V.G.S.</p></div>
			<div><p>Todos los derechos Reservados</p></div>
		</footer>
		<script>
		
			$("#form").submit( function(){
				var isValid=true;
				
				if(!existe("descripcion-proveedor"))
					isValid=false;
				if(!esPalabra("descripcion-proveedor"))
					isValid=false;				
				
				if(existeProveedor("descripcion-proveedor",0))
					isValid=false;
				
				if(isValid)
					if (confirm("¿Esta seguro que desea agregar un nuevo proveedor?"))
						return true;
				return false;
			});
			
				$("#cancelar").click(function (){
				if (confirm("¿Esta seguro que desea cancelar la agregación de este nuevo proveedor?"))
					$(location).attr("href","abmproveedores.php");
				return false;
			});
		
		</script>
	</body>
</html>