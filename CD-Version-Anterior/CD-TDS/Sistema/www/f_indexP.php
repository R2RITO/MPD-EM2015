<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo donde se agregan las preferencias del usuario en cuanto al peso.
<!-->

<html>
<head>
<title>Laboratorio</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<noscript>
<link rel="stylesheet" href="css/5grid/core.css" />
<link rel="stylesheet" href="css/5grid/core-desktop.css" />
<link rel="stylesheet" href="css/5grid/core-1200px.css" />
<link rel="stylesheet" href="css/5grid/core-noscript.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="stylesheet" href="css/style-desktop.css" />
</noscript>
<!--/> 
	Script donde se grafican los valores de las etiquetas insertadas por
	el usuario en cuanto al peso para ser almacenados en la base de datos.
<!-->

<script src="css/5grid/jquery.js"></script>
<script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none"></script>
<script language="javascript" type="text/javascript" src="js/flot-0.7/jquery.js">
</script>
<script language="javascript" type="text/javascript" src="js/flot-0.7/jquery.flot.js"></script>
<script language="javascript" type="text/javascript">
function dibuja_grafico(e1,e2,e3,x,y,v,w,x1,y1,v1,w1,x2,y2,v2,w2) {
var data = [
		{
		label: e1,
		data:[
		[y.value,1], 
		[v.value, 1],
		[w.value, 0],
		[300,0]]},
		
		{
		label: e2,
		data:[
		[0,0],
		[x1.value,0], 
		[y1.value, 1],
		[v1.value, 1],
		[w1.value, 0]
		[300,0]]},
		
		{
		label: e3,
		data:[
		[0,0],
		[x2.value, 0],
		[y2.value,1],
		[v2.value, 1],
		[300, 1]]},
	
	];
	
	var opciones = { xaxis: { min: 0, max: 300} , yaxis: { min: 0, max: 1}, series:{lines: { show: true }, points: { show: true },}, legend: {
            show: true, position: 'se'},};
	$.plot($("#placeholder"), data , opciones);
	}
</script>

<!--[if IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->

</head><body>
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
					<h2>Datos del Peso de los Pacientes</h2>
					<form action="indexP.php" method="post">
					LIGERO:
					 <input type="text" id="l1" name="l1"  style="width: 50px">
					 <input type="text" id="l2" name="l2" style="width: 50px">
					 <input type="text" id="l3" name="l3" style="width: 50px">
					 <input type="text" id="l4" name="l4" style="width: 50px">
					 
					<br>
					 
					  NORMAL:
					 <input type="text" id="n1" name="n1" style="width: 50px">
					 <input type="text" id="n2" name="n2" style="width: 50px">
					 <input type="text" id="n3" name="n3" style="width: 50px">
					 <input type="text" id="n4" name="n4" style="width: 50px">

					<br>
					 
					  OBESO:
					 <input type="text" id="o1" name="o1" style="width: 50px">
					 <input type="text" id="o2" name="o2" style="width: 50px">
					 <input type="text" id="o3" name="o3" style="width: 50px">
					 <input type="text" id="o4" name="o4" style="width: 50px">
					 
					<br><br>
					 
					  <input type="button" value="Generar Grafico" onclick="dibuja_grafico('Ligero','Normal','Obeso',l1,l2,l3,l4,n1,n2,n3,n4,o1,o2,o3,o4);" style="width: 100px">
					 <div id="placeholder" style="width:600px;height:300px;"></div>
					 
					 
					 <input class="button-style1" type="submit" value="Cargar datos" />
					 
					 </form>
					
					<br>
					<p align="right"><input type="button"  disabled value="Continuar" /></p>
				</section>
			</div>
		</div>
	</div>


</div>
<div class="5grid-layout" id="copyright">
	<div class="row">
		<div class="12u">
			<section align="right" style="margin-right: 62px;">
				<p>&copy; Laboratorio de Marcha | Hospital J.M de los Ríos   &nbsp; </p>
			</section>
		</div>
	</div>
</div>
</body>
</html>