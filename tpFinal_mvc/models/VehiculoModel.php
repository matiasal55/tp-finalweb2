<?php


class VehiculoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database=$database;
    }

    public function registrar($datos){
        $patente=$datos['patente'];
        $marca=$datos['marca'];
        $modelo=$datos['modelo'];
        $chasis=$datos['chasis'];
        $motor=$datos['motor'];
        $kmtotal=$datos['km_total'];
        $sql="INSERT INTO Vehiculo VALUES ('$patente','$marca','$modelo','$chasis','$motor',DEFAULT ,'$kmtotal',DEFAULT,DEFAULT)";
        return $this->database->execute($sql);
    }

    public function getVehiculos(){
        $sql="SELECT * FROM Vehiculo";
        return $this->database->query($sql);
    }

    public function getMarcas(){
        $sql="SELECT * FROM Marca";
        return $this->database->query($sql);
    }

    public function getModelos(){
        $sql="SELECT * FROM Modelo";
        return $this->database->query($sql);
    }

    public function getVehiculo($patente){
        $sql="SELECT * FROM Vehiculo WHERE patente='$patente'";
        return $this->database->query($sql);
    }

    public function editVehiculo($datos){
        $patente=$datos['patente'];
        $marca=$datos['marca'];
        $modelo=$datos['modelo'];
        $chasis=$datos['chasis'];
        $motor=$datos['motor'];
        $sql="UPDATE Vehiculo SET cod_marca='$marca', cod_modelo='$modelo', chasis='$chasis', motor='$motor' WHERE patente='$patente'";
        return $this->database->execute($sql);
    }

    public function deleteTaller($patente){
        $sql="DELETE FROM Vehiculo WHERE patente='$patente'";
        return true;
    }
}