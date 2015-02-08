<!DOCTYPE HTML>
<!--/> 
	Arturo Voltattorni 10-10774
	Ramon Marquez	   10-10849
	Esteban Oliveros   10-11252
	Archivo que muestra el formulario de inicio de sesion para los usuarios del sistema.
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
						<h1><a href="#" class="mobileUI-site-name">Inicio de Sesi&oacute;n</a></h1>
						<p>Hospital Ortop&eacute;dico Infantil</p>
					</div>
				</div>
			</div>
		</header>
	</div>
	<div id="wrapper">
		<div class="5grid-layout" id="page-wrapper">
			<div class="row">
				<div class="12u">
					<section id="pbox1">
					
						<h2>Inicio de Sesi&oacute;n</h2>
						<div class="row">
							<div class="col-md-3 col-sm-6 col-md-push-4">
								<form style="text-align:center;" class="s" action="validar_usuario.php" method="post">
									Usuario: <input type="text" id="usuario" name="usuario" size="20" maxlength="20" class="form-control"/><br>
									Contrase&ntilde;a: <input type="password" id="password" name="password" size="10" maxlength="10" class="form-control" /><br>
									<input class="button-style1" type="submit" value="Iniciar Sesion" />
								</form>
							</div>
						</div>
						
						<a href="registro.php" class="button-style1">Registrarse</a></p>
						
					</section>
				</div>
			</div>
		</div>
	</div>
	<?php include("footer.php"); ?>
</body>
</html>