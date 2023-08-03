<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Cliente;
use App\Session\Login;
use Dompdf\Dompdf;
use Dompdf\Options;

define('TITLE', 'TOTAL GERAL POR CLIENTES');
define('BRAND', 'Relatorio');

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$acesso = $usuariologado['acessos_id'];

$usuario = $usuariologado['id'];

$user_acesso = $usuariologado['acessos_id'];

$cliente = "";
$setor = "";
$mes = "";

if (isset($_POST['consultar'])) {

    if (isset($_POST['setor'])) {
        $setor = $_POST['setor'];
    } else {
        $setor = null;
    }

    if (isset($_POST['clientes_id'])) {
        $cliente = $_POST['clientes_id'];
    } else {
        $cliente = null;
    }

    if (isset($_POST['mes_id'])) {
        $mes = $_POST['mes_id'];
    } else {
        $mes = null;
    }
}

$condicoes = [
    strlen($cliente) ? "r.clientes_id =" . $cliente : null,
    strlen($setor) ? "s.id =" . $setor : null,
    strlen($mes) ? "MONTH(r.data) =" . $mes : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$result = Cliente::getList('COUNT(c.nome) as nome', 'clientes AS c
INNER JOIN
setores AS s ON (c.setores_id = s.id)
INNER JOIN
receber AS r ON (r.clientes_id = c.id)', $where, 'c.nome', null, null);


$nome = "";
$cont = 1;
$qtd = 0;

foreach ($result as $item) {

    $qtd += $cont;
}

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 6);

$listar = Cliente::getList(
    ' c.id AS id, c.nome AS nome,r.disponivel AS disponivel,r.id as codigo, s.nome AS setor, sum(r.qtd ) as qtd',
    'clientes AS c
    INNER JOIN
setores AS s ON (c.setores_id = s.id)
    INNER JOIN
receber AS r ON (r.clientes_id = c.id)',
    $where,
    'c.nome',
    'qtd DESC',
    $pagination->getLimit()
);

$total_absoluto = Cliente::getTotal('sum(r.qtd) as total,r.disponivel AS disponivel', 'clientes AS c
INNER JOIN
setores AS s ON (c.setores_id = s.id)
INNER JOIN
receber AS r ON (r.clientes_id = c.id)');

$resul_total = $total_absoluto->total;

$resul_disponivel = $total_absoluto->disponivel;

$clientes = Cliente::getList('*', 'clientes', null, null, 'nome ASC');

$graficos = Cliente::getList(' (CASE MONTH(r.data)
WHEN 1 THEN "JANEIRO"
WHEN 2 THEN "FEVEREIRO"
WHEN 3 THEN "MARÇO"
WHEN 4 THEN "ABRIL"
WHEN 5 THEN "MAIO"
WHEN 6 THEN "JUNHO"
WHEN 7 THEN "JULHO"
WHEN 8 THEN "AGOSTO"
WHEN 9 THEN "SETEMBRO"
WHEN 10 THEN "OUTUBRO"
WHEN 11 THEN "NOVEMBRO"
WHEN 12 THEN "DEZEMBRO"
END) AS mes,
c.id AS id,
c.nome AS nome,
s.nome AS setor,
SUM(r.qtd) AS qtd', ' clientes AS c
INNER JOIN
setores AS s ON (c.setores_id = s.id)
INNER JOIN
receber AS r ON (r.clientes_id = c.id)', $where, ' mes', 'r.data ASC');

if (isset($_POST['relatorios'])) {

    if (isset($_POST['setor'])) {
        $setor = $_POST['setor'];
    } else {
        $setor = null;
    }

    if (isset($_POST['clientes_id'])) {
        $cliente = $_POST['clientes_id'];
    } else {
        $cliente = null;
    }

    if (isset($_POST['mes_id'])) {
        $mes = $_POST['mes_id'];
    } else {
        $mes = null;
    }

    $dompdf = new Dompdf();
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);

    ob_start();

    require __DIR__ . "/relatorio-pdf.php";

    $dompdf->loadHtml(ob_get_clean());

    // echo $pdf;

    $dompdf->setPaper("A4");

    $dompdf->render();

    $dompdf->stream("cliente.pdf", ["Attachment" => false]);
}



include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/relatorio/relatorio1-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script>
var ctx = document.getElementById("myChart").getContext("2d");

const bgColor = {
    id: 'bgColor',
    beforeDraw: (chart, steps, options) => {

        const {
            ctx,
            width,
            height
        } = chart;
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, width, height);
        ctx.restore();

    }

}

var myChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: [
            <?php

                foreach ($graficos as $item) {

                    echo "'" . $item->mes . "',";
                }

                ?>
        ],
        datasets: [{
            label: "# of Votes",
            data: [<?php
                        foreach ($graficos as $item) {
                            echo "'" . $item->qtd . "',";
                        }

                        ?>],
            backgroundColor: [
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255,1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255,1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderColor: [
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255,1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255,1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1,
        }, ],
    },

    options: {
        layout: {

            padding: 30
        },
        scales: {

        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                enabled: false
            },
            bgColor: {
                backgroundColor: 'white'
            },
            labels: {
                padding: 2,
                render: 'percentage',
                position: 'outside',
                fontStyle: 'bolder',
                textMargin: 2,
                fontColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255,1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255,1)',
                    'rgba(255, 159, 64, 1)'
                ]

            },

            datalabels: {
                align: 'center',
                anchor: 'end',
                align: 'top',
                formatter: (value, context) => {
                    const datapoints = context.chart.data.datasets[0].data;

                    function totalSum(total, datapoint) {
                        return total + datapoint;
                    }

                    const totalvalue = datapoints.reduce(totalSum, 0);

                    const soma = value - <?= $resul_disponivel ?>

                    const porcentageValue = (soma / <?= $resul_total ?> * 100)
                        .toFixed(1);
                    const display = [`QTD ${value}`, `${porcentageValue} % `];
                    return display;
                }

            }

        },
    },

    plugins: [ChartDataLabels, bgColor],
});

function dowloadPDF() {
    const canvas = document.getElementById('myChart');
    const canvasImage = canvas.toDataURL('image/jpeg', 1.0);

    let pdf = new jsPDF('landscape');

    pdf.setFontSize(20);
    pdf.addImage(canvasImage, 'JPEG', 15, 15, 280, 130);
    pdf.text(15, 15, "MONTENEGRO - CLIENTE")
    pdf.save('Grafico-Cliente.pdf');
}
</script>