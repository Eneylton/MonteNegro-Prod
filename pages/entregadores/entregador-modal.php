<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Entregador;
use App\Entidy\EntregadorServicos;
use App\Entidy\EntregadorSetor;
use App\Entidy\EntreRotas;
use App\Entidy\FormaPagamento;
use App\Entidy\Regiao;
use App\Entidy\Rota;
use App\Entidy\Servico;
use App\Entidy\Setor;
use App\Entidy\Veiculo;


$dados = "";
$selected = "";
$checked = "";
$select_pag = "";
$select_reg = "";
$select_vei = "";
$result_setor = "";
$result_servicos = "";
$select_rota = "";
$regiao_id = 0;

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if ($param != null) {

   $value = Entregador::getID('*', 'entregadores', $param, null, null);
   $regiao_id = $value->regioes_id;
   $rotas = Rota::getList('*', 'rotas', 'regioes_id=' . $regiao_id, 'nome ASC');
}

if (isset($_POST['id2'])) {

   $regiao_id = $_POST['id2'];

   $rotas = Rota::getList('*', 'rotas', 'regioes_id=' . $regiao_id, 'nome ASC');
}

$pagamentos = FormaPagamento::getList('*', 'forma_pagamento', null, 'nome ASC', null);

$regioes = Regiao::getList('*', 'regioes', null, 'nome ASC', null);

$setores = Setor::getList('*', 'setores', null, 'nome ASC');

$servicos = Servico::getList('*', 'servicos', null, 'nome ASC');

$veiculos = Veiculo::getList('*', 'veiculos', null, 'nome ASC');



foreach ($setores as $item) {

   $value2 = EntregadorSetor::getIDEntregador('*', 'entregador_setores', $param . ' AND setores_id=' . $item->id, null, null);

   if ($value2 != false) {

      $id = $value2->setores_id;

      if ($id == $item->id) {

         $checked = "checked ";
      } else {

         $checked = " ";
      }
   } else {

      $checked = " ";
   }


   $result_setor .= '
<div class="custom-control custom-radio custom-control-inline grande ">
<input class="form-check-input" type="checkbox" value="' . $item->id . '" name="setores[]" id="[' . $item->id . ']" ' . $checked . '>
<label for="' . $item->id . '" >' . $item->nome . '</label>
</div>

';
}


foreach ($servicos as $item) {

   $value3 = EntregadorServicos::getEntreID('*', 'entregador_servicos', $param . ' AND servicos_id= ' . $item->id, null, null);

   if ($value3 != false) {

      $id = $value3->servicos_id;

      if ($id == $item->id) {

         $checked = "checked ";
      } else {

         $checked = " ";
      }
   } else {

      $checked = " ";
   }


   $result_servicos .= '
<div class="custom-control custom-radio custom-control-inline grande ">
<input class="form-check-input" type="checkbox" value="' . $item->id . '" name="servicos[]" id="[' . $item->id . ']" ' . $checked . '>
<label for="' . $item->id . '" >' . $item->nome . '</label>
</div>

';
}

foreach ($veiculos as $item) {

   if ($item->id == $value->veiculos_id) {

      $selected_vei = "selected";
   } else {

      $selected_vei = "";
   }

   $select_vei .= '<option value="' . $item->id . '"  ' . $selected_vei . '>' . $item->nome . '</option>';
}


foreach ($regioes as $item) {

   if ($item->id == $value->regioes_id) {

      $selected = "selected";
   } else {

      $selected = "";
   }

   $select_reg .= '<option value="' . $item->id . '"  ' . $selected . '>' . $item->nome . '</option>';
}

foreach ($rotas as $item) {

   $rota_item = EntreRotas::getIDRotas('*', 'entregador_rota', $item->id . ' AND entregadores_id=' . $param . '', null, null);


   if ($rota_item  != false) {

      if ($item->id == $rota_item->rotas_id) {

         $selected = "selected";
      } else {

         $selected = "";
      }
   } else {
      $selected = "";
   }

   $select_rota .= '<option value="' . $item->id . '"  ' . $selected . '>' . $item->nome . '</option>';
}


foreach ($pagamentos as $item) {

   if ($item->id == $value->forma_pagamento_id) {

      $selected = "selected";
   } else {

      $selected = "";
   }

   $select_pag .= '<option value="' . $item->id . '"  ' . $selected . '>' . $item->nome . '</option>';
}


$dados .= '


<div class="row">

<input type="hidden" name="id" value="' . $value->id . '">

<div class="col-6">
<div class="form-group">
<label>Nome</label>
<input style="text-transform:uppercase" type="text" class="form-control" name="nome" value="' . $value->nome . '">
</div>
</div>
<div class="col-6">
<div class="form-group">
<label>Nome de guerra</label>
<input style="text-transform:uppercase" type="text" class="form-control" name="apelido" value="' . $value->apelido . '">
</div>
</div>

<div class="col-4">
<div class="form-group">
<label>CPF</label>
<input style="text-transform:uppercase" type="text" class="form-control" name="cpf" id="cpf" value="' . $value->cpf . '">
</div>
</div>

