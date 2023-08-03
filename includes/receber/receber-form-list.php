<?php

$list = '';
$ocultar = '';
$nome = '';
$resultados = '';
$block = '';
$contador  = 0;
$ecommerce  = 'E-commerce';
$campo  = '';
$desc  = '';
$res  = '';

if ($acesso == 6) {
    $ocultar = 'style="display:none"';
}
if ($acesso == 6) {
    $nome = 'Controle de Envio';
} else {
    $nome = 'Controle ';
}

switch ($acesso) {

    case '2':
        $block = "disabled";
        break;
    case '3':
        $block = "";
        break;
    case '4':
        $block = "";
        break;

    default:
        $block = "";
        break;
}


foreach ($listar as $item) {

    $res = $item->coleta;

    $campo = $acesso == 6 ? $ecommerce : $item->setores;

    switch ($item->disponivel) {
        case '10':
            $cor2 = "badge-danger";
            $disponivel = "10";
            $msn = " ITENS PEDENTES";
            $disabled = "";
            break;

        case '9':
            $cor2 = "badge-danger";
            $disponivel = "9";
            $msn = "Pendentes";
            $disabled = "";
            break;

        case '8':
            $cor2 = "badge-danger";
            $disponivel = "8";
            $msn = "Pendentes";
            $disabled = "";
            break;


        case '7':
            $cor2 = "badge-danger";
            $disponivel = "7";
            $msn = "Pendentes";
            $disabled = "";
            break;


        case '6':
            $cor2 = "badge-danger";
            $disponivel = "6";

            $msn = "Pendentes";
            $disabled = "";
            break;


        case '5':
            $cor2 = "badge-danger";
            $disponivel = "5";
            $msn = "Pendentes";
            $disabled = "";
            break;
        case '4':
            $cor2 = "badge-danger";
            $disponivel = "4";
            $msn = "Pendentes";
            $disabled = "";
            break;

        case '3':
            $cor2 = "badge-danger";
            $disponivel = "3";
            $msn = " Pendentes";
            $disabled = "";
            break;

        case '2':
            $cor2 = "badge-danger";
            $disponivel = "2";
            $msn = "Pendentes";
            $disabled = "";
            break;

        case '1':
            $cor2 = "badge-danger";
            $disponivel = "1";
            $msn = "Pendente";
            $disabled = "";
            break;

        case '0':
            $cor2 = "badge-success";
            $disponivel = "";
            $msn = "Itens em Rota";
            $disabled = "disabled";
            break;

        default:
            $cor2 = "badge-dark";
            $disponivel = $item->disponivel;
            $msn = " Itens Disponiveis";
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
            $dia = "Dia da Entrega...";
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
            $dia = "SEM PREVISÃO !!!!";
            break;
    }

    if ($item->coleta == null) {

        $desc = "Não coletado";
    } else {

        $desc = date('d/m/Y  Á\S  H:i:s', strtotime($item->coleta));
    }


    $id = $item->id;

    $contador += 1;

    $resultados .= '<tr>
    

                      <td style="text-transform:uppercase">

                      <a href="#" onclick="ListarEntregador2(' . $item->id . ')" >
                      
                      <h4><span class="badge badge-pill badge-dark">' . $item->id . '</span><h4>

                      </a>
                      
                      </td>

                      <td style="text-transform:uppercase"><strong>' . date('d/m/Y  Á\S  H:i:s', strtotime($item->data)) . '</strong></td>
                      <td style="text-transform:uppercase"> <h4><span class="badge badge-pill badge-info">' . $desc . '</span><h4></td>
                      
                      <td>
                      <h4>
                      <small class="badge badge-pill ' . $cor . '"><i class="far fa-clock"></i> &nbsp; &nbsp;' . $dia . '</small>
                      </h4>
                      </td>
                 
                      <td style="text-transform:uppercase"><strong>' . $item->numero . '</strong></td>
                      <td style="text-transform:uppercase"><strong>' . $item->cliente . '</strong></td>
                      <td style="text-transform:uppercase;font-size:20px">
                      
                      <input ' . $disabled . ' type="text" size="1" class="form-control centro qtd-40" name="val[' . $item->id  . ']" value="' . $item->qtd . '" />
                        <button type="submit" class="btn btn-primary ocultar"><i class="fas fa-search"></i></button>
                      
                      </td>
                      <td style="text-transform:uppercase;FONT-SIZE:20PX"><span class="badge badge-pill ' . $cor2 . '"> <i class="fa fa-plus-circle" aria-hidden="true"></i> &nbsp;' . $disponivel . ' &nbsp;' . $msn . '&nbsp; </span></td>
                    
                      <td style="text-align:center">
                    
                      <a href="../receber/receber-item-cadastro.php?id_item=' . $item->id . '&qtd=' . $disponivel . '">
                    <button ' . $ocultar . ' title="ALT + W" accesskey="w" ' . $disabled . ' type="button" class="btn btn-info" ><i class="fas fa-fa fa-motorcycle"></i> &nbsp; &nbsp; ROTERIZAR </button>
                      </a>
                       &nbsp;
                     
                       <a href="../boletos/boleto-list.php?id_item=' . $item->id . '&entregadores_id=">
                      <button title="ALT + B" accesskey="b" type="button" class="btn btn-warning" ><i class="fas fa-fa fa-list"></i> &nbsp; &nbsp; ' . $nome . ' </button>
                      </a>
                      &nbsp;

                   
                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                      Ações
                    </button>
                    <ul class="dropdown-menu">
                    
                      <li class="dropdown-item"> <a href="#" onclick="MinhasEntregas(' . $item->id . ')" >
                      <button ' . $ocultar . ' title="Minhas Entregas" type="button" class="btn btn-info"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; M.Entregas </button>
                      </a></li>
                      <li class="dropdown-item"><a href="../lotes/lote-form-list.php?id_param=' . $item->id . '">
                      <button ' . $ocultar . ' title="Adicionar Novo Arquivo" name="editar" class="btn btn-success"> <i class="fa fa-star"></i> Adicionar &nbsp;&nbsp;</button>
                      </a></li>
                      <li class="dropdown-item"><a href="#"> <button title="Importar Arquivos" name="editar" class="btn btn-secondary " onclick="Editar222(' . $item->id . ')"> <i class="fa fa-plus"></i> Importar &nbsp;&nbsp;&nbsp;&nbsp;</button></a></li>
                      <li class="dropdown-divider"> <a href="#" onclick="MinhasEntregas(' . $item->id . ')" >
                       <button ' . $ocultar . ' title="Minhas Entregas" type="button" class="btn btn-info"><i class="fa fa-user" aria-hidden="true"></i></button>
                       </a></li>
                      <li class="dropdown-item"> <a href="../relatorio/relatorio-list7.php?id_param=' . $item->id . '">
                       <button ' . $ocultar . ' title="Estatística" type="button" class="btn btn-dark"><i style="font-size:25px" class="ion ion-stats-bars"></i>&nbsp; Estatística</button>
                       </a></li>
                      <li class="dropdown-item">  <a href="lote-delete.php?id=' . $item->id . '">
                       <button ' . $ocultar . ' type="button" class="btn btn-danger"> <i class="fas fa-trash"></i> &nbsp; Deletar &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                       </a></li>
                    </ul>
                 

                      </td>
                      </tr>
                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="9" class="text-center" > Nenhum Registro Adicionado !!!!! </td>
                                                     </tr>';
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card back-black">
                    <div class="card-header">
                        <button accesskey="q" title="ALT+Q" type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal-default"> <i class="fas fa-plus"></i> &nbsp; Novo</button>
                        <a href="../../pages/roteiro/roteiro-list.php"> <button <?= $acesso == 6 ? 'disabled' : ''  ?> type="submit" class="btn btn-danger"> <i class="fa fa-motorcycle"></i>
                                &nbsp;Roteiro /
                                Entregador</button></a>
                        <button disabled <?= $block ?> accesskey="r" title="ALT+R" style="margin-left: 10px;" type="submit" class="btn btn-secondary float-right" data-toggle="modal" data-target="#modal-data"> <i class="fas fa-print"></i> &nbsp; IMPRIMIR RELATÓRIOS</button>
                        <button disabled <?= $block ?> accesskey="e" title="ALT+E" type="submit" class="btn btn-secondary float-right" data-toggle="modal" data-target="#modal-data2"><i class="fas fa-chart-bar"></i> &nbsp;
                            IMPRIMIR ESTATÍSTICA</button>
                    </div>
                    <!-- /.card-header -->


                    <div class="card-body">

                        <table id="example" class="table table-light table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th> CÓDIGO </th>
                                    <th> DATA IMPORTAÇÃO</th>
                                    <th> DATA DA COLETA</th>
                                    <th> PRAZO DE ENTREGA </th>
                                    <th>REFERÊNCIA</th>
                                    <th>CLIENTE</th>

                                    <th class="centro"> QTD </th>
                                    <th> DISPONÍVEL </th>

                                    <th style="text-align: center; width: 400px;"> AÇÃO </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?= $resultados ?>
                            </tbody>


                        </table>


                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<form action="../receber/receber-insert.php" method="post" enctype="multipart/form-data">

    <div class="modal fade" id="modal-default" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-light">
                <input type="hidden" name="rotas" value="93">
                <input type="hidden" name="receber" value="93">

                <div class="modal-header">
                    <h4 class="modal-title">Enviar Arquivos
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-6">
                            <div class="form-group">
                                <label>Recebido em: </label>
                                <input value="<?php
                                                date_default_timezone_set('America/Sao_Paulo');
                                                echo date('Y-m-d\TH:i:s', time()); ?>" type="datetime-local" class="form-control" name="data" required>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Vencimento em:</label>
                                <input value="<?php
                                                date_default_timezone_set('America/Sao_Paulo');
                                                echo date('Y-m-d\TH:i:s', time()); ?>" type="datetime-local" class="form-control" name="vencimento" required>
                            </div>
                        </div>

                        <div class="col-12">

                            <div class="form-group">
                                <label>Cliente</label>
                                <select class="form-control select" style="width: 100%;" name="clientes_id" required>
                                    <option value=""> Selecione um cliente</option>
                                    <?php

                                    foreach ($clientes as $item) {
                                        echo '<option style="text-transform: uppercase;" value="' . $item->id . '">' . $item->nome . '</option>';
                                    }
                                    ?>

                                </select>

                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label>Referência</label>
                                <input type="text" class="form-control" style="text-transform:uppercase;" name="numero" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Importar lote</label>

                                <input class="form-control" type="file" name="arquivo[]" multiple>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label><span style="color:#ff0000">Código de Barras</span></label>

                                <input id="codbarra" class="form-control" type="text" name="codbarra">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="progress progress-bar-success active " style="height: 40px;">
                                <div class="progress-bar " style="width: 0%">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer justify-content-between">
                    <button title="ALT+W" type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button title="ALT+S" accesskey="s" type="submit" class="btn btn-primary">Receber</button>
                </div>


            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>


<form id="form" action="../receber/receber-insert2.php" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="editModal88">
        <div class="modal-dialog modal-lg">

            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title">Receber boletos
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <span class="edit-modal88"></span>


                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button name="importar" type="submit" class="btn btn-primary">Importar
                    </button>
                </div>
            </div>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>

<!-- EDITAR -->


<div class="modal fade" id="editModal4">
    <div class="modal-dialog modal-lg">

        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">Entregadores
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <span class="edit-modal4"></span>


            </div>

        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="editModal5">
    <div class="modal-dialog modal-lg">

        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">Minhas Entregas
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <span class="edit-modal5"></span>


            </div>

        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>