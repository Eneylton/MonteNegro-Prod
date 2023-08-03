<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Boleto;
use App\Entidy\Entrega;
use App\Entidy\EntregaDevolucao;
use App\Entidy\Gaiola;
use App\Entidy\Producao;
use App\Entidy\Receber;
use App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();
$qtd_producao = 0;
$calculo = 0;
$receber_id = 0;
$qtd = 0;
$qtd_atual = 0;
$qtd_total = 0;
$entregador_id = 0;
$gaiolas_id = 0;
$gaiolas_qtd = 0;
$gaiolas_total = 0;
$param_id = 0;

$resultado_busca = Producao::getID('*', 'producao', $_POST['producao_id'], null, null);

$param_id = $resultado_busca->qtd;

$condicao = Producao::getMaiorValor($_POST['qtd'], $param_id);

if ($condicao == true) {

    header('location: ../producao/producao-list.php?status=condicao');
    exit;
}

if (isset($_POST['qtd'])) {

    $qtd_producao = $_POST['qtd'];

    $receber_id = $_POST['receber_id'];

    $value = Producao::getID('*', 'producao', $_POST['producao_id'], null, null, null);

    $qtd = $value->qtd;
    $entregador_id = $value->entregadores_id;

    $calculo = ($qtd - $_POST['qtd']);

    $result = Producao::getID('*', 'producao', $_POST['producao_id'], null, null, null);
    $receberID = $result->receber_id;
    $prd_param = $result->id;

    $cadboletos = new Boleto;
    $cadboletos->codigo = 7847548;
    $cadboletos->ocorrencias_id = 18;
    $cadboletos->receber_id = $receberID;
    $cadboletos->cadastar();

    $boletos_id = $cadboletos->id;

    if ($calculo == 0) {

        $value->qtd    = $calculo;
        $value->status = 2;
        $value->atualizar();
    } else {
        $value->qtd    = $calculo;
        $value->status = 1;
        $value->atualizar();
    }

    $item = new Entrega;

    $item->data                        = $_POST['data'];
    $item->qtd                         = $_POST['qtd'];
    $item->producao_id                 = $_POST['producao_id'];
    $item->boletos_id                  = $boletos_id;
    $item->entregadores_id             = $_POST['entregadores_id'];
    $item->cadastar();

    $entrega_id = $item->id;

    $res = Receber::getID('*', 'receber', $receber_id, null, null);


    $item2 = new EntregaDevolucao;
    $item2->data                        = $_POST['data'];
    $item2->entrega                     = $_POST['qtd'];
    $item2->devolucao                   = 0;
    $item2->producao_id                 = $_POST['producao_id'];
    $item2->entregadores_id             = $_POST['entregadores_id'];
    $item2->boletos_id                  = $boletos_id;
    $item2->receber_id                  = $receber_id;


    $item2->cadastar();


    $gaiolas_id = $res->gaiolas_id;

    $result = Gaiola::getID('*', 'gaiolas', $gaiolas_id, null, null);
    $gaiolas_qtd = $result->qtd;

    $gaiolas_total = ($gaiolas_qtd -  $qtd_producao);
    $result->qtd = $gaiolas_total;
    $result->atualizar();

    header('location: ../producao/producao-list.php?status=success');
    exit;
}