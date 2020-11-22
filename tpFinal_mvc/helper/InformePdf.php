<?php

require_once "third_party/dompdf/dompdf/autoload.inc.php";
use Dompdf\Dompdf;
use Dompdf\Options;

class DomPdf
{
    public function __construct()
    {
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $options->setDefaultFont('sans-serif');
        $options->setIsHtml5ParserEnabled(true);
        $options->setChroot("./");
        $dompdf = new Dompdf($options);
        $contxt = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed'=> TRUE
            ]
        ]);
        $dompdf->setHttpContext($contxt);
    }

    public function render($content){
        $codigo=file_get_contents($content);
        $dompdf->loadHtml($codigo);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    }
}