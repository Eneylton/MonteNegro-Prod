<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Devolucao;
use App\Entidy\Entrega;
use App\Entidy\EntregaDevolucao;
use App\Entidy\Retorno;

$calculado = 0;
$qtd_retorno = 0;
$calculo = 0;
$calculo2 = 0;
$calculo3 = 0;
$soma = 0;
$soma2 = 0;
$producao_id = 0;
$entregador_id = 0;
$qtd_producao = 0;

if (isset($_GET['id'])) {


    $producao_id    = $_GET['producao_id'];
    $entregador_id  = $_GET['entregadores_id'];
    $qtd_producao   = $_GET['entreque'];
    $gaiolas_id     = $_GET['gaiolas_id'];
    $boletos_id     = $_GET['boletos_id'];

    date_default_timezone_set('America/Sao_Paulo');
    $hoje = date("Y-m-d H:i:s");

    $result = Retorno::getID('*', 'retorno', $_GET['id'], null, null);
    $qtd_retorno = $result->qtd;
    $calculo = ($qtd_retorno - $qtd_producao);
    if ($calculo == 0) {
        $result->qtd =  $calculo;
        $result->data = $_GET['data'];
        $result->status = 1;
        $result->boletos_id = $boletos_id;
        $result->atualizar();
    } else {
        $result->qtd =  $calculo;
        $result->data = $_GET['data'];
        $result->status = 0;
        $result->boletos_id = $boletos_id;
        $result->atualizar();
    }

    $item = new Entrega;

    $item->data                        = $_GET['data'];
    $item->qtd                         = $qtd_producao;
    $item->producao_id                 = $producao_id;
    $item->entregadores_id             = $entregador_id;
    $item->boletos_id                  = $boletos_id;

    $item->cadastar();

    $dev = Devolucao::getIDProducao('*', 'devolucao', $producao_id, null, null);
    $dev_id = $dev->id;
    $excluirdev = Devolucao::getID('*', 'devolucao', $dev_id, null, null);
    if ($excluirdev != false) {
        $excluirdev->excluir();
    }

    $entregdev = EntregaDevolucao::getBoletosID('*', 'entrega_devolucao', $boletos_id, null, null);

    $devcalculo2 = $entregdev->entrega;
    $calculo3 = ($devcalculo2 + $qtd_producao);

    $entregdev->data                        = $_GET['data'];
    $entregdev->devolucao                   = 0;
    $entregdev->entrega                     = $calculo3;
    $entregdev->producao_id                 = $producao_id;
    $entregdev->entregadores_id             = $entregador_id;
    $entregdev->boletos_id                  = $boletos_id;

    $entregdev->atualizar();

    header('location: retorno-list.php');

    exit;
}