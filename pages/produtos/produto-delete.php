<?php 

require __DIR__.'../../../vendor/autoload.php';

use \App\Entidy\Produto;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Produto::getID('*','produtos',$_GET['id'],null,null);

if(!$value instanceof Produto){
    header('location: index.php?status=error');

    exit;
}



if(!isset($_POST['excluir'])){
    
 
    $value->excluir();

    header('location: produto-list.php?status=del');

    exit;
}

