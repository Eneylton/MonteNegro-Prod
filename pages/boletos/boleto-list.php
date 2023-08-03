<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Boleto;
use App\Entidy\Entregador;
use App\Entidy\Receber;
use App\Session\Login;

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

$acesso = $usuariologado['acessos_id'];

$flag = 0;

if ($acesso != 6) {
    define('TITLE', 'Controle de Envio');
    define('BRAND', 'Controle de Envio');
} else {
    define('TITLE', 'Controle de Envio');
    define('BRAND', 'Controle de Envio');
}


if (isset($_GET['id_item'])) {

    $id = $_GET['id_item'];

    $listar = Boleto::getList('b.id,
    b.nota,
    b.sequencia,
    b.codigo,
    b.cliente,
    b.status,
    b.receber_id,
    b.ocorrencias_id,
    b.entregadores_id,
    b.notafiscal_id,
    b.destinatario_id,
    b.ocorrencias_id AS ocorrencias_id,
    o.nome AS ocorrencia,e.id as entregadores_id,
    e.apelido,
    d.nome,
    d.cpf,
    d.logradouro,
    d.numero,
    d.bairro,
    d.municipio,
    d.uf,
    d.cep,
    d.pais,
    d.telefone,
    d.email', 
    
    'boletos AS b
    INNER JOIN
    destinatario AS d ON (b.destinatario_id = d.id)
    INNER JOIN
    ocorrencias AS o ON (o.id = b.ocorrencias_id)
    INNER JOIN
    entregadores AS e ON (b.entregadores_id = e.id)
', 'b.receber_id=' . $id, null, null, null);
}
if (isset($_GET['id_param'])) {

    $id_param = $_GET['id_param'];
    $receber_id = $_GET['receber_id'];

    $res = Receber::getID('*', 'receber', $receber_id, null, null, null);

    $flag = $res->setores_id;

    $listar = Boleto::getList('b.id,
    b.nota,
    b.sequencia,
    b.codigo,
    b.cliente,
    b.status,
    b.receber_id,
    b.ocorrencias_id,
    b.entregadores_id,
    b.notafiscal_id,
    b.destinatario_id,
    b.ocorrencias_id AS ocorrencias_id,
    o.nome AS ocorrencia,e.id as entregadores_id,
    e.apelido,
    d.nome,
    d.cpf,
    d.logradouro,
    d.numero,
    d.bairro,
    d.municipio,
    d.uf,
    d.cep,
    d.pais,
    d.telefone,
    d.email', 
    
    'boletos AS b
    INNER JOIN
    destinatario AS d ON (b.destinatario_id = d.id)
    INNER JOIN
    ocorrencias AS o ON (o.id = b.ocorrencias_id)
    INNER JOIN
    entregadores AS e ON (b.entregadores_id = e.id)
', 'b.entregadores_id=' . $id_param . ' AND b.receber_id=' . $receber_id);
}

$entregadores = Entregador::getList('*', 'entregadores', 'status=1', 'apelido ASC');

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/boleto/boleto-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script>
    async function Editar(id) {
        const dadosResp = await fetch('boleto-modal.php?id=' + id);
        const result = await dadosResp.json();

        const editModal = new bootstrap.Modal(document.getElementById("editModal"));
        editModal.show();
        document.querySelector(".edit-modal").innerHTML = result['dados'];

    }
</script>

<script>
    async function Detalhe6(id) {
        const dadosResp = await fetch('detalhe-control.php?id=' + id);
        const result = await dadosResp.json();

        const editModal2 = new bootstrap.Modal(document.getElementById("editModal2"));
        editModal2.show();
        document.querySelector(".edit2-modal").innerHTML = result['dados'];

    }
</script>

<script>
    async function Detalhe7(id) {
        const dadosResp = await fetch('destinatario-control.php?id=' + id);
        const result = await dadosResp.json();

        const editModal45 = new bootstrap.Modal(document.getElementById("editModal45"));
        editModal45.show();
        document.querySelector(".edit3-modal").innerHTML = result['dados'];

    }
</script>

<script>
    async function Detalhe8(id) {
        const dadosResp = await fetch('endereco-control.php?id=' + id);
        const result = await dadosResp.json();

        const editModal46 = new bootstrap.Modal(document.getElementById("editModal46"));
        editModal46.show();
        document.querySelector(".edit4-modal").innerHTML = result['dados'];

    }
</script>