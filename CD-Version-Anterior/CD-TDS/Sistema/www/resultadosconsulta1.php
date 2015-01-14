<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que muestra los resultados del primer tipo de consulta de pacientes.
<!-->

<?php

session_start();
include_once ("FachadaBD.php");
include_once("Paciente.php");

/*	Funcion que se encarga de realizar la busqueda en la base de datos a partir de
	la cedula del paciente e imprime los resultados en pantalla.
*/
function realizarBusqueda(){

	$cedula = $_GET['cedula'];

	$fbd = FachadaBD::getInstance();
	$resultado = $fbd->consultarPacienteBD($cedula);
	$paciente = new Paciente();

    if (($row = oci_fetch_array($resultado, OCI_BOTH))){
        $paciente->setCI($row[0]);
        $paciente->setNombres($row[1]);
        $paciente->setApellidos($row[2]);
        $paciente->setProfesion($row[3]);
        $paciente->setLugarRes($row[4]);
        $paciente->setFechaNac($row[5]);
        $paciente->setID_Historial($row[6]);
        $paciente->setDiagnostico($row[7]);
        $paciente->setInterQuir($row[8]);
    }

	return $paciente;	
}

/*	Funcion que muestra los dispositivos que utiliza el paciente y
	el grado en que los usa.
*/
function muestraDisp(){

	$cedula = $_GET['cedula'];

	$fbd = FachadaBD::getInstance();
	$resultado = $fbd->consultarDispositivosBD($cedula);
	
	while (($row = oci_fetch_array($resultado, OCI_BOTH))) {
		echo "<li>&nbsp;&nbsp;&nbsp;&nbsp;".$row[0]. " en un grado de ".$row[1]."</li>";
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
							<?php 
							if ($_SESSION['esfisio'] == 1){
								?>
							<li><a href="index.php">Home</a></li>
							<li><a href="nuevopaciente.php"> Nuevo Paciente</a></li>
							<li><a href="nuevoEFA.php">Nuevo EFA</a></li>
							<li class="current_page_item"><a href="consultarpaciente.php"> Consultar Paciente</a></li>
							<li><a href="eliminarpaciente.php">Eliminar Paciente</a></li>
								<?php
							}else{ 
								?>
							<li><a href="index.php">Home</a></li>
							<li class="current_page_item"><a href="consultarpaciente.php"> Consultar Paciente</a></li>
								<?php
							}
							?>
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
			<div class="6u">
				<section class="content">
					<h2>Datos Personales del Paciente</h2>
					<?php $paciente = realizarBusqueda();?>
					<ul>
						<li> Nombres: <?php echo $paciente->getNombres();?></li>
						<li> Apellidos: <?php echo $paciente->getApellidos();?></li>
						<li> Identificación: <?php echo $paciente->getCI();?></li>
					</ul>
				</section>
			</div>
			<div class="6u">
				<section class="content">
					<h2><br></h2>
					<ul>
						<li> Profesión: <?php echo $paciente->getProfesion();?></li>
						<li> Lugar de Residencia: <?php echo $paciente->getLugarRes();?></li>
						<li> Fecha de Nacimiento: <?php echo $paciente->getFechaNac();?></li>
					</ul>
				</section>
			</div>

		</div>
	</div>
	<div class="5grid-layout" id="welcome">
		<div class="row">
			<div class="6u">
				<section class="content">
					<h2>Datos del Historial del Paciente</h2>
					<ul>
						<li> ID del Historial del paciente: <?php echo $paciente->getID_Historial();?></li>
						<li> Diagnóstico que presentó inicialmente el paciente: <?php echo $paciente->getDiagnostico();?></li>
					</ul>
				</section>
			</div>
			<div class="6u">
				<section class="content">
					<h2><br></h2>
					<ul>
						<li> Intervenciones Quirúrgicas: <?php echo $paciente->getInterQuir();?><li>
						<li> Dispositivos que utiliza el paciente:<br><ul> <?php muestraDisp();?></ul><li>
					</ul>
				</section>
			</div>
		</div>
	</div>
	<div class="5grid-layout" id="footer1">
		<div class="row">
			<div class="12u">
				<section id="fbox1">
					<p style="text-align:right;"><a href="consultarpaciente.php" class="button-style1">Regresar</a></p>
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