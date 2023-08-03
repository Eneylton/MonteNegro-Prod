<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Boleto;
use App\Entidy\Receber;
use App\Session\Login;

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

$comparar = "COD_CONTRATO ";

$soma = 0;
$soma = 0;


if (isset($_POST['receber_id'])) {

    $cont = $_POST['qtd'];

    $receber = Receber::getID('*', 'receber', $_POST['receber_id'], null, null, null, null);

    $qtd = $receber->qtd;
    $receber_id = $receber->id;
}
$cont2 = 0;
$comparar = "COD_CONTRATO ";
$contar = 0;
$arquivos = [];
$arquivo_tmp = $_FILES['arquivo']['tmp_name'];

foreach ($arquivo_tmp as $key) {

    $arquivos  = file($key);

    foreach ($arquivos  as $contar) {

        $linha2 = trim($contar);
        $valor2 = explode(';', $contar);
        $codigo2 = str_replace('"', '', $valor2[0]);


        if ($codigo2 === $comparar) {

            $cont2 = 0;
        } else {
            $cont += 1;
        }
    }
}


if (!isset($arquivo_tmp)) {


    $receber->data            = $_POST['data'];
    $receber->vencimento      = $_POST['vencimento'];
    $receber->disponivel      = $cont;
    $receber->qtd             = $cont;
    $receber->setores_id      = $_POST['setores'];
    $receber->numero          = 0;
    $receber->servicos_id     = 1;
    $receber->clientes_id     = $_POST['clientes_id'];
    $receber->usuarios_id     = $usuario;
    $receber->gaiolas_id      = $id_gaiola;
    $receber->atualizar();

    header('location: receber-list.php?');
    exit;
} else {


    $receber->data            = $_POST['data'];
    $receber->vencimento      = $_POST['vencimento'];
    $receber->disponivel      = $cont;
    $receber->qtd             = $cont;
    $receber->setores_id      = 3;
    $receber->numero          = $_POST['numero'];
    $receber->servicos_id     = 3;
    $receber->clientes_id     = $_POST['clientes_id'];
    $receber->usuarios_id     = $usuario;
    $receber->gaiolas_id      = 117;
    $receber->atualizar();


    foreach ($arquivo_tmp as $key) {

        $dados  = file($key);

        foreach ($dados  as $linha) {


            $linha = trim($linha);
            $valor = explode(';', $linha);

            $codigo = str_replace('"', '', $valor[0]);
            $codigo2 = str_replace('"', '', $valor[1]);
            $destinatario = str_replace('"', '', $valor[2]);
            $numero = str_replace('"', '', $valor[5]);
            $endereco1 = str_replace('"', '', $valor[4]);
            $endereco2 = iconv('UTF-8', 'ISO-8859-1', $endereco1);
            $logradouro = str_replace('"', '', $valor[6]);
            $logradouro2 = iconv('UTF-8', 'ISO-8859-1', $logradouro);
            $bairro = str_replace('"', '', $valor[7]);
            $municipio = str_replace('"', '', $valor[8]);
            $estado = str_replace('"', '', $valor[9]);
            $cep = str_replace('"', '', $valor[10]);
            $tipo = str_replace('"', '', $valor[11]);
            $status = 3;

            if ($codigo === $comparar) {

                echo "";
            } else {

                $item2 = new Boleto;
                $item2->data            = $_POST['data'];
                $item2->vencimento      = $_POST['vencimento'];
                $item2->codigo          = $codigo;
                $item2->destinatario    = $destinatario;
                $item2->numero          = $numero;
                $item2->endereco        = $endereco2;
                $item2->logradouro      = $logradouro2;
                $item2->bairro          = $bairro;
                $item2->municipio       = $municipio;
                $item2->estado          = $estado;
                $item2->cep             = $cep;
                $item2->tipo            = $tipo;
                $item2->status          = $status;
                $item2->ocorrencias_id  = 18;
                $item2->receber_id      = $receber_id;

                $item2->cadastar();
            }
        }
    }

    header('location: ../lotes/lote-list.php?');
    exit;
}