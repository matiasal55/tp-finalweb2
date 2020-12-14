<?php


class ProformaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function registrar($datos)
    {
        $proforma = [];
        $viaje = [];

        foreach ($datos as $index => $dato) {
            $clave = explode("_", $index);
            if ($clave[0] == "proforma") {
                $proforma[$index] = $dato;
            } else if ($clave[0] != "total") {
                $viaje[$index] = $dato;
            }
        }

        $clave_peso = "peso_neto";
        $claves = array_keys($viaje);
        $valores = array_values($viaje);

        $insertarFaltantes = array_search($clave_peso, $claves) + 1;
        $claves2 = array_splice($claves, $insertarFaltantes);
        $valores2 = array_splice($valores, $insertarFaltantes);

        $claves[] = "imoClass";
        $valores[] = $datos['imoClass'] ?? null;

        $claves[] = "temperatura";
        $valores[] = $datos['temperatura'] ?? null;

        $viaje = array_merge(array_combine($claves, $valores), array_combine($claves2, $valores2));

        $query = "";
        foreach ($viaje as $index => $dato) {
            if (isset($dato))
                $query .= ",'$dato'";
            else
                $query .= ",DEFAULT";
        }
        $sql = "INSERT INTO Viaje VALUES (DEFAULT" . $query . " ,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT)";
        if ($this->database->execute($sql)) {
            $clave = $this->database->query("SELECT LAST_INSERT_ID()");
            $clave_viaje = $clave[0]['LAST_INSERT_ID()'];
            $dni = $datos['dni_chofer'];
            $patente = $datos['patente_vehiculo'];
            $celular = $datos['id_celular'];
            $this->asignarVehiculoYCelular($dni, $patente, $celular);
            $estado = 2;
            $this->cambiarEstados($datos, $estado);
            $fecha = $proforma['proforma_fecha'];
            $fee = $proforma['proforma_fee'];
            $total = $proforma['proforma_total_estimado'];
            $cuit = $proforma['proforma_cuit_cliente'];
            $sql = "INSERT INTO Proforma VALUES (DEFAULT,'$fecha',' $fee','$total','$cuit','$clave_viaje',DEFAULT,DEFAULT)";
            if ($this->database->execute($sql)) {
                $numero = $this->database->query("SELECT LAST_INSERT_ID()");
                return $numero[0]['LAST_INSERT_ID()'];
            }
            return false;
        }
        return false;
    }

    public function asignarVehiculoYCelular($dni, $patente, $celular)
    {
        $sql = "UPDATE Chofer SET vehiculo_asignado='$patente',id_celular='$celular' WHERE dni_chofer='$dni'";
        return $this->database->execute($sql);
    }

    public function getProforma($codigo)
    {
        $sql = "SELECT * FROM Proforma, Viaje, Cliente WHERE `Proforma`.`cod_viaje`=`Viaje`.`codigo` AND `Proforma`.`cuit_cliente`=`Cliente`.`CUIT` AND `Proforma`.`numero`='$codigo'";
        return $this->database->query($sql);
    }

    public function getProformasInfo()
    {
        $sql = "SELECT numero,fecha_emision,cuit_cliente,codigo,fecha_viaje,localidad_origen,localidad_destino,estado,patente_vehiculo,patente_arrastre,dni_chofer FROM Proforma, Viaje WHERE `Proforma`.`cod_viaje`=`Viaje`.`codigo`";
        return $this->database->query($sql);
    }

    public function getProformas()
    {
        $sql = "SELECT  * FROM Proforma, Viaje WHERE `Proforma`.`cod_viaje`=`Viaje`.`codigo` ";
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

    public function getClientes()
    {
        $sql = "SELECT * FROM Cliente";
        return $this->database->query($sql);
    }

    public function getArrastres()
    {
        $sql = "SELECT `Arrastre`.`patente`, `tipoArrastre`.`nombre`, `Arrastre`.`estado` FROM Arrastre,tipoArrastre WHERE `Arrastre`.`codigo_tipoArrastre`=`tipoArrastre`.`codigo` ";
        return $this->database->query($sql);
    }

    public function getChoferes()
    {
        $sql = "SELECT `Usuarios`.`dni`,`Usuarios`.`nombre`,`Usuarios`.`apellido`,`Chofer`.`estado` FROM Usuarios, Chofer WHERE `Usuarios`.`dni`=`Chofer`.`dni_chofer`";
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

    public function getCodigoViaje($numero)
    {
        $sql = "SELECT cod_viaje FROM Proforma WHERE numero='$numero'";
        return $this->database->query($sql);
    }

    public function deleteProforma($numero)
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

    private function cambiarEstado($tabla, $clave, $valor, $estado)
    {
        $sql = "UPDATE " . $tabla . " SET estado='$estado' WHERE " . $clave . "='$valor'";
        return $this->database->execute($sql);
    }

    public function getPosicion($patente)
    {
        $sql = "SELECT posicion_actual FROM Vehiculo WHERE patente='$patente'";
        return $this->database->query($sql);
    }

    public function getCosteo($numero)
    {
        $sql = "SELECT * FROM Costeo WHERE codigo_viaje='$numero'";
        return $this->database->query($sql);
    }

    private function cambiarEstados($datos, $estado)
    {
        $this->cambiarEstado("Vehiculo", "patente", $datos['patente_vehiculo'], $estado);
        $this->cambiarEstado("Arrastre", "patente", $datos['patente_arrastre'], $estado);
        $this->cambiarEstado("Chofer", "dni_chofer", $datos['dni_chofer'], $estado);
        $this->cambiarEstado("Celulares", "id", $datos['id_celular'], $estado);
    }
}
