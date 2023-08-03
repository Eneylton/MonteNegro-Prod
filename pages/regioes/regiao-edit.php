<?php 

require __DIR__.'../../../vendor/autoload.php';



$alertaCadastro = '';

define('TITLE','Editar Região');
define('BRAND','Região');

use App\Entidy\Regiao;
use App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Regiao:: getID('*','regioes',$_GET['id'],null,null);


if(!$value instanceof Regiao){
    header('location: index.php?status=error');

    exit;
}



if(isset($_GET['nome'])){
    
    $value->nome = $_GET['nome'];
    $value-> atualizar();

    header('location: regiao-list.php?status=edit');

    exit;
}


