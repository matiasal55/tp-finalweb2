<?php


class ViajeModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getViajes(){
        $sql="SELECT * FROM Viaje";
        return $this->database->query($sql);
    }

    public function getViaje($codigo){
        $sql="SELECT * FROM Viaje WHERE codigo='$codigo'";
        return $this->database->query($sql);
    }

    public function editViaje($datos){
        $cuit=$datos['CUIT'];
        $nombre=$datos['nombre'];
        $direccion=$datos['direccion'];
        $telefono=$datos['telefono'];
//        $sql="UPDATE Taller SET CUIT='$cuit', nombre='$nombre', direccion='$direccion', telefono='$telefono' WHERE cuit='$cuit'";
        return $this->database->execute($sql);
    }

    public function deleteViaje($codigo){
        $sql="DELETE FROM Viaje WHERE codigo='$codigo'";
        return true;
    }
}