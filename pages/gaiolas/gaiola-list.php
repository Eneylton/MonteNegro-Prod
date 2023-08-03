<?php
require __DIR__ . '../../../vendor/autoload.php';

use  App\Entidy\Gaiola;
use  App\Entidy\Rota;
use  App\Session\Login;

define('TITLE', 'Lista de Baias');
define('BRAND', 'Baias');

Login::requireLogin();

$listar = Gaiola::getList('g.id as id,g.nome as gaiolas, SUM(g.qtd) AS total', '  gaiolas AS g', null,null,'g.nome ASC', null);

$rotas = Rota::getList('*', 'rotas');


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/gaiola/gaiola-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script>
async function Editar(id) {
    const dadosResp = await fetch('gaiola-modal.php?id=' + id);
    const result = await dadosResp.json();

    const editModal = new bootstrap.Modal(document.getElementById("editModal"));
    editModal.show();
    document.querySelector(".edit-modal").innerHTML = result['dados'];

}
</script>