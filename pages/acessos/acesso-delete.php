<?php 

require __DIR__.'../../../vendor/autoload.php';

use \App\Entidy\Acesso;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Acesso::getID('*','acessos',$_GET['id'],null,null);

if(!$value instanceof Acesso){
    header('location: index.php?status=error');

    exit;
}



if(!isset($_POST['excluir'])){
    
 
    $value->excluir();

    header('location: acesso-list.php?status=del');

    exit;
}

