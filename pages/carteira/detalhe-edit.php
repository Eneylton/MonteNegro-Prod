<?php

require __DIR__ . '../../../vendor/autoload.php';

$alertaCadastro = '';

define('TITLE', 'Detalhes');
define('BRAND', 'Detalhes');

use App\Entidy\Devolucao;
use App\Entidy\Entrega;
use App\Session\Login;


Login::requireLogin();

if (isset($_GET['id']) or is_numeric($_GET['id'])) {

    $id_caixa = $_GET['id'];
}

$entregas = Entrega::getList(' e.id AS id,
e.data AS data,
e.qtd AS qtd,
et.id AS entregadores_id,
et.apelido AS apelido,
st.nome AS setores,
sv.id AS servico_id,
upper(sv.nome) AS servicos,
et.valor_boleto AS boleto,
et.valor_cartao AS cartao,
et.valor_pequeno AS pequeno,
et.valor_grande AS grande', ' entrega AS e
INNER JOIN
producao AS p ON (e.producao_id = p.id)
INNER JOIN
receber AS r ON (p.receber_id = r.id)
INNER JOIN
setores AS st ON (p.setores_id = st.id)
INNER JOIN
servicos AS sv ON (p.servicos_id = sv.id)
INNER JOIN
entregadores AS et ON (e.entregadores_id = et.id)', ' month(e.data) = MONTH(CURRENT_DATE())  AND e.entregadores_id  = ' . $_GET['id']);

$devolucoes = Devolucao::getList('d.id AS id,
d.data AS data,
d.qtd AS qtd,
en.apelido AS apelido,
en.valor_boleto AS boleto,
en.valor_cartao AS cartao,
en.valor_pequeno AS pequeno,
en.valor_grande AS grande,
o.nome AS ocorrencias,
st.nome AS setores,
p.setores_id As setores_id,
p.servicos_id AS servicos_id,
sv.nome AS servicos ', ' devolucao AS d
INNER JOIN
entregadores AS en ON (d.entregadores_id = en.id)
INNER JOIN
ocorrencias AS o ON (d.ocorrencias_id = o.id)
INNER JOIN
producao AS p ON (d.producao_id = p.id)
INNER JOIN
receber AS r ON (p.receber_id = r.id)
INNER JOIN
setores AS st ON (r.setores_id = st.id)
INNER JOIN
servicos AS sv ON (r.servicos_id = sv.id)', 'month(d.data) = MONTH(CURRENT_DATE())  AND d.entregadores_id=' . $_GET['id']);

$graficos = Entrega::getList(' e.data AS data,
sv.id AS servicos_id,
upper(sv.nome) AS servicos,
e.qtd AS qtd,
et.valor_boleto as boleto,
et.valor_cartao as cartao,
et.valor_pequeno as pequeno,
et.valor_grande as grande', ' entrega AS e
INNER JOIN
producao AS p ON (e.producao_id = p.id)
INNER JOIN
receber AS r ON (p.receber_id = r.id)
INNER JOIN
setores AS st ON (r.setores_id = st.id)
INNER JOIN
servicos AS sv ON (r.servicos_id = sv.id)
INNER JOIN
entregadores AS et ON (e.entregadores_id = et.id) 
', 'month(e.data) = MONTH(CURRENT_DATE())  AND e.entregadores_id  = ' . $_GET['id']);


$graficos2 = Entrega::getList(' e.data AS data,
sv.id AS servicos_id,
upper(sv.nome) AS servicos,
e.qtd AS qtd,
et.valor_boleto as boleto,
et.valor_cartao as cartao,
et.valor_pequeno as pequeno,
et.valor_grande as grande', ' devolucao AS e
INNER JOIN
producao AS p ON (e.producao_id = p.id)
INNER JOIN
receber AS r ON (p.receber_id = r.id)
INNER JOIN
setores AS st ON (r.setores_id = st.id)
INNER JOIN
servicos AS sv ON (r.servicos_id = sv.id)
INNER JOIN
entregadores AS et ON (e.entregadores_id = et.id) 
', 'month(e.data) = MONTH(CURRENT_DATE())  AND e.entregadores_id  = ' . $_GET['id']);

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/detalhe/detalhe-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>


<script type="text/javascript">
var ctx = document.getElementById('myChart2').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [

            <?php

                foreach ($entregas as $item) {

                    echo "'" . $item->servicos . "',";
                }

                ?>
        ],
        datasets: [{
                label: '• ENTREGAS R$',
                data: [
                    <?php
                        $total_entrega = 0;
                        $qtd = 0;
                        $valor_total = 0;
                        $total = 0;
                        foreach ($graficos as $item) {

                            switch ($item->servicos_id) {
                                case '1':
                                    $valor = $item->pequeno;
                                    break;
                                case '3':
                                    $valor = $item->boleto;
                                    break;
                                case '4':
                                    $valor = $item->cartao;
                                    break;

                                default:
                                    $valor = $item->grande;
                                    break;
                            }

                            $qtd = $item->qtd;
                            $total_entrega = $valor * $qtd;
                            $valor_total += $total_entrega;
                            $total = $valor_total;

                            echo "'" . $total . "',";
                        }

                        ?>
                ],
                backgroundColor: [
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',

                ],
                borderColor: [
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8',
                    '#6fe633a8'

                ],
                borderWidth: 1
            },

            {
                label: '• DEVOLUÇÕES •',
                data: [


                    <?php
                        $total_entrega = 0;
                        $qtd = 0;
                        $valor_total = 0;
                        $total = 0;
                        foreach ($graficos2 as $item) {

                            switch ($item->servicos_id) {
                                case '1':
                                    $valor = $item->pequeno;
                                    break;
                                case '3':
                                    $valor = $item->boleto;
                                    break;
                                case '4':
                                    $valor = $item->cartao;
                                    break;

                                default:
                                    $valor = $item->grande;
                                    break;
                            }

                            $qtd = $item->qtd;
                            $total_entrega = $valor * $qtd;
                            $valor_total += $total_entrega;
                            $total = $valor_total;

                            echo "'" . $total . "',";
                        }

                        ?>
                ],
                backgroundColor: [
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000'
                ],
                borderColor: [
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000',
                    '#ff0000'

                ],
                borderWidth: 1
            }

        ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>