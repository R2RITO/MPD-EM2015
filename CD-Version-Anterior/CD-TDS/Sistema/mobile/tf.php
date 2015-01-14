<?php 
/**
 * Archivo que posee ciertas funciones de tono flexor.
 */
session_start(); 
include_once ('FachadaBD.php');
include_once ("EFA_tab.php");
/**
 * @deprecated: No es usada.
 */
function obtenerTM(){
    $fbd = FachadaBD::getInstance();
    $tono = $fbd->consultarTNBD();

	$table = "<table  border='1'>";
	
	$table .= "<tr><th>etiqueta</th><th>dominio</th><th>grado</th><tr>";
	
    while(($row1 = oci_fetch_array($tono, OCI_BOTH))){
		$table .= "<tr>";
		
		$table .= "<td>";
		$table .=$row1[0];
		$table .= "</td>";
		
		$table .= "<td>";
		$table .=$row1[1];
		$table .= "</td>";
		
		$table .= "<td>";
		$table .=$row1[2];
		$table .= "</td>";
		   
		$table .= "</tr>";
    }
	
	$table .= "</table>";							
	echo $table;
}

/**
 * Muestra la tabla del tono flexor dorsal derecho.
 * @author: Veronica, Andreina
 */
function obtenerTM2I(){
    $fbd = FachadaBD::getInstance();
    $tono = $fbd->consultarTNBD_etiqueta_I();
	$etiquetaT;
	$dominioT;
	$long_e =0;
	$long_d =0;
	$gradoT;
	
	while(($row1 = oci_fetch_array($tono, OCI_BOTH))){
        
		$etiquetaT[] =$row1[0];
		$long_e = $long_e +1;
		

    };
	
	
	$fbd1 = FachadaBD::getInstance();
    $tono1 = $fbd1->consultarTNBD_dominio_I();
	
	while(($row2 = oci_fetch_array($tono1, OCI_BOTH))){
        
		$dominioT[] =$row2[0];
		$long_d = $long_d +1;
		

    };

	$table = '<table class="tablita">';
	$table .= '<tr class="tablita"><th></th>';
	
	for($v=0; $v<$long_d; $v++){
	
		$table .= "<th>";
		$table .=$dominioT[$v];
		$table .= "</th>";
	
	};
	$table .= "</tr>";
	
	for($i=0; $i<$long_e; $i++){
	
		$table .= '<tr class="campo">';
		$table .= "<th>";
		$table .=$etiquetaT[$i];
		$table .= "</th>";
	
		for($j=0; $j<$long_d; $j++){
		
		$fbd2 = FachadaBD::getInstance();
		$tono2 = $fbd2->consultarTNBD_grado_I($dominioT[$j], $etiquetaT[$i]);
		$row3 = oci_fetch_array($tono2, OCI_BOTH);
		$gradoT[] = $row3[0];
		
		$table .='<td class="campo">';
		$table .=$row3[0];
		$table .= "</td>";		
		
		};
		
		$table .= "</tr>";
	
	};
	
	

	$table .= "</table>";							
	echo $table;	
	
}

/**
 * Muestra la tabla del tono flexor dorsal derecho.
 * @author: Veronica, Andreina
 */
function obtenerTM2D(){
    $fbd = FachadaBD::getInstance();
    $tono = $fbd->consultarTNBD_etiqueta_D();
	$etiquetaT;
	$dominioT;
	$long_e =0;
	$long_d =0;
	$gradoT;
	
	while(($row1 = oci_fetch_array($tono, OCI_BOTH))){
        
		$etiquetaT[] =$row1[0];
		$long_e = $long_e +1;
		

    };
	
	
	$fbd1 = FachadaBD::getInstance();
    $tono1 = $fbd1->consultarTNBD_dominio_D();
	
	while(($row2 = oci_fetch_array($tono1, OCI_BOTH))){
        
		$dominioT[] =$row2[0];
		$long_d = $long_d +1;
		

    };

	$table = '<table class="tablita">';
	$table .= '<tr class="tablita"><th></th>';
	
	for($v=0; $v<$long_d; $v++){
	
		$table .= "<th>";
		$table .=$dominioT[$v];
		$table .= "</th>";
	
	};
	$table .= "</tr>";
	
	for($i=0; $i<$long_e; $i++){
	
		$table .= "<tr>";
		$table .= "<th>";
		$table .=$etiquetaT[$i];
		$table .= "</th>";
	
		for($j=0; $j<$long_d; $j++){
		
		$fbd2 = FachadaBD::getInstance();
		$tono2 = $fbd2->consultarTNBD_grado_D($dominioT[$j], $etiquetaT[$i]);
		$row3 = oci_fetch_array($tono2, OCI_BOTH);
		$gradoT[] = $row3[0];
		
		$table .= '<td class="campo">';
		$table .=$row3[0];
		$table .= "</td>";		
		
		};
		
		$table .= "</tr>";
	
	};
	
	

	$table .= "</table>";							
	echo $table;	
	
	
}

/**
 * Funcion que nos dice el rol del usuario.
 * @author: Veronica, Andreina.
 */
function tipo_medico(){
if ($_SESSION['esfisio'] == 1){ echo "Fisioterapeuta";
}else{ echo "Interpretador";};
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
      <a class ="icon selected" href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-search"></span></a>
				<ul class="dropdown-menu">
					<li><a href="paciente.php">Paciente</a></li>
					<li><a href="generales.php">Generales</a></li>
                                        <li><a href="comparaciones.php">Comparaciones</a></li>
				</ul>
       <a class ="icon" href="consultaBorrarPaciente.php"><span class="glyphicon glyphicon-minus-sign"></span></a></li>	
       <a class ="icon" href="cerrarSesion.php"><span class="glyphicon glyphicon-log-out"></span></a>    
    <?php }else{ ?>
       <a class ="icon" href="perfil.php"><span class="glyphicon glyphicon-home"></span></a>
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


  <div class="panel-group trans" id="accordion">
  <div class="panel panel-default trans2">
    
      <h4 class="panel-title trans2">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="titulo2">
          Tono Flexor Dorsal Derecho
        </a>
      </h4>
    
    <div id="collapseOne" class="panel-collapse collapse in trans2">
      <div class="panel-body">
        <div class="table-responsive">
        <?php obtenerTM2D(); ?>
        </div>
      </div>
    </div>
  </div>
    <div class="panel panel-default trans2">
    
      <h4 class="panel-title trans2">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="titulo2">
          Tono Flexor Dorsal Izquierdo
        </a>
      </h4>
    
    <div id="collapseTwo" class="panel-collapse collapse trans2">
      <div class="panel-body">
      
      <div class="table-responsive">
        <?php obtenerTM2I(); ?>
      </div>  
        
      </div>
    </div>
  </div>
 </div>
 

 
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
