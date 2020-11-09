<?php

class UsuariosModel{
    private $database;

    public function __construct($database)
    {
        $this->database=$database;
    }

    public function setRegistro($datos){
        $encriptada=md5($datos->password);
        $sql="INSERT INTO Usuarios VALUES ($datos->dni,$datos->nombre,$datos->apellido,$datos->fecha_nacimiento,$datos->email,$encriptada)";
        return $this->database->query($sql);
    }
//cambiarrrrr
    public function getLogin($email.$password){

        $encriptada=md5($datos->password);
        $sql="SELECT * FROM Usuarios WHERE email='$datos->email' AND password='$encriptada'";
        return $this->database->query($sql);
    }
}