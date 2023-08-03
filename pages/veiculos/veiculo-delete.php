<?php 

require __DIR__.'../../../vendor/autoload.php';

use \App\Entidy\Veiculo;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Veiculo::getID('*','veiculos',$_GET['id'],null,null);

if(!$value instanceof Veiculo){
    header('location: index.php?status=error');

    exit;
}



if(!isset($_POST['excluir'])){
    
 
    $value->excluir();

    header('location: veiculo-list.php?status=del');

    exit;
}

