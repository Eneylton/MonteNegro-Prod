<?php 

require __DIR__.'../../../vendor/autoload.php';

define('TITLE','Novo Categoria');
define('BRAND','Cadastrar Categoria');

use \App\Entidy\Categoria;
use  \App\Session\Login;
use   \App\File\Upload;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();

Login::requireLogin();

if(isset($_FILES['arquivo'])){
    $obUpload = new Upload ($_FILES['arquivo']);
    $sucesso = $obUpload->upload(__DIR__.'../../../imgs',false);
    $obUpload->gerarNovoNome();

    if($sucesso){

        echo 'Arquivo Enviado ' .$obUpload->getBasename(). "com Sucesso" ;

        if(isset($_POST['nome'])){


            $item = new Categoria;
            $item->nome = $_POST['nome'];
            $item->foto = $obUpload->getBasename();
            $item->cadastar();
    
            header('location: categoria-list.php?status=success');
            exit;
        }

    }

}

if(isset($_POST['nome'])){


    $item = new Categoria;
    $item->nome = $_POST['nome'];
    $item->foto = "";
    $item->cadastar();

    header('location: categoria-list.php?status=success');
    exit;
}
