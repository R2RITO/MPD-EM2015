<?php session_start();
/**
 * En esta archivo se revisa la cedula colocada es correcta.
 * @author: Daniela & Ruben.
 */
include_once ("FachadaBD.php");

/**
 * Funcion que verifica si la cedula existe en la base de datos.
 *
 * Ademas de validar la existencia de una cedula que concuerda con
 * otra guardada en la BD, si se colocan otros caracteres distintos a
 * digitos se envia a resultadosNombre que tomara el String escrito
 * por el usuario como si fuese un nombre de un paciente.
 *
 * @author: Daniela & Ruben
 */

function verificar_campo(){

    $fbd = FachadaBD::getInstance();
    //$id = $_POST["cedula"];
    $id = $_GET["cedula"];    

    if(trim($id) == ""){
        echo "**debe introducir un valor para el campo";
    } else if(!preg_match("/^[[:digit:]]+$/", $id)){
        $string = "Location: resultadosNombre.php?nombre=".$id;
        header($string);
    } else if(!$fbd->validarPacienteBD($id)){
        echo "El paciente no existe en la base de datos";
    } else{
        $string = "Location: resultadoConsultaCedula.php?cedula=".$id;
        header($string);
    }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Consultar Paciente</title>
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
     <p class="titulo">Consultar Paciente</p>
 </div>
 <div class="row">
  <div class="col-xs-12 col-md-7 trans">	
        <form role="form" action="revisionCedula.php">
		  <div class="form-group">
			<label for="exampleInputEmail1">Cédula</label>
			<input type="text" class="form-control" id="cedula" name="cedula" placeholder="123456789">
                        <?php verificar_campo(); ?>
		  </div>
		  <button type="submit" class="btn btn-warning btn-block" id="login" class="boton">Buscar</button>
	</form>
  </div>
 </div>
 
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
