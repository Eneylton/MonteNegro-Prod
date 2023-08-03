<?php

use App\Entidy\Combustivel;

require __DIR__ . '../../../vendor/autoload.php';



if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {

    header('location: index.php?status=error');

    exit;
}

$value = Combustivel::getID('*', 'combustivel', $_GET['id'], null, null);

if (!$value instanceof Combustivel) {
    header('location: index.php?status=error');

    exit;
}

if (!isset($_POST['excluir'])) {

    $value->excluir();

    header('location: combustivel-list.php?status=del');

    exit;
}