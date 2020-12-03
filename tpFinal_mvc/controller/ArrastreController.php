<?php

class ArrastreController
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
        header("location:consultar");
    }

    public function nuevo()
    {
        $this->controlAcceso();
        $data['tipo_arrastres'] = $this->modelo->getTipoArrastre();
        $data['accion'] = "Agregar";
       // $data['nuevo'] = "arrastre";

        echo $this->render->render("views/arrastre.pug", $data);
    }

    public function consultar()
    {
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje'] = null;
        }
        $this->controlAccesoSupervisor();
        if($_SESSION['rol']==1) {
            $data['botones'] = true;
            $data['botonNuevo'] = true;
        }
        $data['cabeceras'] = ['Patente', 'Chasis', 'Tipo de Arrastre'];
        $data['listado'] = $this->modelo->getArrastres();
        $data['titulo_listado'] = "arrastres";
        $data['sector'] = "Arrastre";
        $data['datoPrincipal'] = "patente";
        echo $this->render->render("views/listas.pug", $data);
    }

    public function editar()
    {
        $this->controlEdicion();
        $patente = $_GET['patente'];
        $info = $this->modelo->getArrastre($patente);
        $data['info'] = $info[0];
        $data['tipo_arrastres'] = $this->modelo->getTipoArrastre();
        $data['accion'] = "Editar";
        $data['editar'] = true;
        echo $this->render->render("views/arrastre.pug", $data);
    }

    public function eliminar()
    {
        $this->controlEdicion();
        $patente = $_GET['patente'];
        if ($this->modelo->deleteArrastre($patente))
            $_SESSION['mensaje'] = "El arrastre se eliminó correctamente";
        else
            $_SESSION['mensaje'] = "El arrastre no se pudo eliminar";
        header("location:consultar");
    }

    public function procesar()
    {
        $this->controlAcceso();
        $datos = $_POST;
        if ($_POST['editar']) {
            if ($this->modelo->editArrastre($datos))
                $_SESSION['mensaje'] = "Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la carga de datos";
        } else {
            if ($this->modelo->registrar($datos))
                $_SESSION['mensaje'] = "Los datos han sido agregados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la carga de datos";
        }
        header("location:consultar");
    }

    public function informe(){
        $this->controlAccesoSupervisor();
        $patente=$_GET['patente'];
        $resultado=$this->modelo->getArrastre($patente);
        $data['info']=$resultado[0];
        $data['titulo_listado'] = "arrastre";
        echo $this->render->render("views/informe.pug",$data);
    }

    private function controlAcceso(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=1){
            header("location:../index");
            die();
        }
    }

    private function controlAccesoSupervisor(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=1 && $_SESSION['rol']!=2){
            header("location:../index");
            die();
        }
    }

    private function controlEdicion(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=1 || !isset($_GET['patente'])){
            header("location:../index");
            die();
        }
    }
}