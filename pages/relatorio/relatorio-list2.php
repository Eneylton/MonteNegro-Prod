<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Entregador;
use App\Entidy\Producao;
use App\Entidy\Receber;
use App\Entidy\Rota;
use App\Session\Login;
use Dompdf\Dompdf;
use Dompdf\Options;

define('TITLE', 'TOTAL GERAL POR ROTAS');
define('BRAND', 'Relatorio');

Login::requireLogin();


$usuariologado = Login::getUsuarioLogado();

$acesso = $usuariologado['acessos_id'];

$usuario = $usuariologado['id'];

$user_acesso = $usuariologado['acessos_id'];

$inicio = "";
$fim = "";
$data = "";
$rota = "";
$entregador = "";
$status = 1;
$mes = 'month(e.data) = MONTH(CURRENT_DATE()) ';

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

    if (isset($_POST['rota_id'])) {
        $rota = $_POST['rota_id'];
    } else {
        $rota = null;
    }

    if (isset($_POST['entregador_id'])) {
        $entregador = $_POST['entregador_id'];
    } else {
        $entregador = null;
    }
}

$condicoes = [
    strlen($inicio) ? "date(e.data) between date('$inicio') AND date('$fim')"   : null,
    strlen($rota) ? "r.id =" . $rota : null,
    strlen($entregador) ? "et.id =" . $entregador : null,
    strlen($mes) ? $mes : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$result = Producao::getList('e.data as data,
et.apelido AS entregador,
c.nome as cliente,
r.nome as rotas,
rg.nome as regiao,
sum(e.qtd) as total ', 'producao AS p
INNER JOIN
entregadores AS et ON (p.entregadores_id = et.id)
INNER JOIN
rotas AS r ON (p.rotas_id = r.id) 
INNER JOIN
regioes AS rg ON (p.regioes_id = rg.id) 
INNER JOIN
receber AS rc ON (p.receber_id = rc.id) 
INNER JOIN
entrega AS e ON (e.producao_id = p.id) 
INNER JOIN
clientes AS c ON (c.id = rc.clientes_id)', $where, 'r.nome', 'r.nome ASC', null);


$nome = "";
$cont = 1;
$qtd = 0;

foreach ($result as $item) {

    $qtd += $cont;
}

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 10);

$listar = Producao::getList(
    'e.data as data,
    et.apelido AS entregador,
    c.nome as cliente,
    r.nome as rota,
    rg.nome as regiao,
    sum(e.qtd) as total ',
    ' producao AS p
    INNER JOIN
    entregadores AS et ON (p.entregadores_id = et.id)
    INNER JOIN
    rotas AS r ON (p.rotas_id = r.id) 
    INNER JOIN
    regioes AS rg ON (p.regioes_id = rg.id) 
    INNER JOIN
    receber AS rc ON (p.receber_id = rc.id) 
    INNER JOIN
    entrega AS e ON (e.producao_id = p.id) 
    INNER JOIN
    clientes AS c ON (c.id = rc.clientes_id)',
    $where,
    'r.nome',
    'total DESC',
    $pagination->getLimit()
);

$total_absoluto = Receber::getTotal('
sum(e.qtd) as total ', 'producao AS p
INNER JOIN
entregadores AS et ON (p.entregadores_id = et.id)
INNER JOIN
rotas AS r ON (p.rotas_id = r.id) 
INNER JOIN
regioes AS rg ON (p.regioes_id = rg.id) 
INNER JOIN
receber AS rc ON (p.receber_id = rc.id) 
INNER JOIN
entrega AS e ON (e.producao_id = p.id) 
INNER JOIN
clientes AS c ON (c.id = rc.clientes_id)', $where, null, null, null);

$resul_total = $total_absoluto->total;

$rotas = Rota::getList('id,ROW_NUMBER() OVER(ORDER BY id ASC) AS cont,nome ', 'rotas', null, null);

$entregadores = Entregador::getList('*', 'entregadores', null, null, 'nome ASC');

$graficos = Producao::getList(
    'e.data as data,
    et.apelido AS entregador,
    c.nome as cliente,
    r.nome as rota,
    rg.nome as regiao,
    sum(e.qtd) as total',
    ' producao AS p
    INNER JOIN
    entregadores AS et ON (p.entregadores_id = et.id)
    INNER JOIN
    rotas AS r ON (p.rotas_id = r.id) 
    INNER JOIN
    regioes AS rg ON (p.regioes_id = rg.id) 
    INNER JOIN
    receber AS rc ON (p.receber_id = rc.id) 
    INNER JOIN
    entrega AS e ON (e.producao_id = p.id) 
    INNER JOIN
    clientes AS c ON (c.id = rc.clientes_id)',
    $where,
    'r.nome',
    'total asc',
    $pagination->getLimit()

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

    if (isset($_POST['rota_id'])) {
        $rota = $_POST['rota_id'];
    } else {
        $rota = null;
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

    require __DIR__ . "/relatorio2-pdf.php";

    $dompdf->loadHtml(ob_get_clean());

    // echo $pdf;

    $dompdf->setPaper("A4");

    $dompdf->render();

    $dompdf->stream("rotas.pdf", ["Attachment" => false]);
}



include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/relatorio/relatorio2-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script type="text/javascript">
$(document).ready(function() {

    $('#create_pdf').click(function() {
        $('#hidden_html').val($('#testing').html());
        $('#make_pdf').submit();
    });
});
</script>

<script type="text/javascript">
google.charts.load('current', {
    'packages': ['bar']
});
google.charts.setOnLoadCallback(drawStuff);

function drawStuff() {
    var data = new google.visualization.arrayToDataTable([

        <?php
            echo  '["Rotas", "Percentual"],';
            foreach ($graficos as $item) {

                $total = intval($item->total);
                $porecentagem = round(($total / $resul_total * 100), 1);

                echo '["' . $item->rota . '","' . $porecentagem . '"],';
            }

            ?>
    ]);

    var options = {
        title: 'Gráfico percentual por rotas',
        width: 900,
        legend: {
            position: 'none'
        },
        bars: 'horizontal', // Required for Material Bar Charts.
        axes: {
            x: {
                0: {
                    side: 'top',
                    label: 'Porcentagem'
                } // Top x-axis.
            }
        },
        bar: {
            groupWidth: "90%"
        }
    };

    var chart = new google.charts.Bar(document.getElementById('top_x_div'));
    chart.draw(data, options);
};
</script>