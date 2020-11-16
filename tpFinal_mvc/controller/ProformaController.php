<?php


class ProformaController
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
        if (isset($_SESSION['iniciada']))
            echo $this->render->render("views/proforma.pug");
        else {
            $data['error'] = "Para acceder al sistema debe loguearse";
            echo $this->render->render("views/login.pug", $data);
        }
    }

   /*metodo para buscarl el cliente
   public function buscar($cuit)
    {
        if (isset($_POST['buscar']) && $_POST['cuit_cliente'] != "") {
            $buscar = $_POST['cuit_cliente'];
            $sql = "SELECT * FROM Cliente  WHERE CUIT = '$buscar'";
            $result = $this->query($sql) or die;
            if ($result->num_rows == 0) {
                $sql = "SELECT * FROM Cliente";
                $result = $this->query($sql) or die;
                echo "<h2 class='text-center mt-3 p-5'>Cliente no encontrado</h2>";
            }
        }
    }*/
    //  el formulario para agregar,
    public function nuevo()
    {
        $data['accion'] = "Agregar";
        echo $this->render->render("views/cliente.pug", $data);
    }
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
        echo $this->render->render("views/listadoCliente.pug",$data);
    }
}