<?php

session_start();
include_once "helper/Configuration.php";


$configuration=new Configuration();

$module=$_GET['module'] ?? "index";
$action=$_GET['action'] ?? "execute";

$router=$configuration->getRouter();
$router->executeActionFromModule($action,$module);