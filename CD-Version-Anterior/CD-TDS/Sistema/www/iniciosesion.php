<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que muestra el formulario de inicio de sesion para los usuarios del sistema.
<!-->

<html>
<head>
<title>Laboratorio</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<noscript>
<link rel="stylesheet" href="css/5grid/core.css" />
<link rel="stylesheet" href="css/5grid/core-desktop.css" />
<link rel="stylesheet" href="css/5grid/core-1200px.css" />
<link rel="stylesheet" href="css/5grid/core-noscript.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/style-desktop.css" />
</noscript>
<script src="css/5grid/jquery.js"></script>
<script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none"></script>
<!--[if IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->
</head><body>
<div id="header-wrapper">
	<header id="header" class="5grid-layout">
		<div id="row">
			<div id="12u">
				<div id="logo">
					<h1><a href="#" class="mobileUI-site-name">Inicio de Sesion</a></h1>
					<p>Hospital J.M. de los Ríos</p>
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
				
					<h2>Inicio de Sesion</h2>
						<form style="text-align:center;" class="s" action="validar_usuario.php" method="post">
							Usuario: <input type="text" id="usuario" name="usuario" size="20" maxlength="20" /><br>
							Contraseña: <input type="password" id="password" name="password" size="10" maxlength="10" /><br>
							<input class="button-style1" type="submit" value="Iniciar Sesion" />
						</form>
					
					<a href="registro1.php" class="button-style1">Registrarse</a></p>
					
				</section>
			</div>
		</div>
	</div>
</div>
<div class="5grid-layout" id="copyright">
	<div class="row">
		<div class="12u">
			<section align="right" style="margin-right: 62px;">
				<p>&copy; Laboratorio de Marcha | Hospital J.M de los Ríos &nbsp;&nbsp;&nbsp;&nbsp;              
			</section>
		</div>
	</div>
</div>
</body>
</html>