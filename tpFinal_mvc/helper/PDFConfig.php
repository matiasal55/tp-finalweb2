<?php

require_once 'third-party/fpdf/fpdf.php';

class PDFConfig extends FPDF
{
    function Header()
    {
        $this->Image('views/imagenes/logoMatanza.png',10,8,33);
        $this->SetFont('Arial','B',12);
        $this->Cell(40);
        $this->Cell(30,10,'Title',0,1,'L');
        $this->Ln(30);
    }
}