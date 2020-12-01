<?php


class CelularesModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    public function getCelulares()
    {
        $sql = "SELECT numero,compañia,estado FROM Celulares";
        return $this->database->query($sql);
    }
//    public function getCelulares()
//    {
//        $sql = "SELECT `Viaje`.`dni_chofer`,`Celulares`.`numero`, `Celulares`.`compañia`, `Celulares`.`estado` FROM Viaje,Celulares WHERE `Viaje`.`id_celular`=`Celulares`.`id` ";
//        return $this->database->query($sql);
//    }

    public function getcelular($id)
    {
        $sql = "SELECT * FROM Celulares  WHERE id='$id'";
        return $this->database->query($sql);
    }


    public function registrar($datos)
    {
        $id=$datos['id'];
        $numero = $datos['celular'];
        $compañia = $datos['compania'];

        $sql = "INSERT INTO Celulares VALUES ($id,'$numero','$compañia',DEFAULT)";
        return $this->database->execute($sql);
    }

    public function editCelular($datos)
    {
        $id = $datos['id'];
        $numero = $datos['celular'];
        $compañia = $datos['compania'];
        $estado=$datos['estado'];
        $sql = "UPDATE Celular SET numero='$numero',compañia='$compañia', estado='$estado' WHERE id='$id'";
        return $this->database->execute($sql);
    }
    public function deleteCelular($id)
    {
        $sql = "DELETE FROM Celulares WHERE id='$id'";
        return $this->database->execute($sql);
    }
}