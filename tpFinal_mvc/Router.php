<?php


class Router
{
    private $configuration;

    public function __construct($configuration)
    {
        $this->configuration=$configuration;
    }

    public function executeActionFromModule($action, $module)
    {
        $controller=$this->getControllerFrom($module);
        $this->executeMethodFromController($controller,$action);
    }

    private function executeMethodFromController($controller, $action)
    {
        $valid
    }


}