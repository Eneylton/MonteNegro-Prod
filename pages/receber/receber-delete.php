<?php 

require __DIR__.'../../../vendor/autoload.php';

use App\Entidy\Entrega;
use App\Entidy\Gaiola;
use App\Entidy\Producao;
use App\Entidy\Receber;
use App\Session\Login;


Login::requireLogin();

$id_gaiola = 0;
$qtd = 0;
$qtd_baia = 0;
$total_baia = 0;

if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Receber::getID('*','receber',$_GET['id'],null,null);

// $id = $value->id;

// $id_gaiola = $value->gaiolas_id;

// $qtd = $value->qtd;

// $result = Gaiola::getID('*','gaiolas',$id_gaiola,null,null);

// $qtd_baia = $result->qtd;

// $total_baia = ($qtd_baia - $qtd);

// $result_produtor = Producao::getReceberID('*','producao',$id,null,null);

// $id_producao = $result_produtor->id;

// $value_entrega = Entrega ::getEntregaID('*','entrega',$id_producao,null,null);


if(!$value instanceof Receber){
    header('location: index.php?status=error');

    exit;
}



if(!isset($_POST['excluir'])){

    //$result->qtd = $total_baia;
    //$result-> atualizar();
    
    $value->excluir();
   // $value_entrega->excluir();

    header('location: receber-list.php?status=del');

    exit;
}
