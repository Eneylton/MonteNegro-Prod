<?php 

require __DIR__.'../../../vendor/autoload.php';

define('TITLE','Novo Usuário');
define('BRAND','Cadastrar Usuário');

use App\Entidy\Rota;
use   \App\Session\Login;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();


if(isset($_POST['nome'])){

        $item = new Rota;
        $item->nome = $_POST['nome'];
        $item->regioes_id = $_POST['regioes_id'];
        $item->gaiolas_id = $_POST['gaiolas_id'];
        $item->entregadores_id = $_POST['entregadores_id'];
        $item->cadastar();

        header('location: rota-list.php?status=success');
        exit;
    }
  
   