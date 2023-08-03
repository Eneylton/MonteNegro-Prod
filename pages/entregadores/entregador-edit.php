<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Entregador;
use App\Entidy\EntregadorServicos;
use App\Entidy\EntregadorSetor;
use App\Entidy\EntreRotas;
use App\Session\Login;

Login::requireLogin();

if (isset($_POST["regioes_id"])) {
    $country = $_POST["regioes_id"];
    echo "select country is => " . $country;
}

if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {

    header('location: index.php?status=error');

    exit;
}


$value = Entregador::getID('*', 'entregadores', $_GET['id'], null, null);


if (!$value instanceof Entregador) {
    header('location: index.php?status=error');

    exit;
}

if (isset($_GET['id'])) {

    $value->nome                = $_GET['nome'];
    $value->telefone            = $_GET['telefone'];
    $value->email               = $_GET['email'];
    $value->banco               = $_GET['banco'];
    $value->conta               = $_GET['conta'];
    $value->apelido             = $_GET['apelido'];
    $value->agencia             = $_GET['agencia'];
    $value->veiculos_id         = $_GET['veiculos_id'];
    $value->pix                 = $_GET['pix'];
    $value->cpf                 = $_GET['cpf'];
    $value->cnh                 = $_GET['cnh'];
    $value->renavam             = $_GET['renavam'];
    $value->tipo                = $_GET['tipo'];
    $value->status              = $_GET['status'];
    $value->admissao            = $_GET['admissao'];
    $value->recisao             = $_GET['recisao'];
    $value->regioes_id          = $_GET['regioes_id'];
    $value->valor_boleto        = $_GET['valor_boleto'];
    $value->valor_cartao        = $_GET['valor_cartao'];
    $value->valor_pequeno       = $_GET['valor_pequeno'];
    $value->valor_grande        = $_GET['valor_grande'];
    $value->forma_pagamento_id  = $_GET['forma_pagamento_id'];
    $value->atualizar();

    if (isset($_GET['id'])) {

        foreach ($_GET['setores'] as $id2) {


            $listarEnt = EntregadorSetor::getIDListEntregador('*', 'entregador_setores', $_GET['id'], null, null);

            if ($listarEnt != false) {

                foreach ($listarEnt as $value3) {

                    $delete = EntregadorSetor::getID('*', 'entregador_setores', $value3->id, null, null);

                    $delete->excluir();
                }
            }
        }

        foreach ($_GET['setores'] as $id3) {

            $itemEntreg = new EntregadorSetor;
            $itemEntreg->entregadores_id = $_GET['id'];
            $itemEntreg->setores_id = $id3;
            $itemEntreg->valor = 1;
            $itemEntreg->cadastar();
        }


        if (isset($_GET['servicos'])) {

            foreach ($_GET['servicos'] as $id) {

                $listarServi = EntregadorServicos::getIDListEntregador('*', 'entregador_servicos', $_GET['id'], null, null);

                if ($listarServi != false) {

                    foreach ($listarServi as $key) {

                        $del = EntregadorServicos::getID('*', 'entregador_servicos', $key->id, null, null);

                        $del->excluir();
                    }
                }
            }

            foreach ($_GET['servicos'] as $id4) {

                $itemServ = new EntregadorServicos;
                $itemServ->entregadores_id = $_GET['id'];
                $itemServ->servicos_id = $id4;
                $itemServ->cadastar();
            }


            foreach ($_GET['rotas'] as $item) {


                $listRotas = EntreRotas::getIDListEntregador('*', 'entregador_rota', $_GET['id'], null, null);

                if ($listRotas != false) {

                    foreach ($listRotas as $rota) {

                        $delete = EntreRotas::getID('*', 'entregador_rota', $rota->id, null, null);

                        $delete->excluir();
                    }
                }
            }

            foreach ($_GET['rotas'] as $item) {

                $rota = new EntreRotas;
                $rota->entregadores_id = $_GET['id'];
                $rota->regioes_id = $_GET['regioes_id'];
                $rota->rotas_id = $item;
                $rota->cadastar();
            }

            header('location: entregador-list.php?status=edit');

            exit;
        }
    }
}