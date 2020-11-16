<?php


class ClienteController
{
    private $modelo;
    private $render;

    public function __construct($modelo,$render)
    {
        $this->modelo=$modelo;
        $this->render=$render;
    }
    public function execute(){
        header("location:home");
    }
    // Renderiza el formulario para agregar, no para editar
    public function nuevo(){
        $data['accion']="Agregar";
        echo $this->render->render("views/cliente.pug",$data);
    }

        // Lista los clientes
        public function consultar(){
            if(isset($_SESSION['mensaje'])) {
                $data['mensaje'] = $_SESSION['mensaje'];
                $_SESSION['mensaje']=null;
            }
            $data['cabeceras']=['CUIT','Denominación','Dirección','Teléfono','Email','Contacto 1','Contacto 2'];
            $data['listado']=$this->modelo->getClientes();
            $data['titulo_listado']="Clientes";
            $data['sector']="Cliente";
            $data['datoPrincipal']="CUIT";
            //a(href=`editar?${datoPrincipal.toLowerCase()}=${datos[datoPrincipal]}`);
            echo $this->render->render("views/listadoCliente.pug",$data);
        } /**/

    public function editar(){
        $cuit=$_GET['cuit'];
        $info=$this->modelo->getCliente($cuit);
        $data['info']=$info[0];
        $data['accion']="Editar";
        $data['editar']=true;
        echo $this->render->render("views/cliente.pug",$data);
    }

    public function eliminar(){
        $cuit=$_GET['cuit'];
        if($this->modelo->deleteCliente($cuit))
            $_SESSION['mensaje']="El cliente se eliminó correctamente";
        else
            $_SESSION['mensaje']="El cliente no se pudo eliminar";
        header("location:consultar");
    }

    public function procesar(){
        $datos=[
            "CUIT"=>intval($_POST['CUIT']),
            "denominacion"=>$_POST['denominacion'],
            "direccion"=>$_POST['direccion'],
            "telefono"=>intval($_POST['telefono']),
            "email"=>$_POST['email'],
            "contacto1"=>intval($_POST['contacto1']),
            "contacto2"=>intval($_POST['contacto2'])
        ];
        if(isset($_POST['editar'])){
            if($this->modelo->editCliente($datos))
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
}