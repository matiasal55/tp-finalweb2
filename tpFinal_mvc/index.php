<?php

// localhost/mapa => localhost/index.php?module=mapa&action=execute

include_once "./helper/Configuration.php";

$configuration=new Configuration();

$urlHelper=$configuration->getUrlHelper();
$module=$urlHelper->getModule("login");
$action=$urlHelper->getAction("execute");

$router=$configuration->getRouter();
$router->executeActionFromModule($action,$module);


//include_once "./helper/Render.php";
//
//$render=new Render();
//
//if(!isset($_GET['pagina'])){
//    echo $render->render("./views/login.pug");
//    exit();
//}
//
//$pagina=$_GET['pagina'];
//
//switch ($pagina){
//    case "registro":{
//        echo $render->render("./views/registro.pug");
//        break;
//    }
//    case "home":{
//        echo $render->render("./views/home.pug");
//        break;
//    }
//    case "proforma":{
//        echo $render->render("./views/proforma.pug");
//        break;
//    }
//    case "mapa":{
//        echo $render->render("./views/mapa.pug");
//        break;
//    }
//    case "registrar":{
//        echo $render->render("./views/registrar.pug");
//    }
//}
