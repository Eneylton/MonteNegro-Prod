<?php

use App\Entidy\Producao;

require __DIR__ . '../../../vendor/autoload.php';

$dados = "";
$contador = 0;
$qtd = 0;

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$buscar = Producao::getID('*', 'producao', $param, null, null);

$id = $buscar->id;
$entregador = $buscar->entregadores_id;
$receber = $buscar->receber_id;
$qtd  = $buscar->qtd;

date_default_timezone_set('America/Sao_Paulo');
$data =  date('Y-m-d\TH:i:s', time());

$dados .= '

            <input type="hidden" name="producao_id" value="' . $id . '">
            <input type="hidden" name="entregadores_id" value="' . $entregador  . '">
            <input type="hidden" name="receber_id" value="' . $receber . '">

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
                    <label>Quantidade entregue</label>
                    <input style="text-transform: uppercase;" type="text" class="form-control" name="qtd"
                        value="' . $qtd . '" autofocus required>
</div>

</div>


</div>

';

$retorna = ['erro' => false, 'dados' => $dados];

echo json_encode($retorna);