<!DOCTYPE HTML>

<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que muestra el mensaje de exito al eliminar un paciente de la base de datos.
<!-->

<?php

/*
    Script que realiza la verificacion de si el paciente existe o no en la base de datos
    y segun esa verificacion elimina el paciente de la base de datos.
*/

include_once ("FachadaBD.php");
session_start();

echo "<script language=javascript> alert(\"Se eliminará el paciente de forma permanente\");</script>"; 
$fbd = FachadaBD::getInstance();
$valido;

if (!preg_match("/^[[:digit:]]+$/", $_POST["cedula"])) {
	header("Location: noeliminado.php");
	exit;
}

$valido = $fbd->validarPacienteBD($_POST["cedula"]);

if($valido){
	$fbd1 = FachadaBD::getInstance();
	$fbd1 ->eliminarPacienteBD($_POST["cedula"]);
} else{
	header("Location: noeliminado.php");
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
					<h1><a href="#" class="mobileUI-site-name">registro de pacientes</a></h1>
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
							<li><a href="nuevopaciente.php">Nuevo Paciente</a></li>
							<li><a href="nuevoEFA.php">Nuevo EFA</a></li>
							<li><a href='consultarpaciente.php'>Consultar Paciente</a></li>
							<li class="current_page_item"><a href="eliminarpaciente.php">Eliminar Paciente</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</header>
</div>
<div id="wrapper">
	<div class="5grid-layout" id="welcome">
		<div class="row">
			<div class="12u">
				<section class="content">
					<h2>El paciente ha sido eliminado con éxito</h2>
						
				</section>
			</div>
		</div>
	</div>
	<div class="5grid-layout" id="footer1">
		<div class="row">
			<div class="12u">
				<section id="fbox1">
					<p style="text-align:right;"><a href="index.html" class="button-style1">HOME</a></p>	
				</section>
			</div>
		</div>
	</div>
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