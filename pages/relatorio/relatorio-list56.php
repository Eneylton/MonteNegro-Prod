<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Entrega;
use App\Entidy\Entregador;
use App\Entidy\Ocorrencia;
use App\Session\Login;
use Dompdf\Dompdf;
use Dompdf\Options;

define('TITLE', 'TOTAL GERAL POR OCORRÊNCIAS');
define('BRAND', 'Relatório');

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$acesso = $usuariologado['acessos_id'];

$usuario = $usuariologado['id'];

$user_acesso = $usuariologado['acessos_id'];

$inicio = "";
$fim = "";
$data = "";
$ocorrencia = "";
$entregador = "";
$status = 1;

if (isset($_GET['id_param'])) {

    echo "ok";
}

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

    if (isset($_POST['ocorrencias_id'])) {
        $ocorrencia = $_POST['ocorrencias_id'];
    } else {
        $ocorrencia = null;
    }

    if (isset($_POST['entregador_id'])) {
        $entregador = $_POST['entregador_id'];
    } else {
        $entregador = null;
    }
}

$condicoes = [
    strlen($inicio) ? "date(p.data) between date('$inicio') AND date('$fim')"   : null,
    strlen($ocorrencia) ? "p.setores_id =" . $ocorrencia : null,
    strlen($entregador) ? "p.entregadores_id =" . $entregador : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$listar = Entrega::getList(
    ' e.apelido AS entregador,
    o.nome AS ocorrencias,sum(CASE
        WHEN MONTH(d.data) = 1 THEN o.id
        ELSE NULL
    END) AS jan,
    SUM(CASE
        WHEN MONTH(d.data) = 2 THEN o.id
        ELSE NULL
    END) AS fer,
    SUM(CASE
        WHEN MONTH(d.data) = 3 THEN o.id
        ELSE NULL
    END) AS mar,
    SUM(CASE
        WHEN MONTH(d.data) = 4 THEN o.id
        ELSE NULL
    END) AS abr,
    SUM(CASE
        WHEN MONTH(d.data) = 5 THEN o.id
        ELSE NULL
    END) AS mai,
    SUM(CASE
        WHEN MONTH(d.data) = 6 THEN o.id
        ELSE NULL
    END) AS jun,
    SUM(CASE
        WHEN MONTH(d.data) = 7 THEN o.id
        ELSE NULL
    END) AS jul,
    COUNT(CASE
        WHEN MONTH(d.data) = 8 THEN o.id
        ELSE NULL
    END) AS ago,
    SUM(CASE
        WHEN MONTH(d.data) = 9 THEN o.id
        ELSE NULL
    END) AS ste,
    SUM(CASE
        WHEN MONTH(d.data) = 10 THEN o.id
        ELSE NULL
    END) AS otb,
    SUM(CASE
        WHEN MONTH(d.data) = 11 THEN o.id
        ELSE NULL
    END) AS nov,
    SUM(CASE
        WHEN MONTH(d.data) = 12 THEN o.id
        ELSE NULL
    END) AS dez',
    ' devolucao AS d
    INNER JOIN
ocorrencias AS o ON (d.ocorrencias_id = o.id)
    INNER JOIN
entregadores AS e ON (d.entregadores_id = e.id)',
    $where,
    'o.nome',
    'o.nome ASC',
    null
);

$ocorrencias = Ocorrencia::getList('id,ROW_NUMBER() OVER(ORDER BY id ASC) AS cont,nome ', 'ocorrencias', null, null);
$entregadores = Entregador::getList('*', 'entregadores', null, 'nome ASC');

$graficos = Entrega::getList(
    '   o.nome AS ocorrencias,
    count(o.id) as total',
    ' devolucao AS d
    INNER JOIN
ocorrencias AS o ON (d.ocorrencias_id = o.id)
    INNER JOIN
entregadores AS e ON (d.entregadores_id = e.id)',
    $where,
    'o.nome',
    null,
    null

);

if (isset($_POST['relatorios'])) {

    $dompdf = new Dompdf();
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);

    ob_start();

    require __DIR__ . "/relatorio5-pdf.php";

    $dompdf->loadHtml(ob_get_clean());

    // echo $pdf;

    $dompdf->setPaper("A4", 'landscape');

    $dompdf->render();

    $dompdf->stream("ocoreencia.pdf", ["Attachment" => false]);
}

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/relatorio/relatorio6-form-list.php';
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
        labels: [<?php

                        foreach ($graficos as $item) {

                            echo "'" . substr($item->ocorrencias, 0, 5) . "',";
                        }

                        ?>],
        datasets: [{
            label: "#",
            data: [<?php

                        foreach ($graficos as $item) {

                            echo "'" . $item->total . "',";
                        }

                        ?>],
            backgroundColor: [
                "rgba(255, 206, 86, 0.2)",
                "rgba(75, 192, 192, 0.2)",
                "rgba(255, 99, 132, 0.2)",
                "rgba(54, 162, 235, 0.2)",
                "rgba(153, 102, 255, 0.2)",
                "rgba(255, 159, 64, 0.2)",
            ],
            borderColor: [
                "rgba(255, 206, 86, 1)",
                "rgba(75, 192, 192, 1)",
                "rgba(255, 99, 132, 1)",
                "rgba(54, 162, 235, 1)",
                "rgba(153, 102, 255, 1)",
                "rgba(255, 159, 64, 1)",
            ],
            borderWidth: 1,
        }, ],
    },

    options: {


        indexAxis: 'y',
        scales: {



        },
        plugins: {
            tooltip: {
                enabled: false
            },
            labels: {
                padding: 30,
                render: 'percentage',
                position: 'outside',
                fontStyle: 'bolder',
                textMargin: 8,
                fontColor: ['rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255,1)',
                    'rgba(255, 159, 64, 1)'

                ]

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