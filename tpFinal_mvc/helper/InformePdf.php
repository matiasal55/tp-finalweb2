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

    public function informePdf($numero,$seccion){
        $this->pdf->pdf->SetDisplayMode('fullpage');
        $ruta="http://".$_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF'])."/".$seccion."/pdf?numero=".$numero;
        $codigo=file_get_contents($ruta);
        $this->pdf->writeHTML($codigo);
        $this->pdf->output("proforma_".md5($numero).".pdf","I");
    }

    public function listaPdf($seccion){
        $ruta="http://".$_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF'])."/".$seccion."/pdf";
        $codigo=file_get_contents($ruta);
        $this->pdf->writeHTML($codigo);
        $this->pdf->output("proforma_lista.pdf","I");
    }
}