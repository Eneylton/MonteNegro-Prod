<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Boleto;
use App\Entidy\Cliente;
use App\Entidy\Destinatario;
use App\Entidy\EntregadorDetalhe;
use App\Entidy\NotaFiscal;
use App\Entidy\Receber;
use App\Session\Login;

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

$comparar = "COD_CONTRATO ";

$id_gaiola = 117;

$cont = 0;
$cont2 = 0;
$contar = 0;
$arquivos = [];
$array    = [];
$arquivo_tmp = $_FILES['arquivo']['tmp_name'];

$soma = 0;
$qtd_entrega = 0;
$contador = 0;
$val = 1;
$disponivel = 0;
$cont_disponivel = 0;
$qtd_disp  = 0;
$reslt   = "";
$linha2 = "";
$valor2 = 0;
$codigo2 = 0;

foreach ($arquivo_tmp as $key) {

    $arquivos  = file($key);

    if ($arquivos != false) {
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
}

if ($arquivos != false) {


    $item = new Receber;
    $item->data            = $_POST['data'];
    $item->vencimento      = $_POST['vencimento'];
    $item->disponivel      = $cont;
    $item->qtd             = $cont;
    $item->setores_id      = 3;
    $item->numero          = $_POST['numero'];
    $item->servicos_id     = 3;
    $item->clientes_id     = $_POST['clientes_id'];
    $item->usuarios_id     = $usuario;
    $item->gaiolas_id      = $id_gaiola;
    $item->cadastar();

    $receber_id = $item->id;


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
                $item2->entregadores_id = 195;
                $item2->ocorrencias_id  = 18;
                $item2->receber_id      = $receber_id;

                $item2->cadastar();
            }
        }
    }

    header('location: ../lotes/lote-list.php?');
    exit;
} else {

    if ($_POST['qtd'] != "") {

        $cont = $_POST['qtd'];

        $item = new Receber;
        $item->data            = $_POST['data'];
        $item->vencimento      = $_POST['vencimento'];
        $item->disponivel      = $cont;
        $item->qtd             = $cont;
        $item->setores_id      = 3;
        $item->numero          = $_POST['numero'];
        $item->servicos_id     = 3;
        $item->clientes_id     = $_POST['clientes_id'];
        $item->usuarios_id     = $usuario;
        $item->gaiolas_id      = $id_gaiola;
        $item->cadastar();
        $receber_id = $item->id;

        for ($i = 0; $i < $cont; $i++) {

            $numero_de_bytes = 4;
            $restultado_bytes = random_bytes($numero_de_bytes);
            $codigo = bin2hex($restultado_bytes);

            $item2 = new Boleto;
            $item2->data            = $_POST['data'];
            $item2->vencimento      = $_POST['vencimento'];
            $item2->codigo          = $codigo;
            $item2->destinatario    = $_POST['codbarra'];
            $item2->numero          = $_POST['numero'];
            $item2->endereco        = "";
            $item2->logradouro      = "";
            $item2->bairro          = "";
            $item2->municipio       = "SÃO LUÍS";
            $item2->estado          = "MA";
            $item2->cep             = "65000-000";
            $item2->tipo            = "BOLETO";
            $item2->status          = 3;
            $item2->entregadores_id = 195;
            $item2->ocorrencias_id  = 18;
            $item2->receber_id      = $receber_id;

            $item2->cadastar();
        }

        header('location: ../lotes/lote-list.php?');
        exit;
    } else {

        $item = new Receber;
        $item->data            = $_POST['data'];
        $item->vencimento      = $_POST['vencimento'];
        $item->disponivel      = 1;
        $item->qtd             = 1;
        $item->setores_id      = 3;
        $item->numero          = $_POST['numero'];
        $item->servicos_id     = 3;
        $item->clientes_id     = $_POST['clientes_id'];
        $item->usuarios_id     = $usuario;
        $item->gaiolas_id      = $id_gaiola;
        $item->cadastar();

        $receber_id = $item->id;

        $item2 = new Boleto;
        $item2->data            = $_POST['data'];
        $item2->vencimento      = $_POST['vencimento'];
        $item2->codigo          = $_POST['codbarra'];
        $item2->destinatario    = $_POST['codbarra'];
        $item2->numero          = "Sem/Numero";
        $item2->endereco        = "";
        $item2->logradouro      = "";
        $item2->bairro          = "";
        $item2->municipio       = 'São Luis ';
        $item2->estado          = 'Maranhão';
        $item2->cep             = '650000';
        $item2->tipo            = 'BOLETOS';
        $item2->status          = 3;
        $item2->entregadores_id = 195;
        $item2->ocorrencias_id  = 18;
        $item2->receber_id      = $receber_id;

        $item2->cadastar();
    }
}

header('location: ../lotes/lote-list.php?');
exit;

// FIM