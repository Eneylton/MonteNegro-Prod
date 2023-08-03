<?php


$resultados = '';
$status = '';
$cores  = '';

foreach ($listar as $item) {

    switch ($item->status) {
        case '1':
            $status = 'AGUARDANDO';
            $cores = 'badge-warning';
            break;

        case '2':
            $status = 'EM ROTA';
            $cores = 'badge-info';
            break;
        case '3':
            $status = 'ENTREGUE';
            $cores = 'badge-success';
            break;

        default:
            $status = 'DEVOLVIDO';
            $cores = 'badge-danger';
            break;
    }

    $resultados .= '<tr>
                    
                      <td><h4><span class="badge badge-pill badge-danger">' . date('d/m/Y  Á\S  H:i:s', strtotime($item->data)) . '</span><h4></td>
                      <td>' . $item->notafiscal . ' - ' . $item->serie . '</td>
                      <td>' . $item->chave . '</td>
                      <td style="text-transform:uppercase">' . $item->razaosocial . '</td>
                      <td style="text-transform:uppercase">' . $item->consultora . '</td>
                      <td>' . $item->ocorrencia . '</td>
                  
                      <td style="text-transform:uppercase"><h4><span class="badge badge-pill ' . $cores . '">' . $status . '</span><h4></td>
                    
                      <td style="text-align: center; width:400px">
                        
                      
                      <button type="submit" class="btn btn-success " title="ROTERIZAR" onclick="Detalhe(' . $item->id . ')"><i class="fa fa-motorcycle" aria-hidden="true"></i></button>
                      &nbsp;
                      <button type="submit" class="btn btn-info " onclick="Detalhe3(' . $item->id . ')"> CONTATO</button>
                      &nbsp;
                      <button type="submit" class="btn btn-danger " >TRATATIVA</button>
                      &nbsp;
                      <button type="submit" class="btn btn-info " onclick="Detalhe2(' . $item->id . ')"> DETALHES</button>

                      </td>
                      </tr>

                      ';
}




?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card">

                    <div class="table-responsive">

                        <table id="example" class="table table-bordered table-bordered table-hover table-striped">
                            <thead>

                                <tr>

                                    <th> DATA EXPEDIÇÂO</th>
                                    <th> Nº DA NOTA FÍSCAL</th>
                                    <th> CHAVE</th>
                                    <th> CLIENTE</th>
                                    <th> CONSULTOR(A)</th>
                                    <th> OCORRÊNCIAS</th>
                                    <th> STATUS</th>
                                    <th style="text-align: center; width:200px"> AÇÃO </th>
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

<!-- EDITAR -->

<form id="form" action="./controlenvio-insert.php" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="editModal88">
        <div class="modal-dialog modal-lg">

            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h4 class="modal-title">Controle de Envie
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
                    <button name="importar" type="submit" class="btn btn-primary">Salvar
                    </button>
                </div>
            </div>

            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</form>

<div class="modal fade" id="editModal2">
    <div class="modal-dialog modal-lg">

        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">Detalhes
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <span class="edit-modal"></span>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                <button name="importar" type="submit" class="btn btn-primary">Salvar
                </button>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="editModal3">
    <div class="modal-dialog modal-lg">

        <div class="modal-content bg-light">
            <div class="modal-header">
                <h4 class="modal-title">Contato do Destinatário
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <span class="edit-modal1"></span>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                <button name="importar" type="submit" class="btn btn-primary">Salvar
                </button>
            </div>
        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>