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
        $sql = "SELECT patente_vehiculo,combustible_total FROM Viaje WHERE codigo='$codigo'";
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

    public function editViaje($datos)
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
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
        if ($this->database->execute($sql)) {
            $codigo = $datos['codigo'];
            $combustible_total = $datos['combustible']+$datos['combustible_previo'];
            $km_total = $datos['km'];
            $sql = "UPDATE Viaje SET combustible_total='$combustible_total',km_totales='$km_total' WHERE  codigo='$codigo'";
            return $this->database->execute($sql);
        }
        return false;
    }
}