<?php 

require __DIR__.'../../../vendor/autoload.php';

use \App\Entidy\Cargo;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Cargo::getID('*','cargos',$_GET['id'],null,null);

if(!$value instanceof Cargo){
    header('location: index.php?status=error');

    exit;
}



if(!isset($_POST['excluir'])){
    
 
    $value->excluir();

    header('location: cargo-list.php?status=del');

    exit;
}

