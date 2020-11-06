<?php

include_once "models/UsuariosModel.php";
include_once "helper/MySqlDatabase.php";
include_once "helper/UrlHelper.php";
include_once "helper/Render.php";
include_once "controller/IndexController.php";
include_once "Router.php";
include_once "controller/HomeController.php";
include_once "controller/ProformaController.php";

class Configuration
{
    public function getUsuariosModel(){
        $database=$this->getDatabase();
        return new UsuariosModel($database);
    }

    private function getDatabase(){
        $config=$this->getConfig();
        return new MySqlDatabase($config['host'],$config['user'],$config['password'],$config['database'],$config['port']);
    }

    private function getConfig()
    {
        return parse_ini_file("config/config.ini");
    }

    public function getUrlHelper(){
        return new UrlHelper();
    }

    public function getRouter()
    {
        return new Router($this);
    }

    public function getIndexController(){
        return new IndexController($this->getRender());
    }

    public function getRegistrarController(){
        return new RegistrarController($this->getRender());
    }
    public function getMapaController(){
        return new MapaController($this->getRender());
    }

    public function getProformaController(){
        return new ProformaController($this->getRender());
    }

    public function getHomeController(){
        return new HomeController($this->getRender());
    }

    private function getRender()
    {
        return new Render();
    }
}