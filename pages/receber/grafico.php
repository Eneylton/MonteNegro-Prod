<?php

require __DIR__ . '../../../vendor/autoload.php';

$alertaCadastro = '';

define('TITLE', 'Gráficos');
define('BRAND', 'Recerber');

use App\Entidy\Cliente;
use App\Entidy\Receber;
use App\Session\Login;

Login::requireLogin();

$inicio = "";
$fim = "";
$cliente_nome = "";
$cliente = "";
$and = "";

if ($_GET['clientes_id'] != "") {

    $and = " AND r.clientes_id= ";

    $cliente = $_GET["clientes_id"];

    $clientes = Cliente::getID('*', 'clientes', $cliente, null, null);

    $cliente_nome = $clientes->nome;
}

$inicio  = $_GET['dataInicio'];

$fim     = $_GET['dataFim'];

$consulta = "r.data BETWEEN ' $inicio ' AND ' $fim '";

$quantidades = Receber::getClientID(' (CASE MONTH(r.data)
    WHEN 1 THEN "Janeiro"
    WHEN 2 THEN "Fevereiro"
    WHEN 3 THEN "Março"
    WHEN 4 THEN "Abril"
    WHEN 5 THEN "Maio"
    WHEN 6 THEN "Junho"
    WHEN 7 THEN "Julho"
    WHEN 8 THEN "Agosto"
    WHEN 9 THEN "Setembro"
    WHEN 10 THEN "Outubro"
    WHEN 11 THEN "Novembro"
    WHEN 12 THEN "Dezembro"
    END) AS mes,
    SUM(r.qtd) AS total', 'receber AS r
    INNER JOIN
    clientes AS cli ON (r.clientes_id = cli.id)
    INNER JOIN
    setores AS st ON (cli.setores_id = st.id)', $consulta . $and . $cliente, 'mes', 'r.data ASC', null);

