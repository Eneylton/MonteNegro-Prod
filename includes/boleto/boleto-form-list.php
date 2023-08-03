<?php

use App\Entidy\Receber;
use App\Session\Login;

$usuariologado = Login::getUsuarioLogado();

$acesso = $usuariologado['acessos_id'];

$list = '';
$texto = '';
$block = '';
$listSelect = '';
$entregaId = '';
$itemId = 0;
$cont = 0;

$status = "";

if (isset($_GET['id_param'])) {
} else {
    $id_entregador = 0;
}

if (isset($_GET['id_item'])) {

    $itemId = $_GET['id_item'];

    $res = Receber::getID('*', 'receber', $itemId, null, null, null);

    $flag = $res->setores_id;
}

if (isset($_GET['entregadores_id'])) {

    if ($_GET['entregadores_id'] == "") {

        $entregaId = 'false';
    } else {
        $entregaId = $_GET['entregadores_id'];
    }
}

if (isset($_GET['status'])) {

    $status .= '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
   VOCÊ PRECISA FAZER A ROTERIZAÇÃO PRIMEIRO.
</div>';
} else {
    $status .= '';
}

if (isset($_GET['status27'])) {

    $status .= '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-ban"></i> Alerta!</h5>        
   ATENÇÃO: VOCÊ PRECISA ADICIONAR UM ENTREGADOR PARA ESSE REGISTRO.....
</div>';
} else {
    $status .= '';
}


if (isset($_GET['status2'])) {

    $status .= '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
    <h5> ESTE ENTREGADOR NÃO FAZ PARTE DESSE REMESSA ... VA EM PRODUÇÃO E VEREFIQUE O ENTREGADOR CÓDIGO:&nbsp; <span style="color:#000;font-weight:bold"> ' . $_GET['id_param'] . '</span></h5> 
</div>';
} else {
    $status .= '';
}

if (isset($_GET['status3'])) {

    $status .= '<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
    <h5>VOCÊ PRECISA SELECIONAR UM STATUS !</h5> 
</div>';
} else {
    $status .= '';
}
if (isset($_GET['status4'])) {

    $status .= '<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-ban"></i> Alerta!</h5>
    <h5>VOCÊ PRECISA SELECIONAR UM ENTREGADOR !!!!</h5> 
</div>';
} else {
    $status .= '';
}

$resultados = '';
$cores = '';
$contador  = 0;

