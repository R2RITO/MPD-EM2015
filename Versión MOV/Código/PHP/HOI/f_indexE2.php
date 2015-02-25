<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo donde se agregan las preferencias del tono flexor dorsal del medico usuario.
<!-->

<?php include_once ("FachadaBD.php");
		include_once ("EFA_tab.php");
	include_once ("dominio_fijo_t.php");
session_start();
?>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Laboratorio</title>
<noscript>
<link rel="stylesheet" href="css/5grid/core.css" />
<link rel="stylesheet" href="css/5grid/core-desktop.css" />
<link rel="stylesheet" href="css/5grid/core-1200px.css" />
<link rel="stylesheet" href="css/5grid/core-noscript.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/style-desktop.css" />

</noscript>
<script src="css/5grid/jquery.js"></script>
<script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none"></script>
<script language="javascript" type="text/javascript" src="js/flot-0.7/jquery.js">
</script>
<script language="javascript" type="text/javascript" src="js/flot-0.7/jquery.flot.js"></script>


</head>
<body>


<style type="text/css">
	#demos{
		width:800px;
		margin:10px auto 0 auto;
		padding:30px;
		border:1px solid #DFDFDF;
		font:normal 12px Arial, Helvetica, sans-serif
	}
	#demos h3{
		border-bottom:1px solid #DFDFDF;
		padding-bottom:7px;
		margin:10px 0
	}
	table{
		margin-top:15px;
		width:100%
	}
	table td{
		padding:7px;
		border:1px solid #CCC
	}
</style>
<div id="header-wrapper">
	<header id="header" class="5grid-layout">
		<div id="row">
			<div id="12u">
				<div id="logo">
					<h1><a href="#" class="mobileUI-site-name">Registro de Pacientes</a></h1>
					<p>Hospital J.M. de los Ríos</p>
				</div>
			</div>
		</div>
	</header>
</div>

<div id="wrapper">
	<div class="5grid-layout" id="welcome">
		<div class="row">
			<div class="12u">
				<section class="content">
				<h2>Tono Flexor Dorsal</h2>
					
					<div id="demos">
						<form name="frmload" method="post" action="indexE2.php" enctype="multipart/form-data">
						<h3>Tono Flexor Dorsal: </h3> 
						<input type="radio" name="dorsal" id="dorsal" value="Tono_Flexores_Dorsales_Der">Derecho <br>
						<input type="radio" name="dorsal" id="dorsal" value="Tono_Flexores_Dorsales_Izq">Izquierdo						
						
						<h3>Seleccionar archivo Excel</h3>
						
							<input type="file" name="file" /> &nbsp; &nbsp; &nbsp; <input type="submit" value="Subir y cargar datos" />
						</form>
						<div id="show_excel">
						
						</div>
					</div>
					<br>
					<p align="right"><input type="button"  disabled value="Continuar" /></p>
				</section>
				
         	</div>
		</div>
	</div>
</DIV>



</body>
</html>
