<?php

use App\Session\Login;

$prodTotal = 0;
$devTotal = 0;
$totalEditorial = 0;
$totalEcommerce = 0;
$totalEcommercedev = 0;
$totalEditorialdev = 0;
$totalEcommercentrega = 0;
$valor_total_ecommerce = 0;
$valor_total_ecommercedev = 0;
$totalEditorialtrega = 0;
$totalEcommersoma = 0;
$totalEditorialsoma = 0;
$devTotal = 0;
$soma1 = 0;
$soma2 = 0;
$soma3 = 0;
$soma4 = 0;
$somapequeno = 0;
$somagrande = 0;
$somar_entrega = 0;
$somar_devolucao = 0;
$ecommerce_entrega = 0;
$ecommerce_devolucao = 0;
$boleto = 0;
$cartao = 0;
$pequeno = 0;
$grande = 0;
$entrega = 0;
$devolucao = 0;
$total_combustivel = 0;
$qtde1 = 0;
$qtde2 = 0;
$qtde3 = 0;
$qtde4 = 0;
$cor = "";
$ecommerce = "";
$cor2 = "";
$entrega = 0;
$devolucao = 0;

$usuariologado = Login::getUsuarioLogado();

$acesso = $usuariologado['acessos_id'];

$ocorrencias_key = 0;

foreach ($listar2 as $itemkey) {

    $devolucao = $itemkey->devolucao;
    $entrega = $itemkey->entrega;
    $boleto = $itemkey->boleto;
    $cartao = $itemkey->cartao;
    $pequeno = $itemkey->pequeno;
    $grande = $itemkey->grande;


    if ($itemkey->setores_id == 3) {

        if ($entrega != 0) {

            $qtde1 += $entrega;

            switch ($itemkey->servicos_id) {
                case '1':

                    $somar_entrega += ($entrega  *  $pequeno);

                    break;

                case '5':

                    $somar_entrega += ($entrega  *  $grande);

                    break;

                case '3':

                    $somar_entrega += ($entrega  *  $boleto);

                    break;

                default:
                    $somar_entrega += ($entrega  *  $cartao);

                    break;
            }

            $totalEditorialtrega  = $somar_entrega;
        } else {

            $qtde2 += $devolucao;

            switch ($itemkey->servicos_id) {
                case '1':

                    $somar_devolucao += ($devolucao  *  $pequeno);

                    break;

                case '5':

                    $somar_devolucao += ($devolucao  *  $grande);

                    break;

                case '3':

                    $somar_devolucao += ($devolucao  *  $boleto);

                    break;

                default:
                    $somar_devolucao += ($devolucao  *  $cartao);

                    break;
            }

            $totalEditorialsoma =  (-$somar_devolucao);
        }
    } else {

        /*AQui */
        if ($entrega != 0) {

            $qtde3 += $entrega;

            switch ($itemkey->servicos_id) {
                case '1':

                    $ecommerce_entrega += ($entrega  *  $pequeno);

                    break;

                case '5':

                    $ecommerce_entrega += ($entrega  *  $grande);

                    break;

                case '3':

                    $ecommerce_entrega += ($entrega  *  $boleto);

                    break;

                default:
                    $ecommerce_entrega += ($entrega  *  $cartao);

                    break;
            }

            $totalEcommercentrega += $ecommerce_entrega;
        } else {

            $qtde4 += $devolucao;

            switch ($itemkey->servicos_id) {
                case '1':

                    $ecommerce_devolucao += ($devolucao  *  $pequeno);

                    $somapequeno = $ecommerce_devolucao;

                    break;

                case '5':

                    $ecommerce_devolucao += ($devolucao  *  $grande);

                    $somagrande = $ecommerce_devolucao;

                    break;

                case '3':

                    $ecommerce_devolucao += ($devolucao  *  $boleto);

                    break;

                default:
                    $ecommerce_devolucao += ($devolucao  *  $cartao);

                    break;
            }
        }
    }
}
$totalEcommersoma = ($ecommerce_entrega -  $ecommerce_devolucao);

foreach ($total_entregasecommerce as $res) {

    $valor_total_ecommerce += ($res->boleto + $res->cartao +  $res->pequeno +  $res->grande);
}