foreach ($listar as $item) {

    $id_item = $item->id;
    $id_rec = $item->receber_id;

    $contador += 1;

    if ($item->obs == "") {

        $texto = "Nenhuma ....";
    } else {
        $texto = $item->obs;
    }


    if ($item->status == 1) {

        $cores = '<span class="badge badge-pill badge-success"><i class="fas fa-check"></i> &nbsp; ENTREGUE</span>';
    } else if ($item->status == 3) {

        $cores = '<span class="badge badge-pill badge-warning"><i class="fas fa-check"></i> &nbsp; AGUARDANDO</span>';
    } else if ($item->status == 4) {

        $cores = '<span class="badge badge-pill badge-info"><i class="fas fa-check"></i> &nbsp; EM ROTA</span>';
    } else {

        $cores = '<span class="badge badge-pill badge-danger"><i class="fas fa-check"></i> &nbsp; DEVOLVIDO</span>';
    }

    if ($item->status == 1) {
        $block = "disabled";
    } else {
        $block = "";
    }

    $resultados .= '<tr>
                      
                     
   <td style="font-size:18px">
   <span class="badge badge-pill badge-secondary">' . $contador . '</span>
   </td>

   <td style="font-size:18px;width:100px">
   <strong><a href="#" onclick="Detalhe6(' . $item->id . ')" >' . $item->nota . '</a></strong>
   </td>

   <td style="text-transform:uppercase;font-size:18px"> 
   <span class="badge badge-pill badge-dark"><i class="fa fa-barcode" aria-hidden="true"></i> &nbsp;' . $item->codigo . '</span>
   </td>


   <td style="text-transform:uppercase;font-size:13px">
   <strong><span>'.$item->nome.'</span></strong></br><strong>CPF:&nbsp;'.$item->cpf.'</strong>
   </td>

   <td>
   <a style="color:#ff0000" href="#" onclick="Detalhe8(' . $item->id . ')" >
   <strong>'.$item->logradouro.'&nbsp; Nº &nbsp; '.$item->numero.'</br>'.$item->bairro.' | '.$item->municipio.' - '.$item->uf.'
   <span style="color:#000">| CEP:'.$item->cep.'</span>
   </strong>
   </a>
   </td>
   <td>
   <strong>Email:</strong> &nbsp;
   </td>
   
   <td style="text-transform:uppercase;font-size:18px">
   <span class="badge badge-pill badge-secondary">
   <i class="fas fa-check"></i> &nbsp;' . $item->apelido  . '</span> 
   </td>
   
   <td><strong>
   <a href="#" onclick="Detalhe7(' . $item->id . ')" >
   ' . $item->ocorrencia . '</a></strong>
   </td>
 
   <td style="text-align:center; text-transform:uppercase;font-size:18px;text-align:left">
   ' . $cores . '
   </td>

   <td style="width:180px">
                      
   <button title="ALT + A" accesskey="a" class="btn btn-secondary btn-sm" onclick="Editar(' . $item->id . ')"> <i class="fa fa-retweet"></i> &nbsp; Atualizar</button>
  
   &nbsp;
   
   <a href="boleto-delete.php?id=' . $item->id . '&entregadores_id=' . $item->entregadores_id . '">
      <button type="button" class="btn btn-danger" ' . $block . '> <i class="fas fa-trash"></i></button>
   </a>
   </td>
   
   </tr>

   ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="10" class="text-center" > Nenhum bolelto encontrado !!!!! </td>
                                                     </tr>';

?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <?= $status ?>

                <div class="card back-black">
                    <div class="card-header">
                        <a href="<?= $flag != 1 ? '../lotes/lote-list.php' : '../receber/receber-list.php'  ?>">

                            <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                                <i class="fas fa-arrow-left"></i> &nbsp; <span style="font-size:24px;font-weight:600">VOLTAR</span></button>
                        </a>
                        <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#modal-default">
                            <i class="fas fa-envelope"></i> &nbsp; Tota de boletos: <span style="font-size:24px;font-weight:600"><?= $contador  ?></span></button>



                        <button accesskey="r" title="ALT+R" style="margin-left: 10px;" type="submit" class="btn btn-secondary float-right" data-toggle="modal" data-target="#modal-data"> <i class="fas fa-print"></i> &nbsp; IMPRIMIR RELATÓRIOS</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example" class="table table-light table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Nº NOTA</th>
                                    <th>CHAVE</th>
                                    <th>CONSULTOR </th>
                                    <th>ENDEREÇO</th>
                                    <th>CONTATO</th>
                                    <th>ENTREGADOR</th>
                                    <th>OCORRÊNCIA</th>
                                    <th style="text-align:center;">STATUS</th>
                                    <th style="text-align:center;">AÇÕES</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?= $resultados ?>

                        </table>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<form action="./boleto-edit.php" method="GET">
    <input type="hidden" value="<?= $entregaId ?>" name="existe">
    <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-lg">

            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title">Controle de Envio
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <span class="edit-modal"></span>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button accesskey="q" title="ALT+Q" type="submit" class="btn btn-primary">Baixar
                    </button>
                </div>
            </div>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>


<div class="modal fade" id="modal-data">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <form id="form-04" action="./boleto-gerar.php" method="GET" enctype="multipart/form-data">
                <input type="hidden" value="<?= $id_rec  ?>" name="item_id">
                <input type="hidden" value="<?= $id_entregador ?>" name="id_entregador">
                <input type="hidden" value="<?= $entregaId ?>" name="existe_entregador">
                <div class="modal-header">
                    <h4 class="modal-title">Relatório
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">

                    <div class="form-group">

                        <div class="row">

                            <div class="col-12">
                                <div class="form-group">
                                    <label>Entregadores</label>
                                    <select class="form-control select" style="width: 100%;" name="entregadores_id">
                                        <option value=""> Selecione um entregador </option>
                                        <?php

                                        foreach ($entregadores as $item) {
                                            $cont += 1;
                                            echo '<option value="' . $item->id . '">' . $cont . ' - ' . $item->apelido . '</option>';
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-3">
                                <div class="form-group">
                                    <label>Destinatário</label>
                                    <input class="form-control" type="text" value="" name="destinatario">
                                </div>
                            </div>
                            <div class="col-lg-3 col-3">
                                <div class="form-group">
                                    <label>Endereço</label>
                                    <input class="form-control" type="text" value="" name="endereco">
                                </div>
                            </div>
                            <div class="col-lg-3 col-3">
                                <div class="form-group">
                                    <label>Bairro</label>
                                    <input class="form-control" type="text" value="" name="bairro">
                                </div>
                            </div>
                            <div class="col-lg-3 col-3">
                                <div class="form-group">
                                    <label>Cidade</label>
                                    <input class="form-control" type="text" value="" name="cidade">
                                </div>
                            </div>
                            <div class="col-4">

                                <div class="form-group">
                                    <label>Status</label>

                                    <div class="form-group clearfix">
                                        <div class="icheck-success d-inline">
                                            <input type="radio" id="radioPrimary1" name="status" value="1">
                                            <label for="radioPrimary1">
                                                Entregue
                                            </label>
                                        </div>

                                        <div class="icheck-info d-inline">
                                            <input type="radio" id="radioPrimary2" name="status" value="2">
                                            <label for="radioPrimary2">
                                                Devolvido
                                            </label>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="col-8">

                                <div class="form-group">
                                    <label style="color:#fff">Status</label>

                                    <div class="form-group clearfix">
                                        <div class="icheck-warning d-inline">
                                            <input type="radio" id="radioPrimary3" name="status" value="3">
                                            <label for="radioPrimary3">Aguardando
                                            </label>
                                        </div>
                                        <div class="icheck-danger d-inline">
                                            <input type="radio" id="radioPrimary4" name="status" value="4">
                                            <label for="radioPrimary4">Entrega / Devolução
                                            </label>
                                        </div>
                                    </div>

                                </div>

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
    </div>
</div>

<div class="modal fade" id="editModal2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">Informações Detalhadas
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <span class="edit2-modal"></span>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" disabled>Fechar</button>
                <button name="importar" type="submit" class="btn btn-primary" disabled>Salvar
                </button>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="editModal45">
    <div class="modal-dialog modal-lg">

        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">Histórico de Envio
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <span class="edit3-modal"></span>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" data-dismiss="modal">Salvar</button>
                </button>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<form action="./boleto-endereco.php" method="GET">
    <div class="modal fade" id="editModal46">
        <div class="modal-dialog modal-lg">

            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title">Atualizar Endereço
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <span class="edit4-modal"></span>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button name="editar" type="submit" class="btn btn-primary">Salvar </button>
                </div>
            </div>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>