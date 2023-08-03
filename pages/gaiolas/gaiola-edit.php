<?php 

require __DIR__.'../../../vendor/autoload.php';

use App\Entidy\Gaiola;
use App\Session\Login;

Login::requireLogin();

$item = Gaiola:: getID('*','gaiolas',$_GET['id'],null,null);


if(!$item instanceof Gaiola){

    header('location: index.php?status=error');

    exit;
}

if(isset($_GET['nome'])){
    
    $item->nome = $_GET['nome'];
    $item->qtd = $_GET['qtd'];
   
    $item-> atualizar();

    header('location: gaiola-list.php?status=edit');

    exit;
}


