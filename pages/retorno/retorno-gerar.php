<?php 

require __DIR__.'../../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf();
$options = new Options();
$options->set('isRemoteEnabled', true);
$options-> set ('isHtml5ParserEnabled', true);

ob_start();


if(isset($_GET['dataInicio'])){

    $dataFim = $_GET['dataFim'];
    $dataInicio = $_GET['dataInicio'];
    $entregadores_id = $_GET['entregadores_id'];
    $ocorrencias_id = $_GET['ocorrencias_id'];
    $tipo_id = $_GET['tipo_id'];
    $gaiolas_id = $_GET['gaiolas_id'];
}

require __DIR__."/retorno-pdf.php";

$dompdf->loadHtml(ob_get_clean());

// echo $pdf;

$dompdf->setPaper("A4");

$dompdf->render();

$dompdf->stream("devolucao.pdf", ["Attachment"=> false]);


