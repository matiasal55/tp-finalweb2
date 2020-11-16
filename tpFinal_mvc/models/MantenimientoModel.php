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
        $cod_taller=$datos['cod_taller'];
        $mecanico=$datos['dni_mecanico'];
        $proximo=$datos['fecha_proximo'];
        $sql="INSERT INTO Service VALUES (DEFAULT,'$patente','$proximo');";
        if($this->database->execute($sql)){
            $sql="SELECT LAST_INSERT_ID()";
            $resultado=$this->database->query($sql);
            $id_service=intval($resultado[0]['LAST_INSERT_ID()']);
            $sql="INSERT INTO Mantenimiento VALUES (DEFAULT,'$patente','$inicio','$final','$kilometraje','$costo','$cod_taller','$mecanico','$id_service')";
            return $this->database->execute($sql);
        }
        return false;
    }


    public function getMantenimientos(){
        $sql="SELECT `Mantenimiento`.`codigo`,`Mantenimiento`.`patente_vehiculo`,`Mantenimiento`.`fecha inicio`,`Mantenimiento`.`fecha final`,`Mantenimiento`.`kilometraje`,`Mantenimiento`.`costo`,`Mantenimiento`.`cod_taller`,`Mantenimiento`.`dni_mecanico`,`Service`.`fecha` FROM Mantenimiento, Service WHERE `Mantenimiento`.`id_proximo`=`Service`.`id`";
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
        $proximo=$datos['fecha_proximo'];
        $service=$datos['service'];
        $sql="UPDATE Mantenimiento SET patente_vehiculo='$patente',`fecha inicio`='$inicio',`fecha final`='$final',kilometraje='$kilometraje',costo='$costo',cod_taller='$taller',dni_mecanico='$mecanico' WHERE codigo='$codigo';";
        if($this->database->execute($sql)){
            $sql="UPDATE Service SET fecha='$proximo' WHERE id='$service'";
            return $this->database->execute($sql);
        }
        return false;
    }

    public function deleteMantenimiento($codigo){
        $sql="DELETE FROM Mantenimiento WHERE codigo='$codigo'";
        return true;
    }

    public function deleteMantenimientoRepuesto($mantenimiento,$repuesto){
        $sql="DELETE FROM Mantenimiento WHERE cod_mantenimiento='$codigo' AND cod_repuesto='$repuesto'";
        return true;
    }

    public function registrarService($patente,$fecha){
        $sql="INSERT INTO Service VALUES (DEFAULT ,'$patente','$fecha')";
        return $this->database->execute($sql);
    }

    public function editService($patente,$fecha){
        $sql="UPDATE Service SET patente_vehiculo='$patente',fecha='$fecha' WHERE ";
        return $this->database->execute($sql);
    }
}