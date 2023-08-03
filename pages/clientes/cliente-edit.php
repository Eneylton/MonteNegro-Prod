<?php 

require __DIR__.'../../../vendor/autoload.php';

use \App\Entidy\Cliente;
use   \App\Session\Login;

Login::requireLogin();


if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$item = Cliente::getID('*','clientes',$_GET['id'],null,null);


if(!$item instanceof Cliente){
    header('location: index.php?status=error');

    exit;
}

if(isset($_GET['nome'])){
    
    $item->nome              = $_GET['nome'];
    $item->setores_id        = $_GET['setores_id'];
    $item-> atualizar();

    header('location: cliente-list.php?status=edit');

    exit;
}



