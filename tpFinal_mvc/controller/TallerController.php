<?php


class TallerController
{
    private $modelo;
    private $render;

    public function __construct($modelo,$render)
    {
        $this->modelo=$modelo;
        $this->render=$render;
    }

    public function nuevo(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=2){
            header("location:../index");
            die();
        }
        $data['accion']="Agregar";
        echo $this->render->render("views/taller.pug",$data);
    }

    public function consultar(){
        if(isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje']=null;
        }
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=2){
            header("location:../index");
            die();
        }
        $data['botones']=true;
        $data['cabeceras']=['CUIT','Nombre','Dirección','Teléfono'];
        $data['listado']=$this->modelo->getTalleres();
        $data['titulo_listado']="talleres";
        $data['sector']="Taller";
        $data['datoPrincipal']="CUIT";
        echo $this->render->render("views/listas.pug",$data);
    }

    public function editar(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=2){
            header("location:../index");
            die();
        }
        if(!isset($_GET['cuit'])){
            header("location: consultar");
            die();
        }
        $cuit=$_GET['cuit'];
        $info=$this->modelo->getTaller($cuit);
        $data['info']=$info[0];
        $data['accion']="Editar";
        $data['editar']=true;
        echo $this->render->render("views/taller.pug",$data);
    }

    public function eliminar(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=2 || !isset($_GET['cuit'])){
            header("location:../index");
            die();
        }
        $cuit=$_GET['cuit'];
        if($this->modelo->deleteTaller($cuit))
            $_SESSION['mensaje']="El taller se eliminó correctamente";
        else
            $_SESSION['mensaje']="El taller no se pudo eliminar";
        header("location:consultar");
    }

    public function procesar(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=2 || empty($_POST['taller'])){
            header("location:../index");
            die();
        }
        $datos=[
            "cuit"=>intval($_POST['cuit']),
            "nombre"=>$_POST['nombre'],
            "direccion"=>$_POST['direccion'],
            "telefono"=>intval($_POST['telefono'])
        ];

        if(isset($_POST['editar'])){
            if($this->modelo->editTaller($datos))
                $_SESSION['mensaje']="Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje']="Hubo un error en la edición de datos";
        }
        else {
            if($this->modelo->registrar($datos))
                $_SESSION['mensaje']="Los datos han sido agregados correctamente";
            else
                $_SESSION['mensaje']="Hubo un error en la carga de datos";
        }
        header("location:consultar");
    }

    public function execute(){
        header("location:consultar");
    }

}