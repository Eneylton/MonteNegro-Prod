<?php

use App\Entidy\Gaiola;

require __DIR__ . '../../../vendor/autoload.php';

$dados = "";
$contador = 0;

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$value = Gaiola::getID('*','gaiolas',$param ,null,null);

$id    = $value->id;
$nome  = $value->nome;
$qtd   = $value->qtd;

$dados .= '<div class="row">

            <div class="col-12">
               <div class="form-group">
               <input type="hidden" name="id" value="'.$id.'">
               <label>Nome</label>
               <input style="text-transform:uppercas" type="text" class="form-control" name="nome" value="'.$nome.'">
               </div>
            </div>

            <div class="col-6">
               <div class="form-group">
               <label>Qtd</label>
               <input style="text-transform:uppercas" type="text" class="form-control" name="qtd" value="'.$qtd.'">
               </div>
            </div>

          </div>
            


';

                $retorna = ['erro' => false, 'dados' => $dados];

                echo json_encode($retorna);
