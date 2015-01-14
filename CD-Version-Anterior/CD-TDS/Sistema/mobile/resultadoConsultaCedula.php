<!DOCTYPE html>
<?php session_start();
/**
 * En esta vista se muestra el resultado de la consulta por cedula.
 *
 * @author: Veronica, Andrea, Daniela & Ruben.
 */
 
include_once ("FachadaBD.php");
include_once("Paciente.php");

/**  
 * Realiza la busqueda por cedula. 
 *
 * Funcion que se encarga de realizar la busqueda en la base de datos a partir de
 * la cedula del paciente e imprime los resultados en pantalla.
 * @return $paciente: Retorna, si existe, el paciente con la cedula dada.
 * @author: Veronica, Andrea, Daniela & Ruben.
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

/**
 * Funcion que muestra los dispositivos que utiliza el paciente y el grado en que los usa.
 *
 * En esta función se consultan los dispositivos que usa el paciente y se imprimen estos
 * junto con su grado de uso.
 * @author: Veronica, Andrea
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
    <title>Datos del Paciente</title>
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
      <a class ="icon" href="nuevoPaciente.php"><span class="glyphicon glyphicon-plus-sign"></span></a>
      <a class ="icon" href="nuevoEFA.php"><span class="glyphicon glyphicon-folder-open"></span></a>
      <a class ="icon selected" href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-search"></span></a>
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
 <?php $paciente = realizarBusqueda() ?>
  <div>
     <p class="titulo"> <?php echo $paciente->getNombres()." ".$paciente->getApellidos();?> </p>
 </div>
 
 
  <div class="panel-group trans" id="accordion">
  <div class="panel panel-default trans2">
    
      <h4 class="panel-title trans2">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="titulo2">
          Datos Personales
        </a>
      </h4>
    
    <div id="collapseOne" class="panel-collapse collapse in trans2">
      <div class="panel-body">
        <ul>
                <li> Identificación: <?php echo $paciente->getCI();?></li>
                <li> Profesión: <?php echo $paciente->getProfesion();?></li>
                <li> Lugar de Residencia: <?php echo $paciente->getLugarRes();?></li>
                <li> Fecha de Nacimiento: <?php echo $paciente->getFechaNac();?></li>
        </ul>
      </div>
    </div>
  </div>
    <div class="panel panel-default trans2">
    
      <h4 class="panel-title trans2">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="titulo2">
          Datos de Historial
        </a>
      </h4>
    
    <div id="collapseTwo" class="panel-collapse collapse trans2">
      <div class="panel-body">
        <ul>
                    <li> ID del Historial del paciente: <?php echo $paciente->getID_Historial();?></li>
                    <li> Diagnóstico que presentó inicialmente el paciente: <?php echo $paciente->getDiagnostico();?></li>
                    <li> Intervenciones Quirúrgicas: <?php echo $paciente->getInterQuir();?><li>
                    <li> Dispositivos que utiliza el paciente:<br><ul> <?php muestraDisp();?></ul><li>
                </ul>
      </div>
    </div>
  </div>
 </div>
 
 
 <!--
 <div class="row">
   <div class="col-xs-12 col-md-7 trans ">	
	  <div class="col-xs-12 col-md-5 trans2" >	
	    <p>Datos Personales</p>
            <ul>
                <li> Identificación: <?php echo $paciente->getCI();?></li>
                <li> Profesión: <?php echo $paciente->getProfesion();?></li>
                <li> Lugar de Residencia: <?php echo $paciente->getLugarRes();?></li>
                <li> Fecha de Nacimiento: <?php echo $paciente->getFechaNac();?></li>
            </ul>
	  </div>
  </div>
 </div>
  <div class="row">
  <div class="col-xs-12 col-md-7 trans ">	
	  <div class="col-xs-12 col-md-5 trans2">	
            <p>Datos Historial</p>
                <ul>
                    <li> ID del Historial del paciente: <?php echo $paciente->getID_Historial();?></li>
                    <li> Diagnóstico que presentó inicialmente el paciente: <?php echo $paciente->getDiagnostico();?></li>
                    <li> Intervenciones Quirúrgicas: <?php echo $paciente->getInterQuir();?><li>
                    <li> Dispositivos que utiliza el paciente:<br><ul> <?php muestraDisp();?></ul><li>
                </ul>
	  </div>
  </div>
 </div>
 -->
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
