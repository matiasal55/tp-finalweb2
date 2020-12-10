<?php

class ServiceController
{
    private $modelo;
    private $render;
    private $pdf;

    public function __construct($modelo, $render, $pdf)
    {
        $this->modelo = $modelo;
        $this->render = $render;
        $this->pdf = $pdf;
    }

    public function execute()
    {
        header("location: consultar");
    }

    public function nuevo()
    {
        $this->controlAcceso();
        $data['vehiculos'] = $this->modelo->getVehiculos();
        $data['accion'] = "Agregar";
        echo $this->render->render("views/service.pug", $data);
    }

    public function consultar()
    {
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje'] = null;
        }
        $this->controlAcceso();
        $data['cabeceras'] = $this->getCabeceras();
        if ($_SESSION['rol'] != 4) {
            $data['listado'] = $this->modelo->getTodoslosService();
            $data['botones'] = true;
            $data['botonNuevo'] = true;
            if($_SESSION['rol'] != 4)
                $data['noEliminar'] = true;
        } else {
            if (isset($_SESSION['chofer']['vehiculo_asignado'])) {
                $patente = $_SESSION['chofer']['vehiculo_asignado'];
                $data['listado'] = $this->modelo->getService($patente);
            } else
                $data['listado'] = [];
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

    public function informe()
    {
        $this->controlInforme();
        $id = $_GET['id'];
        $resultado = $this->modelo->getServiceYVehiculo($id);
        $data['info'] = $resultado[0];
        $data['titulo_listado'] = "service";
        $data['datoPrincipal'] = "id";
        echo $this->render->render("views/informe.pug", $data);
    }

    public function generar()
    {
        $this->controlAcceso();
        if (isset($_GET['id'])) {
            $codigo = $_GET['id'];
            $this->pdf->informePdf($codigo, "service", "id");
        } else {
            $this->pdf->listaPdf("service");
        }
    }

    public function pdf()
    {
        $data['fecha'] = date('d-m-Y');
        if (isset($_GET['id'])) {
            $codigo = $_GET['id'];
            $resultado = $this->modelo->getServiceYVehiculo($codigo);
            $data['info'] = $resultado[0];
            $data['titulo_listado'] = "Service";
            echo $this->render->render("views/pdf_template.pug", $data);
        } else {
            $data['listado'] = $this->modelo->getTodoslosService();
            $data['titulo_listado'] = "Services";
            $data['cabeceras'] = $this->getCabeceras();
            echo $this->render->render("views/pdf_listas.pug", $data);
        }
    }

    private function controlAcceso()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 && $_SESSION['rol'] != 3) {
            header("location:../index");
            die();
        }
    }

    private function controlEdicion()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 3 || !isset($_GET['id'])) {
            header("location:../index");
            die();
        }
    }

    private function controlAccesoChofer()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 3 && $_SESSION['rol'] != 4) {
            header("location:../index");
            die();
        }
    }

    private function controlInforme()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] == 0 || !isset($_GET['id'])) {
            header("location:../index");
            die();
        }
    }

    private function getCabeceras()
    {
        $cabeceras=['Id', 'Patente', 'Fecha'];
        return $cabeceras;
    }
}