<?php

class HomeController
{
    private $render;

    public function __construct($render)
    {
        $this->render=$render;
    }

    public function execute(){
        if(isset($_SESSION['iniciada'])) {
            $data['direccion']=".";
            $data['rol']=$_SESSION['rol'];
            if($data['rol']==1)
                echo $this->render->render("views/admin.pug",$data);
            else if($data['rol']==2)
                echo $this->render->render("views/supervisor.pug",$data);
            else if($data['rol']==4)
                echo $this->render->render("views/chofer.pug",$data);
            else
                echo $this->render->render("views/sinrol.pug",$data);
        }
        else{/**/
            $data['error']="Para acceder al sistema debe loguearse";
            echo $this->render->render("views/login.pug",$data);
        }
    }
}