<?php 

require __DIR__.'../../../vendor/autoload.php';

use App\Entidy\Entrega;
use App\Entidy\Gaiola;
use App\Entidy\Retgaiola;

$calculado = 0;
$qtd_retorno = 0;
$calculo = 0;
$soma = 0;
$soma2 = 0;
$producao_id = 0;
$entregador_id = 0;
$qtd_producao = 0;
$gaiolas_id = 0;

if(isset($_GET['id'])){

    $producao_id    = $_GET['producao_id'];
    $entregador_id  = $_GET['entregadores_id'];
    $qtd_producao   = $_GET['entreque'];
    $gaiolas_id     = $_GET['gaiolas_id'];

    $value = Gaiola:: getID('*','gaiolas',$gaiolas_id,null,null);
    
    $qtd  = $value->qtd;
    
    $calculado = ($qtd - $_GET['entreque']);

    $value->qtd = $calculado;
   
    $value->atualizar();

    date_default_timezone_set('America/Sao_Paulo');
    $hoje = date("Y-m-d H:i:s");   

    $result = Retgaiola:: getProducaoID('*','retorno_gaiola',$producao_id ,null,null);
    $qtd_retorno = $result->qtd;
    $calculo = ($qtd_producao - $qtd_retorno);
    if($calculo == 0 ){
        $result->qtd =  $calculo;
        $result->data = $hoje;
        $result->status = 0;
        $result->atualizar();
    }else{
        $result->qtd =  $calculo;
        $result->data = $hoje;
        $result->status = 1;
        $result->atualizar();
    }

    $item = new Entrega;

    $item->data                        = $hoje;
    $item->qtd                         = $qtd_producao;
    $item->producao_id                 = $producao_id;
    $item->entregadores_id             = $entregador_id;

    $item->cadastar();

    header('location: retgaiola-list.php');

    exit;


    
}





