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

    public function nuevo(){
        $data['accion']="Agregar";
        echo $this->render->render("views/mantenimiento.pug",$data);
    }

    public function procesar(){
        $datos=[
            "patente"=>$_POST['patente'],
            "fecha_inicio"=>date('Y-m-d',strtotime($_POST['fecha_inicio'])),
            "fecha_final"=>date('Y-m-d',strtotime($_POST['fecha_final'])),
            "kilometraje"=>intval($_POST['kilometraje']),
            "costo"=>intval($_POST['costo']),
            "dni_mecanico"=>intval($_POST['dni_mecanico']),
            "fecha_proximo"=>$_POST['fecha_proximo']
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

    // Ver el tema de los roles. Si es un encargado de taller solamente tiene que ver
    // los mantenimientos de su taller
    public function consultar(){
        if(isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje']=null;
        }
        if($_SESSION['rol']==1 || $_SESSION['rol']==2) {
            $data['cabeceras'] = ['Código', 'Vehículo', 'Fecha Inicio', 'Fecha Final', 'Kilometraje', 'Costo', 'Taller', 'Mecánico','Próximo Service'];
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
        $data['datoPrincipal'] = "codigo";
        $data['titulo_listado'] = "mantenimientos";
        $data['sector'] = "Mantenimiento";
//        var_dump($data['listado']);
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
        $data['editar']=true;
        if($info[0]['cod_taller']==$this->cod_taller)
            $data['interno']=true;
        else $data['externo']=true;
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