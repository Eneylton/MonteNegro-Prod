<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Boleto;
use App\Entidy\Devolucao;
use App\Entidy\EntregaDevolucao;
use App\Entidy\Gaiola;
use App\Entidy\Producao;
use App\Entidy\Receber;
use App\Entidy\Retorno;
use App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();

$calculo = 0;
$qtd = 0;
$receber_id = 0;
$qtd_recebida = 0;
$qtd_atual = 0;
$qtd_total = 0;
$producaoID = 0;
$gaiolasID = 0;
$gaiolasQtd = 0;
$totalQtd = 0;
$idretorno = 0;
$param_id = 0;
$boletos_id = 0;

$resultado_busca = Producao::getID('*', 'producao', $_POST['id2'], null, null);

$param_id = $resultado_busca->qtd;

$condicao = Producao::getMaiorValor($_POST['qtd'], $param_id);

if ($condicao == true) {

    header('location: ../producao/producao-list.php?status=condicao');
    exit;
}


if (isset($_POST['qtd'])) {


    if ($_POST['ocorrencias_id'] == 6) {


        $result = Producao::getID('*', 'producao', $_POST['id2'], null, null);
        $receberID = $result->receber_id;
        $prd_param = $result->id;

        $produt = Receber::getID('*', 'receber', $receberID, null, null);
        $gaiolasID = $produt->gaiolas_id;

        $resultGaiola = Gaiola::getID('*', 'gaiolas', $gaiolasID, null, null);
        $gaiolasQtd = $resultGaiola->qtd;
        $totalQtd = ($gaiolasQtd - $_POST['qtd']);

        $resultGaiola->qtd = $totalQtd;
        $resultGaiola->atualizar();

        $cadboletos = new Boleto;
        $cadboletos->codigo = 7847548;
        $cadboletos->ocorrencias_id = 18;
        $cadboletos->receber_id = $receberID;
        $cadboletos->cadastar();

        $boletos_id = $cadboletos->id;

        $item = new Retorno;

        $idretorno = $item->id;

        $item->data                        = $_POST['data'];
        $item->qtd                         = $_POST['qtd'];
        $item->producao_id                 = $_POST['id2'];
        $item->entregadores_id             = $_POST['entregadores2_id'];
        $item->ocorrencias_id              = $_POST['ocorrencias_id'];
        $item->boletos_id                  = $boletos_id;
        $item->tipo_id                     = 1;
        $item->status                      = 0;

        $item->cadastar();


        $item = new Devolucao;

        $item->data                        = $_POST['data'];
        $item->qtd                         = $_POST['qtd'];
        $item->producao_id                 = $_POST['id2'];
        $item->boletos_id                  = $boletos_id;
        $item->entregadores_id             = $_POST['entregadores2_id'];
        $item->ocorrencias_id              = $_POST['ocorrencias_id'];

        $item->cadastar();

        $item2 = new EntregaDevolucao;
        $item2->data                        = $_POST['data'];
        $item2->devolucao                   = $_POST['qtd'];
        $item2->producao_id                 = $prd_param;
        $item2->entregadores_id             = $_POST['entregadores2_id'];
        $item2->boletos_id                  = $boletos_id;
        $item2->receber_id                  = $receberID;

        $item2->cadastar();

        $value = Producao::getID('*', 'producao', $_POST['id2'], null, null);

        $recebr_id = $value->receber_id;
        $qtd = $value->qtd;

        $calculo = ($qtd - $_POST['qtd']);

        if ($calculo == 0) {

            $value->qtd    = $calculo;
            $value->status = 2;
            $value->atualizar();

            header('location: ../producao/producao-list.php?status=success');
            exit;
        } else {
            $value->qtd    = $calculo;
            $value->status = 1;
            $value->atualizar();

            header('location: ../producao/producao-list.php?status=success');
            exit;
        }
    } else {

        $result = Producao::getID('*', 'producao', $_POST['id2'], null, null);
        $receberID = $result->receber_id;
        $prd_param = $result->id;

        $cadboletos = new Boleto;
        $cadboletos->codigo = 7847548;
        $cadboletos->ocorrencias_id = 18;
        $cadboletos->receber_id = $receberID;
        $cadboletos->cadastar();

        $boletos_id = $cadboletos->id;

        $value2 = Producao::getID('*', 'producao', $_POST['id2'], null, null);

        $recebr_id = $value2->receber_id;

        $item2 = new Retorno;
        $item2->data                        = $_POST['data'];
        $item2->qtd                         = $_POST['qtd'];
        $item2->producao_id                 = $_POST['id2'];
        $item2->entregadores_id             = $_POST['entregadores2_id'];
        $item2->ocorrencias_id              = $_POST['ocorrencias_id'];
        $item2->boletos_id                  = $boletos_id;
        $item2->tipo_id                     = 2;
        $item2->status                      = 0;

        $item2->cadastar();

        $item = new Devolucao;

        $item->data                        = $_POST['data'];
        $item->qtd                         = $_POST['qtd'];
        $item->producao_id                 = $_POST['id2'];
        $item->boletos_id                  = $boletos_id;
        $item->entregadores_id             = $_POST['entregadores2_id'];
        $item->ocorrencias_id              = $_POST['ocorrencias_id'];

        $item->cadastar();

        $devolucao_id = $item->id;

        $entregdev = new EntregaDevolucao;
        $entregdev->data                        = $_POST['data'];
        $entregdev->devolucao                   = $_POST['qtd'];
        $entregdev->producao_id                 = $_POST['id2'];
        $entregdev->entregadores_id             = $_POST['entregadores2_id'];
        $entregdev->boletos_id                  = $boletos_id;
        $entregdev->receber_id                  = $recebr_id;

        $entregdev->cadastar();

        //REORNA PARA BAIA

        $result = Producao::getID('*', 'producao', $_POST['id2'], null, null);
        $receberID = $result->receber_id;

        $produt = Receber::getID('*', 'receber', $receberID, null, null);
        $gaiolasID = $produt->gaiolas_id;

        $resultGaiola = Gaiola::getID('*', 'gaiolas', $gaiolasID, null, null);
        $gaiolasQtd = $resultGaiola->qtd;
        $totalQtd = ($gaiolasQtd - $_POST['qtd']);

        $resultGaiola->qtd = $totalQtd;
        $resultGaiola->atualizar();

        $value = Producao::getID('*', 'producao', $_POST['id2'], null, null);

        $qtd = $value->qtd;

        $calculo = ($qtd - $_POST['qtd']);

        if ($calculo == 0) {

            $value->qtd    = $calculo;
            $value->status = 2;
            $value->atualizar();

            header('location: ../producao/producao-list.php?status=success');
            exit;
        } else {
            $value->qtd    = $calculo;
            $value->status = 1;
            $value->atualizar();

            header('location: ../producao/producao-list.php?status=success');
            exit;
        }
    }
}