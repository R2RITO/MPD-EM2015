<?php session_start();
  include_once ("FachadaBD.php");

function tienePar(){
    $fbd = FachadaBD::getInstance();
    
    return $fbd->perfilDefinido($_SESSION['user']);   
    
}

function tipo_medico(){
  if ($_SESSION['esfisio'] == 1){ 
     echo "Fisioterapeuta";
  }else{ 
     echo "Interpretador";};
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

       <a class ="icon selected" href="perfil.php"><span class="glyphicon glyphicon-home"></span></a>
       <a class ="icon" href="cerrarSesion.php"><span class="glyphicon glyphicon-log-out"></span></a>   

 </div>
 </nav>
 <b><?php if ($_SESSION['esfisio'] == 1){ echo "Fisioterapeuta: "; } else { echo "Interpretador: "; } ?></b>
 <b><?php echo $_SESSION['nombre']." ".$_SESSION['apellido'] ; ?></b>
 
 
 <!-- ================================================== -->
 <!-- SI EL USUARIO NO TIENE NADA EN UDLINLAB_TAB ENTONCES INDICAR QUE DEBE COMPLETAR SU PERFIL-->
 <!-- Parámetros de Perfil -->
 <div class="row">
  <div class="col-xs-12 col-md-7 trans">			
		   <p> Debe terminar de completar su registro por el Portal Web.</p><br/>
       <p> Gracias</p><br/>		
   </div>
 </div>
 
 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
