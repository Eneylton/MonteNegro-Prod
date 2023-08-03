<?php 

require __DIR__.'/vendor/autoload.php';

use \App\Entidy\Usuario;
use   \App\Session\Login;


Login::requireLogout();


$alertaLogin  = '';
$alertaCadastro = '';

if(isset($_POST['acao'])){
  
    switch ($_POST['acao']) {
        case 'logar':
            
            $obUsurio = Usuario:: getParam('*','usuarios','email= "'.$_POST['email'].'"');
            
            if(!$obUsurio instanceof Usuario || !password_verify($_POST['senha'],$obUsurio->senha)){
                $alertaLogin = 'Usuário ou Senha estão Inválidos';
                break;
            }

            Login:: login($obUsurio);
             
            break;
        
            case 'cadastrar':
                
            if(isset($_POST['nome'],$_POST['email'],$_POST['senha'])){

                $obUsurio = Usuario:: getParam($_POST['email']);

                if($obUsurio instanceof Usuario){
                    $alertaCadastro = 'Email já está em uso !!!';
                    break;
                }
              
                $obUsurio = new Usuario;
                $obUsurio->nome = $_POST['nome'];
                $obUsurio->email = $_POST['email'];
                $obUsurio->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

                $obUsurio->cadastar();

                Login:: login($obUsurio);
            

            } 

            break;
    }

}

include __DIR__.'/includes/login/header.php';
include __DIR__.'/includes/login/content.php';
include __DIR__.'/includes/login/footer.php';