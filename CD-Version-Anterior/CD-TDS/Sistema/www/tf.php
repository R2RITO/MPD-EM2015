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
    
    <a class ="icon selected" href="perfil.html"><span class="glyphicon glyphicon-home"></span></a>
    <a class ="icon" href="nuevoPaciente.html"><span class="glyphicon glyphicon-plus-sign"></span></a>
    <a class ="icon" href="nuevoEFA.html"><span class="glyphicon glyphicon-folder-open"></span></a>
    <a class ="icon" href="consultas.html" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-search"></span></a>
				<ul class="dropdown-menu">
					<li><a href="paciente.php">Paciente</a></li>
					<li><a href="generales.php">Generales</a></li>
          <li><a href="comparaciones.php">Comparaciones</a></li>
				</ul>
    <a class ="icon" href="#"><span class="glyphicon glyphicon-minus-sign"></span></a></li>	
		<a class ="icon" href="cerrarSesion.php"><span class="glyphicon glyphicon-log-out"></span></a>    
  </div>
 </nav>
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
          Tono Flexor Dorsal Izquierdo
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
 
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
