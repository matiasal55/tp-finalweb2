<?php


class ProformaController
{
    private $modelo;
    private $render;
    private $pdf;
    private $genQR;

    public function __construct($modelo, $render,$pdf,$qr)
    {
        $this->modelo = $modelo;
        $this->render = $render;
        $this->pdf=$pdf;
        $this->genQR=$qr;
    }

//    public function consultar(){
//        if(isset($_SESSION['mensaje'])) {
//            $data['mensaje'] = $_SESSION['mensaje'];
//            $_SESSION['mensaje']=null;
//        }
//        $data['cabeceras']=['Número','Origen','Destino','Fecha de carga','ETA','Kilometraje actual','Kilometraje total','Posicion actual','Estado'];
//        $data['listado']=$this->modelo->getVehiculos();
//        $data['titulo_listado']="vehículos";
//        $data['sector']="Vehículo";
//        $data['datoPrincipal']="patente";
//        echo $this->render->render("views/listas.pug",$data);
//    }

    public function nuevo()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
        $data['vehiculos'] = $this->modelo->getVehiculos();
        $data['arrastres'] = $this->modelo->getArrastres();
        $data['choferes'] = $this->modelo->getChoferes();
        echo $this->render->render("views/proforma.pug", $data);
    }

    public function informe(){
        $proforma=$_GET['numero'];
        $resultado=$this->modelo->getProforma($proforma);
        $data['info']=$resultado[0];
        $data['qr']=md5($proforma);
        echo $this->render->render("views/pdf_template.pug",$data);
    }

    public function pdf(){
        $proforma=$_GET['numero'];
        $resultado=$this->modelo->getProforma($proforma);
        return $this->pdf->render($resultado[0],$proforma);
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
            if ($this->modelo->registrar($datos)) {
                $this->genQR->generarQR();
                $_SESSION['mensaje'] = "Los datos han sido agregados correctamente";
            }
            else
                $_SESSION['mensaje'] = "Hubo un error en la carga de datos";
        }

        var_dump($_SESSION['mensaje']);
    }

    public function eliminar(){
        $numero = $_GET['numero'];
        $viaje=$_GET['viaje'];
        if($this->modelo->deleteProforma($numero,$viaje))
            $_SESSION['mensaje']="La proforma se eliminó correctamente";
        else
            $_SESSION['mensaje']="La proforma no se pudo eliminar";
        header("location:consultar");
    }

    public function execute()
    {
        header("location: nuevo");
    }
}