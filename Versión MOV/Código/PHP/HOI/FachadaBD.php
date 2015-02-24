<?php

class FachadaBD {

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
    function conectar($usuario, $password) {
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
    function validarUsuarioBD($usuario) {
        $conn = $this->conectar("userdef", "1234");
        $query = "SELECT Contrasena, Usuario, Nombres, Apellidos, Fisio FROM Medico WHERE Usuario = '".$usuario."'";
        $result = oci_parse($conn, $query);
        oci_execute($result);

        return $result;
    }

/*  Funcion que devuelve si un paciente existe en la 
    base de datos.
*/
    function validarPacienteBD($ci) {
        $conn = $this->conectar("userdef", "1234");
        $query = "SELECT ci FROM Paciente WHERE ci = ".$ci;
        $result = oci_parse($conn, $query);
        oci_execute($result);

        if (($row = oci_fetch_array($result, OCI_BOTH))) {
            return true;
            }
        return false;
    }

/*  Funcion que agrega un usuario nuevo en la base
    de datos.
*/
    function agregarUsuarioBD($objeto) {

        $user = strtoupper(htmlentities($objeto->getUsuario(), ENT_QUOTES));
        
        $pass = $objeto->getContrasena();

        $conexion = $this->conectar("userdef","1234");

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

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);

        $result = oci_parse($conexion, "INSERT INTO PACIENTE VALUES (".$objeto->getCI().", '".$objeto->getNombres()."', '".$objeto->getApellidos()."', '".$objeto->getProfesion()."', '".$objeto->getLugarRes()."', to_date('".$objeto->getFechaNac()."', 'YYYY-MM-DD'), ID_historiales.nextval, '".$objeto->getDiagnostico()."', '".$objeto->getInterQuir()."')");
        oci_execute($result);

        $this->desconectar($conexion);
        return $result;
    }

/*  Funcion que agrega una preferencia de algun tono flexor
    dorsal en la base de datos.
*/
    function agregarTonoFlexDorBD($objeto) {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);

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

/*  Funcion que agrega una preferencia de caracteristica de marcha segun el 
    usuario en la base de datos.
*/
    function agregarCaracMarchaBD($objeto) {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);

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

/*  Funcion que agrega una preferencia de peso segun el usuario en 
    la base de datos.
*/
    function agregarPesoBD($objeto) {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);

        $result = oci_parse($conexion, "INSERT INTO UDLinLab_tab VALUES ('".$objeto->getLabel()."' , '".$user."', 'Peso', Trapezoid_objtyp(".$objeto->getN1().", ".$objeto->getN2().", ".$objeto->getN3().", ".$objeto->getN4()."))");

        oci_execute($result);

        $this->desconectar($conexion);
        return $result;
    }

/*  Funcion que consulta una preferencia de peso segun el usuario
    en la base de datos.
*/
    function consultarPesoBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT U.Label, U.Trapezoid.T_a, U.Trapezoid.T_b, U.Trapezoid.T_c, U.Trapezoid.T_d FROM UDLinLab_tab U WHERE dom_name = 'Peso' AND user_name = '".$user."'";
                
        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

/*  Funcion que consulta las preferencias del usuario en tono flexor dorsal.
*/
    function consultarTNBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT etiqueta, dominio, grado FROM semejanza_fijo_etiqueta WHERE usuario = '".$user."'";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);
        return $res;
    }
	
/*  Funcion que consulta las etiquetas del usuario en tono flexor dorsal 
    izquierdo.
*/
	function consultarTNBD_etiqueta_I() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT  DISTINCT etiqueta FROM semejanza_fijo_etiqueta WHERE usuario = '".$user."' AND DOM_NAME = 'Tono_Flexores_Dorsales_Izq'";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);
        return $res;
    }
	
/*  Funcion que consulta las etiquetas del usuario en tono flexor dorsal 
    derecho.
*/
	function consultarTNBD_dominio_I() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT dominio FROM semejanza_fijo_etiqueta WHERE usuario = '".$user."' AND DOM_NAME = 'Tono_Flexores_Dorsales_Izq'";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);
        return $res;
    }
	
/*  Funcion que consulta el grado de semejanza en cuanto a las preferencias del
    usuario en el tono flexor dorsal izquierdo.
*/
	function consultarTNBD_grado_I($dom,$et) {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT grado FROM semejanza_fijo_etiqueta WHERE dominio=".$dom." AND etiqueta='".$et."' AND usuario = '".$user."' AND DOM_NAME = 'Tono_Flexores_Dorsales_Izq'";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);
        return $res;
    }
	
