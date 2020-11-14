<?php


class MantenimientoModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function registrar($datos){
        $patente=$datos['patente'];
        $inicio=$datos['fecha_inicio'];
        $final=$datos['fecha_final'];
        $kilometraje=$datos['kilometraje'];
        $costo=$datos['costo'];
        $taller=$datos['cod_taller'];
        $mecanico=$datos['dni_mecanico'];
        $sql="INSERT INTO Mantenimiento VALUES (DEFAULT,'$patente','$inicio','$final','$kilometraje','$costo','$cod_taller','$mecanico')";
        return $this->database->execute($sql);
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
        $codigo=$datos['codigo'];
        $patente=$datos['patente'];
        $inicio=$datos['fecha_inicio'];
        $final=$datos['fecha_final'];
        $kilometraje=$datos['kilometraje'];
        $costo=$datos['costo'];
        $taller=$datos['cod_taller'];
        $mecanico=$datos['dni_mecanico'];
//        var_dump($datos);
        $sql="UPDATE Mantenimiento SET patente_vehiculo='$patente',`fecha inicio`='$inicio',`fecha final`='$final',kilometraje='$kilometraje',costo='$costo',cod_taller='$taller',dni_mecanico='$mecanico' WHERE codigo='$codigo'";
        return $this->database->execute($sql);
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