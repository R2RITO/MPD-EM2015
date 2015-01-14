<!--/> 
07-41038 Veronica Hernandez
07-41125 Andreina Loriente
    Archivo que verifica los valores del formulario de inicio de sesion para un usuario.
<!-->

<?php session_start();
 

include_once ("FachadaBD.php");
 
function quitar($mensaje)
{
    $nopermitidos = array("'",'\\','<','>',"\"");
    $mensaje = str_replace($nopermitidos, "", $mensaje);
    return $mensaje;
}

function verificar_usuario(){
    if(trim($_POST["usuario"]) == ""){
        echo "**debe introducir un valor para el campo Usuario";
    }
}

function verificar_contrasena(){
    if(trim($_POST["password"]) == ""){
        echo "**debe introducir un valor para la contraseña";
    }
}

/*  Funcion que verifica los campos ingresados en el formulario del
    ingreso del nuevo usuario.
*/
function usuario_unico(){
    $fbd = FachadaBD::getInstance();
    $usuario = strtoupper(htmlentities($_POST["usuario"], ENT_QUOTES));
    $password = $_POST["password"];

    if(trim($_POST["usuario"]) != ""){
        $valido = $fbd->validarUsuarioBD($usuario);

        if (($row = oci_fetch_array($valido, OCI_BOTH))) {
            if($row[0] == $password){
                $_SESSION['user'] = $row[1];
                $_SESSION['pass'] = $row[0];
                $_SESSION['nombre'] = $row[2];
                $_SESSION['apellido'] = $row[3];
                $_SESSION['esfisio'] = $row[4];
                   
                header('Location: index.php');
                exit;
            } else {
                echo 'Password incorrecto';
            }
        } else{
           // header('Location: iniciosesion.php');
            echo 'El usuario no existe';
        }    
    }   
}

?>

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
<script src="css/5grid/jquery.js"></script>
<script src="css/5grid/init.js?use=mobile,desktop,1000px&amp;mobileUI=1&amp;mobileUI.theme=none"></script>
<!--[if IE 9]><link rel="stylesheet" href="css/style-ie9.css" /><![endif]-->
</head><body>
<div id="header-wrapper">
    <header id="header" class="5grid-layout">
        <div id="row">
            <div id="12u">
                <div id="logo">
                    <h1><a href="#" class="mobileUI-site-name">Inicio de Sesion</a></h1>
                    <p>Hospital J.M. de los Ríos</p>
                </div>
            </div>
        </div>
    </header>
</div>
<div id="wrapper">
    <div class="5grid-layout" id="page-wrapper">
        <div class="row">
            <div class="12u">
                <section id="pbox1">
                
                    <h2>Inicio de Sesión</h2>
                        <form style="text-align:center;" class="s" action="validar_usuario.php" method="post">
                            Usuario: <input type="text" id="usuario" name="usuario" size="20" maxlength="20" /> <?php verificar_usuario(); ?><br>
                            Contraseña: <input type="password" id="password" name="password" size="10" maxlength="10" /><?php verificar_contrasena(); ?><br>
                            <?php usuario_unico(); ?>
                            <input class="button-style1" type="submit" value="Ingresar" />
                        </form>
                    
                    <a href="registro1.php" class="button-style1">Registrarse</a></p>
                    
                </section>
            </div>
        </div>
    </div>
</div>
<div class="5grid-layout" id="copyright">
    <div class="row">
        <div class="12u">
            <section align="right" style="margin-right: 62px;">
                <p>&copy; Laboratorio de Marcha | Hospital J.M de los Ríos &nbsp;&nbsp;&nbsp;&nbsp;              
            </section>
        </div>
    </div>
</div>
</body>
</html>