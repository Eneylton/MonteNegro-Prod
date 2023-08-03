<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Ocorrencia;
use App\Entidy\Producao;
use App\Session\Login;

define('TITLE', 'Produção');
define('BRAND', 'Produção');

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

$user_acesso = $usuariologado['acessos_id'];

if ($user_acesso == 1) {
    $listar = Producao::getList(
        '   p.id AS id,
        p.status AS status,
        p.entregadores_id,entregadores_id,
        p.receber_id AS receber_id,
        p.data AS data,
        p.data_inicio AS data_inicio,
        p.data_fim AS data_fim,
        c.nome AS clientes,
        e.apelido AS entregadores,
        p.qtd AS qtd,
        rt.nome AS rota,
        se.nome AS setores,
        s.nome AS servicos',
        ' producao AS p
        INNER JOIN
        receber AS r ON (p.receber_id = r.id)
        INNER JOIN
        rotas AS rt ON (p.rotas_id = rt.id)
        INNER JOIN
        clientes AS c ON (r.clientes_id = c.id)
        INNER JOIN
        entregadores AS e ON (p.entregadores_id = e.id)
        INNER JOIN
        regioes AS rg ON (p.regioes_id = rg.id)
        INNER JOIN
        setores AS s ON (p.setores_id = s.id)
        INNER JOIN
        servicos AS se ON (p.servicos_id = se.id)
    ',
        'p.status = 1 ',
        null,
        'p.data DESC',
        null
    );
} else {

    $listar = Producao::getList(
        '   p.id AS id,
        r.id AS receber_id,
        p.status AS status,
        p.entregadores_id,entregadores_id,
        p.receber_id AS receber_id,
        p.data AS data,
        p.data_inicio AS data_inicio,
        p.data_fim AS data_fim,
        c.nome AS clientes,
        e.apelido AS entregadores,
        p.qtd AS qtd,
        rt.nome AS rota,
        se.nome AS setores,
        s.nome AS servicos',
        ' producao AS p
        INNER JOIN
        receber AS r ON (p.receber_id = r.id)
        INNER JOIN
        rotas AS rt ON (p.rotas_id = rt.id)
        INNER JOIN
        clientes AS c ON (r.clientes_id = c.id)
        INNER JOIN
        entregadores AS e ON (p.entregadores_id = e.id)
        INNER JOIN
        regioes AS rg ON (p.regioes_id = rg.id)
        INNER JOIN
        setores AS s ON (p.setores_id = s.id)
        INNER JOIN
        servicos AS se ON (p.servicos_id = se.id)
    ',
        'p.status = 1 AND p.usuarios_id=' . $usuario,
        null,
        'p.data DESC',
        null
    );
}

$ocorrencias = Ocorrencia::getList('*', 'ocorrencias', null, null, 'nome ASC LIMIT 50');

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/producao/producao-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script>
async function Entregar(id) {
    const dadosResp = await fetch('entregar-modal.php?id=' + id);
    console.log(id);
    const result = await dadosResp.json();

    const entregModal = new bootstrap.Modal(document.getElementById("entregModal"));
    entregModal.show();
    document.querySelector(".end-modal").innerHTML = result['dados'];

}
</script>


<script>
async function Devolver(id) {
    const dadosResp = await fetch('devolver-entrega-modal.php?id=' + id);
    console.log(id);
    const result = await dadosResp.json();

    const devModal = new bootstrap.Modal(document.getElementById("devModal"));
    devModal.show();
    document.querySelector(".dev-modal").innerHTML = result['dados'];

}
</script>