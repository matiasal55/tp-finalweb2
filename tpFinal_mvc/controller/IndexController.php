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
        $data=[];
        if(isset($_SESSION['error'])) {
            $data['valueEmail']=$_SESSION['email'] ?? "";
            $data['error'] = $_SESSION['error'];
            session_destroy();
        }
        echo $this->render->render("views/login.pug",$data);
    }
}