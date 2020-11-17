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
        $data['accion'] = "Agregar";
        echo $this->render->render("views/service.pug", $data);
    }

    public function consultar()
    {
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje'] = null;
        }
        $data['cabeceras'] = ['Id', 'Patente', 'Fecha'];
        $data['listado'] = $this->modelo->getTodoslosService();
        $data['titulo_listado'] = "service";
        $data['sector'] = "Service";
        $data['datoPrincipal'] = "id";
        $data['botones'] = true;
        $data['botonNuevo'] = true;
        echo $this->render->render("views/listas.pug", $data);
    }

    public function editar()
    {
        if (!isset($_GET['id'])) {
            header("location: consultar");
            die();
        }
        $id = $_GET['id'];
        $info = $this->modelo->getService($id);
        $data['info'] = $info[0];
        $data['accion'] = "Editar";
        $data['editar'] = true;
        echo $this->render->render("views/service.pug", $data);
    }

    public function eliminar()
    {
        $id = $_GET['id'];
        if ($this->modelo->deleteService($id))
            $_SESSION['mensaje'] = "El service se eliminó correctamente";
        else
            $_SESSION['mensaje'] = "El service no se pudo eliminar";
        header("location:consultar");
    }

    public function procesar()
    {
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


}