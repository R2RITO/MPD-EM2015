<!DOCTYPE html>

<?php
/**
 * En esta vista se verifica y elimina el historial de un paciente.
 * @author: Daniela & Ruben
 */

include_once ("FachadaBD.php");
session_start();

/**
 * Función que verifica el historial a borrar.
 *
 * Función que verifica si el usuario escribio solo digitos de una cedula ya existente
 * y avisa al usuario si tuvo exito o no.
 *
 * @author: Ruben & Daniela.
 */
function verificarHistorialBorrar(){
   
    $fbd = FachadaBD::getInstance();
    $valido;
    if (!preg_match("/^[[:digit:]]+$/", $_GET["cedula"])) {
        echo '<br><div class="alert alert-danger">Debe colocar solo digitos.</div>';
        exit;
    }

    $valido = $fbd->validarPacienteBD($_GET["cedula"]);

    if($valido){
        $fbd1 = FachadaBD::getInstance();
        $fbd1 ->eliminarPacienteBD($_GET["cedula"]);
        echo '<br><div class="alert alert-success"> Historial de paciente eliminado.</div>';
    } else{
	echo '<br><div class="alert alert-danger">El historial de paciente no existe.</div>';
    }
}
?>

<html>
  <head>
    <title>Borrar Historial Paciente</title>
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
      <a class ="icon" href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-search"></span></a>
				<ul class="dropdown-menu">
					<li><a href="paciente.php">Paciente</a></li>
					<li><a href="generales.php">Generales</a></li>
                                        <li><a href="comparaciones.php">Comparaciones</a></li>
				</ul>
       <a class ="icon selected" href="consultaBorrarPaciente.php"><span class="glyphicon glyphicon-minus-sign"></span></a></li>	
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
 <!-- Borrar Historial Paciente-->
  <div>
     <p class="titulo">Borrar Historial Paciente</p>
 </div>
 <div class="row">
  <div class="col-xs-12 col-md-7 trans">	
	  <form role="form" action="borrarHistorialPaciente.php">
		  <div class="form-group">
			<label for="exampleInputEmail1">Cédula</label>
			<input type="text" class="form-control" id="cedula" name="cedula" placeholder="123456789">
		  </div>
		  <button type="submit" class="btn btn-warning btn-block" id="login" onclick="return confirm('¿Desea eliminar este paciente?');" 
                          value="Eliminar paciente">Borrar</button> <?php verificarHistorialBorrar(); ?>
		</form>
  </div>
 </div>
 
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