/*  Funcion que consulta las etiquetas del usuario en tono flexor dorsal 
    derecho.
*/
	function consultarTNBD_etiqueta_D() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT  DISTINCT etiqueta FROM semejanza_fijo_etiqueta WHERE usuario = '".$user."' AND DOM_NAME = 'Tono_Flexores_Dorsales_Der'";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);
        return $res;
    }
	
/*  Funcion que consulta los dominios del usuario en tono flexor dorsal 
    derecho.
*/
	function consultarTNBD_dominio_D() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT dominio FROM semejanza_fijo_etiqueta WHERE usuario = '".$user."' AND DOM_NAME = 'Tono_Flexores_Dorsales_Der'";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);
        return $res;
    }
	
/*  Funcion que consulta el grado de semejanza en cuanto a las preferencias del
    usuario en el tono flexor dorsal derecho.
*/
	function consultarTNBD_grado_D($dom,$et) {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT grado FROM semejanza_fijo_etiqueta WHERE dominio=".$dom." AND etiqueta='".$et."' AND usuario = '".$user."' AND DOM_NAME = 'Tono_Flexores_Dorsales_Der'";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);
        return $res;
    }

/*  Funcion que consulta el grado de semejanza en cuanto a las preferencias del
    usuario en las caracteristicas de marcha.
*/
    function consultarCMBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT etiqueta_1, etiqueta_2, grado FROM semejanza_etiquetas WHERE dom_name = 'Carac_Marcha' AND usuario = '".$user."' order by etiqueta_1 ";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }
	
/*  Funcion que consulta las etiquetas de las caracteristicas de marcha.
*/
	function consultarCM_etiquetas() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT etiqueta_1 FROM semejanza_etiquetas WHERE dom_name = 'Carac_Marcha' AND usuario = '".$user."' order by etiqueta_1 ";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }
	
