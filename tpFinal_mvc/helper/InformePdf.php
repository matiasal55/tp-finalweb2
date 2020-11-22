<?php

require_once 'helper/PDFConfig.php';

class InformePdf
{
    private $pdf;

    public function __construct()
    {
        $this->pdf=new PDFConfig();
    }

    public function render($content,$codigo){
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial','',11);
        foreach ($content as $dato)
            $this->pdf->Cell(40,10,$dato,1,1);
        $this->pdf->Ln(20);
        $this->pdf->Image("views/qr/viaje_".md5($codigo).".png",null,null,30);
        return $this->pdf->Output();
    }


}