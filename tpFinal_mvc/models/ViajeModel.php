<?php


class ViajeModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getViajes(){
        $sql="SELECT codigo,fecha_viaje,localidad_origen,localidad_destino,estado,patente_vehiculo,patente_arrastre,dni_chofer FROM Viaje";
        return $this->database->query($sql);
    }

    public function getViajeDetalles($codigo){
        $sql="SELECT * FROM Viaje WHERE codigo='$codigo'";
        $viaje=$this->database->query($sql);
        $dni_chofer=$viaje[0]['dni_chofer'];
        $patente_vehiculo=$viaje[0]['patente_vehiculo'];
        $sql="SELECT nombre, apellido FROM Usuarios WHERE dni='$dni_chofer'";
        $chofer=$this->database->query($sql);
        $sql="SELECT * FROM Vehiculo WHERE patente='$patente_vehiculo'";
        $vehiculo=$this->database->query($sql);
        $posicion_actual=$vehiculo[0]['posicion actual'];
        $cod_marca=$vehiculo[0]['cod_marca'];
        $cod_modelo=$vehiculo[0]['cod_modelo'];
        $sql="SELECT nombre FROM Marca WHERE codigo='$cod_marca'";
        $marca=$this->database->query($sql);
        $sql="SELECT descripcion FROM Modelo WHERE cod_modelo='$cod_modelo' AND cod_marca='$cod_marca'";
        $modelo=$this->database->query($sql);
        $patente_arrastre=$viaje[0]['patente_arrastre'];
        $sql="SELECT * FROM Arrastre WHERE patente='$patente_arrastre'";
        $arrastre=$this->database->query($sql);
        $cod_tipoArrastre=$arrastre[0]['codigo_tipoArrastre'];
        $sql="SELECT nombre FROM tipoArrastre WHERE codigo='$cod_tipoArrastre'";
        $tipoArrastre=$this->database->query($sql);
        $resultado=["viaje"=>$viaje,
            "chofer"=>$chofer,
            "posicion actual"=>$posicion_actual,
            "marca"=>$marca,
            "modelo"=>$modelo,
            "arrastre"=>$arrastre,
            "tipo_arrastre"=>$tipoArrastre];
        return $resultado;
    }

    public function getViaje($codigo){
        $sql="SELECT * FROM Viaje WHERE codigo='$codigo'";
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
        $query="UPDATE Viaje SET ";
        foreach ($datos as $index => $dato) {
            if($index!="viaje_codigo")
                $query .= "$index='$dato', ";
        }
        $query=rtrim($query,", ");
        $query.=" WHERE codigo='".$datos['viaje_codigo']."'";
        return $this->database->execute($query);
    }

    public function deleteViaje($codigo){
        $sql="DELETE FROM Viaje WHERE codigo='$codigo'";
        return $this->database->execute($sql);
    }
}