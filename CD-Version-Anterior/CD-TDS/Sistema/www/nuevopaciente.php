<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que contiene el formulario para agregar un nuevo paciente.
<!-->

<?php

session_start();
include_once ("FachadaBD.php");

/*	Funcion que busca en la base de datos los dispositivos posibles 
	a usar por un paciente y los muestra en el HTML para ser 
	seleccionados.
*/
function dispositivos(){

	$fbd = FachadaBD::getInstance();
	$result = $fbd->consultarDispositivosPosiblesBD();
	while (($row = oci_fetch_array($result, OCI_BOTH))) {
		$var = str_replace(" ", "_", $row[0]);
		echo '<input type="checkbox" name="'.$var.'cb" value="Y"/> '.$row[0].' con frecuencia 
		<select name="'.$var.'t">
			<option value="">Seleccione...</option>
			<option value="1">Siempre</option>
			<option value="0.75">Frecuentemente</option>
			<option value="0.5">Algunas veces</option>
			<option value="0.25">Rara vez</option>
			</select><br>';
	}
}
?>

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
					<h1><a href="#" class="mobileUI-site-name">Registro de Pacientes</a></h1>
					<p>Hospital J.M. de los Ríos</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="12u">
				<div class="5grid-layout" id="menu">
					<nav class="mobileUI-site-nav">
						<ul>
							<li><a href="index.php">Home</a></li>
							<li class="current_page_item"><a href="#"> Nuevo Paciente</a></li>
							<li><a href="nuevoEFA.php"> Nuevo EFA</a></li>
							<li><a href="consultarpaciente.php"> Consultar Paciente</a></li>
							<li><a href="eliminarpaciente.php">Eliminar Paciente</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</header>
</div>
<div id="wrapper">
	<form action="validarpacientenuevo.php" method="post">
	<div class="5grid-layout" id="welcome">
		<div class="row">
			<div class="6u">
				<section class="content">
					<h2>Datos Personales del Paciente</h2>
					Nombres: <input type="text" name="nombre"><br>
					Apellidos: <input type="text" name="apellido"><br>
					Identificación: <input type="text" name="id"><br>
				</section>
			</div>
			<div class="6u">
				<section class="content">
					<h2><br></h2>
					Profesión: <input type="text" name="profesion"><br>
					Lugar de Residencia: <input type="text" name="lugarres"><br>
					Fecha de Nacimiento: <input type="date" name="bday"><br>
				</section>
			</div>

		</div>
	</div>
	<div class="5grid-layout" id="welcome">
		<div class="row">
			<div class="12u">
				<section class="content">
					<h2>Datos del Historial del Paciente</h2>
					Diagnóstico que presentó inicialmente el paciente: <input type="text" name="diagnostico"><br>
					Intervenciones Quirúrgicas: <input type="text" name="operaciones"><br>
					Dispositivos que utiliza el paciente: <br><?php dispositivos();?><br>
				</section>
			</div>
		</div>
	</div>
	<div class="5grid-layout" id="footer1">
		<div class="row">
			<div class="12u">
				<section id="fbox1">
					<p style="text-align:right;"><input class="button-style1" type="submit" value="Ingresar Paciente"/></p>
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
				<p>&copy; Laboratorio de Marcha | Hospital J.M de los Ríos   &nbsp; </p><a href="logout.php" class="button-style1" >Cerrar sesión</a></p>
			</section>
		</div>
	</div>
</div>
</body>
</html>