<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Gaiola;
use App\Entidy\Producao;
use App\Entidy\Receber;
use App\Entidy\Retgaiola;
use App\Entidy\Retorno;
use App\Entidy\Rota;
use App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();

$receber_id = 0;
$qtd = 0;
$qtd_atual = 0;
$qtd_total = 0;
$entregador_id = 0;
$gaiolas_id = 0;
$gaiolas_qtd = 0;
$gaiolas_total = 0;
$producaoID = 0;

if (isset($_GET['dev_id']) or !is_numeric($_GET['dev_id'])) {

    $val2 = Retorno::getID('*', 'retorno', $_GET['dev_id'], null, null);

    $producaoID = $val2->producao_id;
    $ocorrenciaID = $val2->ocorrencias_id;

    $val2->status = 1;

    $val2->atualizar();


    if ($_GET['tipo_id'] == 2) {

        $item = new Retgaiola;

        $item->data                        = $_GET['data'];
        $item->qtd                         = $_GET['qtd'];
        $item->status                      = 0;
        $item->producao_id                 = $producaoID;
        $item->tipo_id                     = 2;
        $item->ocorrencias_id              = $ocorrenciaID;
        $item->entregadores_id             = $_GET['entregador_ID'];

        $item->cadastar();

        $value = Rota::getEntregadorID('*', 'rotas', $_GET['entregador_ID'], null, null);

        $gaiolas_id = $value->gaiolas_id;

        $result = Gaiola::getID('*', 'gaiolas', $gaiolas_id, null, null);
        $gaiolas_qtd = $result->qtd;

        $gaiolas_total = ($gaiolas_qtd +  $_GET['qtd']);

        if ($gaiolas_total != 0) {

            $result->qtd = $gaiolas_total;
            $result->atualizar();
        } else {

            $result->qtd = $gaiolas_total;
            $result->atualizar();
        }
    } else {



        $item = new Retgaiola;

        $item->data                        = $_GET['data'];
        $item->qtd                         = $_GET['qtd'];
        $item->status                      = 1;
        $item->producao_id                 = $producaoID;
        $item->tipo_id                     = 1;
        $item->ocorrencias_id              = $ocorrenciaID;
        $item->entregadores_id             = $_GET['entregador_ID'];

        $item->cadastar();

        $result = Producao::getID('*', 'producao', $producaoID, null, null);
        $receberID = $result->receber_id;

        $produt = Receber::getID('*', 'receber', $receberID, null, null);
        $gaiolasID = $produt->gaiolas_id;

        $result = Gaiola::getID('*', 'gaiolas',  $gaiolasID, null, null);
        $gaiolas_qtd = $result->qtd;

        $gaiolas_total = ($gaiolas_qtd +  $_GET['qtd']);



        if ($gaiolas_total != 0) {

            $result->qtd = $gaiolas_total;
            $result->atualizar();
        }
    }

    header('location: retorno-list.php?status=success');
    exit;
}