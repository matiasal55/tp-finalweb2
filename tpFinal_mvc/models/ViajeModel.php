<?php


class ViajeModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getViajes()
    {
        $sql = "SELECT codigo,fecha_viaje,localidad_origen,localidad_destino,estado,patente_vehiculo,patente_arrastre,dni_chofer FROM Viaje";
        return $this->database->query($sql);
    }

    public function getViaje($codigo)
    {
        $sql = "SELECT * FROM Viaje WHERE codigo='$codigo'";
        return $this->database->query($sql);
    }

    public function getPatente($codigo)
    {
        $sql = "SELECT patente_vehiculo FROM Viaje WHERE codigo='$codigo'";
        return $this->database->query($sql);
    }

    public function getViajesPorVehiculo($patente){
        $sql="SELECT codigo,fecha_viaje,localidad_origen,localidad_destino,estado,patente_vehiculo,patente_arrastre,dni_chofer FROM Viaje WHERE patente_vehiculo='$patente'";
        return $this->database->query($sql);
    }

    public function getVehiculos()
    {
        $sql = "SELECT `Vehiculo`.`patente`, `Marca`.`nombre`,`Modelo`.`descripcion` FROM Vehiculo,Marca,Modelo WHERE `Vehiculo`.`cod_marca`=`Marca`.`codigo` and `Vehiculo`.`cod_modelo`=`Modelo`.`cod_modelo`";
        return $this->database->query($sql);
    }

    public function getArrastres()
    {
        $sql = "SELECT `Arrastre`.`patente`, `tipoArrastre`.`nombre` FROM Arrastre,tipoArrastre WHERE `Arrastre`.`codigo_tipoArrastre`=`tipoArrastre`.`codigo` ";
        return $this->database->query($sql);
    }

    public function getChoferes()
    {
        $sql = "SELECT dni,nombre,apellido FROM Usuarios WHERE cod_area= '4'";
        return $this->database->query($sql);
    }

    public function getCelulares(){
        $sql="SELECT * FROM Celulares";
        return $this->database->query($sql);
    }


    public function editViaje($datos)
    {
        $query = "UPDATE Viaje SET ";
        foreach ($datos as $index => $dato) {
            if ($index != "viaje_codigo")
                $query .= "$index='$dato', ";
        }
        $query = rtrim($query, ", ");
        $query .= " WHERE codigo='" . $datos['viaje_codigo'] . "'";
        return $this->database->execute($query);
    }

    public function registrarReporte($datos)
    {
        $patente = $datos['patente'];
        $posicion_actual = $datos['posicionActual'];
        $sql = "UPDATE Vehiculo SET posicion_actual='$posicion_actual' WHERE patente='$patente'";
        $this->database->execute($sql);
        $codigo_viaje = $datos['codigo'];
        $factura=$datos['numero_factura'];
        $detalles=$datos['detalles'];
        $direccion=$datos['direccion'];
        $precio=$datos['precio'];
        $codigo_gastos=$datos['codigo_gastos'];
        $sql="INSERT INTO Costeo VALUES (DEFAULT,'$codigo_viaje','$factura','$detalles','$direccion',DEFAULT,'$precio','$codigo_gastos')";
        if ($this->database->execute($sql)) {
            if($datos['combustible']){
                $codigo=$this->database->query("SELECT LAST_INSERT_ID()");
                $codigo_costeo=$codigo[0]['LAST_INSERT_ID()'];
                $combustible=$datos['combustible'];
                $sql = "UPDATE Costeo SET litros_combustible='$combustible' WHERE codigo='$codigo_costeo'";
                $this->database->execute($sql);
            }
            $km_total = $datos['km'];
            $concepto = $this->buscarConcepto($codigo_gastos);
            $concepto = strtolower($concepto[0]['nombre']);
            $sql = "UPDATE Viaje SET km_totales='$km_total',".$concepto."_total=`".$concepto."_total`+".$precio." WHERE codigo='$codigo_viaje'";
            $this->database->execute($sql);
            $subsql="(SELECT SUM(precio) FROM Costeo WHERE codigo_viaje='$codigo_viaje')";
            $sql="UPDATE Proforma SET total_real=".$subsql." WHERE cod_viaje='$codigo_viaje'";
            return $this->database->execute($sql);
        }
        return false;
    }

    public function getPosicion($patente){
        $sql="SELECT posicion_actual FROM Vehiculo WHERE patente='$patente'";
        return $this->database->query($sql);
    }

    public function getViajesCliente($cuit){
        $sql="SELECT `Viaje`.`codigo`,`Viaje`.`fecha_viaje`,`Viaje`.`localidad_origen`,`Viaje`.`localidad_destino`,`Viaje`.`estado`,`Viaje`.`patente_vehiculo`,`Viaje`.`patente_arrastre`,`Viaje`.`dni_chofer` FROM Viaje, Proforma WHERE `Viaje`.`codigo`=`Proforma`.`cod_viaje` AND `Proforma`.`cuit_cliente`='$cuit'";
        return $this->database->query($sql);
    }

    public function getConceptos(){
        $sql="SELECT * FROM Gastos";
        return $this->database->query($sql);
    }

    private function buscarConcepto($codigo)
    {
        $sql="SELECT nombre FROM Gastos WHERE codigo='$codigo'";
        return $this->database->query($sql);
    }
}