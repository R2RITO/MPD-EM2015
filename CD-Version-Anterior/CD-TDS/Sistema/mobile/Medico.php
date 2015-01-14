<?php
/**
 * Clase para representar un examen fisico articular en la base de datos. 
 * Contiene get y set para sus atributos y la funcion agregarEFA que
 * agrega un examen fisico articular en la base de datos.
 * @property  $ci: cedula de la persona.
 * @property  $nombre: nombre de la persona.
 * @property  $apellido: apellido de la persona.
 * @property  $usuario: usuario .
 * @property  $contrasena: contraseña del usuario.
 * @property  $fisio: fisioterapeuta.
 * @method  Medico(): inicializa las variables de la clase.
 * @method  setCI(): asigna la cedula.
 * @method  getCI(): retorna la cedula.
 * @method  setNombre($nombre): asigna el nombre.
 * @method  getNombre(): retorna el nombre.
 * @method  setApellido($apellido): asigna el apellido.
 * @method  getApellido(): retorna el apellido.
 * @method setUsuario($usuario): asina el nombre de usuario.
 * @method getUsuario(): retorna el nombre de usuario.
 * @method setContrasena($contrasena): asigna la contraseña.
 * @method getContrasena(): retorna la contraseña.
 * @method setFisio($fisio): asigna si es fisioterapeuta.
 * @method isFisio(): retorna si es fisioterapeuta. 
 * @method agregarUsuario() : guarda al nuevo usuario.
 * @author: Daniela & Ruben
 * @version: 1.0
 * @ignore: Favor documentar de esta manera.
 */ 
include_once ("FachadaBD.php");

class Medico {
    
	/** @property $ci: cedula de la persona.*/
    private $ci;
	/** @property $nombre: nombre de la persona.*/
    private $nombre;
	/** @property $apellido: apellido de la persona.*/
    private $apellido;
	/** @property $usuario: nombre de usuario.*/
    private $usuario;
	/** @property $contrasena: contrasña del usuario.*/
    private $contrasena;
	/** @property $fisio: es o no fisioterapeuta.*/
    private $fisio;
    
    /**
     * Metodo que inicializa las propiedades de la clase Medico.
     * @author: Veronica, Andreina, Daniela & Ruben.
     */  
    function Medico() {
        $this->cedula = null;
        $this->nombre = null;
        $this->apellido = null;
        $this->usuario = null;
        $this->contrasena = null;
        $this->fisio = null;
    }
    /**
     * Metodo que asigna el valor de la cedula de la persona.
     * @param $ci: cedula de la persona. 
     * @author: Daniela & Ruben.
     */   
    public function setCI($ci){
        $this->cedula = $ci;
    }
    /**
     * Metodo que retorna el valor de la cedula de la persona.
	 * @return $this->cedula: cedula de la persona. 
     * @author: Daniela & Ruben.
     */   	
    public function getCI(){
        return $this->cedula;
    }
      /**
     * Metodo que asigna el valor del nombre de la persona.
	 * @param $nombre: nombre de la persona. 
     * @author: Daniela & Ruben.
     */   
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    /**
     * Metodo que retorna el valor del nombre de la persona.
	 * @return $this->nombre: nombre de la persona. 
     * @author: Daniela & Ruben.
     */  
    public function getNombre(){
        return $this->nombre;
    } 
    /**
     * Metodo que asigna el valor del apellido de la persona.
	 * @param $apellido: apellido de la persona. 
     * @author: Daniela & Ruben.
     */     
    public function setApellido($apellido){
        $this->apellido = $apellido;
    }
    /**
     * Metodo que retorna el valor del apellido de la persona.
	 * @return $this->apellido: apellido de la persona. 
     * @author: Daniela & Ruben.
     */  
    public function getApellido(){
        return $this->apellido;
    }     
    /**
     * Metodo que asigna el valor del nombre de usuario.
	 * @param $usuario: nombre de usuario. 
     * @author: Daniela & Ruben.
     */           
    public function setUsuario($usuario){
        $this->usuario = $usuario;
    }
    /**
     * Metodo que retorna el valor deñ usuario
	 * @return $this->usuario: usuario
     * @author: Daniela & Ruben.
     */  
    public function getUsuario(){
        return $this->usuario;
    }
    /**
     * Metodo que asigna el valor la contraseña.
	 * @param $contrasena: contraseña. 
     * @author: Daniela & Ruben.
     */  
    public function setContrasena($contrasena){
        $this->contrasena = $contrasena;
    }
    /**
     * Metodo que retorna el valor de la contraseña
	 * @return $this->contrasena: contrasena
     * @author: Daniela & Ruben.
     */  
    public function getContrasena(){
        return $this->contrasena;
    }
    /**
     * Metodo que asigna el valor si es Fisioterapeuta
	 * @param $fisio: es o no fisioterapeuta. 
     * @author: Daniela & Ruben.
     */  
    public function setFisio($fisio){
        $this->fisio = $fisio;
    }
    /**
     * Metodo que retorna si es o no fisioterapeuta
	 * @return $this->fisio: fisioterapeuta
     * @author: Daniela & Ruben.
     */  
    public function isFisio(){
        return $this->fisio;
    }
    /**
     * Metodo guarda al usuario en la Base de Datos
	 * @return $fisio: success si el ususario se agrego con exito
     * @author: Daniela & Ruben.
     */  
    function agregarUsuario() {
        // Llama a la fachada de BD.
        $fbd = FachadaBD::getInstance();
        return $fbd->agregarUsuarioBD($this);
    }

}

?>
