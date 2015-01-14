<?php
/**
 *
 * Se obtiene la tabla de caracteristicas de marcha asociada al usuario.
 * @method session_start(): funciona para iniciar la sesion de usuario.
 * @method obtenerCM2():  obtiene e imprime las caracteristicas de marcha.
 * @author: Veronica, Andreina ,Daniela & Ruben
 * @version: 1.0
 * @ignore: Favor documentar de esta manera.
 */

 /*
  * Método que inicia la sesión de un ususario
  * @author: Veronica, Andreina.
  */
session_start(); 

include_once ('FachadaBD.php');
include_once ("EFA_tab.php");

/*
 * Función que obtiene e imprime las caracteristicas de marcha.
 *
 * Esta función obtiene e imprime la tabla de las caracteristicas de marcha
 * Imprimiendo las etiquetas y los grados asociados al usuario que la pide
 *
 * @author: Veronica & Andreina
 */
function obtenerCM2(){
    $fbd = FachadaBD::getInstance();
    $marcha = $fbd->consultarCM_etiquetas();
	$etiqueta1;
	$etiqueta2;
	$longitud=0;
	$grados;

    while(($row1 = oci_fetch_array($marcha, OCI_BOTH))){        
		$etiqueta1[] =$row1[0];		
		$etiqueta2[] =$row1[0];
		$longitud = $longitud +1;
    };
	
	$table =  '<table class="tablita">';
	$table .= '<tr class="tablita"><th></th>';
	
	for($v=0; $v<$longitud; $v++){
	
		$table .= "<th>";
		$table .=$etiqueta2[$v];
		$table .= "</th>";
	
	};
	$table .= "</tr>";
	
	$fbd1 = FachadaBD::getInstance();
	
	for($i=0; $i<$longitud; $i++){
	
		$table .= "<tr>";
		$table .= "<th>";
		$table .=$etiqueta1[$i];
		$table .= "</th>";
	
		for($j=0; $j<$longitud; $j++){
		
			$gr = $fbd1->consultarCM_grado($etiqueta1[$i], $etiqueta2[$j]);
			$row2 = oci_fetch_array($gr, OCI_BOTH);
			$grados[] = $row2[0];
			$table .= '<td class="campo">';
			$table .=$row2[0];
			$table .= "</td>";
		
		};
		
		$table .= "</tr>";
		
	};
	
	$table .= "</table> <br><br>";							
	echo $table;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Perfil</title>
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
      <a class ="icon selected" href="perfil.php"><span class="glyphicon glyphicon-home"></span></a>
      <a class ="icon" href="nuevoPaciente.php"><span class="glyphicon glyphicon-plus-sign"></span></a>
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
 <!-- Parámetros de Perfil -->
 <div class ="trans">
 <div class ="trans2">
  <div class="table-responsive">			
  <h4 class="titulo2">
      Tipos de Marcha
  </h4>
 
     <?php obtenerCM2(); ?>
   
   </div>
  </div> 
 </div>
 
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
