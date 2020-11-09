<?php

class UsuariosController{
    private $usuariosModel;
    private $render;

    public function __construct($usuariosModel,$render)
    {
        $this->usuariosModel=$usuariosModel;
        $this->render=$render;
    }

    public function loguear(){
        $email=$_POST['email'];
        $password=$_POST['password'];
        $data["usuarios"]=$this->usuariosModel->getLogin($email,$password);
        if($data['usuarios']){
            echo $this->render->render("views/home.pug");
        }
        else {
            $data['error']="Email y/o contraseña incorrecta";
            echo $this->render->render("views/login.pug",$data);
        }
    }

    public function registrar(){
        $datos=$_POST;
        $data['usuario']=$this->usuariosModel->setRegistro($datos);
        echo $this->render->render("../views/login.php");
    }
}