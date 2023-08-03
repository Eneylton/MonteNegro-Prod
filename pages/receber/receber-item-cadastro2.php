<?php

require __DIR__ . '../../../vendor/autoload.php';

use App\Entidy\Cliente;
use App\Entidy\Entregador;
use App\Entidy\EntregadorQtd;
use App\Entidy\EntreRotas;
use App\Entidy\Producao;
use App\Entidy\Receber;
use App\Entidy\Registro;
use App\Entidy\Rota;
use App\Entidy\Setor;
use App\Session\Login;

$id = "";
$qtd_1 = "";
$qtd_2 = "";
$status = "";
$block = "";
$msn = "";
$zero = "";
$disponivel = 0;
$contar = 0;

if (isset($_POST['receber_id'])) {

    $receber_qtd = EntregadorQtd::getIDQtd('*', 'entregador_qtd', 'receber_id=' . $_POST['receber_id'] . ' and entregadores_id=' . $_POST['entregador_id']);

    $rec_qtd =  $receber_qtd->qtd;
    $rec_entregador =  $receber_qtd->entregadores_id;
    $rec_receber_id =  $receber_qtd->receber_id;

    if ($receber_qtd == false) {

        $cadqtd = new EntregadorQtd;

        $cadqtd->qtd                 = $_POST['qtd'];
        $cadqtd->entregadores_id     = $_POST['entregador_id'];
        $cadqtd->receber_id          = $_POST['receber_id'];
        $cadqtd->data_ini            = $_POST['data_inicio'];
        $cadqtd->vencimento          = $_POST['data_fim'];
        $cadqtd->receber_id          = $_POST['receber_id'];
        $cadqtd->cadastar();
    } else {

        $receber_qtd->qtd  = $rec_qtd + $_POST['qtd'];
        $receber_qtd->atualizar();
    }
}

if (isset($_GET['id_item'])) {
    $qtd_entregador = EntregadorQtd::getListView('*', 'view_entregador_qtd as v', 'v.id=' . $_GET['id_item'], null, null, null);
}

if (isset($_POST['id_entrega'])) {

    $param = $_POST['id_entrega'];

    $rotas = EntreRotas::getList(' er.rotas_id as id,
                        e.nome as entregador,
                        r.nome as rotas', 'entregador_rota AS er
                        INNER JOIN
                        entregadores AS e ON (e.id = er.entregadores_id)
                        INNER JOIN
                        rotas AS r ON (r.id = er.rotas_id)', 'er.entregadores_id= ' . $param, null, null);

    foreach ($rotas as $item) {
        $contar += 1;
        echo '
              <option value="' . $item->id . '">' . $contar . ' - ' . $item->rotas . '</option>';
    }
}

if (isset($_POST['id_setores'])) {
    $id = $_POST['id_setores'];

    $servicos = Entregador::getList('*', 'servicos', 'setores_id= ' . $id, null, null);

    foreach ($servicos as $item) {
        echo '
            

              <option value="' . $item->id . '">' . $item->nome . '</option>';
    }
}

if (isset($_GET['id_item'])) {

    $id = $_GET['id_item'];
    $qtd_1 = $_GET['qtd'];
    if ($qtd_1 <= 10) {

        $status = '<span class="badge badge-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i>&nbsp;&nbsp;';
        $msn = "";
        $block = "";
    } else {

        $status = '<span class="badge badge-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;';
        $msn = "";
        $block = "";
    }

    if ($qtd_1 == 0) {

        $status = '<span class="badge badge-success"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;';
        $msn = " TODOS OS ITENS FORAM ENTREGUES ...";
        $block = "disabled";
    }

    if ($qtd_1 != 0) {

        $zero = $qtd_1;
    } else {

        $zero = "";
    }


    define('TITLE', 'TOTAL DE ITENS DISPONIVEIS - ' . $status . '' . $zero . '' . $msn . '</span>');
    define('BRAND', 'Itens');
} else {

    define('TITLE', 'TOTAL DE ITENS DISPONIVEIS - - ');
    define('BRAND', 'Itens');
}

Login::requireLogin();

$usuariologado = Login::getUsuarioLogado();

$usuario = $usuariologado['id'];

if (isset($_POST['enviar'])) {

    $qtd_entregar = intval($_POST['qtd']);

    $receberItem = Receber::getID('*', 'receber', $_POST['receber_id'], null, null);

    $disponivel = $receberItem->disponivel;

    $rotaRegiao = Rota::getID('*', 'rotas', $_POST['rotas_id'], null, null);

    $regioes_id = $rotaRegiao->regioes_id;

    $cliente_id   = $receberItem->clientes_id;

    $qtd_recebida = $receberItem->qtd;

    $clientes = Cliente::getID('*', 'clientes', $cliente_id, null, null);

    $setor = $clientes->setores_id;

    $valor_item = $receberItem->disponivel;

    $soma = ($valor_item - intval($_POST['qtd']));

    $receberItem->disponivel = $soma;

    if ($qtd_entregar > $disponivel) {

        header('location: receber-item-cadastro2.php?id_item=' . $_POST['receber_id'] . '&qtd=' .  $disponivel . '&status=error');

        exit;
    }

    $receberItem->atualizar();

    $item = new Producao;

    switch ($regioes_id) {
        case '74':
            $datafim = date('Y-m-d', strtotime("+0 days", strtotime($_POST['data_fim'])));
            break;

        default:
            $datafim = date('Y-m-d', strtotime("+7 days", strtotime($_POST['data_inicio'])));
            break;
    }

    $item->data_inicio          = $_POST['data_inicio'];
    $item->data_fim             = $datafim;
    $item->qtd                  = intval($_POST['qtd']);
    $item->entregadores_id      = $_POST['entregador_id'];
    $item->regioes_id           = $regioes_id;
    $item->receber_id           = $_POST['receber_id'];
    $item->setores_id           = $_POST['setores'];
    $item->servicos_id          = $_POST['servicos'];
    $item->rotas_id             = $_POST['rotas_id'];
    $item->usuarios_id          = $usuario;
    $item->status               = 1;

    $item->cadastar();

    $id_cad = $item->id;

    $contador = 1;
    $cont = 0;

    if (isset($item->id)) {

        $item2 = new Registro;

        $cont += $contador;

        $item2->usuarios_id          = $usuario;
        $item2->producao_id          = $id_cad;
        $item2->qtd                  = $cont;
        $item2->cadastar();
    }


    define('TITLE', 'TOTAL DE ITENS DISPONIVEIS - <span class="badge badge-danger"><i class="fa fa-minus-circle" aria-hidden="true"></i>&nbsp;&nbsp;' . $soma . '</span>');
    define('BRAND', 'Itens');
    header('location: receber-item-cadastro2.php?id_item=' . $_POST['receber_id'] . '&qtd=' . $soma);

    exit;
}

$entregadores  = Entregador::getList('id,upper(apelido) as apelido', 'entregadores', 'status=1', null, 'nome ASC');
$setores =  Setor::getList('*', 'setores', null, null, 'nome ASC');

include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/receber/receber-form-cadastro2.php';
include __DIR__ . '../../../includes/layout/footer.php';


?>

<script>
    function setor(id) {
        $.ajax({
            type: "POST",
            url: 'receber-item-cadastro.php',
            data: {
                id_setores: id
            },

            success: function(data) {

                $("#servicos").html(data);
            }
        });
    };
</script>

<script>
    function rotas(id) {
        $.ajax({
            type: "POST",
            url: 'receber-item-cadastro.php',
            data: {
                id_entrega: id
            },

            success: function(data) {

                $("#rota").html(data);
            }
        });
    };
</script>