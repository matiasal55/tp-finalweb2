<?php

require 'third-party/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

class InformePdf
{
    private $pdf;

    public function __construct()
    {
     $this->pdf=new Spipu\Html2Pdf\Html2Pdf("P",'A4','es');

    }

    public function render($numero){
        $ruta="http://".$_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF'])."/proforma/pdf?numero=".$numero;
        $codigo=file_get_contents($ruta);
        $this->pdf->writeHTML($codigo);
        $this->pdf->output("proforma_".md5($numero).".pdf","I");
    }
}