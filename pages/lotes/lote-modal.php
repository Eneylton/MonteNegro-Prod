<?php

use App\Entidy\Cliente;
use App\Entidy\Receber;

require __DIR__ . '../../../vendor/autoload.php';


date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d\TH:i:s', time());

$dados = "";
$cont = 0;
$select_cli = "";
$selectded_cli = "";

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$receber = Receber::getID('*', 'receber', $param, null, null, null, null);

$disponivel = $receber->disponivel;
$data = $receber->data;
$vencimento = $receber->vencimento;
$numero = $receber->numero;
$qtd = $receber->qtd;
$clientes_id = $receber->clientes_id;

$clientes = Cliente::getList('*', 'clientes', null, null, 'nome ASC');

foreach ($clientes as $item) {

   $cont++;

   if ($item->id == $clientes_id) {

      $selectded_cli = "selected";
   } else {

      $selectded_cli = "";
   }

   $select_cli .= '<option ' . $selectded_cli . ' style="text-transform: uppercase;" value="' . $item->id . '" >' . $cont . '-' . $item->nome . '</option>';
}


$dados .= '

        
            <input type="hidden" name="receber_id" value="' . $param . '">
            <input type="hidden" name="qtd" value="' . $qtd . '">

            <div class="row">

                  <div class="col-6">
                                 <div class="form-group">
                                    <label>Recebido em: </label>
                                    <input value="' . $data . '" type="datetime-local" class="form-control" name="data" >
                                 </div>
                  </div>
                  <div class="col-6">
                                 <div class="form-group">
                                    <label>Recebido em: </label>
                                    <input value="' . $vencimento . '" type="datetime-local" class="form-control" name="vencimento">
                                 </div>
                  </div>
                  <div class="col-12">
                            <div class="form-group">
                                <label>Numero do lote</label>
                                <input type="text" class="form-control" name="numero" value="' . $numero . '" required>
                            </div>
                  </div>

                  <div class="col-12">
                                  <div class="form-group">
                                    <label>Clientes</label>
                                    <select class="form-control select" style="width: 100%;" name="clientes_id"required>
                                    <option value="">Selecione</option>

                                    ' . $select_cli . '
                                 
                                 </select>
                  </div>
                  </div>
                

                  <div class="col-6">
                            <div class="form-group">
                                <label>Adicionar novo lote</label>

                                <input class="form-control" type="file" name="arquivo[]" multiple> <br><br>
                            </div>
                        
               </div>
            </div>

';

$retorna = ['erro' => false, 'dados' => $dados];

echo json_encode($retorna);