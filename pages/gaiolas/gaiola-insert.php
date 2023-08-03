<?php 

require __DIR__.'../../../vendor/autoload.php';

define('TITLE','Novo Usuário');
define('BRAND','Cadastrar Usuário');

use App\Entidy\Gaiola;
use App\Session\Login;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();


if(isset($_POST['nome'])){

        $item = new Gaiola;
        $item->nome = $_POST['nome'];
        $item->qtd = $_POST['qtd'];
        $item->rotas_id = $_POST['rotas_id'];
        $item->cadastar();

        header('location: gaiola-list.php?status=success');
        exit;
    }
  
   