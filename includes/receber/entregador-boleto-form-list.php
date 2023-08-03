<?php

use App\Entidy\Cliente;
use App\Entidy\Receber;

$resultados = '';
$contador = 0;
$qtd_cont = 0;
$total_boletos = 0;
$soma = 0;
$cores = '';
$disabled = '';
$data = '';
$venciemnto = '';

if (isset($_GET['qtd']) && isset($_GET['data']) && isset($_GET['vencimento'])) {

    $qtd_cont = $_GET['qtd'];
    $data = $_GET['data'];
    $venciemnto = $_GET['vencimento'];
}

if (empty($listar)) {
    $total_boletos = $_GET['qtd'];
}

foreach ($listar as $item) {
    if ($item->status == 1) {
        $cores = '<h4><span class="badge badge-pill badge-success"><i class="fas fa-check"></i> &nbsp; ENTREGUE</span></h4>';
    } else if ($item->status == 3) {

        $cores = '<h4><span class="badge badge-pill badge-warning"><i class="fas fa-check"></i> &nbsp; AGUARDANDO</span></h4>';
    } else if ($item->status == 4) {

        $cores = '<h4><span class="badge badge-pill badge-info"><i class="fas fa-check"></i> &nbsp; EM ROTA</span></h4>';
    } else {

        $cores = '<h4><span class="badge badge-pill badge-danger"><i class="fas fa-check"></i> &nbsp; DEVOLVIDO</span></h4>';
    }

    $contador += 1;

    $total_boletos = $qtd_cont - $contador;

    if ($total_boletos == 0) {
        $disabled = 'disabled';
    } else {
        $disabled = '';
        $total_boletos = $contador;
    }

    $resultados .= '<tr>
                       <td>' . $contador . '</td>
                       <td>' . $item->codigo . '</td>
                       <td> <h4><span class="badge badge-pill badge-secondary"><i class="fas fa-calendar"></i> &nbsp; ' . date('d/m/Y  Á\S  H:i:s', strtotime($item->coleta)) . '</span></h4></td>
                       <td style="text-align:center; text-transform:uppercase;font-size:13px;text-align:left">' . $cores . '</td>
                       <td style="text-align: center;">
                         
                        <a href="../boletos/boleto-delete2.php?id=' . $item->id . '&entregadores_id=' . $item->entregadores_id . '&qtd=' . $_GET['qtd'] . '">
                        <button type="button" class="btn btn-danger"> <i class="fas fa-trash"></i></button>
                        </a>

                       </td>
                    </tr>
 
                       ';
}


if (isset($_GET['entregador_id'])) {

    $id = $_GET['receber_id'];
    $dados = "";
    $cont = 0;
    $select_cli = "";
    $selectded_cli = "";
    $param = $_GET['entregador_id'];
    $receber = Receber::getID('*', 'receber', $id, null, null, null);
    $disponivel = $receber->disponivel;
    $data = $receber->data;
    $vencimento = $receber->vencimento;
    $numero = $receber->numero;
    $qtd = $_GET['qtd'];
    $clientes_id = $receber->clientes_id;

    $clientes = Cliente::getList('*', 'clientes', null, null, 'nome ASC');

    foreach ($clientes as $item) {

        $cont++;

        if ($item->id == $clientes_id) {

            $selectded_cli = "selected";
        } else {

            $selectded_cli = "";
        }

        $select_cli .= '<option ' . $selectded_cli . ' style="text-transform: uppercase;" value="' . $item->id . '" >' . $cont . '-' . $item->nome . '</option>';
    }
}

?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">

                <div class="card back-black">
                    <div class="card-header">
                        <a href="../receber/receber-item-cadastro.php?id_item=<?= $id ?>&qtd=<?= $soma ?>">
                            <button accesskey="q" title="ALT+K" type="button" class="btn btn-warning"
                                data-toggle="modal" data-target="#modal-default"> <i style="font-size: 27px;"
                                    class="fa fa-arrow-circle-left" aria-hidden="true"></i> &nbsp;
                                <span style="font-size: 27px;">VOLTAR</span></button>
                        </a>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <a href="../producao/producao-list.php">
                            <button accesskey="p" title="ALT+P" type="submit" class="btn btn-danger float-right"
                                <?= $disabled ?> data-toggle="modal" data-target="#modal-default"> <i
                                    style="font-size: 27px;" class="fa fa-truck" aria-hidden="true"></i> &nbsp;
                                <span style="font-size: 27px;">TOTAL:
                                    <?= isset($total_boletos) ? $total_boletos : null ?> </span></button>
                        </a>
                    </div>
                    <!-- /.card-header -->

                    <form id="form" action="../receber/receber-adicionar.php" method="post"
                        enctype="multipart/form-data">
                        <input type="hidden" value="<?= $id ?>" name="receber_id">
                        <input type="hidden" value="<?= $param ?>" name="entregador_id">
                        <input type="hidden" value="<?= $qtd  ?>" name="qtd">
                        <input type="hidden" value="<?= $data  ?>" name="data">
                        <input type="hidden" value="<?= $vencimento  ?>" name="vencimento">

                        <div class="modal-body">

                            <div class="row">

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Data da Coleta: </label>
                                        <input disabled value="<?= $data ?>" type="datetime-local" class="form-control"
                                            name="data">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Prazo de Entrega: </label>
                                        <input disabled value="<?= $vencimento ?>" type="datetime-local"
                                            class="form-control" name="vencimento">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Referência</label>
                                        <input disabled type="text" class="form-control" name="numero"
                                            value="<?= $numero ?>" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Clientes</label>
                                        <select disabled class="form-control select" style="width: 100%;"
                                            name="clientes_id" required>
                                            <option value="">Selecione</option>

                                            <?= $select_cli ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label><span style="color:#ff0000">Código de Barras</span></label>

                                        <input id="codbarra2" class="form-control" type="text" name="codbarra2"
                                            autofocus>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label><span style="color:#fff">Código de Barras</span></label>

                                        <button name="adicionar" class="form-control btn btn-dark" type="submit">
                                            Adicionar</button>
                                    </div>
                                </div>


                            </div>

                        </div>


                    </form>

                </div>

            </div>
            <div class="col-6">
                <div class="card">

                    <table id="example" class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Nº</th>
                                <th scope="col">CÓDIGO</th>
                                <th scope="col">DATA DA COLETA</th>
                                <th scope="col">STATUS</th>
                                <th style="text-align: center;">AÇÃO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?= $resultados ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>


    </div>

</section>