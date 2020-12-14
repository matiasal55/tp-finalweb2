<?php


class ProformaController
{
    private $modelo;
    private $render;
    private $pdf;
    private $genQR;

    public function __construct($modelo, $render, $pdf, $qr)
    {
        $this->modelo = $modelo;
        $this->render = $render;
        $this->pdf = $pdf;
        $this->genQR = $qr;
    }

    public function nuevo()
    {
        $this->controlAcceso();
        $data['datoPrincipal'] = "numero";
        $data = $this->getEquipo();
        $data['url'] = $this->getUrl();
        echo $this->render->render("views/proforma.pug", $data);
    }

    public function consultar()
    {
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje'] = null;
        }
        $this->controlAcceso();
        $data['cabeceras'] = $this->getCabeceras();
        $data['listado'] = $this->modelo->getProformasInfo();
        $data['titulo_listado'] = "proformas";
        $data['sector'] = "Proforma";
        $data['datoPrincipal'] = "numero";
        $data['botones'] = true;
        $data['botonNuevo'] = true;
        if ($_SESSION['rol'] == 2) {
            $data['noEliminar'] = true;
        }
        echo $this->render->render("views/listas.pug", $data);
    }

    public function costeo()
    {
        $this->controlEdicion();
        $numero = $_GET['numero'];
        $viaje = $this->modelo->getCodigoViaje($numero);
        $viaje = $viaje[0]['cod_viaje'] ?? null;
        $data['listado'] = $this->modelo->getCosteo($viaje);
        $data['titulo_listado'] = "costeo";
        $data['cabeceras'] = ["Código", "Código de viaje", "Número de factura", "Detalles", "Dirección", "Litros de combustible", "Precio", "Conceptos"];
        $data['reportes'] = true;
        $data['acciones'] = true;
        $data['sector'] = "Costeo";
        echo $this->render->render("views/listas.pug", $data);
    }

    public function editar()
    {
        $this->controlEdicion();
        $codigo = $_GET['numero'];
        $info = $this->modelo->getProforma($codigo);
        $data['info'] = $info[0];
        $data['accion'] = "Editar";
        $data = $this->getEquipo();
        $data['editar'] = true;
        $data['url'] = $this->getUrl();
        echo $this->render->render("views/proforma.pug", $data);
    }

    public function eliminar()
    {
        $this->controlEdicion();
        $numero = $_GET['numero'];
        if ($this->modelo->deleteProforma($numero))
            $_SESSION['mensaje'] = "La proforma se eliminó correctamente";
        else
            $_SESSION['mensaje'] = "La proforma no se pudo eliminar";
        header("location:consultar");
    }

    public function execute()
    {
        header("location: consultar");
    }

    public function factura()
    {
        $this->controlAcceso();
        if (isset($_GET['numero'])) {
            $proforma = $_GET['numero'];
            $this->pdf->generarFactura($proforma);
        }
    }

    public function generar()
    {
        $this->controlAcceso();
        if (isset($_GET['numero'])) {
            $proforma = $_GET['numero'];
            $this->pdf->informePdf($proforma, "proforma", "numero");
        } else {
            $this->pdf->listaPdf("proforma");
        }
    }

    public function informe()
    {
        $this->controlAcceso();
        $proforma = $_GET['numero'];
        $resultado = $this->modelo->getProforma($proforma);
        $data['qr'] = md5($proforma);
        $data['titulo_listado'] = "proforma";
        $patente = $resultado[0]['patente_vehiculo'];
        $posicion = $this->modelo->getPosicion($patente);
        if ($resultado[0]['estado'] == 2)
            $resultado[0]['posicion_actual'] = $posicion[0]['posicion_actual'];
        $data['posicion'] = $posicion[0]['posicion_actual'];
        $data['mapa'] = true;
        $data['factura'] = true;
        $data['datoPrincipal'] = "numero";
        $data['info'] = $resultado[0];
        echo $this->render->render("views/informe.pug", $data);
    }


    public function pdf()
    {
        $data['fecha'] = date('d-m-Y');
        if (isset($_GET['numero'])) {
            $proforma = $_GET['numero'];
            $resultado = $this->modelo->getProforma($proforma);
            $data['info'] = $resultado[0];
            $data['qr'] = md5($proforma);
            $data['titulo_listado'] = "Proforma";
            echo $this->render->render("views/pdf_template.pug", $data);
        } else {
            $data['listado'] = $this->modelo->getProformasInfo();
            $data['titulo_listado'] = "proformas";
            $data['estados'] = ["No iniciado", "En viaje", "Finalizado"];
            $data['cabeceras'] = $this->getCabeceras();
            echo $this->render->render("views/pdf_listas.pug", $data);
        }
    }

    public function pdfFactura()
    {
        if (isset($_GET['numero'])) {
            $proforma = $_GET['numero'];
            $resultado = $this->modelo->getProforma($proforma);
            $data['info'] = $resultado[0];
            $data['fecha'] = date('d-m-Y');
            echo $this->render->render("views/detalle.pug", $data);
        }
    }

    public function procesar()
    {
        $this->controlAcceso();
        $datos = $_POST;
        if (isset($_POST['proforma_numero'])) {
            if ($this->modelo->editProforma($datos))
                $_SESSION['mensaje'] = "Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la edición de datos";
        } else {
            $codigo = $this->modelo->registrar($datos);
            if ($codigo) {
                $this->genQR->generarQR($codigo);
                header("location:informe?numero=" . $codigo);
                die();
            } else {
                header("location:nuevo");
                die();
            }
        }
        header("location:consultar");
    }

    private function getEquipo()
    {
        $data['vehiculos'] = $this->modelo->getVehiculos();
        $data['arrastres'] = $this->modelo->getArrastres();
        $data['choferes'] = $this->modelo->getChoferes();
        $data['celulares'] = $this->modelo->getCelulares();
        $data['clientes'] = $this->modelo->getClientes();
        return $data;
    }

    private function getUrl()
    {
        $url = "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);
        return $url;
    }

    private function getCabeceras()
    {
        $cabeceras = ['Número', 'Fecha de emision', 'Cuit del cliente', 'Codigo del viaje', 'Fecha del viaje', 'Localidad de origen', 'Localidad de destino', 'Estado', 'Patente del vehiculo', 'Patente del arrastre', 'Dni del chofer'];
        return $cabeceras;
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
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 || !isset($_GET['numero'])) {
            header("location:../index");
            die();
        }
    }
}