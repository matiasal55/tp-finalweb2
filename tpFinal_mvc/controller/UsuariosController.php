<?php

class UsuariosController{
    private $modelo;
    private $render;

    public function __construct($modelo,$render)
    {
        $this->modelo=$modelo;
        $this->render=$render;
    }

    public function login(){
        $email=$_POST['email'];
        $password=$_POST['password'];
        $data["usuario"]=$this->modelo->getLogin($email,$password);
        if($data['usuario']){
            $_SESSION['iniciada']=true;
            header("location:../home");
        }
        else {
            $data['error']="Email y/o contraseña incorrecta";
            echo $this->render->render("views/login.pug",$data);
        }
    }

    public function registrar(){
        $datos=[
            "dni"=>$_POST['dni'],
            "nombre"=>$_POST['nombre'],
            "apellido"=>$_POST['apellido'],
            "fecha_nacimiento"=>$_POST['fecha_nacimiento'],
            "email"=>$_POST['email'],
            "password"=>$_POST['password']
        ];
        if($this->modelo->setRegistro($datos))
            header("location:../");
        else $this->render->render("registrar.pug");
    }
}