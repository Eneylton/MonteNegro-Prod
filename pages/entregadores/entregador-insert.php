<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Entregador;
use App\Entidy\EntregadorServicos;
use App\Entidy\EntregadorSetor;
use App\Entidy\EntreRotas;
use App\Entidy\Servico;
use App\Entidy\Setor;
use App\Session\Login;

$alertaLogin  = '';
$alertaCadastro = '';
$checked = 0;

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();

$entregador_id = 0;

if (isset($_POST['nome'])) {

    $value = new Entregador;

    $din1                = $_POST['valor_boleto'];
    $din2                = str_replace(".", "", $din1);
    $boleto              = str_replace(",", ".", $din2);

    $cart1               = $_POST['valor_cartao'];
    $cart2               = str_replace(".", "", $cart1);
    $cartao              = str_replace(",", ".", $cart2);

    $peq1                = $_POST['valor_pequeno'];
    $peq2                = str_replace(".", "", $peq1);
    $pequeno             = str_replace(",", ".", $peq2);

    $grand1              = $_POST['valor_grande'];
    $grand2              = str_replace(".", "", $grand1);
    $grande              = str_replace(",", ".", $grand2);

    $value->nome                = $_POST['nome'];
    $value->telefone            = $_POST['telefone'];
    $value->email               = $_POST['email'];
    $value->banco               = $_POST['banco'];
    $value->conta               = $_POST['conta'];
    $value->apelido             = $_POST['apelido'];
    $value->agencia             = $_POST['agencia'];
    $value->veiculos_id         = $_POST['veiculos_id'];
    $value->pix                 = $_POST['pix'];
    $value->cpf                 = $_POST['cpf'];
    $value->cnh                 = $_POST['cnh'];
    $value->renavam             = $_POST['renavam'];
    $value->tipo                = $_POST['tipo'];
    $value->status              = $_POST['status'];
    $value->admissao            = $_POST['admissao'];
    $value->recisao             = $_POST['recisao'];
    $value->valor_boleto        = $boleto;
    $value->valor_cartao        = $cartao;
    $value->valor_pequeno       = $pequeno;
    $value->valor_grande        = $grande;
    $value->regioes_id          = $_POST['regioes'];
    $value->forma_pagamento_id  = $_POST['forma_pagamento_id'];
    $value->usuarios_id         = $usuario;
    $value->cadastar();

    $entregador_id = $value->id;

    if (isset($_POST['setores'])) {

        foreach ($_POST['setores'] as $id) {

            $setor = Setor::getID('*', 'setores', $id, null, null);;

            $setor_id = $setor->id;

            $item = new EntregadorSetor;

            if ($id != "") {

                $checked = 1;
            } else {

                $checked = 0;
            }

            $item->entregadores_id = $entregador_id;
            $item->setores_id = $id;
            $item->valor = $checked;
            $item->cadastar();
        }
    }

    if (isset($_POST['servicos'])) {

        foreach ($_POST['servicos'] as $id) {

            $servicos = Servico::getID('*', 'servicos', $id, null, null);

            $setor_id = $servicos->id;

            $item = new EntregadorServicos;

            $item->entregadores_id = $entregador_id;
            $item->servicos_id = $id;
            $item->cadastar();
        }
    }

    if (isset($_POST['rotas'])) {

        foreach ($_POST['rotas'] as $id) {

            $cad = new EntreRotas;

            $cad->entregadores_id = $entregador_id;
            $cad->regioes_id = $_POST['regioes'];
            $cad->rotas_id = $id;
            $cad->cadastar();
        }
    }

    header('location: entregador-list.php?status=success');
    exit;
}
