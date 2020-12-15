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
                if ($dato == '') {
                    $dato = 'DEFAULT';
                    $query.=$dato.",";
                }
                else
                    $query .= "'" . $dato . "', ";
            }
        }

        $sql = "INSERT INTO Viajes VALUES (DEFAULT, " . $query . " DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT)";
        if ($this->database->execute($sql)) {
            $this->cambiarEstados($datos,2);
            $this->asignarVehiculoYCelular($datos['dni_chofer'],$datos['patente_vehiculo'],$datos['id_celular']);
            $clave = $this->database->query("SELECT LAST_INSERT_ID()");
            $clave_viaje = $clave[0]['LAST_INSERT_ID()'];
            return $clave_viaje;
        }

        return false;
    }


    public
    function asignarVehiculoYCelular($dni, $patente, $celular)
    {
        $sql = "UPDATE Chofer SET vehiculo_asignado='$patente',id_celular='$celular' WHERE dni_chofer='$dni'";
        return $this->database->execute($sql);
    }

    public function getViajes()
    {
        $sql = "SELECT * FROM  Viajes ";
        return $this->database->query($sql);
    }

    public
    function getViaje($numero)
    {
        $sql = "SELECT * FROM Viajes,Cliente WHERE `Viajes`.`cuit_cliente`=`Cliente`.`CUIT`AND numero='$numero'";
        return $this->database->query($sql);
    }

    public
    function getViajeInfo()
    {
        $sql = "SELECT numero,fecha_emision,cuit_cliente,fecha_viaje,localidad_origen,localidad_destino,estado,patente_vehiculo,patente_arrastre,dni_chofer FROM Viajes ";
        return $this->database->query($sql);
    }

    public
    function getCelulares()
    {
        $sql = "SELECT * FROM Celulares";
        return $this->database->query($sql);
    }

    public
    function getVehiculos()
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

    public
    function getChoferes()
    {
        $sql = "SELECT `Usuarios`.`dni`,`Usuarios`.`nombre`,`Usuarios`.`apellido`,`Chofer`.`estado` FROM Usuarios, Chofer WHERE `Usuarios`.`dni`=`Chofer`.`dni_chofer`";
        return $this->database->query($sql);
    }

    public
    function getPatente($codigo)
    {
        $sql = "SELECT patente_vehiculo FROM Viajes WHERE numero='$codigo'";
        return $this->database->query($sql);
    }

    public function getTotalCosteo($numero){
        $sql="SELECT SUM(precio) FROM Costeo WHERE codigo_viaje='$numero'";
        return $this->database->query($sql);
    }

    public function editViaje($datos)
    {
        $query = "";
        foreach ($datos as $index => $dato) {
            $clave = explode("_", $index);
            if ($clave[0] != "total") {
                if ($dato != '') {
                    $query .= $index . "='" . $dato . "',";
                }
            }
        }
        if($datos['estado']==3){
            $this->cambiarEstados($datos,1);
        }
        $query=rtrim($query,",");
        $numero=$datos['numero'];
        $sql = "UPDATE Viajes SET " . $query . " WHERE numero='$numero'";
        return $this->database->execute($sql);
    }


    public
    function getViajesCliente($cuit)
    {
        $sql = "SELECT numero,fecha_emision,cuit_cliente,fecha_viaje,localidad_origen,localidad_destino,estado,patente_vehiculo,patente_arrastre,dni_chofer FROM Viajes WHERE cuit_cliente='$cuit'";
        return $this->database->query($sql);
    }

    public
    function getViajesPorVehiculo($patente)
    {
        $sql = "SELECT numero,fecha_emision,cuit_cliente,fecha_viaje,localidad_origen,localidad_destino,estado,patente_vehiculo,patente_arrastre,dni_chofer FROM Viajes WHERE patente_vehiculo='$patente'";
        return $this->database->query($sql);
    }

    public
    function getCodigoViaje($numero)
    {
        $sql = "SELECT * FROM Viajes WHERE numero='$numero'";
        return $this->database->query($sql);
    }

    public
    function deleteViaje($numero)
    {
        $sql = "DELETE FROM Viajes WHERE numero='$numero'";
        return $this->database->execute($sql);

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

    public function getTotalCosteo($numero)
    {
        $sql = "SELECT SUM(precio) FROM Costeo WHERE codigo_viaje='$numero'";
        return $this->database->query($sql);
    }

    private function cambiarEstados($datos, $estado)
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

    public
    function registrarReporte($datos)
    {
        $patente = $datos['patente'];
        $posicion_actual = $datos['posicionActual'];
        $sql = "UPDATE Vehiculo SET posicion_actual='$posicion_actual' WHERE patente='$patente'";
        $this->database->execute($sql);
        $codigo_viaje = $datos['codigo'];
        $factura = $datos['numero_factura'];
        $detalles = $datos['detalles'];
        $direccion = $datos['direccion'];
        $precio = $datos['precio'];
        $codigo_gastos = $datos['codigo_gastos'];
        $sql = "INSERT INTO Costeo VALUES (DEFAULT,'$codigo_viaje','$factura','$detalles','$direccion',DEFAULT,'$precio','$codigo_gastos')";
        if ($this->database->execute($sql)) {
            if ($datos['combustible']) {
                $codigo = $this->database->query("SELECT LAST_INSERT_ID()");
                $codigo_costeo = $codigo[0]['LAST_INSERT_ID()'];
                $combustible = $datos['combustible'];
                $sql = "UPDATE Costeo SET litros_combustible='$combustible' WHERE codigo='$codigo_costeo'";
                $this->database->execute($sql);
            }
            $km_total = $datos['km'];
            $concepto = $this->buscarConcepto($codigo_gastos);
            $concepto = strtolower($concepto[0]['nombre']);
            $subsql="(SELECT SUM(precio) FROM Costeo WHERE codigo_viaje='$codigo_viaje')";
            $sql = "UPDATE Viajes SET km_total='$km_total',".$concepto."_total=`".$concepto."_total`+".$precio.",total_real=".$subsql." WHERE numero='$codigo_viaje'";
            return $this->database->execute($sql);
        }
        return false;
    }
}