<?php

class MySqlDatabase{
    private $conexion;

    public function __construct($host,$user,$password,$database,$port)
    {
        $con=mysqli_connect($host,$user,$password,$database,$port);
        if(!$con)
            die("Falló la conexión");
        $this->conexion=$con;
    }

    publIc function query($sql){
        $resultado=mysqli_query($this->conexion,$sql);
        return mysqli_fetch_all($resultado,MYSQLI_ASSOC);
    }

    public function execute($sql){
        return mysqli_query($this->conexion,$sql);
    }

}