<?php

$sub_total = 0;
$sub_total2 = 0;
$dev_total = 0;
$dev_total2 = 0;
$bruto = 0;
$bruto2 = 0;
$saldo = 0;
$saldo2 = 0;
$sub = 0;
$sub2 = 0;
$calc = 0;
$calc2 = 0;

$sub_total_dev = 0;
$dev_total_dev = 0;
$bruto_dev = 0;
$saldo_dev = 0;
$sub_dev = 0;
$calc_dev = 0;
$somar = 0;

$resultados = '';
$resultados2 = '';
$valor = 0;
$valor2 = 0;
$boleto = 0;
$cartao = 0;
$pequeno = 0;
$grande = 0;
$param = "";

foreach ($entregas as $item) {

    switch ($item->servico_id) {
        case '1':
            $valor = $item->pequeno;
            $param = "PEQUENO";
            break;
        case '3':
            $valor = $item->boleto;
            $param = "BOLETO";
            break;
        case '4':
            $valor = $item->cartao;
            $param = "CARTÃO";
            break;

        default:
            $valor = $item->grande;
            $param = "GRANDE";
            break;
    }

    $codigo = $item->entregadores_id;

    if ($item->qtd != null) {

        $sub_total = $item->qtd;
    } else {
        $item->qtd = "nenhuma";
    }



    $id = $item->id;


    $sub =  $sub_total *  $valor;

    $calc += $sub;

    $bruto += $sub_total;

    $saldo = $valor;

    $resultados .= '<tr>
                     
                     
                      <td style="text-transform:uppercase">' .  date('d/m/Y', strtotime($item->data)) . '</td>
                      <td style="text-transform:uppercase">' . $item->apelido . '</td>
                      <td style="text-transform:uppercase">' . $item->setores . '</td>
                      <td style="text-transform:uppercase">' . $param . '</td>
                      <td style="text-transform:uppercase; text-align:center"> <h5><span class="badge badge-pill badge-danger">R$ ' . number_format($valor, "2", ",", ".") . '</span></h5> </td>
                      <td style="text-transform:uppercase; text-align:center"> <h5><span class="badge badge-pill badge-success">' . $item->qtd . '</span></h5> </td>
                      <td style="text-transform:uppercase; text-align:center"> <h5><span class="badge badge-pill badge-dark">R$ ' . number_format($sub, "2", ",", ".")  . '</span></h5> </td>
                      
                    
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="6" class="text-center" > Nenhuma devolução até o momento !!!!! </td>
                                                     </tr>';

foreach ($devolucoes as $item2) {

    switch ($item2->servicos_id) {
        case '1':
            $valor2 = $item2->pequeno;
            $param = "PEQUENO";
            break;
        case '3':
            $valor2 = $item2->boleto;
            $param = "BOLETO";
            break;
        case '4':
            $valor2 = $item2->cartao;
            $param = "CARTÃO";
            break;

        default:
            $valor2 = $item2->grande;
            $param = "GRANDE";
            break;
    }

    if ($item2->qtd != null) {

        $sub_total2 = $item2->qtd;
    } else {
        $item2->qtd = "nenhuma";
    }


    $sub2 =  $sub_total2 *  $valor2;

    $calc2 += $sub2;

    $bruto2 += $sub_total2;

    $saldo2 = $valor2;

    $resultados2 .= '<tr>
                                                                        
        
         <td style="text-transform:uppercase">' .  date('d/m/Y', strtotime($item2->data)) . '</td>
         <td style="text-transform:uppercase">' . $item2->apelido . '</td>
     
         <td style="text-transform:uppercase; text-align:left"> <h5><span class="badge badge-pill badge-secondary">' . $item2->ocorrencias . '</span></h5> </td>
         <td style="text-transform:uppercase; text-align:left"> <h5><span class="badge badge-pill badge-secondary">' . $item2->setores . '</span></h5> </td>
         <td style="text-transform:uppercase; text-align:left"> <h5><span class="badge badge-pill badge-secondary">' . $param . '</span></h5> </td>
         <td style="text-transform:uppercase; text-align:center"> <h5><span class="badge badge-pill badge-danger">' . $item2->qtd . '</span></h5> </td>
         
         </tr>

         ';
}

$resultados2 = strlen($resultados2) ? $resultados2 : '<tr>
                                                         <td colspan="6" class="text-center" > Nenhum cliente cadastrado !!!!! </td>
                                                         </tr>';

$somar = $bruto - $bruto2;

?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">PRODUÇÃO DIÁRIA</h3>
                            <a href="#" data-toggle="modal" data-target="#modal-data">
                                <button type="button" class="btn btn-outline-dark text-light">IMPRIMIR</button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">Quantidade: &nbsp; <?= $bruto ?></span>

                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success">
                                    <span style="font-size:30px"><i class="fas fa-arrow-up"></i>&nbsp; R$
                                        <?= number_format($calc, "2", ",", ".") ?></span>
                                </span>
                                <span class="text-muted">Desde o último dia</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="card-body">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>DATA ENTREGA</th>
                                        <th>ENTREGADOR</th>
                                        <th>SETORES</th>
                                        <th>SERVICOS</th>
                                        <th>VL.ENTREGA</th>
                                        <th style="text-align: center;">QTD</th>

                                        <th>SALDO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?= $resultados ?>
                                    </tr>
                                    <tr>
                                        <td colspan=5" style="text-align: right; font-size:22px">
                                            TOTAL
                                        </td>
                                        <td style="text-align: center; font-size:22px">
                                            <?= $bruto ?>
                                        </td>
                                        <td style="text-align: center; font-size:22px">
                                            R$ <?= number_format($calc, "2", ",", ".") ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> Data
                            </span>

                            <span>
                                <i class="fas fa-square text-gray"></i> <?php date_default_timezone_set('America/Sao_Paulo');
                                                                        echo date('d/m/Y') ?>
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">DEVOLUÇÕES</h3>
                            <a href="gerar-pdf.php?id=<?= $codigo  ?>" target="_blank"></a>
                            <button type="button" class="btn btn-outline-dark text-light">IMPRIMIR</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">Quantidade: &nbsp; <?= $bruto2  ?></span>

                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-danger">
                                    <span style="font-size:30px"><i class="fas fa-arrow-down"></i>&nbsp; R$
                                        R$ <?= number_format($calc2, "2", ",", ".") ?></span>
                                </span>
                                <span class="text-muted">Desde o último dia</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="card-body">

                            <table class="table">
                                <thead>
                                    <tr>

                                        <th>DATA DEVOLUÇÃO</th>
                                        <th>ENTREGADOR</th>
                                        <th>OCORRÊNCIAS</th>
                                        <th>SETOR</th>
                                        <th>SERVIÇOS</th>
                                        <th>DEVOLUÇÕES</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?= $resultados2 ?>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right;font-size:22px">
                                            TOTAL
                                        </td>
                                        <td style="text-align: center; font-size:22px">
                                            R$ <?= number_format($calc2, "2", ",", ".") ?>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> Data
                            </span>

                            <span>
                                <i class="fas fa-square text-gray"></i> <?= date('d/m/Y') ?>
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">
                                <P>PRODUÇÃO DIÁRIA</P>
                            </h3>
                            <a href="javascript:void(0);">TOTAL POR DIA </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">R$ <?= number_format($somar, "2", ",", ".") ?></span>
                                <span>Acumulado do dia</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> &nbsp; Entregas <?= $bruto ?> / <span
                                        class="text-danger">
                                        <i class="fas fa-arrow-down"></i> &nbsp; Devoluções <?= $bruto2 ?>
                                    </span>
                                </span>
                                <span class="text-muted">Entrega / Devoluções</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="card-body">

                            <canvas id="myChart2" width="400" height="130"></canvas>

                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-success"></i> Entrega: <?= $bruto ?>
                            </span>

                            <span>
                                <i class="fas fa-square text-danger"></i> Devolução: <?= $dev_total ?>
                            </span>
                        </div>
                    </div>
                </div>

            </div>


        </div>

</section>

<div class="modal fade" id="modal-data">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <form action="./gerar-pdf.php" method="GET" enctype="multipart/form-data">
                <input type="hidden" name="id_caixa" value="<?= $id_caixa ?>">
                <div class="modal-header">
                    <h4 class="modal-title">Relatórios
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
                                                                                echo date('Y-m-d') ?>"
                                    name="dataInicio">
                            </div>


                            <div class="col-lg-6 col-6">
                                <input class="form-control" type="date" value="<?php date_default_timezone_set('America/Sao_Paulo');
                                                                                echo date('Y-m-d') ?>" name="dataFim">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Gerar relatório</button>
                </div>

            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>