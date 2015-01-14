<?php

session_start();

include_once ("FachadaBD.php");
include_once ("EFA_tab.php");
include_once ("D_Peso.php");
include_once ("dominio_fijo_t.php");
include_once ("etiqueta_t.php");

/** 	
 * Funcion que agrega un examen fisico articular nuevo en la base de datos.
 */
function agregarEFA(){

	$fbd = FachadaBD::getInstance();
	$pacientevalido = $fbd->validarPacienteBD($_POST['cedula']);

	$valido = validarPeso() && validarTFDI() && validarTFDD() && validarCM() && $pacientevalido && validarCedula();

	if ($valido) {

		$peso = new D_Peso();
		if (trim($_POST['peso']) != "") {
			$peso->setValor(trim($_POST['peso']));
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
		$efa_tab->setFechaExamen($_POST['dpYears']);
		echo $_POST['dpYears'];
		$efa_tab->setMedicoInt($_POST['nombreM']);

		$efa_tab->setPeso($peso);
		$efa_tab->setTonoFlexDorIzq($TFDI);
		$efa_tab->setTonoFlexDorDer($TFDD);
		$efa_tab->setCaracMarcha($caracmarcha);

		$efa_tab->agregarHistoria();

		header("Location: agregadoEFA.php");
		exit();
	} else {
		echo '<br><div class="alert alert-danger">Revise los errores antes de continuar.</div>';
	}
}
/**
 * Funcion que valida una cedula.
 * @return boolean: Retorna true si la cedula es valida. false si no lo es.
 */
function validarCedula(){

	if (trim($_POST['cedula']) == '') {
		echo '<br><div class="alert alert-danger">El campo de la cedula es obligatorio</div>';
		return false;
	} elseif (!preg_match("/^[[:digit:]]+$/", $_POST['cedula'])) {
		echo '<br><div class="alert alert-danger">El campo de la cedula solo puede estar rellenado con numeros.</div>';
		return false;
	}

	return true;
}
/**
 * Funcion que valida una fecha.
 * @return boolean: Retorna true si la fecha es valida. false si no lo es.
 */
function validarFecha(){

	if (trim($_POST['dpYears']) == '') {
		echo '<br><div class="alert alert-danger">El campo de fechas es obligatorio.</div>';
		return false;
	} elseif (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $_POST['dpYears'])) {
		echo '<br><div class="alert alert-danger">El formato para fechas es dd-mm-yyyy.</div>';
		return false;
	}

	return true;
}

/**
 * Funcion que valida un peso.
 * @return boolean: Retorna true si el peso es valido. false si no lo es.
 */
function validarPeso(){

	if ((trim($_POST['peso']) == '') && ($_POST['PE'] == '')) {
		echo '<br><div class="alert alert-danger">El atributo peso esta vacio. Por favor, llenelo.</div>';
		return false;
	}

	return true;
}

/**
 * Funcion que valida un tono flexr dorsal izq.
 * @return boolean: Retorna true si el tono flexor dorsal izq es valido. false si no lo es.
 */
function validarTFDI(){

	if ($_POST['TFDI'] == '') {
		echo '<br><div class="alert alert-danger">Debe seleccionar una opcion para el Tono Flexor Dorsal Izquierdo.</div>';
		return false;
	}

	return true;
}

/**
 * Funcion que valida un tono flexor dorsal derecho.
 * @return boolean: Retorna true si el tono flexor dorsal derecho es valido. false si no lo es.
 */
function validarTFDD(){

	if ($_POST['TFDD'] == '') {
		echo '<br><div class="alert alert-danger">Debe seleccionar una opcion para el Tono Flexor Dorsal Derecho.</div>';
		return false;
	}

	return true;
}
/**
 * Funcion que valida la caracteristica de marcha dada.
 * @return boolean: Retorna true si el tono flexor dorsal derecho es valido. false si no lo es.
 */
function validarCM(){

	if ($_POST['CM'] == '') {
		echo '<br><div class="alert alert-danger">Debe seleccionar una opcion para la Caracteristica de Marcha.</div>';
		return false;
	}

	return true;
}
/**
 * Funcion que busca e imprime las etiquetas de peso.
 */
function buscarEtiquetasPeso(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosiblePesoBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}
/**
 * Funcion que busca e imprime las etiquetas del tonoflexor dorsal izquierdo
 */
function buscarEtiquetasTFDI(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}
/**
 * Funcion que busca e imprime los dominios del TFDI
 */
