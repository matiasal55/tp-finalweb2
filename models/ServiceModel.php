<?php


class ServiceModel
{
    private $database;

    public function __construct($database)
    {
        $this->database=$database;
    }

    public function getTodoslosService(){
        $sql="SELECT * FROM Service";
        return $this->database->query($sql);
    }

    public function getVehiculos(){
        $sql="SELECT `Vehiculo`.`patente`, `Marca`.`nombre`,`Modelo`.`descripcion` FROM Vehiculo,Marca,Modelo WHERE `Vehiculo`.`cod_marca`=`Marca`.`codigo` and `Vehiculo`.`cod_modelo`=`Modelo`.`cod_modelo`";
        return $this->database->query($sql);
    }

    public function getService($patente){
        $sql="SELECT * FROM Service WHERE patente_vehiculo='$patente'";
        return $this->database->query($sql);
    }

    public function getServiceYVehiculo($id){
        $sql="SELECT * FROM Service, Vehiculo WHERE `Vehiculo`.`patente`=`Service`.`patente_vehiculo` AND id='$id'";
        return $this->database->query($sql);
    }

    public function getServicePorFecha($fecha){
        $sql="SELECT * FROM Service, Vehiculo WHERE `Vehiculo`.`patente`=`Service`.`patente_vehiculo` AND fecha='$fecha'";
        return $this->database->query($sql);
    }

    public function getServicePorFechaYVehiculo($patente,$fecha){
        $sql="SELECT * FROM Service, Vehiculo WHERE `Vehiculo`.`patente`=`Service`.`patente_vehiculo` AND `Service`.`patente_vehiculo`='$patente' AND `Service`.`fecha`='$fecha' ";
        return $this->database->query($sql);
    }

    public function registrar($datos){
        $patente=$datos['patente'];
        $fecha=$datos['fecha'];

        $sql="INSERT INTO Service VALUES (DEFAULT,'$patente',' $fecha')";
        return $this->database->execute($sql);
    }
    public function editService($datos){
        $id=$datos['id'];
        $patente=$datos['patente'];
        $fecha=$datos['fecha'];
        $sql="UPDATE Service SET patente_vehiculo='$patente',fecha='$fecha' WHERE id='$id'";
        return $this->database->execute($sql);
    }

    public function deleteService($id){
        $sql="DELETE FROM Service WHERE id='$id'";
        return $this->database->execute($sql);;
    }

}