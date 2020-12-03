<?php

require 'third-party/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

class InformePdf
{
    private $pdf;

    public function __construct()
    {
//        $this->pdf=new Spipu\Html2Pdf\Html2Pdf("P",'A4','es');
        $this->pdf=new \Mpdf\Mpdf(['tempDir'=>'third-party/tmp']);
    }

    public function render($numero){
        $ruta="http://".$_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF'])."/proforma/pdf?numero=".$numero;
        $bootstrap=file_get_contents("https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css");
        $codigo=file_get_contents($ruta);
        $this->pdf->WriteHTML($bootstrap,\Mpdf\HTMLParserMode::HEADER_CSS);
        $this->pdf->WriteHTML($codigo);
        $this->pdf->Output("proforma_".md5($numero).".pdf","I");
    }


}