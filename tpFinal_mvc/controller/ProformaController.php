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
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
        $data['datoPrincipal'] = "numero";
        $data['vehiculos'] = $this->modelo->getVehiculos();
        $data['arrastres'] = $this->modelo->getArrastres();
        $data['choferes'] = $this->modelo->getChoferes();
        $data['datoPrincipal']="numero";
        echo $this->render->render("views/proforma.pug", $data);
    }

    public function consultar()
    {
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje'] = null;
        }
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 2 && $_SESSION['rol'] != 4) {
            header("location:../index");
            die();
        }
<<<<<<< HEAD
        $data['cabeceras'] = ['Número', 'Fecha emision', 'Fee previsto', 'Cuit cliente', 'Cod viaje', 'Fee total', 'Codigo', 'Fecha viaje', 'ETA', 'Direccion origen', 'Localidad origen', 'Provincia origen', 'Pais origen', 'Direccion destino', 'Localidad destino', 'Provincia destino', 'Pais destino', 'Tipo carga', 'Peso neto', 'Imo class', 'Temperatura', 'km estimados', 'Combustible previsto', 'Hazard previsto', 'Reefer previsto', 'Patente_vehiculo', 'Patente arrastre', 'Dni chofer', 'Estado', 'Desviaciones', 'Km totales', 'Eta real', 'Combustible total', 'Hazard total', 'Reefer total'];
        $data['listado'] = $this->modelo->getProformas();
        $data['titulo_listado'] = "proformas";
        $data['sector'] = "Proforma";
        $data['datoPrincipal'] = "codigo";
=======
        $data['cabeceras']=['Número','Fecha emision','Fee previsto','Cuit cliente','Cod viaje','Fee total','Codigo','Fecha viaje','ETA','Direccion origen','Localidad origen','Provincia origen','Pais origen','Direccion destino','Localidad destino','Provincia destino','Pais destino','Tipo carga','Peso neto','Imo class','Temperatura','km estimados','Combustible previsto','Hazard previsto','Reefer previsto','Patente_vehiculo','Patente arrastre','Dni chofer','Estado','Desviaciones','Km totales','Eta real','Combustible total','Hazard total','Reefer total'];
        $data['listado']=$this->modelo->getProformas();
        $data['titulo_listado']="proformas";
        $data['sector']="Proforma";
        $data['datoPrincipal']="numero";
>>>>>>> cc7a10fdcdcef2e47e0a2bfad26662d4632a94ec
        $data['botones'] = true;
        $data['botonNuevo'] = true;
        echo $this->render->render("views/listas.pug", $data);
    }

    public function informe()
    {
        $proforma = $_GET['numero'];
        $resultado = $this->modelo->getProforma($proforma);
        $data['info'] = $resultado[0];
        $data['qr'] = md5($proforma);
        $data['titulo_listado'] = "proforma";
        echo $this->render->render("views/informe.pug", $data);
    }
    public function generar()
    {
        $proforma = $_GET['numero'];

        $resultado = $this->modelo->getProforma($proforma);
        $data['info'] = $resultado[0];
        $data['qr'] = md5($proforma);
        $data['titulo_listado'] = "proforma";
        echo $this->render->render("views/informe.pug", $data);
    }

    public function pdf()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
        $proforma = $_GET['numero'];
        $resultado = $this->modelo->getProforma($proforma);
        $data['info']=$resultado[0];
        $data['qr'] = md5($proforma);
        echo $this->render->render("views/pdf_template.pug", $data);
    }

    public function editar()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
        $codigo = $_GET['codigo'];
        $info = $this->modelo->getProforma($codigo);
        $data['info'] = $info[0];
        $data['accion'] = "Editar";
        $data['vehiculos'] = $this->modelo->getVehiculos();
        $data['arrastres'] = $this->modelo->getArrastres();
        $data['choferes'] = $this->modelo->getChoferes();
        $data['editar'] = true;
        echo $this->render->render("views/proforma.pug", $data);
    }

    public function procesar()
    {
        $datos = $_POST;
        if (isset($_POST['proforma_numero'])) {
            if ($this->modelo->editProforma($datos))
                $_SESSION['mensaje'] = "Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la edición de datos";
        } else {
<<<<<<< HEAD
            $codigo = $this->modelo->registrar($datos);
            if ($codigo) {
                $this->genQR->generarQR($codigo);
                header("location:informe?numero=" . $codigo);
                die();
            } else {
=======
            $codigo=$this->modelo->registrar($datos);
            if ($codigo) {
                $this->genQR->generarQR($codigo);
                header("location:informe?numero=".$codigo);
                die();
            }
            else {
>>>>>>> cc7a10fdcdcef2e47e0a2bfad26662d4632a94ec
                header("location:nuevo");
                die();
            }
        }
    }

    public function eliminar()
    {
        $numero = $_GET['numero'];
        $viaje = $_GET['viaje'];
        if ($this->modelo->deleteProforma($numero, $viaje))
            $_SESSION['mensaje'] = "La proforma se eliminó correctamente";
        else
            $_SESSION['mensaje'] = "La proforma no se pudo eliminar";
        header("location:consultar");
    }

    public function execute()
    {
        header("location: nuevo");
    }
}