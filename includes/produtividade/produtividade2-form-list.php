<?php

$porcentagem = 0;
$resultados = "";
$total = 0;
$total2 = 0;
$qtd = 0;
$cor = "";
$bed = "";
$star = "";
$contar = 1;
$dispinivel = 0;
$geral_percent = 0;
$soma = 0;


foreach ($listar as $item) {


    $cont += $contar;

    $qtd = $item->total;

    $total += $qtd;

    $porcentagem = round(($qtd / $resul_total * 100), 1);

    $geral_percent += $porcentagem;

    if ($porcentagem > 50.0) {

        $cor = 'class="progress-bar progress-bar bg-success"';
        $bed = 'bg-success"';
    } else {

        $cor = 'class="progress-bar progress-bar bg-danger"';
        $bed = 'bg-danger';
    }

    if ($qtd >= 5 && $qtd <= 9) {

        $star = '<i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp;
        <i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp;
        <i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp;
        <i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp
        <i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp';
    } else if ($qtd  >= 10 && $qtd <= 14) {

        $star = '<i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp;
            <i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp;
            <i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp;
            <i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp
            <i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp';
    } else if ($qtd >= 15 && $qtd <= 19) {

        $star = '<i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp;
            <i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp;
            <i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp;
            <i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp
            <i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp';
    } else if ($qtd >= 20 && $qtd <= 24) {

        $star = '<i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp;
                    <i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp;
                    <i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp;
                    <i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp
                    <i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp';
    } else if ($qtd >= 25) {

        $star = '<i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp;
                                <i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp;
                                <i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp;
                                <i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp
                                <i style="font-size:23px;color:#ffc107" class="fa fa-star"></i>&nbsp';
    } else {

        $star = '<i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp;
            <i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp;
            <i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp;
            <i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp
            <i style="font-size:23px;color:#d1d1d1" class="fa fa-star"></i>&nbsp';
    }

    switch ($item->ranque) {
        case '1':
            $foto = "01.jpg";
            break;

        case '2':
            $foto = "02.jpg";
            break;

        case '3':
            $foto = "03.jpg";
            break;

        default:
            $foto = "04.jpg";
            break;
    }


    $resultados .= '<tr>
    <td ><img src="../../imgs/' . $foto . '" style="width:50px; 50px"></td>
<td style="text-transform:uppercase"><span>' . $item->entregadores  . '</span></span></td>
<td class="centro">' . $item->total . '</td>
<td style="text-align:center"><span style="font-size:14px" class="badge ' . $bed . '">' . $porcentagem . ' %</span></td>
<td class="centro">
    <div >
        ' . $star . '
    </div>
</td>
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
                    <a href="produtividade-list.php">
                        <button class="btn btn-primary "><i class="fa fa-circle" style="color:#00254cf2"></i> &nbsp
                            Relatório 1</button>

                    </a>
                    <span style="padding:7px">
                        <a href="produtividade2-list.php">
                            <button class="btn btn-danger"><i class="fa fa-circle" style="color:#25e958"></i> &nbsp
                                Relatório 2</button>
                        </a>
                        <span style="padding:7px">
                            <a href="relatorio-list3.php">
                                <button class="btn btn-primary"><i class="fa fa-circle" style="color:#00254cf2"></i>
                                    &nbsp Relatório 3</button>
                            </a>
                            <span style="padding:7px">
                                <a href="relatorio-list4.php">
                                    <button class="btn btn-primary ">
                                        <i class="fa fa-circle" style="color:#00254cf2"></i> &nbsp Relatório
                                        4</button>
                                </a>

                                <span style="padding:7px">
                                    <a href="relatorio-list5.php">
                                        <button class="btn btn-primary "><i class="fa fa-circle"
                                                style="color:#00254cf2"></i> &nbsp Relatório
                                        </button>
                                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header border-0" style="background-color:#2f3ab9;">
                        <form name="form1" action="produtividade-list.php" method="POST" enctype="multipart/form-data">
                            <div class="d-flex justify-content-between">
                                <div class="row">



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

                                                <th style="width: 10px">RANK</th>
                                                <th style="width: 400px">FUNCIONÁRIOS</th>
                                                <th class="centro">QTD</th>
                                                <th>PERCENTUAL</th>
                                                <th class="centro">PROGRESSO</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?= $resultados ?>

                                            <tr>
                                                <th colspan="2" style="text-align:center">TOTAL</th>
                                                <th style="text-align:center"><?= $total ?></th>
                                                <th class="centro"><span style="font-size:14px"
                                                        class="badge bg-dark"><?= intval($geral_percent) ?> %</span>
                                                </th>
                                                <th class="centro">PROGRESSO</th>
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
                                <i class="fas fa-square text-primary"></i> TOTAL GERAL:
                                <?= $resul_total ?>
                            </span>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6" id="testing">

                <input type="hidden" name="hidden_html" id="hidden_html">
                <div class="card">
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
                        <div class="card-body">

                            <div id="columnchart_values" style="width: 800px; height: 300px;"></div>

                        </div>
                        </br>
                        </br>
                        </br>
                        </br>
                        </br>
                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2 gd">
                                <i class="fas fa-square text-primary"></i> TOTAL:
                                <?= $geral_percent ?> %
                            </span>


                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</section>