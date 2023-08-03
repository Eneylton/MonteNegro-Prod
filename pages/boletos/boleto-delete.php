<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Boleto;
use App\Entidy\EntregadorQtd;
use App\Entidy\Producao;
use App\Entidy\Receber;
use App\Session\Login;


Login::requireLogin();

$soma = 0;
$somadisp = 0;
$somaqtd = 0;

if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {

    header('location: index.php?status=error');

    exit;
}

$value = Boleto::getID('*', 'boletos', $_GET['id'], null, null, null);

$id_receber = $value->receber_id;

$receber = Receber::getID('*', 'receber', $id_receber, null, null, null);

$entregadorQtd = EntregadorQtd::getIDReceber('*', 'entregador_qtd', $id_receber . ' AND entregadores_id=' . $_GET['entregadores_id'], null, null, null);

$producao = Producao::getListIdProd('*', 'producao as p', 'p.entregadores_id = ' . $_GET['entregadores_id'] . ' AND p.receber_id =' . $id_receber . '');

$qtd = $entregadorQtd->qtd;

if ($qtd != 0) {

    $somaqtd = $qtd - 1;
} else {
    $somaqtd  = 0;
}

$receber_qtd = $receber->qtd;

$receber_disp = $receber->disponivel;

if ($receber_disp != 0) {
    $somadisp = $receber_disp - 1;
} else {
    $somadisp = 0;
}

$soma = $receber_qtd - 1;

if ($_GET['entregadores_id'] == 195) {
    $receber->qtd = $soma;
    $receber->disponivel = $somadisp;
    if ($soma != 0) {
        $receber->atualizar();
    } else {
        $receber->excluir();
    }
    $value->excluir();
    header('location: boleto-List.php?id_item=' . $id_receber);
    exit;
}

if ($soma != 0) {
    $entregadorQtd->qtd = $somaqtd;
    $receber->qtd = $soma;
    $entregadorQtd->atualizar();
    $value->excluir();
    $receber->atualizar();
    header('location: boleto-List.php?id_item=' . $id_receber);
    exit;
} else {

    $value->excluir();
    $entregadorQtd->excluir();
    $receber->excluir();
    header('location: boleto-List.php?id_item=' . $id_receber);
    exit;
}




if (!$value instanceof Boleto) {
    header('location: index.php?status=error');

    exit;
}



if (!isset($_POST['excluir'])) {


    $value->excluir();

    header('location: boleto-List.php?id_item=' . $id_receber);

    exit;
}
