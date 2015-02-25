<?php

include_once ("fachadaBD.php");



class Medico {
    
    private $ci;
    private $nombres;
    private $apellidos;
    private $usuario;
    private $contrasena;
    private $fisio;
    
    function Medico() {
        $this->ci = null;
        $this->nombres = null;
        $this->apellidos = null;
        $this->usuario = null;
        $this->contrasena = null;
        $this->fisio = null;
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
        
    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }

    public function getUsuario(){
        return $this->usuario;
    }

    public function setContrasena($contrasena){
        $this->contrasena = $contrasena;
    }

    public function getContrasena(){
        return $this->contrasena;
    }

    public function setFisio($fisio){
        $this->fisio = $fisio;
    }

    public function isFisio(){
        return $this->fisio;
    }

    function agregarUsuario() {
        // Llama a la fachada de BD.
        $fbd = fachadaBD::getInstance();
        return $fbd->agregarUsuarioBD($this);
    }

}

?>