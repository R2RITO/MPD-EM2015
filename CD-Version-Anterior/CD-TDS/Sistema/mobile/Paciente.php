<?php

include_once ("FachadaBD.php");

/**
 *   Clase para representar el tipo de dato Paciente en la base de datos. 
 *   
 *   Contiene get y set para sus atributos y la funcion agregarPaciente que
 *   agrega un nuevo paciente en la base de datos.
 */

class Paciente {
    
    private $ci;
    private $nombres;
    private $apellidos;
    private $profesion;
    private $lugar_residencia;
    private $fecha_nacimiento;
    private $id_historial;
    private $diagnostico;
    private $intervenciones_quir;
    
    function Paciente() {
        $this->ci = null;
        $this->nombres = null;
        $this->apellidos = null;
        $this->profesion = null;
        $this->lugar_residencia = null;
        $this->fecha_nacimiento = null;
        $this->id_historial = null;
        $this->diagnostico = null;
        $this->intervenciones_quir = null;
    }

    public function setCI($ci){
        $this->ci = $ci;
    }

    public function getCI(){
        return $this->ci;
    }
    
    public function setNombres($nombres){
        $this->nombres = $nombres;
    }

    public function getNombres(){
        return $this->nombres;
    } 
    
    public function setApellidos($apellidos){
        $this->apellidos = $apellidos;
    }

    public function getApellidos(){
        return $this->apellidos;
    }     

    public function setProfesion($profesion){
        $this->profesion = $profesion;
    }

    public function getProfesion(){
        return $this->profesion;
    }

    public function setLugarRes($lugar_residencia){
        $this->lugar_residencia = $lugar_residencia;
    }

    public function getLugarRes(){
        return $this->lugar_residencia;
    }

    public function setFechaNac($fecha_nacimiento){
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function getFechaNac(){
        return $this->fecha_nacimiento;
    }

    public function setID_Historial($id_historial){
        $this->id_historial = $id_historial;
    }

    public function getID_Historial(){
        return $this->id_historial;
    }

    public function setDiagnostico($diagnostico){
        $this->diagnostico = $diagnostico;
    }

    public function getDiagnostico(){
        return $this->diagnostico;
    }

    public function setInterQuir($intervenciones_quir){
        $this->intervenciones_quir = $intervenciones_quir;
    }

    public function getInterQuir(){
        return $this->intervenciones_quir;
    }

    function agregarPacienteBD() {
        // Llama a la fachada de BD.
        $fbd = FachadaBD::getInstance();
        return $fbd->agregarPacienteBD($this);
    }



}

?>