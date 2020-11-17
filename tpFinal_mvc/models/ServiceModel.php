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

    public function getService($id){
        $sql="SELECT * FROM Service WHERE id='$id'";
        return $this->database->query($sql);
    }
    public function registrar($datos){
        $id=$datos['id'];
        $patente=$datos['patente'];
        $fecha=$datos['fecha'];

        $sql="INSERT INTO Service VALUES ('$id','$patente',' $fecha')";
        return $this->database->execute($sql);
    }
    public function editService($datos){
        $id=$datos['id'];
        $patente=$datos['patente'];
        $fecha=$datos['fecha'];
        $sql="UPDATE Service SET id='$id', patente_vehiculo='$patente',fecha=$fecha WHERE id='$id'";
        return $this->database->execute($sql);
    }

    public function deleteService($id){
        $sql="DELETE FROM Service WHERE id='$id'";
        return $this->database->execute($sql);;
    }

}