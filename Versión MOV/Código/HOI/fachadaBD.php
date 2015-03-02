<?php

class fachadaBD {

    // Para implementar el patron singleton.
    private static $instance;

    // Metodo que permite obtener la unica instancia de la clase.
    public static function getInstance() {
        //si no existe instancia de la clase se crea
        // si existe se retorna la instancia existente.
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Privado se previene la creacion via new.
    private function __construct() {
    }

    // Para evitar la clonacion de este objeto.
    private function __clone() {
        throw new Exception('No se puede clonar');
    }

    public function __wakeup() {
        throw new Exception("No se puede deserializar una instancia de " . get_class($this) . " class.");
    }

    public function __sleep() {
        throw new Exception("No se puede serializar una instancia de " . get_class($this) . " class.");
    }

/*  Funcion que abre una conexion con la base de datos.
*/
    function conectar() {
        $conn = oci_connect("ADMIN", "1234", "localhost/XE");
        if (!$conn) {
            $e = oci_error();  
            echo $e['message']."<br>";
        }else{  
            return $conn;
        }
    }

/*  Funcion que abre una conexion con la base de datos.
*/
    function conectarBD($usuario, $password) {
        $conn = oci_connect($usuario, $password, "localhost/XE");
        if (!$conn) {
            $e = oci_error();  
            echo $e['message']."<br>";
        }else{  
            return $conn;
        }
    }

/*  Funcion que cierra una conexion con la base de datos.
*/
    function desconectar($conn) {
        oci_close($conn);
    }

/*  Funcion que devuelve los datos de un usuario en especifico segun
    su cedula de identidad.
*/
    function validar_usuario($usuario) {
        $conn = $this->conectar();
        $query = "SELECT * FROM MEDICO WHERE login = '".$usuario."'";
        $result = oci_parse($conn, $query);
        oci_execute($result);
        return $result;
    }

/*  Funcion que devuelve true si el paciente esta en la base de datos
*/
    function validar_paciente($id) {
        $ci = (int) $id;
        $conn = $this->conectar();
        $query = "SELECT * FROM PACIENTE WHERE CI = '".$ci."'";
        $result = oci_parse($conn, $query);
        oci_execute($result);
        return $result;
    }


/*  Funcion que agrega un usuario nuevo en la base
    de datos.
*/
	function agregarUsuarioBD($objeto) {

        $user = strtoupper(htmlentities($objeto->getUsuario(), ENT_QUOTES));
        
        $pass = $objeto->getContrasena();

        $conexion = $this->conectar("ADMIN","1234");

        $agrego = oci_parse($conexion,'CREATE USER '.$user.' IDENTIFIED BY '.$pass);
        oci_execute($agrego);

        $agrego = oci_parse($conexion,'GRANT ALL PRIVILEGES TO '.$user);
        oci_execute($agrego);

        $string = "INSERT INTO USUARIOS VALUES ('".$user."')";
        $result = oci_parse($conexion, $string);
        oci_execute($result);

        $result = oci_parse($conexion, "INSERT INTO MEDICO VALUES (".$objeto->getCI().", '".$objeto->getNombres()."', '".$objeto->getApellidos()."', '".$user."', '".$pass."', ".$objeto->isFisio().")");
        oci_execute($result);

        $this->desconectar($conexion);
        return $result;
    }

/*  Funcion que agrega un paciente nuevo en la base de datos.
*/
    function agregarPacienteBD($objeto) {

		$conexion = $this->conectarBD("ADMIN","1234");
        #$conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);

        $result = oci_parse($conexion, "INSERT INTO PACIENTE VALUES (".$objeto->getCI().", '".$objeto->getNombres()."', '".$objeto->getApellidos()."', '".$objeto->getProfesion()."', '".$objeto->getLugarRes()."', to_date('".$objeto->getFechaNac()."', 'YYYY-MM-DD'),'".$objeto->getID_Historial()."','".$objeto->getDiagnostico()."', '".$objeto->getInterQuir()."')");
        oci_execute($result);

        $this->desconectar($conexion);
        return $result;
    }

/*  Funcion que elimina un paciente de la base de datos.
*/
    function eliminarPacienteBD($id){
        $ci = (int) $id;
        $query = "DELETE FROM PACIENTE WHERE CI='".$ci."'";
        $conexion = $this->conectarBD("ADMIN","1234");
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);

        return $res;
    
    }
}



	
?>
