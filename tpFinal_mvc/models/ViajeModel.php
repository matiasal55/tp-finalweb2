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

    public function registrar($datos){
        $codigo=$datos['codigo'];
        $fecha=$datos['fecha'];
        $direccion_origen=$datos['direccion_origen'];
        $localidad_origen=$datos['localidad_origen'];
        $provincia_origen=$datos['provincia_origen'];
        $pais_origen = $datos['pais_origen'];
        $direccion_destino = $datos['direccion_destino'];
        $localidad_destino = $datos['localidad_destino'];
        $provincia_destino = $datos['provincia_destino'];
        $pais_destino= $datos['pais_destino'];
        $estado= $datos['estado'];
        $peso= $datos['peso'];
        $ETA= $datos['ETA'];
        $km_estimados= $datos['km_estimados'];
        $desviaciones= $datos['desviaciones'];
        $combustible_previsto= $datos['combustible_previsto'];
        $combustible_total= $datos['combustible_total'];
        $patente_vehiculo= $datos['patente_vehiculo'];
        $patente_arrastre= $datos['patente_arrastre'];
        $dni_chofer= $datos['dni_chofer'];

        $sql="INSERT INTO Viaje VALUES ('$codigo','$fecha','$direccion_origen','$localidad_origen','$provincia_origen','$pais_origen','$direccion_destino','$localidad_destino','$provincia_destino','$pais_destino','$estado','$peso','$ETA','$km_estimados','$desviaciones','$combustible_previsto','$combustible_total','$patente_vehiculo','$patente_arrastre','$dni_chofer')";
        return $this->database->execute($sql);
    }

    public function editViaje($datos){
        $codigo=$datos['codigo'];
        $fecha=$datos['fecha'];
        $direccion_origen=$datos['direccion_origen'];
        $localidad_origen=$datos['localidad_origen'];
        $provincia_origen=$datos['provincia_origen'];
        $pais_origen = $datos['pais_origen'];
        $direccion_destino = $datos['direccion_destino'];
        $localidad_destino = $datos['localidad_destino'];
        $provincia_destino = $datos['provincia_destino'];
        $pais_destino= $datos['pais_destino'];
        $estado= $datos['estado'];
        $peso= $datos['peso'];
        $ETA= $datos['ETA'];
        $km_estimados= $datos['km_estimados'];
        $desviaciones= $datos['desviaciones'];
        $combustible_previsto= $datos['combustible_previsto'];
        $combustible_total= $datos['combustible_total'];
        $patente_vehiculo= $datos['patente_vehiculo'];
        $patente_arrastre= $datos['patente_arrastre'];
        $dni_chofer= $datos['dni_chofer'];
        $sql="UPDATE Viaje SET codigo='$codigo',fecha='$fecha',direccion_origen='$direccion_origen',localidad_origen='$localidad_origen',provincia_origen='$provincia_origen',pais_origen='$pais_origen',provincia_origen='$provincia_origen',direccion_destino='$direccion_destino',localidad_destino='$localidad_destino',provincia_destino='$provincia_destino',pais_destino='$pais_destino',estado='$estado',peso='$peso',provincia_origen='$provincia_origen',provincia_origen='$provincia_origen',ETA='$ETA',km_estimados='$km_estimados',desviaciones='$desviaciones',combustible_previsto='$combustible_previsto',combustible_total='$combustible_total',patente_vehiculo='$patente_vehiculo',patente_arrastre='$patente_arrastre',dni_chofer='$dni_chofer' WHERE codigo='$codigo'";
        return $this->database->execute($sql);
    }

    public function deleteViaje($codigo){
        $sql="DELETE FROM Viaje WHERE codigo='$codigo'";
        return $this->database->execute($sql);
    }
}