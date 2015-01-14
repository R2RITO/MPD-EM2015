<?php
 
/**
 * Clase intermedia para la realizaciÃ³n de consultas en la BD.
 * 
 * Esta clase unica se ocupa de las consultas en la BD.
 *
 * @property $instance: Es la unica instancia posible de FachadaBD, se usa para el patron singleton.
 * @method getInstance(): Obtiene la unica instancia de la clase.
 * @method __wakeup(): Evita que se deserialice la instancia de FachadaBD.
 * @method __sleep(): Evita que se deserialice una instancia de FachadaBD.
 * @method conectar($usuario,$password): Se conecta con la base de datos.
 * @method: desconectar(): Cierra la conexion con la base de datos.
 * @method validarUsuario($ci): Valida un usuario del sistema.
 * @method validarPacienteBD($ci): Valida un paciente en la BD.
 * @method agregarUsuarioBD($objeto): Agrega un nuevo usuario a la BD.
 * @method agregarPacienteBD($objeto): Agrega un nuevo paciente a la BD.
 * @method agregarTonoFlexDorBD($objeto): Agrega una preferencia de tono flexor dorsal a la BD.
 * @method agregarCaracMarchaBD($objeto): Agrega una preferencia de caracteristica de marcha a la BD.
 * @method agregarPesoBD($objeto): Agrega una preferencia de peso a la BD.
 * @method consultarPesoBD(): Consulta las preferencias de peso de un usuario.
 * @method consultarTNBD(): Consulta las preferencias del tono flexor dorsal de un usuario.
 * @method consultarTNBD_etiqueta_I(): Consulta las preferencias de etiqueta de  un usuario en cuanto a tono flexor dorsal izquierdo
 * @method consultarTNBD_dominio_I(): Consulta las preferencias de los dominios de un usuario en cuanto a tono flexor dorsal izquierdo
 * @method consultarTNBD_grado_I($dom,$et): Consulta el grado de semejanza en cuanto a la preferencia del usuario en tono flexor dorsal izquierdo.
 * @method consultarTNBD_etiqueta_D(): Consulta las preferencias de etiqueta de  un usuario en cuanto a tono flexor dorsal derecho
 * @method consultarTNBD_dominio_D(): Consulta las preferencias de los dominios de un usuario en cuanto a tono flexor dorsal derecho 
 * @method consultarTNBD_grado_D($dom,$et): Consulta el grado de semejanza en cuanto a la preferencia del usuario en tono dorsal derecho.
 * @method consultarCMBD(): Consulta las preferencias de etiquetas del usuario en cuanto a las caracteristicas de marcha.
 * @method consultarCM_etiquetas(): Consulta las etiquetas de caracteristicas de marcha.
 * @method consultarCM_grado($et1,$et2): Consulta el grado de semejanza entre las etiquetas de caracteristicas de marcha.
 * @method consultarHistorialBD($ci): Consulta el numero del historial en cuanto a la cedula. 
 * @method consultarPacienteBD($ci): Consulta el paciente de la BD en cuanto a la cedula. 
 * @method consultarPacienteNombre($nombre, $apellido): Consulta el paciente en cuanto al nombre y apellido.
 * @method consultarEtiquetaPesoBD(): Consulta las etiquetas de peso.
 * @method consultarEtiquetaPosiblePesoBD(): Consulta las posibles etiquetas de peso.
 * @method consultarEtiquetaTonoFlexDorIzqBD(): Consulta las etiquetas tono flexor dorsal izquierdo. 
 * @method consultarEtiquetaPosibleTonoFlexDorBD(): Consulta las posibles etiquetas de tono flexor. 
 * @method consultarDominioFijoTonoFlexDorIzqBD(): Consulta dominio fijo tono flexor dorsal izquerdo. 
 * @method consultarDominioFijoPosibleTonoFlexDorBD(): Consulta todos los dominios posibles a utilizar.
 * @method consultarEtiquetaTonoFlexDorDerBD(): Consulta etiquetas de tono flexor dorsal derecho. 
 * @method consultarDominioFijoTonoFlexDorDerBD(): Consulta domininio de tono flexor dorsal derecho usado por el usuario. 
 * @method consultarEtiquetaCaracMarchaBD(): Consulta etiquetas de caracteristicas de marcha usadas por el usuario.
 * @method consultarEtiquetaPosibleCaracMarchaBD(): Consulta todas las etiquetas posibles de caracteristicas de marcha. 
 * @method consultarDispositivosBD($ci): Consulta los dispositivos usados por un paciente. 
 * @method agregarDispositivosBD($ci, $dispositivo, $grado): Agrega dispositivos usados por un paciente a la BD.
 * @method consultarDispositivosPosiblesBD(): Consulta todos los dispositivos posibles.
 * @method agregarHistoriaBD($objeto): Agrega un historial a la base de datos. 
 * @method compararAtributosBD($etiquetaP, $etiquetaTFDI, $etiquetaTFDD, $etiquetaCM): Compara atributos en la BD. Consultas generales. 
 * @method compararAtributosBD2($etiquetaP, $etiquetaTFDI, $etiquetaTFDD, $etiquetaCM): Compara atributos en la BD.
 * @method compararDispositivosIgualesBD($ci): Compara pacientes segun dispositivos que utiliza. 
 * @method compararDispositivosIgualesBD2($ci): Compara pacientes segun dispositivos que usa. 
 * @method compararDispositivosIgualesBDAlfa($ci,$alfa): Compara pacientes segun dispositivos que usa y selecciona un rango segun un alfacorte dado. 
 * @method agregarCaracMarchaEtiquetasBD($etiqueta): Agrega etiqueta nueva de caracteristica de marcha a la BD. 
 * @method eliminarPacienteBD($id): Elimina un paciente de la BD.
 * @method perfilDefinido($username): Revisa si el usuario tiene definido los parámetros de su perfil.
 * @author: Veronica, Andreina ,Daniela & Ruben
 * @version: 1.0
 * @ignore: Favor documentar de esta manera.
 */
