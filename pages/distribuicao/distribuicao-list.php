<?php
require __DIR__ . '../../../vendor/autoload.php';

use   App\Db\Pagination;
use   App\Entidy\Distribuicao;
use App\Entidy\Entregador;
use   App\Session\Login;

define('TITLE', 'Distribuição de itens');
define('BRAND', 'Distribuição');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);

$condicoes = [
    strlen($buscar) ? 'nome LIKE "%' . str_replace(' ', '%', $buscar) . '%" 
    or 
    id LIKE "%' . str_replace(' ', '%', $buscar) . '%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Distribuicao::getQtd($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 5);

$listar = Distribuicao::getList('g.id AS id,g.gaiolas_id AS gaiolas_id,ga.rotas_id as rotas_id,
                                 re.clientes_id as clientes_id, r.entregadores_id as entregadores_id,
                                 g.data AS data, g.qtd AS qtd, ga.nome AS gaiolas, cli.nome AS clientes, r.nome AS rotas, e.apelido AS entregador',
                                 'divgaiolas AS g
                                 INNER JOIN
                                 gaiolas AS ga ON (g.gaiolas_id = ga.id)
                                 INNER JOIN
                                 receber AS re ON (g.receber_id = re.id)
                                 INNER JOIN
                                 clientes AS cli ON (re.clientes_id = cli.id)
                                 INNER JOIN
                                 rotas AS r ON (ga.rotas_id = r.id)
                                 INNER JOIN
                                 entregadores AS e ON (r.entregadores_id = e.id)','g.qtd >= 1 ', 'id desc', $pagination->getLimit());
 
 $entregadores = Entregador ::getList('*','entregadores');                                

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/distribuicao/distribuicao-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>


<script>
$(document).ready(function(){
    $('.editbtn2').on('click', function(){
        $('#editmodal2').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function(){
            return $(this).text();
        }).get();

        $('#id').val(data[0]);
        $('#gaiolas_id').val(data[1]);
        $('#rotas_id').val(data[2]);
        $('#clientes_id').val(data[3]);
        $('#entregadores_id').val(data[4]);
        $('#data').val(data[5]);
        $('#qtd').val(data[6]);
        $('#gaiolas').val(data[7]);
        $('#rotas').val(data[8]);
      
    });
});
</script>
