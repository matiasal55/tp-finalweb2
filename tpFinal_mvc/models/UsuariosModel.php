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
        $sql="INSERT INTO Usuarios VALUES ('$dni','$nombre','$apellido','$fecha_nacimiento','$email','$encriptada',DEFAULT,'$cod_area','$licencia',DEFAULT)";
        return $this->database->execute($sql);
    }

    public function getLogin($email,$password){
        $encriptada=md5($password);
        $sql="SELECT * FROM Usuarios WHERE email='$email' AND password='$encriptada'";
        return $this->database->query($sql);
    }

    public function getEmpleados(){
        $sql="SELECT * FROM `Usuarios` INNER JOIN `Area` ON `Usuarios`.`cod_area`=`Area`.`codigo`";
        return $this->database->query($sql);
    }

    public function deleteUser($dni){
        $sql="DELETE FROM Usuarios WHERE dni='$dni'";
        return $this->database->execute($sql);
    }

    public function getRoles(){
        $sql="SELECT * FROM Area";
        return $this->database->query($sql);
    }

    public function getDatos($dni){
        $sql="SELECT * FROM Usuarios WHERE dni='$dni'";
        return $this->database->query($sql);
    }

    public function editDatos($datos){
        $dni=$datos["dni"];
        $nombre=$datos["nombre"];
        $apellido=$datos["apellido"];
        $fecha_nacimiento=$datos["fecha_nacimiento"];
        $email=$datos["email"];
        $cod_area=$datos['cod_area'];
        $licencia=$datos['licencia'] ?? null;
        $sql="UPDATE Usuarios SET nombre='$nombre',apellido='$apellido',`fecha de nacimiento`='$fecha_nacimiento',email='$email',cod_area='$cod_area',tipo_licencia='$licencia' WHERE dni='$dni'";
        return $this->database->execute($sql);
    }

    public function editRol($dni,$rol){
        $sql="UPDATE Usuarios SET rol='$rol' WHERE dni='$dni'";
        return $this->database->execute($sql);
    }
}