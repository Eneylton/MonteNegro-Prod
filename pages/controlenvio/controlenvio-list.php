<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\ControlEnvio;
use App\Session\Login;

define('TITLE', 'Controle de Envio');
define('BRAND', 'Controle de Envio');

Login::requireLogin();

$listar = ControlEnvio::getList(' c.id as id,
c.data as data,
c.notafiscal as notafiscal,
c.serie as serie,
c.consultora as consultora,
c.status as status,
o.nome as ocorrencia,
n.id as notafiscal_id,
n.chave as chave,
n.razaosocial as razaosocial', '  controlenvio AS c
INNER JOIN
ocorrencias AS o ON (c.ocorrencias_id = o.id)
inner join notafiscal as n ON (c.notafiscal_id = n.id)');

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/controlenvio/controlenvio-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>


<script>
    async function Detalhe(id) {
        const dadosResp = await fetch('EntregadorDetalhe-modal.php?id=' + id);
        const result = await dadosResp.json();

        const editModal = new bootstrap.Modal(document.getElementById("editModal88"));
        editModal.show();
        document.querySelector(".edit-modal88").innerHTML = result['dados'];

    }
</script>

<script>
    async function Detalhe2(id) {
        const dadosResp = await fetch('detalhe-modal.php?id=' + id);
        const result = await dadosResp.json();

        const editModal2 = new bootstrap.Modal(document.getElementById("editModal2"));
        editModal2.show();
        document.querySelector(".edit-modal").innerHTML = result['dados'];

    }
</script>


<script>
    async function Detalhe3(id) {
        const dadosResp = await fetch('destinatario-modal.php?id=' + id);
        const result = await dadosResp.json();

        const editModal3 = new bootstrap.Modal(document.getElementById("editModal3"));
        editModal3.show();
        document.querySelector(".edit-modal1").innerHTML = result['dados'];

    }
</script>