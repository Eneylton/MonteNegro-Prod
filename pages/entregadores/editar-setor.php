<?php

use App\Entidy\Entregador;

require __DIR__ . '../../../vendor/autoload.php';

$dados = "";
$contador = 0;

$id = filter_input(INPUT_GET, "id_cat", FILTER_SANITIZE_NUMBER_INT);

$value = Entregador::getID('*','entregadores',$id ,null,null);

$nome = $value->nome;

$dados .= "<div class='row'>

<div class='col-6'>

<div class='form-group'>
                        <label>Nome</label>
                        <input style='text-transform:uppercas' type='text' class='form-control' name='nome' value='".$nome."'>
                     </div>
                  </div>
                  </div>
            


";

                $retorna = ['erro' => false, 'dados' => $dados];

                echo json_encode($retorna);

?>	