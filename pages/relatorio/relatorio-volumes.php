<?php

require __DIR__ . '../../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf();
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);

ob_start();
date_default_timezone_set('America/Sao_Paulo');
$data =  date("Y-m-d H:i:s");



if ($_GET['dataInicio'] != "") {
    $inicio = $_GET['dataInicio'];
} else {
    $inicio = $data;
}

if ($_GET['dataFim'] != "") {
    $fim = $_GET['dataFim'];
} else {
    $fim = $data;
}

if (isset($_GET['entregador_id'])) {
    $entregador = $_GET['entregador_id'];
} else {
    $entregador = null;
}

require __DIR__ . "/relatorio24-pdf.php";

$dompdf->loadHtml(ob_get_clean());

// echo $pdf;

$dompdf->setPaper("A4");

$dompdf->render();

$dompdf->stream("producao.pdf", ["Attachment" => false]);