<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que muestra el formulario para el ingreso de los datos de nuevos usuarios.
<!-->


<html>
<head>
<title>Laboratorio</title>
<meta http-equiv="content-type" content="text/html;  charset=UTF-8" />
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
					<h1><a href="#" class="mobileUI-site-name">Registro de Pacientes</a></h1>
					<p>Hospital J.M. de los Ríos</p>
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
					<h2>Datos Personales del Medico</h2>
						Nombres: <input type="text" id="firstname" name="firstname"><br>
						Apellidos: <input type="text" id="lastname" name="lastname"><br>
						Cédula de Identidad: <input type="text" id="cedula" name="cedula"><br>
						Usuario: <input type="text"  id="username" name="username"><br>
						Contraseña: <input type="password" id="pwd1" name="pwd1"><br>
						Repetir Contraseña: <input type="password" id="pwd2" name="pwd2"><br>
						Tipo de Usuario: <br><br>
						<input type="radio" name="medico" id="medico" value=1>Fisioterapeuta<br>
						<input type="radio" name="medico" id="medico" value=2>Interpretador
						<br><br>
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
<div class="5grid-layout" id="copyright">
	<div class="row">
		<div class="12u">
			<section align="right" style="margin-right: 62px;">
				<p>&copy; Laboratorio de Marcha | Hospital J.M de los Ríos &nbsp;&nbsp;&nbsp;&nbsp;</p>
			</section>
		</div>
	</div>
</div>
</body>
</html>