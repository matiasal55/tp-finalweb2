<?php


class VehiculoController
{
    private $modelo;
    private $render;

    public function __construct($modelo,$render)
    {
        $this->modelo=$modelo;
        $this->render=$render;
    }

    public function nuevo(){
        $data['marcas']=$this->modelo->getMarcas();
        $data['modelos']=$this->modelo->getModelos();
        $data['accion']="Agregar";
        echo $this->render->render("views/vehiculo.pug",$data);
    }

    public function procesar(){
        $datos=[
          "patente"=>$_POST['patente'],
          "marca"=>intval($_POST['marca']),
          "modelo"=>intval($_POST['modelo']),
          "anio_fabricacion"=>intval($_POST['anio_fabricacion']),
          "chasis"=>$_POST['chasis'],
          "motor"=>$_POST['motor']
        ];
        if(isset($_POST['km_total'])){
            $datos['km_total']=intval($_POST['km_total']);
            if($this->modelo->registrar($datos))
                $_SESSION['mensaje']="Los datos han sido agregados correctamente";
            else
                $_SESSION['mensaje']="Hubo un error en la carga de datos";
        }
        else {
            if($this->modelo->editVehiculo($datos))
                $_SESSION['mensaje']="Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje']="Hubo un error en la edición de datos";
        }
        header("location:consultar");
    }

    public function consultar(){
        if(isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje']=null;
        }
        $data['cabeceras']=['Patente','Marca','Modelo','Año','Chasis','Motor','Kilometraje actual','Kilometraje total','Posicion actual','Estado'];
        $data['listado']=$this->modelo->getVehiculos();
        $data['titulo_listado']="vehículos";
        $data['sector']="Vehículo";
        $data['datoPrincipal']="patente";
        echo $this->render->render("views/listas.pug",$data);
    }

    public function editar(){
        if(!isset($_GET['patente'])){
            header("location: consultar");
            die();
        }
        $patente=$_GET['patente'];
        $info=$this->modelo->getVehiculo($patente);
        $data['info']=$info[0];
        $data['marcas']=$this->modelo->getMarcas();
        $data['modelos']=$this->modelo->getModelos();
        $data['accion']="Editar";
        echo $this->render->render("views/vehiculo.pug",$data);
    }

    public function eliminar(){
        $patente=$_GET['patente'];
        if($this->modelo->deleteVehiculo($patente))
            $_SESSION['mensaje']="El vehículo se eliminó correctamente";
        else
            $_SESSION['mensaje']="El vehículo no se pudo eliminar";
        header("location:consultar");
    }

    public function execute(){
        header("location:consultar");
    }

}