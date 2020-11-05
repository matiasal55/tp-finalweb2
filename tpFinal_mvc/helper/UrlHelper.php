<?php


class UrlHelper
{
    public function getModule($default){
        return isset($_GET['module']) ? $_GET['module'] : $default;
    }

    public function getAction($default){
        return isset($_GET['action']) ? $_GET['action'] : $default;
    }
}