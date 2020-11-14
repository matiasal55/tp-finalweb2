<?php


class TallerController
{
    private $modelo;
    private $render;

    public function __construct($modelo,$render)
    {
        $this->modelo=$modelo;
        $this->render=$render;
    }

    // Renderiza el formulario para agregar, no para editar
    public function nuevo(){
        $data['accion']="Agregar";
        echo $this->render->render("views/taller.pug",$data);
    }

    // Lista los talleres
    public function consultar(){
        if(isset($_SESSION['mensaje'])) {
            $data['mensaje'] = $_SESSION['mensaje'];
            $_SESSION['mensaje']=null;
        }
        $data['cabeceras']=['CUIT','Nombre','Dirección','Teléfono'];
        $data['listado']=$this->modelo->getTalleres();
        $data['titulo_listado']="talleres";
        $data['sector']="Taller";
        $data['datoPrincipal']="CUIT";
        echo $this->render->render("views/listas.pug",$data);
    }

    public function editar(){
        $cuit=$_GET['cuit'];
        $info=$this->modelo->getTaller($cuit);
        $data['info']=$info[0];
        $data['accion']="Editar";
        echo $this->render->render("views/taller.pug",$data);
    }

    public function eliminar(){
        $cuit=$_GET['cuit'];
        if($this->modelo->deleteTaller($cuit))
            $_SESSION['mensaje']="El taller se eliminó correctamente";
        else
            $_SESSION['mensaje']="El taller no se pudo eliminar";
        header("location:consultar");
    }


}