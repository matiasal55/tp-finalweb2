<?php

class HomeController
{
    private $modelo;
    private $render;

    public function __construct($modelo,$render)
    {
        $this->modelo=$modelo;
        $this->render=$render;
    }

    public function execute(){
        if(isset($_SESSION['iniciada'])) {
            $data['direccion']=".";
            $data['rol']=$_SESSION['rol'];
            $fecha=date('Y-m-d');
            if($data['rol']==1 || $data['rol']==3){
                $data['services']=$this->modelo->getServicePorFecha($fecha);
            }
            else if($data['rol']==4){
                $patente=$_SESSION['chofer']['vehiculo_asignado'];
                $data['services']=$this->modelo->getServicePorFechaYVehiculo($patente,$fecha);
            }
            if($data['rol']==1){
                echo $this->render->render("views/admin.pug",$data);
            }
            else if($data['rol']==2)
                echo $this->render->render("views/supervisor.pug",$data);
            else if($data['rol']==3)
                echo $this->render->render("views/encargado.pug",$data);
            else if($data['rol']==4)
                echo $this->render->render("views/chofer.pug",$data);
            else
                echo $this->render->render("views/sinrol.pug",$data);
        }
        else{
            $_SESSION['error']="Para acceder al sistema debe loguearse";
            header("location:index");
        }
    }
}