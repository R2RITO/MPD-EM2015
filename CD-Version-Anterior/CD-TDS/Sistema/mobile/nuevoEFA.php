
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

/**
 * Funcion que busca las etiquetas del peso almacenadas en 
 * la base de datos para presentarlas al usuario para su
 * seleccion para la busqueda.
 */
function buscarEtiquetasPeso(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosiblePesoBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/**
 * Funcion que busca las etiquetas del tono flexor dorsal izq
 * almacenadas en la base de datos para presentarlas al 
 * usuario para su	seleccion para la busqueda.
 */
function buscarEtiquetasTFDI(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/**
 * Funcion que busca los dominios del tono flexor dorsal izq
 * almacenados en la base de datos para presentarlos al 
 * usuario para su	seleccion para la busqueda.
 */
function buscarDominioTFDI(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarDominioFijoPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/**
 * Funcion que busca los dominios del tono flexor dorsal der
 * almacenados en la base de datos para presentarlos al 
 * usuario para su	seleccion para la busqueda.
 */
function buscarDominioTFDD(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarDominioFijoPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/**	
 * Funcion que busca las etiquetas del tono flexor dorsal der
 * almacenadas en la base de datos para presentarlas al 
 * usuario para su	seleccion para la busqueda.
 */
function buscarEtiquetasTFDD(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/**
 * Funcion que busca las etiquetas de las caracteristicas de marcha
 * almacenadas en la base de datos para presentarlas al 
 * usuario para su	seleccion para la busqueda.
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
