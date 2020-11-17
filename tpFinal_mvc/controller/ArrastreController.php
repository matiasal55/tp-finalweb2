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
        $data['tipo_arrastres'] = $this->modelo->getTipoArrastre();
        $data['accion'] = "Agregar";
        echo $this->render->render("views/arrastre.pug", $data);
    }

    // Lista los arrastres
    public function consultar()
    {
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje'] = null;
        }
        $data['cabeceras'] = ['Patente', 'Chasis', 'Tipo de Arrastre'];
        $data['listado'] = $this->modelo->getArrastres();
        $data['titulo_listado'] = "arrastres";
        $data['sector'] = "Arrastre";
        $data['botones'] = true;
        $data['botonNuevo'] = true;
        $data['datoPrincipal'] = "patente";
        echo $this->render->render("views/listas.pug", $data);
    }

    public function editar()
    {
        if (!isset($_GET['patente'])) {
            header("location: consultar");
            die();
        }
        $patente = $_GET['patente'];
        $info = $this->modelo->getArrastre($patente);
        $data['info'] = $info[0];
        $data['tipo_arrastres'] = $this->modelo->getTipoArrastre();;
        $data['accion'] = "Editar";
        $data['editar'] = true;
        echo $this->render->render("views/arrastre.pug", $data);
    }

    public function eliminar()
    {
        $patente = $_GET['patente'];
        if ($this->modelo->deleteArrastre($patente))
            $_SESSION['mensaje'] = "El arrastre se eliminó correctamente";
        else
            $_SESSION['mensaje'] = "El arrastre no se pudo eliminar";
        header("location:consultar");
    }

    public function procesar()
    {
        $datos = [
            "patente" => $_POST['patente'],
            "chasis" => $_POST['chasis'],
            "codigo_tipoArrastre" => $_POST['tipo_arrastre']
        ];
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

}