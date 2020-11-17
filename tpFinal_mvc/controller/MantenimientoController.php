<?php


class MantenimientoController
{
    private $modelo;
    private $render;
    private $cod_taller;

    public function __construct($modelo, $render)
    {
        $this->modelo = $modelo;
        $this->render = $render;
        $this->cod_taller=2014125982;
    }

    public function execute()
    {
        header("location:consultar");
    }

    public function nuevo(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=2 && $_SESSION['rol']!=3){
            header("location:../index");
            die();
        }
        $data['accion']="Agregar";
        echo $this->render->render("views/mantenimiento.pug",$data);
    }

    public function procesar(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=2 && $_SESSION['rol']!=3){
            header("location:../index");
            die();
        }
        $datos=[
            "patente"=>$_POST['patente'],
            "fecha_inicio"=>date('Y-m-d',strtotime($_POST['fecha_inicio'])),
            "fecha_final"=>date('Y-m-d',strtotime($_POST['fecha_final'])),
            "kilometraje"=>intval($_POST['kilometraje']),
            "costo"=>intval($_POST['costo']),
            "dni_mecanico"=>intval($_POST['dni_mecanico']),
            "fecha_proximo"=>$_POST['fecha_proximo'] ?? null,
            "repuestos_cambiados"=>$_POST['repuestos_cambiadoss']
        ];
        if($_POST['taller']=="Empresa")
            $datos['cod_taller']=$this->cod_taller;
        else $datos['cod_taller']=$_POST['cod_taller'];
        if(isset($_POST['editar'])){
            $datos['codigo']=intval($_POST['editar']);
            $datos['service']=intval($_POST['id_service']);
            if($this->modelo->editMantenimiento($datos))
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

    // Ver lo de taller vinculado a encargado
    public function consultar(){
        if(isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje']=null;
        }
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=2 && $_SESSION['rol']!=3){
            header("location:../index");
            die();
        }
        else if($_SESSION['rol']==2) {
            $data['cabeceras'] = ['Código', 'Vehículo', 'Fecha Inicio', 'Fecha Final', 'Kilometraje', 'Costo', 'Taller', 'Mecánico','Próximo Service'];
            $data['listado'] = $this->modelo->getMantenimientos();
        }
        else if($_SESSION['rol']==3){
            $data['cabeceras'] = ['Código', 'Vehículo', 'Fecha Inicio', 'Fecha Final', 'Kilometraje', 'Costo', 'Mecánico'];
            $data['listado'] = $this->modelo->getMantenimientosPorTaller($_SESSION['taller']);
        }
        $data['botones']=true;
        $data['botonNuevo']=true;
        $data['datoPrincipal'] = "codigo";
        $data['titulo_listado'] = "mantenimientos";
        $data['sector'] = "Mantenimiento";
        echo $this->render->render("views/listas.pug",$data);
    }

    public function editar(){
        if(!isset($_GET['codigo'])){
            header("location: consultar");
            die();
        }
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=2 && $_SESSION['rol']!=3){
            header("location:../index");
            die();
        }
        $codigo=$_GET['codigo'];
        $info=$this->modelo->getMantenimiento($codigo);
        $data['info']=$info[0];
        $data['accion']="Editar";
        $data['editar']=true;
        if($info[0]['cod_taller']==$this->cod_taller)
            $data['interno']=true;
        else $data['externo']=true;
        echo $this->render->render("views/mantenimiento.pug",$data);
    }

    public function eliminar(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=2 && $_SESSION['rol']!=3){
            header("location:../index");
            die();
        }
        if(!isset($_GET['codigo'])){
            header("location: consultar");
            die();
        }
        $codigo=$_GET['codigo'];
        if($this->modelo->deleteMantenimiento($codigo))
            $_SESSION['mensaje']="El mantenimiento se eliminó correctamente";
        else
            $_SESSION['mensaje']="El mantenimiento no se pudo eliminar";
        header("location:consultar");
    }
}