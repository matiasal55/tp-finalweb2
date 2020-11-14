<?php


class ProformaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database=$database;
    }

    public function registrar($datos){
        $numero=$datos['numero'];
        $fecha=$datos['fecha'];
        $cliente_cuit=$datos['cliente_cuit'];
        $viaje_origen=$datos['origen'];
        $viaje_destino=$datos['destino'];
        $carga_fecha=$datos['carga_fecha'];
        $viaje_eta=$datos['viaje_eta'];
        $carga_tipo=$datos['carga_tipo'];
        $carga_peso=$datos['carga_peso'];
        $hazard=$datos['hazard'];
        $reefer=$datos['reefer'];
        $estimados_km=$datos['estimados_km'];
        $estimados_combustible=$datos['estimados_combustible'];
        $estimados_eta=$datos['estimados_eta'];
        $estimados_etd=$datos['estimados_etd'];
        $estimados_viaticos=$datos['estimados_viaticos'];
        $estimados_peajes_pesajes=$datos['estimados_peajes_pesajes'];
        $estimados_extras=$datos['estimados_extras'];
        $estimados_hazard=$datos['estimados_hazard'];
        $estimados_reefer=$datos['estimados_reefer'];
        $estimados_fee=$datos['estimados_fee'];
        $estimados_total=$datos['total'];
        $sqlViaje="INSERT INTO Viaje ('fecha','origen','destino','peso','km_estimados','combustible_previsto','ETD','ETA','patente_arrastre') VALUES('$carga_fecha','$viaje_origen','$viaje_destino',$carga_peso,$estimados_km,$estimados_combustible,$estimados_etd,$estimados_eta,NULL)";
        return true;
    }
}