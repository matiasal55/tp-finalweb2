<?php

include 'third-party/vendor/autoload.php';

class Render
{
    private $pug;

    public function __construct()
    {
        $this->pug=new Pug();
    }

    public function render($content,$data=[]){
        if(isset($_SESSION['datos']))
            $data['datos']=$_SESSION['datos'];
        $data['paginas']=["Home","Proforma","Mapa"];
        return $this->pug->render($content,$data);
    }
}