$entregas = Receber::getClientID(' r.id,
    c.nome as cliente,
    (CASE MONTH(r.data)
    WHEN 1 THEN "Janeiro"
    WHEN 2 THEN "Fevereiro"
    WHEN 3 THEN "Março"
    WHEN 4 THEN "Abril"
    WHEN 5 THEN "Maio"
    WHEN 6 THEN "Junho"
    WHEN 7 THEN "Julho"
    WHEN 8 THEN "Agosto"
    WHEN 9 THEN "Setembro"
    WHEN 10 THEN "Outubro"
    WHEN 11 THEN "Novembro"
    WHEN 12 THEN "Dezembro"
    END) AS mes,
    sum(e.qtd) as total', 'receber AS r
    INNER JOIN
    producao AS p ON (p.receber_id = r.id)
    INNER JOIN
    entrega AS e ON (e.producao_id = p.id)
    INNER JOIN
    clientes AS c ON (r.clientes_id = c.id)', $consulta . $and . $cliente, 'mes', 'r.data ASC', null);

$devolucao = Receber::getClientID('r.id,
    c.nome as cliente,
    (CASE MONTH(r.data)
    WHEN 1 THEN "Janeiro"
    WHEN 2 THEN "Fevereiro"
    WHEN 3 THEN "Março"
    WHEN 4 THEN "Abril"
    WHEN 5 THEN "Maio"
    WHEN 6 THEN "Junho"
    WHEN 7 THEN "Julho"
    WHEN 8 THEN "Agosto"
    WHEN 9 THEN "Setembro"
    WHEN 10 THEN "Outubro"
    WHEN 11 THEN "Novembro"
    WHEN 12 THEN "Dezembro"
    END) AS mes,
    SUM(d.qtd) AS total', '  receber AS r
    INNER JOIN
    producao AS p ON (p.receber_id = r.id)
    INNER JOIN
    devolucao AS d ON (d.producao_id = p.id)
    INNER JOIN
    clientes AS c ON (r.clientes_id = c.id)', $consulta . $and . $cliente, 'mes', 'r.data ASC', null);

$ocorrencias = Receber::getClientID(' r.id,
    c.nome AS cliente,
    o.nome as ocorrencia,
    (CASE MONTH(r.data)
    WHEN 1 THEN "Janeiro"
    WHEN 2 THEN "Fevereiro"
    WHEN 3 THEN "Março"
    WHEN 4 THEN "Abril"
    WHEN 5 THEN "Maio"
    WHEN 6 THEN "Junho"
    WHEN 7 THEN "Julho"
    WHEN 8 THEN "Agosto"
    WHEN 9 THEN "Setembro"
    WHEN 10 THEN "Outubro"
    WHEN 11 THEN "Novembro"
    WHEN 12 THEN "Dezembro"
    END) AS mes,
    SUM(d.qtd) AS total', ' receber AS r
    INNER JOIN
    producao AS p ON (p.receber_id = r.id)
    INNER JOIN
    devolucao AS d ON (d.producao_id = p.id)
    INNER JOIN
    clientes AS c ON (r.clientes_id = c.id)
    INNER JOIN
    ocorrencias AS o ON (d.ocorrencias_id = o.id)', $consulta . $and . $cliente, 'o.nome', 'r.data ASC', null);

$ranks = Receber::getClientID(' r.id,
    c.nome as cliente,
    et.apelido as entregador,
    (CASE MONTH(r.data)
    WHEN 1 THEN "Janeiro"
    WHEN 2 THEN "Fevereiro"
    WHEN 3 THEN "Março"
    WHEN 4 THEN "Abril"
    WHEN 5 THEN "Maio"
    WHEN 6 THEN "Junho"
    WHEN 7 THEN "Julho"
    WHEN 8 THEN "Agosto"
    WHEN 9 THEN "Setembro"
    WHEN 10 THEN "Outubro"
    WHEN 11 THEN "Novembro"
    WHEN 12 THEN "Dezembro"
    END) AS mes,
    SUM(e.qtd) AS total', ' receber AS r
    INNER JOIN
    producao AS p ON (p.receber_id = r.id)
    INNER JOIN
    entrega AS e ON (e.producao_id = p.id)
    INNER JOIN
    clientes AS c ON (r.clientes_id = c.id)
    INNER JOIN
    entregadores AS et ON (e.entregadores_id = et.id)', $consulta . $and . $cliente, ' et.apelido', 'r.data ASC', null);


$servicos = Receber::getClientID('sv.nome AS servicos,
    st.nome AS setores,
    SUM(r.qtd) AS total', 'receber AS r
    INNER JOIN
    servicos AS sv ON (r.servicos_id = sv.id)
    INNER JOIN
    clientes AS c ON (r.clientes_id = c.id)
    INNER JOIN
    setores AS st ON (sv.setores_id = st.id)', $consulta . $and . $cliente, ' sv.nome', 'r.data ASC', null);


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/gaiola/gaiola-grafico-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script type="text/javascript">
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [

            <?php

                foreach ($quantidades as $item) {

                    echo "'" . $item->mes . "',";
                }

                ?>
        ],
        datasets: [{
            label: '• PRODUÇÃO MENSAL •',
            data: [
                <?php
                    foreach ($quantidades as $item) {
                        echo "'" . $item->total . "',";
                    }

                    ?>
            ],
            backgroundColor: [
                '#ffc107cc',
                '#9d64a480',
                '#ee901d8f',
                '#d12f61',
                '#3d606c',
                '#F0379A',
                '#763dd986',
                '#d0ff0093',
                '#3794F0',
                '#ff00ff',
                '#ff0000',
                '#121212'
            ],
            borderColor: [
                '#ffc107cc',
                '#9d64a480',
                '#ee901d8f',
                '#d12f61',
                '#3d606c',
                '#F0379A',
                '#763dd986',
                '#d0ff0093',
                '#3794F0',
                '#ff00ff',
                '#ff0000',
                '#121212'

            ],
            borderWidth: 1
        }]
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

<script type="text/javascript">
var ctx = document.getElementById('myChart2').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [

            <?php

                foreach ($entregas as $item) {

                    echo "'" . $item->mes . "',";
                }

                ?>
        ],
        datasets: [{
                label: '• ENTREGAS •',
                data: [
                    <?php

                        foreach ($entregas as $item) {

                            echo "'" . $item->total . "',";
                        }

                        ?>
                ],
                backgroundColor: [
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de'
                ],
                borderColor: [
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de',
                    '#39d905de'

                ],
                borderWidth: 11
            },

            {
                label: '• DEVOLUÇÕES•',
                data: [
                    <?php
                        foreach ($devolucao as $item) {
                            echo "'" . $item->total . "',";
                        }

                        ?>
                ],
                backgroundColor: [


                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de'
                ],
                borderColor: [

                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',
                    '#e81a40de',

                ],
                borderWidth: 11
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


<script type="text/javascript">
var ctx = document.getElementById('myChart3').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [

            <?php

                foreach ($ocorrencias as $item) {

                    echo "'" . $item->ocorrencia . "',";
                }

                ?>
        ],
        datasets: [{
            label: '• OCORRÊNCIAS •',
            data: [
                <?php
                    foreach ($ocorrencias as $item) {
                        echo "'" . $item->total . "',";
                    }

                    ?>
            ],
            backgroundColor: [
                '#6fe633a8',
                '#9d64a480',
                '#ee901d8f',
                '#d12f61',
                '#3d606c',
                '#F0379A',
                '#763dd986',
                '#d0ff0093',
                '#3794F0',
                '#ff00ff',
                '#ff0000',
                '#121212'
            ],
            borderColor: [
                '#6fe633a8',
                '#9d64a480',
                '#ee901d8f',
                '#d12f61',
                '#3d606c',
                '#F0379A',
                '#763dd986',
                '#d0ff0093',
                '#3794F0',
                '#ff00ff',
                '#ff0000',
                '#121212'

            ],
            borderWidth: 3
        }]
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



<script type="text/javascript">
var ctx = document.getElementById('myChart4').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [

            <?php

                foreach ($ranks as $item) {

                    echo "'" . $item->entregador . "',";
                }

                ?>
        ],
        datasets: [{
            label: '• ENTREGA •',
            data: [
                <?php
                    foreach ($ranks as $item) {
                        echo "'" . $item->total . "',";
                    }

                    ?>
            ],
            backgroundColor: [
                '#6fe633a8',
                '#9d64a480',
                '#ee901d8f',
                '#ff005ebf',
                '#3d606c',
                '#F0379A',
                '#763dd986',
                '#d0ff0093',
                '#3794F0',
                '#ff00ff',
                '#ff0000',
                '#6fe633a8',
                '#9d64a480',
                '#ee901d8f',
                '#d12f61',
                '#3d606c',
                '#F0379A',
                '#763dd986',
                '#d0ff0093',
                '#3794F0',
                '#ff00ff',
                '#ff0000',
                '#121212'
            ],
            borderColor: [
                '#6fe633a8',
                '#9d64a480',
                '#ee901d8f',
                '#ff005ebf',
                '#3d606c',
                '#F0379A',
                '#763dd986',
                '#d0ff0093',
                '#3794F0',
                '#ff00ff',
                '#ff0000',
                '#6fe633a8',
                '#9d64a480',
                '#ee901d8f',
                '#d12f61',
                '#3d606c',
                '#F0379A',
                '#763dd986',
                '#d0ff0093',
                '#3794F0',
                '#ff00ff',
                '#ff0000',
                '#121212'

            ],
            borderWidth: 10
        }]
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

<script type="text/javascript">
var ctx = document.getElementById('myChart5').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [

            <?php

                foreach ($servicos as $item) {

                    echo "'" . $item->servicos . "',";
                }

                ?>
        ],
        datasets: [{
            label: '• TOTAL •',
            data: [
                <?php
                    foreach ($servicos as $item) {
                        echo "'" . $item->total . "',";
                    }

                    ?>
            ],
            backgroundColor: [
                '#c9fb00c2',
                '#00b5fbc2',
                '#6fe633a8',
                '#ff005ebf',
                '#ee901d8f',
                '#00fbefc2',
                '#7800fbc2',
                '#fb6800c2'
            ],
            borderColor: [
                '#c9fb00c2',
                '#00b5fbc2',
                '#6fe633a8',
                '#fb00aec2',
                '#ee901d8f',
                '#00fbefc2',
                '#7800fbc2',
                '#fb6800c2'

            ],
            borderWidth: 10
        }]
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