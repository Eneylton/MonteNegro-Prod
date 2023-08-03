<?php

$porecentagem = 0;
$resultados = "";
$total = 0;
$total2 = 0;
$qtd = 0;
$cor = "";
$bed = "";
$contar = 1;
$dispinivel = 0;
$geral_percent = 0;
$soma = 0;


foreach ($listar as $item) {


    $cont += $contar;

    $qtd = $item->qtd;

    $dispinivel = $item->disponivel;

    $total += $qtd;
    $total2 = $qtd - $dispinivel;

    $porecentagem = round(($total2 / $resul_total * 100), 1);

    $geral_percent += $porecentagem;

    if ($porecentagem > 50.0) {

        $cor = 'class="progress-bar progress-bar bg-success"';
        $bed = 'bg-success"';
    } else {

        $cor = 'class="progress-bar progress-bar bg-danger"';
        $bed = 'bg-danger';
    }

    $resultados .= '<tr>
    <td><span style="font-size:18px" class="badge bg-secondary">' . $item->codigo . '</td>
<td><span>' . $item->nome . '</span> &nbsp; / &nbsp; <span style="color:#787878; font-size:14px">' . $item->setor . '</span></td>
<td class="centro">' . $item->qtd . '</td>
<td>
    <div class="progress progress-xl">
        <div ' . $cor . '  style="width: ' . $porecentagem . '%"></div>
    </div>
</td>
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
                        <button class="btn btn-danger "><i class="fa fa-circle" style="color:#25e958"></i> &nbsp
                            TOTAL CLIENTES</button>

                    </a>
                    <span style="padding:7px">
                        <a href="relatorio-list2.php">
                            <button class="btn btn-primary "><i class="fa fa-circle" style="color:#00254cf2"></i> &nbsp
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
                        <form name="form1" action="relatorio-list.php" method="POST" enctype="multipart/form-data">
                            <div class="d-flex justify-content-between">
                                <div class="row">
                                    <div class="col-4">
                                        <select class="form-control select" style="width: 100%;" name="clientes_id">
                                            <option value="">Selec Cliente</option>
                                            <?php

                                            foreach ($clientes as $item) {
                                                echo '<option style="text-transform: uppercase;" value="' . $item->id . '">' . $item->nome . '</option>';
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control select" style="width: 100%;" name="mes_id">
                                            <option value="">Mês</option>
                                            <option value="1">JANEIRO</option>
                                            <option value="2"> FEVEREIRO</option>
                                            <option value="3"> MARÇO</option>
                                            <option value="4"> ABRIL</option>
                                            <option value="5"> MAIO</option>
                                            <option value="6"> JUNHO</option>
                                            <option value="7"> JULHO</option>
                                            <option value="8"> AGOSTO</option>
                                            <option value="9"> SETEMBRO</option>
                                            <option value="10"> OUTUBRO</option>
                                            <option value="11"> NOVEMBRO</option>
                                            <option value="12"> DEZEMBRO</option>


                                        </select>
                                    </div>
                                    <div class="col-5">
                                        <p></p>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="radioPrimary1" name="setor" value="3">
                                            <label for="radioPrimary1">
                                                Editorial
                                            </label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="radioPrimary2" name="setor" value="1">
                                            <label for="radioPrimary2">

                                                E-commerce
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-tools">
                                    <h2 style="color:#ff0000"><button type="submit" name="consultar"
                                            class="btn btn-outline-light">CONSULTAR</button>
                                        <button name="relatorios" class="btn btn-outline-light">RELATÓRIO</button>
                                    </h2>

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
                                                <th style="width: 10px">CÓDIGO</th>
                                                <th>CLIENTES</th>
                                                <th class="centro">QTD</th>
                                                <th>PROGRESSO</th>
                                                <th style="width: 40px">PERCENTUAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?= $resultados ?>

                                            <tr>
                                                <th colspan="4" style="text-align:center">TOTAL</th>
                                                <th class="centro"><span style="font-size:14px"
                                                        class="badge bg-dark"><?= intval($geral_percent) ?> %</span>
                                                </th>


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
                                <i class="fas fa-square text-primary"></i> TOTAL GERAL:
                                <?= $total ?>
                            </span>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <form name="form2" action="relatorio-list.php" method="POST" enctype="multipart/form-data">
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
                                    <i class="fas fa-square text-primary"></i> TOTAL:
                                    <?= $geral_percent ?> %
                                </span>


                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</section>