<?php

class HomeController
{
    private $render;

    public function __construct($render)
    {
        $this->render=$render;
    }

    public function execute(){
        if($_SESSION['iniciada'])
            echo $this->render->render("views/home.pug");
        else{
            $data['error']="Para acceder al sistema debe loguearse";
            echo $this->render->render("views/login.pug",$data);
        }
    }
}