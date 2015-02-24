<!DOCTYPE HTML>
<!--/> 
	Arturo Voltattorni 10-10774
	Ramon Marquez	   10-10849
	Esteban Oliveros   10-11252
	Archivo que muestra el formulario para el ingreso de los datos de nuevos usuarios.
<!-->


<html>
<head>
	<?php include("encabezado.php")?>
</head>
<body>
	<div id="header-wrapper">
		<header id="header" class="5grid-layout">
			<div id="row">
				<div id="12u">
					<div id="logo">
						<h1><a href="#" class="mobileUI-site-name">Registro de Usuarios</a></h1>
						<p>Hospital Ortopédico Infantil</p>
					</div>
				</div>
			</div>
		</header>
	</div>
	<div id="wrapper">
		<form action="validar_registro.php" method="post">
		<div class="5grid-layout" id="welcome">
			<div class="row">
				<div class="12u">
					<section class="content">
						<h2 align="center">Datos Personales del Médico</h2>
							<table >
								<tr>
									<td> Nombres:</td>
									<td> <input type="text" id="firstname" name="firstname"></td>
								</tr>
								<tr>
									<td> Apellidos:</td>
									<td> <input type="text" id="lastname" name="lastname"></td>
								</tr>
								<tr>
									<td> Cédula de Identidad:</td>
									<td> <input type="text" id="cedula" name="cedula"></td>
								</tr>
								<tr>
									<td> Usuario:</td>
									<td> <input type="text" id="username" name="username"></td>
								</tr>
								<tr>
									<td> Contraseña:</td>
									<td>  <input type="password" id="pwd1" name="pwd1"></td>
								</tr>
								<tr>
									<td> Repetir Contraseña:</td>
									<td>  <input type="password" id="pwd2" name="pwd2"></td>
								</tr>
								<tr>
									<td> Tipo de Usuario:</td>
									<td> 
										<input type="radio" name="medico" id="medico" value=1>Fisioterapeuta<br>
										<input type="radio" name="medico" id="medico" value=2>Interpretador
									</td>
								</tr>
							</table>
					</section>
				</div>
			</div>
		</div>
		<div class="5grid-layout" id="footer1">
			<div class="row">
				<div class="12u">
					<section id="fbox1">
						<p style="text-align:right;"><input class="button-style1" type="submit" value="Continuar"/></p></p>	
					</section>
				</div>
			</div>
		</div>
		</form>

	</div>
	<?php include("footer.php")?>
</body>
</html>