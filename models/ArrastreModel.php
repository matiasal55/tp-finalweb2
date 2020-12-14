<?php


class ArrastreModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getArrastres()
    {
        $sql = "SELECT `Arrastre`.`patente`,`Arrastre`.`chasis`, `tipoArrastre`.`nombre` FROM Arrastre,tipoArrastre WHERE `Arrastre`.`codigo_tipoArrastre`=`tipoArrastre`.`codigo` ";
        return $this->database->query($sql);
    }

    public function getArrastre($patente)
    {
        $sql = "SELECT * FROM  Arrastre, tipoArrastre WHERE `Arrastre`.`codigo_tipoArrastre`=`tipoArrastre`.`codigo` AND patente='$patente'";
        return $this->database->query($sql);
    }

    public function getTipoArrastre()
    {
        $sql = "SELECT * FROM tipoArrastre";
        return $this->database->query($sql);
    }

    public function registrar($datos)
    {
        $patente = $datos['patente'];
        $chasis = $datos['chasis'];
        $tipoArrastre = $datos['codigo_tipoArrastre'];
        $sql = "INSERT INTO Arrastre VALUES ('$patente','$chasis','$tipoArrastre',DEFAULT)";
        return $this->database->execute($sql);
    }

    public function editArrastre($datos)
    {
        $patente = $datos['patente'];
        $chasis = $datos['chasis'];
        $tipoArrastre = $datos['codigo_tipoArrastre'];
        $estado=$datos['estado'];
        $sql = "UPDATE Arrastre SET patente='$patente',chasis='$chasis',codigo_tipoArrastre='$tipoArrastre', estado='$estado' WHERE patente='$patente'";
        return $this->database->execute($sql);
    }

    public function deleteArrastre($patente)
    {
        $sql = "DELETE FROM Arrastre WHERE patente='$patente'";
        return $this->database->execute($sql);
    }
}