<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Registro;
use App\Entidy\Usuario;
use App\Session\Login;
use Dompdf\Dompdf;
use Dompdf\Options;

define('TITLE', 'Produtividade');
define('BRAND', 'Produtividade');

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$acesso = $usuariologado['acessos_id'];

$usuario = $usuariologado['id'];

$user_acesso = $usuariologado['acessos_id'];

$cliente = "";
$setor = "";
$mes = "month(r.data) = MONTH(CURRENT_DATE())";

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
    strlen($mes) ? "" . $mes : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$result = Registro::getQtdGrupo('u.nome as funcionarios,
sum(r.qtd) as total,
RANK() OVER (ORDER BY total DESC) as ranque ', 'registros AS r
INNER JOIN
usuarios AS u ON (r.usuarios_id = u.id) ', $where, 'u.nome', 'total', null);


$nome = "";
$cont = 1;
$qtd = 0;

foreach ($result as $item) {

    $qtd += $cont;
}

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 6);

$listar = Registro::getQtdGrupo(' u.nome as funcionarios,
sum(r.qtd) as total,
RANK() OVER (ORDER BY total DESC) as ranque ', 'registros AS r
INNER JOIN
usuarios AS u ON (r.usuarios_id = u.id) ', null, 'u.nome', 'total DESC', null);


$total_absoluto = Registro::getTotal('sum(r.qtd) as total ', 'registros as r');

$resul_total = $total_absoluto->total;

$clientes = Usuario::getList('*', 'usuarios', null, null, 'nome ASC');

$graficos = Registro::getQtdGrupo(' u.nome as funcionarios,
sum(r.qtd) as total,
RANK() OVER (ORDER BY total DESC) as ranque ', 'registros AS r
INNER JOIN
usuarios AS u ON (r.usuarios_id = u.id) ', null, 'u.nome', 'total DESC', null);

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

    $dompdf->stream("produtividade.pdf", ["Attachment" => false]);
}



include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/produtividade/produtividade-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script type="text/javascript">
google.charts.load("current", {
    packages: ['corechart']
});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ["Element", "Funcionários", {
            role: "style"
        }],

        <?php
            foreach ($graficos as $item) {

                switch ($item->ranque) {
                    case '1':
                        $cor = "#ff0000";
                        break;
                    case '2':
                        $cor = "#1a73e8";
                        break;
                    case '3':
                        $cor = "#0ab10e";
                        break;
                    case '4':
                        $cor = "#1ae820";
                        break;
                    case '5':
                        $cor = "#1ae820";
                        break;
                    case '6':
                        $cor = "#03bbe5";
                        break;
                    case '7':
                        $cor = "#e5d403";
                        break;
                    case '8':
                        $cor = "#e55603";
                        break;
                    case '9':
                        $cor = "#03e55d";
                        break;
                    case '10':
                        $cor = "#0329e5";
                        break;

                    default:
                        # code...
                        break;
                }

                $qt = intval($item->total);

                echo '["' . $item->funcionarios . '",' . $qt . ', "' . $cor . '"],';
            }

            ?>
    ]);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
        {
            calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation"
        },
        2
    ]);

    var options = {
        title: "PRODUTIVIDADE",
        width: 900,
        height: 400,
        bar: {
            groupWidth: "80%"
        },
        legend: {
            position: "top"
        },
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
    chart.draw(view, options);
}
</script>