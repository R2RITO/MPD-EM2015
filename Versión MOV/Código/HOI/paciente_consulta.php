<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>Plantilla</title>
        <meta name="description" content="Plantilla para Hospital Ortopédico Infantil">
        <meta name="author" content="MOV">
        <meta name="viewport" content="width=device-width; initial-scale=1.0">

        <!-- JQUERY -->
		<script type="text/javascript" src="./jquery/jquery-2.1.3.min.js"></script>

		<!-- BOOTSTRAP -->
        <link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css"/>
        <script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>

        <!-- STYLE -->
        <link rel="stylesheet" type="text/css" href="./css/basico.css"/>    </head>
        <?php session_start(); ?>
    <body>

        <?php
        
            include_once ("fachadaBD.php");
            include_once ("Paciente.php");


            function test_input($data) {
               $data = trim($data);
               $data = stripslashes($data);
               $data = htmlspecialchars($data);
               return $data;
            }
            function verificar_campos(){
                $valido = true;
                if((trim($_POST["ci"])) == "" ){
                    $valido = false;
                }
                return $valido;
            }

            /*  Funcion que se encarga de realizar la busqueda en la base de datos a partir de
                la cedula del paciente e imprime los resultados en pantalla.
            */
            function realizarBusqueda(){

                $cedula = trim($_POST["ci"]);

                $fbd = fachadaBD::getInstance();
                $resultado = $fbd->consultarPacienteBD($cedula);
                $paciente = new Paciente();

                if (($row = oci_fetch_array($resultado, OCI_BOTH))){
                    $paciente->setCI($row[0]);
                    $paciente->setNombres($row[1]);
                    $paciente->setApellidos($row[2]);
                    $paciente->setProfesion($row[3]);
                    $paciente->setLugarRes($row[4]);
                    $paciente->setFechaNac($row[5]);
                    $paciente->setID_Historial($row[6]);
                    $paciente->setDiagnostico($row[7]);
                    $paciente->setInterQuir($row[8]);
                }

                return $paciente;   
            }

            $check = false;
            $verificarCampos = true;
            $esta = true;
            $valido = true;

            
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $verificarCampos = verificar_campos();

                if ($verificarCampos){
                    $paciente = realizarBusqueda();
                    if ($paciente==null){ 
                        $esta = false;
                    }else {
                        $check = true;
                        $esta = true;
                    }
                }
                  
            }
        
        ?>

    	<div class="container-fluid" style="height: 100%;">
    		<!-- TOPBAR -->
    		<div class="row topbar">
    			<div class="col-xs-12">
    				<!-- LOGO -->
    				<div class="col-xs-4 logo ">
    					<img src="./imagenes/logo.jpg" class="img-responsive" alt="Logo">
    				</div>
    				<!-- USER PROFILE INFORMATION -->
    				<div class="col-xs-3 pull-right user-session">    				
    					<div class="row user-info">
    						<!-- USER PHOTO -->
    						<div class="col-xs-3">
    							<img src="./imagenes/user.png" class="img-responsive" alt="Foto usuario">	
    						</div>
    						<!-- USERNAME -->
    						<div class="col-xs-9">
    							<h4><?php echo $_SESSION['NOMBRE'], " ", $_SESSION['APELLIDO'] ?></h4>
    						</div>
    					</div>
    					<!-- USER CONTEXT -->
						<div class="row">
							<div class="col-xs-12 user-context">
							</div>
						</div>
    				</div>					
    			</div>
    		</div>
    		<!-- MAIN -->
    		<div class="row main" style="height: 80%;">    			
    			<div class="row-same-height" style="height: 100%;">
    				<!-- MAIN MENU -->
	    			<div class="col-xs-2 col-xs-height col-top main-menu" >
						<ul class="list-unstyled main-menu">
							<li><a href="<?php echo "cuenta_informacion.php" ?>">Mi cuenta</a></li>
							<li class="active"><a href="<?php echo "paciente_consulta.php" ?>">Pacientes</a></li>
							<li><a href="<?php echo "efa_consulta.php" ?>">Examen Físico Articular</a></li>
							<li><a href="<?php echo "iniciar_sesion.php" ?>">Salir</a></li>
						</ul>
	    			</div>
	    			<!-- MAIN CONTENT -->
	    			<div class="col-xs-10 col-xs-height col-top main-content">
	    				<!-- SUBMENU -->
	    				<div class="row">
	    					<div class="col-xs-12 sub-menu">
								<ul class="list-inline ">
									<li class="active"><a href="<?php echo "paciente_consulta.php" ?>">Consultar</a></li>
									<li><a href="<?php echo "paciente_nuevo.php" ?>">Agregar</a></li>
                                    <li><a href="<?php echo "paciente_eliminar.php" ?>">Eliminar</a></li>
								</ul>
	    					</div>
	    				</div>
	    				<!-- CONTENT -->
	    				<div class="row">
	    					<div class="col-xs-12 content">
	    						<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                    <!-- DATOS DEL PACIENTE -->
                                    <h3 class="title">Buscar Pacientes</h3>
                                    <div class="form-group">
                                        <label class="col-xs-2 control-label">Cédula</label>
                                        <div class="col-xs-10">
                                            <input type="text" class="form-control" placeholder="Cédula del paciente" name="ci">
                                        </div>
                                    </div>
                                    <?php if (!$verificarCampos): ?>
                                        <div class="alert alert-danger error" role="alert">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            <span class="sr-only">Error:</span>
                                            <?php echo "Escriba la cédula del paciente que desea consultar";?>
                                        </div>                            
                                    <?php endif; ?>
                                    <?php if (!$esta): ?>
                                        <div class="alert alert-danger error" role="alert">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            <span class="sr-only">Error:</span>
                                            <?php echo "NO existe!!";?>
                                        </div>      
                                    <?php endif; ?>
                                    <?php if ($check): ?>
                                        <ul>
                                            <li> Nombres: <?php echo $paciente->getNombres();?></li>
                                            <li> Apellidos: <?php echo $paciente->getApellidos();?></li>
                                            <li> Identificación: <?php echo $paciente->getCI();?></li>
                                        </ul>   
                                    <?php endif; ?>                        
                                    
                                    
                                    
                                    <div style="text-align: center; margin-top: 30px;">
                                        <button type="submit" class="btn btn-primary">Buscar</button>
                                        <button type="button" class="btn btn-default" onClick="document.location.href='<?php echo "paciente_consulta.php" ?>'">Cancelar</button>
                                        </div>
                                    </div>
                                </form>  
								
                                <h3 class="title">Consulta general</h3>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
    		</div>
    		<!-- FOOTER -->
    		<div class="row footer">
    			<div class="col-xs-12 " style="">
                    <p>© Laboratorio de Marcha | Hospital Ortopédico Infantil </p>   
                </div>
    		</div>
    	</div>
    </body>
</html>
