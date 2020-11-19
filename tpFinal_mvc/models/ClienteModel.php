<?php
/**/

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
        $cuit = $datos['CUIT'];
        $denominacion = $datos['denominacion'];
        $direccion = $datos['direccion'];
        $telefono = $datos['telefono'];
        $email = $datos['email'];
        $contacto1 = $datos['contacto1'];
        $contacto2 = $datos['contacto2'];
        $sql = "INSERT INTO Cliente VALUES (' $cuit','$denominacion',' $direccion','$telefono','$email','$contacto1','$contacto2')";
        return $this->database->execute($sql);
    }

    public function editCliente($datos)
    {
        $cuitnuevo=$datos['CUIT'];
        $cuitAnterior = $datos['CUIT'];
        $denominacion = $datos['denominacion'];
        $direccion = $datos['direccion'];
        $telefono = $datos['telefono'];
        $email = $datos['email'];
        $contacto1 = $datos['contacto1'];
        $contacto2 = $datos['contacto2'];
        $sql = "UPDATE Cliente SET CUIT='$cuitnuevo', denominacion='$denominacion', direccion='$direccion', telefono='$telefono',email='$email',contacto1='$contacto1',contacto2='$contacto2' WHERE CUIT='$cuitAnterior'";
        return $this->database->execute($sql);
    }

    public function deleteCliente($cuit)
    {
        $sql = "DELETE FROM Cliente WHERE CUIT='$cuit'";
        return $this->database->execute($sql);
    }
}