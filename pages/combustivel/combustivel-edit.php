<?php

use App\Entidy\Combustivel;

require __DIR__ . '../../../vendor/autoload.php';


if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {

    header('location: index.php?status=error');

    exit;
}

$value = Combustivel::getID('*', 'combustivel', $_GET['id'], null, null);

if (isset($_GET['id'])) {

    $din1                = $_GET['valor'];
    $din2                = str_replace(".", "", $din1);
    $valor               = str_replace(",", ".", $din2);

    $value->data  = $_GET['data'];
    $value->entregadores_id = $_GET['entregadores_id'];
    $value->veiculos_id  = $_GET['veiculos_id'];
    $value->placa = $_GET['placa'];
    $value->valor = $valor;
    $value->atualizar();

    header('location: combustivel-list.php?status=edit');

    exit;
}