<?php



$resultados = "";
$total_entrega = 0;
$total_devolucao = 0;
$qtd = 0;
$cor = "";
$bed = "";
$jan = 0;
$fer = 0;
$mar = 0;
$abr = 0;
$mai = 0;
$jun = 0;
$jul = 0;
$ago = 0;
$ste = 0;
$otb = 0;
$nov = 0;
$dez = 0;
$total = 0;

$formt = date_default_timezone_set('America/Sao_Paulo');


foreach ($listar as $item) {

    $jan += $item->jan;
    $fer += $item->fer;
    $mar += $item->mar;
    $abr += $item->abr;
    $mai += $item->mai;
    $jun += $item->jun;
    $jul += $item->jul;
    $ago += $item->ago;
    $ste += $item->ste;
    $otb += $item->otb;
    $nov += $item->nov;
    $dez += $item->dez;
    $total += $item->total;

    $resultados .= '<tr>
    <td style="text-transform:uppercase; text-align:left">' . $item->entregador . '</td>
    <td style="text-transform:uppercase; text-align:left">' . $item->setor . '</td>
    <td style="text-transform:uppercase; text-align:center">' . $item->jan . '</td>
    <td style="text-transform:uppercase; text-align:center">' . $item->fer . '</td>
    <td style="text-transform:uppercase; text-align:center">' . $item->mar . '</td>
    <td style="text-transform:uppercase; text-align:center">' . $item->abr . '</td>
    <td style="text-transform:uppercase; text-align:center">' . $item->mai . '</td>
    <td style="text-transform:uppercase; text-align:center">' . $item->jun . '</td>
    <td style="text-transform:uppercase; text-align:center">' . $item->jul . '</td>
    <td style="text-transform:uppercase; text-align:center">' . $item->ago . '</td>
    <td style="text-transform:uppercase; text-align:center">' . $item->ste . '</td>
    <td style="text-transform:uppercase; text-align:center">' . $item->otb . '</td>
    <td style="text-transform:uppercase; text-align:center">' . $item->nov . '</td>
    <td style="text-transform:uppercase; text-align:center">' . $item->dez . '</td>
    <td style="text-transform:uppercase; text-align:center">' . $item->total . '</td>
</tr>';
}


?>

<section class="content">
    <div class="container-fluid">

        <div class="card card-green">
            <div class="card-header">
                <div class="col-12">
                    <a href="relatorio-list.php">
                        <button class="btn btn-primary"><i class="fa fa-circle" style="color:#00254cf2"></i> &nbsp
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
                                    <button class="btn btn-danger">
                                        <i class="fa fa-circle" style="color:#25e958"></i> &nbsp TOTAL SETOR</button>
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
            <div class="col-8">
                <div class="card">
                    <div class="card-header border-0" style="background-color:#2f3ab9;">
                        <form name="form1" action="relatorio-list4.php" method="POST" enctype="multipart/form-data">
                            <div class="d-flex justify-content-between">
                                <div class="row">
                                    <div class="col-3">
                                        <input class="form-control" type="date" name="dataInicio">
                                    </div>
                                    <div class="col-3">
                                        <input class="form-control" type="date" name="dataFim">
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
                                    <div class="col-3">
                                        <select class="form-control select" style="width: 100%;" name="setor_id">
                                            <option value="">SETORES</option>
                                            <?php

                                            foreach ($setores as $item) {
                                                echo '<option style="text-transform: uppercase;" value="' . $item->id . '">COD: ' . $item->cont . ' / ' . $item->nome . '</option>';
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
                                                <th style="width: 10px">ENTREGADOR</th>
                                                <th>SETORES</th>
                                                <th class="centro">JAN</th>
                                                <th class="centro">FEV</th>
                                                <th class="centro">MAR</th>
                                                <th class="centro">ABR</th>
                                                <th class="centro">MAI</th>
                                                <th class="centro">JUN</th>
                                                <th class="centro">JUL</th>
                                                <th class="centro">AGO</th>
                                                <th class="centro">SET</th>
                                                <th class="centro">OUT</th>
                                                <th class="centro">NOV</th>
                                                <th class="centro">DEZ</th>
                                                <th class="centro">TOTAL</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?= $resultados ?>


                                            <tr>
                                                <th colspan="2" class="centro">TOTAL</th>

                                                <th class="centro"><?= $jan ?></th>
                                                <th class="centro"><?= $fer ?></th>
                                                <th class="centro"><?= $mar ?></th>
                                                <th class="centro"><?= $abr ?></th>
                                                <th class="centro"><?= $mai ?></th>
                                                <th class="centro"><?= $jun ?></th>
                                                <th class="centro"><?= $jul ?></th>
                                                <th class="centro"><?= $ago ?></th>
                                                <th class="centro"><?= $ste ?></th>
                                                <th class="centro"><?= $otb ?></th>
                                                <th class="centro"><?= $nov ?></th>
                                                <th class="centro"><?= $dez ?></th>
                                                <th class="centro" style="color:green;font-size:20px"><?= $total ?></th>

                                            </tr>



                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <div class="pagination pagination-sm float-right">

                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
            <div class="col-4">
                <form name="form2" action="relatorio-list4.php" method="POST" enctype="multipart/form-data">
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