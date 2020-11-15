<?php


class TallerController
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

    // Renderiza el formulario para agregar, no para editar
    public function nuevo()
    {
        $data['accion'] = "Agregar";
        echo $this->render->render("views/taller.pug", $data);
    }

    // Lista los talleres
    public function consultar()
    {
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje'] = null;
        }
        $data['cabeceras'] = ['CUIT', 'Nombre', 'Dirección', 'Teléfono'];
        $data['listado'] = $this->modelo->getTalleres();
        $data['titulo_listado'] = "talleres";
        $data['sector'] = "Taller";
        $data['datoPrincipal'] = "CUIT";
        echo $this->render->render("views/listas.pug", $data);
    }

    public function editar()
    {
        if (!isset($_GET['cuit'])) {
            header("location: consultar");
            die();
        }
        $cuit = $_GET['cuit'];
        $info = $this->modelo->getTaller($cuit);
        $data['info'] = $info[0];
        $data['accion'] = "Editar";
        $data['editar'] = true;
        echo $this->render->render("views/taller.pug", $data);
    }

    public function eliminar()
    {
        $cuit = $_GET['cuit'];
        if ($this->modelo->deleteTaller($cuit))
            $_SESSION['mensaje'] = "El taller se eliminó correctamente";
        else
            $_SESSION['mensaje'] = "El taller no se pudo eliminar";
        header("location:consultar");
    }

    public function procesar()
    {
        $datos = [
            "CUIT" => intval($_POST['CUIT']),
            "nombre" => $_POST['nombre'],
            "direccion" => $_POST['direccion'],
            "telefono" => intval($_POST['telefono'])
        ];
        if (isset($_POST['editar'])) {
            if ($this->modelo->editTaller($datos))
                $_SESSION['mensaje'] = "Los datos han sido agregados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la carga de datos";
        } else {
            if ($this->modelo->registrar($datos))
                $_SESSION['mensaje'] = "Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la edición de datos";
        }
        header("location:consultar");
    }


}