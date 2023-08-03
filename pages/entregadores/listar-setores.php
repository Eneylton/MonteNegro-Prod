<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\EntregadorSetor;

$dados = "";
$contador = 0;

$id = filter_input(INPUT_GET, "id_cat", FILTER_SANITIZE_NUMBER_INT);

$listarSetores = EntregadorSetor::getEntreID('es.id AS id, s.nome AS setores', '   entregador_setores AS es
        INNER JOIN
        entregadores AS e ON (es.entregadores_id = e.id)
        INNER JOIN
        setores AS s ON (es.setores_id = s.id)',$id, null, null);

$dados .= "<table class='table'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                        </tr>
                    </thead>
                    <tbody>";

foreach ($listarSetores as $item) {

    $contador += 1;

    $dados .= "<tr>
                            <td style='font-size:22px'>$contador</td>
                            <td style='font-size:22px'>$item->setores</td>
                          
                        </tr>";
    
}

$dados .= "</tbody>
                </table>";

                $retorna = ['erro' => false, 'dados' => $dados];

                echo json_encode($retorna);

?>