<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Veiculo;
use   \App\Session\Login;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();

if (isset($_POST['nome'])) {
   
    $item = new Veiculo;
    $item->nome           = $_POST['nome'];
    $item->cadastar();

    header('location: veiculo-list.php?status=success');
    exit;
}
