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
        $anio=$datos['anio_fabricacion'];
        $chasis=$datos['chasis'];
        $motor=$datos['motor'];
        $kmtotal=$datos['km_total'];
        $sql="INSERT INTO Vehiculo VALUES ('$patente','$marca','$modelo','$anio','$chasis','$motor',DEFAULT ,'$kmtotal',DEFAULT,DEFAULT)";
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

    public function getVehiculoParaChofer($patente){
        $sql="SELECT `Vehiculo`.`patente`,`Marca`.`nombre`,`Modelo`.`descripcion`,`Vehiculo`.`anio_fabricacion`,`Vehiculo`.`km actual`,`Vehiculo`.`posicion actual`,`Vehiculo`.`estado` FROM Vehiculo, Marca, Modelo WHERE `Vehiculo`.`cod_marca`=`Marca`.`codigo` AND `Vehiculo`.`cod_modelo`=`Modelo`.`cod_modelo` AND `Vehiculo`.`patente`='$patente'";
        return $this->database->query($sql);
    }

    public function editVehiculo($datos){
        $patente=$datos['patente'];
        $marca=$datos['marca'];
        $modelo=$datos['modelo'];
        $anio=$datos['anio_fabricacion'];
        $chasis=$datos['chasis'];
        $motor=$datos['motor'];
        $estado=$datos['estado'];
        $sql="UPDATE Vehiculo SET cod_marca='$marca', cod_modelo='$modelo', anio_fabricacion='$anio', chasis='$chasis', motor='$motor', estado='$estado' WHERE patente='$patente'";
        return $this->database->execute($sql);
    }

    public function deleteVehiculo($patente){
        $sql="DELETE FROM Vehiculo WHERE patente='$patente'";
        return $this->database->execute($sql);
    }
}