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
        <?php 
            session_start(); 
            include_once ("fachadaBD.php");
        ?>
    <body>
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
							<li class="active"><a href="<?php echo "cuenta_informacion.php" ?>">Mi cuenta</a></li>
							<li><a href="<?php echo "paciente_consulta.php" ?>">Pacientes</a></li>
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
									<li><a href=""<?php echo "cuenta_informacion.php" ?>"">Información</a></li>
									<li class="active"><a href=""<?php echo "cuenta_contexto.php" ?>"">Contextos</a></li>
								</ul>
	    					</div>
	    				</div>
	    				<!-- CONTENT -->
	    				<div class="row">
	    					<div class="col-xs-12 content">
	    						<h3 class="title">Mis contextos</h3>
								 <form name="F1"class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
									<div class="form-group">
										<label class="col-xs-2 control-label">Dominios</label>
										<div class="col-xs-10">
											<select name = "dominios">
												<option value="">--- Seleccione ---</option>
												<?php 
													$conn = oci_connect("ADMIN", "1234", "localhost/XE");

													$query= "SELECT nombre FROM DominioDifuso_TAB";
													$result = oci_parse($conn, $query);
													oci_execute($result);
													
													while($row = oci_fetch_array($result,OCI_BOTH)){
														echo "<option value=" . $row['NOMBRE'] . ">" . $row['NOMBRE'] . "</option>";
													}


												?>

												
											</select>
										</div>

									</div>

                                    <div>
                                        <button type="submit" class="btn btn-primary" name="submit">Seleccionar</button>
                                    </div>
                                    
								 </form>


                                 <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                    <div class="form-group">
                                        <label class="col-xs-2 control-label">Dimensiones Contextuales</label>
                                        <br>
                                        <div class="col-xs-10">
                                            <?php
                                                $option = isset($_POST['dominios']) ? $_POST['dominios'] : false;

                                                if($option) {

                                                    echo "<input type=\"hidden\" name=\"domSeleccionado\" value=" . $_POST['dominios'] . ">";

                                                    $fdb = fachadaBD::getInstance();
                                                    $result = $fdb->obtenerDimensionesContextuales($_POST['dominios']);
                                                    oci_execute($result);
                                                    
                                                    while($row = oci_fetch_array($result,OCI_BOTH)) {

                                                        $result_dimCtx = $fdb->obtenerDominiosDeDimensionContextual($_SESSION['USERNAME'],$row['DIMENSION']);

                                                        echo "<div class=\"col-xs-10\">";
                                                        echo "<label class=\"col-xs-2 control-label\">" . $row['DIMENSION'] . "</label>";
                                                        echo "<select name = \"" . $row['DIMENSION'] . "\">";
                                                        echo "<option selected disabled value=\"\">" . $row['DIMENSION'] . "</option>";
                                                        
                                                        while($rowCtx = oci_fetch_array($result_dimCtx,OCI_BOTH)){
                                                            echo "<option value=" . $rowCtx['DOMINIO'] . ">" . $rowCtx['DOMINIO'] . "</option>";
                                                        }

                                                        echo "</select>";
                                                        echo "</div>";
                                                        
                                                    }
                                                    
                                                }

                                            ?>                                                
                                        </div>

                                        <br>

                                        <div class="col-xs-10">
                                            <label class="col-xs-2 control-label">Seleccione la validez de contextos</label>
                                            <select name = "ALWAYS">
                                                <option selected disabled value="defaultAlways">Parámetro Always</option>
                                                <option value="0">Válido sólo para este contexto</option>
                                                <option value="1">Válido para cualquier contexto</option>
                                            </select>
                                        </div>

                                        <div class="col-xs-10">
                                            Etiqueta:<br>
                                            <input type="text" name="Etiqueta">
                                            <br>
                                            Límite izquierdo de soporte:<br>
                                            <input type="text" name="A">
                                            <br>
                                            Límite izquierdo de núcleo:<br>
                                            <input type="text" name="B">
                                            <br>
                                            Límite derecho de núcleo:<br>
                                            <input type="text" name="C">
                                            <br>
                                            Límite derecho de soporte:<br>
                                            <input type="text" name="D">
                                            <br>

                                        </div>

                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary" name="submit">Seleccionar</button>
                                    </div>
                                 </form>

                                 <?php
                                    if (isset($_POST['Etiqueta'])) {

                                        // Agregar a la lista de dominios de dimensiones contextuales.

                                        $etiqueta = $_POST['Etiqueta'];
                                        $limites = array($_POST['A'],$_POST['B'],$_POST['C'],$_POST['D']);

                                        $dominioDifuso = $_POST['domSeleccionado'];
                                        $usuario = $_SESSION['USERNAME'];
                                        $always = $_POST['ALWAYS'];

                                        // Crear la lista de dominios de dimensiones contextuales
                                        $fdb = fachadaBD::getInstance();
                                        $res = $fdb->obtenerDimensionesContextuales($_POST['domSeleccionado']);

                                        $listaDimCtx = array();
                                        $listaDomCtx = array();

                                        while($rowDom = oci_fetch_array($res,OCI_BOTH)) {
                                            if (isset($_POST[$rowDom['DIMENSION']])) {
                                                $listaDimCtx[] = $rowDom['DIMENSION'];
                                                $listaDomCtx[] = $_POST[$rowDom['DIMENSION']];
                                            }
                                        }

                                        $fdb->insertarNuevoTrapezoide($dominioDifuso, $etiqueta, $listaDomCtx, $listaDimCtx, $limites, $usuario, $always);

                                    }
                                 ?>								
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