foreach ($total_entregasecommercedev as $res) {

    $valor_total_ecommercedev += ($res->boleto + $res->cartao +  $res->pequeno +  $res->grande);
}

foreach ($combustivel as $key) {

    $total_combustivel += $key->total;
}

foreach ($total_ocorrencias as $key) {

    $ocorrencias_key += $key->total;
}

foreach ($valorProducao as $key) {

    if ($key->setores == 3) {

        $soma1 = $key->boleto * $total_entrega3;
    } else {

        $soma2 = $key->cartao * $total_entrega3;
    }

    $prodTotal += $soma1 + $soma2;
}


foreach ($valorProducaodev  as $key) {

    if ($key->setores == 3) {

        $soma3 = $key->boleto * $total_dev;
    } else {

        $soma4 = $key->cartao * $total_dev;
    }

    $devTotal += $soma3 + $soma4;
}

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

    if ($acesso == 6) {

        $ecommerce = "E-commerce";
    } else {

        $ecommerce =  $item->setores;
    }

    $resultados .= '<tr>
<td style="text-transform:uppercase"><span style="font-size:18px"
class="badge bg-teal">' . $item->codigo . '</span></td>
<td style="text-transform:uppercase">' . $item->nome . '</td>
<td style="text-transform:uppercase">' .   $ecommerce . '</td>
<td style="text-transform:uppercase">' . $item->entregadores . '</td>
<td style="text-align:center">' . $param2 . '</td>
<td style="text-align:center">' . $param . '</td>

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

if ($totalEcommersoma < 0) {

    $cor = '<span style="color:#ff0000">R$ ' . number_format($totalEcommersoma, "2", ",", ".") . '</span>';
} else {
    $cor = '<span style="color:aqua">R$ ' .  number_format($totalEcommersoma, "2", ",", ".") . '</span>';
}

if ($totalEditorialsoma < 0) {

    $cor2 = '<span style="color:#ebef00">R$ ' . number_format($totalEditorialsoma, "2", ",", ".") . '</span>';
} else {
    $cor2 = '<span style="color:#0cffbc">R$ ' .  number_format($totalEditorialsoma, "2", ",", ".") . '</span>';
}


?>

