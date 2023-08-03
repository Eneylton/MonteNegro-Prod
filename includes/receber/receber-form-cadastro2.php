<?php

$status = "";

$cor = "";

if (isset($_GET['status'])) {

    $status .= '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-ban"></i> Atenção!</h5>
    QUANTIDADE MAIOR DO QUE ESPERADO.
</div>';
} else {
    $status .= '';
}


$resultados = '';
$listarEntregador = '';

foreach ($qtd_entregador as $item) {

    if ($item->qtd != 0) {

        $cor = '<span class="info-box-icon bg-danger"><i class="fa fa-envelope" aria-hidden="true"></i></span>';
    } else {
        $cor = '<span class="info-box-icon bg-success"><i class="fa fa-check"></i></span>';
    }

    $data = $item->data_ini;
    $vencimento = $item->vencimento;

    $listarEntregador .= '
    
    <div class="col-md-3 col-sm-6 col-12">
            <a href="entregador-boleto.php?entregador_id=' . $item->entregador_id . '&receber_id=' . $item->id . '&qtd=' . $item->qtd . ' &data=' . $item->data_ini . '&vencimento=' . $item->vencimento . '">
            <div class="info-box">
              ' . $cor . '

              <div class="info-box-content">
                <span class="info-box-text"style="text-transform:uppercase"> ' . $item->entregador . '</span>
                <span class="info-box-number">Qtd : ' . $item->qtd . '</span>
              </div>
           
            </div>
            </a>
          
          </div>
    
    ';
}

?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">

                <?= $status ?>

                <div class="card back-black">
                    <div class="card-header">
                        <a href="../receber/receber-list.php">
                            <button accesskey="q" title="ALT+K" type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-default"> <i style="font-size: 27px;" class="fa fa-arrow-circle-left" aria-hidden="true"></i> &nbsp;
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

                    <form action="./receber-item-cadastro2.php" method="POST">
                        <input type="hidden" value="<?= $id ?>" name="receber_id">
                        <input type="hidden" value="<?= $data ?>" name="data_inicio">
                        <input type="hidden" value="<?= $vencimento ?>" name="vencimento">

                        <div class="modal-body">

                            <div class="row">
                                <div class="col-6">

                                    <div class="form-group">
                                        <label>Início da entrega</label>
                                        <input value="<?php
                                                        date_default_timezone_set('America/Sao_Paulo');
                                                        echo date('Y-m-d\TH:i:s', time()); ?>" type="datetime-local" class="form-control" name="data_inicio" required>
                                    </div>
                                </div>
                                <div class="col-6">

                                    <div class="form-group">
                                        <label>Final da entrega</label>
                                        <input value="<?php
                                                        date_default_timezone_set('America/Sao_Paulo');
                                                        echo date('Y-m-d\TH:i:s', time()); ?>" type="datetime-local" class="form-control" name="data_fim" required>
                                    </div>
                                </div>


                            </div>

                            <div class="row">

                                <div class="col-6">
                                    <label>Entregadores</label>
                                    <select class="form-control select2" style="width: 100%;" name="entregador_id" id="entregadores" onchange="rotas(this.value);" required>
                                        <option value=""> Selecione um entregador </option>
                                        <?php

                                        foreach ($entregadores as $item) {
                                            echo '<option style="text-transform: uppercase;" value="' . $item->id . '">' . $item->apelido . '</option>';
                                        }
                                        ?>

                                    </select>

                                </div>

                                <div class="col-6">
                                    <label>Rotas</label>
                                    <select class="form-control" name="rotas_id" id="rota" required></select>

                                </div>

                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">

                                        <label>Status</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-control">
                                                    <input type="radio" name="setores" value="3" checked> Editorial
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-6">
                                    <div class="form-group">

                                        <label>Entrega</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-control ">
                                                    <input type="radio" name="servicos" value="3" checked> Boletos
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-control ">
                                                    <input type="radio" name="servicos" value="6"> Notificações

                                                </label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <label class="form-control">
                                                    <input type="radio" name="servicos" value="4"> Cartões
                                                </label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <label class="form-control">
                                                    <input type="radio" name="servicos" value="7"> Caixa
                                                </label>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>


                            <br>

                            <div class="row">

                                <div class="col-6">
                                    <label class="vermelho">Quantidade para entrega</label>
                                    <input type="text" name="qtd" value="" class="form-control menor" required>

                                </div>
                                <div class="col-6">
                                    <label style="color:#fff ;">ok</label>
                                    <button name="enviar" class="form-control btn btn-dark float-right" type="submit" <?= $block ?>> ADICIONAR </button>

                                </div>

                            </div>

                        </div>


                    </form>

                </div>

            </div>

            <div class="col-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">LISTA DE ENTREGADORES PARA ESSA REMESSA...</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="display: block;">

                        <div class="row">

                            <?= $listarEntregador ?>

                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

    </div>

</section>