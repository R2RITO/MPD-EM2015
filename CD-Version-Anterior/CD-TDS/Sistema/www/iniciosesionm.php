<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
	Archivo que muestra el formulario de inicio de sesion para los usuarios del sistema
	para la version movil del mismo.
<!-->
<meta name="viewport" content="width=device-width, content="text/html; charset=UTF-8", minimum-scale=1, maximum-scale=1">
<title>Laboratorio Marcha</title>
<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
</head>
 
<body> 
<div data-role="page"  data-theme="b"  style="background-image:url(themes/images/img01.png)">
  
  
   <div data-role="content">
   <br/><br/><br/><br/><br/>
   <br/><br/><br/><br/><br/>
		<div data-role="partes" style="background-image:url(themes/images/fb2.png); background-repeat: no-repeat;  background-position: 40% 50%; left: 40%;  top: 50%;  margin-left: -50px;
  margin-top: -50px;">
		<br/>
		<br/>
		 
			  <font face="Arial" size="2" color="#515756">
				 <form  action="validar_usuariom.php" method="post">
							Usuario: <input type="text" id="usuario" name="usuario" size="20" maxlength="20" /><br>
							Contrasena: <input type="password" id="password" name="password" size="10" maxlength="10" /><br>
							<input class="button-style1" type="submit" value="Iniciar Sesion"/>
				 </form>
			   </font>
			
		<br/>
		</div>
		
		<br/>
		
		
		
	
   </div><!-- /content -->
   
   
</body>
</html>