<di v class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6" style="display:<?php

                                                    switch ($acesso) {
                                                        case '2':
                                                            echo "none";
                                                            break;
                                                        case '3':
                                                            echo "none";
                                                            break;
                                                        case '4':
                                                            echo "none";
                                                            break;

                                                        case '6':
                                                            echo "none";
                                                            break;

                                                        default:
                                                            echo "";
                                                            break;
                                                    }

                                                    ?>">
            <!-- small box -->
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>QTD:&nbsp;<span style="color:aqua"><?= $qtde1 ?></span> &nbsp; <i class="ion ion-android-bicycle"></i></h3>

                    <p> <span style="font-size:24px;">NOTIFICAÇÃO ENTREGUE: </span>
                        <span style="font-size:28px;color:aqua;font-weight:500">R$
                            <?= number_format($somar_entrega, '2', ',', '.') ?></span>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-car"></i>
                </div>

                <a href="#" data-toggle="modal" data-target="#modal-data2" class="small-box-footer">GERAR RELATÓRIOS <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6" style="display:<?php

                                                    switch ($acesso) {
                                                        case '2':
                                                            echo "none";
                                                            break;
                                                        case '3':
                                                            echo "";
                                                            break;
                                                        case '4':
                                                            echo "none";
                                                            break;

                                                        case '6':
                                                            echo "none";
                                                            break;

                                                        default:
                                                            echo "";
                                                            break;
                                                    }

                                                    ?>">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>QTD:&nbsp;<span style="color:yellow"><?= $qtde2 ?></span> &nbsp; <i class="ion ion-android-bicycle"></i></h3>

                    <p> <span style="font-size:24px;">NOTIFICAÇÃO DEVOLUÇÕES: </span>
                        <span style="font-size:28px;font-weight:700">R$
                            <?= $cor2 ?></span>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-car"></i>
                </div>

                <a href="#" data-toggle="modal" data-target="#modal-data3" class="small-box-footer">GERAR RELATÓRIOS <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6" style="display:<?php

                                                    switch ($acesso) {
                                                        case '2':
                                                            echo "none";
                                                            break;
                                                        case '3':
                                                            echo "none";
                                                            break;
                                                        case '4':
                                                            echo "none";
                                                            break;

                                                        case '6':
                                                            echo "none";
                                                            break;

                                                        default:
                                                            echo "";
                                                            break;
                                                    }

                                                    ?>">
            <!-- small box -->
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>E-COMMERCE:&nbsp;<span> R$ <?= number_format($valor_total_ecommerce, '2', ',', '.') ?>

                        </span> &nbsp; <i class="ion ion-android-bicycle"></i></h3>

                    <p> <span style="font-size:24px;">TOTAL DEVOLUÇÕES </span>
                        <span style="font-size:28px;font-weight:700;color:chartreuse">R$
                            <?= number_format($valor_total_ecommercedev, '2', ',', '.') ?></span>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>

                <a href="#" data-toggle="modal" data-target="#modal-data" class="small-box-footer">GERAR RELATÓRIOS
                    <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6" style="display:<?php

                                                    switch ($acesso) {
                                                        case '2':
                                                            echo "none";
                                                            break;
                                                        case '3':
                                                            echo "";
                                                            break;
                                                        case '4':
                                                            echo "none";
                                                            break;

                                                        case '6':
                                                            echo "none";
                                                            break;

                                                        default:
                                                            echo "";
                                                            break;
                                                    }

                                                    ?>">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>TOTAL:&nbsp;<span style="color:yellow">R$
                            <?= number_format($total_combustivel, '2', ',', '.') ?></span> &nbsp;
                        <i class="ion ion-android-bicycle"></i> / <i class="ion ion-android-car"></i>
                    </h3>

                    <p> <span style="font-size:24px;"> TOTAL DE COMBUSTIVEL POR MÊS </span>
                        <span style="font-size:28px;color:yellow;font-weight:500">
                        </span>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-bicycle"></i>
                </div>

                <a href="#" data-toggle="modal" data-target="#modal-data" class="small-box-footer">GERAR RELATÓRIOS <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>


    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header border-0" style="background-color:#2f3ab9;">
                            <form name="form1" action="pages/relatorio/relatorio-principal.php" method="POST">
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
                                        <button type="submit" name="consultar" class="btn btn-outline-light float-rigth">CONSULTAR</button>
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

                                                    <th style="color:green; text-align:center;"><span style="font-size:18px" class="badge bg-dark"><?= $total_entrega ?></span></th>
                                                    <th style="color:red;text-align:center"><span style="font-size:18px" class="badge bg-dark"><?= $total_devolucao ?></span></th>

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
                            <div class="card-header border-0" style="background-color:#2f3ab9;">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">
                                        <P style="color:aliceblue">GRÁFICOS ESTÍSTICOS TOTAL RECEBIDO</P>
                                    </h3>
                                    <div class="card-tools">
                                        <h2 style="color:#ff0000">
                                            <button type="submit" name="grafico" onclick="dowloadPDF()" class="btn btn-outline-light">IMPRIMIR</button>
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


    <div class="modal fade" id="modal-data">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <form action="pages/relatorio/relatorio-volumes.php" method="GET" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title">ENTREGA/ DEVOLUÇÃO E-COMMERCE
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">

                        <div class="form-group">

                            <div class="row">

                                <div class="col-lg-6 col-6">
                                    <input class="form-control" type="date" value="<?php date_default_timezone_set('America/Sao_Paulo');
                                                                                    echo date('Y-m-d') ?>" name="dataInicio">
                                </div>


                                <div class="col-lg-6 col-6">
                                    <input class="form-control" type="date" value="<?php date_default_timezone_set('America/Sao_Paulo');
                                                                                    echo date('Y-m-d') ?>" name="dataFim">
                                </div>

                                <br>
                                <br>
                                <br>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>ENTREGADORES</label>
                                        <select class="form-control select" style="width: 100%;" name="id_caixa">
                                            <option value=""> SELECIONE UM ENTREGADOR </option>
                                            <?php

                                            foreach ($entregadores as $item) {
                                                echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                        <button name="relatorios" type="submit" class="btn btn-primary">Gerar relatório</button>
                    </div>

                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>