class FachadaBD {

    /** @global $instance: Para implementar el patron singleton */
    private static $instance;

    /**
     * Metodo que permite obtener la unica instancia de la clase.
     * 
     * Para asegurar tener una sola instancia de la clase FachadaBD
     * se usa el patron singleton.
     * 
     * @return self::$instance: Retorna una instancia de ella misma.
     * @author: Veronica, Andreina.
     */
    public static function getInstance() {
        //si no existe instancia de la clase se crea
        // si existe se retorna la instancia existente.
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Previene la creacion de una nueva instancia mediante new.
     *
     * @author: Veronica, Andreina.
     */
    private function __construct() {

    }

    /**
     * Evita la clonacion de este objeto.
     * @throws Exception: Excepcion con un mensaje que indica que no se puede clonar.
     * @author: Veronica, Andreina.
     */
    private function __clone() {
        
        throw new Exception('No se puede clonar');
    }

    /** 
     * Evita que se deserialice una instancia de FachadaBD.
     * @throws Exception: Escribe un mensaje de error.
     * @author: Veronica, Andreina.
     */
    public function __wakeup() {
        throw new Exception("No se puede deserializar una instancia de " . get_class($this) . " class.");
    }

    /** 
     * Evita que se deserialice una instancia de FachadaBD.
     * @throws Exception: Escribe un mensaje de error.
     * @author: Veronica, Andreina.
     */
    public function __sleep() {
        throw new Exception("No se puede serializar una instancia de " . get_class($this) . " class.");
    }

    /**
     * Funcion que abre una conexion con la base de datos.
     *
     * @return $conexion: Conexion con la base de datos.
     * @author: Veronica, Andreina.
     */
    function conectar($usuario, $password) {
        $conexion = oci_connect($usuario, $password, "localhost/XE");
        if (!$conexion) {
            $e = oci_error();  
            echo $e['message']."<br>";
        }else{  
            return $conexion;
        }
    }

    /**
     * Funcion que cierra una conexion con la base de datos.
     * @author: Veronica, Andreina.
     */
    function desconectar($conexion) {
        oci_close($conexion);
    }

    /**
     * Funcion que devuelve los datos de un usuario especifico segun su cedula de identidad.
     * @param $usuario: Nombre de usuario que se desea consultar.
     * @return $result: Resultados de la consulta.
     * @author: Veronica, Andreina.
     */
    function validarUsuarioBD($usuario) {
        $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $query = "SELECT Contrasena, Usuario, Nombres, Apellidos, Fisio FROM Medico WHERE Usuario = '".$usuario."'";
        $result = oci_parse($conexion, $query);
        oci_execute($result);

        return $result;
    }

    /**
     * Funcion que indica si un paciente existe o no en la BD.
     * @param $ci: Cedula de identidad del paciente.
     * @return true: Si el paciente existe en la BD.
     * @return false: Si el paciente no existe en la BD.
     * @author: Veronica, Andreina.
     */
    function validarPacienteBD($ci) {
        $conn = $this->conectar("miniproyecto", "miniproyecto");
        $query = "SELECT ci FROM Paciente WHERE ci = ".$ci;
        $result = oci_parse($conn, $query);
        oci_execute($result);

        if (($row = oci_fetch_array($result, OCI_BOTH))) {
            return true;
            }
        return false;
    }

    /**
     * Funcion que agrega un usuario nuevo en la base de datos.
     * 
     * Crea un nuevo usuario y agrega un nuevo medico a la tabla MEDICO con los valores dados.
     *
     * @param $objeto: Datos dados por el usuario que desea registrarse.
     * @return $result: Resultado de agregar un paciente nuevo a la BD.
     * @author: Veronica, Andreina.
     */
    function agregarUsuarioBD($objeto) {

        $user = strtoupper(htmlentities($objeto->getUsuario(), ENT_QUOTES));
        
        $pass = $objeto->getContrasena();

        $conexion = $this->conectar("miniproyecto","miniproyecto");

        $agrego = oci_parse($conexion,'CREATE USER '.$user.' IDENTIFIED BY '.$pass);
        oci_execute($agrego);

        $agrego = oci_parse($conexion,'GRANT ALL PRIVILEGES TO '.$user);
        oci_execute($agrego);

        $string = "INSERT INTO USUARIOS VALUES ('".$user."')";
        $result = oci_parse($conexion, $string);
        oci_execute($result);

        $result = oci_parse($conexion, "INSERT INTO MEDICO VALUES (".$objeto->getCI().", '".$objeto->getNombre()."', '".$objeto->getApellido()."', '".$user."', '".$pass."', ".$objeto->isFisio().")");
        oci_execute($result);

        $this->desconectar($conexion);
        return $result;
    }


    /**
     * Funcion que agrega un paciente nuevo a la BD.
     *
     * Realiza un INSERT con todos los datos provistos por el medico.
     * @param $objeto: Datos suministrados por el medico.
     * @return $result: Resultado de agregar un nuevo paciente.
     * @author: Veronica, Andreina.
     */
     function agregarPacienteBD($objeto) {
        $conexion = $this->conectar("miniproyecto", "miniproyecto");

        $result = oci_parse($conexion, "INSERT INTO PACIENTE VALUES (".$objeto->getCI().", '".$objeto->getNombres()."', '".$objeto->getApellidos()."', '".$objeto->getProfesion()."', '".$objeto->getLugarRes()."', to_date('".$objeto->getFechaNac()."', 'DD-MM-YYYY'), ID_historiales.nextval, '".$objeto->getDiagnostico()."', '".$objeto->getInterQuir()."')");
        oci_execute($result);

        $this->desconectar($conexion);
        return $result;
    }

    /**
     * Funcion que agrega una preferencia de algun tono flexor dorsal en la BD.
     *
     * Los tonos flexores dorsales van a tener etiqueta, dominio, grado y un usuario
     * asociado a estos.
     *
     * @param $objeto: Datos suministrados por el medico.
     * @return $result: Resultado de agregar un tono flexor dorsal.
     * @author: Veronica, Andreina.
     */
    function agregarTonoFlexDorBD($objeto) {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));

