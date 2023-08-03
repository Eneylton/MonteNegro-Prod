<?php

use App\Entidy\Boleto;
use App\Entidy\Cliente;
use App\Entidy\Destinatario;
use App\Entidy\NotaFiscal;
use App\Entidy\Produto;
use App\Entidy\Receber;
use App\Session\Login;

require __DIR__ . '../../../vendor/autoload.php';

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

$acesso = $usuariologado['acessos_id'];

$foto = "";

date_default_timezone_set('America/Sao_Paulo');

$data = date('Y-m-d\TH:i:s', time());

$dados = "";

$resultados  = "";

$icon = "";

$timeline = '';

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$boletos = Boleto::getID('*', 'boletos', $param, null, null, null);

$res = $boletos->receber_id;

$destinatario_id = $boletos->destinatario_id;

$destinatario = Destinatario::getID('*', 'destinatario', $destinatario_id, null, null, null);

$receber = Receber::getID('*', 'receber', $res, null, null, null);

$id_cliente = $receber->clientes_id;

$cli = Cliente::getID('*', 'clientes', $id_cliente, null, null, null);

$cli_foto = $cli->foto;

$nome = $destinatario->nome;
$logradouro = $destinatario->logradouro;
$numero = $destinatario->numero;
$bairro = $destinatario->bairro;
$municipio = $destinatario->municipio;
$uf = $destinatario->uf;
$cep = $destinatario->cep;
$cep = $destinatario->cep;
$pais = $destinatario->pais;
$telefone = $destinatario->telefone;
$email = $destinatario->email;

$notafiscal_id = $destinatario->notafiscal_id;

$notafiscal = NotaFiscal::getID('*', 'notafiscal', $notafiscal_id, null, null, null);

$cliente = $notafiscal->razaosocial;
$cnpj = $notafiscal->cnpj;
$notadata = $notafiscal->data;
$chave = $notafiscal->chave;

$produtos = Produto::getIDProdutos('*', 'produtos', $notafiscal_id, null, null, null);

foreach ($produtos as $item) {
  $resultados .= ' <tr>
   
    <td>' . $item->id . '</td>
    <td>' . $item->nome . '</td>
    <td>' . $item->qtd . '</td>
    <td>' . $item->valor_prod . '</td>
   
  </tr>';
}

$dados .= '

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
          <div class="callout callout-info">
            <div class="row">
            <div class="col-3">
            <img src="../.' . $cli_foto . '" style="width:150px; heigth:40px">
            </div>
                <div class="col-9">
                <address>
                <strong><span style="text-transform:uppercase;font-size:18px">' . $cliente . '</strong><br>
                ' . $cnpj . '<br>
                <small class="float-right"><span style="font-size:16px">Data : ' . date('d/m/Y -- H:i:s', strtotime($notadata)) . '</span></small>
                </address>
                </div>
              
              
            </div>

            
            </div>

            <div class="invoice p-3 mb-3">
            <div class="row">
            <div class="col-12">

            <h4>
            <i class="fas fa-globe"></i>&nbsp; Consultor(a) : <strong><span style="font-size:18px">' . $nome . '</span></strong>
        
            </h4>

            </div>
            <div class="col-6">
            <address>
            <strong>Endereço :</strong><br>
            ' . $logradouro . ' - Nº: ' . $numero . ', Bairro : ' . $bairro . ' CEP : ' . $cep . ' - ' . $municipio . '-' . $uf . '
           
            </address>
            </div>
            <div class="col-6">
            <address>
            <strong>Contato :</strong><br>
            E-mail : ' . $email . '</br>
            Telefone :' . $telefone . '
            
            </address>
            </div>
            <div class="col-12">

            <div class="card-body table-responsive p-0" style="height: 200px;">
                <table class="table table-head-fixed text-nowrap table-stripe">
            <thead>
              <tr>
                <th scope="col">Nª</th>
                <th scope="col">Produlto</th>
                <th scope="col">Qtd</th>
                <th scope="col">Valor</th>
            
              </tr>
            </thead>
              <tbody>
                   ' . $resultados . '
              </tbody>
             
              </table>
</div>
<div class="col-12">
<strong><span style="text-transform:uppercase;font-size:18px">Código de Barras</strong><br>
<span class="barra">' . $chave . '</span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>      
</section>

';

$retorna = ['erro' => false, 'dados' => $dados];

echo json_encode($retorna);
