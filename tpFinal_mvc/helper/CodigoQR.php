<?php
require_once "third-party/QRCode/phpqrcode.php";

class CodigoQR
{
    public function generarQR($codigo){
        $direccion="http://www.google.com";
        $filename="views/qr/viaje_".md5($codigo).".png";
        QRcode::png($direccion, $filename, 'L', 16, 0);
        return $filename;
    }
}