<?php 

require __DIR__.'../../../vendor/autoload.php';

use \App\Entidy\Servico;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Servico::getID('*','servicos',$_GET['id'],null,null);

if(!$value instanceof Servico){
    header('location: index.php?status=error');

    exit;
}



if(!isset($_POST['excluir'])){
    
 
    $value->excluir();

    header('location: servico-list.php?status=del');

    exit;
}

