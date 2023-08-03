<?php

$list = '';

$resultados = '';

$dia = '';
$cor = '';
$alerta = '';
$total = 0;

if (isset($_GET['status'])) {

    switch ($_GET['status']) {
        case 'condicao':
            $alerta = strlen($alerta) ? $alerta : '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Atenção</h5>
            A QUANTIDADE DEVE SER MENOR OU IGUAL QUE A FORNECIDA ....
            </div>';

            break;
    }
}


foreach ($listar as $item) {

    $total += $item->qtd;

    switch ($item->qtd) {
        case '10':
            $cor2 = "badge-warning";
            $qtd = "10";
            $msn = "Itens Pendentes";
            $disabled = "";
            break;

        case '9':
            $cor2 = "badge-warning";
            $qtd = "9 ";
            $msn = "Itens Pendentes";
            $disabled = "";
            break;

        case '8':
            $cor2 = "badge-warning";
            $qtd = "8";
            $msn = "Itens Pendentes";
            $disabled = "";
            break;


        case '7':
            $cor2 = "badge-warning";
            $qtd = "7";
            $msn = "Itens Pendentes";
            $disabled = "";
            break;


        case '6':
            $cor2 = "badge-warning";
            $qtd = "6";

            $msn = "Itens Pendentes";
            $disabled = "";
            break;


        case '5':
            $cor2 = "badge-danger";
            $qtd = "5";
            $msn = "Itens Pendentes";
            $disabled = "";
            break;
        case '4':
            $cor2 = "badge-danger";
            $qtd = "4";
            $msn = "Itens Pendentes";
            $disabled = "";
            break;

        case '3':
            $cor2 = "badge-danger";
            $qtd = "3";
            $msn = "Itens Pendentes";
            $disabled = "";
            break;

        case '2':
            $cor2 = "badge-danger";
            $qtd = "2";
            $msn = "Pendentes";
            $disabled = "";
            break;

        case '1':
            $cor2 = "badge-danger";
            $qtd = "1";
            $msn = "Item Pendente";
            $disabled = "";
            break;

        case '0':
            $cor2 = "badge-success";
            $qtd = "";
            $msn = "Entrega Concluida";
            $disabled = "disabled";
            break;

        default:
            $cor2 = "badge-dark";
            $qtd = $item->qtd;
            $msn = "Itens p/ entregar";
            $disabled = "";
            break;
    }


    date_default_timezone_set('America/Sao_Paulo');

    $dat1 = date('Y-m-d');
    $data_formatada  = date('d/m/Y', strtotime($dat1));
    $dat2 = $item->data_fim;

    $data1 = strtotime($dat1);
    $data2 = strtotime($dat2);

    $data_final = ($data2 - $data1) / 86400;

    if ($data_final < 0) {
        $data_vencimento = $data_final * -1;
    }

    switch ($data_final) {

        case '-5':
            $cor = "badge-danger";
            $dia = "Já se passaram 5 dias do vencimento...";
            break;
        case '-4':
            $cor = "badge-danger";
            $dia = "Já se passaram 4 dias do vencimento...";
            break;
        case '-3':
            $cor = "badge-danger";
            $dia = "Já se passaram 3 dias do vencimento...";
            break;

        case '-2':
            $cor = "badge-danger";
            $dia = "Já se passaram 2 dias do vencimento...";
            break;

        case '-1':
            $cor = "badge-danger";
            $dia = "Já se passou 1 dia do prazo de vencimento...";
            break;

        case '0':
            $cor = "badge-success";
            $dia = "Dia do vencimento...";
            break;

        case '1':
            $cor = "badge-danger";
            $dia = "Falta apenas 1 dia para o vencimento...";
            break;

        case '2':
            $cor = "badge-primary";
            $dia = "Faltam apenas 2 dias para o vencimento...";
            break;

        case '3':
            $cor = "badge-secondary";
            $dia = "Faltam apenas 3 dias para o vencimento...";
            break;

        case '4':
            $cor = "badge-info";
            $dia = "Faltam apenas 4 dias para o vencimento...";
            break;

        case '5':
            $cor = "badge-primary";
            $dia = "Faltam apenas 5 dias para o vencimento...";
            break;

        default:
            $cor = "badge-dark";
            $dia = "" . date('d/m/Y ', strtotime($dat2)) . "";
            break;
    }


    $resultados .= '<tr>  
                
                      <td><h5><span class="badge badge-pill badge-info">' . $item->receber_id . '</span></h5></td>
                      <td style="text-transform:uppercase">' . date('d/m/Y  Á\S  H:i:s', strtotime($item->data)) . '</td>
                      <td>
                      <h4>
                      <small class="badge badge-pill ' . $cor . '"><i class="far fa-clock"></i> &nbsp; &nbsp;' . $dia . '</small>
                      </h4>
                      </td>
                      <td style="text-transform:uppercase">' . $item->clientes . '</td>
                      <td style="text-transform:uppercase">' . $item->rota  . '</td>
                      <td style="text-transform:uppercase">' . $item->setores  . '</td>
                      <td style="text-transform:uppercase">' . $item->servicos  . '</td>
            
                      <td style="text-transform:uppercase"> <h5><span class="badge badge-pill badge-secondary"> <i class="fa fa-motorcycle" aria-hidden="true"></i> &nbsp;' . $item->entregadores . '</span></h5> </td>
                      <td style="text-align:center">
                      <h4>
                      <small class="badge badge-pill ' . $cor2 . ' ">' . $qtd . '&nbsp;' . $msn . '</small>
                      </h4>
                      </td>
                    
                      <td style="text-align: center;">
                        
                      <button ' . $disabled . ' type="button" class="btn btn-primary" onclick="Entregar(' . $item->id . ')" ><i class="fas fa-fa fa-motorcycle"></i> &nbsp; &nbsp; ENTREGAR </button>
                      &nbsp;
                      <button type="button" onclick="Devolver(' . $item->id . ')"  class="btn btn-danger" ' . $disabled . ' > <i class="fa fa-arrow-right" aria-hidden="true"></i> &nbsp; DEVOLUÇÕES </button>
                      
                      </td>
                      </tr>

                      ';
}

