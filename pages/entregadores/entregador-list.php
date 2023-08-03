<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Entregador;
use App\Entidy\FormaPagamento;
use App\Entidy\Regiao;
use App\Entidy\Rota;
use App\Entidy\Servico;
use App\Entidy\Setor;
use App\Entidy\Veiculo;
use App\Session\Login;

define('TITLE', 'Lista de Entregadores');
define('BRAND', 'Entregadores');

Login::requireLogin();

if (isset($_POST['id'])) {

    $id = $_POST['id'];

    $rotas = Rota::getList('*', 'rotas', 'regioes_id= ' . $id, null, null);

    foreach ($rotas as $item) {
        echo '
            

              <option value="' . $item->id . '">' . $item->nome . '</option>';
    }
}


$listar = Entregador::getList(
    'e.id AS id,
    e.admissao AS admissao,
    e.valor_boleto AS valor,
    e.valor_cartao AS cartao,
    e.valor_pequeno AS pequeno,
    valor_grande AS grande,
    e.recisao AS recisao,
    e.status AS status,
    e.tipo AS tipo,
    e.forma_pagamento_id AS forma_pagamento_id,
    e.apelido AS apelido,
    e.nome AS nome,
    e.cnh AS cnh,
    e.renavam AS renavam,
    e.apelido AS entregador,
    e.cpf AS cpf,
    e.telefone AS telefone,
    e.email AS email,
    e.banco AS banco,
    e.veiculos_id AS veiculos_id,
    e.agencia AS agencia,
    e.conta AS conta,
    e.pix AS pix,
    v.nome AS veiculo,
    r.id AS regioes_id,
    r.nome AS regioes',
    'entregadores AS e
    INNER JOIN
    veiculos AS v ON (e.veiculos_id = v.id)
    INNER JOIN
    regioes AS r ON (r.id = e.regioes_id)',
    ' e.status = 1',
    null,
    'e.apelido ASC',
    null
);

$veiculos = Veiculo::getList('*', 'veiculos');
$servicos = Servico::getList('*', 'servicos', null, null, 'nome ASC');
$setores = Setor::getList('*', 'setores');
$pagamentos = FormaPagamento::getList('*', 'forma_pagamento');
$regioes = Regiao::getList('*', 'regioes', null, null, 'nome ASC');


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/entregador/entregador-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';


?>


<script>
async function Editar(id) {
    const dadosResp = await fetch('entregador-modal.php?id=' + id);
    const result = await dadosResp.json();

    const editModal = new bootstrap.Modal(document.getElementById("editModal"));
    editModal.show();
    document.querySelector(".edit-modal").innerHTML = result['dados'];

}
</script>


<script>
$("#regioes").on("change", function() {

    var rg = $("#regioes").val();
    $.ajax({
        url: 'entregador-list.php',
        type: 'POST',
        data: {
            id: rg
        },

        success: function(data) {
            $("#rota").css({
                'display': 'block'
            });
            $("#rota").html(data);
        }
    })

});
</script>

<script>
$("#regioes2").on("change", function() {

    var rg = $("#regioes2").val();
    $.ajax({
        url: 'entregador-list.php',
        type: 'POST',
        data: {
            id: rg
        },

        success: function(data) {
            $("#rota2").css({
                'display': 'block'
            });
            $("#rota2").html(data);
        }
    })

});
</script>

<script>
async function Calculo(valor) {
    console.log(valor);
    $.ajax({
        url: 'entregador-modal.php',
        type: 'POST',
        data: {
            id2: valor
        },

        success: function(data) {
            $("#resultado").css({
                'display': 'block'
            });
            $("#resultado").html(data);
        }

    });
}
</script>