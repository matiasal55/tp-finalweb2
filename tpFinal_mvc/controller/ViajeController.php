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

    public function informe()
    {
        $this->controlInforme();
        $codigo = $_GET['codigo'];
        $info = $this->modelo->getViaje($codigo);
        $data['datoPrincipal'] = "codigo";
        $data['titulo_listado'] = "viaje";
        $patente = $info[0]['patente_vehiculo'];
        $posicion = $this->modelo->getPosicion($patente);
        if ($info[0]['estado'] == 2)
            $info[0]['posicion_actual'] = $posicion[0]['posicion_actual'];
        $data['posicion'] = $posicion[0]['posicion_actual'];
        $data['mapa'] = true;
        $data['info'] = $info[0];
        echo $this->render->render("views/informe.pug", $data);
    }

    public function procesar()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
        $datos = $_POST;
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
        $data['celulares'] = $this->modelo->getCelulares();
        echo $this->render->render("views/viaje.pug", $data);
    }

    public function consultar()
    {
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje'] = null;
        }
        $this->controlAccesoChofer();
        $data['cabeceras'] = ['Código', 'Fecha', 'Localidad de Origen', 'Localidad de Destino', 'Estado', 'Patente del vehiculo', 'Patente del arrastre', 'Dni del chofer'];
        if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
            if (isset($_GET['cuit'])) {
                $cuit = $_GET['cuit'];
                $data['listado'] = $this->modelo->getViajesCliente($cuit);
            } else
                $data['listado'] = $this->modelo->getViajes();
            $data['botones'] = true;
            $data['noEliminar'] = true;
        } else {
            if (isset($_SESSION['chofer']['vehiculo_asignado'])) {
                $patente = $_SESSION['chofer']['vehiculo_asignado'];
                $data['listado'] = $this->modelo->getViajesPorVehiculo($patente);
            } else
                $data['listado'] = [];
        }
        $data['titulo_listado'] = "viajes";
        $data['sector'] = "Viaje";
        $data['datoPrincipal'] = "codigo";
        echo $this->render->render("views/listas.pug", $data);
    }

    private function controlInforme()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 && $_SESSION['rol'] != 4 || !isset($_GET['codigo'])) {
            header("location:../index");
            die();
        }
    }

    private function controlAccesoChofer()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 && $_SESSION['rol'] != 4) {
            header("location:../index");
            die();
        }
    }

    public function reportar()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 4 || !isset($_GET['codigo'])) {
            header("location:../index");
            die();
        }
        $data['codigo'] = $_GET['codigo'];
        $data['conceptos']=$this->modelo->getConceptos();
        echo $this->render->render("views/cargaDatos.pug", $data);
    }

    public function procesarReporte()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 4) {
            header("location:../index");
            die();
        }
        $datos = $_POST;
        $codigo = $datos['codigo'];
        $resultado = $this->modelo->getPatente($codigo);
        $datos['patente'] = $resultado[0]['patente_vehiculo'];
        if ($this->modelo->registrarReporte($datos)) {
            header("location:confirmacion");
        }
        else {
            header("location:reportar?codigo=".$codigo);
        }

    }
}