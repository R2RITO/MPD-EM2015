<?php
/**
 * En esta vista se muestran los resultados de las comparaciones entre un paciente y todos los demas.
 * 
 * Se realizan las comparaciones con respecto a los dispositivos usados y
 * el grado de uso que tienen los pacientes.
 *
 * @global $GLOBALS['alfa']: Variable global de todo el documento que guarda el alfacorte usado. 
 * @author: Daniela & Ruben
 */
session_start();
include_once ("FachadaBD.php");
include_once("Paciente.php");

$GLOBALS['alfa'] = 0;

function realizarBusquedaCedula(){

    $cedula = $_GET['cedula'];

    $fbd = FachadaBD::getInstance();
    $resultado = $fbd->consultarPacienteBD($cedula);
    $paciente = new Paciente();

    if (($output = oci_fetch_array($resultado, OCI_BOTH))){
        $paciente->setCI($output[0]);
        $paciente->setNombres($output[1]);
        $paciente->setApellidos($output[2]);
        $paciente->setProfesion($output[3]);
        $paciente->setLugarRes($output[4]);
        $paciente->setFechaNac($output[5]);
        $paciente->setID_Historial($output[6]);
        $paciente->setDiagnostico($output[7]);
        $paciente->setInterQuir($output[8]);
    }

    return $paciente;   
}

/**
 * Función de comparacion entre los pacientes.
 *
 * Consulta en la base de datos con la cedula dada para encontrar pacientes similares
 * dependiendo de los dispositivos que usa y frecuencia de uso. Muestra ordenadamente 
 * en pantalla tan solo los 1-8 pacientes con mayor similitud.
 *
 * @author: Daniela & Ruben.
 */
function realizarBusquedaComparacion(){

    $cedula = $_GET['cedula'];
	
    $fbd = FachadaBD::getInstance();

    // Mientras los resultados sean mayores de 8
    // se aumenta el alfa.
    do {
        $results = $fbd->compararDispositivosIgualesBDAlfa($cedula,$GLOBALS['alfa']);
        $nrows = oci_fetch_all($results, $output, null, null, OCI_FETCHSTATEMENT_BY_ROW + OCI_NUM);
        $GLOBALS['alfa'] = $GLOBALS['alfa'] + 0.1;
    } while( $GLOBALS['alfa'] <= 0.9 && $nrows > 10);

    $j = 0;

    if ($nrows > 0){
       // Obtiene una lista de columnas.
       foreach ($output as $key => $row) {
            $mid[$key]  = $row[3];
       }
       // Ordena los datos de forma descendiente con $mid.
       // Agrega $output como ultimo parametro para tener una llave comun.
       array_multisort($mid, SORT_DESC, $output);
    }
    echo '<div class="table-responsive">';
    echo '<table class="table">';
    echo '<tr class="tablita">';
    echo "<th>Nombres</th>";
    echo "<th>Apellidos</th>";
    echo "<th>Cedula</th>";
    echo "<th>Semejanza</th>";
    echo "<th>Prom.Semejanza</th>";
    echo "</tr>";
	
    while ( $j < $nrows ) {
        echo '<tr class="tablita">';

	for ($i=0; $i <= 4; $i++) {
            $link = '"resultadoConsultaCedula.php?cedula='.$output[$j][2].'"';
            if ($i >= 0 && $i <3){
                echo "<td><a href=$link>".$output[$j][$i]."</a></td>";
             } else {
                echo "<td>".$output[$j][$i]."</td>";
             }
        }
        echo "</tr>";
        $j = $j + 1;
    }
    echo "</table>";
}

?>

<!DOCTYPE html>
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

 <?php $paciente =  realizarBusquedaCedula(); ?>
 
  <div>
     <p class="titulo"><?php echo "Resultados de ".$paciente->getNombres()." ".$paciente->getApellidos();?></p>
  </div>
 
 <?php realizarBusquedaComparacion();?>

 <p class="titulo"><?php echo "Umbral: ".($GLOBALS['alfa']-0.1); ?></p>
 
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
