<?php

use App\Entidy\Boleto;
use App\Entidy\Destinatario;
use App\Session\Login;

require __DIR__ . '../../../vendor/autoload.php';

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

$acesso = $usuariologado['acessos_id'];

date_default_timezone_set('America/Sao_Paulo');

$data = date('Y-m-d\TH:i:s', time());

$dados = "";

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$res = Boleto::getID('*', 'boletos', $param, null, null, null);

$dest_id = $res->destinatario_id;
$res_id = $res->receber_id;

$resdest = Destinatario::getID('*','destinatario',$dest_id,null,null,null);

$id               = $resdest->id;
$cpf              = $resdest->cpf;
$nome             = $resdest->nome;
$logradouro       = $resdest->logradouro;
$complemento      = $resdest->complemento;
$numero           = $resdest->numero;
$bairro           = $resdest->bairro;
$municipio        = $resdest->municipio;
$uf               = $resdest->uf;
$cep              = $resdest->cep;
$pais             = $resdest->pais;
$telefone         = $resdest->telefone;
$telefone2        = $resdest->telefone2;
$email            = $resdest->email;
$flag             = 1;
$notafiscal_id    = $resdest->notafiscal_id;

$dados .= ' 
            <input type="hidden" name="id" value="' . $id . '">
            <input type="hidden" name="id_param" value="' . $res_id . '">
            <input type="hidden" name="flag" value="' . $flag . '">
            <div class="row">
            <div class="col-4">

            <div class="form-group">
            <label>Endereço</label>
            <input style="text-transform:uppercas" type="text" class="form-control" name="logradouro" value="' . $logradouro . '">
            </div>
        
             </div>
            <div class="col-3">

            <div class="form-group">
            <label>Cep</label>
            <input style="text-transform:uppercas" type="text" class="form-control" name="cep" value="' . $cep . '">
            </div>
        
             </div>

             <div class="col-2">

             <div class="form-group">
             <label>Nº</label>
             <input style="text-transform:uppercas" type="text" class="form-control" name="numero" value="' . $numero . '">
             </div>
      
             </div>
             <div class="col-3">

             <div class="form-group">
             <label>Bairro</label>
             <input style="text-transform:uppercas" type="text" class="form-control" name="bairro" value="' . $bairro . '">
             </div>
      
             </div>
             <div class="col-6">

             <div class="form-group">
             <label>Complemento</label>
             <input style="text-transform:uppercas" type="text" class="form-control" name="complemento" value="' . $complemento . '">
             </div>
      
             </div>
             <div class="col-3">

             <div class="form-group">
             <label>Telefone</label>
             <input style="text-transform:uppercas" type="text" class="form-control" name="telefone" value="' . $telefone . '">
             </div>
      
             </div>
             <div class="col-3">

             <div class="form-group">
             <label>Whatsapp</label>
             <input style="text-transform:uppercas" type="text" class="form-control" name="telefone2" value="' . $telefone2 . '">
             </div>
      
             </div>

            </div>
           </div>
               ';
$retorna = ['erro' => false, 'dados' => $dados];

echo json_encode($retorna);

