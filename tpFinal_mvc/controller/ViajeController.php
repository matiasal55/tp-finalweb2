<?php


class ViajeController
{
    private $modelo;
    private $render;

    public function __construct($modelo, $render)
    {
        $this->modelo = $modelo;
        $this->render = $render;
    }

    public function nuevo(){
        $data['accion']="Agregar";
        echo $this->render->render("views/viaje.pug",$data);
    }

    public function procesar(){
//        $datos=[
//            "patente"=>$_POST['patente'],
//            "marca"=>intval($_POST['marca']),
//            "modelo"=>intval($_POST['modelo']),
//            "anio_fabricacion"=>intval($_POST['anio_fabricacion']),
//            "chasis"=>$_POST['chasis'],
//            "motor"=>$_POST['motor']
//        ];

        if(isset($_POST['editar'])){
            if($this->modelo->editViaje($datos))
                $_SESSION['mensaje']="Los datos han sido agregados correctamente";
            else
                $_SESSION['mensaje']="Hubo un error en la carga de datos";
        }
        else {
            if($this->modelo->registrar($datos))
                $_SESSION['mensaje']="Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje']="Hubo un error en la edición de datos";
        }
        header("location:consultar");
    }

    public function editar(){
        if(!isset($_GET['codigo'])){
            header("location: consultar");
            die();
        }
        $codigo=$_GET['codigo'];
        $info=$this->modelo->getViaje($codigo);
        $data['info']=$info[0];
        $data['accion']="Editar";
        $data['editar']=true;
        echo $this->render->render("views/viaje.pug",$data);
    }

    public function consultar(){
        if(isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje']=null;
        }
        $data['cabeceras']=[];
        $data['listado']=$this->modelo->getViajes();
        $data['titulo_listado']="viajes";
        $data['sector']="Viaje";
        $data['datoPrincipal']="codigo";
        echo $this->render->render("views/listas.pug",$data);
    }

    public function eliminar(){
        $codigo=$_GET['codigo'];
        if($this->modelo->deleteViaje($codigo))
            $_SESSION['mensaje']="El viaje se eliminó correctamente";
        else
            $_SESSION['mensaje']="Verifique haber borrado primero la proforma relacionada";
        header("location:consultar");
    }

    public function execute(){
        header("location:consultar");
    }
}