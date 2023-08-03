<?php 

require __DIR__.'../../../vendor/autoload.php';



$alertaCadastro = '';

define('TITLE','Editar Usuários');
define('BRAND','Editar Usuários');

use \App\Entidy\Rota;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$item = Rota:: getID('*','rotas',$_GET['id'],null,null);


if(!$item instanceof Rota){
    header('location: index.php?status=error');

    exit;
}



if(isset($_GET['nome'])){
    
    $item->nome = $_GET['nome'];
    $item->regioes_id = $_GET['regioes_id'];
    $item->gaiolas_id = $_GET['gaiolas_id'];
    $item-> atualizar();

    header('location: rota-list.php?status=edit');

    exit;
}


