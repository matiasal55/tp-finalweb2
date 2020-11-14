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

    // Renderiza el formulario. Le pasa el título de la acción
    // Al ser un único diseño de formulario, se usa para agregar o editar
    // Como hice en la Pokedex
    public function nuevo(){
        // Para el Select de Marcas
        $data['marcas']=$this->modelo->getMarcas();
        // Para el Select de Modelos
        $data['modelos']=$this->modelo->getModelos();
        // Accion= agregar o editar. En este caso Agregar
        $data['accion']="Agregar";
        echo $this->render->render("views/vehiculo.pug",$data);
    }

    // Aca se agrega o se edita. En este caso va a depender de
    // si existe la variable de Kilometraje, que aparece nomas cuando se agrega
    // un vehiculo. Cuando se edita un vehículo los kilometros no se tocan.
    // El km actual varia de acuerdo a los datos que le va a pasar el chofer
    public function procesar(){
        $datos=[
          "patente"=>$_POST['patente'],
          "marca"=>intval($_POST['marca']),
          "modelo"=>intval($_POST['modelo']),
          "chasis"=>$_POST['chasis'],
          "motor"=>$_POST['motor']
        ];
        // Si existe km total, es porque es un vehiculo nuevo
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

    // Lista todos los vehiculos
    public function consultar(){
        // Si existe el mensaje, lo guarda en la variable para luego mandarlo al render
        // Despues, a diferencia del login, no destruye la sesión sino que
        // pone esa variable en null. Sino tira un undefinex o queda el mensaje viendose
        if(isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje']=null;
        }
        // Cabeceras de la tabla
        $data['cabeceras']=['Patente','Marca','Modelo','Chasis','Motor','Kilometraje actual','Kilometraje total','Posicion actual','Estado'];
        // Lista de vehiculos
        $data['listado']=$this->modelo->getVehiculos();
        // Titulo de la lista
        $data['titulo_listado']="vehículos";
        // Nombre de la tabla
        $data['sector']="Vehículo";
        // Para mandar al GET para editar o eliminar. EJ: eliminar?patente=AB153QV
        $data['datoPrincipal']="patente";
        echo $this->render->render("views/listas.pug",$data);
    }

    // Renderiza el formulario, esta vez para editar
    // vehiculo/editar?patente=....
    public function editar(){
        // Patente por get
        $patente=$_GET['patente'];
        // Informacion del vehiculo para insertarse en el formulario
        $info=$this->modelo->getVehiculo($patente);
        // Resultado que voy a renderizar. Posicion 0 ya que getVehiculo devuelve un array
        $data['info']=$info[0];
        // Para el select
        $data['marcas']=$this->modelo->getMarcas();
        $data['modelos']=$this->modelo->getModelos();
        // Accion principal, para que vaya en el titulo y en el boton
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
}