<?php 

require __DIR__.'../../../vendor/autoload.php';

use \App\Entidy\Cliente;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Cliente::getID('*','clientes',$_GET['id'],null,null);

if(!$value instanceof Cliente){
    header('location: index.php?status=error');

    exit;
}


if(!isset($_POST['excluir'])){
    
 
    $value->excluir();

    header('location: cliente-list.php?status=del');

    exit;
}

