<?php 

require __DIR__.'../../../vendor/autoload.php';



$alertaCadastro = '';

define('TITLE','Editar Forma Pagamentos');
define('BRAND','Forma Pagamento');

use \App\Entidy\FormaPagamento;
use   \App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = FormaPagamento:: getID('*','forma_pagamento',$_GET['id'],null,null);


if(!$value instanceof FormaPagamento){
    header('location: index.php?status=error');

    exit;
}



if(isset($_GET['nome'])){
    
    $value->nome = $_GET['nome'];
    $value-> atualizar();

    header('location: formaPagamento-list.php?status=edit');

    exit;
}


