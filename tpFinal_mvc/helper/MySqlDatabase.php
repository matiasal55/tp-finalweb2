<?php

class MySqlDatabase{
    private $conexion;

    public function __construct($host,$user,$password,$database)
    {
        $con=mysqli_connect($host,$user,$password,$database);
        if(!$con)
            die("Falló la conexión");
        $this->conexion=$con;
    }

    public function query($sql){
        $resultado=mysqli_query($this->conexion,$sql);
        return mysqli_fetch_all($resultado,MYSQLI_ASSOC);
    }

    public function execute($sql){
        mysqli_query($this->conexion,$sql);
    }

}