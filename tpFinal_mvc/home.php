<?php
include_once "./helper/Render.php";

$render=new Render();
echo $render->render("./views/home.pug");