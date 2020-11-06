<?php


class ProformaController
{
    private $render;

    public function __construct($render)
    {
        $this->render=$render;
    }

    public function execute(){
        echo $this->render->render("views/proforma.pug");
    }
}