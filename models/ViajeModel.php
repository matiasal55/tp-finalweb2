<?php


class ViajeModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function registrar($datos)
    {
        $query = "";
        foreach ($datos as $index => $dato) {

            $clave = explode("_", $index);
            if ($clave[0] != "total") {
                if ($dato == '')
                    $dato = 'DEFAULT';
                $query .= "'" . $dato . "', ";
            }
        }
        $sql = "INSERT INTO Viajes VALUES (DEFAULT, " . $query . " DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT)";
        if ($this->database->execute($sql)) {
            $clave = $this->database->query("SELECT LAST_INSERT_ID()");
            $clave_viaje = $clave[0]['LAST_INSERT_ID()'];
            return $clave_viaje;
        }
        return false;
    }


    public function asignarVehiculoYCelular($dni, $patente, $celular)
    {
        $sql = "UPDATE Chofer SET vehiculo_asignado='$patente',id_celular='$celular' WHERE dni_chofer='$dni'";
        return $this->database->execute($sql);
    }

//nuevo metodo abarcatodo
    public function getViajes()
    {
        $sql = "SELECT * FROM  Viajes ";
        return $this->database->query($sql);
    }

    public function getViaje($numero)
    {
        $sql = "SELECT * FROM Viajes,Cliente WHERE `Viajes`.`cuit_cliente`=`Cliente`.`CUIT`AND numero='$numero'";
        return $this->database->query($sql);
    }

    public function getViajeInfo()
    {
        $sql = "SELECT numero,fecha_emision,cuit_cliente,codigo,fecha_viaje,localidad_origen,localidad_destino,estado,patente_vehiculo,patente_arrastre,dni_chofer FROM Viajes ";
        return $this->database->query($sql);
    }

    public function getCelulares()
    {
        $sql = "SELECT * FROM Celulares";
        return $this->database->query($sql);
    }

    public function getVehiculos()
    {
        $sql = "SELECT `Vehiculo`.`patente`, `Marca`.`nombre`,`Modelo`.`descripcion`,`Vehiculo`.`estado` FROM Vehiculo,Marca,Modelo WHERE `Vehiculo`.`cod_marca`=`Marca`.`codigo` and `Vehiculo`.`cod_modelo`=`Modelo`.`cod_modelo`";
        return $this->database->query($sql);
    }

    public
    function getClientes()
    {
        $sql = "SELECT * FROM Cliente";
        return $this->database->query($sql);
    }

    public
    function getArrastres()
    {
        $sql = "SELECT `Arrastre`.`patente`, `tipoArrastre`.`nombre`, `Arrastre`.`estado` FROM Arrastre,tipoArrastre WHERE `Arrastre`.`codigo_tipoArrastre`=`tipoArrastre`.`codigo` ";
        return $this->database->query($sql);
    }

    public
    function getChoferes()
    {
        $sql = "SELECT `Usuarios`.`dni`,`Usuarios`.`nombre`,`Usuarios`.`apellido`,`Chofer`.`estado` FROM Usuarios, Chofer WHERE `Usuarios`.`dni`=`Chofer`.`dni_chofer`";
        return $this->database->query($sql);
    }

    public
    function getPatente($codigo)
    {
        $sql = "SELECT patente_vehiculo FROM Viaje WHERE codigo='$codigo'";
        return $this->database->query($sql);
    }

    public function editProforma($datos)
    {
        $proforma = [];
        $viaje = [];

        foreach ($datos as $index => $dato) {
            $clave = explode("_", $index);
            if ($clave[0] == "proforma") {
                $proforma[$index] = $dato;
            } else if ($clave[0] != "total" && $index != "viaje_codigo") {
                $viaje[$index] = $dato;
            }
        }
        $query = "UPDATE Viaje SET ";
        foreach ($viaje as $index => $dato) {
            $query .= "$index='$dato', ";
        }
        $query = rtrim($query, ", ");
        $query .= " WHERE codigo='" . $datos['viaje_codigo'] . "'";
        if ($this->database->execute($query)) {
            $dni = $datos['dni_chofer'];
            $patente = $datos['patente_vehiculo'];
            $celular = $datos['id_celular'];
            if ($datos['estado'] != 3) {
                $this->asignarVehiculoYCelular($dni, $patente, $celular);
                $estado = 2;
            } else {
                $estado = 1;
            }
            $this->cambiarEstados($datos, $estado);
            $query = "UPDATE Proforma SET fecha_emision='" . $proforma['proforma_fecha'] . "', fee_previsto='" . $proforma['proforma_fee'] . "',cuit_cliente='" . $proforma['proforma_cuit_cliente'] . "',cod_viaje='" . $datos['viaje_codigo'] . "',fee_total='" . $datos['proforma_fee'] . "' WHERE numero='" . $datos['proforma_numero'] . "'";
            return $this->database->execute($query);
        }
        return false;
    }

    public
    function getViajesCliente($cuit)
    {
        $sql = "SELECT `Viaje`.`codigo`,`Viaje`.`fecha_viaje`,`Viaje`.`localidad_origen`,`Viaje`.`localidad_destino`,`Viaje`.`estado`,`Viaje`.`patente_vehiculo`,`Viaje`.`patente_arrastre`,`Viaje`.`dni_chofer` FROM Viaje, Proforma WHERE `Viaje`.`codigo`=`Proforma`.`cod_viaje` AND `Proforma`.`cuit_cliente`='$cuit'";
        return $this->database->query($sql);
    }

    public
    function getViajesPorVehiculo($patente)
    {
        $sql = "SELECT codigo,fecha_viaje,localidad_origen,localidad_destino,estado,patente_vehiculo,patente_arrastre,dni_chofer FROM Viaje WHERE patente_vehiculo='$patente'";
        return $this->database->query($sql);
    }

    public
    function getCodigoViaje($numero)
    {
        $sql = "SELECT cod_viaje FROM Proforma WHERE numero='$numero'";
        return $this->database->query($sql);
    }

    public
    function deleteProforma($numero)
    {
        $resultado = $this->getCodigoViaje($numero);
        $viaje = $resultado[0]['cod_viaje'];
        $sql = "DELETE FROM Proforma WHERE numero='$numero'";
        if ($this->database->execute($sql)) {
            $sql = "DELETE FROM Viaje WHERE codigo='$viaje'";
            return $this->database->execute($sql);
        }
        return false;
    }

    private
    function cambiarEstado($tabla, $clave, $valor, $estado)
    {
        $sql = "UPDATE " . $tabla . " SET estado='$estado' WHERE " . $clave . "='$valor'";
        return $this->database->execute($sql);
    }

    public
    function getPosicion($patente)
    {
        $sql = "SELECT posicion_actual FROM Vehiculo WHERE patente='$patente'";
        return $this->database->query($sql);
    }

    public
    function getCosteo($numero)
    {
        $sql = "SELECT * FROM Costeo WHERE codigo_viaje='$numero'";
        return $this->database->query($sql);
    }

    private
    function cambiarEstados($datos, $estado)
    {
        $this->cambiarEstado("Vehiculo", "patente", $datos['patente_vehiculo'], $estado);
        $this->cambiarEstado("Arrastre", "patente", $datos['patente_arrastre'], $estado);
        $this->cambiarEstado("Chofer", "dni_chofer", $datos['dni_chofer'], $estado);
        $this->cambiarEstado("Celulares", "id", $datos['id_celular'], $estado);
    }

    public
    function getConceptos()
    {
        $sql = "SELECT * FROM Gastos";
        return $this->database->query($sql);
    }

    private
    function buscarConcepto($codigo)
    {
        $sql = "SELECT nombre FROM Gastos WHERE codigo='$codigo'";
        return $this->database->query($sql);
    }

}