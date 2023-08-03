<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Entregador;
use App\Session\Login;

define('TITLE', 'Lista de Rotas');
define('BRAND', 'Rotas');

Login::requireLogin();

$buscar = filter_input(INPUT_GET, 'buscar', FILTER_UNSAFE_RAW);

$condicoes = [
    strlen($buscar) ? 'r.nome LIKE "%' . str_replace(' ', '%', $buscar) . '%" or 
    et.apelido LIKE "%' . str_replace(' ', '%', $buscar) . '%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Entregador::getQtd($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 1000);

$listar = Entregador::getList('er.id AS id,
et.id AS id_entregador,
et.apelido AS entregador,
r.nome AS roteiro', 'entregador_rota AS er
INNER JOIN
rotas AS r ON (r.id = er.rotas_id)
INNER JOIN
entregadores AS et ON (er.entregadores_id = et.id)', $where, 'et.apelido', 'et.nome ASC', $pagination->getLimit());

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/roteiro/roteiro-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';