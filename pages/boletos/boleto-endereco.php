<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Destinatario;
use App\Session\Login;

Login::requireLogin();

date_default_timezone_set('America/Sao_Paulo');
$data_cadastra = date('Y-m-d H:m:s');


if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {

    header('location: index.php?status=error');

    exit;
} else {

    $value = Destinatario::getID('*', 'destinatario', $_GET['id'], null, null);

    $id = $value->receber_id;

    $value->logradouro = $_GET['logradouro'];
    $value->numero = $_GET['numero'];
    $value->bairro = $_GET['bairro'];
    $value->cep = $_GET['cep'];
    $value->complemento = $_GET['complemento'];
    $value->flag = $_GET['flag'];
    $value->telefone = $_GET['telefone'];
    $value->telefone2 = $_GET['telefone2'];
    $value->atualizar();

    header('location: boleto-list.php?id_item=' . $_GET['id_param'] . '&entregadores_id=');

    exit;
}
