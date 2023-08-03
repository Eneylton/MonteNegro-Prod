<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Boleto;
use App\Entidy\Receber;
use App\Session\Login;

Login::requireLogin();

$soma = 0;

if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {

    header('location: index.php?status=error');

    exit;
}

$value = Boleto::getID('*', 'boletos', $_GET['id'], null, null, null);

$id_receber = $value->receber_id;

// $receber = Receber::getID('*', 'receber', $id_receber, null, null, null);

// $receber_qtd = $receber->qtd;
// $receber_disp = $receber->disponivel;

// $receber->qtd = $receber_qtd - 1;
// $receber->disponivel = $receber_disp - 1;
// $receber->atualizar();

if (!$value instanceof Boleto) {
    header('location: index.php?status=error');

    exit;
}

if (!isset($_POST['excluir'])) {


    $value->excluir();

    header('location: ../receber/entregador-boleto.php?entregador_id=' . $_GET['entregadores_id'] . '&receber_id=' . $id_receber . '&qtd=' . $_GET['qtd'] . '');
    exit;
}
