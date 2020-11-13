<?php

class UsuariosModel{
    private $database;

    public function __construct($database)
    {
        $this->database=$database;
    }

    public function setRegistro($datos){
        $encriptada=md5($datos['password']);
        $dni=$datos["dni"];
        $nombre=$datos["nombre"];
        $apellido=$datos["apellido"];
        $fecha_nacimiento=$datos["fecha_nacimiento"];
        $email=$datos["email"];
        $cod_area =$datos['area'];
        $licencia=$datos['licencia'] ?? null;
        $sql="INSERT INTO Usuarios VALUES ('$dni','$nombre','$apellido','$fecha_nacimiento','$email','$encriptada',DEFAULT,'$cod_area','$licencia')";
        return $this->database->execute($sql);
    }

    public function getLogin($email,$password){
        $encriptada=md5($password);
        $sql="SELECT * FROM Usuarios WHERE email='$email' AND password='$encriptada'";
        return $this->database->query($sql);
    }

    public function getEmpleados(){
        $sql="SELECT * FROM Usuarios";
        return $this->database->query($sql);
    }

    public function deleteUser($dni){
        $sql="DELETE FROM Usuarios WHERE dni='$dni'";
        return $this->database->execute($sql);
    }
}