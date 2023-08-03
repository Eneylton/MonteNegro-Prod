<?php
require __DIR__ . '../../../vendor/autoload.php';

use  App\Db\Pagination;
use   App\Entidy\Regiao;
use   App\Session\Login;

define('TITLE', 'Lista de Regiões');
define('BRAND', 'Regiões');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_UNSAFE_RAW);

$condicoes = [
    strlen($buscar) ? 'id LIKE "%' . str_replace(' ', '%', $buscar) . '%" or 
    nome LIKE "%' . str_replace(' ', '%', $buscar) . '%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Regiao::getQtd($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 50);

$listar = Regiao::getList('*', 'regioes', $where, null, 'nome ASC', $pagination->getLimit());

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/regiao/regiao-form-list.php';
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