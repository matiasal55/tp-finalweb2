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
        $data['vehiculos'] = $this->modelo->getVehiculos();
        $data['arrastres'] = $this->modelo->getArrastres();
        $data['choferes'] = $this->modelo->getChoferes();
        $data['celulares'] = $this->modelo->getCelulares();
        $data['clientes'] = $this->modelo->getClientes();
        $data['datoPrincipal']="numero";
        echo $this->render->render("views/proforma.pug", $data);
    }

    public function consultar()
    {
        if (isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje'] = null;
        }
        $this->controlAcceso();
        $data['cabeceras'] = ['Número', 'Fecha emision', 'Fee previsto', 'Cuit cliente', 'Cod viaje', 'Fee total', 'Codigo', 'Fecha viaje', 'ETA', 'Direccion origen', 'Localidad origen', 'Provincia origen', 'Pais origen', 'Direccion destino', 'Localidad destino', 'Provincia destino', 'Pais destino', 'Tipo carga', 'Peso neto', 'Imo class', 'Temperatura', 'km estimados', 'Combustible previsto', 'Hazard previsto', 'Reefer previsto', 'Patente_vehiculo', 'Patente arrastre', 'Dni chofer', 'Estado', 'Desviaciones', 'Km totales', 'Eta real', 'Combustible total', 'Hazard total', 'Reefer total'];
        $data['listado'] = $this->modelo->getProformas();
        $data['titulo_listado'] = "proformas";
        $data['sector'] = "Proforma";
        $data['datoPrincipal'] = "numero";
        $data['botones'] = true;
        $data['botonNuevo'] = true;
        if($_SESSION['rol']==2){
            $data['noEliminar']=true;
        }
        echo $this->render->render("views/listas.pug", $data);
    }

    public function informe()
    {
        $this->controlAcceso();
        $proforma = $_GET['numero'];
        $resultado = $this->modelo->getProforma($proforma);
        $data['info'] = $resultado[0];
        $data['qr'] = md5($proforma);
        $data['titulo_listado'] = "proforma";
        echo $this->render->render("views/informe.pug", $data);
    }

    public function generar()
    {
        $this->controlEdicion();
        $proforma = $_GET['numero'];
        $this->pdf->render($proforma);
    }

    public function pdf(){
        if(!isset($_GET['numero'])){
            header("location:../index");
            die();
        }
        $proforma=$_GET['numero'];
        $resultado=$this->modelo->getProforma($proforma);
        $data['info']=$resultado[0];
        $data['qr']=md5($proforma);
        echo $this->render->render("views/pdf_template.pug",$data);
    }

    public function editar()
    {
        $this->controlEdicion();
        $codigo = $_GET['numero'];
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

    private function controlAcceso(){
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
    }

    private function controlEdicion(){
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 || !isset($_GET['numero'])) {
            header("location:../index");
            die();
        }
    }
}