<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que valida los campos ingresados cuando se queire agregar
	un examen fisico articular nuevo.
<!-->

<script type="text/javascript">
    function updateTextInput1(val) {
      document.getElementById('textInput1').value=val; 
    }

    function updateTextInput2(val) {
      document.getElementById('textInput2').value=val; 
    }
</script>

<?php

session_start();

include_once ("FachadaBD.php");
include_once ("EFA_tab.php");
include_once ("D_Peso.php");
include_once ("dominio_fijo_t.php");
include_once ("etiqueta_t.php");

/*	Funcion que agrega un examen fisico articular nuevo en la base de datos.
*/
function agregarEFA(){

	$fbd = FachadaBD::getInstance();
	$pacientevalido = $fbd->validarPacienteBD($_POST['cedula']);

	$valido = validarPeso() && validarTFDI() && validarTFDD() && validarCM() && $pacientevalido && validarCedula();

	if ($valido) {

		$peso = new D_Peso();
		if (trim($_POST['P']) != "") {
			$peso->setValor(trim($_POST['P']));
		}
		if (($_POST['PE']) <> '') {
			$peso->setLabel($_POST['PE']);
		}

		$TFDI = new dominio_fijo_t();

		if ($_POST['TFDI'] <> '') {
			$TFDI->setVal($_POST['TFDI']);
		}
		
		$TFDI->setDom('Tono_Flexores_Dorsales_Izq');

		if ($_POST['TFDIE'] <> '') {
			$TFDI->setEt($_POST['TFDIE']);
			$TFDI->setGrado($_POST['textInput1']);
		}

		$TFDI->agregarTonoFlexDor();

		$TFDD = new dominio_fijo_t();

		if ($_POST['TFDD'] <> '') {
			$TFDD->setVal($_POST['TFDD']);
		}
		
		$TFDD->setDom('Tono_Flexores_Dorsales_Der');

		if ($_POST['TFDDE'] <> '') {
			$TFDD->setEt($_POST['TFDDE']);
			$TFDD->setGrado($_POST['textInput2']);
		}

		$TFDD->agregarTonoFlexDor();

		$caracmarcha = new etiqueta_t();

		$caracmarcha->setEt1($_POST['CM']);
		$caracmarcha->setDom('Carac_Marcha');

		$ci = $_POST['cedula'];

		$efa_tab = new EFA_tab();
		$efa_tab->setIDPersona($ci);

		$fbd = FachadaBD::getInstance();
		$hist = $fbd->consultarHistorialBD($ci);

		$efa_tab->setIDHistorial($hist);
		$efa_tab->setFechaExamen($_POST['testdate']);
		$efa_tab->setMedicoInt($_POST['medicoref']);

		$efa_tab->setPeso($peso);
		$efa_tab->setTonoFlexDorIzq($TFDI);
		$efa_tab->setTonoFlexDorDer($TFDD);
		$efa_tab->setCaracMarcha($caracmarcha);

		$efa_tab->agregarHistoria();

		header("Location: agregado.html");
		exit();

	} else {
		echo "** Revise los errores antes de continuar";
	}
}

function validarCedula(){

	if (trim($_POST['cedula']) == '') {
		echo "** Este campo es obligatorio";
		return false;
	} elseif (!preg_match("/^[[:digit:]]+$/", $_POST['cedula'])) {
		echo "** El campo solo puede ser rellenado con numeros";
		return false;
	}

	return true;
}

function validarFecha(){

	if (trim($_POST['testdate']) == '') {
		echo "** Este campo es obligatorio";
		return false;
	} elseif (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $_POST['testdate'])) {
		echo "** El formato para fechas es MM/DD/AAAA";
		return false;
	}

	return true;
}

function validarPeso(){

	if ((trim($_POST['P']) == '') && ($_POST['PE'] == '')) {
		echo "** Debe llenar al menos una opcion para el atributo Peso";
		return false;
	}

	return true;
}

