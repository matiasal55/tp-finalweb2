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
        $repuestos_cambiados=$datos['repuestos_cambiados'];
        $sql="INSERT INTO Service VALUES (DEFAULT,'$patente','$proximo');";
        if($this->database->execute($sql)){
            $sql="SELECT LAST_INSERT_ID()";
            $resultado=$this->database->query($sql);
            $id_service=intval($resultado[0]['LAST_INSERT_ID()']);
            $sql="INSERT INTO Mantenimiento VALUES (DEFAULT,'$patente','$inicio','$final','$kilometraje','$costo','$cod_taller','$mecanico','$id_service','$repuestos_cambiados')";
            return $this->database->execute($sql);
//            return $sql;
        }
        return false;
    }


    public function getMantenimientos(){
        $sql="SELECT `Mantenimiento`.`codigo`,`Mantenimiento`.`patente_vehiculo`,`Mantenimiento`.`fecha inicio`,`Mantenimiento`.`fecha final`,`Mantenimiento`.`kilometraje`,`Mantenimiento`.`costo`,`Mantenimiento`.`cod_taller`,`Mantenimiento`.`dni_mecanico`,`Service`.`fecha`, `Mantenimiento`.`repuestos_cambiados` FROM Mantenimiento, Service WHERE `Mantenimiento`.`id_proximo`=`Service`.`id` ORDER BY `fecha inicio` DESC";
        return $this->database->query($sql);
    }

    public function getMantenimiento($codigo){
        $sql="SELECT * FROM Mantenimiento WHERE codigo='$codigo' ORDER BY `fecha inicio` DESC";
        return $this->database->query($sql);
    }

    public function getMantenimientoVehiculo($patente){
        $sql="SELECT * FROM Mantenimiento WHERE patente_vehiculo='$patente' ORDER BY `fecha inicio` DESC";
        return $this->database->query($sql);
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
        $repuestos_cambiados=$datos['repuestos_cambiados'];
        $sql="UPDATE Mantenimiento SET patente_vehiculo='$patente',`fecha inicio`='$inicio',`fecha final`='$final',kilometraje='$kilometraje',costo='$costo',cod_taller='$taller',dni_mecanico='$mecanico',repuestos_cambiados='$repuestos_cambiados' WHERE codigo='$codigo';";

        if($this->database->execute($sql)){
            if($proximo!="") {
                $sql = "UPDATE Service SET fecha='$proximo' WHERE id='$service'";
                return $this->database->execute($sql);
            }
            return true;
        }
        return false;
    }

    public function deleteMantenimiento($codigo){
        $sql="DELETE FROM Mantenimiento WHERE codigo='$codigo'";
        return $this->database->execute($sql);
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