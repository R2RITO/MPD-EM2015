<!DOCTYPE HTML>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo donde se lee el archivo de Excel para hacer las inserciones de las preferencias del
	usuario medico en la base de datos. 
<!-->

<?php include_once ("FachadaBD.php");
		include_once ("EFA_tab.php");
	include_once ("etiqueta_t.php");
session_start();
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
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

<?php 

/*	Funcion donde se lee el archivo de Excel y se crea la tabla de los
	datos leidos para ser mostrados al usuario.
*/
function tabla(){
	if($_FILES['file']['name'] != '')
	{
		
		require_once 'reader/Classes/PHPExcel/IOFactory.php';

		//Funciones extras
		
		function get_cell($cell, $objPHPExcel){
			//select one cell
			$objCell = ($objPHPExcel->getActiveSheet()->getCell($cell));
			//get cell value
			return $objCell->getvalue();
		}
		
		function pp(&$var){
			$var = chr(ord($var)+1);
			return true;
		}

		$name	  = $_FILES['file']['name'];
		$tname 	  = $_FILES['file']['tmp_name'];
		$type 	  = $_FILES['file']['type'];
			
		if($type == 'application/vnd.ms-excel')
		{
			// Extension excel 97
			$ext = 'xls';
		}
		else if($type == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
		{
			// Extension excel 2007 y 2010
			$ext = 'xlsx';
		}else{
			// Extension no valida
			echo -1;
			exit();
		}

		$xlsx = 'Excel2007';
		$xls  = 'Excel5';

		//creando el lector
		$objReader = PHPExcel_IOFactory::createReader($$ext);
		
		//cargamos el archivo
		$objPHPExcel = $objReader->load($tname);

		$dim = $objPHPExcel->getActiveSheet()->calculateWorksheetDimension();

		// list coloca en array $start y $end
		list($start, $end) = explode(':', $dim);
			
		if(!preg_match('#([A-Z]+)([0-9]+)#', $start, $rslt)){
			return false;
		}
		list($start, $start_h, $start_v) = $rslt;
		if(!preg_match('#([A-Z]+)([0-9]+)#', $end, $rslt)){
			return false;
		}
		list($end, $end_h, $end_v) = $rslt;

		//empieza  lectura vertical
		$table = "<table  border='1'>";
		$numh=0; //para etiquetas ubicadas horizontalmente;
		$numv=0; //para etiquetas ubicadas verticalmente;
		$etiquetas1;
		$etiquetas2;
		$valores;
		for($v=$start_v; $v<=$end_v; $v++){
			//empieza lectura horizontal
			$table .= "<tr>";
			for($h=$start_h; ord($h)<=ord($end_h); pp($h)){
				$cellValue = get_cell($h.$v, $objPHPExcel);
				//echo $cellValue."-";
				
				if($numh<1){
				
				$etiquetas1[]=$cellValue;
				};
				if($numv<1){
				$etiquetas2[]=$cellValue;
				}else{
					$valores[$numh][$numv]= $cellValue;
				};
				
				$numv=$numv+1;
				
				$table .= "<td>";
				if($cellValue !== null){
					$table .= $cellValue;
				}
				$table .= "</td>";
			}
			$numh=$numh+1;
			$numv=0;
			
			$table .= "</tr>";
		}
		
		
			for($i=1; $i<$numh ;$i++){
				$fbd1 = FachadaBD::getInstance();
				$fbd1 -> agregarCaracMarchaEtiquetasBD($etiquetas2[$i]);
				for($j=1;$j<=$i;$j++){
				
					//echo "++".$etiquetas2[$i]."-".$etiquetas1[$j]."-".$valores[$i][$j]."<br>";
					$fbd = FachadaBD::getInstance();
					$caract = NEW etiqueta_t();
					$caract->setDom('Carac_Marcha');
					$caract->setEt1($etiquetas2[$i]);
					$caract->setEt2($etiquetas1[$j]);
					$caract->setGrado($valores[$i][$j]);
					$fbd -> agregarCaracMarchaBD($caract);
													
				};								
			};
		
		$table .= "</table>";
			
		echo $table;		
	}
}
?>

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
					<p>Hospital J.M. de los Rios</p>
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
				<h2>Tabla de las Características de la marcha</h2>
					<div id="demos">
						<h3>Seleccionar archivo Excel</h3>
						<form name="frmload" method="post" action="indexP.php" enctype="multipart/form-data">
							<input type="file" name="file" /> &nbsp; &nbsp; &nbsp; <input type="submit" value="Subir y cargar datos" />
						</form>
						<div id="show_excel">
						<?php tabla(); ?>
						</div>
					</div>
					<p align="right"><a  href="f_indexP.php" class="button-style1">Continuar</a></p>
				</section>
				
         	</div>
		</div>
	</div>
</DIV>



</body>
</html>
