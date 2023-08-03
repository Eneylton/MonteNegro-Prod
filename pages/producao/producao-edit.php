<?php 

require __DIR__.'../../../vendor/autoload.php';



$alertaCadastro = '';

define('TITLE','Editar Usuários');
define('BRAND','Editar Usuários');

use \App\Entidy\Gaiola;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$item = Gaiola:: getID('*','gaiolas',$_GET['id'],null,null);


if(!$item instanceof Gaiola){
    header('location: index.php?status=error');

    exit;
}



if(isset($_GET['nome'])){
    
    $item->nome = $_GET['nome'];
    $item->rotas_id = $_GET['rotas_id'];
    $item-> atualizar();

    header('location: gaiola-list.php?status=edit');

    exit;
}


