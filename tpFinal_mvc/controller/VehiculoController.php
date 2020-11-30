<?php


class VehiculoController
{
    private $modelo;
    private $render;

    public function __construct($modelo, $render)
    {
        $this->modelo = $modelo;
        $this->render = $render;
    }

    public function nuevo()
    {
        $this->controlAcceso();
        $data['marcas'] = $this->modelo->getMarcas();
        $data['modelos'] = $this->modelo->getModelos();
        $data['accion'] = "Agregar";
        echo $this->render->render("views/vehiculo.pug", $data);
    }

    public function procesar()
    {
        $this->controlAcceso();
        $datos = $_POST;
        if (isset($_POST['km_total'])) {
            $datos['km_total'] = intval($_POST['km_total']);
            if ($this->modelo->registrar($datos))
                $_SESSION['mensaje'] = "Los datos han sido agregados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la carga de datos";
        } else {
            if ($this->modelo->editVehiculo($datos))
                $_SESSION['mensaje'] = "Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la edición de datos";
        }
        header("location:consultar");
    }

    public function consultar()
    {
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje'] = null;
        }
        $this->controlAccesoUsuarios();
        $data['cabeceras'] = ['Patente', 'Marca', 'Modelo', 'Año', 'Chasis', 'Motor', 'Kilometraje actual', 'Kilometraje total', 'Posicion actual', 'Estado'];
        if($_SESSION['rol']==1){
            $data['listado'] = $this->modelo->getVehiculos();
            $data['botones'] = true;
            $data['botonNuevo'] = true;
        }
        else if($_SESSION['rol']==2 || $_SESSION['rol']==3){
            $data['listado'] = $this->modelo->getVehiculos();
        }
        else {
            if(isset($_SESSION['chofer']['vehiculo_asignado'])) {
                $patente=$_SESSION['chofer']['vehiculo_asignado'];
                $data['listado'] = $this->modelo->getVehiculo($patente);
            }
            else
                $data['listado']=[];
        }

        $data['titulo_listado'] = "vehículos";
        $data['sector'] = "Vehículo";
        $data['datoPrincipal'] = "patente";
        echo $this->render->render("views/listas.pug", $data);
    }

    // Cualquier usuario accedería al informe del vehículo, salvo el que no tiene rol
    public function informe()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] == 0 || !isset($_GET['patente'])) {
            header("location:../index");
            die();
        }
        $patente = $_GET['patente'];
        $resultado = $this->modelo->getVehiculo($patente);
        $data['info'] = $resultado[0];
        $data['titulo_listado'] = "vehículo";
        //$data['datoPrincipal'] = "patente";
        echo $this->render->render("views/informe.pug", $data);
    }

    public function editar()
    {
        $this->controlEdicion();
        $patente = $_GET['patente'];
        $info = $this->modelo->getVehiculo($patente);
        $data['info'] = $info[0];
        $data['marcas'] = $this->modelo->getMarcas();
        $data['modelos'] = $this->modelo->getModelos();
        $data['accion'] = "Editar";
        echo $this->render->render("views/vehiculo.pug", $data);
    }

    public function eliminar()
    {
        $this->controlEdicion();
        $patente = $_GET['patente'];
        if ($this->modelo->deleteVehiculo($patente))
            $_SESSION['mensaje'] = "El vehículo se eliminó correctamente";
        else
            $_SESSION['mensaje'] = "El vehículo no se pudo eliminar";
        header("location:consultar");
    }

    public function posicion()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 || !isset($_GET['patente'])) {
            header("location:../index");
            die();
        }
        $patente = $_GET['patente'];
        $posicion = $this->modelo->getInformacion($patente);
        $data['posicion'] = $posicion[0]['posicion_actual'];
        $data['km_totales'] = $posicion[0]['km_totales'];
        $data['combustible_total'] = $posicion[0]['combustible_total'];
        echo $this->render->render("views/mapa.pug", $data);
    }

    public function execute()
    {
        header("location:consultar");
    }

    private function controlAcceso()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1) {
            header("location:../index");
            die();
        }
    }

    private function controlAccesoUsuarios()
    {
        if (!isset($_SESSION['iniciada'])) {
            header("location:../index");
            die();
        }
    }

    private function controlSupervisorChofer()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 && $_SESSION['rol'] != 4) {
            header("location:../index");
            die();
        }
    }

    private function controlEdicion()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 || !isset($_GET['patente'])) {
            header("location:../index");
            die();
        }
    }

}