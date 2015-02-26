<!DOCTYPE html>
<html lang="es">
    <?php include("./plantilla/header.php")?>
    <body>
    	<div class="container-fluid" style="height: 100%;">

    		<!-- TOPBAR -->
            <?php include("./plantilla/topbar.php")?>

    		<!-- MAIN -->
    		<div class="row main" style="height: 80%;">    			
    			<div class="row-same-height" style="height: 100%;">
    				
                    <!-- MAIN MENU -->
                    <?php 
                        include './plantilla/variables.php';                       
                        $main_menu[0]['active'] = true;
                    ?>
                    <?php include("./plantilla/main_menu.php")?>

	    			<!-- MAIN CONTENT -->
	    			<div class="col-xs-10 col-xs-height col-top main-content">
	    				<!-- SUBMENU -->
	    				<div class="row">
	    					<div class="col-xs-12 sub-menu">
								<ul class="list-inline ">
                                    <?php include("./vistas/cuenta/cuenta_submenu.php")?>
								</ul>
	    					</div>
	    				</div>

	    				<!-- CONTENT -->
	    				<div class="row">
	    					<div class="col-xs-12 content">
                                <div><h3 class="title">Cuenta</h3></div>
	    						
								
	    					</div>
	    				</div>
	    			</div>
	    		</div>
    		</div>

    		<!-- FOOTER -->
            <?php include("./plantilla/footer.php")?>
    	</div>
    </body>
</html>
