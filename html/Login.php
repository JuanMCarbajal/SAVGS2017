<!-- html/Login.php -->

<!DOCTYPE html>
<html>
	<?php 
		$this->renderHead('Login');
	?>
	<script src='../script/jquery.crypt.js'></script>
	<body>
		<?php 
			$this->renderHeader('Login');
		?>
	<div id="wrapper">		
		<?php if($this->error)
				echo("<p> El usuario o contraseña estan incorrectos</p>");
		?>
		<form action="login.php" id="form" method="post">
		<table>
		<tr class="form-inline">
			<td>
			<label class="form-control" for="usuario">Usuario:</label>
			</td>
			<td>
			<input class="form-control" type="text" id="usuario" name="usuario" />
			</td>
		</tr>
		<tr class="form-inline">
			<td>
			<label class="form-control" for="password">Contraseña:</label>
			</td>
			<td>
			<input class="form-control" type="password" id="password" name="password" />
			</td>
		</tr>
		</table>
			<br/>
			<input class="btn btn-default" type="submit" value="Ingresar" />
		</form>		
	</div>	
	<?php 
		$this->renderFooter();
	?>
		<script>
			
			$("form").submit(function(){	

				var isValid=true;
				
				if(!existe("usuario"))
					isValid=false;	
				
				if(!existe("password"))
					isValid=false;
				
				if(isValid)
				{
					$("#password").val($().crypt( { method:"sha1", source:($().crypt( { method:"sha1", source:$("#password").val() } )+'<?= $_SESSION['salt']?>') } ));
				}
			});				
		
		</script>		
		
	</body>
</html>