/*  Funcion que consulta el grado de semejanza en cuanto a las preferencias del
    usuario en la caracteristicas de marcha.
*/
	function consultarCM_grado($et1,$et2) {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT grado FROM semejanza_etiquetas WHERE dom_name = 'Carac_Marcha' AND ((etiqueta_1 = '".$et1."'  AND etiqueta_2 = '".$et2."') OR (etiqueta_1 = '".$et2."'  AND etiqueta_2 = '".$et1."')) AND usuario = '".$user."' order by etiqueta_1 ";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

/*  Funcion que consulta el numero de historial de un paciente en base a su cedula.
*/
    function consultarHistorialBD($ci) {
        $query = "SELECT id_historial FROM Paciente WHERE ci = ".$ci;
                
        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
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

/*  Funcion que consulta el historial de un paciente en base a su cedula.
*/
    function consultarPacienteBD($ci) {
        $query = "SELECT * FROM Paciente WHERE ci = ".$ci;
                
        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);

        return $results;
    }

/*  Funcion que consulta las etiquetas de peso utilizadas por el usuario.
*/
    function consultarEtiquetaPesoBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT Label FROM UDLinLab_tab WHERE dom_name = 'Peso' AND user_name = '".$user."'";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

/*  Funcion que consulta todas las etiquetas posibles de peso.
*/
    function consultarEtiquetaPosiblePesoBD() {
        $query = "SELECT DISTINCT Label FROM UDLinLab_tab WHERE dom_name = 'Peso'";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

/*  Funcion que consulta las etiquetas de tono flexor dorsal utilizadas 
    por el usuario.
*/
    function consultarEtiquetaTonoFlexDorIzqBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT etiqueta FROM semejanza_fijo_etiqueta WHERE dom_name = 'Tono_Flexores_Dorsales_Izq' AND usuario = '".$user."'";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

/*  Funcion que consulta todas las etiquetas posibles de 
    tono flexor dorsal
*/
    function consultarEtiquetaPosibleTonoFlexDorBD() {
        $query = "SELECT etiq FROM etiqueta_tono_muscular";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

/*  Funcion que consulta los dominios utilizados por el usuario.
*/
    function consultarDominioFijoTonoFlexDorIzqBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT dominio FROM semejanza_fijo_etiqueta WHERE dom_name = 'Tono_Flexores_Dorsales_Izq' AND usuario = '".$user."'";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

/*  Funcion que consulta todos los dominios posibles a utilizar.
*/
    function consultarDominioFijoPosibleTonoFlexDorBD() {
        $query = "SELECT valor FROM D_tono_muscular";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

/*  Funcion que consulta las etiquetas de tono flexor dorsal derecho
     utilizadas por el usuario.
*/
    function consultarEtiquetaTonoFlexDorDerBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT etiqueta FROM semejanza_fijo_etiqueta WHERE dom_name = 'Tono_Flexores_Dorsales_Der' AND usuario = '".$user."'";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

/*  Funcion que consulta los dominios de tono flexor dorsal derecho
     utilizadas por el usuario.
*/
    function consultarDominioFijoTonoFlexDorDerBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT dominio FROM semejanza_fijo_etiqueta WHERE dom_name = 'Tono_Flexores_Dorsales_Izq' AND usuario = '".$user."'";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

/*  Funcion que consulta las etiquetas de caracteristicas de marcha
     utilizadas por el usuario.
*/
    function consultarEtiquetaCaracMarchaBD() {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $query = "SELECT DISTINCT etiqueta_1 FROM semejanza_etiquetas WHERE dom_name = 'Carac_Marcha' AND usuario = '".$user."'";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

/*  Funcion que consulta todas las etiquetas posibles de caracteristicas
    de marcha.
*/
    function consultarEtiquetaPosibleCaracMarchaBD() {
        $query = "SELECT etiq FROM etiqueta_carac_marcha";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

/*  Funcion que consulta los dispositivos utilizados por el paciente.
*/
    function consultarDispositivosBD($ci) {
        $query = "SELECT dispositivo, grado FROM dispositivos_usados WHERE paciente = ".$ci;

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

/*  Funcion que agrega los dispositivos utilizados por el paciente.
*/
    function agregarDispositivosBD($ci, $dispositivo, $grado) {

        $hist = $this->consultarHistorialBD($ci);
        $query = "INSERT INTO dispositivos_usados VALUES (".$ci.", ".$hist.", '".$dispositivo."', ".$grado.")";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
    }

/*  Funcion que consulta los dispositivos posibles a utilizar por el paciente.
*/
    function consultarDispositivosPosiblesBD() {
        $query = "SELECT DISTINCT etiq FROM dispositivo";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $results = oci_parse($conexion, $query);
        oci_execute($results);
        $this->desconectar($conexion);
        return $results;
    }

/*  Funcion que agrega un examen fisico articular a la base de datos.
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
        
        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);

        $result = oci_parse($conexion, $valores);
        oci_execute($result);

        $this->desconectar($conexion);
    }

/*  Funcion que hace el segundo tipo de consulta del sistema.
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

/*  Funcion que hace el segundo tipo de consulta del sistema.
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


        $query = "SELECT ".$atributos." FROM EFA_tab E, Paciente P WHERE ".$condiciones;

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);

        return $res;
    }

/*  Funcion que compara los pacientes segun los dispostivos que utiliza.
*/
    function compararDispositivosIgualesBD($ci) {

        $query = "SELECT P.Nombres, P.Apellidos, P.ci, P.Id_Historial, P.FEQ(".$ci."), P.prom_parecido3(".$ci.") FROM Paciente P WHERE P.FEQ(".$ci.") > 0 AND P.prom_parecido3(".$ci.") > 0";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);

        return $res;
    }

/*  Funcion que compara los pacientes segun los dispostivos que utiliza.
*/
    function compararDispositivosIgualesBD2($ci) {

        $query = "SELECT P.Nombres, P.Apellidos, P.ci, P.FEQ(".$ci."), P.prom_parecido3(".$ci.") FROM Paciente P WHERE P.FEQ(".$ci.") > 0 AND P.prom_parecido3(".$ci.") > 0";

        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $this->desconectar($conexion);

        return $res;
    }

/*  Funcion que agrega una etiqueta nueva a la base de datos.
*/
    function agregarCaracMarchaEtiquetasBD($etiqueta) {
        $user = strtoupper(htmlentities($_SESSION['user'], ENT_QUOTES));
        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        
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

/*  Funcion que elimina un paciente de la base de datos.
*/
    function eliminarPacienteBD($id){
    
        $query2 = "delete from paciente where CI='".$id."'";
        $query1 = "delete from efa_tab where ID_PERSONA='".$id."'";
        $query = "delete from dispositivos_usados where PACIENTE='".$id."'";
        $conexion = $this->conectar($_SESSION['user'], $_SESSION['pass']);
        $res = oci_parse($conexion, $query);
        oci_execute($res);
        $res1= oci_parse($conexion, $query1);
        oci_execute($res1);
        $res2= oci_parse($conexion, $query2);
        oci_execute($res2);
        $this->desconectar($conexion);

        return $res;
    
    }



}

?>
