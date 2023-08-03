<?php 

require __DIR__.'../../../vendor/autoload.php';

$alertaCadastro = '';

use App\Entidy\Backlog;
use App\Entidy\Devigaiola;
use App\Entidy\Gaiola;
use App\Entidy\Producao;
use App\Entidy\Receber;
use App\Entidy\Retorno;
use App\Session\Login;

Login::requireLogin();

$qtd = 0;
$disponivel = 0;
$soma = 0;

$calculo = 0;
$qtd = 0;
$receber_id = 0;
$qtd_recebida = 0;
$qtd_atual = 0;
$qtd_total = 0;

if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$calculado = 0;

if(isset($_GET['id'])){

   if($_GET['tipo_id'] == 1){

    $value = Gaiola:: getID('*','gaiolas',$_GET['gaiola_id'],null,null);
    
    $qtd  = $value->qtd;
    
    $calculado = ($qtd + $_GET['qtd']);

    $value->qtd = $calculado;
   
    $value->atualizar();
    
    $retorno = Retorno:: getID('*','retorno',$_GET['retorno_id'],null,null);

    $retorno->status = 1;

    $retorno-> atualizar();

    $item = new Devigaiola;

    $item->data = $_GET['data'];
    $item->qtd = $_GET['qtd'];
    $item->status = 1;
    $item->entregadores_id = $_GET['entregadores_id'];
    $item->ocorrencias_id = $_GET['ocorrencia'];
    $item->tipo_id = $_GET['tipo_id'];

    $item->cadastar();

    $qtd_recebida = $_GET['qtd'];
    $value = Producao::getentregadorID('*', 'producao', $_GET['entregadores_id'], null, null);
    $receber_id = $value->receber_id;

    $result = Receber:: getID('*','receber',$receber_id,null,null);
    $qtd_atual = $result->disponivel;

    $qtd_total = ($qtd_atual + $qtd_recebida);

    $result->disponivel       = $qtd_total;
    $result-> atualizar();

    header('location: retorno-list.php?status=edit');

    exit;

   }else{

    $retorno = Retorno:: getID('*','retorno',$_GET['retorno_id'],null,null);

    $retorno->status = 1;

    $retorno-> atualizar();


    $item = new Backlog;

    $item->data = $_GET['data'];
    $item->qtd = $_GET['qtd'];
    $item->status = 1;
    $item->entregadores_id = $_GET['entregadores_id'];
    $item->ocorrencias_id = $_GET['ocorrencia'];
    $item->tipo_id = $_GET['tipo_id'];

    $item->cadastar();

    header('location: retorno-list.php?status=edit');

    exit;

   }

   
}


