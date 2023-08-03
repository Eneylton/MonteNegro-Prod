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

if (isset($_POST['relatorios'])) {

    if ($_POST['dataInicio'] != "") {
        $inicio = $_POST['dataInicio'];
    } else {
        $inicio = $data;
    }

    if ($_POST['dataFim'] != "") {
        $fim = $_POST['dataFim'];
    } else {
        $fim = $data;
    }

    if (isset($_POST['cliente_id'])) {
        $cliente = $_POST['cliente_id'];
    } else {
        $cliente = null;
    }

    if (isset($_POST['entregador_id'])) {
        $entregador = $_POST['entregador_id'];
    } else {
        $entregador = null;
    }

    if (isset($_POST['id_param'])) {
        $id_param  = $_POST['id_param'];
    } else {
        $id_param  = null;
    }


    $dompdf = new Dompdf();
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);

    ob_start();

    require __DIR__ . "/relatorio23-pdf.php";

    $dompdf->loadHtml(ob_get_clean());

    // echo $pdf;

    $dompdf->setPaper("A4");

    $dompdf->render();

    $dompdf->stream("producao.pdf", ["Attachment" => false]);
}