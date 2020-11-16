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

    public function nuevo(){
        $data['accion']="Agregar";
        echo $this->render->render("views/viaje.pug",$data);
    }

    public function procesar(){
        $datos=[
               "fecha"=>intval($_POST['fecha']),
               "direccion_origen"=>$_POST['direccion_origen'],
               "localidad_origen"=>$_POST['localidad_origen'],
               "provincia_origen"=>$_POST['provincia_origen'],
               "pais_origen"=>$_POST['pais_origen'],
               "direccion_destino"=>$_POST['direccion_destino'],
               "localidad_destino"=>$_POST['localidad_destino'],
                "provincia_destino"=>$_POST['provincia_destino'],
                "pais_destino"=>$_POST['pais_destino'],
                "ETA"=>$_POST['ETA'],
                "tipoCarga"=>$_POST['tipoCarga'],
                "peso_neto"=>intval($_POST['peso_neto']),
                "hazard"=>$_POST['hazard'],
                "reefer"=>$_POST['reefer'],
                "imoClass"=>$_POST['imoClass'],
                "temperatura"=>intval($_POST['temperatura'])
        ];

        if(isset($_POST['editar'])){
            if($this->modelo->editViaje($datos))
                $_SESSION['mensaje']="Los datos han sido agregados correctamente";
            else
                $_SESSION['mensaje']="Hubo un error en la carga de datos";
        }
        else {
            if($this->modelo->registrar($datos))
                $_SESSION['mensaje']="Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje']="Hubo un error en la edición de datos";
        }
        header("location:consultar");
    }

    public function editar(){
        if(!isset($_GET['codigo'])){
            header("location: consultar");
            die();
        }
        $codigo=$_GET['codigo'];
        $info=$this->modelo->getViaje($codigo);
        $data['info']=$info[0];
        $data['accion']="Editar";
        $data['editar']=true;
        echo $this->render->render("views/viaje.pug",$data);
    }
    public function detalle(){
        if(isset($_GET['codigo'])){
        $codigo=$_GET['codigo'];
        $info=$this->modelo->getViaje($codigo);
        $data['info']=$info[0];
        $data['datoPrincipal']="codigo";
            echo $this->render->render("views/detalle.pug",$data);
        }
    }
    public function consultar(){
        if(isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje']=null;
        }
        $data['cabeceras']=['Codigo','Fecha','Direccion_origen','Localidad_origen','Provincia_origen','Pais_origen','Direccion_destino','Localidad_destino','Provincia_destino','pais_destino','estado','peso','ETA','km_estimados','km_totales','desviaciones','combustible_previsto','combustible_total','patente_vehiculo','patente_arrastre','dni_chofer'];
        $data['listado']=$this->modelo->getViajes();
        $data['titulo_listado']="viajes";
        $data['sector']="Viaje";
        $data['datoPrincipal']="codigo";
        echo $this->render->render("views/listas.pug",$data);
    }

    public function eliminar(){
        $codigo=$_GET['codigo'];
        if($this->modelo->deleteViaje($codigo))
            $_SESSION['mensaje']="El viaje se eliminó correctamente";
        else
            $_SESSION['mensaje']="Verifique haber borrado primero la proforma relacionada";
        header("location:consultar");
    }

    public function execute(){
        header("location:consultar");
    }
}