?>

<section class="content">

    <?= $alerta ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-purple">
                    <div class="card-header">
                        <a href="../lotes/lote-list.php"> <button accesskey="q" title="ALT+K" type="submit"
                                class="btn btn-warning" data-toggle="modal" data-target="#modal-default"> <i
                                    class="fas fa-arrow-left"></i> &nbsp; Editorial</button></a>&nbsp;
                        <a href="../receber/receber-list.php"> <button accesskey="q" title="ALT+K" type="submit"
                                class="btn btn-danger" data-toggle="modal" data-target="#modal-default"> <i
                                    class="fas fa-arrow-left"></i> &nbsp; E-commerce</button></a </div>
                    </div>

                    <div class="table-responsive">

                        <table id="example" class="table table-light table-hover table-bordered table-striped">
                            <thead>

                                <tr>

                                    <th> CÓDIGO</th>
                                    <th> DATA </th>
                                    <th style="text-align: center;"> VENCIMENTO </th>
                                    <th> CLIENTES </th>
                                    <th> ROTAS </th>
                                    <th> SETORES </th>
                                    <th> SERVIÇOS </th>
                                    <th> ENTREGADORES </th>
                                    <th style="text-align: center;"> QTD ITENS </th>

                                    <th style="text-align: center;"> AÇÃO </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?= $resultados ?>
                            </tbody>
                            <tr>
                                <td class="direita qtd-40" colspan="8">
                                    <span>TOTAL DE ITENS PENDENTES PARA ENTREGA &nbsp;</span>
                                </td>
                                <td class="centro qtd-40 " colspan="1">
                                    <span style="color:#ff0000"><?= $total ?></span>
                                </td>
                                <td colspan="2">

                                </td>
                            </tr>

                        </table>

                    </div>


                </div>

            </div>

        </div>

    </div>

</section>

<form action="../entrega/entrega-insert.php" method="POST">
    <div class="modal fade" id="entregModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">

            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title">Prazo de Entrega
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="row">

                        <div class="col-12">
                            <span class="end-modal"></span>
                        </div>

                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Entregar
                    </button>
                </div>
            </div>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>


<form action="../devolucao/devolucao-insert.php" method="POST">
    <div class="modal fade" id="devModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">

            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title">Devolução
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <span class="dev-modal"></span>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Devolver
                    </button>
                </div>
            </div>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>