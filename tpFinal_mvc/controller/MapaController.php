<?php


class MapaController
{
    private $render;

    public function __construct($render)
    {
        $this->render=$render;
    }

    public function execute(){
        if(isset($_SESSION['iniciada'])) {
            $data['direccion']=".";
            echo $this->render->render("views/mapa.pug",$data);
        }
        else{
            $data['error']="Para acceder al sistema debe loguearse";
            echo $this->render->render("views/login.pug",$data);
        }
    }
}