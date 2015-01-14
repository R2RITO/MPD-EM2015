<?php
/**
 * En esta vista se muestra una tabla con los resultados de la consulta de pacientes por nombre.
 *
 * @author: Daniela & Ruben.
 */
session_start();
include_once ("FachadaBD.php");
include_once("Paciente.php");


/**	
 * Funcion que busca pacientes por nombre en la BD.
 * 
 * Obtiene el String que se desea buscar y se divide este por espacios para
 * ver si el usuario coloco el nombre y apellido, 
 * luego se realiza la consulta mostrando los resultados en una tabla. 
 * 
 * @author: Daniela & Ruben
 */
function realizarBusquedaNombre(){

    $string = $_GET['nombre'];
    $nombres =  preg_split("/[\s]+/", $string);


    if (count($nombres) >= 2){
        $nombre = $nombres[0];
        $apellido = $nombres[1];
    } else if ( count($nombres) == 1){
        $nombre = $nombres[0];
        $apellido = NULL;
    } else {
        $nombre = "";
        $apellido = NULL;
    }

    $fbd = FachadaBD::getInstance();
    $results = $fbd->consultarPacienteNombre($nombre,$apellido);

    echo '<div class="table-responsive">';
    echo '<table class="table">';
    echo '<tr class="tablita">';
    echo "<th>Nombres</th>";
    echo "<th>Apellidos</th>";
    echo "<th>Cedula</th>";
    echo "</tr>";
	
    while (($row = oci_fetch_array($results, OCI_BOTH))) {
        echo '<tr class="tablita">';
        $link = '"resultadoConsultaCedula.php?cedula='.$row[2].'"';
        for ($i=0; $i <= 2; $i++) {
            echo "<td><a href=$link>".$row[$i]."</a></td>";
	}
        echo "</tr>";
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

 
  <div>
     <p class="titulo">Resultados</p>
  </div>
 
 <?php realizarBusquedaNombre();?>

 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
