<?php

use App\Entidy\Ocorrencia;
use App\Entidy\Producao;

require __DIR__ . '../../../vendor/autoload.php';

$dados = "";
$contador = 0;
$qtd = 0;
$select = "";

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$buscar = Producao::getID('*', 'producao', $param, null, null);

$id = $buscar->id;
$entregador = $buscar->entregadores_id;
$receber = $buscar->receber_id;
$qtd     = $buscar->qtd;

date_default_timezone_set('America/Sao_Paulo');
$data =  date('Y-m-d\TH:i:s', time());

$ocorrencias = Ocorrencia::getList('*', 'ocorrencias', null, null, 'nome ASC');

foreach ($ocorrencias as $item) {
    $select .= '<option style="text-transform: uppercase;" value="' . $item->id . '">' . $item->nome . '</option>';
}

$dados .= '

            <input type="hidden" name="id2" value="' . $id . '">
            <input type="hidden" name="entregadores2_id" value="' . $entregador  . '">
            <div class="row">
            <div class="col-6">

                <div class="form-group">
                    <label>Data de entrega</label>
                    <input value="' . $data . '" type="datetime-local"
                        class="form-control" name="data" required>
                </div>

            </div>
            <div class="col-6">

            <div class="form-group">
            <label>Quantidade devolvida</label>
            <input style="text-transform: uppercase;" type="text" class="form-control" name="qtd"
            value="' . $qtd . '" autofocus required>
            </div>

            </div>

            <div class="col-12">

                            <div class="form-group">
                                <label>Ocorrências</label>
                                <select class="form-control select" style="width: 100%;" name="ocorrencias_id" required>
                                    <option value=""> Selecione um ocorrência</option>
                                    ' . $select . '

</select>

</div>


</div>
</div>

';

$retorna = ['erro' => false, 'dados' => $dados];

echo json_encode($retorna);