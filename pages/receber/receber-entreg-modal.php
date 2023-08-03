<?php

use App\Entidy\Receber;

require __DIR__ . '../../../vendor/autoload.php';

$dados = "";
$contador = 0;
$qtd = 0;

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$rec = Receber :: getID('*','receber',$param,null,null);

$qtd = $rec->qtd;

$dados .= '


            <label>Quantidade para entrega</label>
            <input type="text" class="form-control" name="qtd" value="'.$qtd.'">
            <input type="hidden" name="receber_id" value="'.$param.'">

            

           
            


';

                $retorna = ['erro' => false, 'dados' => $dados];

                echo json_encode($retorna);
