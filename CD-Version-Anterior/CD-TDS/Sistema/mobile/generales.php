<?php

/**
 *
 * Contiene varias funcionespara obtener etiquetas.
 * @method session_start():funciona para iniciar la sesion de usuario.
 * @method buscarEtiquetasPeso():Función que busca las etiquetas de pesos.
 * @method buscarEtiquetasTFDI(): Función que busca las etiquetas del tono flexor dorsal izquierdo.
 * @method buscarDominioTFDI():  Función que busca los dominios del tono flexor dorsal izquierdo. 
 * @method buscarDominioTFDD(): Función que busca los dominios del tono flexor dorsal derecho. 
 * @method buscarEtiquetasTFDD():  Funcion que busca las etiquetas de las caracteristicas de marcha.
 * @method buscarEtiquetasCaracMarcha(): Funcion que busca las etiquetas de las caracteristicas de marcha.
 * @author: Veronica, Andreina ,Daniela & Ruben
 * @version: 1.0
 * @ignore: Favor documentar de esta manera.
 */
 
 
session_start();
include_once ("FachadaBD.php");

/**
 * Función que busca las etiquetas de pesos.
 *
 * Funcion que busca las etiquetas del peso almacenadas en 
 * la base de datos para presentarlas al usuario para su
 * seleccion para la busqueda.
 *
 * @author: Andreina & Veronica.
 * @version: 1.0
 */
function buscarEtiquetasPeso(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosiblePesoBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/**
 * Función que busca las etiquetas del tono flexor dorsal izquierdo. 
 *
 * Funcion que busca las etiquetas del tono flexor dorsal izq
 * almacenadas en la base de datos para presentarlas al 
 * usuario para su seleccion para la busqueda.
 *
 * @author: Andreina & Veronica.
 * @version: 1.0
 */
function buscarEtiquetasTFDI(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/**
 * Función que busca los dominios del tono flexor dorsal izquierdo. 
 *
 * Funcion que busca los dominios del tono flexor dorsal izq
 * almacenados en la base de datos para presentarlos al 
 * usuario para su seleccion para la busqueda.
 * 
 * @author: Andreina & Veronica.
 * @version: 1.0
 */
function buscarDominioTFDI(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarDominioFijoPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/**
 * Función que busca los dominios del tono flexor dorsal derecho. 
 *
 * Funcion que busca los dominios del tono flexor dorsal derecho
 * almacenados en la base de datos para presentarlos al 
 * usuario para su seleccion para la busqueda.
 * 
 * @author: Andreina & Veronica.
 * @version: 1.0
 */
function buscarDominioTFDD(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarDominioFijoPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/**
 * Función que busca las etiquetas del tono flexor dorsal derecho. 
 *
 * Funcion que busca las etiquetas del tono flexor dorsal derecho
 * almacenadas en la base de datos para presentarlas al 
 * usuario para su seleccion para la busqueda.
 *
 * @author: Andreina & Veronica.
 * @version: 1.0
 */
function buscarEtiquetasTFDD(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosibleTonoFlexDorBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

/**
 * Funcion que busca las etiquetas de las caracteristicas de marcha.
 *
 * Funcion que busca las etiquetas de las caracteristicas de marcha
 * almacenadas en la base de datos para presentarlas al 
 * usuario para su seleccion para la busqueda.
 *
 * @author: Andreina & Veronica.
 * @version: 1.0
 */
function buscarEtiquetasCaracMarcha(){
	$fbd = FachadaBD::getInstance();
	$results = $fbd->consultarEtiquetaPosibleCaracMarchaBD();

	while (($row = oci_fetch_array($results, OCI_BOTH))) {
		echo '<option value="'.$row[0].'">'.$row[0].'</option>';
	}
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Consultas Generales</title>
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
 <!-- ======================= Consultar Paciente de forma General=================== -->
  <div>
     <p class="titulo">Consultas Generales</p>
 </div>
 
 <form action="resultadosGenerales.php" method="post" class="trans">
    
    <!-- Peso del paciente -->    
      <label for="exampleInputEmail1">Peso</label>
        <div class="form-group trans2 et">
            <input type="checkbox" name="parametro1" value="Y">
            <select name="peso" class="sel trans2"> 
                <option value="">Seleccione</option>  
                <?php buscarEtiquetasPeso();?>
            </select>
         </div><!-- /btn-group -->
      
  <!-- Tono Flexor Dorsal Derecho -->
      <label for="exampleInputEmail1">Tono Flexor Dorsal Derecho</label>      
        <div class="form-group trans2 et">
             <input type="checkbox" name="parametro3" value="Y">
             Etiqueta
             <select name="tonoflexdorder" class="sel trans2">   
                     <option value="">Seleccione</option>  
                     <?php buscarEtiquetasTFDD(); ?>
             </select>
             o Dominio Fijo
             <select class="sel trans2" name="dominioTFDD">   
                     <option value="">Seleccione</option>     
                     <?php buscarDominioTFDD(); ?>
             </select> 
    </div><!-- input-group -->

    <!-- Tono Flexor Dorsal Izquierdo -->
    <label for="exampleInputEmail1">Tono Flexor Dorsal Izquierdo</label>      
       <div class="form-group trans2 et">
          <input type="checkbox" name="parametro2" value="Y">
        Etiqueta
        <select name="tonoflexdorizq" class="sel trans2">   
            <option value="">Seleccione</option> 
            <?php buscarEtiquetasTFDI(); ?>
          </select>
      o Dominio Fijo
      <select class="sel trans2" name="dominioTFDI">
          <option value="">Seleccione</option>         
          <?php buscarDominioTFDI(); ?>
      </select> 
     
      </div><!-- input-group -->

      <!-- Caracteristicas de la marcha -->
      <label for="exampleInputEmail1">Tipos de Marcha</label>
         <div class="form-group trans2 et">
            <input type="checkbox" name="parametro4" value="Y">
               <select name="caracmarcha" class="sel trans2"> 
                  <option value="">Seleccione</option> 
                  <?php buscarEtiquetasCaracMarcha();?>
               </select>
          </div><!-- /input-group -->
 
          <br> 
          <button type="submit" class="btn btn-warning btn-block" id="login" class="boton">Buscar</button>
        
       </div><!-- /.col-lg-6 -->
    
 <form> 
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 <script src="js/jquery-1.10.2.min.js"></script>
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="js/bootstrap.min.js"></script>
</body>
</html>
