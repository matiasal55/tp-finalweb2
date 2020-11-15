<?php


class MantenimientoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    public function getMantenimientos(){
        $sql="SELECT * FROM Mantenimiento";
        return $this->database->query($sql);
    }

    public function getMantenimiento($codigo){
        $sql="SELECT * FROM Mantenimiento WHERE codigo='$codigo'";
        return $this->database->query($sql);
    }

    public function getMantenimientosPorTaller($codigo){
        $sql="SELECT codigo,patente_vehiculo,`fecha inicio`,`fecha final`,kilometraje,costo,dni_mecanico FROM Mantenimiento WHERE cod_taller='$codigo'";
        return $this->database->query($sql);
    }

    public function getMantenimientoVehiculo($patente){
        $sql="SELECT * FROM Mantenimiento WHERE patente_vehiculo='$patente'";
        return $this->database->query($sql);
    }

    public function registrarMantenimientoRepuesto($mantenimiento,$repuesto,$cantidad){
        $sql="INSERT INTO Mantenimiento_Repuesto VALUES ('$mantenimiento','$repuesto','$cantidad')";
        return $this->database->execute($sql);
    }

    public function editMantenimientoRepuesto($mantenimiento,$repuesto,$cantidad){
        $sql="UPDATE Mantenimiento_Repuesto SET cantidad='$cantidad' WHERE cod_mantenimiento='$mantenimiento' AND cod_repuesto='$repuesto'";
        return $this->database->execute($sql);
    }

    public function editMantenimiento($datos){
//        $codigo=$datos['codigo'];
//        $sql="UPDATE Mantenimiento SET CUIT='$cuit', nombre='$nombre', direccion='$direccion', telefono='$telefono' WHERE cuit='$cuit'";
//        return $this->database->execute($sql);
    }

    public function deleteMantenimiento($codigo){
        $sql="DELETE FROM Mantenimiento WHERE codigo='$codigo'";
        return true;
    }

    public function deleteMantenimientoRepuesto($mantenimiento,$repuesto){
        $sql="DELETE FROM Mantenimiento WHERE cod_mantenimiento='$codigo' AND cod_repuesto='$repuesto'";
        return true;
    }
}