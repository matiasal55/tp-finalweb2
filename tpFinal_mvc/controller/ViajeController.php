<?php


class ViajeController
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
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
        $data['accion'] = "Agregar";
        echo $this->render->render("views/viaje.pug", $data);
    }
    public function informe(){
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 && $_SESSION['rol']!=4 || !isset($_GET['codigo'])) {
           header("location:../index");
            die();
        }
        $codigo = $_GET['codigo'];
        $info=$this->modelo->getViaje($codigo);
        $data['info'] = $info[0];
        $data['datoPrincipal'] = "codigo";
        $data['titulo_listado'] = "viaje";
        echo $this->render->render("views/informe.pug",$data);
    }

    public function procesar()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
        $datos=$_POST;
            if ($this->modelo->editViaje($datos))
                $_SESSION['mensaje'] = "Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la edición de datos";
        header("location:consultar");
    }


    public function editar()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 || !isset($_GET['codigo'])) {
            header("location:../index");
            die();
        }
        $codigo = $_GET['codigo'];
        $info = $this->modelo->getViaje($codigo);
        $data['info'] = $info[0];
        $data['accion'] = "Editar";
        $data['editar'] = true;
        $data['vehiculos'] = $this->modelo->getVehiculos();
        $data['arrastres'] = $this->modelo->getArrastres();
        $data['choferes'] = $this->modelo->getChoferes();
        echo $this->render->render("views/viaje.pug", $data);
    }

    public function consultar()
    {
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje'] = null;
        }
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 && $_SESSION['rol'] != 4) {
            header("location:../index");
            die();
        }
        $data['cabeceras'] = ['Código', 'Fecha', 'Localidad_origen', 'Localidad_destino', 'estado', 'patente_vehiculo', 'patente_arrastre', 'dni_chofer'];
        $data['listado'] = $this->modelo->getViajes();
        $data['titulo_listado'] = "viajes";
        $data['sector'] = "Viaje";
        $data['datoPrincipal'] = "codigo";
        $data['botones'] = true;
        echo $this->render->render("views/listas.pug", $data);
    }

    public function eliminar()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
        $codigo = $_GET['codigo'];
        if ($this->modelo->deleteViaje($codigo))
            $_SESSION['mensaje'] = "El viaje se eliminó correctamente";
        else
            $_SESSION['mensaje'] = "Verifique haber borrado primero la proforma relacionada";
        header("location:consultar");
    }
    public function reportar(){
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
        $data['codigo'] = $_GET['codigo'];
        echo $this->render->render("views/cargaDatos.pug", $data);
    }

    public  function procesarReporte(){
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
        $datos=$_POST;
        $codigo=$datos['codigo'];
        $resultado=$this->modelo->getPatente($codigo);
        $datos['patente']=$resultado[0]['patente_vehiculo'];
        $datos['combustible_previo']=$resultado[0]['combustible_total'];
            if ($this->modelo->registrarReporte($datos))
                $_SESSION['mensaje'] = "Los datos han sido agregados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la carga de datos";

        header("location:consultar");
    }
}