<?php

class ClienteModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getClientes()
    {
        $sql = "SELECT * FROM Cliente";
        return $this->database->query($sql);
    }

    public function getCliente($cuit)
    {
        $sql = "SELECT * FROM Cliente WHERE CUIT='$cuit'";
        return $this->database->query($sql);
    }

    public function registrar($datos)
    {
        $query = "";
        foreach ($datos as $dato){
            if($dato=='')
                $dato=0;
            $query.="'".$dato."', ";
        }
        $query = rtrim($query, ", ");
        $sql="INSERT INTO Cliente VALUES (".$query.")";
        return $this->database->execute($sql);
    }

    public function editCliente($datos)
    {
        $query = "";
        foreach ($datos as $index=>$dato){
            if($dato=='')
                $dato=0;
            if($index!="editar")
                $query.="$index='".$dato."', ";
        }
        $query=rtrim($query,", ");
        $cuit = $datos['editar'];
        $sql="UPDATE Cliente SET ".$query." WHERE CUIT='$cuit'";
        return $this->database->execute($sql);
    }

    public function deleteCliente($cuit)
    {
        $sql = "DELETE FROM Cliente WHERE CUIT='$cuit'";
        return $this->database->execute($sql);
    }
}