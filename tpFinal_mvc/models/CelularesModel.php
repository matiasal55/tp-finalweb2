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
        $sql = "SELECT * FROM Celulares";
        return $this->database->query($sql);
    }

    public function getCelular($id)
    {
        $sql = "SELECT * FROM Celulares  WHERE id='$id'";
        return $this->database->query($sql);
    }


    public function registrar($datos)
    {
        $numero = $datos['celular'];
        $compañia = $datos['compania'];

        $sql = "INSERT INTO Celulares VALUES (DEFAULT ,'$numero','$compañia',DEFAULT)";
        return $this->database->execute($sql);
    }

    public function editCelular($datos)
    {
        $id = $datos['id'];
        $numero = $datos['celular'];
        $compañia = $datos['compania'];
        $estado=$datos['estado'];
        $sql = "UPDATE Celulares SET numero='$numero',compañia='$compañia', estado='$estado' WHERE id='$id'";
        return $this->database->execute($sql);
    }
    public function deleteCelular($id)
    {
        $sql = "DELETE FROM Celulares WHERE id='$id'";
        return $this->database->execute($sql);
    }
}