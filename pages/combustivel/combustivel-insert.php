<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Combustivel;
use App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();

if (isset($_POST['valor'])) {

    $din1                = $_POST['valor'];
    $din2                = str_replace(".", "", $din1);
    $valor               = str_replace(",", ".", $din2);

    $item = new Combustivel;
    $item->data                     = $_POST['data'];
    $item->placa                    = $_POST['placa'];
    $item->valor                    = $valor;
    $item->veiculos_id              = $_POST['veiculos_id'];
    $item->entregadores_id          = $_POST['entregadores_id'];
    $item->usuarios_id              = $usuario;
    $item->cadastar();

    header('location: combustivel-list.php?status=success');
    exit;
}