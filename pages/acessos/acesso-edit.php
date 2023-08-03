<?php 

require __DIR__.'../../../vendor/autoload.php';



$alertaCadastro = '';

define('TITLE','Editar Usuários');
define('BRAND','Editar Usuários');

use \App\Entidy\Acesso;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Acesso:: getID('*','cargos',$_GET['id'],null,null);


if(!$value instanceof Acesso){
    header('location: index.php?status=error');

    exit;
}



if(isset($_GET['nivel'])){
    
    $value->nivel = $_GET['nivel'];
    $value-> atualizar();

    header('location: acesso-list.php?status=edit');

    exit;
}


