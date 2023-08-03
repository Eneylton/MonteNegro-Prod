<?php

use App\Entidy\Combustivel;
use App\Entidy\Entregador;
use App\Entidy\Veiculo;

require __DIR__ . '../../../vendor/autoload.php';

$dados = "";
$section1 = "";
$section2 = "";
$selected_vei  = "";
$selected_enteg  = "";

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$value = Combustivel::getID('*', 'combustivel', $param, null, null);

$entregador_sect = Entregador::getList('*', 'entregadores', null, 'nome ASC');
$veiculos_sect   = Veiculo::getList('*', 'veiculos', null, 'nome ASC');

$id = $value->id;

$id_entregador = $value->entregadores_id;

$id_veiculo = $value->veiculos_id;

$data = $value->data;

$placa = $value->placa;

$valor = $value->valor;

$volar_format = number_format($valor, "2", ",", ".");

$entregadores = Entregador::getList('*', 'entregadores', 'id=' . $id_entregador, null, null);

$veiculos = Veiculo::getList('*', 'veiculos', 'id=' . $id_veiculo, null, null);

foreach ($entregador_sect as $item) {

    if ($item->id == $id_entregador) {

        $selected_enteg = "selected";
    } else {

        $selected_enteg = "";
    }

    $section1 .= '<option value="' . $item->id . '" ' . $selected_enteg . '>' . $item->apelido . '</option>';
}


foreach ($veiculos_sect as $item) {

    if ($item->id == $id_veiculo) {

        $selected_vei = "selected";
    } else {

        $selected_vei = "";
    }

    $section2 .= '<option value="' . $item->id . '" ' . $selected_vei . '>' . $item->nome . '</option>';
}

$dados .= '

            <input type="hidden" name="id" value="' . $id . '">
           

            <div class="row">

            <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Data do recibo</label>
                    <input type="datetime-local"
class="form-control" name="data" value="' . $data . '" required>
</div>
</div>

<div class="col-12">
<div class="form-group">
<label>Entregador</label>
<select class="form-control select" style="width: 100%;" name="entregadores_id" required>
            
  ' . $section1 . '

</select>
</div>

</div>

<div class="col-4">
    <div class="form-group">
        <label>Veículo</label>
        <select class="form-control select" style="width: 100%;" name="veiculos_id" required>
            
  ' . $section2 . '

</select>
    </div>
</div>
<div class="col-4">
    <div class="form-group">
        <label>Placa</label>
        <input type="text" class="form-control" name="placa" value="' . $placa . '">
    </div>
</div>
<div class="col-4">
    <div class="form-group">
        <label>Valor</label>
        <input type="text" class="form-control" name="valor" id="dinheiro" value="' . $volar_format . '" required>
    </div>
</div>
</div>


</div>

';

$retorna = ['erro' => false, 'dados' => $dados];

echo json_encode($retorna);