function validarTFDI(){

	if ($_POST['TFDI'] == '') {
		echo "** Debe seleccionar al menos una opcion para el dominio Tono Flexor Dorsal Izquierdo";
		return false;
	}

	return true;
}

function validarTFDD(){

	if ($_POST['TFDD'] == '') {
		echo "** Debe seleccionar al menos una opcion para el dominio Tono Flexor Dorsal Derecho";
		return false;
	}

	return true;
}

function validarCM(){

	if ($_POST['CM'] == '') {
		echo "** Debe llenar una opcion para la característica de marcha";
		return false;
	}

	return true;
}

function buscarEtiquetasPeso(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosiblePesoBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

function buscarEtiquetasTFDI(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

function buscarDominioTFDI(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarDominioFijoPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

function buscarDominioTFDD(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarDominioFijoPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

function buscarEtiquetasTFDD(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

function buscarEtiquetasCaracMarcha(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosibleCaracMarchaBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}


?>

<html>
<head>
<title>Laboratorio</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
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
							<li><a href="nuevopaciente.php"> Nuevo Paciente</a></li>
							<li class="current_page_item"><a href="#">Nuevo EFA</a></li>
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
	<form action="validarhistpaciente.php" method="post">
	<div class="5grid-layout" id="welcome">
		<div class="row">
			<div class="12u">
				<section class="content">
					<h2>Datos del Examen</h2>
					Cédula del Paciente: <input type="text" name="cedula"><?php validarCedula();?><br>
					Fecha del Examen: <input type="date" name="testdate"><?php validarFecha();?><br>
					Nombre del médico <br> que envió al paciente: <input type="text" name="medicoref"><br>
				</section>
			</div>
		</div>
	</div>
	<div class="5grid-layout" id="welcome">
		<div class="row">
			<div class="6u">
				<section class="content">
					<h2>Datos Recogidos</h2>
					<input type="text" name="P"> Peso<br>
					<select name="TFDI">
						<option value="">Seleccione...</option>
						<?php buscarDominioTFDI();?>
						</select> Tono Flexor Dorsal Izquierdo<br><br>
					<select name="TFDD"> 
						<option value="">Seleccione...</option>
						<?php buscarDominioTFDD();?>
						</select> Tono Flexor Dorsal Derecho<br><br>
					<select name="CM">
						<option value="">Seleccione...</option>
						<?php buscarEtiquetasCaracMarcha();?>
						</select> Caracteristicas de Marcha <?php validarCM();?><br><br>
						<BR>
				</section>
			</div>
			<div class="6u">
				<section class="content">
					<h2></h2>
					<h1>Puede completar su historia agregándole etiquetas a los resultados:</h1><br>
					Etiqueta
					<select name="PE">
						<option value="">Seleccione...</option>
						<?php buscarEtiquetasPeso();?>
						</select> de Peso<?php validarPeso();?><br><br>
					Etiqueta
					<select name="TFDIE">
						<option value="">Seleccione...</option>
						<?php buscarEtiquetasTFDI();?>
						</select> Tono Flexor Dorsal Izquierdo <?php validarTFDI();?><br><br>
						con grado <input type="range" name="TFDIG" min="0.0" max="1.0" step="0.1" onchange="updateTextInput1(this.value);"><input type="text" id="textInput1" value=""><br><br>
					Etiqueta
					<select name="TFDDE"> 
						<option value="">Seleccione...</option>
						<?php buscarEtiquetasTFDD();?>
						</select> Tono Flexor Dorsal Derecho <?php validarTFDD();?><br><br>
						con grado <input type="range" name="TFDDG" min="0.0" max="1.0" step="0.1" onchange="updateTextInput2(this.value);"><input type="text" id="textInput2" value=""><br><br>
						<BR>
				</section>
				<?php agregarEFA();?>
			</div>
		</div>
	</div>
	<div class="5grid-layout" id="footer1">
		<div class="row">
			<div class="12u">
				<section id="fbox1">
					<p style="text-align:right;"><input class="button-style1" type="submit" value="Ingresar Examen"/></p>	
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