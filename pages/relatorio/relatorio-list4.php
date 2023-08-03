<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Entrega;
use App\Entidy\Entregador;
use App\Entidy\Producao;
use App\Entidy\Setor;
use App\Session\Login;
use Dompdf\Dompdf;
use Dompdf\Options;

define('TITLE', 'TOTAL GERAL POR SETOR');
define('BRAND', 'Relatório');

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$acesso = $usuariologado['acessos_id'];

$usuario = $usuariologado['id'];

$user_acesso = $usuariologado['acessos_id'];

$inicio = "";
$fim = "";
$data = "";
$setor = "";
$entregador = "";
$status = 1;

if (isset($_POST['consultar'])) {

    if (isset($_POST['dataInicio'])) {
        $inicio = $_POST['dataInicio'];
    } else {
        $inicio = null;
    }

    if (isset($_POST['dataFim'])) {
        $fim = $_POST['dataFim'];
    } else {
        $fim = null;
    }

    if (isset($_POST['setor_id'])) {
        $setor = $_POST['setor_id'];
    } else {
        $setor = null;
    }

    if (isset($_POST['entregador_id'])) {
        $entregador = $_POST['entregador_id'];
    } else {
        $entregador = null;
    }
}

$condicoes = [
    strlen($inicio) ? "date(p.data) between date('$inicio') AND date('$fim')"   : null,
    strlen($setor) ? "p.setores_id =" . $setor : null,
    strlen($entregador) ? "p.entregadores_id =" . $entregador : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$listar = Entrega::getList(
    '  DISTINCT et.apelido as entregador,s.nome as setor,
    SUM(CASE
        WHEN MONTH(e.data) = 1 THEN e.qtd
        ELSE NULL
    END) AS jan,
    SUM(CASE
        WHEN MONTH(e.data) = 2 THEN e.qtd
        ELSE NULL
    END) AS fer,
    SUM(CASE
        WHEN MONTH(e.data) = 3 THEN e.qtd
        ELSE NULL
    END) AS mar,
    SUM(CASE
        WHEN MONTH(e.data) = 4 THEN e.qtd
        ELSE NULL
    END) AS abr,
    SUM(CASE
        WHEN MONTH(e.data) = 5 THEN e.qtd
        ELSE NULL
    END) AS mai,
    SUM(CASE
        WHEN MONTH(e.data) = 6 THEN e.qtd
        ELSE NULL
    END) AS jun,
    SUM(CASE
        WHEN MONTH(e.data) = 7 THEN e.qtd
        ELSE NULL
    END) AS jul,
    SUM(CASE
        WHEN MONTH(e.data) = 8 THEN e.qtd
        ELSE NULL
    END) AS ago,
    SUM(CASE
        WHEN MONTH(e.data) = 9 THEN e.qtd
        ELSE NULL
    END) AS ste,
    SUM(CASE
        WHEN MONTH(e.data) = 10 THEN e.qtd
        ELSE NULL
    END) AS otb,
    SUM(CASE
        WHEN MONTH(e.data) = 11 THEN e.qtd
        ELSE NULL
    END) AS nov,
    SUM(CASE
        WHEN MONTH(e.data) = 12 THEN e.qtd
        ELSE NULL
    END) AS dez, sum(e.qtd) as total',
    '  entrega AS e
    INNER JOIN
producao AS p ON (p.id = e.producao_id)
    INNER JOIN
setores AS s ON (p.setores_id = s.id)
    INNER JOIN
entregadores AS et ON (e.entregadores_id = et.id)',
    $where,
    'et.apelido, s.nome',
    'et.apelido ASC',
    null
);

$total_absoluto = Producao::getTotal('sum(e.qtd) AS entrega,
sum(d.qtd) AS devolucao ', 'entrega AS e
INNER JOIN
producao AS p ON (e.producao_id = p.id)
INNER JOIN
devolucao AS d ON (d.producao_id = p.id)
INNER JOIN
receber AS r ON (p.receber_id = r.id)
INNER JOIN
clientes AS c ON (r.clientes_id = c.id)
INNER JOIN
entregadores AS et ON (e.entregadores_id = et.id)
INNER JOIN
setores AS st ON (p.setores_id = st.id)', $where, null, null, null);

$resul_total1 = $total_absoluto->entrega;
$resul_total2 = $total_absoluto->devolucao;

$soma  = ($resul_total1 - $resul_total2);

$setores = Setor::getList('id,ROW_NUMBER() OVER(ORDER BY id ASC) AS cont,nome ', 'setores', null, null);
$entregadores = Entregador::getList('*', 'entregadores', null, 'nome ASC');

$graficos = Entrega::getList(
    '  s.nome as setor,sum(e.qtd) as total',
    '  entrega AS e
INNER JOIN
producao AS p ON (p.id = e.producao_id)
INNER JOIN
setores AS s ON (p.setores_id = s.id)
INNER JOIN
entregadores AS et ON (e.entregadores_id = et.id)',
    $where,
    's.nome',
    null,
    null

);

if (isset($_POST['relatorios'])) {

    $dompdf = new Dompdf();
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);

    ob_start();

    require __DIR__ . "/relatorio4-pdf.php";

    $dompdf->loadHtml(ob_get_clean());

    // echo $pdf;

    $dompdf->setPaper("A4", 'landscape');

    $dompdf->render();

    $dompdf->stream("producao-geral.pdf", ["Attachment" => false]);
}

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/relatorio/relatorio4-form-list.php';
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
    type: "pie",
    data: {
        labels: ['E- COMMERCE', 'EDITORIAL'],
        datasets: [{
            label: "#",
            data: [<?php

                        foreach ($graficos as $item) {

                            echo "'" . $item->total . "',";
                        }

                        ?>],
            backgroundColor: [
                "#4064fdd9",
                "#58fd40d9",
                "rgba(255, 206, 86, 0.2)",
                "rgba(75, 192, 192, 0.2)",
                "rgba(153, 102, 255, 0.2)",
                "rgba(255, 159, 64, 0.2)",
            ],
            borderColor: [
                "#4064fdd9",
                "#58fd40d9",
                "rgba(255, 206, 86, 1)",
                "rgba(75, 192, 192, 1)",
                "rgba(153, 102, 255, 1)",
                "rgba(255, 159, 64, 1)",
            ],
            borderWidth: 1,
        }, ],
    },

    options: {
        layout: {

            padding: 30
        },
        plugins: {
            tooltip: {
                enabled: false
            },
            labels: {

                fontStyle: 'bolder',
                textMargin: 20,


            },
            datalabels: {
                align: 'center',
                formatter: (value, context) => {
                    const datapoints = context.chart.data.datasets[0].data;

                    function totalSum(total, datapoint) {
                        return total + datapoint;
                    }

                    const totalvalue = datapoints.reduce(totalSum, 0);

                    const porcentageValue = (value / <?= $soma ?> * 100).toFixed(1);
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
    pdf.addImage(canvasImage, 'JPEG', 60, 15, 180, 180);
    pdf.text(15, 15, "MONTENEGRO - PRODUÇÃO")
    pdf.save('Grafico-producao.pdf');
}
</script>