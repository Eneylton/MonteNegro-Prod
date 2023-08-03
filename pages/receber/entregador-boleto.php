<?php

use App\Entidy\Boleto;
use App\Entidy\Receber;
use App\Session\Login;

require __DIR__ . '../../../vendor/autoload.php';

define('TITLE', 'Adicionar Novos Registros');
define('BRAND', 'Adicionar Arquivos');

Login::requireLogin();

if (isset($_GET['receber_id'])) {

    $entregador_id = $_GET['entregador_id'];
    $receber_id = $_GET['receber_id'];
}

if (isset($_GET['qtd'])) {

    $qtd_id = $_GET['qtd'];
}

$receb =  Receber::getID('*', 'receber', $_GET['receber_id'], null, null, null);

$coleta = $receb->coleta;

if (!isset($_GET['status'])) {
    $listar = Boleto::getList('*', 'boletos', 'entregadores_id= ' . $_GET['entregador_id'] . ' AND receber_id=' . $_GET['receber_id']);

    if (!empty($listar)) {

        foreach ($listar as $value) {
            $item = Boleto::getID('*', 'boletos', $value->id, null, null, null);
            if ($value->entregadores_id == 195) {

                $receb->entregadores_id = $entregador_id;
                $receb->coleta = $coleta;
                $receb->atualizar();
            } else {
                $receb->coleta = $coleta;
                $receb->atualizar();
            }
        }
    } else {

        $receb->coleta = $coleta;
        $receb->atualizar();
    }
} else {

    $listar = Boleto::getList('*', 'boletos', 'entregadores_id= ' . $_GET['entregador_id'] . ' AND receber_id=' . $_GET['receber_id'] . ' AND status=' . $_GET['status']);

    if (!empty($listar)) {

        foreach ($listar as $value) {
            $item = Boleto::getID('*', 'boletos', $value->id, null, null, null);
            if ($value->entregadores_id == 195) {

                $receb->entregadores_id = $entregador_id;
                $receb->coleta = $coleta;
                $receb->atualizar();
            } else {

                $receb->atualizar();
            }
        }
    } else {

        $receb->atualizar();
    }
}



include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/receber/entregador-boleto-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';
