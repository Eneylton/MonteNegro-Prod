<?php

$porecentagem = 0;
$resultados = "";
$total = 0;
$qtd = 0;
$cor = "";
$bed = "";
$contar = 1;
$geral_percent = 0;
$formt = date_default_timezone_set('America/Sao_Paulo');

foreach ($listar as $item) {

    $cont += $contar;

    $qtd = $item->total;

    $total += $qtd;

    $porecentagem = round(($qtd / $resul_total * 100), 1);

    $geral_percent += $porecentagem;

    if ($porecentagem > 50.0) {

        $cor = 'class="progress-bar progress-bar bg-success"';
        $bed = 'bg-success"';
    } else {

        $cor = 'class="progress-bar progress-bar bg-danger"';
        $bed = 'bg-danger';
    }

    $resultados .= '<tr>
    <td><span style="font-size:18px" class="badge bg-dark texto-grande">' . $item->rota . '</span></td>
<td>' . $item->regiao . '</td>
<td class="texto-grande">' . $item->cliente . '</td>
<td class="texto-grande">' . $item->entregador . '</td>
<td class="">' . $item->total . '</td>
<td style="text-align:center"><span style="font-size:14px" class="badge ' . $bed . '">' . $porecentagem . ' %</span></td>
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
                    <a href="relatorio-list.php">
                        <button class="btn btn-primary "><i class="fa fa-circle" style="color:#00254cf2"></i> &nbsp
                            TOTAL CLIENTES</button>

                    </a>
                    <span style="padding:7px">
                        <a href="relatorio-list2.php">
                            <button class="btn btn-danger"><i class="fa fa-circle" style=" color:#25e958"></i> &nbsp
                                TOTAL ROTAS</button>
                        </a>
                        <span style="padding:7px">
                            <a href="relatorio-list3.php">
                                <button class="btn btn-primary"><i class="fa fa-circle" style="color:#00254cf2"></i>
                                    &nbsp TOTAL ENTREGA / DEVOLUÇÃO</button>
                            </a>
                            <span style="padding:7px">
                                <a href="relatorio-list4.php">
                                    <button class="btn btn-primary ">
                                        <i class="fa fa-circle" style="color:#00254cf2"></i> &nbsp TOTAL SETOR</button>
                                </a>

                                <span style="padding:7px">
                                    <a href="relatorio-list5.php">
                                        <button class="btn btn-primary "><i class="fa fa-circle"
                                                style="color:#00254cf2"></i> &nbsp TOTAL OCORRÊNCIA
                                        </button>
                                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header border-0" style="background-color:#2f3ab9;">
                        <form name="form1" action="relatorio-list2.php" method="POST" enctype="multipart/form-data">
                            <div class="d-flex justify-content-between">
                                <div class="row">
                                    <div class="col-3">
                                        <input class="form-control" type="date" name="dataInicio">
                                    </div>
                                    <div class="col-3">
                                        <input class="form-control" type="date" name="dataFim">
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control select" style="width: 100%;" name="rota_id">
                                            <option value="">ROTA</option>
                                            <?php

                                            foreach ($rotas as $item) {
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
                                                <th>ROTAS</th>
                                                <th>REGIÕES</th>
                                                <th>CLIENTES</th>
                                                <th>ENTREGADORES</th>
                                                <th>QTD</th>
                                                <th style="width: 40px">PERCENTUAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?= $resultados ?>



                                            <tr>
                                                <th colspan="5" style="text-align:right">PERCENTUAL</th>

                                                <th style="width: 40px; text-align:center"><span style="font-size:14px"
                                                        class="badge bg-dark"><?= $geral_percent ?>
                                                        %</span></th>
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
                                <i class="fas fa-square text-primary"></i> TOTAL GERAL :
                                <?= $resul_total ?>
                            </span>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6" id="testing">

                <div class="card">
                    <input type="hidden" name="hidden_html" id="hidden_html">
                    <div class="card-header border-0" style="background-color:#ff0000;">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">
                                <P>GRÁFICOS ESTÍSTICOS TOTAL RECEBIDO</P>
                            </h3>
                            <div class="card-tools">
                                <h2 style="color:#ff0000">
                                    <input id="save-pdf" type="button" value="IMPRIMIR" class="btn btn-outline-light"
                                        disabled />
                                </h2>
                            </div>
                        </div>
                    </div>


                    <div class="card-body">
                        </br>
                        <div id="top_x_div" style="height: 1000px;"></div>


                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2 gd" style="margin-top: 80px">
                                <i class="fas fa-square text-primary"></i> PERCENTUAL:
                                <?= $geral_percent ?> %
                            </span>


                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>

</section>