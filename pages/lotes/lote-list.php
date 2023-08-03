<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Cliente;
use App\Entidy\Entregador;
use App\Entidy\Gaiola;
use App\Entidy\Receber;
use App\Entidy\Regiao;
use App\Entidy\Setor;
use App\Session\Login;

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$acesso = $usuariologado['acessos_id'];

$usuario = $usuariologado['id'];
$user_acesso = $usuariologado['acessos_id'];

if ($user_acesso == 6) {
    define('TITLE', 'Enviar Arquivos');
    define('BRAND', 'Enviar Arquivos');
} else {
    define('TITLE', 'Editorial');
    define('BRAND', 'Editorial');
}


if (isset($_GET['acao'])) {
    if ($_GET['acao'] == 'up') {

        if (isset($_POST['val'])) {

            foreach ($_POST['val'] as $id => $valor) {

                $item = Receber::getID('*', 'receber', $id, null, null);

                $val1 = $item->qtd;

                if ($item->disponivel != 0) {

                    $item->qtd = $valor;
                    $item->disponivel  = $valor;
                }
                $item->atualizar();
            }
        }
    }
}


if (isset($_POST['id_regioes'])) {
    $id_regioes = $_POST['id_regioes'];

    $servicos = Entregador::getList('*', 'entregadores', 'regioes_id= ' . $id_regioes, null, null);

    foreach ($servicos as $item) {
        echo '
            

              <option value="' . $item->id . '">' . $item->nome . '</option>';
    }
}
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $servicos = Entregador::getList('*', 'servicos', 'setores_id= ' . $id, null, null);

    foreach ($servicos as $item) {
        echo '
            

              <option value="' . $item->id . '">' . $item->nome . '</option>';
    }
}

if ($user_acesso == 1) {

    $listar = Receber::getList(' r.id AS id,
    r.data AS data,
    r.vencimento AS vencimento,
    u.nome AS usuario,
    r.qtd AS qtd,
    r.numero AS numero,
    r.clientes_id AS clientes_id,
    r.disponivel AS disponivel,
    c.nome AS cliente,
    st.nome AS setores,
    s.nome AS servicos ', ' receber AS r
    INNER JOIN
clientes AS c ON (r.clientes_id = c.id)
   
    INNER JOIN
setores AS st ON (r.setores_id = st.id)
    INNER JOIN
servicos AS s ON (r.servicos_id = s.id)
    INNER JOIN
usuarios AS u ON (r.usuarios_id = u.id)', 'st.id= 3', null, 'r.id DESC LIMIT 50', null);
} else {
    $listar = Receber::getList(' r.id AS id,
    r.data AS data,
    r.vencimento AS vencimento,
    u.nome AS usuario,
    r.qtd AS qtd,
    r.numero AS numero,
    r.clientes_id AS clientes_id,
    r.disponivel AS disponivel,
    c.nome AS cliente,
    st.nome AS setores,
    s.nome AS servicos ', ' receber AS r
    INNER JOIN
clientes AS c ON (r.clientes_id = c.id)
    INNER JOIN
setores AS st ON (r.setores_id = st.id)
    INNER JOIN
servicos AS s ON (r.servicos_id = s.id)
    INNER JOIN
usuarios AS u ON (r.usuarios_id = u.id)', 'st.id= 3 AND r.usuarios_id=' . $usuario, null, 'r.id DESC LIMIT 50', null);
}


if ($user_acesso == 6) {

    $clientes = Cliente::getList('*', 'clientes', 'usuarios_id=' . $usuario);
} else {
    $clientes = Cliente::getList('*', 'clientes');
}
$baias    = Gaiola::getList('*', 'gaiolas');
$setores =  Setor::getList('*', 'setores');
$regioes =  Regiao::getList('*', 'regioes');


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/lote/lote-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>


<script>
    async function Editar222(id) {
        const dadosResp = await fetch('lote-modal.php?id=' + id);
        const result = await dadosResp.json();

        const editModal = new bootstrap.Modal(document.getElementById("editModal88"));
        editModal.show();
        document.querySelector(".edit-modal88").innerHTML = result['dados'];

    }
</script>

<script>
    async function ListarEntregador(id) {
        const dadosResp = await fetch('listarEntregador-modal.php?id=' + id);
        const result = await dadosResp.json();

        const editModal = new bootstrap.Modal(document.getElementById("editModal4"));
        editModal.show();
        document.querySelector(".edit-modal4").innerHTML = result['dados'];

    }
</script>
<script>
    async function MinhasEntregas(id) {
        const dadosResp = await fetch('minhasEntregas.php?id=' + id);
        const result = await dadosResp.json();

        const editModal = new bootstrap.Modal(document.getElementById("editModal5"));
        editModal.show();
        document.querySelector(".edit-modal5").innerHTML = result['dados'];

    }
</script>
<script>
    async function EditarFormulario(id) {
        const dadosResp = await fetch('formulario-qtd-boleto.php?id=' + id);
        const result = await dadosResp.json();

        const editModal = new bootstrap.Modal(document.getElementById("editModal4"));
        editModal.show();
        document.querySelector(".edit-modal4").innerHTML = result['dados'];

    }
</script>


<script>
    $('#modal-default').on('shown.bs.modal', function() {
        $('#codbarra').trigger('focus')
    })
</script>