<?php


class MantenimientoController
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
        echo $this->render->render("views/mantenimiento.pug",$data);
    }

    public function procesar(){
        $datos=[
            "patente"=>$_POST['patente'],
            "marca"=>intval($_POST['marca']),
            "modelo"=>intval($_POST['modelo']),
            "chasis"=>$_POST['chasis'],
            "motor"=>$_POST['motor']
        ];
        if(isset($_POST['km_total'])){
            $datos['km_total']=intval($_POST['km_total']);
            if($this->modelo->registrar($datos))
                $_SESSION['mensaje']="Los datos han sido agregados correctamente";
            else
                $_SESSION['mensaje']="Hubo un error en la carga de datos";
        }
        else {
            if($this->modelo->editVehiculo($datos))
                $_SESSION['mensaje']="Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje']="Hubo un error en la edición de datos";
        }
        header("location:consultar");
    }

    // Ver el tema de los roles. Si es un encargado de taller solamente tiene que ver
    // los mantenimientos de su taller
    public function consultar(){
        if(isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje']=null;
        }
        if($_SESSION['rol']==1 || $_SESSION['rol']==2) {
            $data['cabeceras'] = ['Código', 'Vehículo', 'Fecha Inicio', 'Fecha Final', 'Kilometraje', 'Costo', 'Taller', 'Mecánico'];
            $data['listado'] = $this->modelo->getMantenimientos();
        }
        else if($_SESSION['rol']==3){
            $data['cabeceras'] = ['Código', 'Vehículo', 'Fecha Inicio', 'Fecha Final', 'Kilometraje', 'Costo', 'Mecánico'];
            $data['listado'] = $this->modelo->getMantenimientosPorTaller($_SESSION['taller']);
        }
        else {
            header("location:../index");
            die();
        }
        $data['datoPrincipal'] = "mantenimiento";
        $data['titulo_listado'] = "mantenimientos";
        $data['sector'] = "Mantenimiento";
        echo $this->render->render("views/listas.pug",$data);
    }

    public function editar(){
        if(!isset($_GET['codigo'])){
            header("location: consultar");
            die();
        }
        $codigo=$_GET['codigo'];
        $info=$this->modelo->getMantenimiento($codigo);
        $data['info']=$info[0];
        $data['accion']="Editar";
        echo $this->render->render("views/mantenimiento.pug",$data);
    }

    public function eliminarMantenimiento(){
        $codigo=$_GET['codigo'];
        if($this->modelo->deleteMantenimiento($codigo))
            $_SESSION['mensaje']="El mantenimiento se eliminó correctamente";
        else
            $_SESSION['mensaje']="El mantenimiento no se pudo eliminar";
        header("location:consultar");
    }


}