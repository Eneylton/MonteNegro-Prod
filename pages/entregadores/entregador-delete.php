<?php 

require __DIR__.'../../../vendor/autoload.php';

use \App\Entidy\Entregador;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Entregador::getID('*','entregadores',$_GET['id'],null,null);


if(!$value instanceof Entregador){
    header('location: index.php?status=error');

    exit;
}



if(!isset($_POST['excluir'])){
    
 
    $value->excluir();

    header('location: entregador-list.php?status=del');

    exit;
}

