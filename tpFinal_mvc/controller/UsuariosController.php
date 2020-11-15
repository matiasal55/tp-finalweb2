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
        if(isset($_SESSION['iniciada']))
            header("location:../home");
        if(!isset($_POST['email'])) {
            header("location:../");
            die();
        }
        $email=$_POST['email'];
        $password=$_POST['password'];
        $data["usuario"]=$this->modelo->getLogin($email,$password);
        if($data['usuario']){
            $_SESSION['rol']=$data['usuario'][0]['rol'];
            $_SESSION['iniciada']=true;
            header("location:../home");
        }
        else {
            $_SESSION['email']=$email;
            $_SESSION['error']="Email y/o contraseña incorrecta";
            header("location: ../index");
        }
    }

    public function registrar(){
        // Mismos puntos que en login
        if(isset($_SESSION['iniciada']))
            header("location:home");
        if(empty($_POST['registrar']))
            header("location:../");
        $datos=[
            "dni"=>$_POST['dni'],
            "nombre"=>$_POST['nombre'],
            "apellido"=>$_POST['apellido'],
            "fecha_nacimiento"=>$_POST['fecha_nacimiento'],
            "email"=>$_POST['email'],
            "password"=>$_POST['password'],
            "area"=>$_POST['area'],
            "licencia"=>$_POST['tipo_licencia'] ?? null
        ];
        if($this->modelo->setRegistro($datos))
            header("location:../");
        else echo $this->render->render("views/registrar.pug");
    }

    public function consultar(){
        if(!isset($_SESSION['iniciada'])){
            header("location:index");
            die();
        }
        if($_SESSION['rol']!=1){
            header("location:../index");
        }
        $data['empleados']=$this->modelo->getEmpleados();
        echo $this->render->render("views/listaempleados.pug",$data);
    }

    public function eliminar(){
        $dni=$_GET['id'];
        if($this->modelo->deleteUser($dni))
            echo "OK";
        else echo "No";
    }
}