<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\EntregadorServicos;

$dados = "";
$contador = 0;

$id = filter_input(INPUT_GET, "id_cat", FILTER_SANITIZE_NUMBER_INT);

$listarServicos = EntregadorServicos::getEntregadorID('s.id AS id, s.nome AS servicos, e.valor_boleto as boleto,e.valor_cartao as cartao,
e.valor_pequeno as pequeno,e.valor_grande as grande', 'entregador_servicos AS es
INNER JOIN
entregadores AS e ON (es.entregadores_id = e.id)
INNER JOIN
servicos AS s ON (es.servicos_id = s.id)',$id, null, null);

$dados .= "<table class='table'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>";

foreach ($listarServicos as $item) {

    $contador += 1;

    switch ($item->id) {
        case '1':
           $valor = $item->pequeno;
           $preco = number_format($valor,"2",",",".");
           break;
        case '3':
           $valor = $item->boleto;
           $preco = number_format($valor,"2",",",".");
           break;
        case '4':
           $valor = $item->cartao;
           $preco = number_format($valor,"2",",",".");
           break;
        
        default:
           $valor = $item->grande;
           $preco = number_format($valor,"2",",",".");
           break;
     }

    $dados .= "<tr>
                            <td style='font-size:22px'>$contador</td>
                            <td style='font-size:22px'>$item->servicos</td>
                            <td style='font-size:22px'>R$ $preco</td>
                          
                        </tr>";
    
}

$dados .= "</tbody>
                </table>";

                $retorna = ['erro' => false, 'dados' => $dados];

                echo json_encode($retorna);

?>	