function buscarDominioTFDI(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarDominioFijoPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/**
 * Funcion que busca e imprime los dominios del TFDD
 */
function buscarDominioTFDD(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarDominioFijoPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/**
 * Funcion que busca e imprime las etiquetas del TFDD
 */
function buscarEtiquetasTFDD(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/**
 * Funcion que busca e imprime las etiquetas de las caracteristicas de marcha
 */
function buscarEtiquetasCaracMarcha(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosibleCaracMarchaBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}
?>
<!DOCTYPE HTML>

<html>
  <head>
    <title>Nuevo Examen Fisico Articular</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/mystyle.css" rel="stylesheet" media="screen">
    <link href="css/datepicker.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

<body>  
 <!-- Barra Principal de Opciones -->
 <nav class="navbar navbar-default navFondo" role="navigation">
  <div class="navbar-header">
    <!-- Tiene parametros definidos -->

    <!-- Es Medico o Interpretado -->
    <?php if ($_SESSION['esfisio'] == 1){ ?>
      <a class ="icon" href="perfil.php"><span class="glyphicon glyphicon-home"></span></a>
      <a class ="icon" href="nuevoPaciente.php"><span class="glyphicon glyphicon-plus-sign"></span></a>
      <a class ="icon selected" href="nuevoEFA.php"><span class="glyphicon glyphicon-folder-open"></span></a>
      <a class ="icon" href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-search"></span></a>
				<ul class="dropdown-menu">
					<li><a href="paciente.php">Paciente</a></li>
					<li><a href="generales.php">Generales</a></li>
                                        <li><a href="comparaciones.php">Comparaciones</a></li>
				</ul>
       <a class ="icon" href="consultaBorrarPaciente.php"><span class="glyphicon glyphicon-minus-sign"></span></a></li>	
       <a class ="icon" href="cerrarSesion.php"><span class="glyphicon glyphicon-log-out"></span></a>    
    <?php }else{ ?>
       <a class ="icon selected" href="perfil.php"><span class="glyphicon glyphicon-home"></span></a>
       <a class ="icon" href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-search"></span></a>
				<ul class="dropdown-menu">
					<li><a href="paciente.php">Paciente</a></li>
					<li><a href="generales.php">Generales</a></li>
                                        <li><a href="comparaciones.php">Comparaciones</a></li>
				</ul>
       <a class ="icon" href="cerrarSesion.php"><span class="glyphicon glyphicon-log-out"></span></a>   
    <?php } ?>
 </div>
 </nav>
 <b><?php if ($_SESSION['esfisio'] == 1){ echo "Fisioterapeuta: "; } else { echo "Interpretador: "; } ?></b>
 <b><?php echo $_SESSION['nombre']." ".$_SESSION['apellido'] ; ?></b>
 
 <!-- ================================================== -->
 <!-- Nuevo Examen Fisico Articular -->
  <div>
     <p class="titulo">Datos Examen Fisico Articular</p>
 </div>
 <div class="">
  <div class="trans">	
	  <form role="form" action="validarEFA.php" method="post">
		
		  <div class="form-group">
			<label for="exampleInputEmail1">Cedula</label>
			<input type="text" class="form-control" id="cedula" name="cedula" placeholder="123456789">
			<label for="exampleInputEmail1">Fecha</label>
			<input class="form-control" size="16" type="text"  id="dpYears" name="dpYears" data-date="12-02-2012" data-date-format="yyyy-mm-dd" data-date-viewmode="years">	
                        <label for="exampleInputEmail1">Nombre Medico</label>
			<input type="text" class="form-control" id="nombreM" name="nombreM" placeholder="Nombre de Medico">
                        <label for="exampleInputEmail1">Peso (Kg.)</label>
			<input type="text" class="form-control" id="peso" name="peso" placeholder="123456789">
                  </div>
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
						</select> Características de Marcha<br><br>
						<BR>
	<p>Complete el Examen Fisico Articular, agregando sus etiquetas personalizadas</p>
			<select name="PE">
			    <option value="">Seleccione...</option>
			    <?php buscarEtiquetasPeso();?>
			</select> Peso<br><br>
			<select name="TFDIE">
			<option value="">Seleccione...</option>
			    <?php buscarEtiquetasTFDI();?>
			</select> Tono Flexor Dorsal Izquierdo con grado <input type="range" name="TFDIG" min="0.0" max="1.0" step="0.1" onchange="updateTextInput1(this.value);"><input type="text" name="textInput1" id="textInput1" value=""><br><br>
			<select name="TFDDE"> 
			    <option value="">Seleccione...</option>
			    <?php buscarEtiquetasTFDD();?>
			</select> Tono Flexor Dorsal Derecho con grado <input type="range" name="TFDDG" min="0.0" max="1.0" step="0.1" onchange="updateTextInput2(this.value);"><input type="text" name="textInput2" id="textInput2" value=""><br><br>
		  <button type="submit" class="btn btn-warning btn-block" id="login" class="boton">Ingresar</button>
		  <?php agregarEFA();?>

	  </form>
  </div>
 </div>
 

 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
 	<script src="js/jquery.js"></script>
 <script src="js/bootstrap-datepicker.js"></script>
	<script>
	if (top.location != location) {
    top.location.href = document.location.href ;
  }
		$(function(){
			window.prettyPrint && prettyPrint();
			$('#dp1').datepicker({
				format: 'mm-dd-yyyy'
			});
			$('#dp2').datepicker();
			$('#dp3').datepicker();
			$('#dp3').datepicker();
			$('#dpYears').datepicker();
			$('#dpMonths').datepicker();
			
			
			var startDate = new Date(2012,1,20);
			var endDate = new Date(2012,1,25);
			$('#dp4').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() > endDate.valueOf()){
						$('#alert').show().find('strong').text('The start date can not be greater then the end date');
					} else {
						$('#alert').hide();
						startDate = new Date(ev.date);
						$('#startDate').text($('#dp4').data('date'));
					}
					$('#dp4').datepicker('hide');
				});
			$('#dp5').datepicker()
				.on('changeDate', function(ev){
					if (ev.date.valueOf() < startDate.valueOf()){
						$('#alert').show().find('strong').text('The end date can not be less then the start date');
					} else {
						$('#alert').hide();
						endDate = new Date(ev.date);
						$('#endDate').text($('#dp5').data('date'));
					}
					$('#dp5').datepicker('hide');
				});

        // disabling dates
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('#dpd1').datepicker({
          onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
          }
          checkin.hide();
          $('#dpd2')[0].focus();
        }).data('datepicker');
        var checkout = $('#dpd2').datepicker({
          onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');
		});
	</script>
 

</body>
</html>
