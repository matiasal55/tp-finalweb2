<?php


class CelularesController
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
        $data['companias'] = $this->modelo->getCelulares();
        $data['accion'] = "Agregar";
        echo $this->render->render("views/celular.pug", $data);
    }
    public function consultar()
    {
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje'] = null;
        }
        // Rol 1 y 2
        $this->controlAccesoSupervisor();
        // Si es Admin, muestra los botones de Editar y Eliminar
        if($_SESSION['rol']==1) {
            $data['botones'] = true;
            $data['botonNuevo'] = true;
        }
        $data['cabeceras'] = ['Número', 'Compañia', 'Estado'];
        $data['listado'] = $this->modelo->getCelulares();
        $data['titulo_listado'] = "celulares";
        $data['sector'] = "Celulares";
        $data['datoPrincipal'] = "id";
        echo $this->render->render("views/listas.pug", $data);
    }

    public function informe(){
        // Agregue aca tambien
        $this->controlAccesoSupervisor();
        $id=$_GET['id'];
        $resultado=$this->modelo->getcelular($id);
        $data['info']=$resultado[0];
        $data['titulo_listado'] = "celular";
        echo $this->render->render("views/informe.pug",$data);
    }
    public function editar()
    {
        $this->controlEdicion();
        $id = $_GET['id'];
        $info = $this->modelo->getcelular($id);
        $data['info'] = $info[0];
        $data['companias'] = $this->modelo->getCelulares();
        $data['accion'] = "Editar";
        $data['editar'] = true;
        echo $this->render->render("views/celular.pug", $data);
    }

    public function eliminar()
    {
        $this->controlEdicion();
        $id = $_GET['id'];
        if ($this->modelo->deleteCelular($id))
            $_SESSION['mensaje'] = "El numero de celular se eliminó correctamente";
        else
            $_SESSION['mensaje'] = "El numero de celular no se pudo eliminar";
        header("location:consultar");
    }

    public function procesar()
    {
        $this->controlAcceso();
        $datos = $_POST;
        if ($_POST['editar']) {
            if ($this->modelo->editCelular($datos))
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

    private function controlAcceso(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=1){
            header("location:../index");
            die();
        }
    }
    // Agregado
    private function controlAccesoSupervisor(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=1 && $_SESSION['rol']!=2){
            header("location:../index");
            die();
        }
    }
    private function controlEdicion(){
        if(!isset($_SESSION['iniciada']) || $_SESSION['rol']!=1 || !isset($_GET['id'])){
            header("location:../index");
            die();
        }
    }
}