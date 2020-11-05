<?php

include_once "../models/UsuariosModel.php";
include_once "./MySqlDatabase.php";
include_once "./UrlHelper.php";

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
        return parse_ini_file("../config/config.ini");
    }

    public function getUrlHelper(){
        return new UrlHelper();
    }

    public function getRouter()
    {
        return new Router($this);
    }
}