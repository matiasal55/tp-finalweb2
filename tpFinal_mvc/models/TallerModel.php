<?php


class TallerModel
{
    private $database;

    public function __construct($database)
    {
        $this->database=$database;
    }

    public function registrar($datos){
        $cuit=$datos['cuit'];
        $nombre=$datos['nombre'];
        $direccion=$datos['direccion'];
        $telefono=$datos['telefono'];
        $sql="INSERT INTO Taller VALUES('$cuit','$nombre','$direccion','$telefono')";
        return $this->database->execute($sql);
    }

    public function getTalleres(){
        $sql="SELECT * FROM Taller";
        return $this->database->query($sql);
    }

    public function getTaller($cuit){
        $sql="SELECT * FROM Taller WHERE CUIT='$cuit'";
        return $this->database->query($sql);
    }

    public function editTaller($datos){
        $cuit=$datos['CUIT'];
        $nombre=$datos['nombre'];
        $direccion=$datos['direccion'];
        $telefono=$datos['telefono'];
        $sql="UPDATE Taller SET CUIT='$cuit', nombre='$nombre', direccion='$direccion', telefono='$telefono' WHERE CUIT='$cuit'";
        return $this->database->execute($sql);
    }

    public function deleteTaller($cuit){
        $sql="DELETE FROM Taller WHERE CUIT='$cuit'";
        return true;
    }
}