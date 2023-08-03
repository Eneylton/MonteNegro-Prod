<?php

require __DIR__ . '../../../vendor/autoload.php';

$alertaCadastro = '';

define('TITLE', 'Editar Usuários');
define('BRAND', 'Editar Usuários');

use App\Entidy\Receber;
use App\Session\Login;


Login::requireLogin();


if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {

    header('location: index.php?status=error');

    exit;
}

$item = Receber::getID('*', 'receber', $_GET['id'], null, null);


if (!$item instanceof Receber) {
    header('location: index.php?status=error');

    exit;
}



if (isset($_GET['qtd'])) {

    $item->data            = $_GET['data'];
    $item->disponivel      = $_GET['qtd'];
    $item->qtd             = $_GET['qtd'];
    $item->numero          = $_GET['numero'];
    $item->clientes_id     = $_GET['clientes_id'];
    $item->setores_id      = $_GET['setores_id'];
    $item->servicos_id     = $_GET['servicos_id'];
    $item->gaiolas_id      = $_GET['baias_id'];
    $item->atualizar();

    header('location: receber-list.php?status=edit');

    exit;
}