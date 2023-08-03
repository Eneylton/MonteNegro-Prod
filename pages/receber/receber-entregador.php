<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Cliente;
use App\Entidy\Producao;
use App\Entidy\Receber;
use App\Session\Login;

$regioes_id = 0;

$soma = 0;

$qtd_recebida = 0;
$qtd_entregar = 0;

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();


if (isset($_POST['qtd'])) {

    $qtd_entregar = intval($_POST['qtd']);

    $regioes_id = intval($_POST['regioes']);

    $receberItem = Receber::getID('*', 'receber', $_POST['receber_id'], null, null);

    $cliente_id   = $receberItem->clientes_id;
    $qtd_recebida = $receberItem->qtd;

    if ($qtd_entregar > $qtd_recebida) {

        header('location: receber-list.php?status=maior');

        exit;
    }

    $clientes = Cliente::getID('*', 'clientes', $cliente_id, null, null);

    $setor = $clientes->setores_id;
    $valor_item = $receberItem->disponivel;

    //MANIPULANDO DADAS

    $soma = ($valor_item - intval($_POST['qtd']));

    $receberItem->disponivel = $soma;

    $receberItem->atualizar();

    $item = new Producao;

    switch ($regioes_id) {
        case '74':
            $datafim = date('Y-m-d', strtotime("+2 days", strtotime($_POST['data_inicio'])));
            break;

        default:
            $datafim = date('Y-m-d', strtotime("+7 days", strtotime($_POST['data_fim'])));
            break;
    }

    $item->data_inicio          = $_POST['data_inicio'];
    $item->data_fim             = $datafim;
    $item->qtd                  = intval($_POST['qtd']);
    $item->entregadores_id      = $_POST['entregadores'];
    $item->regioes_id           = $regioes_id;
    $item->receber_id           = $_POST['receber_id'];
    $item->usuarios_id          = $usuario;
    $item->status               = 1;

    $item->cadastar();

    header('location: receber-list.php?');
    exit;
}