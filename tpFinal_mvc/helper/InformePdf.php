<?php

//require_once 'helper/PDFConfig.php';
require 'third-party/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

class InformePdf
{
    private $pdf;

    public function __construct()
    {
//        $this->pdf=new PDFConfig();
        $this->pdf=new Html2Pdf("P",'A4','es');
    }

    public function render($content,$numero){
        $ruta="http://".$_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF'])."/proforma/informe?numero=".$numero;
        $codigo=file_get_contents($ruta);
        $this->pdf->writeHTML($codigo);
        $this->pdf->output("proforma_".md5($numero).".pdf","D");
//        $this->pdf->AddPage();
//        $this->pdf->SetFont('Arial','',11);
//        foreach ($content as $dato)
//            $this->pdf->Cell(40,5,$dato,1,1);
//        $this->pdf->Ln(20);
//        $this->pdf->Image("views/qr/viaje_".md5($codigo).".png",null,null,30);
//        return $this->pdf->Output("proforma_".$codigo.".pdf","I");
    }


}