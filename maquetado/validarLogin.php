<?php
require_once "helper/MySqlDatabase.php"; //linkear bien
session_start();
error_reporting(0);

$email = $_POST['email'];
$password = $_POST['pass'];


$consulta = "SELECT * from usuarios where email='$email' and password='$password'";
$result = mysqli_query($con,$consulta);

$filas = mysqli_fetch_array($result);
if($filas){

    $_SESSION['logueado']=1;

    $_SESSION['email'] = $email;
    header("Location:index.php");
    exit();
}else {
        echo"<h1>'Error en la autentificacion'</h1>";
    }
?>