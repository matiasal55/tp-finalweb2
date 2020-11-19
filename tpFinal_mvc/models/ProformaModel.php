<?php


class ProformaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database=$database;
    }

    public function registrar($datos){
        $proforma=[];
        $viaje=[];
        foreach ($datos as $index=>$dato) {
            $clave = explode("_", $index);
            if ($clave[0] == "proforma") {
                $proforma[$index] = $dato;
            } else if ($clave[0] != "total") {
                $viaje[$index] = $dato;
            }
        }
        $query="";
        foreach ($viaje as $index=>$dato){
            $query.=",'$dato'";
        }
        $sql="INSERT INTO Viaje VALUES (DEFAULT".$query.",'AA123CD','AD100AZ','32514124',DEFAULT,DEFAULT,DEFAULT,DEFAULT,DEFAULT)";
        if($this->database->execute($sql)){
            $clave=$this->database->query("SELECT LAST_INSERT_ID()");
            $clave_viaje=$clave[0]['LAST_INSERT_ID()'];
            $fecha=$proforma['proforma_fecha'];
            $cuit=$proforma['proforma_cuit_cliente'];
            $sql="INSERT INTO Proforma VALUES (DEFAULT,'$fecha','$cuit','$clave_viaje')";
            return $this->database->execute($sql);
        }
        return false;
    }
}