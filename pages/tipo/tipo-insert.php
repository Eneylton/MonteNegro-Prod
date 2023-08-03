<?php 

require __DIR__.'../../../vendor/autoload.php';

use App\Entidy\Tipo;
use App\Session\Login;

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();


if(isset($_POST['nome'])){

        $item = new Tipo;
        $item->nome = $_POST['nome'];
        $item->cadastar();

        header('location: tipo-list.php?status=success');
        exit;
    }
  