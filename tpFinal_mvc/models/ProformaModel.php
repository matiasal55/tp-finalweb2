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
        $viaje['imoClass'] = $datos['imoClass'] ?? 'DEFAULT';
        $viaje['temperatura'] = $datos['temperatura'] ?? 'DEFAULT';

        foreach ($datos as $index => $dato) {
            $clave = explode("_", $index);
            if ($clave[0] == "proforma") {
                $proforma[$index] = $dato;
            } else if ($clave[0] != "total") {

                $viaje[$index] = $dato;
            }
        }
        $query = "";
        foreach ($viaje as $index => $dato) {
            $query .= ",'$dato'";
        }
        $sql = "INSERT INTO Viaje VALUES (DEFAULT" . $query . " ,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT)";
        if ($this->database->execute($sql)) {
            $clave = $this->database->query("SELECT LAST_INSERT_ID()");
            $clave_viaje = $clave[0]['LAST_INSERT_ID()'];
            $fecha = $proforma['proforma_fecha'];
            $fee = $proforma['proforma_fee'];
            $cuit = $proforma['proforma_cuit_cliente'];


            $sql = "INSERT INTO Proforma VALUES (DEFAULT,'$fecha',' $fee','$cuit','$clave_viaje',DEFAULT)";
            return $this->database->execute($sql);
        }
        return false;
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
}
