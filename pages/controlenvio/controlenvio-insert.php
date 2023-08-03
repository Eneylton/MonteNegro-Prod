<?php

use App\Entidy\ControlEnvio;
use App\Entidy\EntregadorDetalhe;
use App\Session\Login;

require __DIR__ . '../../../vendor/autoload.php';


Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];


if (isset($_POST['obs'])) {

    $item = new  EntregadorDetalhe;
    $item->data              = $_POST['data'];
    $item->status            = $_POST['status'];
    $item->obs               = $_POST['obs'];
    $item->ocorrencias_id    = $_POST['ocorrencias_id'];
    $item->entregadores_id   = $_POST['entregadores_id'];
    $item->controlenvio_id   = $_POST['codid'];
    $item->cadastar();

    $controle = ControlEnvio::getID('*', 'controlenvio', $_POST['codid'], null, null);

    $controle->status = $_POST['status'];
    $controle->entregadores_id  = $_POST['entregadores_id'];
    $controle->ocorrencias_id   = $_POST['ocorrencias_id'];

    $controle->atualizar();

    header('location: controlenvio-list.php');
    exit;
}
