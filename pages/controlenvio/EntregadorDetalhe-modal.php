<?php

use App\Entidy\ControlEnvio;
use App\Entidy\Entregador;
use App\Entidy\EntregadorDetalhe;
use App\Entidy\Ocorrencia;
use App\Entidy\StatusDetalhe;

require __DIR__ . '../../../vendor/autoload.php';

date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d\TH:i:s', time());
$dados = "";
$cont = 0;
$selectded_entregador = "";
$select_entreg = "";
$select_ocorre = "";
$select = "";
$radioBox = "";
$radio = "";

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$controle = ControlEnvio::getID('*', 'controlenvio', $param, null, null, null);

$res = EntregadorDetalhe::getIDDetalhe('*', 'entregador_detalhe', $param, null, null, null);

$id = $res->id;
$status = $controle->status;
$ocorrencias_id   = $res->ocorrencias_id;
$entregadores_id  = $controle->entregadores_id;
$controlenvio_id  = $res->controlenvio_id;
$obs = $res->obs;

$res->atualizar();

$entregadores = Entregador::getList('*', 'entregadores', null, null, 'apelido ASC');

foreach ($entregadores as $item) {

    $cont++;

    if ($item->id == $entregadores_id) {

        $selectded_entregador = "selected";
    } else {

        $selectded_entregador = "";
    }

    $select_entreg .= '<option ' . $selectded_entregador . ' style="text-transform: uppercase;" value="' . $item->id . '" >' . $cont . '-' . $item->apelido . '</option>';
}


$ocorencias = Ocorrencia::getList('*', 'ocorrencias', null, null, 'nome ASC');

foreach ($ocorencias as $item) {

    $cont++;

    if ($item->id == $ocorrencias_id) {

        $select = "selected";
    } else {

        $select = "";
    }

    $select_ocorre .= '<option ' . $select . ' style="text-transform: uppercase;" value="' . $item->id . '" >' . $cont . '-' . $item->nome . '</option>';
}

$detalhes = StatusDetalhe::getList('*', 'status_detalhe');

foreach ($detalhes as $item) {

    if ($item->id == $status) {

        $radio = "checked";
    } else {

        $radio = "";
    }

    $radioBox .= '
    <div class="icheck-info d-inline">
            <input type="radio" id="' . $item->id . '" name="status" value="' . $item->id . '" ' . $radio . '>
            <label for="' . $item->id . '">
            ' . $item->nome . '
            </label>
    </div>
';
}


$dados .= '<div class="row">
              <input class="form-control" type="hidden" name="codid" value="' . $param . '">
                 
                <div class="col-4">
                    <div class="form-group">
                        <label>Recebido em: </label>
                        <input value="' . $data . '" type="datetime-local" class="form-control" name="data" >
                    </div>
                </div>
              
                <div class="col-8">

                <div class="form-group">
                    <label>Status</label>

                    <div class="form-group clearfix">
                    
                    ' . $radioBox . '
                     
                    </div>
                    
                </div>
                </div>
                <div class="col-6">
                <div class="form-group">
                <label>Entregadores</label>
                <select class="form-control select" style="width: 100%;" name="entregadores_id"required>
                <option value="">Selecione</option>
    
                ' .  $select_entreg . '
    
                </select>
                </div>
            </div>
            <div class="col-6">
            <div class="form-group">
            <label>Ocorrências</label>
            <select class="form-control select" style="width: 100%;" name="ocorrencias_id"required>
            <option value="">Selecione</option>
            
            ' .  $select_ocorre . '
            
            </select>
            </div>
            </div>
            <div class="col-6">
            <div class="form-group">
            <label>Observações</label>
            <textarea value="' . $obs . '" name="obs" class="form-control" rows="3" placeholder="Enter ...">' . $obs . '</textarea>
            </div>


            </div>

               
            </div>

            
            ';

$retorna = ['erro' => false, 'dados' => $dados];

echo json_encode($retorna);
