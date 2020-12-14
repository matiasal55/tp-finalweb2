<?php

class ServiceController
{
    private $modelo;
    private $render;

    public function __construct($modelo, $render)
    {
        $this->modelo = $modelo;
        $this->render = $render;
    }

    public function execute()
    {
        header("location: consultar");
    }

    public function nuevo()
    {
        $this->controlAcceso();
        $data['vehiculos']=$this->modelo->getVehiculos();
        $data['accion'] = "Agregar";
        echo $this->render->render("views/service.pug", $data);
    }

    public function consultar()
    {
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje'] = null;
        }
        $this->controlAccesoChofer();
        $data['cabeceras'] = ['Id', 'Patente', 'Fecha'];
        if($_SESSION['rol']==1 || $_SESSION['rol']==3) {
            $data['listado'] = $this->modelo->getTodoslosService();
            $data['botones']=true;
            $data['botonNuevo']=true;
        }
        else {
            if(isset($_SESSION['chofer']['vehiculo_asignado'])) {
                $patente=$_SESSION['chofer']['vehiculo_asignado'];
                $data['listado'] = $this->modelo->getService($patente);
            }
            else
                $data['listado']=[];
        }
        $data['titulo_listado'] = "service";
        $data['sector'] = "Service";
        $data['datoPrincipal'] = "id";
        echo $this->render->render("views/listas.pug", $data);
    }

    public function editar()
    {
        $this->controlEdicion();
        $id = $_GET['id'];
        $info = $this->modelo->getServiceYVehiculo($id);
        $data['info'] = $info[0];
        $data['accion'] = "Editar";
        $data['editar'] = true;
        echo $this->render->render("views/service.pug", $data);
    }

    public function eliminar()
    {
        $this->controlEdicion();
        $id = $_GET['id'];
        if ($this->modelo->deleteService($id))
            $_SESSION['mensaje'] = "El service se eliminó correctamente";
        else
            $_SESSION['mensaje'] = "El service no se pudo eliminar";
        header("location:consultar");
    }

    public function procesar()
    {
        $this->controlAcceso();
        $datos = [
            "id" => intval($_POST['id']),
            "patente" => $_POST['patente'],
            "fecha" => $_POST['fecha']
        ];
        if (isset($_POST['editar'])) {
            if ($this->modelo->editService($datos))
                $_SESSION['mensaje'] = "Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la edición de datos";
        } else {
            if ($this->modelo->registrar($datos))
                $_SESSION['mensaje'] = "Los datos han sido agregados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la carga de datos";
        }
        header("location:consultar");
    }

    // Ver los datos que muestra al chofer
    public function informe(){
        $this->controlInforme();
        $id=$_GET['id'];
        $resultado=$this->modelo->getServiceYVehiculo($id);
        $data['info']=$resultado[0];
        $data['titulo_listado'] = "service";
        echo $this->render->render("views/informe.pug",$data);
    }
    public function generar()
    {
        $this->controlAcceso();
        $this->pdf->listaPdf("service");
    }
    public function pdf()
    {
        if (isset($_GET['cuit'])) {
            $data['listado'] = $this->modelo->getTodoslosService();
            $data['titulo_listado'] = "service";
            $data['cabeceras'] = ['Id', 'Patente', 'Fecha'];
            echo $this->render->render("views/pdf_listas.pug", $data);
        } else {
            echo $this->render->render("views/listas.pug");
        }
    }
    private function controlAcceso(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=1 && $_SESSION['rol']!=3){
            header("location:../index");
            die();
        }
    }

    private function controlEdicion(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=1 && $_SESSION['rol']!=3 || !isset($_GET['id'])){
            header("location:../index");
            die();
        }
    }

    private function controlAccesoChofer()
    {
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=1 && $_SESSION['rol']!=3 && $_SESSION['rol']!=4){
            header("location:../index");
            die();
        }
    }

    private function controlInforme()
    {
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=1 && $_SESSION['rol']!=3 && $_SESSION['rol']!=4 || !isset($_GET['id'])){
            header("location:../index");
            die();
        }
    }
}