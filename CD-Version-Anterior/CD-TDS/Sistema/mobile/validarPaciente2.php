<?php
 session_start();
 include_once ("FachadaBD.php");
 include_once("Paciente.php");

/**
 * Funcion que busca en la base de datos los dispositivos posibles 
 * a usar por un paciente y los muestra en el HTML para ser 
 * seleccionados.
 */
function dispositivos(){

	$fbd = FachadaBD::getInstance();
	$result = $fbd->consultarDispositivosPosiblesBD();
	while (($row = oci_fetch_array($result, OCI_BOTH))) {
		$var = str_replace(" ", "_", $row[0]);
		echo '<div class="form-group et2"><input type="checkbox" name="'.$var.'cb" value="Y"/> '.$row[0].'  
		<select class="sel2 trans" name="'.$var.'t">
			<option value="">Seleccione...</option>
			<option value="1">Siempre</option>
			<option value="0.75">Frecuentemente</option>
			<option value="0.5">Algunas veces</option>
			<option value="0.25">Rara vez</option>
                        </select></div>';
	}
}

/**
 * Funcion que verifica los primeros campos de la vista nuevoPaciente.php
 * @return boolean: Retorna true si es valido y false en caso contrario.
 */
function verificar_campos(){
   $valido=true;
   if ((trim($_POST["diagnostico"]) == "") | 
       (trim($_POST["cirugias"]) == "")){
       $valido=false;
   }
   return $valido;
}
/**
 * Funcion que verifica si el paciente es valido y agrega a este a la BD.
 */
function agregar_paciente(){
        // echo '<div class="alert alert-danger">Todos los campos son obligatorios. Por favor, intente de nuevo.'.$_POST["diagnostico"].'</div>';
    $fbd = FachadaBD::getInstance();
    $cedula = $_SESSION["cedula"];
	  $result = $fbd->consultarDispositivosPosiblesBD();

    $valido = verificar_campos();

    if (!$valido) {
	    echo '<div class="alert alert-danger">Todos los campos son obligatorios. Por favor, intente de nuevo.</div>'; 
	  } else {
	    $valido = !($fbd->validarPacienteBD($cedula));

	    if ($valido) {
	    	$paciente = new Paciente();
	    	$paciente->setNombres($_SESSION["nombre"]);
	    	$paciente->setApellidos($_SESSION["apellido"]);
	    	$paciente->setCI($_SESSION["cedula"]);
	    	$paciente->setProfesion($_SESSION["profesion"]);
	    	$paciente->setLugarRes($_SESSION["residencia"]);
	    	$paciente->setFechaNac($_SESSION["nacimiento"]);
	    	$paciente->setDiagnostico($_POST["diagnostico"]);
	    	$paciente->setInterQuir($_POST["cirugias"]);

	    	$fbd->agregarPacienteBD($paciente);

	    	while (($row = oci_fetch_array($result, OCI_BOTH))) {
	    		$var = str_replace(" ", "_", $row[0]);
		    	if (isset($_POST[$var.'cb'])) {
		    		if ($_POST[$var.'cb'] == "Y") {
		    			$fbd->agregarDispositivosBD($cedula, $row[0], $_POST[$var.'t']);
		    		}
		    	}
            }

	        header('Location: p_creado.php');
	        exit;
	    } else{
           echo '<div class="alert alert-danger">El usuario ya esta en la base de datos.</div>'; 
	       
	    }
	}
 
}
	

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Datos de Historial</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/mystyle.css" rel="stylesheet" media="screen">

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
      <a class ="icon selected" href="nuevoPaciente.php"><span class="glyphicon glyphicon-plus-sign"></span></a>
      <a class ="icon" href="nuevoEFA.php"><span class="glyphicon glyphicon-folder-open"></span></a>
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
 <!-- Consultar Paciente-->
  <div>
     <p class="titulo">Datos de Historial</p>
 </div>
 <div class="">
  <div class="trans">	
	  <form role="form" action="validarPaciente2.php" method="post">
		  <div class="form-group">
                        <?php agregar_paciente(); ?>
			<label for="exampleInputEmail1">Diagnostico Inicial</label>
			<input type="text" class="form-control" id="diagnostico" name="diagnostico" placeholder="Gripe">
			<label for="exampleInputEmail1">Intervenciones Quirurgicas</label>
			<input type="text" class="form-control" id="cirugias" name="cirugias" placeholder="Ninguna">
      <?php dispositivos();?>
      </div>
      <button type="submit" class="btn btn-warning btn-block" id="login" class="boton">Siguiente</button>
          </form>
  </div>
 </div>
 
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
