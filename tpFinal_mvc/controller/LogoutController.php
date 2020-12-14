<?php


class LogoutController
{
    private $render;

    public function __construct($render)
    {
        $this->render=$render;
    }

    public function execute(){
        if(isset($_SESSION['iniciada'])){
            session_destroy();
        }
        header("location:index");
    }
}