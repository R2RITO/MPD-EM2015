<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Menu Dinâmico - Bootstrap</title>
<style>
	.esconde {display:none;}
	.son{background-color: red;}
</style>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">                          
       function cambiar()
{
   var index=document.trimestres.selectedIndex;
   
   formulario.meses.length=0;
   
   if(index==0) trimestre1();
   if(index==1) trimestre2();
   if(index==2) trimestre3();
   if(index==3) trimestre4();   
}



function trimestre1(){
  opcion0=new Option("Enero","Enero","defauldSelected");
  opcion1=new Option("Febrero","Febrero");
  opcion2=new Option("Marzo","Marzo");
  
  document.meses.options[0]=opcion0;
  document.meses.options[1]=opcion1;
  document.meses.options[2]=opcion2;  
 }

function trimestre2(){
  opcion0=new Option("Abril","Abril","defauldSelected");
  opcion1=new Option("Mayo","Mayo");
  opcion2=new Option("Junio","Junio");
  
  document.meses.options[0]=opcion0;
  document.meses.options[1]=opcion1;
  document.meses.options[2]=opcion2;  
 }

function trimestre3(){
  opcion0=new Option("Julio","Julio","defauldSelected");
  opcion1=new Option("Agosto","Agosto");
  opcion2=new Option("Septiembre","Septiembre");

  document.meses.options[0]=opcion0;
  document.meses.options[1]=opcion1;
  document.meses.options[2]=opcion2;  
 }
 
function trimestre4(){
  opcion0=new Option("Octubre","Octubre","defauldSelected");
  opcion1=new Option("Noviembre","Noviembre");
  opcion2=new Option("Diciembre","Diciembre");
  
  document.meses.options[0]=opcion0;
  document.meses.options[1]=opcion1;
  document.meses.options[2]=opcion2;  
 }
    </script>
</head>

<?php

$con = oci_connect("miniproyecto", "m1n1pr0y3ct0", "localhost/XE");
$sql = oci_parse($con,"SELECT DISTINCT etiqueta FROM semejanza_fijo_etiqueta WHERE dom_name = 'Tono_Flexores_Dorsales_Izq' AND usuario = 'DRUIZ'");
oci_execute($sql);

?>

<body>
<div class="btn-group">
  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
    Meu menu
    <span class="caret"></span>
  </a>
  <ul class="dropdown-menu">		<?php
			while (($row = oci_fetch_array($sql, OCI_BOTH))) {
		
    echo '<li value="'.$row[0].'">'.$row[0].'</li>';
 }
?>
  </ul>
</div>

          <select name="trimestres" OnChange="cambiar()">
          <option value="1er. Trimestre" selected>1er. Trimestre</option>
          <option value="2do. Trimestre">2er. Trimestre</option>
          <option value="3er. Trimestre">3er. Trimestre</option>
          <option value="4to. Trimestre">4to. Trimestre</option>
          </select>
          Meses 
          <select name="meses">
          <option value="Enero" selected>Enero</option>
          <option value="Febrero">Febrero</option>
          <option value="Marzo">Marzo</option>
          </select>


</body>
</html>
