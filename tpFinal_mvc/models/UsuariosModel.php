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
        $licencia=$datos['tipo_licencia'];
        $sql="INSERT INTO Usuarios VALUES ('$dni','$nombre','$apellido','$fecha_nacimiento','$email','$encriptada',DEFAULT,'$cod_area')";
        if($cod_area==4){
            if($this->database->execute($sql)){
                $sql="INSERT INTO Chofer VALUES ('$dni','$licencia',DEFAULT,DEFAULT,DEFAULT)";
                return $this->database->execute($sql);
            }
            return false;
        }
        return $this->database->execute($sql);
    }

    public function dniExistente($dni){
        $sql="SELECT dni FROM Usuarios WHERE dni='$dni'";
        return $this->database->query($sql);
    }

    public function emailExistente($email){
        $sql="SELECT email FROM Usuarios WHERE email='$email'";
        return $this->database->query($sql);
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

    public function getDatosChofer($dni){
        $sql="SELECT * FROM Chofer WHERE dni_chofer='$dni'";
        return $this->database->query($sql);
    }

    public function editDatos($datos){
        $dni=$datos["dni"];
        $nombre=$datos["nombre"];
        $apellido=$datos["apellido"];
        $fecha_nacimiento=$datos["fecha_nacimiento"];
        $email=$datos["email"];
        $cod_area=$datos['area'];
        if($_SESSION['rol']==4){
            $licencia=$datos['licencia'];
            $sql="UPDATE Chofer SET tipo_licencia='$licencia' WHERE dni_chofer='$dni'";
            $this->database->execute($sql);
        }
        $sql="UPDATE Usuarios SET nombre='$nombre',apellido='$apellido',`fecha de nacimiento`='$fecha_nacimiento',email='$email',cod_area='$cod_area' WHERE dni='$dni'";
        return $this->database->execute($sql);
    }

    public function editRol($dni,$rol){
        $sql="UPDATE Usuarios SET rol='$rol' WHERE dni='$dni'";
        return $this->database->execute($sql);
    }

    public function bloquearUsuario($dni){
        $sql="UPDATE Usuarios SET rol=0 WHERE dni='$dni'";
        return $this->database->execute($sql);
    }
}