         $conexion = $this->conectar("miniproyecto", "miniproyecto");

        $query = "begin sem_fijo_etiq(:dom_name, :user, :etiqueta, :dominio, :grado); end;";

        $result = oci_parse($conexion, $query);

        oci_bind_by_name($result, ":dom_name", $objeto->getDom());
        oci_bind_by_name($result, ":user", $user);
        oci_bind_by_name($result, ":etiqueta", $objeto->getEt());
        oci_bind_by_name($result, ":dominio", $objeto->getVal());
        oci_bind_by_name($result, ":grado", $objeto->getGrado());

        oci_execute($result);

        $this->desconectar($conexion);
        return $result;
    }

    /**
     * Funcion que agrega una preferencia de caracteristica de marcha segun el usuario en la BD.
     *
     * Las caracteristicas de marcha van a tener etiquetas, dominios, grado y un usuario
     * asociado a estas.
     *
     * @param $objeto: Datos suministrados por el medico.
     * @return $result: Resultado de agregar una caracteristica de marcha.
     * @author: Veronica, Andreina.
     */
    function agregarCaracMarchaBD($objeto) {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));

         $conexion = $this->conectar("miniproyecto", "miniproyecto");

        $query = "begin sem_etiquetas(:dom_name, :user, :etiqueta1, :etiqueta2, :grado); end;";

        $result = oci_parse($conexion, $query);

        oci_bind_by_name($result, ":dom_name", $objeto->getDom());
        oci_bind_by_name($result, ":user", $user);
        oci_bind_by_name($result, ":etiqueta1", $objeto->getEt1());
        oci_bind_by_name($result, ":etiqueta2", $objeto->getEt2());
        oci_bind_by_name($result, ":grado", $objeto->getGrado());

        oci_execute($result);

        $this->desconectar($conexion);
        return $result;
    }

    
    /**
     * Funcion que agrega una preferencia de peso segun el usuario en la BD.
     *
     * El peso pertenece al dominio continuo por lo que es guardado como
     * un objeto trapezoidal en la BD, asociado al usuario.
     *
     * @param $objeto: Datos suministrados por el medico.
     * @return $result: Resultado de agregar sus preferencias de peso.
     * @author: Veronica, Andreina.
     */
    function agregarPesoBD($objeto) {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));

         $conexion = $this->conectar("miniproyecto", "miniproyecto");

        $result = oci_parse($conexion, "INSERT INTO UDLinLab_tab VALUES ('".$objeto->getLabel()."' , '".$user."', 'Peso', Trapezoid_objtyp(".$objeto->getN1().", ".$objeto->getN2().", ".$objeto->getN3().", ".$objeto->getN4()."))");

        oci_execute($result);

        $this->desconectar($conexion);
        return $result;
    }

    /**
     * Funcion que consulta una preferencia de peso segun el usuario en la BD.
     * 
     * @return $results: Resultados de consulta.
     * @author: Veronica, Andreina.
     */
    function consultarPesoBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT U.Label, U.Trapezoid.T_a, U.Trapezoid.T_b, U.Trapezoid.T_c, U.Trapezoid.T_d FROM UDLinLab_tab U WHERE dom_name = 'Peso' AND user_name = '".$user."'";
                
         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

    /**
     * Funcion que consulta una preferencia del usuario en cuanto a tono flexor dorsal.
     * 
     * @return $res: Resultados de consulta.
     * @author: Veronica, Andreina.
     */
    function consultarTNBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT etiqueta, dominio, grado FROM semejanza_fijo_etiqueta WHERE usuario = '".$user."'";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);
        return $res;
    }
	
    /**
     * Funcion que consulta las etiquetas del usuario en tono flexor dorsal izquierdo.
     * 
     * @return $res: Resultados de consulta.
     * @author: Veronica, Andreina.
     */
     function consultarTNBD_etiqueta_I() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT  DISTINCT etiqueta FROM semejanza_fijo_etiqueta WHERE usuario = '".$user."' AND DOM_NAME = 'Tono_Flexores_Dorsales_Izq'";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);
        return $res;
     }
	
    /**
     * Funcion que consulta el dominio del usuario en cuanto a tono flexor dorsal izquierdo.
     * 
     * @return $res: Resultados de consulta.
     * @author: Veronica, Andreina.
     */
     function consultarTNBD_dominio_I() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT dominio FROM semejanza_fijo_etiqueta WHERE usuario = '".$user."' AND DOM_NAME = 'Tono_Flexores_Dorsales_Izq'";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);
        return $res;
     }
	
    /**
     * Funcion que consulta grado de semejanza en cuanto a las preferencias del usuario en tono flexor dorsal izquierdo.
     * 
     * @param $dom: Dominio del tono flexor dorsal izquierdo.
     * @param $et: Etiqueta del tono flexor dorsal izquierdo.
     * @return $res: Resultados de consulta.
     * @author: Veronica, Andreina.
     */
     function consultarTNBD_grado_I($dom,$et) {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT grado FROM semejanza_fijo_etiqueta WHERE dominio=".$dom." AND etiqueta='".$et."' AND usuario = '".$user."' AND DOM_NAME = 'Tono_Flexores_Dorsales_Izq'";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);
        return $res;
     }
	
    /**
     * Funcion que consulta las etiquetas del usuario en cuanto a tono flexor dorsal derecho.
     * 
     * @return $res: Resultados de consulta.
     * @author: Veronica, Andreina.
     */
     function consultarTNBD_etiqueta_D() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT  DISTINCT etiqueta FROM semejanza_fijo_etiqueta WHERE usuario = '".$user."' AND DOM_NAME = 'Tono_Flexores_Dorsales_Der'";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);
        return $res;
     }
	
    /**
     * Funcion que consulta el dominio del usuario en cuanto a tono flexor dorsal derecho.
     * 
     * @return $res: Resultados de consulta.
     * @author: Veronica, Andreina.
     */
     function consultarTNBD_dominio_D() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT dominio FROM semejanza_fijo_etiqueta WHERE usuario = '".$user."' AND DOM_NAME = 'Tono_Flexores_Dorsales_Der'";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);
        return $res;
     }
	
    /**
     * Funcion que consulta grado de semejanza en cuanto a las preferencias del usuario en tono flexor dorsal derecho.
     * 
     * @param $dom: Dominio del tono flexor dorsal derecho.
     * @param $et: Etiqueta del tono flexor dorsal derecho.
     * @return $res: Resultados de consulta.
     * @author: Veronica, Andreina.
     */
    function consultarTNBD_grado_D($dom,$et) {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT grado FROM semejanza_fijo_etiqueta WHERE dominio=".$dom." AND etiqueta='".$et."' AND usuario = '".$user."' AND DOM_NAME = 'Tono_Flexores_Dorsales_Der'";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);
        return $res;
    }

    /**
     * Funcion que consulta grado de semejanza en cuanto a las preferencias del usuario en las caracteristicas de marcha.
     * 
     * @return $results: Resultados de consulta.
     * @author: Veronica, Andreina.
     */
    function consultarCMBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT etiqueta_1, etiqueta_2, grado FROM semejanza_etiquetas WHERE dom_name = 'Carac_Marcha' AND usuario = '".$user."' order by etiqueta_1 ";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }
	
    /**
     * Funcion que consulta las etiquetas de las caracteristicas de marcha.
     *
     * @return $results: Etiquetas de caracteristicas de marcha.
     * @author: Veronica, Andreina.
     */
    function consultarCM_etiquetas() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT etiqueta_1 FROM semejanza_etiquetas WHERE dom_name = 'Carac_Marcha' AND usuario = '".$user."' order by etiqueta_1 ";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }
	
    /**
     * Funcion que consulta el grado de semejanza en cuanto a las preferencias del usuario en la caracteristicas de marcha.
     *
     * @param $et1: Etiqueta 1 a comparar.
     * @param $et2: Etiqueta 2 a comparar.
     * @author: Veronica, Andreina.
     */
    function consultarCM_grado($et1,$et2) {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT grado FROM semejanza_etiquetas WHERE dom_name = 'Carac_Marcha' AND ((etiqueta_1 = '".$et1."'  AND etiqueta_2 = '".$et2."') OR (etiqueta_1 = '".$et2."'  AND etiqueta_2 = '".$et1."')) AND usuario = '".$user."' order by etiqueta_1 ";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

    /**
     * Funcion que consulta el numero de historial de un paciente en base a su cedula.
     *
     * @param $ci: Cedula del paciente.
     * @author: Veronica, Andreina.
     */
    function consultarHistorialBD($ci) {
        $query = "SELECT id_historial FROM Paciente WHERE ci = ".$ci;
                
         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);

        $id_hist = 0;

        if (($row = oci_fetch_array($results, OCI_BOTH))){
            $id_hist = $row[0];
            return $id_hist;
        }

        return $id_hist;
    }

    /** 
     * Funcion que consulta el historial de un paciente en base a su cedula.
     *
     * @param $ci: Cedula de identidad del paciente.
     * @author: Veronica, Andreina.
     */
    function consultarPacienteBD($ci) {
        $query = "SELECT * FROM Paciente WHERE ci = ".$ci;
                
         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);

        return $results;
    }

    /**
     * Funcion que consulta pacientes por su nombre en la BD.
     *
     * @param $nombre: Nombre del paciente.
     * @param $apellido: Apellido del paciente.
     * @return $results: Resultados de la consulta.
     * @author: Ruben 
     */
    function consultarPacienteNombre($nombre, $apellido){
       if ( is_null($apellido) ){
           $query = "SELECT nombres, apellidos, ci from Paciente WHERE (nombres = '".$nombre."'"." OR apellidos = '".$nombre."' )";
       } else {
           $query = "SELECT nombres, apellidos, ci from Paciente WHERE nombres = '".$nombre."' AND apellidos = '".$apellido."'";
       }
    
        $conexion = $this->conectar("miniproyecto", "miniproyecto");
       $results = oci_parse($conexion, $query);
       oci_execute($results);
       $this->desconectar($conexion);

       return $results;
   }

    /**  
     * Funcion que consulta las etiquetas de peso utilizadas por el usuario.
     * 
     * @return results: Etiquetas de peso usadas por el usuario. 
     * @author: Veronica, Andreina.
     */
    function consultarEtiquetaPesoBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT Label FROM UDLinLab_tab WHERE dom_name = 'Peso' AND user_name = '".$user."'";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

    /** 
     * Funcion que consulta todas las etiquetas posibles de peso.
     *
     * @return $results: Etiquetas de peso.
     * @author: Veronica, Andreina.
     */
    function consultarEtiquetaPosiblePesoBD() {
        $query = "SELECT DISTINCT Label FROM UDLinLab_tab WHERE dom_name = 'Peso'";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

    /** 
     * Funcion que consulta todas las etiquetas de tono flexor dorsal izquierdo usadas por el usuario.
     *
     * @return $results: Etiquetas de tono flexor dorsal izquierdo.
     * @author: Veronica, Andreina.
     */
    function consultarEtiquetaTonoFlexDorIzqBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT etiqueta FROM semejanza_fijo_etiqueta WHERE dom_name = 'Tono_Flexores_Dorsales_Izq' AND usuario = '".$user."'";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

    /** 
     * Funcion que consulta todas las etiquetas posibles de tono flexor dorsal.
     *
     * @return $results: Etiquetas de tono flexor dorsal.
     * @author: Veronica, Andreina.
     */
    function consultarEtiquetaPosibleTonoFlexDorBD() {
        $query = "SELECT etiq FROM etiqueta_tono_muscular";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

    /** 
     * Funcion que consulta los dominios usados por el usuario.
     *
     * @return $results: Dominios del usuario.
     * @author: Veronica, Andreina.
     */
    function consultarDominioFijoTonoFlexDorIzqBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT dominio FROM semejanza_fijo_etiqueta WHERE dom_name = 'Tono_Flexores_Dorsales_Izq' AND usuario = '".$user."'";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

    /** 
     * Funcion que consulta los dominios posibles a usar.
     *
     * @return $results: Dominios.
     * @author: Veronica, Andreina.
     */
    function consultarDominioFijoPosibleTonoFlexDorBD() {
        $query = "SELECT valor FROM D_tono_muscular";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

    /** 
     * Funcion que consulta todas las etiquetas de tono flexor dorsal derecho usadas por el usuario.
     *
     * @return $results: Etiquetas de tono flexor dorsal derecho.
     * @author: Veronica, Andreina.
     */
    function consultarEtiquetaTonoFlexDorDerBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT etiqueta FROM semejanza_fijo_etiqueta WHERE dom_name = 'Tono_Flexores_Dorsales_Der' AND usuario = '".$user."'";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

    /** 
     * Funcion que consulta los dominios de tono flexor dorsal derecho usados por el usuario.
     *
     * @return $results: Dominio de tono flexor dorsal derecho.
     * @author: Veronica, Andreina.
     */
    function consultarDominioFijoTonoFlexDorDerBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT dominio FROM semejanza_fijo_etiqueta WHERE dom_name = 'Tono_Flexores_Dorsales_Izq' AND usuario = '".$user."'";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

    /** 
     * Funcion que consulta las etiquetas de caracteristicas de marcha usadas por el usuario.
     *
     * @return $results: Etiquetas de caracteristicas de marcha
     * @author: Veronica, Andreina.
     */
    function consultarEtiquetaCaracMarchaBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT etiqueta_1 FROM semejanza_etiquetas WHERE dom_name = 'Carac_Marcha' AND usuario = '".$user."'";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

    /** 
     * Funcion que consulta todas las etiquetas posibles de caracteristicas de marcha. 
     *
     * @return $results: Etiquetas de caracteristicas de marcha
     * @author: Veronica, Andreina.
     */
    function consultarEtiquetaPosibleCaracMarchaBD() {
        $query = "SELECT etiq FROM etiqueta_carac_marcha";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

    /** 
     * Funcion que consulta los dispositivos usados por el paciente.
     *
     * @param $ci: Cedula de identidad del paciente.
     * @return $results: Dispositivos usados por el paciente.
     * @author: Veronica, Andreina.
     */
    function consultarDispositivosBD($ci) {
        $query = "SELECT dispositivo, grado FROM dispositivos_usados WHERE paciente = ".$ci;

        $conexion = $this->conectar('miniproyecto', 'miniproyecto');
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

    /** 
     * Funcion que agrega los dispositivos utilizados por el paciente.
     *
     * @param $ci: Cedula de identidad del paciente.
     * @param $dispositivo: Dispositivo que usa el paciente.
     * @param $grado: Grado de uso del dispositivo. 
     * @author: Veronica, Andreina.
     */
    function agregarDispositivosBD($ci, $dispositivo, $grado) {

        $hist = $this->consultarHistorialBD($ci);
        $query = "INSERT INTO dispositivos_usados VALUES (".$ci.", ".$hist.", '".$dispositivo."', ".$grado.")";

        $conexion = $this->conectar('miniproyecto', 'miniproyecto');
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
    }

    /** 
     * Funcion que consulta los dispositivos posibles a usar por el paciente.
     *
     * @return $results: Dispositivos.
     * @author: Veronica, Andreina.
     */
    function consultarDispositivosPosiblesBD() {
        $query = "SELECT DISTINCT etiq FROM dispositivo";

        $conexion = $this->conectar('miniproyecto', 'miniproyecto');
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

    /**  
     * Funcion que agrega un examen fisico articular a la base de datos.
     *
     * @param $objeto: Examen fisico articular a agregar en la BD. 
     * @author: Veronica, Andreina.
     */
    function agregarHistoriaBD($objeto) {

        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
    
        $valores = "INSERT INTO EFA_tab VALUES (".$objeto->getIDPersona().", ".$objeto->getIDHistorial().", to_date('".$objeto->getFechaExamen()."', 'YYYY-MM-DD'), '".$objeto->getMedicoInt()."', '".$user."', ";

        if($objeto->getPeso()->getLabel() == null){
            $valores .= " D_Peso(". $objeto->getPeso()->getValor() . "),";
        } elseif($objeto->getPeso()->getValor() == null) {
            $valores .= " D_Peso('". $objeto->getPeso()->getLabel() . "'),";
        } else{
            $valores .= " D_Peso('" . $objeto->getPeso()->getLabel() . "'," . $objeto->getPeso()->getValor() . " ," . $objeto->getPeso()->getValor() . " ," .$objeto->getPeso()->getValor(). " ," .$objeto->getPeso()->getValor(). "),";
        }

        if($objeto->getTonoFlexDorIzq()->getGrado() == null){
            $valores .= " dominio_fijo_t(". $objeto->getTonoFlexDorIzq()->getVal() . "),";
        } else {
            $valores .= " dominio_fijo_t('" . $objeto->getTonoFlexDorIzq()->getDom() . "' , '" . $objeto->getTonoFlexDorIzq()->getEt() . "' ," . $objeto->getTonoFlexDorIzq()->getVal() . " ," .$objeto->getTonoFlexDorIzq()->getGrado(). "),";
        }

        if($objeto->getTonoFlexDorDer()->getGrado() == null){
            $valores .= " dominio_fijo_t(". $objeto->getTonoFlexDorDer()->getVal() . "),";
        } else {
            $valores .= " dominio_fijo_t('" . $objeto->getTonoFlexDorDer()->getDom() . "' , '" . $objeto->getTonoFlexDorDer()->getEt() . "' ," . $objeto->getTonoFlexDorDer()->getVal() . " ," .$objeto->getTonoFlexDorDer()->getGrado(). "),";
        }

        if($objeto->getCaracMarcha()->getGrado() == null){
            $valores .= " etiqueta_t('". $objeto->getCaracMarcha()->getEt1() . "')";
        } else {
            $valores .= " etiqueta_t('" . $objeto->getCaracMarcha()->getDom() . "' ,'" . $objeto->getCaracMarcha()->getEt1() . "' , '" . $objeto->getCaracMarcha()->getEt2() . "' ," .$objeto->getCaracMarcha()->getGrado(). ")";
        }

        $valores .= ")"; 
        
        $conexion = $this->conectar('miniproyecto', 'miniproyecto');

        $result = oci_parse($conexion, $valores);
        oci_execute($result);

        $this->desconectar($conexion);
    }

    /**  
     * Funcion que hace la consultas generales del sistema.
     * @param $etiquetaP: Etiqueta de peso a usar para realizar la consulta.
     * @param $etiquetaTFDI: Etiqueta de tono flexor dorsal izquierdo a usar para realizar la consulta.
     * @param $etiquetaTFDI: Etiqueta de tono flexor dorsal derecho a usar para realizar la consulta.
     * @param $etiquetaTFDI: Etiqueta de caracteristicas (tipo) de marcha a usar para realizar la consulta.
     *
     * @return $res: Resultado de la consulta.
     * @author: Veronica, Andreina.
     */
    function compararAtributosBD($etiquetaP, $etiquetaTFDI, $etiquetaTFDD, $etiquetaCM) {

        $atributos = "P.Nombres, P.Apellidos, P.ci, E.Id_Historial, E.Fecha_Examen";

        $condiciones = "E.ID_persona = P.ci ";

            
        if ($etiquetaP <> 'a') {
            $atributos .= ", E.Peso.Trap.FEQ('Peso', '".$etiquetaP."') ";
            $condiciones .= "AND E.Peso.Trap.FEQ('Peso','".$etiquetaP."') > 0 ";
        }

        if ($etiquetaTFDI <> 'a') {
            if (gettype($etiquetaTFDI) == 'integer')  {
                $atributos .= ", E.Tono_Flex_Dor_Izq.FEQ(".$etiquetaTFDI.") ";
                $condiciones .= "AND E.Tono_Flex_Dor_Izq.FEQ(".$etiquetaTFDI.") > 0 ";
            } else if (gettype($etiquetaTFDI) == 'string') {
                $atributos .= ", E.Tono_Flex_Dor_Izq.FEQ('Tono_Flexores_Dorsales_Izq','".$etiquetaTFDI."') ";
                $condiciones .= "AND E.Tono_Flex_Dor_Izq.FEQ('Tono_Flexores_Dorsales_Izq','".$etiquetaTFDI."') > 0 ";
            }
        }

        if ($etiquetaTFDD <> 'a') {
            if (gettype($etiquetaTFDD) == 'integer')  {
                $atributos .= ", E.Tono_Flex_Dor_Der.FEQ(".$etiquetaTFDD.") ";
                $condiciones .= "AND E.Tono_Flex_Dor_Der.FEQ(".$etiquetaTFDD.") > 0 ";
            } else if (gettype($etiquetaTFDD) == 'string'){
                $atributos .= ", E.Tono_Flex_Dor_Der.FEQ('Tono_Flexores_Dorsales_Der' ,'".$etiquetaTFDD."') ";
                $condiciones .= "AND E.Tono_Flex_Dor_Der.FEQ('Tono_Flexores_Dorsales_Der' , '".$etiquetaTFDD."') > 0 ";
            }
        }


        if ($etiquetaCM <> 'a') {
            $atributos .= ", E.Carac_Marcha.FEQ('Carac_Marcha', '".$etiquetaCM."') ";
            $condiciones .= "AND E.Carac_Marcha.FEQ('Carac_Marcha', '".$etiquetaCM."') > 0 ";
        }


        $query = "SELECT ".$atributos." FROM EFA_tab E, Paciente P WHERE ".$condiciones;

         $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);

        return $res;
    }

    /**  
     * Funcion que hace la consultas generales del sistema.
     * @param $etiquetaP: Etiqueta de peso a usar para realizar la consulta.
     * @param $etiquetaTFDI: Etiqueta de tono flexor dorsal izquierdo a usar para realizar la consulta.
     * @param $etiquetaTFDI: Etiqueta de tono flexor dorsal derecho a usar para realizar la consulta.
     * @param $etiquetaTFDI: Etiqueta de caracteristicas (tipo) de marcha a usar para realizar la consulta.
     *
     * @return $res: Resultado de la consulta.
     * @author: Veronica, Andreina.
     */
    function compararAtributosBD2($etiquetaP, $etiquetaTFDI, $etiquetaTFDD, $etiquetaCM) {
  
        $atributos = "P.Nombres, P.Apellidos, P.ci, E.Fecha_Examen";

        $condiciones = "E.ID_persona = P.ci ";

            
        if ($etiquetaP <> 'a') {
            $atributos .= ", E.Peso.Trap.FEQ('Peso', '".$etiquetaP."') ";
            $condiciones .= "AND E.Peso.Trap.FEQ('Peso','".$etiquetaP."') > 0 ";
        }

        if ($etiquetaTFDI <> 'a') {
            if (gettype($etiquetaTFDI) == 'integer')  {
                $atributos .= ", E.Tono_Flex_Dor_Izq.FEQ(".$etiquetaTFDI.") ";
                $condiciones .= "AND E.Tono_Flex_Dor_Izq.FEQ(".$etiquetaTFDI.") > 0 ";
            } else if (gettype($etiquetaTFDI) == 'string') {
                $atributos .= ", E.Tono_Flex_Dor_Izq.FEQ('Tono_Flexores_Dorsales_Izq','".$etiquetaTFDI."') ";
                $condiciones .= "AND E.Tono_Flex_Dor_Izq.FEQ('Tono_Flexores_Dorsales_Izq','".$etiquetaTFDI."') > 0 ";
            }
        }

        if ($etiquetaTFDD <> 'a') {
            if (gettype($etiquetaTFDD) == 'integer')  {
                $atributos .= ", E.Tono_Flex_Dor_Der.FEQ(".$etiquetaTFDD.") ";
                $condiciones .= "AND E.Tono_Flex_Dor_Der.FEQ(".$etiquetaTFDD.") > 0 ";
            } else if (gettype($etiquetaTFDD) == 'string'){
                $atributos .= ", E.Tono_Flex_Dor_Der.FEQ('Tono_Flexores_Dorsales_Der' ,'".$etiquetaTFDD."') ";
                $condiciones .= "AND E.Tono_Flex_Dor_Der.FEQ('Tono_Flexores_Dorsales_Der' , '".$etiquetaTFDD."') > 0 ";
            }
        }


        if ($etiquetaCM <> 'a') {
            $atributos .= ", E.Carac_Marcha.FEQ('Carac_Marcha', '".$etiquetaCM."') ";
            $condiciones .= "AND E.Carac_Marcha.FEQ('Carac_Marcha', '".$etiquetaCM."') > 0 ";
        }


        $query = "SELECT ".$atributos." FROM EFA_tab E, Paciente P WHERE ".$condiciones." ORDER BY P.Apellidos, P.Nombres";

         $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);

        return $res;
    }

    /**
     * Funcion que compara los pacientes segun los dispostivos que utiliza.
     *
     * @param $ci: Cedula de identidad del paciente que se desea comparar con los demas.
     * @author: Veronica, Andreina.
     */
    function compararDispositivosIgualesBD($ci) {

        $query = "SELECT P.Nombres, P.Apellidos, P.ci, P.Id_Historial, P.FEQ(".$ci."), P.prom_parecido3(".$ci.") FROM Paciente P WHERE P.FEQ(".$ci.") > 0 AND P.prom_parecido3(".$ci.") > 0";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);

        return $res;
    }

    /**
     * Funcion que compara los pacientes segun los dispostivos que utiliza.
     *
     * @param $ci: Cedula de identidad del paciente que se desea comparar con los demas.
     * @author: Veronica, Andreina.
     */
    function compararDispositivosIgualesBD2($ci) {

        $query = "SELECT P.Nombres, P.Apellidos, P.ci, P.FEQ(".$ci."), P.prom_parecido3(".$ci.") FROM Paciente P WHERE P.FEQ(".$ci.") > 0 AND P.prom_parecido3(".$ci.") > 0";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);

        return $res;
    }

    /** 
     * Funcion que compara los pacientes segun los dispostivos que utiliza con un alfacorte dado.
     *
     * @param $ci: Cedula de identidad del paciente que se desea comparar con los demas.
     * @param $alfa: Alfacorte (umbral) deseado.
     * @author: Ruben
     */
    function compararDispositivosIgualesBDAlfa($ci,$alfa) {

        $query = "SELECT P.Nombres, P.Apellidos, P.ci, P.FEQ(".$ci."), P.prom_parecido3(".$ci.") FROM Paciente P WHERE P.FEQ(".$ci.") > ".$alfa." AND P.prom_parecido3(".$ci.") > 0";

         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);

        return $res;
    }

   /**
    * Funcion que agrega una etiqueta nueva a la base de datos.
    *
    * @param $etiqueta: Etiqueta que se desea agregar a la BD.
    * @author: Veronica, Andreina.
    */
    function agregarCaracMarchaEtiquetasBD($etiqueta) {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        
        $res;
        
        $is= oci_parse( $conexion, " SELECT COUNT(ETIQ) FROM etiqueta_carac_marcha WHERE ETIQ='".$etiqueta."'");
        oci_execute($is);

        if($is==0){
            $result = oci_parse($conexion, "INSERT INTO etiqueta_carac_marcha VALUES ( id_dominio.nextval, '".$etiqueta."')");
            oci_execute($result);
            $res=true;
        }else{
            $res=false;
        }
        

        $this->desconectar($conexion);
        return $res;
    }

    /**  
     * Funcion que elimina un paciente de la base de datos.
     *
     * @param $id: Cedula de identidad del paciente que se desea eliminar.
     * @author: Veronica, Andreina.
     */
    function eliminarPacienteBD($id){
    
        $query2 = "delete from paciente where CI='".$id."'";
        $query1 = "delete from efa_tab where ID_PERSONA='".$id."'";
        $query = "delete from dispositivos_usados where PACIENTE='".$id."'";
         $conexion = $this->conectar("miniproyecto", "miniproyecto");
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $res1= oci_parse($conexion, $query1);
        oci_execute($res1);
        $res2= oci_parse($conexion, $query2);
        oci_execute($res2);
        $this->desconectar($conexion);

        return $res;
    
    }
    /**  
     * Verifica si el usuario tiene definido los paráetros de su perfil.
     *
     * @param $username: usuario al que se va a verificar.
     * @author: Daniela, Ruben.
     */
    function perfilDefinido($username){
       // UDLINLAB_TAB
       $conn = $this->conectar("miniproyecto", "miniproyecto");
       // Consulta si existen paramétros creados para el usuairo
        $query = "select user_name from udlinlab_tab where user_name ='.$username.'";
        $result = oci_parse($conn, $query);
        oci_execute($result);
        if (($row = oci_fetch_array($result, OCI_BOTH))) {
            return true;
        }
        return oci_fetch_array($result, OCI_BOTH);
       
    }

}

?>
