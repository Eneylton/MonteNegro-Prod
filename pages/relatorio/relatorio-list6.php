<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Cliente;
use App\Entidy\Entrega;
use App\Entidy\Entregador;
use App\Entidy\Producao;
use App\Session\Login;
use Dompdf\Dompdf;
use Dompdf\Options;

define('TITLE', 'TOTAL GERAL ENTREGA / DEVOLUÇÃO');
define('BRAND', 'Relatorios');

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$acesso = $usuariologado['acessos_id'];

$usuario = $usuariologado['id'];

$user_acesso = $usuariologado['acessos_id'];

$inicio = "";
$fim = "";
$data = "";
$cliente = "";
$entregador = "";
$status = 1;
$data = 1;

if (isset($_GET['id_param'])) {

    $id_param = $_GET['id_param'];
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

    if (isset($_POST['cliente_id'])) {
        $cliente = $_POST['cliente_id'];
    } else {
        $cliente = null;
    }

    if (isset($_POST['entregador_id'])) {
        $entregador = $_POST['entregador_id'];
    } else {
        $entregador = null;
    }
}

$condicoes = [
    strlen($inicio) ? "date(e.data) between date('$inicio') AND date('$fim')"   : null,
    strlen($cliente) ? "r.clientes_id  =" . $cliente : null,
    strlen($entregador) ? "p.entregadores_id =" . $entregador : null,
    strlen($data) ? "month(e.data) = MONTH(CURRENT_DATE())" : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$result = Entrega::getList(
    'p.id AS id,
p.data AS data,
r.id AS codigo,
c.nome AS nome,
st.nome AS setores,
et.apelido AS entregadores,
SUM(ed.entrega) AS entrega,
SUM(ed.devolucao) AS devolucao',
    ' producao AS p
INNER JOIN
entrega_devolucao AS ed ON (p.id = ed.producao_id)
INNER JOIN
receber AS r ON (p.receber_id = r.id)
INNER JOIN
clientes AS c ON (r.clientes_id = c.id)
INNER JOIN
entregadores AS et ON (p.entregadores_id = et.id)
INNER JOIN
setores AS st ON (p.setores_id = st.id)',
    'r.id=' . $id_param,
    'et.apelido',
    'et.apelido ASC',
    null
);


$nome = "";
$cont = 1;
$qtd = 0;

foreach ($result as $item) {

    $qtd += $cont;
}

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 6);

$listar = Producao::getList(
    ' p.id AS id,
	p.data AS data,
    r.id AS codigo,
    c.nome AS nome,
    st.nome AS setores,
    et.apelido AS entregadores,
    SUM(ed.entrega) AS entrega,
    SUM(ed.devolucao) AS devolucao',
    '  producao AS p
    INNER JOIN
entrega_devolucao AS ed ON (p.id = ed.producao_id)
    INNER JOIN
receber AS r ON (p.receber_id = r.id)
    INNER JOIN
clientes AS c ON (r.clientes_id = c.id)
    INNER JOIN
entregadores AS et ON (p.entregadores_id = et.id)
  INNER JOIN
setores AS st ON (p.setores_id = st.id)',
    ' r.id=' . $id_param,
    'et.apelido',
    'et.apelido ASC',
    $pagination->getLimit()
);

$total_absoluto = Producao::getTotal('sum(e.qtd) AS entrega,
sum(d.qtd) AS devolucao ', 'entrega AS e
LEFT JOIN
producao AS p ON (e.producao_id = p.id)
LEFT JOIN
devolucao AS d ON (d.producao_id = p.id)
INNER JOIN
receber AS r ON (p.receber_id = r.id)
INNER JOIN
clientes AS c ON (r.clientes_id = c.id)
INNER JOIN
entregadores AS et ON (e.entregadores_id = et.id)
INNER JOIN
setores AS st ON (p.setores_id = st.id)',  ' r.id=' . $id_param, null, null, null);

$resul_total1 = $total_absoluto->entrega;
$resul_total2 = $total_absoluto->devolucao;

$clientes = Cliente::getList('id,ROW_NUMBER() OVER(ORDER BY id ASC) AS cont,nome ', 'clientes', null, null);
$entregadores = Entregador::getList('*', 'entregadores', null, null, 'nome ASC');

$graficos = Producao::getList(
    'et.apelido as entregador,
            SUM(ed.entrega) AS entrega, SUM(ed.devolucao) AS devolucao',
    'producao AS p
            INNER JOIN
            entrega_devolucao AS ed ON (p.id = ed.producao_id)
            INNER JOIN
            receber AS r ON (p.receber_id = r.id)
            INNER JOIN
            clientes AS c ON (r.clientes_id = c.id)
            INNER JOIN
            entregadores AS et ON (p.entregadores_id = et.id) ',
    ' r.id=' . $id_param,
    'et.apelido',
    'et.apelido ASC',
    null

);

if (isset($_POST['relatorios'])) {

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

    if (isset($_POST['cliente_id'])) {
        $cliente = $_POST['cliente_id'];
    } else {
        $cliente = null;
    }

    if (isset($_POST['entregador_id'])) {
        $entregador = $_POST['entregador_id'];
    } else {
        $entregador = null;
    }

    $dompdf = new Dompdf();
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);

    ob_start();

    require __DIR__ . "/relatorio3-pdf.php";

    $dompdf->loadHtml(ob_get_clean());

    // echo $pdf;

    $dompdf->setPaper("A4");

    $dompdf->render();

    $dompdf->stream("producao.pdf", ["Attachment" => false]);
}

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/relatorio/relatorio7-form-list.php';
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

                    $texto = $item->entregador;

                    echo "'" . $texto . "',";
                }

                ?>
        ],
        datasets: [{
                label: "ENTREGA",
                data: [<?php

                            foreach ($graficos as $item) {

                                echo "'" . $item->entrega . "',";
                            }

                            ?>],
                backgroundColor: [
                    "rgba(0, 0,0, 0.2)",

                ],
                borderColor: [
                    "rgba(0,0, 0, 1)",

                ],
                borderWidth: 1,
            },
            {
                label: "DEVOLUÇÃO",
                data: [<?php

                            foreach ($graficos as $item) {

                                echo "'" . $item->devolucao . "',";
                            }

                            ?>],
                backgroundColor: [


                    "rgba(255, 26, 104, 0.2)",
                ],
                borderColor: [

                    "rgba(255, 26, 104, 1)",
                ],
                borderWidth: 1,
            }
        ],
    },
    options: {
        scales: {
            x: {
                stacked: true
            },

            y: {
                stacked: true,
                beginAtZero: true
            },


        },
        plugins: {

            tooltip: {
                enabled: false
            },

            datalabels: {
                align: 'center',
                anchor: 'center',
                align: 'top',
                formatter: (value, context) => {
                    const datapoints = context.chart.data.datasets[0].data;

                    function totalSum(total, datapoint) {
                        return total + datapoint;
                    }

                    const totalvalue = datapoints.reduce(totalSum, 0);

                    const porcentageValue = (value / totalvalue * 100).toFixed(1);
                    const display = [`QTD ${value}`];
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
    pdf.text(15, 15, "MONTENEGRO - PRODUÇÃO")
    pdf.save('Grafico-producao.pdf');
}
</script>