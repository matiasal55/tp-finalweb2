<?php


class ProformaController
{
    private $modelo;
    private $render;

    public function __construct($modelo,$render)
    {
        $this->modelo=$modelo;
        $this->render=$render;
    }

//    public function consultar(){
//        if(isset($_SESSION['mensaje'])) {
//            $data['mensaje'] = $_SESSION['mensaje'];
//            $_SESSION['mensaje']=null;
//        }
//        $data['cabeceras']=['Número','Origen','Destino','Fecha de carga','ETA','Kilometraje actual','Kilometraje total','Posicion actual','Estado'];
//        $data['listado']=$this->modelo->getVehiculos();
//        $data['titulo_listado']="vehículos";
//        $data['sector']="Vehículo";
//        $data['datoPrincipal']="patente";
//        echo $this->render->render("views/listas.pug",$data);
//    }

    public function execute(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=2){
            header("location:../index");
            die();
        }
        echo $this->render->render("views/proforma.pug");
    }
}