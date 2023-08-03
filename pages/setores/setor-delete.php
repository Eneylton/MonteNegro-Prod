<?php 

require __DIR__.'../../../vendor/autoload.php';

use \App\Entidy\Setor;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Setor::getID('*','setores',$_GET['id'],null,null);

if(!$value instanceof Setor){
    header('location: index.php?status=error');

    exit;
}



if(!isset($_POST['excluir'])){
    
 
    $value->excluir();

    header('location: setor-list.php?status=del');

    exit;
}

