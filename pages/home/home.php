<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Cliente;
use App\Entidy\Combustivel;
use App\Entidy\Devolucao;
use App\Entidy\Entrega;
use App\Entidy\EntregaDevolucao;
use App\Entidy\Entregador;
use App\Entidy\Producao;
use App\Session\Login;

define('TITLE', 'Painel de controle');
define('BRAND', 'Painel de controle ');
Login::requireLogin();

$resultados = "";
$total_entrega3 = 0;
$total_devolucao = 0;
$qtd = 0;
$cor = "";
$bed = "";
$formt = date_default_timezone_set('America/Sao_Paulo');

$total_entrega = 0;

$entregadores = Entregador::getList('*', 'entregadores', null, null, 'nome ASC');

$entregas = Entrega::getTotal('sum(e.qtd) as total', ' entrega AS e
INNER JOIN
entregadores AS et ON (e.entregadores_id = et.id)
INNER JOIN
producao AS p ON (e.producao_id = p.id)
INNER JOIN
receber AS r ON (r.id = p.receber_id)
INNER JOIN
setores AS s ON (s.id = r.setores_id)', 'month(e.data) = MONTH(NOW()) AND year(e.data) = year(NOW()) AND s.id = 3 ');

$total_entrega3 = $entregas->total;

$dev = Devolucao::getTotal('sum(d.qtd) as total', '  devolucao AS d
INNER JOIN
entregadores AS et ON (d.entregadores_id = et.id)
INNER JOIN
producao AS p ON (d.producao_id = p.id)
INNER JOIN
receber AS r ON (r.id = p.receber_id)
INNER JOIN
setores AS s ON (s.id = r.setores_id)', 'month(d.data) = MONTH(CURRENT_DATE()) AND year(d.data) = year(now()) AND s.id = 3');

$total_dev = $dev->total;

$valorProducao = Entrega::getList(' st.id AS setores,
s.id AS servicos,
et.valor_boleto AS boleto,
et.valor_cartao AS cartao,
e.qtd AS qtd ', ' entrega AS e
INNER JOIN
entregadores AS et ON (e.entregadores_id = et.id)
INNER JOIN
producao AS p ON (e.producao_id = p.id)
INNER JOIN
receber AS r ON (r.id = p.receber_id)
INNER JOIN
setores AS s ON (s.id = r.setores_id)
INNER JOIN
servicos AS st ON (st.id = r.servicos_id)', 'month(e.data) = MONTH(CURRENT_DATE()) AND year(e.data) = year(now()) AND s.id = 3', 'et.valor_boleto', null);

$valorProducaodev = Devolucao::getList(' st.id AS setores,
s.id AS servicos,
et.valor_boleto AS boleto,
et.valor_cartao AS cartao,
d.qtd AS qtd', '   devolucao AS d
INNER JOIN
entregadores AS et ON (d.entregadores_id = et.id)
INNER JOIN
producao AS p ON (d.producao_id = p.id)
INNER JOIN
receber AS r ON (r.id = p.receber_id)
INNER JOIN
setores AS s ON (s.id = r.setores_id)
INNER JOIN
servicos AS st ON (st.id = r.servicos_id)', 'month(d.data) = MONTH(CURRENT_DATE()) AND year(d.data) = year(now()) AND s.id = 3', 'et.valor_boleto', null);

$total_entregas = Entrega::getList(' et.apelido AS entregadores, SUM(e.qtd) AS total', 'entrega AS e
INNER JOIN
entregadores AS et ON (e.entregadores_id = et.id)', ' MONTH(e.data) = MONTH(CURRENT_DATE()) AND year(e.data) = year(now())', 'et.nome', 'total DESC LIMIT 20');

$total_ocorrencias = Devolucao::getList(' o.nome AS ocorrencias, SUM(d.qtd) AS total', ' devolucao AS d
INNER JOIN
ocorrencias AS o ON (d.ocorrencias_id = o.id)', ' MONTH(d.data) = MONTH(CURRENT_DATE()) AND year(d.data) = year(now())', 'o.nome');

$total_entregasecommerce = Entrega::getList('e.apelido as apelido,
    SUM(e.valor_boleto) AS boleto,
    SUM(e.valor_cartao) AS cartao,
    SUM(e.valor_pequeno) AS pequeno,
    SUM(e.valor_grande) AS grande', 'entregadores AS e Left join entrega as et ON (e.id = et.entregadores_id)', ' MONTH(et.data) = MONTH(NOW())
    AND YEAR(et.data) = YEAR(NOW())', ' e.apelido', null);

$total_entregasecommercedev = Devolucao::getList('e.apelido as apelido,
    SUM(e.valor_boleto) AS boleto,
    SUM(e.valor_cartao) AS cartao,
    SUM(e.valor_pequeno) AS pequeno,
    SUM(e.valor_grande) AS grande', 'entregadores AS e Left join devolucao as et ON (e.id = et.entregadores_id)', ' MONTH(et.data) = MONTH(NOW())
    AND YEAR(et.data) = YEAR(NOW())', ' e.apelido', null);



$inicio = "";
$fim = "";
$data = "";
$cliente = "";
$entregador = "";
$status = 1;
$data = 1;
$id_param  = 0;

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


$condicoes = [
    strlen($inicio) ? "date(p.data) between date('$inicio') AND date('$fim')"   : null,
    strlen($cliente) ? "r.clientes_id  =" . $cliente : null,
    strlen($entregador) ? "p.entregadores_id =" . $entregador : null
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
    $where,
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
    'p.id AS id,
    p.setores_id AS setores_id,
    p.servicos_id AS servicos_id,
p.data AS data,
r.id AS codigo,
c.nome AS nome,
st.nome AS setores,
et.apelido AS entregadores,
et.valor_boleto as boleto,
et.valor_cartao as cartao,
et.valor_pequeno as pequeno,
et.valor_grande as grande,
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
servicos AS sv ON (p.servicos_id = sv.id)
INNER JOIN
setores AS st ON (p.setores_id = st.id)',
    null,
    'et.apelido',
    'et.apelido ASC',
    $pagination->getLimit()
);

$listar2 = EntregaDevolucao::getList('ed.id AS id,
p.setores_id AS setores_id,
p.servicos_id AS servicos_id,
UPPER(et.apelido) AS apelido,
UPPER(st.nome) AS setores,
(CASE
    WHEN p.servicos_id = 1 THEN "PEQUENO VOLUME"
    WHEN p.servicos_id = 5 THEN "GRANDE VOLUNE"
    ELSE "MÉDIO"
END) volume,
ed.entrega AS entrega,
ed.devolucao AS devolucao,
et.valor_pequeno AS pequeno,
et.valor_grande AS grande,
et.valor_boleto AS boleto,
et.valor_cartao AS cartao', 'entrega_devolucao AS ed
INNER JOIN
entregadores AS et ON (ed.entregadores_id = et.id)
INNER JOIN
producao AS p ON (ed.producao_id = p.id)
INNER JOIN
setores AS st ON (p.setores_id = st.id)
INNER JOIN
servicos AS sv ON (p.servicos_id = sv.id)

');

$graficos = Producao::getList(
    'cl.nome as clientes,
    sum(ed.entrega) as entrega,
    sum(ed.devolucao) as devolucao',
    ' entrega_devolucao AS ed
    INNER JOIN
    receber AS r ON (r.id = ed.receber_id)
    INNER JOIN
    clientes AS cl ON (cl.id = r.clientes_id)',
    'MONTH(ed.data) = MONTH(CURRENT_DATE()) AND year(ed.data) = year(now())',
    'cl.nome',
    'cl.nome ASC',
    null

);

$clientes = Cliente::getList('*', 'clientes');

$combustivel = Combustivel::getList('SUM(c.valor) AS total', 'combustivel as c', ' MONTH(c.data) = MONTH(NOW()) AND year(c.data) = year(now())');


include __DIR__ . '../../../includes/dashboard/header.php';
include __DIR__ . '../../../includes/dashboard/top.php';
include __DIR__ . '../../../includes/dashboard/menu.php';
include __DIR__ . '../../../includes/dashboard/content.php';
include __DIR__ . '../../../includes/dashboard/box-infor.php';
include __DIR__ . '../../../includes/dashboard/footer.php';

?>
<script type="text/javascript">
var ctx = document.getElementById('myChart').getContext('2d');

var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [

            <?php

                foreach ($graficos  as $item) {

                    echo "'" . $item->clientes . "',";
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
                    '#43b173',
                    '#43b173'

                ],
                borderColor: [

                    '#43b173',
                    '#43b173'

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


                    '#ff0119',
                    '#ff0119'
                ],
                borderColor: [


                    '#ff0119',
                    '#ff0119'
                ],
                borderWidth: 1,
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