<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Combustivel;
use App\Entidy\Entregador;
use App\Entidy\Veiculo;
use App\Session\Login;

define('TITLE', 'Lista de Combustível');
define('BRAND', 'Combustível');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_UNSAFE_RAW);

$condicoes = [
    strlen($buscar) ? 'c.id LIKE "%' . str_replace(' ', '%', $buscar) . '%" or 
                       et.apelido LIKE "%' . str_replace(' ', '%', $buscar) . '%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Combustivel::getQtd($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 10);

$listar = Combustivel::getList(' c.id AS id,c.data as data,
c.placa as placa,
v.nome as veiculo,
et.apelido as entregador,
c.valor as valor', 'combustivel AS c
INNER JOIN
veiculos AS v ON (v.id = c.veiculos_id) 
INNER JOIN
entregadores AS et ON (et.id = c.entregadores_id)', $where, null, 'c.id desc', $pagination->getLimit());

$entregadores = Entregador::getList('*', 'entregadores', null, null, 'apelido ASC');
$veiculos = Veiculo::getList('*', 'veiculos', null, null, 'nome ASC');


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/combustivel/combustivel-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script>
async function Editar(id) {
    const dadosResp = await fetch('combustivel-modal.php?id=' + id);
    const result = await dadosResp.json();

    const editModal = new bootstrap.Modal(document.getElementById("editModal"));
    editModal.show();
    document.querySelector(".edit-modal").innerHTML = result['dados'];

}
</script>