<?php


class CelularesController
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
        $this->controlAccesoSupervisor();
        if ($_SESSION['rol'] == 1) {
            $data['botones'] = true;
            $data['botonNuevo'] = true;
        }
        $data['cabeceras'] = $this->getCabeceras();
        $data['listado'] = $this->modelo->getCelulares();
        $data['titulo_listado'] = "celulares";
        $data['sector'] = "Celular";
        $data['datoPrincipal'] = "id";
        echo $this->render->render("views/listas.pug", $data);
    }

    public function informe()
    {
        $this->controlAccesoSupervisor();
        $id = $_GET['id'];
        $resultado = $this->modelo->getCelular($id);
        $data['info'] = $resultado[0];
        $data['titulo_listado'] = "celular";
        $data['datoPrincipal'] = "id";
        echo $this->render->render("views/informe.pug", $data);
    }

    public function editar()
    {
        $this->controlEdicion();
        $id = $_GET['id'];
        $info = $this->modelo->getCelular($id);
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
        if ($_POST['id']) {
            if ($this->modelo->editCelular($datos))
                $_SESSION['mensaje'] = "Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la carga de datos";
        } else {
            if ($this->modelo->registrar($datos))
                $_SESSION['mensaje'] = "Los datos han sido agregados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error ";
        }
        header("location:consultar");
    }

    public function generar()
    {
        $this->controlAccesoSupervisor();
        if (isset($_GET['id'])) {
            $numero = $_GET['id'];
            $this->pdf->informePdf($numero, "celulares", "id");
        } else {
            $this->pdf->listaPdf("celulares");
        }
    }

    public function pdf()
    {
        $data['fecha'] = date('d-m-Y');
        if (isset($_GET['id'])) {
            $numero = $_GET['id'];
            $resultado = $this->modelo->getCelular($numero);
            $data['info'] = $resultado[0];
            $data['titulo_listado'] = "Celular";
            echo $this->render->render("views/pdf_template.pug", $data);
        } else {
            $data['listado'] = $this->modelo->getCelulares();
            $data['titulo_listado'] = "Celulares";
            $data['estados'] = ["", "Disponible", "Disponible", "No Disponible"];
            $data['cabeceras'] = $this->getCabeceras();
            echo $this->render->render("views/pdf_listas.pug", $data);
        }
    }

    private function controlAcceso()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1) {
            header("location:../index");
            die();
        }
    }

    private function controlAccesoSupervisor()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
    }

    private function controlEdicion()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 || !isset($_GET['id'])) {
            header("location:../index");
            die();
        }
    }

    private function getCabeceras()
    {
        $cabeceras = ['Id', 'Número', 'Compañia', 'Estado'];
        return $cabeceras;
    }
}