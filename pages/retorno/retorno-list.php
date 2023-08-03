<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Entregador;
use App\Entidy\Ocorrencia;
use App\Entidy\Retorno;
use App\Entidy\Tipo;
use App\Session\Login;

define('TITLE', 'Lista de Devoluções');
define('BRAND', 'Devoluções');


Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];
$user_acesso = $usuariologado['acessos_id'];


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_UNSAFE_RAW);


if ($buscar == null) {

    $and = "";
} else {

    $and = " AND";
}


$condicoes = [
    strlen($buscar) ? 'e.apelido LIKE "%' . str_replace(' ', '%', $buscar) . '%" 
    or 
    o.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%"
    or 
    t.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%"
    or 
    rc.id LIKE "%' . str_replace(' ', '%', $buscar) . '%"
    or 
    g.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$result = Retorno::getList('*', 'retorno AS r
INNER JOIN
producao AS p ON (r.producao_id = p.id)
INNER JOIN
receber AS rc ON (p.receber_id = rc.id)
INNER JOIN
gaiolas AS g ON (rc.gaiolas_id = g.id)
INNER JOIN
entregadores AS e ON (r.entregadores_id = e.id)
INNER JOIN
ocorrencias AS o ON (r.ocorrencias_id = o.id)
INNER JOIN
tipo AS t ON (r.tipo_id = t.id)', $where, null, null, null);

$nome = "";
$cont = 1;
$qtd = 0;

foreach ($result as $item) {

    $qtd += $cont;
}


$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 50);

if ($user_acesso == 1) {

    $listar = Retorno::getList(
        '   
    r.id AS id,
    r.boletos_id as boletos_id,
    rc.id AS receber_id,
    r.data AS data,
    r.status AS status,
    r.qtd AS qtd,
    e.apelido AS apelido,
    r.entregadores_id AS entregadores_id,
    r.ocorrencias_id AS ocorrencias_id,
    r.producao_id AS producao_id,
    o.nome AS ocorrencia,
    t.nome AS tipo,
    g.id AS gaiolas_id,
    g.nome AS gaiolas',
        ' retorno AS r
    INNER JOIN
    producao AS p ON (r.producao_id = p.id)
    INNER JOIN
    receber AS rc ON (p.receber_id = rc.id)
    INNER JOIN
    gaiolas AS g ON (rc.gaiolas_id = g.id)
    INNER JOIN
    entregadores AS e ON (r.entregadores_id = e.id)
    INNER JOIN
    ocorrencias AS o ON (r.ocorrencias_id = o.id)
    INNER JOIN
    tipo AS t ON (r.tipo_id = t.id)',
        $where . $and . ' r.status = 0 ',
        null,
        'r.data desc',
        $pagination->getLimit()
    );
} else {

    $listar = Retorno::getList(
        '   
    r.id AS id,
    r.boletos_id as boletos_id,
    rc.id AS receber_id,
    r.data AS data,
    r.status AS status,
    r.qtd AS qtd,
    e.apelido AS apelido,
    r.entregadores_id AS entregadores_id,
    r.ocorrencias_id AS ocorrencias_id,
    r.producao_id AS producao_id,
    o.nome AS ocorrencia,
    t.nome AS tipo,
    g.id AS gaiolas_id,
    g.nome AS gaiolas',
        ' retorno AS r
    INNER JOIN
    producao AS p ON (r.producao_id = p.id)
    INNER JOIN
    receber AS rc ON (p.receber_id = rc.id)
    INNER JOIN
    gaiolas AS g ON (rc.gaiolas_id = g.id)
    INNER JOIN
    entregadores AS e ON (r.entregadores_id = e.id)
    INNER JOIN
    ocorrencias AS o ON (r.ocorrencias_id = o.id)
    INNER JOIN
    tipo AS t ON (r.tipo_id = t.id)',
        $where . $and . ' month(r.data) = MONTH(CURRENT_DATE())  AND r.status = 0 AND rc.usuarios_id=' . $usuario,
        null,
        null,
        'r.data desc',
        $pagination->getLimit()
    );
}

$entregadores = Entregador::getList('*', 'entregadores', null, null, 'apelido ASC');
$ocorrencias = Ocorrencia::getList('*', 'ocorrencias', null, null, 'nome ASC');
$tipos = Tipo::getList('*', 'tipo', null, null, 'nome ASC');

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/retorno/retorno-form-list.php';
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
        $('#gaiolas_id').val(data[1]);
        $('#tipo_id').val(data[2]);
        $('#data').val(data[3]);
        $('#qtd').val(data[4]);
        $('#apelido').val(data[5]);
        $('#ocorrencia').val(data[6]);
        $('#tipo').val(data[7]);
        $('#gaiolas').val(data[8]);
        $('#ocorrencias_id').val(data[9]);
        $('#entregadores_id').val(data[10]);
        $('#producao_id').val(data[11]);
        $('#boletos_id').val(data[13]);


    });
});
</script>