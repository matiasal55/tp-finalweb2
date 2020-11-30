<?php


class ClienteController
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
        $data['accion'] = "Agregar";
        echo $this->render->render("views/cliente.pug", $data);
    }

    public function consultar()
    {
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje'] = null;
        }
        $this->controlAcceso();
        $data['cabeceras'] = ['CUIT', 'Denominación', 'Dirección', 'Teléfono', 'Email', 'Contacto 1', 'Contacto 2'];
        $data['listado'] = $this->modelo->getClientes();
        $data['titulo_listado'] = "Clientes";
        $data['sector'] = "Cliente";
        $data['botones'] = true;
        $data['datoPrincipal'] = "CUIT";
        if($_SESSION['rol']==2)
            $data['noEliminar']=true;
        echo $this->render->render("views/listas.pug", $data);
    }

    public function editar()
    {
        $this->controlEdicion();
        $cuit = $_GET['cuit'];
        $info = $this->modelo->getCliente($cuit);
        $data['info'] = $info[0];
        $data['accion'] = "Editar";
        $data['editar'] = true;
        echo $this->render->render("views/cliente.pug", $data);
    }

    public function api(){
        $this->controlAcceso();
        if(!isset($_GET['cuit'])){
            $clientes=$this->modelo->getClientes();
        }
        else {
            $cuit=$_GET['cuit'];
            $clientes=$this->modelo->getCliente($cuit);
        }
        echo json_encode($clientes);
    }

    public function eliminar()
    {
        // Solo el Admin puede eliminar
        $this->controlEliminar();
        $cuit = $_GET['cuit'];
        if ($this->modelo->deleteCliente($cuit))
            $_SESSION['mensaje'] = "El cliente se eliminó correctamente";
        else
            $_SESSION['mensaje'] = "El cliente no se pudo eliminar";
        header("location:consultar");
    }

    public function procesar()
    {
        $this->controlAcceso();
        $datos = $_POST;
        if (isset($_POST['editar'])) {
            if ($this->modelo->editCliente($datos))
                $_SESSION['mensaje'] = "Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la carga de datos";
        } else {
            if ($this->modelo->registrar($datos))
                $_SESSION['mensaje'] = "Los datos han sido agregados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la carga de datos";
            header("location:../proforma/nuevo");
            die();
        }
        header("location:consultar");
    }

    private function controlAcceso()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
    }

    private function controlEdicion()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 || !isset($_GET['cuit'])) {
            header("location:../index");
            die();
        }
    }

    private function controlEliminar()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1) {
            header("location:../index");
            die();
        }
    }
}