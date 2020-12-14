<?php
require_once "third-party/QRCode/phpqrcode.php";

class CodigoQR
{
    public function generarQR($codigo){
        $direccion="http://".$_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF'])."/viaje/confirmar?codigo=".$codigo;
        $filename="views/qr/proforma_".md5($codigo).".png";
        QRcode::png($direccion, $filename, 'L', 16, 0);
        return $filename;
    }
}