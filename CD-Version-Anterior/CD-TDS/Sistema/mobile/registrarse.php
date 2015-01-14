<?php
  /**
   * Archivo para verificacion de registro
   */
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Registrarse</title>
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
    
    <a class ="icon" href="index.php"><span class="glyphicon glyphicon-home"></span></a>

  </div>
 </nav>
 <!-- ================================================== -->
 <!-- Consultar Paciente-->
  <div>
     <p class="titulo">Registrarse</p>
 </div>
 <div class="row">
  <div class="col-xs-12 col-md-7 trans">	
	  <form role="form" action="registrar_usuario.php">
		  <div class="form-group">
        <div class="errores">
             <?php
                  //echo $_SESSION['error'];
                  //$un_error=unserialize(urldecode($_GET['error']));
                  if (!empty($_GET['error1'])){
                  
                     //foreach ($_SESSION['error'] as $e){
                             echo ($_GET['error1']);
                             echo ($_GET['error2']);
                             echo ($_GET['error3']);
                             echo ($_GET['error4']);
                             echo ($_GET['error5']);
                             echo ($_GET['error6']);
                     //}  
                  }
             ?>
        </div>
			<label for="exampleInputEmail1">Nombre</label>
			<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Jane">
			<label for="exampleInputEmail1">Apellido</label>
			<input type="text" class="form-control" id="apellido" name="apellido" placeholder="Doe">
      <label for="exampleInputEmail1">CÃ©dula</label>
			<input type="text" class="form-control" id="cedula" name="cedula" placeholder="123456789">
      <label for="exampleInputEmail1">Usuario</label>
			<input type="text" class="form-control" id="usuario" name="usuario" placeholder="jdoe">
		  <label for="exampleInputEmail1">Contraseña</label>
			<input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="**********">
      <label for="exampleInputEmail1">Confirme Contraseña</label>
			<input type="password" class="form-control" id="contrasena_conf" name="contrasena_conf" placeholder="**********">
      <input type="radio" id="medico" name="medico" value=1 >Fisioterapeuta<br/>
      <input type="radio" id="medico" name="medico" value=2 >Interpretador
      </div>
		  <button type="submit" class="btn btn-warning btn-block" id="login" class="boton">Aceptar</button>
		</form>
  </div>
 </div>
 
 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
