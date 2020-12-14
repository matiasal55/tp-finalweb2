<?php


class ViajeController
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
        $data['cabeceras'] = $this->getCabeceras();
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

    public function generar()
    {
        $this->controlAccesoChofer();
        if(isset($_GET['codigo'])){
            $codigo = $_GET['codigo'];
            $this->pdf->informePdf($codigo,"viaje","codigo");
        }
        else {
            $this->pdf->listaPdf("viaje");
        }
    }

    public function pdf(){
        if(isset($_GET['codigo'])) {
            $codigo = $_GET['codigo'];
            $resultado = $this->modelo->getViaje($codigo);
            $data['info'] = $resultado[0];
            $data['fecha']=date('d-m-Y');
            $data['titulo_listado']="Viaje";
            echo $this->render->render("views/pdf_template.pug", $data);
        }
        else {
            $data['listado'] = $this->modelo->getViajes();
            $data['titulo_listado']="Viajes";
            $data['fecha']=date('d-m-Y');
            $data['estados']=["No Iniciado","En Viaje","Finalizado"];
            $data['cabeceras'] = $this->getCabeceras();
            echo $this->render->render("views/pdf_listas.pug",$data);
        }
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
        $data['conceptos'] = $this->modelo->getConceptos();
        echo $this->render->render("views/reporteChofer.pug", $data);


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
            header("location:confirmar?codigo=" . $codigo);
        } else {
            header("location:reportar?codigo=" . $codigo);
        }

    }

    public function confirmar()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 4) {
            header("location:../index");
            die();
        }
        $data['codigo'] = $_GET['codigo'];
        echo $this->render->render("views/confirmacion.pug", $data);

    }

    public function gastos()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 4) {
            header("location:../index");
            die();
        }
        $data['codigo'] = $_GET['codigo'];
        echo $this->render->render("views/listas.pug", $data);

    }

    private function getCabeceras()
    {
        $cabeceras=['Código', 'Fecha', 'Localidad de Origen', 'Localidad de Destino', 'Estado', 'Patente del vehiculo', 'Patente del arrastre', 'Dni del chofer'];
        return $cabeceras;
    }
}