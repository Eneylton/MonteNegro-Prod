<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Boleto;
use App\Entidy\BoletoProducao;
use App\Entidy\Devolucao;
use App\Entidy\Entrega;
use App\Entidy\EntregaDevolucao;
use App\Entidy\EntregadorDetalhe;
use App\Entidy\Producao;
use App\Funcao\CalcularQtd;
use App\Session\Login;

Login::requireLogin();

$flag = "";

date_default_timezone_set('America/Sao_Paulo');
$data_cadastra = date('Y-m-d H:m:s');


if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {

    header('location: index.php?status=error');

    exit;
} else {


    $resultado = CalcularQtd::calcularQtd($_GET['entregador_id'], $_GET['receber_id']);


    switch ($_GET['status']) {
        case '3':
            $flag = 1;
            break;
        case '4':
            $flag = 2;
            break;
        case '1':
            $flag = 3;
            break;

        case '2':
            $flag = 4;
            break;

        default:
            # code...
            break;
    }



    if ($resultado != true) {
        header('location: boleto-list.php?id_item=' . $_GET['receber_id'] . '&status27=error');
        exit;
    }

    if ($_GET['status'] == 1) {

        $detalhe = new EntregadorDetalhe;
        $detalhe->data  = $data_cadastra;
        $detalhe->status  = $flag;
        $detalhe->obs  = $_GET['obs'];
        $detalhe->ocorrencias_id  = $_GET['ocorrencias_id'];
        $detalhe->entregadores_id  = $_GET['entregador_id'];
        $detalhe->boletos_id  = $_GET['id'];
        $detalhe->cadastar();

        $producao = Producao::getReceberID('*', 'producao', $_GET['receber_id'] . ' AND entregadores_id = ' . $_GET['entregador_id'], null, null, null);
        $id_prod =  $producao->id;

        $verificaboleto = Entrega::getEntregaBoletoID('*', 'entrega', $_GET['id'], null, null, null);
        $boleto_id = $verificaboleto->id;



        if ($verificaboleto == false) {

            $entrega = new Entrega;
            $entrega->boletos_id          = $_GET['id'];
            $entrega->data                = $_GET['data'];
            $entrega->producao_id         = $id_prod;
            $entrega->entregadores_id     = $_GET['entregador_id'];
            $entrega->qtd                 = 1;
            $entrega->cadastar();

            $estatistica = new EntregaDevolucao;
            $estatistica->boletos_id         = $_GET['id'];
            $estatistica->receber_id         = $_GET['receber_id'];
            $estatistica->data               = $_GET['data'];
            $estatistica->entrega            = 1;
            $estatistica->devolucao          = 0;
            $estatistica->entregadores_id    = $_GET['entregador_id'];
            $estatistica->producao_id        = $id_prod;
            $estatistica->cadastar();

            $boleto = new BoletoProducao;
            $boleto->boletos_id         = $_GET['id'];
            $boleto->data               = $_GET['data'];
            $boleto->codigo             = $_GET['codigo'];
            $boleto->destinatario       = $_GET['destinatario'];
            $boleto->status             = $_GET['status'];
            $boleto->ocorrencias_id     = 18;
            $boleto->entregadores_id    = $_GET['entregador_id'];
            $boleto->receber_id         = $_GET['receber_id'];
            $boleto->cadastar();

            $producao_qtd    = $producao->qtd - 1;
            $id_producao     = $producao->id;
            $producao->qtd   = $producao_qtd;
            $producao->atualizar();

            $value = Boleto::getID('*', 'boletos', $_GET['id'], null, null, null);
            $quantidade = Boleto::getQtdSequencia('count(b.sequencia) as total', 'boletos AS b', null, null, null);

            $qtd = $quantidade->total + 1;


            if (isset($_GET['status'])) {

                $value->data             = $data_cadastra;
                $value->status           = $_GET['status'];
                $value->sequencia        = $qtd;
                $value->ocorrencias_id   = $_GET['ocorrencias_id'];
                $value->obs              = $_GET['obs'];
                $value->atualizar();
                if ($_GET['existe'] == "false") {

                    header('location: boleto-list.php?id_item=' . $_GET['receber_id'] . '&entregadores_id=');
                    exit;
                } else {
                    header('location: boleto-list.php?id_param=' . $_GET['entregador_id'] . '&receber_id=' . $_GET['receber_id'] . '');
                    exit;
                }
            } else {

                header('location: boleto-list.php?id_item=' . $_GET['receber_id'] . '&status3=error&id_param=' . $_GET['receber_id']);
                exit;
            }
        } else {

            $devolvido = Devolucao::getIDProducao('*', 'devolucao', $id_prod . null, null, null);
            $qtdDevolvidaid =  $devolvido->id;
            $excluirEntrega = Devolucao::getID('*', 'devolucao', $qtdDevolvidaid, null, null, null);
            $excluirEntrega->excluir();
        }
    } elseif ($_GET['status'] == 2) {

        $detalhe = new EntregadorDetalhe;
        $detalhe->data  = $data_cadastra;
        $detalhe->status  = $flag;
        $detalhe->obs  = $_GET['obs'];
        $detalhe->ocorrencias_id  = $_GET['ocorrencias_id'];
        $detalhe->entregadores_id  = $_GET['entregador_id'];
        $detalhe->boletos_id  = $_GET['id'];
        $detalhe->cadastar();

        $producao = Producao::getReceberID('*', 'producao', $_GET['receber_id'] . ' AND entregadores_id = ' . $_GET['entregador_id'], null, null, null);
        $id_prod =  $producao->id;

        $verificaboleto = Entrega::getEntregaBoletoID('*', 'entrega', $_GET['id'], null, null, null);
        $boleto_id = $verificaboleto->id;

        if ($verificaboleto == false) {

            $devolucao = new Devolucao;
            $devolucao->boletos_id          = $_GET['id'];
            $devolucao->data                = $_GET['data'];
            $devolucao->producao_id         = $id_prod;
            $devolucao->ocorrencias_id      = $_GET['ocorrencias_id'];
            $devolucao->entregadores_id     = $_GET['entregador_id'];
            $devolucao->qtd                 = 1;
            $devolucao->cadastar();

            $estatistica = new EntregaDevolucao;
            $estatistica->boletos_id         = $_GET['id'];
            $estatistica->receber_id         = $_GET['receber_id'];
            $estatistica->data               = $_GET['data'];
            $estatistica->entrega            = 0;
            $estatistica->devolucao          = 1;
            $estatistica->entregadores_id    = $_GET['entregador_id'];
            $estatistica->producao_id        = $id_prod;
            $estatistica->cadastar();

            $boleto = new BoletoProducao;
            $boleto->boletos_id         = $_GET['id'];;
            $boleto->data               = $_GET['data'];
            $boleto->codigo             = $_GET['codigo'];
            $boleto->destinatario       = $_GET['destinatario'];
            $boleto->status             = $_GET['status'];
            $boleto->ocorrencias_id     = 18;
            $boleto->entregadores_id    = $_GET['entregador_id'];
            $boleto->receber_id         = $_GET['receber_id'];
            $boleto->cadastar();

            $producao_qtd    = $producao->qtd - 1;
            $id_producao     = $producao->id;
            $producao->qtd   = $producao_qtd;
            $producao->atualizar();

            $value = Boleto::getID('*', 'boletos', $_GET['id'], null, null, null);
            $quantidade = Boleto::getQtdSequencia('count(b.sequencia) as total', 'boletos AS b', null, null, null, null);

            $qtd = $quantidade->total + 1;


            if (isset($_GET['status'])) {

                $value->data             = $_GET['data'];
                $value->status           = $_GET['status'];
                $value->ocorrencias_id   = $_GET['ocorrencias_id'];
                $value->sequencia        = $qtd;
                $value->obs              = $_GET['obs'];
                $value->atualizar();
                if ($_GET['existe'] == "false") {

                    header('location: boleto-list.php?id_item=' . $_GET['receber_id'] . '&entregadores_id=');
                    exit;
                } else {
                    header('location: boleto-list.php?id_param=' . $_GET['entregador_id'] . '&receber_id=' . $_GET['receber_id'] . '');
                    exit;
                }
            } else {

                header('location: boleto-list.php?id_item=' . $_GET['receber_id'] . '&status3=error&id_param=' . $_GET['receber_id']);
                exit;
            }
        } else {

            $verificaboleto->excluir();

            $devolucao = new Devolucao;
            $devolucao->data                = $_GET['data'];
            $devolucao->producao_id         = $id_prod;
            $devolucao->ocorrencias_id      = $_GET['ocorrencias_id'];
            $devolucao->entregadores_id     = $_GET['entregador_id'];
            $devolucao->boletos_id          = $_GET['id'];
            $devolucao->qtd                 = 1;
            $devolucao->cadastar();

            $entdev = EntregaDevolucao::getBoletosID('*', 'entrega_devolucao', $_GET['id'], null, null, null);
            $entdev->boletos_id         = $_GET['id'];
            $entdev->receber_id         = $_GET['receber_id'];
            $entdev->data               = $_GET['data'];
            $entdev->entrega            = 0;
            $entdev->devolucao          = 1;
            $entdev->entregadores_id    = $_GET['entregador_id'];
            $entdev->atualizar();

            $boleto = BoletoProducao::getBoletosID('*', 'boleto_producao', $_GET['id'], null, null, null);
            $boleto->boletos_id         = $_GET['id'];;
            $boleto->data               = $_GET['data'];
            $boleto->codigo             = $_GET['codigo'];
            $boleto->destinatario       = $_GET['destinatario'];
            $boleto->status             = $_GET['status'];
            $boleto->ocorrencias_id     = $_GET['ocorrencias_id'];
            $boleto->entregadores_id    = $_GET['entregador_id'];
            $boleto->receber_id         = $_GET['receber_id'];
            $boleto->atualizar();

            $value = Boleto::getID('*', 'boletos', $_GET['id'], null, null, null);
            $quantidade = Boleto::getQtdSequencia('count(b.sequencia) as total', 'boletos AS b', null, null, null);

            $qtd = $quantidade->total + 1;

            if (isset($_GET['status'])) {

                $value->data             = $_GET['data'];
                $value->status           = $_GET['status'];
                $value->ocorrencias_id   = $_GET['ocorrencias_id'];
                $value->obs              = $_GET['obs'];
                $value->atualizar();
                if ($_GET['existe'] == "false") {

                    header('location: boleto-list.php?id_item=' . $_GET['receber_id'] . '&entregadores_id=');
                    exit;
                } else {
                    header('location: boleto-list.php?id_param=' . $_GET['entregador_id'] . '&receber_id=' . $_GET['receber_id'] . '');
                    exit;
                }
            } else {

                header('location: boleto-list.php?id_item=' . $_GET['receber_id'] . '&status3=error&id_param=' . $_GET['receber_id']);
                exit;
            }
        }
    } else {
        $producao = Producao::getReceberID('*', 'producao', $_GET['receber_id'] . ' AND entregadores_id = ' . $_GET['entregador_id'], null, null, null);
        $id_prod =  $producao->id;

        $verifentrega = Entrega::getEntregaBoletoID('*', 'entrega', $_GET['id'], null, null, null);
        $boleto_id = $verifentrega->id;

        if ($verifentrega != false) {

            $entragaexcluir = Entrega::getID('*', 'entrega', $boleto_id, null, null, null);
            $entragaexcluir->excluir();

            $producao_qtd    = $producao->qtd + 1;
            $id_producao     = $producao->id;
            $producao->qtd   = $producao_qtd;
            $producao->atualizar();
        }

        $verifdevolucao = Devolucao::getIDBoletos('*', 'devolucao', $_GET['id'], null, null, null);
        $boleto_id = $verifdevolucao->id;

        if ($verifdevolucao != false) {

            $verifdevolucao = Devolucao::getID('*', 'devolucao', $boleto_id, null, null, null);
            $verifdevolucao->excluir();
            $producao_qtd    = $producao->qtd + 1;
            $id_producao     = $producao->id;
            $producao->qtd   = $producao_qtd;
            $producao->atualizar();
        }


        $verifentdev = EntregaDevolucao::getBoletosID('*', 'entrega_devolucao', $_GET['id'], null, null, null);
        $boleto_id = $verifentdev->id;

        if ($verifentdev != false) {

            $verifentdev  = EntregaDevolucao::getID('*', 'entrega_devolucao', $boleto_id, null, null, null);
            $verifentdev->excluir();
        }

        $boletodev = BoletoProducao::getBoletosID('*', 'boleto_producao', $boleto_id, null, null, null);
        $boleto_id = $boletodev->id;

        if ($boletodev != false) {

            $boletodev  = BoletoProducao::getBoletosID('*', 'boleto_producao', $boleto_id, null, null, null);
            $boletodev->excluir();
        }


        $value = Boleto::getID('*', 'boletos', $_GET['id'], null, null, null);
        $quantidade = Boleto::getQtdSequencia('count(b.sequencia) as total', 'boletos AS b', null, null, null);

        if (isset($_GET['status'])) {

            $value->data             = $_GET['data'];
            $value->status           = $_GET['status'];
            $value->ocorrencias_id   = $_GET['ocorrencias_id'];
            $value->sequencia        = null;
            $value->obs              = $_GET['obs'];
            $value->atualizar();

            if ($_GET['existe'] == "false") {

                header('location: boleto-list.php?id_item=' . $_GET['receber_id'] . '&entregadores_id=');
                exit;
            } else {
                header('location: boleto-list.php?id_param=' . $_GET['entregador_id'] . '&receber_id=' . $_GET['receber_id'] . '');
                exit;
            }
        }
    }
}
