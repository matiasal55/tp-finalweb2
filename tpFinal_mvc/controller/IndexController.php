<?php


class IndexController
{
    private $render;

    public function __construct($render)
    {
        $this->render=$render;
    }

    public function execute(){
        if(isset($_SESSION['iniciada']))
            header("location:home");
        echo $this->render->render("views/login.pug");
    }
}