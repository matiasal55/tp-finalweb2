<?php


class RegistrarController
{
    private $render;

    public function __construct($render)
    {
        $this->render=$render;
    }

    public function execute(){
        if(isset($_SESSION['iniciada'])) {
            header("location:home");
            die();
        }
        $data['url']="https://".$_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);
        echo $this->render->render("views/registrar.pug",$data);
    }
}