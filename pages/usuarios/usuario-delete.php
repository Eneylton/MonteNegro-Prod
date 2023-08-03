<?php 

require __DIR__.'../../../vendor/autoload.php';

use \App\Entidy\Usuario;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$usuarios = Usuario::getUsuariosID($_GET['id']);

if(!$usuarios instanceof Usuario){
    header('location: index.php?status=error');

    exit;
}



if(!isset($_POST['excluir'])){
    
 
    $usuarios->excluir();

    header('location: usuario-list.php?status=del');

    exit;
}

