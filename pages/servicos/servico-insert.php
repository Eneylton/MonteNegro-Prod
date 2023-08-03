<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Servico;
use   \App\Session\Login;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();

if (isset($_POST['nome'])) {
   
    $item = new Servico;
    $item->nome           = $_POST['nome'];
    $item->cadastar();

    header('location: servico-list.php?status=success');
    exit;
}
