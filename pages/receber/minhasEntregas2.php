<?php

use App\Entidy\Producao;

require __DIR__ . '../../../vendor/autoload.php';

$dados = "";
$cont = 0;
$qtd = 0;
$listar = array();

$param = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$listar = Producao::getProducaoListID('eq.id AS id,e.id AS entregadores_id,
r.id AS receber,
SUM(eq.qtd) AS qtd,
r.qtd AS restante,
e.apelido AS entregador', ' entregador_qtd AS eq
INNER JOIN
entregadores AS e ON (e.id = eq.entregadores_id)
INNER JOIN
receber AS r ON (r.id = eq.receber_id)', $param, 'e.apelido', null, null);

if (!$listar) {


    $dados .= '<table class="table">
                    <thead>
                        <tr>
                        <tH colspan="2" style="text-align:center; color:#ff0000; font-size:20px;font-weigth:bold">ATENÇÃO</th>
                           
                        </tr>
                    </thead>
                    <tbody>';


    $dados .= '<tr>
                    <td colspan="2" style="text-align:center; color:#000; font-size:20px;font-weigth:bold">ATENÇÃO VOCÊ PRECISA ADICIONAR O ENTREGAOR NESTE LOTE !!!</td>
                  
              </tr>';

    $retorna = ['erro' => false, 'dados' => $dados];

    echo json_encode($retorna);
} else {

    $dados .= '<table class="table">
                    <thead>
                        <tr>
                            <th>CÓDIGO</th>
                            <th>NOME</th>
                            <th style="text-align:center">PENDENCIA</th>
                            <th style="text-align:center">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>';

    foreach ($listar as $item) {

        $cont += 1;

        $qtd += $item->qtd;

        if ($item->qtd == 0) {

            $texto = '<i style="color:#14d914" class="fa fa-check" aria-hidden="true"></i>';
        } else {
            $texto = $item->qtd;
        }

        $dados .= '<tr>
   <td style="font-size:22px"><h4><span class="badge badge-pill badge-dark">' . $item->receber . '</span></h4></td>
   <td style="font-size:22px; text-transform:uppercase;">' . $item->entregador . '</td>
   <td style="font-size:25px;color:#ff0000;font-weight:bold;text-align:center">' . $texto . '</td>
   <td style="font-size:25px;color:#ff0000;font-weight:bold;text-align:center">
   <a href="../boletos/boleto-list.php?id_param=' . $item->entregadores_id . '&receber_id=' . $item->receber . '">
   <button class="btn btn-info type="button">Baixar Entrega</button></td>
   </a>
   
   </tr>

   ';
    }

    $dados .= ' <tr>
    <td style="font-size:22px">TOTAL</td>
    <td style="font-size:22px;text-align:rigth; color:red">TOTAL DE PENDENCIAS</td>
    <td style="font-size:25px;color:#ff0000;font-weight:bold;text-align:center">'  . $qtd . '</td>
    </tr>';

    $retorna = ['erro' => false, 'dados' => $dados];

    echo json_encode($retorna);
}
