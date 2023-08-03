<?php 

require __DIR__.'../../../vendor/autoload.php';

use \App\Entidy\Gaiola;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Gaiola::getID('*','rotas',$_GET['id'],null,null);

if(!$value instanceof Gaiola){
    header('location: index.php?status=error');

    exit;
}



if(!isset($_POST['excluir'])){
    
 
    $value->excluir();

    header('location: gaiola-list.php?status=del');

    exit;
}

