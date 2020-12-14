<?php

include 'third-party/vendor/autoload.php';

class Render
{
    private $pug;

    public function __construct()
    {
        $this->pug = new Pug();
    }

    public function render($content, $data = [])
    {
        if (isset($_SESSION['datos'])) {
            $data['datos'] = $_SESSION['datos'];
        }
        if (isset($_SESSION['rol'])) {
            $data['rol'] = $_SESSION['rol'];
            if ($data['rol'] == 1)
                $data['paginas'] = ['Arrastre', 'Cliente', 'Celulares', 'Mantenimiento',  'Service', 'Usuarios', 'Vehiculo', 'Viaje'];
            else if ($data['rol'] == 2)
                $data['paginas'] = ['Arrastre', 'Cliente', 'Celulares', 'Service', 'Vehiculo', 'Viaje'];
            else if ($data['rol'] == 3)
                $data['paginas'] = ['Mantenimiento', 'Service', 'Vehiculo'];
            else if ($data['rol'] == 4)
                $data['paginas'] = ['Service', 'Mantenimiento', 'Vehiculo', 'Viaje'];
            else
                $data['paginas'] = [];
        }
        return $this->pug->render($content, $data);
    }
}