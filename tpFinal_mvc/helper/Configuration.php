<?php

include_once "models/UsuariosModel.php";
include_once "models/TallerModel.php";
include_once "models/VehiculoModel.php";
include_once "models/ProformaModel.php";
include_once "models/MantenimientoModel.php";
include_once "helper/MySqlDatabase.php";
include_once "helper/Render.php";
include_once "controller/IndexController.php";
include_once "Router.php";
include_once "controller/HomeController.php";
include_once "controller/ProformaController.php";
include_once "controller/UsuariosController.php";
include_once "controller/RegistrarController.php";
include_once "controller/MapaController.php";
include_once "controller/LogoutController.php";
include_once "controller/TallerController.php";
include_once "controller/VehiculoController.php";
include_once "controller/MantenimientoController.php";

class Configuration
{
    public function getUsuariosModel(){
        $database=$this->getDatabase();
        return new UsuariosModel($database);
    }

    private function getDatabase(){
        $config=$this->getConfig();
        return new MySqlDatabase($config['host'],$config['user'],$config['password'],$config['database']);
    }

    private function getConfig()
    {
        return parse_ini_file("config/online.ini");
    }

    public function getRouter(){
        return new Router($this);
    }

    public function getIndexController(){
        return new IndexController($this->getRender());
    }

    public function getLogoutController(){
        return new LogoutController($this->getRender());
    }

    public function getMapaController(){
        return new MapaController($this->getRender());
    }

    public function getProformaController(){
        $modelo=$this->getProformaModel();
        return new ProformaController($modelo,$this->getRender());
    }

    public function getHomeController(){
        return new HomeController($this->getRender());
    }

    public function getUsuariosController(){
        $modelo=$this->getUsuariosModel();
        return new UsuariosController($modelo,$this->getRender());
    }

    public function getRegistrarController(){
        return new RegistrarController($this->getRender());
    }

    public function getTallerModel(){
        $database=$this->getDatabase();
        return new TallerModel($database);
    }

    public function getTallerController(){
        $modelo=$this->getTallerModel();
        return new TallerController($modelo,$this->getRender());
    }

    private function getRender(){
        return new Render();
    }

    public function getVehiculoModel(){
        $database=$this->getDatabase();
        return new VehiculoModel($database);
    }

    public function getVehiculoController(){
        $modelo=$this->getVehiculoModel();
        return new VehiculoController($modelo,$this->getRender());
    }

    public function getProformaModel()
    {
        $database=$this->getDatabase();
        return new ProformaModel($database);
    }

    public function getMantenimientoModel(){
        $database=$this->getDatabase();
        return new MantenimientoModel($database);
    }

    public function getMantenimientoController(){
        $modelo=$this->getMantenimientoModel();
        return new MantenimientoController($modelo,$this->getRender());
    }
}