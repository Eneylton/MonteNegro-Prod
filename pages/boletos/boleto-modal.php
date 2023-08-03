<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Boleto;
use App\Entidy\Entregador;
use App\Entidy\Ocorrencia;

$dados = "";
$contador = 0;
$contar = 0;
$list_select = "";
$list_select2 = "";
$selected = "";
$checked = "";

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$value = Boleto::getID('*', 'boletos', $param, null, null);

$entregador_id = $value->entregadores_id;

$ocorrencias = Ocorrencia::getList('*', 'ocorrencias', null, null, 'nome ASC');

foreach ($ocorrencias  as $item) {

   $list_select .= '<option value="' . $item->id . '">' . $item->nome . '</option>';
}

$entregador = Entregador::getList('*', 'entregadores', null, null, 'nome ASC');

$listEntregar = Entregador::getID('*', 'entregadores', $entregador_id, null, null, null);



foreach ($entregador  as $item) {

   if ($item->id == $entregador_id) {
      $select_entre = "selected";
   } else {
      $select_entre = "";
   }

   $contar += 1;
   $list_select2 .= '<option value="' . $item->id . '"' . $select_entre . '>' . $contar . ' - ' . $item->apelido . '</option>';
}

$id              = $value->id;
$receber_id      = $value->receber_id;
$codigo          = $value->codigo;
$data            = $value->data;
$status          = $value->status;
$tipo            = $value->tipo;
$destinatario    = $value->destinatario;


$dados .= '<div class="row">

            <div class="col-12">
               <div class="form-group">
               <input type="hidden" name="id" value="' . $id . '">
               <input type="hidden" name="receber_id" value="' . $receber_id . '">
               <input type="hidden" name="codigo" value="' . $codigo . '">
               <input type="hidden" name="destinatario" value="' . $destinatario . '">
               <label>Data</label>
               <input style="text-transform:uppercase" type="datetime-local" class="form-control" name="data" value="' . $data . '">
               </div>
            </div>

            <div class="col-6">
               <div class="form-group">
               <label>Destinatário</label>
               <input disabled style="text-transform:uppercas" type="text" class="form-control" name="destinatario" value="' . $destinatario . '">
               </div>
            </div>
            <div class="col-6">
               <div class="form-group">
               <label>Tipo</label>
               <input disabled style="text-transform:uppercas" type="text" class="form-control" name="tipo" value="' . $tipo . '">
               </div>
            </div>
            <div class="col-12">
            <div class="form-group">
                                  <label>Entregadores</label>
                                  <select class="form-control select" style="width: 100%;" name="entregador_id" autofocus
                                      required>
                                  
  
                                      ' . $list_select2 . '
                                   
                                   </select>
           </div>
            </div>
            <div class="col-3">

               <div class="form-group">
                   <label>Status</label>
               
                   <div class="form-group clearfix">
                   <div class="icheck-success d-inline">
                   <input type="radio" id="radioPrimary1" name="status" value="1">
                   <label for="radioPrimary1">
                   Entregue
                   </label>
                 </div>

                  <div class="icheck-danger d-inline">
                   <input type="radio" id="radioPrimary2" name="status" value="2" >
                   <label for="radioPrimary2">
                   Devolvido
                   </label>
                   </div>
                   </div>
                        
               </div>  

          </div>
          <div class="col-3">

          <div class="form-group">
              <label style="color:#fff">Status</label>
          
              <div class="form-group clearfix">
              <div class="icheck-warning d-inline">
              <input type="radio" id="radioPrimary3" name="status" value="3" >
              <label for="radioPrimary3">Aguardando
              </label>
            </div>
               <div class="icheck-info d-inline">
              <input type="radio" id="radioPrimary4" name="status" value="4">
              <label for="radioPrimary4">Em Rota
              </label>
               </div>
              </div>
                   
          </div>  

     </div>
          <div class="col-6">
          <div class="form-group">
                                <label>Ocorrências</label>
                                <select class="form-control select" style="width: 100%;" name="ocorrencias_id"
                                    required>
                                    <option value="18">Nenhum</option>

                                    ' . $list_select . '
                                 
                                 </select>
         </div>
          </div>
          <div class="col-12">
          <div class="form-group">
          <label>Observação</label>
          <textarea class="form-control" rows="3" placeholder="Digite...." name="obs"></textarea>
          </div>
          </div>
          </div>
';

$retorna = ['erro' => false, 'dados' => $dados];

echo json_encode($retorna);
