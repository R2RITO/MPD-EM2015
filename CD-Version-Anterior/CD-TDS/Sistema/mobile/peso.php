<!DOCTYPE html>
<html>
  <head>
    <title>Mis Parámetros - Peso</title>
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
    <!--
    <script src="css/5grid/jquery.js"></script>
    <script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none"></script>
    <script language="javascript" type="text/javascript" src="js/flot-0.7/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="js/flot-0.7/jquery.flot.js"></script>
    -->
<script>
function cambiar(contenido)
{
	vista=document.getElementById(contenido).style.display;
	if (vista=='none')
		vista='block';
	else
		vista='none';

	document.getElementById(contenido).style.display = vista;
}

function dibuja_grafico(e1,e2,e3,x,y,v,w,x1,y1,v1,w1,x2,y2,v2,w2) {
var data = [
		{
		label: e1,
		data:[
		[y,1], 
		[v, 1],
		[w, 0],
		[300, 0]]},
		
		{
		label: e2,
		data:[
		[0, 0],
		[x1,0], 
		[y1, 1],
		[v1, 1],
		[w1, 0],
		[300, 0]]},
		
		{
		label: e3,
		data:[
		[0, 0],
		[x2, 0],
		[y2,1],
		[v2, 1],
		[300, 1]]},
	
	];
	
	var opciones = { xaxis: { min: 0, max: 300} , yaxis: { min: 0, max: 1}, series:{lines: { show: true }, points: { show: true },}, legend: {
            show: true, position: 'se'},};
	$.plot($("#placeholder"), data , opciones);
	}
</script>
    
    
    
</head>

<?php session_start(); 
include_once ('FachadaBD.php');
include_once ("EFA_tab.php");

/**
 * Funcion que obtiene el peso del usuario y llama a la funcion dibujar_grafico de JS.
 * @author: Veronica, Andreina
 */
function obtenerPeso(){
    $fbd = FachadaBD::getInstance();
    $peso = $fbd->consultarPesoBD();
	  $d_grafica;
	  $eti;
		
    while(($row1 = oci_fetch_array($peso, OCI_BOTH))){	
      echo $row1[0] . "\n";
      echo $row1[1] . "\n";
      echo $row1[2] . "\n";
      echo $row1[3] . "\n";
      echo $row1[4] . "<br><br>";
		  $eti[]= $row1[0];
		  for($i=1;$i<=4;$i++){
        $d_grafica[]=$row1[$i];
		  }; 	
	  }
	
	echo "<script language='JavaScript'> dibuja_grafico('".$eti[0]."','".$eti[1]."','".$eti[2]."',".$d_grafica[0].",".$d_grafica[1].",".$d_grafica[2].",".$d_grafica[3].",".$d_grafica[4].",".$d_grafica[5].",".$d_grafica[6].",".$d_grafica[7].",".$d_grafica[8].",".$d_grafica[9].",".$d_grafica[10].",".$d_grafica[11].");</script>";
		//echo '<div id="placeholder" style="width:400px;height:200px;"></div> <br><br>';
		
	//print_r($d_grafica)."<BR>";
	//echo "".$d_grafica[0].",".$d_grafica[1].",".$d_grafica[2].",".$d_grafica[3].",".$d_grafica[4].",".$d_grafica[5].",".$d_grafica[6].",".$d_grafica[7].
	//",".$d_grafica[8].",".$d_grafica[9].",".$d_grafica[10].",".$d_grafica[11]."";
	
}

?>  
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
 <!-- ParÃ¡metros de Perfil -->
 <div class="row">
  <div class="col-xs-12 col-md-7 trans">			
		   <p class="lista"><b>Peso</b></a></p>
			 <?php obtenerPeso(); ?>  
   </div>
 </div>
 
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
