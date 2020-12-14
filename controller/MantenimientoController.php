<?php


class MantenimientoController
{
    private $modelo;
    private $render;
    private $cod_taller;
    private $pdf;

    public function __construct($modelo, $render,$pdf)
    {
        $this->modelo = $modelo;
        $this->render = $render;
        $this->cod_taller=2014125982;
        $this->pdf=$pdf;
    }

    public function execute()
    {
        header("location:consultar");
    }

    public function nuevo(){
        $this->controlAcceso();
        $data['accion']="Agregar";
        echo $this->render->render("views/mantenimiento.pug",$data);
    }

    public function procesar(){
        $this->controlAcceso();
        $datos=$_POST;
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

    public function consultar(){
        if(isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje']=null;
        }
        $this->controlAccesoChofer();
        $data['cabeceras'] = ['Código', 'Vehículo', 'Fecha Inicio', 'Fecha Final', 'Kilometraje', 'Costo', 'Taller', 'Mecánico','Próximo Service','Repuestos cambiados'];
        if($_SESSION['rol']==1 || $_SESSION['rol']==3) {
            $data['listado'] = $this->modelo->getMantenimientos();
            $data['botones']=true;
            $data['botonNuevo']=true;
        }
        else {
            if(isset($_SESSION['chofer']['vehiculo_asignado'])) {
                $patente=$_SESSION['chofer']['vehiculo_asignado'];

                $data['listado'] = $this->modelo->getMantenimientoVehiculo($patente);
            }
            else
                $data['listado']=[];
        }
        $data['datoPrincipal'] = "codigo";
        $data['titulo_listado'] = "mantenimientos";
        $data['sector'] = "Mantenimiento";
        echo $this->render->render("views/listas.pug",$data);
    }

    public function informe(){
        $this->controlAccesoChofer();
        $patente=$_GET['codigo'];
        $resultado=$this->modelo->getMantenimiento($patente);
        $data['info']=$resultado[0];
        $data['datoPrincipal']="codigo";
        $data['titulo_listado'] = "mantenimiento";
        echo $this->render->render("views/informe.pug",$data);
    }

    public function editar(){
        if(!isset($_GET['codigo'])){
            header("location: consultar");
            die();
        }
        $this->controlAcceso();
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
        $this->controlAcceso();
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

    public function generar()
    {
        $this->controlAcceso();
        if(isset($_GET['codigo'])){
            $codigo = $_GET['codigo'];
            $this->pdf->informePdf($codigo,"mantenimiento","codigo");
        }
        else {
            $this->pdf->listaPdf("mantenimiento");
        }
    }

    public function pdf(){
        $data['fecha']=date('d-m-Y');
        if(isset($_GET['codigo'])) {
            $codigo = $_GET['codigo'];
            $resultado = $this->modelo->getMantenimiento($codigo);
            $data['info'] = $resultado[0];
            $data['titulo_listado']="Mantenimiento";
            echo $this->render->render("views/pdf_template.pug", $data);
        }
        else {
            $data['listado'] = $this->modelo->getMantenimientos();
            $data['titulo_listado']="Mantenimientos";
            $data['cabeceras'] = ['Código', 'Vehículo', 'Fecha Inicio', 'Fecha Final', 'Kilometraje', 'Costo', 'Taller', 'Mecánico','Próximo Service','Repuestos cambiados'];
            echo $this->render->render("views/pdf_listas.pug",$data);
        }
    }

    private function controlAcceso()
    {
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']==4 || $_SESSION['rol']==0){
            header("location:../index");
            die();
        }
    }

    private function controlAccesoChofer()
    {
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']==0 ){
            header("location:../index");
            die();
        }
    }
}