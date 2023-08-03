<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Boleto;
use \App\Entidy\Receber;
use   \App\Session\Login;

Login::requireLogin();


if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {

    header('location: index.php?status=error');

    exit;
}

$value = Receber::getID('*', 'receber', $_GET['id'], null, null);

$id = $value->id;

$boletos = Boleto::getList('*', 'boletos', 'receber_id=' . $id, null, null, null);

if (!$value instanceof Receber) {
    header('location: index.php?status=error');

    exit;
}

foreach ($boletos as $key) {

    $resultado = Boleto::getID('*', 'boletos', $key->id, null, null, null);
    $resultado->excluir();
}



if (!isset($_POST['excluir'])) {


    $value->excluir();

    header('location: lote-list.php?status=del');

    exit;
}