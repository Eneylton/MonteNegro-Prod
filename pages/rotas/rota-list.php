<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Gaiola;
use App\Entidy\Regiao;
use App\Entidy\Rota;
use App\Session\Login;

define('TITLE', 'Lista de Rotas');
define('BRAND', 'Rotas');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_UNSAFE_RAW);

$condicoes = [
    strlen($buscar) ? 'r.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%" 
    or 
    rg.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Rota::getQtd($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 1000);

$listar = Rota::getList('r.id as id,
r.regioes_id as regioes_id,
r.gaiolas_id as gaiolas_id,
r.nome as nome,
rg.nome as regiao', 'rotas AS r
INNER JOIN
regioes AS rg ON (r.regioes_id = rg.id)', $where, null, 'rg.nome ASC', $pagination->getLimit());


$regioes = Regiao::getList('*', 'regioes');
$gaiolas = Gaiola::getList('*', 'gaiolas');


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/rota/rota-form-list.php';
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
        $('#regioes_id').val(data[1]);
        $('#gaiolas_id').val(data[2]);
        $('#nome').val(data[3]);
        $('#regiao').val(data[4]);


    });
});
</script>