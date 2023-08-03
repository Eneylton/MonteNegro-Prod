<?php

use App\Entidy\Cliente;
use App\Entidy\Receber;

$status = '';

if (isset($_GET['status'])) {

    $status .= '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
   ESSE REGISTRO JÁ FOI CASASTRADO ......
</div>';
}

if (isset($_GET['id_param'])) {

    $id = $_GET['id_param'];
    $dados = "";
    $cont = 0;
    $select_cli = "";
    $selectded_cli = "";
    $param = $_GET['id_param'];
    $receber = Receber::getID('*', 'receber', $param, null, null, null);
    $disponivel = $receber->disponivel;
    $data = $receber->data;
    $vencimento = $receber->vencimento;
    $numero = $receber->numero;
    $qtd = $receber->qtd;
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


<?= $status ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">

                <div class="card back-black">
                    <div class="card-header">
                        <a href="lote-list.php">
                            <button accesskey="q" title="ALT+K" type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-default"> <i style="font-size: 27px;" class="fa fa-arrow-circle-left" aria-hidden="true"></i> &nbsp;
                                <span style="font-size: 27px;">EDITORIAL</span></button>
                        </a>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <a href="../producao/producao-list.php">
                            <button accesskey="p" title="ALT+P" type="submit" class="btn btn-danger" data-toggle="modal" data-target="#modal-default"> <i style="font-size: 27px;" class="fa fa-truck" aria-hidden="true"></i> &nbsp;
                                <span style="font-size: 27px;">PRODUÇÃO</span></button>
                        </a>
                    </div>
                    <!-- /.card-header -->

                    <form id="form" action="../receber/receber-insert2.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" value="<?= $id ?>" name="receber_id">

                        <div class="modal-body">

                            <div class="row">

                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Recebido em: </label>
                                        <input value="<?= $data ?>" type="datetime-local" class="form-control" name="data">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Recebido em: </label>
                                        <input value="<?= $vencimento ?>" type="datetime-local" class="form-control" name="vencimento">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Numero do lote</label>
                                        <input type="text" class="form-control" name="numero" value="<?= $numero ?>" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Clientes</label>
                                        <select class="form-control select" style="width: 100%;" name="clientes_id" required>
                                            <option value="">Selecione</option>

                                            <?= $select_cli ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label><span style="color:#ff0000">Código de Barras</span></label>

                                        <input id="codbarra2" class="form-control" type="text" name="codbarra2" autofocus>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label><span style="color:#fff">Código de Barras</span></label>

                                        <button class="form-control btn btn-dark" type="submit"> Adicionar</button>
                                    </div>
                                </div>


                            </div>

                        </div>


                    </form>

                </div>

            </div>

        </div>

    </div>

</section>