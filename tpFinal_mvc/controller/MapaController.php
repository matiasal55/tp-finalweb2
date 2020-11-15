<?php


class MapaController
{
    private $render;

    public function __construct($render)
    {
        $this->render=$render;
    }

    public function execute(){
        if(isset($_SESSION['iniciada']))
            echo $this->render->render("views/mapa.pug");
        else{
            $data['error']="Para acceder al sistema debe loguearse";
            echo $this->render->render("views/login.pug",$data);
        }
    }
}