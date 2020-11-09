<?php


class Router
{
    private $configuration;

    public function __construct($configuration){
        $this->configuration=$configuration;
    }

    public function executeActionFromModule($action, $module){
        $controller=$this->getControllerFrom($module);
        $this->executeMethodFromController($controller,$action);
    }
    // FINAL
    private function executeMethodFromController($controller, $method){
        $validMethod=method_exists($controller,$method) ? $method : "execute";
        call_user_func([$controller,$validMethod]);
    }
    //

    private function getControllerFrom($module)
    {
        $controllerName="get".ucfirst($module)."Controller";
        $validController=method_exists($this->configuration,$controllerName) ? $controllerName : "getIndexController";
        return call_user_func([$this->configuration,$validController]);
        // new Render()
    }




}