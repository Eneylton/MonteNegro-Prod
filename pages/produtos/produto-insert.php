<?php 

require __DIR__.'../../../vendor/autoload.php';

use App\Entidy\Produto;
use App\Session\Login;
use App\File\Upload;

date_default_timezone_set('America/Sao_Paulo');
$agora = date('Y-m-d');

$usuariologado = Login:: getUsuarioLogado();

$usuario_id = $usuarios_id = $usuariologado['id'];

$codigo = substr(uniqid(rand()), 0, 6);
$barcode = '789'.substr(uniqid(rand()), 0, 10);

Login::requireLogin();

if($_POST['barra'] == ""){
$barra = $barcode;
}else{
    $barra = $barcode;
    $barraProduto = Produto:: getID('*','produtos',$barra,null,null);
if($barraProduto instanceof Produto){
    header('location: produto-list.php?status=barra');
    exit;
}
}

if(isset($_FILES['arquivo'])){
    $obUpload = new Upload ($_FILES['arquivo']);
    $sucesso = $obUpload->upload(__DIR__.'../../../imgs',false);
    $obUpload->gerarNovoNome();

    if($sucesso){

        echo 'Arquivo Enviado ' .$obUpload->getBasename(). "com Sucesso" ;

        if(isset($_POST['categorias_id'])){

             
            $item = new Produto;

            $item->codigo               = $codigo;
            $item->data                 = $agora;
            $item->usuarios_id          = $usuario_id;
            $item->categorias_id        = $_POST['categorias_id'];
            $item->barra                = $barra;
            $item->nome                 = $_POST['nome'];
            $item->valor_compra         = $_POST['valor_compra'];
            $item->valor_venda          = $_POST['valor_venda'];
            $item->aplicacao            = $_POST['aplicacao'];
            $item->status               = 0;
            $item->qtd                  = $_POST['qtd'];
            $item->foto                 = $obUpload->getBasename();
            $item->cadastar();
    
            header('location: produto-list.php?status=success');
            exit;
        }

    }

}

if(isset($_POST['categorias_id'])){
             
    $item = new Produto;

    $item->codigo               = $codigo;
    $item->data                 = $agora;
    $item->usuarios_id          = $usuario_id;
    $item->categorias_id        = $_POST['categorias_id'];
    $item->barra                = $barra;
    $item->nome                 = $_POST['nome'];
    $item->valor_compra         = $_POST['valor_compra'];
    $item->valor_venda          = $_POST['valor_venda'];
    $item->aplicacao            = $_POST['aplicacao'];
    $item->estoque              = $_POST['estoque'];
    $item->status               = 0;
    $item->qtd                  = 0;
    $item->foto                 = "";
    $item->cadastar();

    header('location: produto-list.php?status=success');
    exit;
}