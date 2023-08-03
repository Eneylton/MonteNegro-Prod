<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Entregador;
use App\Entidy\Ocorrencia;
use App\Entidy\Retorno;
use App\Entidy\Tipo;
use App\Session\Login;

define('TITLE', 'Backlog');
define('BRAND', 'Devoluções');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);

$condicoes = [
    strlen($buscar) ? 'e.apelido LIKE "%' . str_replace(' ', '%', $buscar) . '%" 
    or 
    o.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%"
    or 
    t.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%"
    or 
    g.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Retorno::getQtd($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 1000);

$listar = Retorno::getList('   
r.id AS id,
r.tipo_id AS tipo_id,
t.id AS tipo_id,
rt.id AS rota_id,
g.id AS gaiolas_id,
r.data AS data,
r.status as status,
r.qtd AS qtd,
e.apelido AS apelido,
r.entregadores_id AS entregadores_id,
r.ocorrencias_id AS ocorrencias_id,
o.nome AS ocorrencia,
t.nome AS tipo,
rt.nome AS rota,
rg.nome AS regiao,
g.nome AS gaiolas', 
' backlog AS r
INNER JOIN
entregadores AS e ON (r.entregadores_id = e.id)
INNER JOIN
ocorrencias AS o ON (r.ocorrencias_id = o.id)
INNER JOIN
tipo AS t ON (r.tipo_id = t.id)
INNER JOIN
rotas AS rt ON (r.entregadores_id = rt.entregadores_id)
INNER JOIN
regioes AS rg ON (rt.regioes_id = rg.id)
INNER JOIN
gaiolas AS g ON (rt.gaiolas_id = g.id)', 'r.tipo_id=2', 'r.id desc', $pagination->getLimit());

$entregadores = Entregador :: getList('*','entregadores',null,'apelido ASC');
$ocorrencias = Ocorrencia :: getList('*','ocorrencias',null,'nome ASC');
$tipos = Tipo :: getList('*','tipo',null,'nome ASC');

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/backlog/backlog-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>


<script>
    $(document).ready(function() {
        $('.editbtn').on('click', function() {
            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            $('#id').val(data[0]);
            $('#nome').val(data[1]);

        });
    });
</script>