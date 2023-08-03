<?php 

require __DIR__.'../../../vendor/autoload.php';

define('TITLE','Novo Usuário');
define('BRAND','Cadastrar Usuário');

use App\Entidy\Usuario;
use App\Session\Login;


$usuariologado = Login:: getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();

if(isset($_POST['nome'],$_POST['email'],$_POST['senha'])){

    $userEmail = Usuario:: getUsuariosEmail('*','usuarios',$_POST['email'],null,null);

    if($userEmail instanceof Usuario){

        header('location: usuario-list.php?status=mail');
        exit;
        
    }else{

        $userEmail = new Usuario;
        $userEmail->nome = $_POST['nome'];
        $userEmail->email = $_POST['email'];
        $userEmail->cargos_id = $_POST['cargos_id'];
        $userEmail->acessos_id = $_POST['acessos_id'];
        $userEmail->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    
        $userEmail->cadastar();

        header('location: usuario-list.php?status=success');
        exit;
    }
  
   


} 
