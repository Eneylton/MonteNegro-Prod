<?php

$resultados = "";
$total_entrega = 0;
$total_devolucao = 0;
$qtd = 0;
$cor = "";
$bed = "";
$formt = date_default_timezone_set('America/Sao_Paulo');


foreach ($listar as $item) {

    if ($item->devolucao == "") {

        $param = '<span style="color:#ff0000">0</span>';
    } else {

        $param = $item->devolucao;
    }

    if ($item->entrega == "") {

        $param2 = '<span style="color:#ff0000">0</span>';
    } else {

        $param2 = $item->entrega;
    }

    $total_entrega += $item->entrega;
    $total_devolucao += $item->devolucao;

    $resultados .= '<tr>
    <td style="text-transform:uppercase"><span style="font-size:18px"
    class="badge bg-teal">' . $item->codigo . '</span></td>
    <td style="text-transform:uppercase">' . $item->nome . '</td>
    <td style="text-transform:uppercase">' . $item->setores . '</td>
    <td style="text-transform:uppercase">' . $item->entregadores . '</td>
<td class="centro">' . $param2 . '</td>
<td class="centro">' . $param . '</td>

</tr>';
}


unset($_GET['status']);
unset($_GET['pagina']);
$gets = http_build_query($_GET);

//PAGINAÇÂO

$paginacao = '';
$paginas = $pagination->getPages();

foreach ($paginas as $key => $pagina) {
    $class = $pagina['atual'] ? 'btn-primary' : 'btn-secondary';
    $paginacao .= '<a href="?pagina=' . $pagina['pagina'] . '&' . $gets . '">

                  <button type="button" class="btn ' . $class . '">' . $pagina['pagina'] . '</button>&nbsp
                  </a>';
}


?>

<section class="content">
    <div class="container-fluid">

        <div class="card card-green">
            <div class="card-header">
                <div class="col-12">
                    <a href="../lotes/lote-list.php">

                        <button class="btn btn-danger"><i class="fa fa-circle" style="color:#25ef00"></i> &nbsp
                            EDITORIAL</button>

                    </a>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header border-0" style="background-color:#2f3ab9;">
                        <form name="form1" action="relatorio-list7.php" method="POST" enctype="multipart/form-data">
                            <input class="form-control" type="hidden" value="<?= $id_param  ?>" name="id_param">
                            <div class="d-flex justify-content-between">
                                <div class="row">
                                    <div class="col-3">
                                        <input class="form-control" type="date" name="dataInicio">
                                    </div>
                                    <div class="col-3">
                                        <input class="form-control" type="date" name="dataFim">
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control select" style="width: 100%;" name="cliente_id">
                                            <option value="">CLIENTE</option>
                                            <?php

                                            foreach ($clientes as $item) {
                                                echo '<option style="text-transform: uppercase;" value="' . $item->id . '">COD: ' . $item->cont . ' / ' . $item->nome . '</option>';
                                            }
                                            ?>

                                        </select>
                                    </div>

                                    <div class="col-3">
                                        <select class="form-control select" style="width: 100%;" name="entregador_id">
                                            <option value="">ENTREGADOR</option>
                                            <?php

                                            foreach ($entregadores as $item) {
                                                echo '<option style="text-transform: uppercase;" value="' . $item->id . '">' . $item->apelido . '</option>';
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <button type="submit" name="consultar"
                                        class="btn btn-outline-light float-rigth">CONSULTAR</button>
                                    <button name="relatorios" class="btn btn-outline-light">RELATÓRIO</button>

                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="card-body">

                        <div class="card-body">

                            <div class="card">

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">COD</th>
                                                <th style="width: 10px">CLIENTES</th>
                                                <th>SETORES</th>
                                                <th class="">ENTREGADORES</th>
                                                <th class="centro">ENTREGA</th>
                                                <th class="centro">DEVOLUÇÃO</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?= $resultados ?>

                                            <tr>
                                                <th colspan="4" style="text-align: center;">TOTAL</th>

                                                <th style="color:green; text-align:center;"><span style="font-size:18px"
                                                        class="badge bg-dark"><?= $total_entrega ?></span></th>
                                                <th style="color:red;text-align:center"><span style="font-size:18px"
                                                        class="badge bg-dark"><?= $total_devolucao ?></span></th>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <div class="pagination pagination-sm float-right">
                                        <?= $paginacao ?>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2 gd">
                                <i class="fas fa-square text-primary"></i> ENTREGA
                                :&nbsp; <?= ($total_entrega) ?>

                            </span>

                            <span class="mr-2 gd">
                                <i class="fas fa-square text-danger"></i> DEVOLUÇÕES
                                :&nbsp; <?= ($total_devolucao) ?>

                            </span>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <form name="form2" action="relatorio-list3.php" method="POST" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header border-0" style="background-color:#ff0000;">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">
                                    <P>GRÁFICOS ESTÍSTICOS TOTAL RECEBIDO</P>
                                </h3>
                                <div class="card-tools">
                                    <h2 style="color:#ff0000">
                                        <button type="submit" name="grafico" onclick="dowloadPDF()"
                                            class="btn btn-outline-light">IMPRIMIR</button>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="card-body">

                                <div class="card-body">

                                    <canvas id="myChart" width="305" height="150"></canvas>

                                </div>

                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2 gd">
                                    <i class="fas fa-square text-warning"></i> ESTATÍSTICA
                                </span>


                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</section>