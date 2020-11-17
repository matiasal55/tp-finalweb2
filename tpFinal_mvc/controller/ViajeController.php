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

    public function execute()
    {
        header("location:consultar");
    }

    public function nuevo()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
        $data['accion'] = "Agregar";
        echo $this->render->render("views/viaje.pug", $data);
    }

    public function procesar()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
//        $datos=[
//            "patente"=>$_POST['patente'],
//            "marca"=>intval($_POST['marca']),
//            "modelo"=>intval($_POST['modelo']),
//            "anio_fabricacion"=>intval($_POST['anio_fabricacion']),
//            "chasis"=>$_POST['chasis'],
//            "motor"=>$_POST['motor']
//        ];

        if (isset($_POST['editar'])) {
            if ($this->modelo->editViaje($datos))
                $_SESSION['mensaje'] = "Los datos han sido agregados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la carga de datos";
        } else {
            if ($this->modelo->registrar($datos))
                $_SESSION['mensaje'] = "Los datos han sido editados correctamente";
            else
                $_SESSION['mensaje'] = "Hubo un error en la edición de datos";
        }
        header("location:consultar");
    }

    public function editViaje($datos)
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
        $codigo = $datos['codigo'];
        $fecha = $datos['fecha'];
        $direccion_origen = $datos['direccion_origen'];
        $localidad_origen = $datos['localidad_origen'];
        $provincia_origen = $datos['provincia_origen'];
        $pais_origen = $datos['pais_origen'];
        $direccion_destino = $datos['direccion_destino'];
        $localidad_destino = $datos['localidad_destino'];
        $provincia_destino = $datos['provincia_destino'];
        $pais_destino = $datos['pais_destino'];
        $estado = $datos['estado'];
        $peso = $datos['peso_neto'];
        $ETA = $datos['ETA'];
        $km_estimados = $datos['km_estimados'];
        $desviaciones = $datos['desviaciones'];
        $combustible_previsto = $datos['combustible_previsto'];
        $combustible_total = $datos['combustible_total'];
        $patente_vehiculo = $datos['patente_vehiculo'];
        $patente_arrastre = $datos['patente_arrastre'];
        $dni_chofer = $datos['dni_chofer'];
        $sql = "UPDATE Viaje SET fecha='$fecha',direccion_origen='$direccion_origen',localidad_origen='$localidad_origen',provincia_origen='$provincia_origen',pais_origen='$pais_origen',direccion_destino='$direccion_destino',localidad_destino='$localidad_destino',provincia_destino='$provincia_destino',pais_destino='$pais_destino',peso='$peso',ETA='$ETA' WHERE codigo='$codigo'";
        return $this->database->execute($sql);
    }

    public function detalle()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 2 && $_SESSION['rol']!=4 || !isset($_GET['codigo'])) {
            header("location:../index");
            die();
        }
        $codigo = $_GET['codigo'];
        $info = $this->modelo->getViajeDetalles($codigo);
        $data['info'] = $info;
        $data['datoPrincipal'] = "codigo";
        echo $this->render->render("views/detalle.pug", $data);
    }

    public function editar()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 2 || !isset($_GET['codigo'])) {
            header("location:../index");
            die();
        }
        $codigo = $_GET['codigo'];
        $info = $this->modelo->getViaje($codigo);
        $data['info'] = $info[0];
        $data['accion'] = "Editar";
        $data['editar'] = true;
        echo $this->render->render("views/viaje.pug", $data);
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
        $data['cabeceras'] = ['Código', 'Fecha', 'Localidad_origen', 'Localidad_destino', 'estado', 'patente_vehiculo', 'patente_arrastre', 'dni_chofer'];
        $data['listado'] = $this->modelo->getViajes();
        $data['titulo_listado'] = "viajes";
        $data['sector'] = "Viaje";
        $data['datoPrincipal'] = "codigo";
        $data['botones'] = true;
        $data['botonNuevo'] = true;
        echo $this->render->render("views/listas.pug", $data);
    }

    public function eliminar()
    {
        if (!isset($_SESSION['iniciada']) || $_SESSION['rol'] != 2) {
            header("location:../index");
            die();
        }
        $codigo = $_GET['codigo'];
        if ($this->modelo->deleteViaje($codigo))
            $_SESSION['mensaje'] = "El viaje se eliminó correctamente";
        else
            $_SESSION['mensaje'] = "Verifique haber borrado primero la proforma relacionada";
        header("location:consultar");
    }
}