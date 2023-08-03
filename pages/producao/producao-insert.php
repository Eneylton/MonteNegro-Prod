<?php 

require __DIR__.'../../../vendor/autoload.php';


use App\Session\Login;

$usuariologado = Login:: getUsuarioLogado();

$usuario = $usuariologado['id'];

$calculo = 0;
$qtd = 0;

Login::requireLogin();


  
   