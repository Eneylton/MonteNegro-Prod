<?php 

require __DIR__.'../../../vendor/autoload.php';

define('TITLE','Novo Região');
define('BRAND','Cadastrar Região');

use App\Entidy\Regiao;
use   \App\Session\Login;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();

if(isset($_POST['nome'])){

        $item = new Regiao;
        $item->nome = $_POST['nome'];
        $item->cadastar();

        header('location: regiao-list.php?status=success');
        exit;
    }
  
   




include __DIR__.'../../../includes/layout/header.php';
include __DIR__.'../../../includes/layout/top.php';
include __DIR__.'../../../includes/layout/menu.php';
include __DIR__.'../../../includes/layout/content.php';
include __DIR__.'../../../includes/usuario/usuario-form-insert.php';
include __DIR__.'../../../includes/layout/footer.php';