<div class="col-4">
<div class="form-group">
<label>Telefone</label>
<input style="text-transform:uppercase" type="text" class="form-control" name="telefone" id="telefone" value="' . $value->telefone . '">
</div>
</div>
<div class="col-4">
<div class="form-group">
<label>Email</label>
<input style="text-transform:uppercase" type="text" class="form-control " name="email" value="' . $value->email . '">
</div>
</div>
<div class="col-3">
<div class="form-group">
<label>Tipo Contratação</label>
<select class="form-control" name="tipo"  required>

<option value="CLT">CLT</option>
<option value="PJ">PJ</option>
<option value="ESTÁGIO">ESTÁGIO</option>
<option value="CONTRATAÇÃO TEMPORÁRIA">CONTRATAÇÃO TEMPORÁRIA</option>
<option value="JOVEM APRENDIZ">JOVEM APRENDIZ</option>
</select>
</div>
</div>
<div class="col-3">
<div class="form-group">
<label>Forma Pagamento</label>
<select class="form-control select" style="width: 100%;" name="forma_pagamento_id">

' . $select_pag . '

</select>

</div>
</div>
<div class="col-3">
<div class="form-group">
<label>Regiões</label>
<select class="form-control select" style="width: 100%;" name="regioes_id" id="porcentagem" onchange="Calculo(this.value   )">

' . $select_reg . '

</select>

</div>
</div>

<div class="col-3">
<div class="form-group">

<label>Rota</label>
<select  name="rotas[]" id="resultado" multiple class="form-control select" style="width: 100%;">

' . $select_rota . '

</select>
</div>
</div>

<div class="col-4">
<div class="form-group">
<label>Setores</label><br>

' . $result_setor . '

</div>
</div>
<div class="col-8">
<div class="form-group">
<label>Serviços</label><br>
' . $result_servicos . '

</div>
</div>
<div class="col-3">
<div class="form-group">
<label>Valor boleto</label>
<input style="text-transform:uppercase" type="text" class="form-control " name="valor_boleto" value="' . $value->valor_boleto . '">
</div>
</div>
<div class="col-3">
<div class="form-group">
<label>Valor Cartão</label>
<input style="text-transform:uppercase" type="text" class="form-control " name="valor_cartao" value="' . $value->valor_cartao . '">
</div>
</div>
<div class="col-3">
<div class="form-group">
<label>Valor entrega grande</label>
<input style="text-transform:uppercase" type="text" class="form-control " name="valor_grande" value="' . $value->valor_grande . '">
</div>
</div>
<div class="col-3">
<div class="form-group">
<label>Valor Entrega Pequeno</label>
<input style="text-transform:uppercase" type="text" class="form-control " name="valor_pequeno" value="' . $value->valor_pequeno . '">
</div>
</div>

<div class="col-4">
<div class="form-group">
<label>Cnh</label>
<input style="text-transform:uppercase" type="text" class="form-control" name="cnh" value="' . $value->cnh . '">
</div>
</div>
<div class="col-4">
<div class="form-group">
<label>Renavam</label>
<input style="text-transform:uppercase" type="text" class="form-control" name="renavam" value="' . $value->renavam . '">
</div>
</div>

<div class="col-4">
<div class="form-group">
<select class="form-control select" style="width: 100%;" name="veiculos_id">

' . $select_vei . '

</select>
</div>
</div>

<div class="col-3">
<div class="form-group">
<label>Banco</label>
<input style="text-transform:uppercase" type="text" class="form-control" name="banco" value="' . $value->banco . '">
</div>
</div>
<div class="col-3">
<div class="form-group">
<label>Agência</label>
<input style="text-transform:uppercase" type="text" class="form-control" name="agencia" value="' . $value->agencia . '">
</div>
</div>
<div class="col-3">
<div class="form-group">
<label>Conta</label>
<input style="text-transform:uppercase" type="text" class="form-control" name="conta" value="' . $value->conta . '">
</div>
</div>

<div class="col-3">
<div class="form-group">
<label>Chave pix</label>
<input style="text-transform:uppercase" type="text" class="form-control" name="pix" value="' . $value->pix . '">
</div>
</div>

<div class="col-4">
<div class="form-group">
<label>Data admissão</label>
<input type="datetime" class="form-control" name="admissao" value="' . $value->admissao . '" >
</div>
</div>
<div class="col-4">
<div class="form-group">
<label>Data recisão</label>
<input type="datetime" class="form-control" name="recisao" value="' . $value->recisao . '">
</div>
</div>
<div class="col-4">
<div class="form-group">

<label>Status</label>
<div>
<div class="form-check form-check-inline">
<label class="form-control">
<input type="radio" name="status" value="1" checked> Ativo
</label>
</div>

<div class="form-check form-check-inline">
<label class="form-control">
<input type="radio" name="status" value="0"> Inativo
</label>
</div>
</div>
</div>
</div>

</div>';

$retorna = ['erro' => false, 'dados' => $dados];

echo json_encode($retorna);